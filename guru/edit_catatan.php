<div class="p-4 sm:ml-64">
    <div class="max-w-4xl mx-auto mt-10">
        <!-- Header -->
         <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-edit text-yellow-500 mr-2"></i> Edit Catatan Siswa
            </h1>
        </div>

        <?php
        if (isset($_GET['edit_catatan_id'])) {
            $id = $_GET['edit_catatan_id'];
            $teacher_id = $_SESSION['teacher_id'];
            $sql = "SELECT * FROM `catatan_siswa` WHERE id_catatan = '$id' AND c_id_guru = '$teacher_id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
        ?>
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-100">
            <form method="post" action="">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Kelas</label>
                         <select name="class_id" id="class_selector" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            <?php
                            $class_res = $conn->query("SELECT * FROM `kelas` ORDER BY nama_kelas ASC");
                            while($k = $class_res->fetch_assoc()){
                                $sel = ($row['c_id_kelas'] == $k['id_kelas']) ? 'selected' : '';
                                echo "<option value='{$k['id_kelas']}' $sel>{$k['nama_kelas']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Siswa</label>
                         <select name="student_id" id="student_selector" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            <?php
                            $curr_class = $row['c_id_kelas'];
                            $sis_res = $conn->query("SELECT * FROM `siswa` WHERE kelas_siswa = '$curr_class' ORDER BY nama_siswa ASC");
                            while($s = $sis_res->fetch_assoc()){
                                $sel = ($row['c_id_siswa'] == $s['id_siswa']) ? 'selected' : '';
                                echo "<option value='{$s['id_siswa']}' $sel>{$s['nama_siswa']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Jenis Catatan</label>
                    <div class="flex gap-4">
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-green-50 w-full sm:w-auto">
                            <input type="radio" name="status" value="Positif" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500" <?= ($row['status'] == 'Positif') ? 'checked' : '' ?> required>
                            <span class="ml-2 text-sm font-medium text-gray-900 flex items-center">
                                <i class="fas fa-thumbs-up text-green-500 mr-2"></i> Positif
                            </span>
                        </label>
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-red-50 w-full sm:w-auto">
                            <input type="radio" name="status" value="Negatif" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500" <?= ($row['status'] == 'Negatif') ? 'checked' : '' ?> required>
                            <span class="ml-2 text-sm font-medium text-gray-900 flex items-center">
                                <i class="fas fa-thumbs-down text-red-500 mr-2"></i> Negatif
                            </span>
                        </label>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Isi Catatan / Keterangan</label>
                    <textarea name="feedback" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required><?= htmlspecialchars($row['catatan']) ?></textarea>
                </div>

                <div class="flex items-center justify-end space-x-2 border-t pt-6 mt-6">
                    <a href="index.php?catatan" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">Batal</a>
                    <button type="submit" name="update_feedback" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
        <?php
            } else {
                 echo "<div class='p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50'>Data tidak ditemukan.</div>";
            }
        }
        ?>
    </div>
</div>

<?php
if(isset($_POST['update_feedback'])) {
    $id = $_GET['edit_catatan_id'];
    $class = $_POST['class_id'];
    $student = $_POST['student_id'];
    $feedback = $_POST['feedback'];
    $status = $_POST['status'];
    
    $sql = "UPDATE `catatan_siswa` SET 
            c_id_kelas = '$class',
            c_id_siswa = '$student',
            catatan = '$feedback',
            status = '$status'
            WHERE id_catatan = '$id' AND c_id_guru = '$_SESSION[teacher_id]'";
    
    if($conn->query($sql)) {
            echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data catatan telah diperbarui.',
                icon: 'success'
            }).then(() => {
                window.location.href = 'index.php?catatan';
            });
        </script>";
    } else {
            echo "<script>Swal.fire('Gagal!', 'Gagal memperbarui database.', 'error');</script>";
    }
}
?>

<script>
    // AJAX to re-fetch students if class changes during edit
    document.getElementById('class_selector').addEventListener('change', function() {
        const classId = this.value;
        const studentSelect = document.getElementById('student_selector');
        
        studentSelect.disabled = true;
        studentSelect.innerHTML = '<option>Loading...</option>';

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
                        option.value = student.student_id;
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