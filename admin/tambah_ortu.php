<?php
// Insert Parent Logic
if (isset($_POST['add_parent'])) {
    $nama_ortu = $_POST['parent_name'];
    $email_ortu = $_POST['parent_email'];
    $nik = $_POST['nik'];
    $password = $_POST['parent_password'];
    $cpassword = $_POST['parent_cpassword'];
    $siswa_ids = isset($_POST['siswa_ids']) ? $_POST['siswa_ids'] : []; // Array of selected student IDs
    
    // Image Upload
    if (!empty($_FILES['parent_pic']['name'])) {
        $random_nums = strtotime("now");
        $foto_ortu = $random_nums . "_" . $_FILES['parent_pic']['name'];
        $temp_pic = $_FILES['parent_pic']['tmp_name'];
        move_uploaded_file($temp_pic, "admin_images/registration/$foto_ortu");
    } else {
        $foto_ortu = "";
    }

    // Check Duplicate Email
    $check_email = $conn->query("SELECT * FROM orang_tua WHERE email_ortu = '$email_ortu'");
    if ($check_email->num_rows > 0) {
        $error_msg = "Email sudah terdaftar!";
        $error_icon = "error";
    } 
    // Check Duplicate NIK
    elseif ($conn->query("SELECT * FROM orang_tua WHERE nik = '$nik'")->num_rows > 0) {
        $error_msg = "NIK sudah terdaftar!";
        $error_icon = "error";
    }
    // Check Password Match
    elseif ($password != $cpassword) {
        $error_msg = "Password tidak cocok!";
        $error_icon = "warning";
    }
    else {
        // Insert Data Orang Tua
        $sql = "INSERT INTO orang_tua (nama_ortu, email_ortu, password_ortu, nik, foto_ortu) VALUES ('$nama_ortu', '$email_ortu', '$password', '$nik', '$foto_ortu')";
        
        if ($conn->query($sql)) {
            // Update Data Siswa (Set NIK Ortu)
            if (!empty($siswa_ids)) {
                foreach ($siswa_ids as $id_siswa) {
                    $id_siswa = $conn->real_escape_string($id_siswa); // sanitize
                    $conn->query("UPDATE siswa SET nik_ortu = '$nik' WHERE id_siswa = '$id_siswa'");
                }
            }

            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data Orang Tua berhasil ditambahkan!',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = 'index.php?ortu';
                    });
                });
            </script>";
        } else {
            $error_msg = "Gagal menyimpan data ke database.";
            $error_icon = "error";
        }
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
    <!-- Breadcrumb -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="index.php?dashboard" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-purple-600">
                    <i class="fas fa-home mr-2"></i> Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-1"></i>
                    <a href="index.php?ortu" class="ml-1 text-sm font-medium text-gray-700 hover:text-purple-600">Orang Tua</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-1"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Tambah Baru</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="max-w-6xl mx-auto"> <!-- Increased width for 2 cols -->
        <!-- Card Container -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Header -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-user-plus mr-3"></i> Tambah Orang Tua Baru
                </h2>
                <p class="text-purple-100 mt-2 text-sm">Isi formulir di bawah ini untuk mendaftarkan akun orang tua baru.</p>
            </div>

            <form action="" method="post" enctype="multipart/form-data" class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Column 1: Biodata -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Biodata Orang Tua</h3>
                        
                        <div>
                            <label for="parent_name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="parent_name" id="parent_name" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-800 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all placeholder-gray-400" placeholder="Contoh: Budi Santoso">
                        </div>

                        <div>
                            <label for="nik" class="block text-sm font-semibold text-gray-700 mb-2">NIK (Nomor Induk Kependudukan)</label>
                            <input type="number" name="nik" id="nik" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-800 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all placeholder-gray-400" placeholder="16 digit NIK">
                            <p class="text-xs text-gray-500 mt-1">Digunakan untuk relasi ke data siswa.</p>
                        </div>
                        
                        <div>
                            <label for="parent_email" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                            <input type="email" name="parent_email" id="parent_email" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-800 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all placeholder-gray-400" placeholder="nama@email.com">
                        </div>

                        <div>
                            <label for="parent_password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                            <div class="relative">
                                <input type="password" name="parent_password" id="parent_password" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-800 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all placeholder-gray-400" placeholder="********">
                                <button type="button" onclick="togglePassword('parent_password')" class="absolute right-3 top-3 text-gray-400 hover:text-purple-600 focus:outline-none">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label for="parent_cpassword" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password</label>
                            <div class="relative">
                                <input type="password" name="parent_cpassword" id="parent_cpassword" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-800 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all placeholder-gray-400" placeholder="********">
                                <button type="button" onclick="togglePassword('parent_cpassword')" class="absolute right-3 top-3 text-gray-400 hover:text-purple-600 focus:outline-none">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: Foto & Pilih Anak -->
                    <div class="space-y-6">
                        
                        <!-- Student Selection -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Hubungkan dengan Siswa (Anak)</h3>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Anak</label>
                            
                            <!-- Search -->
                            <div class="relative mb-2">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400 text-xs"></i>
                                </div>
                                <input type="text" id="filterSiswa" class="w-full pl-8 pr-3 py-2 text-sm border border-gray-200 rounded-lg bg-gray-50 focus:ring-1 focus:ring-purple-500" placeholder="Cari nama siswa...">
                            </div>

                            <!-- List -->
                            <div class="h-64 overflow-y-auto border border-gray-200 rounded-xl bg-gray-50 p-2 space-y-1 custom-scrollbar">
                                <?php
                                $sql_siswa = "SELECT id_siswa, nama_siswa, id_sims FROM siswa ORDER BY nama_siswa ASC";
                                $res_siswa = $conn->query($sql_siswa);
                                if ($res_siswa->num_rows > 0) {
                                    while ($s = $res_siswa->fetch_assoc()) {
                                ?>
                                    <label class="flex items-center p-2 rounded-lg hover:bg-white hover:shadow-sm transition-all cursor-pointer group siswa-item">
                                        <input type="checkbox" name="siswa_ids[]" value="<?= $s['id_siswa'] ?>" class="w-4 h-4 text-purple-600 rounded border-gray-300 focus:ring-purple-500 transition duration-150 ease-in-out">
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-700 group-hover:text-purple-700"><?= htmlspecialchars($s['nama_siswa']) ?></p>
                                            <p class="text-xs text-gray-400">ID: <?= htmlspecialchars($s['id_sims']) ?></p>
                                        </div>
                                    </label>
                                <?php 
                                    } 
                                } else {
                                    echo "<p class='text-sm text-gray-500 p-2'>Tidak ada data siswa.</p>";
                                }
                                ?>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Centang siswa yang merupakan anak dari orang tua ini. NIK Orang Tua akan otomatis disematkan ke data siswa tersebut.</p>
                        </div>

                        <!-- Photo Upload -->
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4 mt-8">Foto Profil</h3>
                            <div class="flex items-center justify-center w-full">
                                <label for="parent_pic" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors overflow-hidden relative">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6" id="upload_placeholder">
                                        <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
                                        <p class="text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span></p>
                                        <p class="text-xs text-gray-500">Max. 2MB</p>
                                    </div>
                                    <img id="image_preview" class="absolute inset-0 w-full h-full object-cover hidden">
                                    <input id="parent_pic" name="parent_pic" type="file" class="hidden" accept="image/*" onchange="previewImage(this)" />
                                </label>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-100">
                    <a href="index.php?ortu" class="px-6 py-2.5 rounded-xl text-gray-700 bg-gray-100 hover:bg-gray-200 font-medium transition-colors">
                        Batal
                    </a>
                    <button type="submit" name="add_parent" class="px-8 py-2.5 rounded-xl text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 font-bold shadow-lg shadow-purple-200 transition-all transform hover:-translate-y-0.5">
                        <i class="fas fa-save mr-2"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = input.nextElementSibling.querySelector('i');
        
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Simple Filter for Student List
    const filterInput = document.getElementById('filterSiswa');
    const items = document.querySelectorAll('.siswa-item');

    filterInput.addEventListener('keyup', function() {
        const term = this.value.toLowerCase();
        items.forEach(item => {
            const name = item.querySelector('p').textContent.toLowerCase();
            if (name.includes(term)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });

    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('image_preview').src = e.target.result;
                document.getElementById('image_preview').classList.remove('hidden');
                document.getElementById('upload_placeholder').classList.add('opacity-0');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>