<div class="p-4 sm:ml-64">
    <div class="max-w-6xl mx-auto mt-10">
        <!-- Header & Action Button -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center self-start md:self-auto">
                <i class="fas fa-graduation-cap text-blue-600 mr-2"></i> Data Nilai Siswa
            </h1>
            <a href="index.php?tambah_nilai" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 shadow-md transition flex items-center self-stretch md:self-auto justify-center">
                <i class="fas fa-plus mr-2"></i> Tambah Nilai
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
            $where_clauses[] = "n.n_id_kelas = '$class_id'";
        }
        if (!empty($start_date) && !empty($end_date)) {
            $where_clauses[] = "n.nilai_date BETWEEN '$start_date' AND '$end_date'";
        }
        $where_sql = implode(' AND ', $where_clauses);

        // -- Query 1: Count Total rows --
        $count_sql = "SELECT COUNT(*) as total 
                      FROM `nilai` n
                      JOIN `kelas` k ON n.n_id_kelas = k.id_kelas
                      JOIN `siswa` s ON n.n_id_siswa = s.id_siswa
                      JOIN `mapel` m ON n.n_id_mapel = m.id_mapel
                      WHERE $where_sql";
        $count_result = $conn->query($count_sql);
        $total_rows = $count_result->fetch_assoc()['total'];
        $total_pages = ceil($total_rows / $limit);

        // -- Query 2: Fetch Data --
        $nilai_sql = "SELECT n.*, k.nama_kelas, s.nama_siswa, m.nama_mapel 
                      FROM `nilai` n
                      JOIN `kelas` k ON n.n_id_kelas = k.id_kelas
                      JOIN `siswa` s ON n.n_id_siswa = s.id_siswa
                      JOIN `mapel` m ON n.n_id_mapel = m.id_mapel
                      WHERE $where_sql
                      ORDER BY n.nilai_date DESC, n.id_nilai DESC
                      LIMIT $limit OFFSET $offset";
        $nilai_result = $conn->query($nilai_sql);
        ?>

        <!-- Filter Form -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6 border border-gray-100">
            <form method="get" action="index.php" class="space-y-4 md:space-y-0 md:flex md:space-x-4 items-end">
                <input type="hidden" name="nilai" value="">
                
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
                    <a href="index.php?nilai" class="text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden flex flex-col min-h-[400px]">
            <div class="overflow-x-auto flex-grow">
                <table class="w-full text-sm text-center text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Kelas</th>
                            <th scope="col" class="px-6 py-3">Siswa</th>
                            <th scope="col" class="px-6 py-3">Mata Pelajaran</th>
                            <th scope="col" class="px-6 py-3">Jenis Ujian</th>
                            <th scope="col" class="px-6 py-3">Nilai</th>
                            <th scope="col" class="px-6 py-3">Tanggal</th>
                            <th scope="col" class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                        if ($nilai_result && $nilai_result->num_rows > 0) {
                            $display_no = $offset + 1;
                            while ($row = $nilai_result->fetch_assoc()) {
                                // Determine styling for score
                                $score_class = 'font-bold text-gray-700';
                                if($row['capaian_nilai'] < 60) $score_class = 'font-bold text-red-600';
                                elseif($row['capaian_nilai'] >= 85) $score_class = 'font-bold text-green-600';
                        ?>
                            <tr class="bg-white hover:bg-gray-50 transition border-b">
                                <td class="px-6 py-4 font-medium"><?= $display_no++ ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($row['nama_kelas']) ?></td>
                                <td class="px-6 py-4 text-left font-semibold text-gray-800"><?= htmlspecialchars($row['nama_siswa']) ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($row['nama_mapel']) ?></td>
                                <td class="px-6 py-4">
                                     <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-blue-400">
                                         <?= htmlspecialchars($row['tipe_nilai']) ?>
                                     </span>
                                </td>
                                <td class="px-6 py-4 <?= $score_class ?> text-base">
                                    <?= htmlspecialchars($row['capaian_nilai']) ?> <span class="text-xs text-gray-400 font-normal">/ <?= $row['total_nilai'] ?></span>
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-500">
                                    <?= date('d M Y', strtotime($row['nilai_date'])) ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center space-x-2">
                                        <a href="index.php?edit_nilai_id=<?= $row['id_nilai'] ?>" class="text-yellow-400 hover:text-yellow-600 transition" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="index.php?hapus_nilai_id=<?= $row['id_nilai'] ?>" class="text-red-500 hover:text-red-700 transition delete-btn-nilai" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php 
                            }
                        } else {
                            echo '<tr><td colspan="8" class="px-6 py-8 text-center text-gray-500 italic">Belum ada data nilai yang diinput.</td></tr>';
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
if (isset($_GET['hapus_nilai_id'])) {
    $delete_id = $_GET['hapus_nilai_id'];
    $del_sql = "DELETE FROM `nilai` WHERE id_nilai = '$delete_id'";
    if ($conn->query($del_sql)) {
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data nilai berhasil dihapus.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = 'index.php?nilai';
            });
        </script>";
    } else {
         echo "<script>
            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
        </script>";
    }
}
?>

<script>
    $('.delete-btn-nilai').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        Swal.fire({
            title: 'Hapus Nilai?',
            text: "Data nilai akan dihapus permanen!",
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