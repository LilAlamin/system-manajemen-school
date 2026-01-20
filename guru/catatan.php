<div class="p-4 sm:ml-64">
    <div class="max-w-6xl mx-auto mt-10">
        <!-- Header & Action Button -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center self-start md:self-auto">
                <i class="fas fa-sticky-note text-blue-600 mr-2"></i> Data Catatan Siswa
            </h1>
            <a href="index.php?tambah_catatan" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 shadow-md transition flex items-center self-stretch md:self-auto justify-center">
                <i class="fas fa-plus mr-2"></i> Tambah Catatan
            </a>
        </div>

        <?php
        // Pagination Parameters
        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        // Filter Parameters
        $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '';
        $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
        $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';

        // Build Query Conditions
        $where_clauses = ["1=1"]; 
        
        if (!empty($class_id)) {
            $where_clauses[] = "c.c_id_kelas = '$class_id'";
        }
        if (!empty($start_date) && !empty($end_date)) {
            $where_clauses[] = "DATE(c.created_at) BETWEEN '$start_date' AND '$end_date'";
        }
        $where_sql = implode(' AND ', $where_clauses);

        // -- Query 1: Count Total rows --
        $count_sql = "SELECT COUNT(*) as total 
                      FROM `catatan_siswa` c
                      JOIN `kelas` k ON c.c_id_kelas = k.id_kelas
                      JOIN `siswa` s ON c.c_id_siswa = s.id_siswa
                      WHERE $where_sql";
        $count_result = $conn->query($count_sql);
        $total_rows = ($count_result && $count_result->num_rows > 0) ? $count_result->fetch_assoc()['total'] : 0;
        $total_pages = ceil($total_rows / $limit);

        // -- Query 2: Fetch Data --
        $feedback_sql = "SELECT c.*, k.nama_kelas, s.nama_siswa 
                         FROM `catatan_siswa` c
                         JOIN `kelas` k ON c.c_id_kelas = k.id_kelas
                         JOIN `siswa` s ON c.c_id_siswa = s.id_siswa
                         WHERE $where_sql
                         ORDER BY c.created_at DESC
                         LIMIT $limit OFFSET $offset";
        $feedback_result = $conn->query($feedback_sql);
        ?>

        <!-- Filter Form -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6 border border-gray-100">
            <form method="get" action="index.php" class="space-y-4 md:space-y-0 md:flex md:space-x-4 items-end">
                <input type="hidden" name="catatan" value="">
                
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
                    <a href="index.php?catatan" class="text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden flex flex-col min-h-[400px]">
            <div class="overflow-x-auto flex-grow">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-3 w-10">No</th>
                            <th scope="col" class="px-6 py-3">Kelas</th>
                            <th scope="col" class="px-6 py-3">Siswa</th>
                            <th scope="col" class="px-6 py-3 w-1/3">Catatan</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                        if ($feedback_result && $feedback_result->num_rows > 0) {
                            $display_no = $offset + 1;
                            while ($row = $feedback_result->fetch_assoc()) {
                                $status_badge = '';
                                // Note: DB enum values are 'Positif' and 'Negatif'
                                if ($row['status'] == 'Positif') {
                                    $status_badge = '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-400">Positif</span>';
                                } elseif ($row['status'] == 'Negatif') {
                                    $status_badge = '<span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded border border-red-400">Negatif</span>';
                                } else {
                                    $status_badge = '<span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded border border-gray-400">'.htmlspecialchars($row['status']).'</span>';
                                }
                        ?>
                            <tr class="bg-white hover:bg-gray-50 transition border-b">
                                <td class="px-6 py-4 font-medium"><?= $display_no++ ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($row['nama_kelas']) ?></td>
                                <td class="px-6 py-4 font-semibold text-gray-800"><?= htmlspecialchars($row['nama_siswa']) ?></td>
                                <td class="px-6 py-4 text-gray-600 italic">"<?= htmlspecialchars($row['catatan']) ?>"</td>
                                <td class="px-6 py-4"><?= $status_badge ?></td>
                                <td class="px-6 py-4 text-xs text-gray-500">
                                    <?= date('d M Y, H:i', strtotime($row['created_at'])) ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="index.php?edit_catatan_id=<?= $row['id_catatan'] ?>" class="text-yellow-400 hover:text-yellow-600 transition" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="index.php?hapus_catatan_id=<?= $row['id_catatan'] ?>" class="text-red-500 hover:text-red-700 transition delete-btn-catatan" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php 
                            }
                        } else {
                            echo '<tr><td colspan="7" class="px-6 py-8 text-center text-gray-500 italic">Belum ada catatan siswa.</td></tr>';
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
// Handle Delete
if (isset($_GET['hapus_catatan_id'])) {
    $id = $_GET['hapus_catatan_id'];
    $del = "DELETE FROM `catatan_siswa` WHERE id_catatan = '$id'";
    if($conn->query($del)){
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Catatan berhasil dihapus.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = 'index.php?catatan';
            });
        </script>";
    } else {
         echo "<script>Swal.fire('Gagal!', 'Gagal menghapus data.', 'error');</script>";
    }
}
?>

<script>
    $('.delete-btn-catatan').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        Swal.fire({
            title: 'Hapus Catatan?',
            text: "Data catatan ini akan dihapus permanen!",
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