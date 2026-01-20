<?php
// Update Teacher Logic Matches Current DB Structure
if (isset($_POST['update_teacher'])) {
    
    // Validate ID first
    if (!isset($_GET['edit_id_guru'])) {
        echo "<script>window.location.href = 'index.php?guru';</script>";
        exit;
    }
    
    $edit_teacher_id = $_GET['edit_id_guru'];
    
    $nama_guru = $_POST['teacher_name'];
    $email_guru = $_POST['teacher_email'];
    $password_guru = $_POST['teacher_password'];
    $tanggal_lahir_guru = $_POST['teacher_dob'];
    $telepon_guru = $_POST['teacher_phone'];
    $mapel_guru = $_POST['teacher_subject'];
    $alamat_guru = $_POST['teacher_address'];
    $umur_guru = $_POST['teacher_age'];
    
    // Gender Enum Map
    $jekel_guru = ($_POST['teacher_gender'] == 'Male') ? 'Laki_Laki' : 'Perempuan';

    // Handle Image Upload
    if (isset($_FILES['teacher_pic']['name']) && $_FILES['teacher_pic']['name'] != "") {
        $random_pic = strtotime("now");
        $foto_guru = $random_pic . "_" . $_FILES['teacher_pic']['name'];
        $temp_pic = $_FILES['teacher_pic']['tmp_name'];
        move_uploaded_file($temp_pic, "admin_images/registration/$foto_guru");
    } else {
        $foto_guru = $_POST['teacher_old_pic'];
    }

    $update_sql = "UPDATE `guru` SET 
        nama_guru = '$nama_guru', 
        email_guru = '$email_guru', 
        password_guru = '$password_guru', 
        tanggal_lahir_guru = '$tanggal_lahir_guru', 
        telepon_guru = '$telepon_guru', 
        mapel_guru = '$mapel_guru', 
        alamat_guru = '$alamat_guru', 
        umur_guru = '$umur_guru', 
        jekel_guru = '$jekel_guru', 
        foto_guru = '$foto_guru' 
        WHERE id_guru = '$edit_teacher_id' ";

    if ($conn->query($update_sql)) {
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data Guru berhasil diperbarui!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                }).then(() => {
                    window.location.href = 'index.php?guru';
                });
            });
        </script>";
    } else {
        $error_msg = "Gagal memperbarui data: " . $conn->error;
        $error_icon = "error";
    }

    if (isset($error_msg)) {
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Gagal!',
                    text: '$error_msg',
                    icon: '$error_icon'
                });
            });
        </script>";
    }
}
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-8 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <span class="bg-yellow-100 text-yellow-600 p-2 rounded-lg mr-3">
                    <i class="fas fa-edit text-lg"></i>
                </span>
                Edit Data Guru
            </h2>
            <a href="index.php?guru" class="text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </a>
        </div>
        
        <?php
        if (isset($_GET['edit_id_guru'])) {
            $edit_teacher_id = $_GET['edit_id_guru'];
            $edit_sql = "SELECT * FROM `guru` WHERE id_guru = '$edit_teacher_id'";
            $edit_result = $conn->query($edit_sql);
            if($edit_result->num_rows > 0) {
                $edit_row = $edit_result->fetch_assoc();
                
                // Convert DB values back to form values if needed
                $gender_val = ($edit_row['jekel_guru'] == 'Laki_Laki') ? 'Male' : 'Female';
        ?>
        
        <form action="" method="post" enctype="multipart/form-data" class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                <!-- Nama Lengkap -->
                <div class="col-span-2">
                    <label for="teacher_name" class="block mb-2 text-sm font-semibold text-gray-700">Nama Lengkap</label>
                    <input type="text" name="teacher_name" id="teacher_name" value="<?= htmlspecialchars($edit_row['nama_guru']) ?>" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block w-full p-3 transition-all duration-200" required>
                </div>

                <!-- Email -->
                <div>
                    <label for="teacher_email" class="block mb-2 text-sm font-semibold text-gray-700">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" name="teacher_email" id="teacher_email" value="<?= htmlspecialchars($edit_row['email_guru']) ?>" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block w-full pl-10 p-3 transition-all duration-200" required>
                    </div>
                </div>

                <!-- Telepon -->
                <div>
                    <label for="teacher_phone" class="block mb-2 text-sm font-semibold text-gray-700">Nomor Telepon</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        <input type="text" name="teacher_phone" id="teacher_phone" value="<?= htmlspecialchars($edit_row['telepon_guru']) ?>" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block w-full pl-10 p-3 transition-all duration-200" required>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="teacher_password" class="block mb-2 text-sm font-semibold text-gray-700">Password</label>
                    <div class="relative">
                        <input type="text" name="teacher_password" id="teacher_password" value="<?= htmlspecialchars($edit_row['password_guru']) ?>" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block w-full p-3 transition-all duration-200" required>
                         <p class="text-xs text-gray-500 mt-1">Ubah jika ingin mengganti password.</p>
                    </div>
                </div>

                <!-- DOB -->
                <div>
                    <label for="teacher_dob" class="block mb-2 text-sm font-semibold text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="teacher_dob" id="teacher_dob" value="<?= htmlspecialchars($edit_row['tanggal_lahir_guru']) ?>" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block w-full p-3 transition-all duration-200">
                </div>

                <!-- Age & Subject -->
                <div class="grid grid-cols-2 gap-4">
                     <div>
                        <label for="teacher_age" class="block mb-2 text-sm font-semibold text-gray-700">Umur</label>
                        <input type="number" name="teacher_age" id="teacher_age" value="<?= htmlspecialchars($edit_row['umur_guru']) ?>" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block w-full p-3 transition-all duration-200">
                    </div>
                    <div>
                         <label for="teacher_subject" class="block mb-2 text-sm font-semibold text-gray-700">Mata Pelajaran</label>
                        <select name="teacher_subject" id="teacher_subject" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block w-full p-3 transition-all duration-200">
                            <option value="">-- Pilih Mapel --</option>
                            <?php
                            $subject_sql = "SELECT * FROM `mapel`";
                            $subject_result = $conn->query($subject_sql);
                            while ($subject_row = $subject_result->fetch_assoc()) {
                                // Important: mapel_guru likely stores ID mapel
                                $selected = ($edit_row['mapel_guru'] == $subject_row['id_mapel']) ? 'selected' : '';
                                echo "<option value='" . $subject_row['id_mapel'] . "' $selected>" . $subject_row['nama_mapel'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- Gender -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Jenis Kelamin</label>
                    <div class="flex items-center space-x-6 mt-3">
                        <div class="flex items-center">
                            <input id="male" type="radio" value="Male" name="teacher_gender" class="w-5 h-5 text-yellow-600 bg-gray-100 border-gray-300 focus:ring-yellow-500 focus:ring-2" <?= ($gender_val == 'Male') ? 'checked' : '' ?>>
                            <label for="male" class="ml-2 text-sm font-medium text-gray-700">Laki-Laki</label>
                        </div>
                        <div class="flex items-center">
                            <input id="female" type="radio" value="Female" name="teacher_gender" class="w-5 h-5 text-yellow-600 bg-gray-100 border-gray-300 focus:ring-yellow-500 focus:ring-2" <?= ($gender_val == 'Female') ? 'checked' : '' ?>>
                            <label for="female" class="ml-2 text-sm font-medium text-gray-700">Perempuan</label>
                        </div>
                    </div>
                </div>

                <!-- Address -->
                <div class="col-span-2">
                    <label for="teacher_address" class="block mb-2 text-sm font-semibold text-gray-700">Alamat Lengkap</label>
                    <textarea name="teacher_address" id="teacher_address" rows="3" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block w-full p-3 transition-all duration-200 resize-none"><?= htmlspecialchars($edit_row['alamat_guru']) ?></textarea>
                </div>

                <!-- Picture -->
                 <div class="col-span-2">
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Foto Profil</label>
                    <div class="flex items-start space-x-6">
                        <div class="shrink-0">
                            <?php if (!empty($edit_row['foto_guru'])): ?>
                                <img id="current_preview" class="h-24 w-24 object-cover rounded-xl border border-gray-200 shadow-sm" src="admin_images/registration/<?= htmlspecialchars($edit_row['foto_guru']) ?>" alt="Current profile photo" />
                            <?php else: ?>
                                <div id="no_preview_placeholder" class="h-24 w-24 rounded-xl bg-yellow-100 flex items-center justify-center text-yellow-500 border border-yellow-200">
                                    <i class="fas fa-chalkboard-teacher text-3xl"></i>
                                </div>
                                <img id="current_preview" class="h-24 w-24 object-cover rounded-xl border border-gray-200 shadow-sm hidden" />
                            <?php endif; ?>
                        </div>
                        <div class="flex-1">
                            <input type="hidden" name="teacher_old_pic" value="<?= htmlspecialchars($edit_row['foto_guru']) ?>">
                            <label class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100 cursor-pointer transition-colors">
                                <span class="sr-only">Choose file</span>
                                <input type="file" name="teacher_pic" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-yellow-700 hover:file:bg-yellow-100" onchange="previewEditImage(this)"/>
                            </label>
                            <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF max 2MB. Upload file baru untuk mengganti foto.</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="index.php?guru" class="px-6 py-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-200">
                    Batal
                </a>
                <button type="submit" name="update_teacher" class="px-8 py-3 text-base font-bold text-white bg-gradient-to-r from-yellow-500 to-orange-500 rounded-xl hover:shadow-lg hover:from-yellow-600 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i> Update Data
                </button>
            </div>
        </form>
        
        <?php
            } else {
                echo "<div class='p-8 text-center text-gray-500'>Data guru tidak ditemukan.</div>";
            }
        }
        ?>
    </div>
</div>

<script>
    function previewEditImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById('current_preview');
                var placeholder = document.getElementById('no_preview_placeholder');
                
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if(placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>