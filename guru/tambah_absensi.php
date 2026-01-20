<div class="p-4 sm:ml-64">
    <div class="max-w-6xl mx-auto mt-10">
        <!-- Header -->
         <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-plus-circle text-green-600 mr-2"></i> Tambah Absensi
            </h1>
            <nav class="flex mt-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="index.php?absensi" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            Absensi
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
        $selected_class = isset($_POST['class_id']) ? $_POST['class_id'] : '';
        $selected_date = isset($_POST['date']) ? $_POST['date'] : date('Y-m-d\TH:i');
        ?>

        <!-- Step 1: Select Class & Date -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6 border border-gray-100">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Langkah 1: Pilih Kelas & Tanggal</h2>
            <form method="post" class="space-y-4 md:space-y-0 md:flex md:space-x-4 items-end">
                <div class="w-full md:w-1/3">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal & Waktu Absensi</label>
                    <input type="datetime-local" name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= $selected_date ?>" required>
                </div>
                <div class="w-full md:w-1/3">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Kelas</label>
                    <select name="class_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        <option value="" disabled <?= $selected_class == '' ? 'selected' : '' ?>>Pilih Kelas</option>
                        <?php
                        $class_sql = "SELECT * FROM `kelas` ORDER BY nama_kelas ASC";
                        $class_result = $conn->query($class_sql);
                        while ($row = $class_result->fetch_assoc()) {
                            $sel = ($selected_class == $row['id_kelas']) ? 'selected' : '';
                            echo '<option value="' . $row['id_kelas'] . '" ' . $sel . '>' . $row['nama_kelas'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="w-full md:w-auto">
                    <button type="submit" name="show_student" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                        Tampilkan Siswa <i class="fas fa-arrow-right ml-1"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Step 2: Student List -->
        <?php
        if (isset($_POST['show_student']) && !empty($selected_class)) {
            $student_sql = "SELECT * FROM `siswa` WHERE kelas_siswa = '$selected_class' ORDER BY nama_siswa ASC";
            $student_result = $conn->query($student_sql);
            
            if ($student_result->num_rows > 0) {
        ?>
            <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden mb-10">
                <div class="p-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                     <h2 class="text-lg font-semibold text-gray-700">Langkah 2: Isi Absensi</h2>
                     <span class="text-sm text-gray-500">Jumlah Siswa: <?= $student_result->num_rows ?></span>
                </div>
                
                <form method="post" action="">
                    <!-- Hidden inputs to carry over selection -->
                    <input type="hidden" name="final_class_id" value="<?= $selected_class ?>">
                    <input type="hidden" name="final_date" value="<?= $selected_date ?>">

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-center text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                <tr>
                                    <th scope="col" class="px-6 py-3 w-10">No</th>
                                    <th scope="col" class="px-6 py-3 text-left">Nama Siswa</th>
                                    <th scope="col" class="px-6 py-3">Status Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($student = $student_result->fetch_assoc()) {
                                    $sid = $student['id_siswa'];
                                ?>
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4"><?= $no++ ?></td>
                                    <td class="px-6 py-4 font-medium text-gray-900 text-left">
                                        <?= htmlspecialchars($student['nama_siswa']) ?>
                                        <div class="text-xs text-gray-500"><?= $student['id_sims'] ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center space-x-4">
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input type="radio" name="status[<?= $sid ?>]" value="Hadir" class="form-radio text-green-600 w-5 h-5" checked>
                                                <span class="ml-2">Hadir</span>
                                            </label>
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input type="radio" name="status[<?= $sid ?>]" value="Izin" class="form-radio text-yellow-500 w-5 h-5">
                                                <span class="ml-2">Izin</span>
                                            </label>

                                            <label class="inline-flex items-center cursor-pointer">
                                                <input type="radio" name="status[<?= $sid ?>]" value="Alpha" class="form-radio text-red-600 w-5 h-5">
                                                <span class="ml-2">Alpha</span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end">
                         <button type="submit" name="save_attendance" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-lg px-8 py-3 text-center shadow-lg transition transform hover:-translate-y-1">
                            <i class="fas fa-save mr-2"></i> Simpan Data Absensi
                        </button>
                    </div>
                </form>
            </div>
        <?php
            } else {
                echo '<div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50" role="alert">
                        <span class="font-medium">Perhatian!</span> Tidak ada data siswa ditemukan di kelas ini.
                      </div>';
            }
        }
        ?>
    </div>
</div>

<?php
// Process Save
if (isset($_POST['save_attendance'])) {
    $class_id = $_POST['final_class_id'];
    $class_id = $_POST['final_class_id'];
    $raw_date = $_POST['final_date'];
    $date = str_replace('T', ' ', $raw_date); // Convert ISO to MySQL format
    $statuses = $_POST['status']; // Array [student_id => status]
    $teacher_id = $_SESSION['teacher_id'];

    if (!empty($statuses)) {
        $success_count = 0;
        foreach ($statuses as $student_id => $status) {
            // Optional: Check if already exists for this date/student to prevent duplicates or update
            // For simplicity in this "Tambah" feature, we insert new. Or deleting existing for that day first could be smarter.
            // Let's first check existence.
            $check = $conn->query("SELECT id_absensi FROM absensi WHERE a_id_siswa='$student_id' AND tanggal_absensi='$date'");
            
            if($check->num_rows > 0) {
                 // Update existing code
                 $sql = "UPDATE absensi SET status_absensi='$status', a_id_guru='$teacher_id', a_id_kelas='$class_id' WHERE a_id_siswa='$student_id' AND tanggal_absensi='$date'";
            } else {
                 // Insert new
                 $sql = "INSERT INTO absensi (a_id_siswa, a_id_kelas, a_id_guru, tanggal_absensi, status_absensi) 
                         VALUES ('$student_id', '$class_id', '$teacher_id', '$date', '$status')";
            }

            if ($conn->query($sql)) {
                $success_count++;
            }
        }

        if ($success_count > 0) {
            echo "<script>
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data absensi berhasil disimpan ($success_count siswa).',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'index.php?absensi';
                });
            </script>";
        } else {
             echo "<script>Swal.fire('Gagal!', 'Terjadi kesalahan saat menyimpan data.', 'error');</script>";
        }
    }
}
?>