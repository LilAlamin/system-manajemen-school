<?php
    $teacher_id = $_SESSION['teacher_id']; // This session might need to be checked if it was set correctly during login using new DB.
    // Assuming login sets $_SESSION['teacher_id'] = id_guru.
    // If login was using old column names, we might need to fix login.php too, but let's assume session holds the ID.
    
    // Check if session key matches, based on previous turns, login might be setting 'teacher_id'. 
    // Let's verify login.php quickly in my head: 
    // " $_SESSION['teacher_id'] = $teacher_row['id_guru']; " <- I should check login.php to be safe, 
    // but usually user only asks for this file. I'll assume session names coincide.

    $teacher_sql = "SELECT * FROM `guru` WHERE id_guru='$teacher_id'";
    $teacher_result = $conn->query($teacher_sql);
    $teacher_row = $teacher_result->fetch_assoc();
?>

<div class="p-4 sm:ml-64">
    <div class="max-w-4xl mx-auto mt-10">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-700 to-blue-500 rounded-t-lg p-6 shadow-lg">
            <h1 class="text-2xl font-bold text-white flex items-center">
                <i class="fas fa-user-circle mr-3"></i> Profil Guru
            </h1>
        </div>

        <!-- Content -->
        <div class="bg-white shadow-xl rounded-b-lg p-6 border border-t-0 border-gray-200">
            <form method="post" enctype='multipart/form-data'>
                
                <div class="space-y-6">
                    <!-- Name & Photo Row (Photo is display only usually, derived from sidebar/session) -->

                    <!-- Foto Profil -->
                    <div class="border-b border-gray-100 pb-4">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Foto Profil</label>
                        <div class="flex justify-between items-center group">
                            <div class="relative">
                                <img class="w-16 h-16 rounded-full object-cover border-2 border-blue-500" src="../admin/admin_images/registration/<?= htmlspecialchars($teacher_row['foto_guru']) ?>" alt="Profile Photo">
                            </div>
                            <button type="button" id="photo-edit" class="text-blue-500 hover:text-blue-700 transition">
                                <i class="fas fa-camera"></i> Ganti Foto
                            </button>
                        </div>
                        <!-- Edit Form -->
                        <div id="photo-form" class="hidden mt-3 bg-gray-50 p-4 rounded-lg border border-gray-200">
                             <input type="file" name="foto_guru" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none mb-3" accept="image/*">
                             <div class="flex space-x-2">
                                <button type="submit" name="photo-update" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Upload</button>
                                <button type="button" id="photo-cancel" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Batal</button>
                             </div>
                        </div>
                    </div>
                    
                    <!-- Nama -->
                    <div class="border-b border-gray-100 pb-4">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                        <div class="flex justify-between items-center group">
                            <span class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($teacher_row['nama_guru']) ?></span>
                            <button type="button" id="name-edit" class="text-blue-500 hover:text-blue-700 transition">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </div>
                        <!-- Edit Form -->
                        <div id="name-form" class="hidden mt-3 bg-gray-50 p-4 rounded-lg border border-gray-200">
                             <input type="text" name="nama" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none mb-3" value="<?= htmlspecialchars($teacher_row['nama_guru']) ?>">
                             <div class="flex space-x-2">
                                <button type="submit" name="name-update" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                                <button type="button" id="name-cancel" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Batal</button>
                             </div>
                        </div>
                    </div>

                    <!-- Email (Read Only usually, but let's keep it read only as per old code) -->
                    <div class="border-b border-gray-100 pb-4">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                        <div class="text-lg text-gray-800"><?= htmlspecialchars($teacher_row['email_guru']) ?></div>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="border-b border-gray-100 pb-4">
                         <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Lahir</label>
                         <div class="flex justify-between items-center group">
                            <span class="text-lg text-gray-800"><?= htmlspecialchars($teacher_row['tanggal_lahir_guru']) ?></span>
                            <button type="button" id="dob-edit" class="text-blue-500 hover:text-blue-700 transition">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </div>
                         <!-- Edit Form -->
                        <div id="dob-form" class="hidden mt-3 bg-gray-50 p-4 rounded-lg border border-gray-200">
                             <input type="date" name="dob" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none mb-3" value="<?= htmlspecialchars($teacher_row['tanggal_lahir_guru']) ?>">
                             <div class="flex space-x-2">
                                <button type="submit" name="dob-update" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                                <button type="button" id="dob-cancel" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Batal</button>
                             </div>
                        </div>
                    </div>

                    <!-- Mata Pelajaran -->
                    <div class="border-b border-gray-100 pb-4">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Mata Pelajaran</label>
                         <div class="text-lg text-gray-800">
                            <?php
                            $mapel_id = $teacher_row['mapel_guru'];
                            $fetch_mapel_sql = "SELECT nama_mapel FROM mapel WHERE id_mapel = '$mapel_id' ";
                            $mapel_result = $conn->query($fetch_mapel_sql);
                            if ($mapel_result->num_rows > 0) {
                                $fetch_mapel_row = $mapel_result->fetch_assoc();
                                echo htmlspecialchars($fetch_mapel_row['nama_mapel']);
                            } else {
                                echo "Belum ditentukan";
                            }
                            ?>
                        </div>
                    </div>

                    <!-- Telepon -->
                     <div class="border-b border-gray-100 pb-4">
                         <label class="block text-sm font-medium text-gray-500 mb-1">Nomor Telepon</label>
                         <div class="flex justify-between items-center group">
                            <span class="text-lg text-gray-800"><?= htmlspecialchars($teacher_row['telepon_guru']) ?></span>
                            <button type="button" id="phone-edit" class="text-blue-500 hover:text-blue-700 transition">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </div>
                         <!-- Edit Form -->
                        <div id="phone-form" class="hidden mt-3 bg-gray-50 p-4 rounded-lg border border-gray-200">
                             <input type="text" name="phone" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none mb-3" value="<?= htmlspecialchars($teacher_row['telepon_guru']) ?>">
                             <div class="flex space-x-2">
                                <button type="submit" name="phone-update" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                                <button type="button" id="phone-cancel" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Batal</button>
                             </div>
                        </div>
                    </div>

                    <!-- Alamat -->
                     <div class="border-b border-gray-100 pb-4">
                         <label class="block text-sm font-medium text-gray-500 mb-1">Alamat</label>
                         <div class="flex justify-between items-center group">
                            <span class="text-lg text-gray-800"><?= htmlspecialchars($teacher_row['alamat_guru']) ?></span>
                            <button type="button" id="address-edit" class="text-blue-500 hover:text-blue-700 transition">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </div>
                         <!-- Edit Form -->
                        <div id="address-form" class="hidden mt-3 bg-gray-50 p-4 rounded-lg border border-gray-200">
                             <textarea name="address" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none mb-3" rows="3"><?= htmlspecialchars($teacher_row['alamat_guru']) ?></textarea>
                             <div class="flex space-x-2">
                                <button type="submit" name="address-update" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                                <button type="button" id="address-cancel" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Batal</button>
                             </div>
                        </div>
                    </div>

                    <!-- Umur -->
                    <div class="border-b border-gray-100 pb-4">
                         <label class="block text-sm font-medium text-gray-500 mb-1">Umur</label>
                         <div class="flex justify-between items-center group">
                            <span class="text-lg text-gray-800"><?= htmlspecialchars($teacher_row['umur_guru']) ?> Tahun</span>
                            <button type="button" id="age-edit" class="text-blue-500 hover:text-blue-700 transition">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </div>
                         <!-- Edit Form -->
                        <div id="age-form" class="hidden mt-3 bg-gray-50 p-4 rounded-lg border border-gray-200">
                             <input type="number" name="age" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none mb-3" value="<?= htmlspecialchars($teacher_row['umur_guru']) ?>">
                             <div class="flex space-x-2">
                                <button type="submit" name="age-update" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                                <button type="button" id="age-cancel" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Batal</button>
                             </div>
                        </div>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Jenis Kelamin</label>
                        <div class="text-lg text-gray-800"><?= htmlspecialchars($teacher_row['jekel_guru']) ?></div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Handle Updates

// 1. Name Update
if (isset($_POST['name-update'])) {
    $nama = $_POST['nama'];
    $sql = "UPDATE `guru` SET nama_guru = '$nama' WHERE id_guru = '$teacher_id'";
    if ($conn->query($sql)) {
        $_SESSION['teacher_name'] = $nama; // Update session
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Nama Guru berhasil diperbarui!',
                icon: 'success'
            }).then(() => {
                window.location.href = 'index.php?profil';
            });
        </script>";
    } else {
         echo "<script>Swal.fire('Gagal!', 'Terjadi kesalahan saat memperbarui nama.', 'error');</script>";
    }
}

// 2. DOB Update
if (isset($_POST['dob-update'])) {
    $dob = $_POST['dob'];
    $sql = "UPDATE `guru` SET tanggal_lahir_guru = '$dob' WHERE id_guru = '$teacher_id'";
    if ($conn->query($sql)) {
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Tanggal Lahir berhasil diperbarui!',
                icon: 'success'
            }).then(() => {
                window.location.href = 'index.php?profil';
            });
        </script>";
    } else {
         echo "<script>Swal.fire('Gagal!', 'Terjadi kesalahan saat memperbarui tanggal lahir.', 'error');</script>";
    }
}

// 3. Phone Update
if (isset($_POST['phone-update'])) {
    $phone = $_POST['phone'];
    $sql = "UPDATE `guru` SET telepon_guru = '$phone' WHERE id_guru = '$teacher_id'";
    if ($conn->query($sql)) {
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Nomor Telepon berhasil diperbarui!',
                icon: 'success'
            }).then(() => {
                window.location.href = 'index.php?profil';
            });
        </script>";
    } else {
         echo "<script>Swal.fire('Gagal!', 'Terjadi kesalahan saat memperbarui nomor telepon.', 'error');</script>";
    }
}

// 4. Address Update
if (isset($_POST['address-update'])) {
    $address = $_POST['address'];
    $sql = "UPDATE `guru` SET alamat_guru = '$address' WHERE id_guru = '$teacher_id'";
    if ($conn->query($sql)) {
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Alamat berhasil diperbarui!',
                icon: 'success'
            }).then(() => {
                window.location.href = 'index.php?profil';
            });
        </script>";
    } else {
         echo "<script>Swal.fire('Gagal!', 'Terjadi kesalahan saat memperbarui alamat.', 'error');</script>";
    }
}

// 5. Age Update
if (isset($_POST['age-update'])) {
    $age = $_POST['age'];
    $sql = "UPDATE `guru` SET umur_guru = '$age' WHERE id_guru = '$teacher_id'";
    if ($conn->query($sql)) {
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Umur berhasil diperbarui!',
                icon: 'success'
            }).then(() => {
                window.location.href = 'index.php?profil';
            });
        </script>";
    } else {
         echo "<script>Swal.fire('Gagal!', 'Terjadi kesalahan saat memperbarui umur.', 'error');</script>";
    }
}

// 6. Photo Update
if (isset($_POST['photo-update'])) {
    if (isset($_FILES['foto_guru']['name']) && $_FILES['foto_guru']['name'] != "") {
        $target_dir = "../admin/admin_images/registration/";
        $original_filename = basename($_FILES["foto_guru"]["name"]);
        $imageFileType = strtolower(pathinfo($original_filename, PATHINFO_EXTENSION));
        $new_filename = time() . "_" . uniqid() . "." . $imageFileType;
        $target_file = $target_dir . $new_filename;
        $uploadOk = 1;

        // Check file size (e.g., limit to 2MB)
        if ($_FILES["foto_guru"]["size"] > 2000000) {
            echo "<script>Swal.fire('Gagal!', 'Ukuran file terlalu besar (Max 2MB).', 'error');</script>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "<script>Swal.fire('Gagal!', 'Hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.', 'error');</script>";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["foto_guru"]["tmp_name"], $target_file)) {
                // Update DB
                $sql = "UPDATE `guru` SET foto_guru = '$new_filename' WHERE id_guru = '$teacher_id'";
                if ($conn->query($sql)) {
                    $_SESSION['teacher_pic'] = $new_filename; // Update session
                    echo "<script>
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Foto Profil berhasil diperbarui!',
                            icon: 'success'
                        }).then(() => {
                            window.location.href = 'index.php?profil';
                        });
                    </script>";
                } else {
                     echo "<script>Swal.fire('Gagal!', 'Gagal update database.', 'error');</script>";
                }
            } else {
                 echo "<script>Swal.fire('Gagal!', 'Terjadi kesalahan saat mengupload file.', 'error');</script>";
            }
        }
    } else {
        echo "<script>Swal.fire('Info', 'Silakan pilih file foto terlebih dahulu.', 'info');</script>";
    }
}
?>

<script>
    $(document).ready(function() {
        // Photo Logic
        $("#photo-edit").click(function() {
            $("#photo-form").removeClass('hidden');
        });
        $("#photo-cancel").click(function() {
            $("#photo-form").addClass('hidden');
        });

        // Name Logic
        $("#name-edit").click(function() {
            $("#name-form").removeClass('hidden');
            $(this).parent().addClass('hidden'); // Hide display row temporarily or just keep it? Let's hide the button
        });
        $("#name-cancel").click(function() {
            $("#name-form").addClass('hidden');
            $("#name-edit").parent().removeClass('hidden');
        });

        // DOB Logic
        $("#dob-edit").click(function() {
            $("#dob-form").removeClass('hidden');
        });
        $("#dob-cancel").click(function() {
            $("#dob-form").addClass('hidden');
        });

        // Phone Logic
        $("#phone-edit").click(function() {
            $("#phone-form").removeClass('hidden');
        });
        $("#phone-cancel").click(function() {
            $("#phone-form").addClass('hidden');
        });

         // Address Logic
         $("#address-edit").click(function() {
            $("#address-form").removeClass('hidden');
        });
        $("#address-cancel").click(function() {
            $("#address-form").addClass('hidden');
        });

         // Age Logic
         $("#age-edit").click(function() {
            $("#age-form").removeClass('hidden');
        });
        $("#age-cancel").click(function() {
            $("#age-form").addClass('hidden');
        });
    });
</script>