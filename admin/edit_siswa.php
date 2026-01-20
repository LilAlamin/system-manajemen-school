<?php
// Fetch Student Logic
if (isset($_GET['edit_id_siswa'])) {
    $edit_id = $_GET['edit_id_siswa'];
    $sql = "SELECT * FROM siswa WHERE id_siswa = '$edit_id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>window.location.href = 'index.php?siswa';</script>";
        exit;
    }
}

// Update Student Logic
if (isset($_POST['update_siswa'])) {
    $id_siswa = $_POST['id_siswa'];
    $nama_siswa = $_POST['nama_siswa'];
    $id_sims = $_POST['id_sims'];
    $email_siswa = $_POST['email_siswa'];
    $password_siswa = $_POST['password_siswa'];
    $kelas_siswa = $_POST['kelas_siswa'];
    $seksi_siswa = $_POST['seksi_siswa'] ?? 0;
    $tanggal_lahir_siswa = $_POST['tanggal_lahir_siswa'];
    $telepon_siswa = $_POST['telepon_siswa'];
    $alamat_siswa = $_POST['alamat_siswa'];
    $umur_siswa = $_POST['umur_siswa'];
    $jekel_siswa = $_POST['jekel_siswa'];

    $old_foto = $_POST['old_foto'];

    // Image Upload
    $foto_siswa = $old_foto;
    if (isset($_FILES['foto_siswa']['name']) && $_FILES['foto_siswa']['name'] != "") {
        $foto_siswa = time() . "_" . $_FILES['foto_siswa']['name'];
        $temp_name = $_FILES['foto_siswa']['tmp_name'];
        move_uploaded_file($temp_name, "admin_images/registration/" . $foto_siswa);
    }

    $update_sql = "UPDATE siswa SET 
                   id_sims = '$id_sims',
                   nama_siswa = '$nama_siswa',
                   email_siswa = '$email_siswa',
                   password_siswa = '$password_siswa',
                   kelas_siswa = '$kelas_siswa',
                   seksi_siswa = '$seksi_siswa',
                   tanggal_lahir_siswa = '$tanggal_lahir_siswa',
                   telepon_siswa = '$telepon_siswa',
                   alamat_siswa = '$alamat_siswa',
                   umur_siswa = '$umur_siswa',
                   jekel_siswa = '$jekel_siswa',
                   foto_siswa = '$foto_siswa'
                   WHERE id_siswa = '$id_siswa'";

    if ($conn->query($update_sql)) {
         echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data Siswa berhasil diperbarui!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'index.php?siswa';
                });
            });
        </script>";
    } else {
        echo "<script>$(document).ready(function() { Swal.fire('Error!', 'Gagal memperbarui data: " . $conn->error . "', 'error'); });</script>";
    }
}
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-8 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <span class="bg-yellow-100 text-yellow-600 p-2 rounded-lg mr-3">
                    <i class="fas fa-user-edit text-lg"></i>
                </span>
                Edit Data Siswa
            </h2>
            <a href="index.php?siswa" class="text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </a>
        </div>
        
        <form action="" method="post" enctype="multipart/form-data" class="p-8">
            <input type="hidden" name="id_siswa" value="<?= $row['id_siswa'] ?>">
            <input type="hidden" name="old_foto" value="<?= $row['foto_siswa'] ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                <!-- ID SIMS -->
                <div>
                    <label for="id_sims" class="block mb-2 text-sm font-semibold text-gray-700">ID SIMS</label>
                    <input type="text" name="id_sims" id="id_sims" value="<?= htmlspecialchars($row['id_sims']) ?>" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200" required>
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="nama_siswa" class="block mb-2 text-sm font-semibold text-gray-700">Nama Lengkap</label>
                    <input type="text" name="nama_siswa" id="nama_siswa" value="<?= htmlspecialchars($row['nama_siswa']) ?>" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200" required>
                </div>

                <!-- Email -->
                <div>
                    <label for="email_siswa" class="block mb-2 text-sm font-semibold text-gray-700">Email / Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" name="email_siswa" id="email_siswa" value="<?= htmlspecialchars($row['email_siswa']) ?>" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all duration-200" required>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password_siswa" class="block mb-2 text-sm font-semibold text-gray-700">Password (Biarkan jika tidak ubah)</label>
                    <input type="text" name="password_siswa" id="password_siswa" value="<?= htmlspecialchars($row['password_siswa']) ?>" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200" required>
                </div>

                <!-- Telepon -->
                <div>
                    <label for="telepon_siswa" class="block mb-2 text-sm font-semibold text-gray-700">Nomor Telepon</label>
                    <div class="relative">
                         <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        <input type="text" name="telepon_siswa" id="telepon_siswa" value="<?= htmlspecialchars($row['telepon_siswa']) ?>" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all duration-200" required>
                    </div>
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label for="tanggal_lahir_siswa" class="block mb-2 text-sm font-semibold text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir_siswa" id="tanggal_lahir_siswa" value="<?= htmlspecialchars($row['tanggal_lahir_siswa']) ?>" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200" required>
                </div>

                <!-- Umur -->
                <div>
                    <label for="umur_siswa" class="block mb-2 text-sm font-semibold text-gray-700">Umur</label>
                    <input type="number" name="umur_siswa" id="umur_siswa" value="<?= htmlspecialchars($row['umur_siswa']) ?>" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200" required>
                </div>

                <!-- Kelas -->
                <div>
                    <label for="kelas_siswa" class="block mb-2 text-sm font-semibold text-gray-700">Kelas</label>
                    <select name="kelas_siswa" id="kelas_siswa" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200" required>
                        <option value="">-- Pilih Kelas --</option>
                        <?php
                        $class_sql = "SELECT * FROM kelas";
                        $class_result = $conn->query($class_sql);
                        while ($class_row = $class_result->fetch_assoc()) {
                            $selected = ($class_row['id_kelas'] == $row['kelas_siswa']) ? "selected" : "";
                            echo "<option value='" . $class_row['id_kelas'] . "' $selected>" . $class_row['nama_kelas'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Seksi -->
                <div id="seksi_container">
                    <label for="seksi_siswa" class="block mb-2 text-sm font-semibold text-gray-700">Seksi / Bagian</label>
                    <select name="seksi_siswa" id="seksi_siswa" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200">
                        <option value="">-- Pilih Seksi --</option>
                         <?php
                            // Pre-fill sections based on current class
                            if (!empty($row['kelas_siswa'])) {
                                $current_class = $row['kelas_siswa'];
                                $c_sql = "SELECT nama_seksi FROM kelas WHERE id_kelas = '$current_class'";
                                $c_res = $conn->query($c_sql);
                                if ($c_res && $c_res->num_rows > 0) {
                                    $c_row = $c_res->fetch_assoc();
                                    if (!empty($c_row['nama_seksi'])) {
                                        $ids = explode(',', $c_row['nama_seksi']);
                                        foreach ($ids as $sec_id) {
                                            $sec_id = intval($sec_id);
                                            // Fetch section name
                                            $s_sql = "SELECT judul_seksi FROM seksi WHERE id_seksi = '$sec_id'";
                                            $s_res = $conn->query($s_sql);
                                            if($s_res && $s_res->num_rows > 0) {
                                                $s_row = $s_res->fetch_assoc();
                                                $selected_s = ($sec_id == $row['seksi_siswa']) ? "selected" : "";
                                                echo "<option value='$sec_id' $selected_s>" . $s_row['judul_seksi'] . "</option>";
                                            }
                                        }
                                    }
                                }
                            }
                         ?>
                    </select>
                </div>

                <!-- Alamat -->
                <div class="col-span-2">
                    <label for="alamat_siswa" class="block mb-2 text-sm font-semibold text-gray-700">Alamat Lengkap</label>
                    <textarea name="alamat_siswa" id="alamat_siswa" rows="2" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200 resize-none"><?= htmlspecialchars($row['alamat_siswa']) ?></textarea>
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Jenis Kelamin</label>
                    <div class="flex items-center space-x-6 mt-3">
                        <div class="flex items-center">
                            <input id="laki_laki" type="radio" value="Laki_Laki" name="jekel_siswa" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2" <?= ($row['jekel_siswa'] == 'Laki_Laki') ? 'checked' : '' ?>>
                            <label for="laki_laki" class="ml-2 text-sm font-medium text-gray-700">Laki-Laki</label>
                        </div>
                        <div class="flex items-center">
                            <input id="perempuan" type="radio" value="Perempuan" name="jekel_siswa" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2" <?= ($row['jekel_siswa'] == 'Perempuan') ? 'checked' : '' ?>>
                            <label for="perempuan" class="ml-2 text-sm font-medium text-gray-700">Perempuan</label>
                        </div>
                    </div>
                </div>

                <!-- Foto Siswa -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700" for="foto_siswa">Upload Foto Baru</label>
                    <div class="flex items-start space-x-4">
                        <?php if (!empty($row['foto_siswa'])): ?>
                            <div class="flex-shrink-0">
                                <img src="admin_images/registration/<?= htmlspecialchars($row['foto_siswa']) ?>" alt="Current Photo" class="h-20 w-20 object-cover rounded-xl border border-gray-200 shadow-sm">
                            </div>
                        <?php endif; ?>
                        <div class="flex-grow">
                             <input class="block w-full text-sm text-gray-500 border border-gray-200 rounded-xl cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2.5 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700" id="foto_siswa" name="foto_siswa" type="file">
                            <p class="mt-1 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah foto.</p>
                        </div>
                    </div>
                </div>



            </div>

            <div class="mt-8 flex justify-end gap-3">
                 <a href="index.php?siswa" class="px-6 py-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">Batal</a>
                <button type="submit" name="update_siswa" class="px-8 py-3 text-base font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl hover:shadow-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i> Update Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        // AJAX Fetch Section
        $('#kelas_siswa').on('change', function() {
            var classId = $(this).val();
            if (classId) {
                $.ajax({
                    type: 'POST',
                    url: 'ambil_seksi.php',
                    data: { class_id: classId }, 
                    dataType: 'json',
                    success: function(data) {
                        $('#seksi_siswa').empty();
                        $('#seksi_siswa').append('<option value="">-- Pilih Seksi --</option>');
                        $.each(data, function(key, value) {
                            $('#seksi_siswa').append('<option value="' + value.id_seksi + '">' + value.judul_seksi + '</option>');
                        });
                    },
                     error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                $('#seksi_siswa').empty();
                $('#seksi_siswa').append('<option value="">-- Pilih Seksi --</option>');
            }
        });
    });
</script>