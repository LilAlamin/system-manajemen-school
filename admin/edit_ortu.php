<?php
// Fetch Data (Logic moved up to be available for Update logic reference if needed, though usually Update handles its own fetching)
// But to be safe, let's keep the standard flow.

// Update Parent Logic
if (isset($_POST['update_parent'])) {
    $edit_id = $_GET['edit_id_ortu'];
    $nama_ortu = $_POST['parent_name'];
    $email_ortu = $_POST['parent_email'];
    $nik = $_POST['nik']; // New NIK
    $password = $_POST['parent_password'];
    $old_pic = $_POST['parent_old_pic'];
    $siswa_ids = isset($_POST['siswa_ids']) ? $_POST['siswa_ids'] : []; // Selected students
    
    // Fetch Old NIK for relation cleanup
    $old_data_query = $conn->query("SELECT nik FROM orang_tua WHERE id_ortu = '$edit_id'");
    $old_data = $old_data_query->fetch_assoc();
    $old_nik = $old_data['nik'];

    // Image Upload
    if (!empty($_FILES['parent_pic']['name'])) {
        $random_nums = strtotime("now");
        $foto_ortu = $random_nums . "_" . $_FILES['parent_pic']['name'];
        $temp_pic = $_FILES['parent_pic']['tmp_name'];
        move_uploaded_file($temp_pic, "admin_images/registration/$foto_ortu");
    } else {
        $foto_ortu = $old_pic;
    }

    // Check Duplicate Email (excluding current user)
    $check_email = $conn->query("SELECT * FROM orang_tua WHERE email_ortu = '$email_ortu' AND id_ortu != '$edit_id'");
    if ($check_email->num_rows > 0) {
        $error_msg = "Email sudah digunakan oleh akun lain!";
        $error_icon = "error";
    } 
    // Check Duplicate NIK (excluding current user)
    elseif ($conn->query("SELECT * FROM orang_tua WHERE nik = '$nik' AND id_ortu != '$edit_id'")->num_rows > 0) {
        $error_msg = "NIK sudah digunakan oleh akun lain!";
        $error_icon = "error";
    }
    else {
        // Update Data Orang Tua
        $sql = "UPDATE orang_tua SET 
                nama_ortu = '$nama_ortu', 
                email_ortu = '$email_ortu', 
                password_ortu = '$password', 
                nik = '$nik', 
                foto_ortu = '$foto_ortu' 
                WHERE id_ortu = '$edit_id'";
        
        if ($conn->query($sql)) {
            // Relation Sync Logic
            // 1. Reset all students who were previously linked to the Old NIK
            if (!empty($old_nik)) {
                 $conn->query("UPDATE siswa SET nik_ortu = NULL WHERE nik_ortu = '$old_nik'");
            }
            
            // 2. Link selected students to the New NIK
            if (!empty($siswa_ids)) {
                foreach ($siswa_ids as $id_siswa) {
                    $id_siswa = $conn->real_escape_string($id_siswa);
                    $conn->query("UPDATE siswa SET nik_ortu = '$nik' WHERE id_siswa = '$id_siswa'");
                }
            }

            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data Orang Tua berhasil diperbarui!',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = 'index.php?ortu';
                    });
                });
            </script>";
        } else {
            $error_msg = "Gagal memperbarui data database.";
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

// Fetch Data for Form Population
if (isset($_GET['edit_id_ortu'])) {
    $edit_parent_id = $_GET['edit_id_ortu'];
    $sql_fetch = "SELECT * FROM orang_tua WHERE id_ortu = '$edit_parent_id'";
    $result_fetch = $conn->query($sql_fetch);
    
    if ($result_fetch->num_rows > 0) {
        $row = $result_fetch->fetch_assoc();
        $current_nik = $row['nik']; // Store for usage in checkbox check
    } else {
        echo "<script>window.location.href='index.php?ortu';</script>";
        exit;
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
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Edit Data</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="max-w-6xl mx-auto">
        <!-- Card Container -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <!-- Header -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-6">
                <h2 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-edit mr-3"></i> Edit Data Orang Tua
                </h2>
                <p class="text-purple-100 mt-2 text-sm">Perbarui informasi akun orang tua siswa.</p>
            </div>

            <form action="" method="post" enctype="multipart/form-data" class="p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Column 1: Biodata -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Biodata Orang Tua</h3>

                        <div>
                            <label for="parent_name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="parent_name" id="parent_name" value="<?= isset($row['nama_ortu']) ? htmlspecialchars($row['nama_ortu']) : '' ?>" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-800 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all placeholder-gray-400">
                        </div>

                        <div>
                            <label for="nik" class="block text-sm font-semibold text-gray-700 mb-2">NIK (Nomor Induk Kependudukan)</label>
                            <input type="text" inputmode="numeric" pattern="[0-9]*" name="nik" id="nik" value="<?= isset($row['nik']) ? htmlspecialchars($row['nik']) : '' ?>" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-800 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all placeholder-gray-400" maxlength="20">
                            <p class="text-xs text-gray-500 mt-1">Pastikan NIK sesuai (16 digit).</p>
                        </div>
                        
                        <div>
                            <label for="parent_email" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                            <input type="email" name="parent_email" id="parent_email" value="<?= isset($row['email_ortu']) ? htmlspecialchars($row['email_ortu']) : '' ?>" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-800 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all placeholder-gray-400">
                        </div>
                        
                        <div>
                            <label for="parent_password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                            <div class="relative">
                                <input type="text" name="parent_password" id="parent_password" value="<?= htmlspecialchars($row['password_ortu']) ?>" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border border-gray-200 text-gray-800 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all placeholder-gray-400">
                                <p class="text-xs text-gray-500 mt-1">Ubah jika ingin mengganti password.</p>
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
                                $sql_siswa = "SELECT id_siswa, nama_siswa, id_sims, nik_ortu FROM siswa ORDER BY nama_siswa ASC";
                                $res_siswa = $conn->query($sql_siswa);
                                if ($res_siswa->num_rows > 0) {
                                    while ($s = $res_siswa->fetch_assoc()) {
                                        // Check if this student is linked to the OLD NIK (current_nik)
                                        $isChecked = ($s['nik_ortu'] === $current_nik) ? 'checked' : '';
                                        // Highlight logic
                                        $bgClass = ($isChecked) ? 'bg-purple-50 border-purple-100' : '';
                                ?>
                                    <label class="flex items-center p-2 rounded-lg hover:bg-white hover:shadow-sm transition-all cursor-pointer group siswa-item <?= $bgClass ?>">
                                        <input type="checkbox" name="siswa_ids[]" value="<?= $s['id_siswa'] ?>" class="w-4 h-4 text-purple-600 rounded border-gray-300 focus:ring-purple-500 transition duration-150 ease-in-out" <?= $isChecked ?>>
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
                            <p class="text-xs text-gray-500 mt-2">Centang siswa yang merupakan anak dari orang tua ini. Jika Checklist ditiadakan, hubungan anak akan dihapus.</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4 mt-8">Foto Profil</h3>
                            <div class="flex items-start space-x-4">
                                <div class="shrink-0">
                                    <?php if (!empty($row['foto_ortu'])): ?>
                                        <img id="current_preview" class="h-20 w-20 object-cover rounded-xl border border-gray-200 shadow-sm" src="admin_images/registration/<?= htmlspecialchars($row['foto_ortu']) ?>" alt="Current profile photo" />
                                    <?php else: ?>
                                        <div id="no_preview_placeholder" class="h-20 w-20 rounded-xl bg-purple-100 flex items-center justify-center text-purple-500 border border-purple-200">
                                            <i class="fas fa-user-tie text-2xl"></i>
                                        </div>
                                        <img id="current_preview" class="h-20 w-20 object-cover rounded-xl border border-gray-200 shadow-sm hidden" />
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1">
                                    <input type="hidden" name="parent_old_pic" value="<?= htmlspecialchars($row['foto_ortu']) ?>">
                                    <label class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 cursor-pointer">
                                        <input type="file" name="parent_pic" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100" onchange="previewEditImage(this)"/>
                                    </label>
                                    <p class="mt-1 text-xs text-gray-500">Upload file baru untuk mengganti foto.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-100">
                    <a href="index.php?ortu" class="px-6 py-2.5 rounded-xl text-gray-700 bg-gray-100 hover:bg-gray-200 font-medium transition-colors">
                        Batal
                    </a>
                    <button type="submit" name="update_parent" class="px-8 py-2.5 rounded-xl text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 font-bold shadow-lg shadow-purple-200 transition-all transform hover:-translate-y-0.5">
                        <i class="fas fa-save mr-2"></i> Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Simple Filter for Student List
    const filterInput = document.getElementById('filterSiswa');
    const items = document.querySelectorAll('.siswa-item');

    if(filterInput) {
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
    }

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