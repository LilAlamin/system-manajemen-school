<div class="p-4 sm:ml-64">
    <div class="max-w-6xl mx-auto mt-10">
        <!-- Header -->
         <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-plus-circle text-blue-600 mr-2"></i> Tambah Nilai Siswa
            </h1>
            <nav class="flex mt-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="index.php?nilai" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            Data Nilai
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Tambah</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <?php
        // Step 1 Data (Defaults or carry over)
        $nama_nilai = isset($_POST['nama_nilai']) ? $_POST['nama_nilai'] : '';
        $tipe_nilai = isset($_POST['tipe_nilai']) ? $_POST['tipe_nilai'] : '';
        $mapel_id   = isset($_POST['mapel_id']) ? $_POST['mapel_id'] : '';
        $class_id   = isset($_POST['class_id']) ? $_POST['class_id'] : '';
        $total_max  = isset($_POST['total_max']) ? $_POST['total_max'] : 100;
        $date       = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d');
        ?>

        <!-- Step 1: Configuration -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6 border border-gray-100">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Langkah 1: Konfigurasi Ujian/Tugas</h2>
            <form method="post" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Row 1 -->
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Nama Penilaian</label>
                        <input type="text" name="nama_nilai" placeholder="Contoh: Ulangan Harian 1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= htmlspecialchars($nama_nilai) ?>" required>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Tipe Nilai</label>
                        <select name="tipe_nilai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            <option value="" disabled <?= empty($tipe_nilai) ? 'selected' : '' ?>>Pilih Tipe</option>
                            <option value="Ulangan" <?= $tipe_nilai == 'Ulangan' ? 'selected' : '' ?>>Ulangan</option>
                            <option value="Tugas" <?= $tipe_nilai == 'Tugas' ? 'selected' : '' ?>>Tugas</option>
                            <option value="MID" <?= $tipe_nilai == 'MID' ? 'selected' : '' ?>>MID Semester</option>
                            <option value="UAS" <?= $tipe_nilai == 'UAS' ? 'selected' : '' ?>>UAS</option>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                        <input type="date" name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= $date ?>" required>
                    </div>

                    <!-- Row 2 -->
                    <div>
                         <label class="block mb-2 text-sm font-medium text-gray-900">Mata Pelajaran</label>
                         <select name="mapel_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            <option value="" disabled <?= empty($mapel_id) ? 'selected' : '' ?>>Pilih Mapel</option>
                            <?php
                            $mapel_sql = "SELECT * FROM `mapel` ORDER BY nama_mapel ASC";
                            $mapel_res = $conn->query($mapel_sql);
                            while($m = $mapel_res->fetch_assoc()){
                                $sel = ($mapel_id == $m['id_mapel']) ? 'selected' : '';
                                echo "<option value='{$m['id_mapel']}' $sel>{$m['nama_mapel']} ({$m['kode_mapel']})</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Kelas</label>
                         <select name="class_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            <option value="" disabled <?= empty($class_id) ? 'selected' : '' ?>>Pilih Kelas</option>
                            <?php
                            $class_sql = "SELECT * FROM `kelas` ORDER BY nama_kelas ASC";
                            $class_res = $conn->query($class_sql);
                            while($k = $class_res->fetch_assoc()){
                                $sel = ($class_id == $k['id_kelas']) ? 'selected' : '';
                                echo "<option value='{$k['id_kelas']}' $sel>{$k['nama_kelas']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Nilai Maksimal (Skor Absolut)</label>
                        <input type="number" name="total_max" min="1" max="1000" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= $total_max ?>" required>
                    </div>
                </div>
                
                <div class="flex justify-end mt-4">
                    <button type="submit" name="show_student" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                        Lanjut ke Input Nilai <i class="fas fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Step 2: Student List & Input -->
        <?php
        if (isset($_POST['show_student']) && !empty($class_id)) {
            $student_sql = "SELECT * FROM `siswa` WHERE kelas_siswa = '$class_id' ORDER BY nama_siswa ASC";
            $student_result = $conn->query($student_sql);
            
            if ($student_result->num_rows > 0) {
        ?>
            <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden mb-10">
                <div class="p-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                     <h2 class="text-lg font-semibold text-gray-700">Langkah 2: Input Nilai Siswa</h2>
                     <span class="text-sm text-gray-500">Nilai Maks: <b><?= $total_max ?></b></span>
                </div>
                
                <form method="post" action="">
                    <!-- Hidden Config -->
                    <input type="hidden" name="final_nama" value="<?= htmlspecialchars($nama_nilai) ?>">
                    <input type="hidden" name="final_tipe" value="<?= $tipe_nilai ?>">
                    <input type="hidden" name="final_mapel" value="<?= $mapel_id ?>">
                    <input type="hidden" name="final_class" value="<?= $class_id ?>">
                    <input type="hidden" name="final_max" value="<?= $total_max ?>">
                    <input type="hidden" name="final_date" value="<?= $date ?>">

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 w-12 text-center">No</th>
                                    <th scope="col" class="px-6 py-3">Nama Siswa</th>
                                    <th scope="col" class="px-6 py-3 w-48 text-center">Nilai Perolehan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($student = $student_result->fetch_assoc()) {
                                    $sid = $student['id_siswa'];
                                ?>
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 text-center"><?= $no++ ?></td>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        <?= htmlspecialchars($student['nama_siswa']) ?>
                                        <div class="text-xs text-gray-400"><?= $student['id_sims'] ?></div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                         <input type="number" name="scores[<?= $sid ?>]" min="0" max="<?= $total_max ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 text-center font-bold" placeholder="0" required>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end">
                         <button type="submit" name="save_grades" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-lg px-8 py-3 text-center shadow-lg transition transform hover:-translate-y-1">
                            <i class="fas fa-save mr-2"></i> Simpan Data Nilai
                        </button>
                    </div>
                </form>
            </div>
        <?php
            } else {
                 echo '<div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50">Tidak ada siswa di kelas ini.</div>';
            }
        }
        ?>
    </div>
</div>

<?php
if (isset($_POST['save_grades'])) {
    $nama = $_POST['final_nama'];
    $tipe = $_POST['final_tipe'];
    $mapel = $_POST['final_mapel'];
    $kelas = $_POST['final_class'];
    $max = $_POST['final_max'];
    $date = $_POST['final_date'];
    $scores = $_POST['scores'];
    $teacher_id = $_SESSION['teacher_id']; // Ensure session is active

    if (!empty($scores)) {
        $count = 0;
        foreach ($scores as $s_id => $score) {
             // Basic validation
             if($score > $max) $score = $max; // cap at max
             if($score < 0) $score = 0;

             $sql = "INSERT INTO `nilai` 
                    (`nama_nilai`, `tipe_nilai`, `total_nilai`, `capaian_nilai`, `n_id_kelas`, `n_id_siswa`, `n_id_guru`, `n_id_mapel`, `nilai_date`) 
                    VALUES 
                    ('$nama', '$tipe', '$max', '$score', '$kelas', '$s_id', '$teacher_id', '$mapel', '$date')";
             
             if($conn->query($sql)){
                 $count++;
             }
        }

        if ($count > 0) {
            echo "<script>
                Swal.fire({
                    title: 'Berhasil!',
                    text: '$count data nilai siswa berhasil disimpan.',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'index.php?nilai';
                });
            </script>";
        } else {
             echo "<script>Swal.fire('Gagal!', 'Gagal menyimpan data.', 'error');</script>";
        }
    }
}
?>