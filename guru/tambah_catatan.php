<div class="p-4 sm:ml-64">
    <div class="max-w-4xl mx-auto mt-10">
        <!-- Header -->
         <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-plus-circle text-blue-600 mr-2"></i> Tambah Catatan Siswa
            </h1>
            <nav class="flex mt-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="index.php?catatan" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            Catatan
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

        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-100">
            <h2 class="text-lg font-semibold text-gray-700 mb-4 border-b pb-2">Form Catatan Perilaku</h2>
            <form method="post" action="">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Kelas</label>
                         <select name="class_id" id="class_selector" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            <option value="" disabled selected>Pilih Kelas</option>
                            <?php
                            $class_sql = "SELECT * FROM `kelas` ORDER BY nama_kelas ASC";
                            $class_res = $conn->query($class_sql);
                            while($k = $class_res->fetch_assoc()){
                                echo "<option value='{$k['id_kelas']}'>{$k['nama_kelas']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Siswa</label>
                         <select name="student_id" id="student_selector" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required disabled>
                            <option value="" selected>Pilih Kelas Terlebih Dahulu</option>
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Jenis Catatan</label>
                    <div class="flex gap-4">
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-green-50 w-full sm:w-auto">
                            <input type="radio" name="status" value="Positif" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500" required>
                            <span class="ml-2 text-sm font-medium text-gray-900 flex items-center">
                                <i class="fas fa-thumbs-up text-green-500 mr-2"></i> Positif (Prestasi/Kebaikan)
                            </span>
                        </label>
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-red-50 w-full sm:w-auto">
                            <input type="radio" name="status" value="Negatif" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500" required>
                            <span class="ml-2 text-sm font-medium text-gray-900 flex items-center">
                                <i class="fas fa-thumbs-down text-red-500 mr-2"></i> Negatif (Pelanggaran/Masalah)
                            </span>
                        </label>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Isi Catatan / Keterangan</label>
                    <textarea name="feedback" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Tuliskan detail perilaku atau prestasi siswa..." required></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" name="create_feedback" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center shadow-md">
                        <i class="fas fa-save mr-2"></i> Simpan Catatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if (isset($_POST['create_feedback'])) {
    $class_id = $_POST['class_id'];
    $student_id = $_POST['student_id'];
    $feedback = $_POST['feedback'];
    $status = $_POST['status'];
    $teacher_id = $_SESSION['teacher_id'];

    $sql = "INSERT INTO `catatan_siswa` (`c_id_kelas`, `c_id_guru`, `c_id_siswa`, `catatan`, `status`, `created_at`) 
            VALUES ('$class_id', '$teacher_id', '$student_id', '$feedback', '$status', NOW())";

    if ($conn->query($sql)) {
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Catatan siswa berhasil ditambahkan.',
                icon: 'success'
            }).then(() => {
                window.location.href = 'index.php?catatan';
            });
        </script>";
    } else {
         echo "<script>Swal.fire('Gagal!', 'Terjadi kesalahan saat menyimpan.', 'error');</script>";
    }
}
?>

<script>
    // Simple AJAX to fetch students when class changes (Reuse logic or simplified inline)
    // Assuming you have 'get_students_by_class.php' or similar that takes class_id and returns JSON
    document.getElementById('class_selector').addEventListener('change', function() {
        const classId = this.value;
        const studentSelect = document.getElementById('student_selector');
        
        studentSelect.disabled = true;
        studentSelect.innerHTML = '<option>Loading...</option>';

        // Use fetch API or jQuery. Let's use jQuery as it's likely loaded
        $.ajax({
            url: 'get_students_by_class.php',
            method: 'POST',
            data: { class_id: classId },
            dataType: 'json',
            success: function(response) {
                studentSelect.innerHTML = '<option value="" selected disabled>Pilih Siswa</option>';
                if (response.students && response.students.length > 0) {
                    response.students.forEach(student => {
                        const option = document.createElement('option');
                        option.value = student.student_id; // Check if API returns 'student_id' or 'id_siswa'
                        option.textContent = student.student_name;
                        studentSelect.appendChild(option);
                    });
                    studentSelect.disabled = false;
                } else {
                     studentSelect.innerHTML = '<option value="">Tidak ada siswa</option>';
                }
            },
            error: function() {
                studentSelect.innerHTML = '<option value="">Gagal memuat siswa</option>';
            }
        });
    });
</script>
