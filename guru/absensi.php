<div class="p-4 sm:ml-64">
    <div class="max-w-6xl mx-auto mt-10">
        <!-- Header & Action Button -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center self-start md:self-auto">
                <i class="fas fa-calendar-check text-blue-600 mr-2"></i> Rekap Absensi Siswa
            </h1>
            <a href="index.php?tambah_absensi" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 shadow-md transition flex items-center self-stretch md:self-auto justify-center">
                <i class="fas fa-plus mr-2"></i> Tambah Absensi
            </a>
        </div>

        <?php
        // Pagination Parameters
        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        // Filter Parameters
        $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
        $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
        $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '';

        // Build Query Conditions
        $where_clauses = ["1=1"]; // Default true
        if (!empty($class_id)) {
            $where_clauses[] = "a.a_id_kelas = '$class_id'";
        }
        if (!empty($start_date) && !empty($end_date)) {
            $where_clauses[] = "a.tanggal_absensi BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";
        }
        $where_sql = implode(' AND ', $where_clauses);

        // -- Query 1: Count Total rows --
        $count_sql = "SELECT COUNT(*) as total 
                      FROM `absensi` a 
                      JOIN `siswa` s ON a.a_id_siswa = s.id_siswa 
                      JOIN `kelas` k ON a.a_id_kelas = k.id_kelas
                      WHERE $where_sql";
        $count_result = $conn->query($count_sql);
        $total_rows = $count_result->fetch_assoc()['total'];
        $total_pages = ceil($total_rows / $limit);

        // -- Query 2: Fetch Data --
        $att_sql = "SELECT a.*, s.nama_siswa, k.nama_kelas 
                    FROM `absensi` a 
                    JOIN `siswa` s ON a.a_id_siswa = s.id_siswa 
                    JOIN `kelas` k ON a.a_id_kelas = k.id_kelas
                    WHERE $where_sql
                    ORDER BY a.tanggal_absensi DESC, s.nama_siswa ASC
                    LIMIT $limit OFFSET $offset";
        $att_result = $conn->query($att_sql);
        ?>

        <!-- Filter Form -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6 border border-gray-100">
            <form method="get" action="index.php" class="space-y-4 md:space-y-0 md:flex md:space-x-4 items-end">
                <input type="hidden" name="absensi" value="">
                
                <div class="w-full md:w-1/4">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= $start_date ?>">
                </div>
                <div class="w-full md:w-1/4">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= $end_date ?>">
                </div>
                <div class="w-full md:w-1/4">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Kelas</label>
                    <select name="class_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="" selected>Semua Kelas</option>
                        <?php
                        $class_sql_list = "SELECT * FROM `kelas` ORDER BY nama_kelas ASC";
                        $class_result_list = $conn->query($class_sql_list);
                        while ($class_row = $class_result_list->fetch_assoc()) {
                            $selected = ($class_id == $class_row['id_kelas']) ? 'selected' : '';
                            echo '<option value="' . $class_row['id_kelas'] . '" ' . $selected . '>' . $class_row['nama_kelas'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="w-full md:w-auto flex gap-2">
                    <button type="submit" class="text-white bg-gray-800 hover:bg-gray-900 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                        <i class="fas fa-filter mr-1"></i> Filter
                    </button>
                    <a href="index.php?absensi" class="text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100 flex flex-col min-h-[400px]">
            <div class="overflow-x-auto flex-grow">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Kelas</th>
                            <th scope="col" class="px-6 py-3">Nama Siswa</th>
                            <th scope="col" class="px-6 py-3">Tanggal</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($att_result && $att_result->num_rows > 0) {
                            $display_no = $offset + 1;
                            while ($row = $att_result->fetch_assoc()) {
                                $status_color = 'text-gray-500';
                                $status_bg = 'bg-gray-100';
                                switch ($row['status_absensi']) {
                                    case 'Hadir': $status_color = 'text-green-800'; $status_bg = 'bg-green-100'; break;
                                    case 'Izin': $status_color = 'text-yellow-800'; $status_bg = 'bg-yellow-100'; break;
                                    case 'Sakit': $status_color = 'text-blue-800'; $status_bg = 'bg-blue-100'; break;
                                    case 'Alpha': $status_color = 'text-red-800'; $status_bg = 'bg-red-100'; break;
                                }
                        ?>
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900"><?= $display_no++ ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($row['nama_kelas']) ?></td>
                                <td class="px-6 py-4 font-semibold"><?= htmlspecialchars($row['nama_siswa']) ?></td>
                                <td class="px-6 py-4"><?= date("d M Y H:i", strtotime($row['tanggal_absensi'])) ?></td>
                                <td class="px-6 py-4">
                                    <span class="<?= $status_bg ?> <?= $status_color ?> text-xs font-medium px-2.5 py-0.5 rounded border border-gray-200">
                                        <?= $row['status_absensi'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="index.php?edit_absensi_id=<?= $row['id_absensi'] ?>" class="font-medium text-yellow-500 hover:text-yellow-700 hover:underline mr-2" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="index.php?hapus_absensi_id=<?= $row['id_absensi'] ?>" class="font-medium text-red-600 hover:text-red-800 hover:underline delete-btn" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='6' class='px-6 py-8 text-center text-gray-500 italic'>Tidak ada data absensi ditemukan untuk kriteria ini.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
            <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4 bg-gray-50 border-t border-gray-200" aria-label="Table navigation">
                <span class="text-sm font-normal text-gray-500">
                    Menampilkan <span class="font-semibold text-gray-900"><?= $offset + 1 ?></span> - <span class="font-semibold text-gray-900"><?= min($offset + $limit, $total_rows) ?></span> dari <span class="font-semibold text-gray-900"><?= $total_rows ?></span>
                </span>
                <ul class="inline-flex items-stretch -space-x-px">
                     <!-- Params string for links -->
                    <?php 
                        $params = $_GET;
                        unset($params['page']);
                        $query_str = http_build_query($params);
                    ?>

                    <!-- Prev -->
                    <li>
                        <a href="index.php?<?= $query_str ?>&page=<?= max(1, $page-1) ?>" class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 <?= ($page <= 1) ? 'pointer-events-none opacity-50' : '' ?>">
                            <span class="sr-only">Previous</span>
                            <i class="fas fa-chevron-left text-xs"></i>
                        </a>
                    </li>
                    
                    <!-- Page Numbers (Simple: 1, 2, ... CUR, ... LAST) -->
                    <?php for ($i = 1; $i <= $total_pages; $i++): 
                         $active_class = ($page == $i) ? 'z-10 text-blue-600 bg-blue-50 border-blue-300 hover:bg-blue-100 hover:text-blue-700' : 'text-gray-500 bg-white border-gray-300 hover:bg-gray-100 hover:text-gray-700';
                    ?>
                        <li>
                            <a href="index.php?<?= $query_str ?>&page=<?= $i ?>" class="flex items-center justify-center text-sm py-2 px-3 leading-tight border <?= $active_class ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <!-- Next -->
                    <li>
                        <a href="index.php?<?= $query_str ?>&page=<?= min($total_pages, $page+1) ?>" class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-500 bg-white rounded-r-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 <?= ($page >= $total_pages) ? 'pointer-events-none opacity-50' : '' ?>">
                            <span class="sr-only">Next</span>
                            <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
// Handle Delete Logic (Keep this same)
if (isset($_GET['hapus_absensi_id'])) {
    $id = $_GET['hapus_absensi_id'];
    $del = "DELETE FROM `absensi` WHERE id_absensi = '$id'";
    if($conn->query($del)){
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data absensi dihapus.',
                icon: 'success'
            }).then(() => {
                window.location.href = 'index.php?absensi';
            });
        </script>";
    } else {
         echo "<script>Swal.fire('Gagal!', 'Gagal menghapus data.', 'error');</script>";
    }
}
?>

<script>
    $('.delete-btn').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        Swal.fire({
            title: 'Hapus Absensi?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
            }
        })
    });
</script>