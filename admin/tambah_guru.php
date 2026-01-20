<?php
if (isset($_POST['add_teacher'])) {
    
    // Mapping input to Indonesian database columns
    $nama_guru = $_POST['teacher_name'];
    $email_guru = $_POST['teacher_email'];
    $password_guru = $_POST['teacher_password']; // No hashing as per user's existing logic, though recommended
    $cpassword_guru = $_POST['teacher_cpassword'];
    $tanggal_lahir_guru = $_POST['teacher_dob'];
    $telepon_guru = $_POST['teacher_phone'];
    $mapel_guru = $_POST['teacher_subject']; // This stores mapel_id (or similar string code)
    $alamat_guru = $_POST['teacher_address'];
    $umur_guru = $_POST['teacher_age'];
    
    // Mapping Gender ENUM
    $gender_input = $_POST['teacher_gender'];
    $jekel_guru = ($gender_input == 'Male') ? 'Laki_Laki' : 'Perempuan'; // Adjust to Enum 'Laki_Laki','Perempuan'

    // File Upload
    $random_nums = strtotime("now");
    $foto_guru = $random_nums . "_" . $_FILES['teacher_pic']['name'];
    $temp_pic = $_FILES['teacher_pic']['tmp_name'];
    
    // Check Email Duplicate
    $check_sql = "SELECT * FROM guru WHERE email_guru = '$email_guru' ";
    $check_result = $conn->query($check_sql);
    
    if ($check_result->num_rows > 0) {
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Email ini sudah terdaftar. Gunakan email lain.',
                    icon: 'error'
                });
            });
        </script>";
    } else {
        if ($password_guru == $cpassword_guru) {
            
            // Move file
            if(move_uploaded_file($temp_pic, "admin_images/registration/$foto_guru")) {
                
                // Insert Logic
                // status_guru default 'Aktif' handled by DB default, but can be explicit
                // tanggal_regis_guru handled by DB default current_timestamp
                $insert_sql = "INSERT INTO `guru` (
                    `nama_guru`, `email_guru`, `password_guru`, `tanggal_lahir_guru`,
                    `telepon_guru`, `mapel_guru`, `alamat_guru`, `umur_guru`,
                    `jekel_guru`, `foto_guru`, `status_guru`
                ) VALUES (
                    '$nama_guru', '$email_guru', '$password_guru', '$tanggal_lahir_guru',
                    '$telepon_guru', '$mapel_guru', '$alamat_guru', '$umur_guru',
                    '$jekel_guru', '$foto_guru', 'Aktif'
                )";

                if ($conn->query($insert_sql)) {
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Data Guru berhasil ditambahkan!',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = 'index.php?guru';
                            });
                        });
                    </script>";
                } else {
                     echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat menyimpan ke database: " . $conn->error . "',
                                icon: 'error'
                            });
                        });
                    </script>";
                }
            } else {
                 echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Gagal Upload!',
                            text: 'Gagal mengupload foto profil.',
                            icon: 'error'
                        });
                    });
                </script>";
            }

        } else {
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'Password Tidak Sama!',
                        text: 'Konfirmasi password harus sama dengan password.',
                        icon: 'error'
                    });
                });
            </script>";
        }
    }
}
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-8 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <span class="bg-blue-100 text-blue-600 p-2 rounded-lg mr-3">
                    <i class="fas fa-user-plus text-lg"></i>
                </span>
                Tambah Data Guru
            </h2>
            <a href="index.php?guru" class="text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </a>
        </div>
        
        <form action="" method="post" enctype="multipart/form-data" class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                <!-- Nama Lengkap -->
                <div class="col-span-2">
                    <label for="teacher_name" class="block mb-2 text-sm font-semibold text-gray-700">Nama Lengkap</label>
                    <input type="text" name="teacher_name" id="teacher_name" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200 hover:bg-white" required placeholder="Contoh: Budi Santoso, S.Pd">
                </div>

                <!-- Email -->
                <div>
                    <label for="teacher_email" class="block mb-2 text-sm font-semibold text-gray-700">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" name="teacher_email" id="teacher_email" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all duration-200 hover:bg-white" required placeholder="namaguru@sekolah.com">
                    </div>
                </div>

                <!-- Telepon -->
                <div>
                    <label for="teacher_phone" class="block mb-2 text-sm font-semibold text-gray-700">Nomor Telepon</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        <input type="text" name="teacher_phone" id="teacher_phone" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all duration-200 hover:bg-white" required placeholder="081234567890">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="teacher_password" class="block mb-2 text-sm font-semibold text-gray-700">Password</label>
                    <div class="relative">
                        <input type="password" name="teacher_password" id="teacher_password" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 pr-10 transition-all duration-200 hover:bg-white" required placeholder="********">
                        <button type="button" onclick="togglePassword('teacher_password')" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-blue-600 focus:outline-none">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="teacher_cpassword" class="block mb-2 text-sm font-semibold text-gray-700">Konfirmasi Password</label>
                    <div class="relative">
                        <input type="password" name="teacher_cpassword" id="teacher_cpassword" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 pr-10 transition-all duration-200 hover:bg-white" required placeholder="********">
                        <button type="button" onclick="togglePassword('teacher_cpassword')" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-blue-600 focus:outline-none">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <p id="password-match-text" class="text-xs mt-1 hidden"></p>
                </div>

                <!-- DOB -->
                <div>
                    <label for="teacher_dob" class="block mb-2 text-sm font-semibold text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="teacher_dob" id="teacher_dob" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200 hover:bg-white" required>
                </div>

                <!-- Age & Subject -->
                <div class="grid grid-cols-2 gap-4">
                     <div>
                        <label for="teacher_age" class="block mb-2 text-sm font-semibold text-gray-700">Umur</label>
                        <input type="number" name="teacher_age" id="teacher_age" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200 hover:bg-white" required placeholder="Contoh: 30">
                    </div>
                    <div>
                         <label for="teacher_subject" class="block mb-2 text-sm font-semibold text-gray-700">Mata Pelajaran</label>
                        <select name="teacher_subject" id="teacher_subject" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200 hover:bg-white" required>
                            <option value="" selected disabled>-- Pilih Mapel --</option>
                            <?php
                            $subject_sql = "SELECT * FROM `mapel`";
                            $subject_result = $conn->query($subject_sql);
                            while ($row = $subject_result->fetch_assoc()) {
                            ?>
                                <option value="<?= $row['id_mapel'] ?>"><?= $row['nama_mapel'] ?></option>
                            <?php
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
                            <input id="male" type="radio" value="Male" name="teacher_gender" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2" required>
                            <label for="male" class="ml-2 text-sm font-medium text-gray-700">Laki-Laki</label>
                        </div>
                        <div class="flex items-center">
                            <input id="female" type="radio" value="Female" name="teacher_gender" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2" required>
                            <label for="female" class="ml-2 text-sm font-medium text-gray-700">Perempuan</label>
                        </div>
                    </div>
                </div>

                <!-- Address -->
                <div class="col-span-2">
                    <label for="teacher_address" class="block mb-2 text-sm font-semibold text-gray-700">Alamat Lengkap</label>
                    <textarea name="teacher_address" id="teacher_address" rows="3" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200 resize-none hover:bg-white" required placeholder="Alamat lengkap domisili guru..."></textarea>
                </div>

                <!-- Picture -->
                 <div class="col-span-2">
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Foto Profil</label>
                    <div class="flex items-start space-x-6">
                        <div class="shrink-0">
                            <div id="no_preview_placeholder" class="h-24 w-24 rounded-xl bg-blue-100 flex items-center justify-center text-blue-500 border border-blue-200 border-dashed">
                                <i class="fas fa-image text-3xl"></i>
                            </div>
                            <img id="image_preview" class="h-24 w-24 object-cover rounded-xl border border-gray-200 shadow-sm hidden" />
                        </div>
                        <div class="flex-1">
                            <label class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer transition-colors">
                                <span class="sr-only">Choose file</span>
                                <input type="file" name="teacher_pic" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required onchange="previewImage(this)"/>
                            </label>
                            <p class="mt-1 text-xs text-gray-500">PNG, JPG, GIF max 2MB. Disarankan rasio 1:1.</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="index.php?guru" class="px-6 py-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    Batal
                </a>
                <button type="submit" name="add_teacher" class="px-8 py-3 text-base font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl hover:shadow-lg hover:from-blue-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePassword(id) {
        var input = document.getElementById(id);
        if (input.type === "password") {
            input.type = "text";
        } else {
            input.type = "password";
        }
    }
    
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById('image_preview');
                var placeholder = document.getElementById('no_preview_placeholder');
                
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    // Real-time password match check
    $('#teacher_cpassword, #teacher_password').on('keyup', function () {
        if ($('#teacher_password').val() == $('#teacher_cpassword').val()) {
            $('#password-match-text').html('<span class="text-green-600"><i class="fas fa-check-circle"></i> Password cocok</span>').removeClass('hidden');
        } else 
            $('#password-match-text').html('<span class="text-red-600"><i class="fas fa-times-circle"></i> Password tidak cocok</span>').removeClass('hidden');
    });
</script>