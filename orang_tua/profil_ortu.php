<div class="p-4 sm:ml-64">
    <div class="max-w-4xl mx-auto mt-10">
        <!-- Header -->
         <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-user-circle text-indigo-600 mr-2"></i> Profil Orang Tua
            </h1>
        </div>

        <?php
        $parent_id = $_SESSION['parent_id'];
        $sql = "SELECT * FROM `orang_tua` WHERE id_ortu = '$parent_id'";
        $result = $conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $curr_name = $row['nama_ortu'];
            $curr_email = $row['email_ortu'];
            $curr_pic = $row['foto_ortu'];
        }
        ?>

        <div class="bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden">
            <div class="h-32 bg-gradient-to-r from-blue-500 to-indigo-600 relative"></div>
            
            <div class="flex flex-col items-center -mt-16 pb-8 px-8">
                <!-- Profile Image -->
                 <div class="relative group">
                    <img class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover bg-white" src="../admin/admin_images/registration/<?= $curr_pic ?>" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($curr_name) ?>&background=random&size=128'" alt="Profile">
                    <div class="absolute inset-0 rounded-full bg-black/40 hidden group-hover:flex items-center justify-center cursor-pointer transition-all" onclick="document.getElementById('profile_pic').click();">
                        <i class="fas fa-camera text-white text-xl"></i>
                    </div>
                 </div>
                
                <h2 class="mt-4 text-2xl font-bold text-gray-800"><?= htmlspecialchars($curr_name) ?></h2>
                <p class="text-gray-500 text-sm"><i class="fas fa-envelope mr-1"></i> <?= htmlspecialchars($curr_email) ?></p>

                <div class="mt-8 w-full max-w-lg">
                    <form method="post" action="" enctype="multipart/form-data" class="space-y-4">
                         
                         <!-- Name Field -->
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap</label>
                            <input type="text" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= htmlspecialchars($curr_name) ?>" required>
                        </div>

                         <!-- Photo Upload Field (Hidden by default, triggered by icon or shown here as backup) -->
                         <div>
                            <label for="profile_pic" class="block mb-2 text-sm font-medium text-gray-900">Ubah Foto Profil</label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" id="profile_pic" name="profile_pic" type="file" accept="image/png, image/jpeg, image/jpg">
                            <p class="mt-1 text-xs text-gray-500">Format: JPG, JPEG, PNG (Max 2MB)</p>
                        </div>

                        <!-- Email Field (Read Only) -->
                         <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Email (Tidak dapat diubah)</label>
                            <input type="text" class="bg-gray-100 border border-gray-300 text-gray-500 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed" value="<?= htmlspecialchars($curr_email) ?>" disabled readonly>
                        </div>

                         <div class="flex justify-end pt-4">
                            <button type="submit" name="update_profile" class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 shadow-md transition-all">
                                <i class="fas fa-save mr-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (isset($_POST['update_profile'])) {
    $new_name = $_POST['name'];
    $img_name = $_FILES['profile_pic']['name'];
    $img_type = $_FILES['profile_pic']['type'];
    $tmp_name = $_FILES['profile_pic']['tmp_name'];
    
    // Logic update variable
    $update_success = false;
    $msg = "";
    $icon = "success";

    if (!empty($new_name)) {
        // Handle Image Upload if exists
        if (!empty($img_name)) {
            $img_explode = explode('.', $img_name);
            $img_ext = end($img_explode);
            $extensions = ['png', 'jpeg', 'jpg'];
            
            if (in_array($img_ext, $extensions)) {
                 $new_img_name = time() . $img_name;
                 // Assuming path is correct relative to this file
                 if (move_uploaded_file($tmp_name, "../admin/admin_images/registration/" . $new_img_name)) {
                     // Update query with image
                     $update_sql = "UPDATE `orang_tua` SET nama_ortu = '$new_name', foto_ortu = '$new_img_name' WHERE id_ortu = '$parent_id'";
                     $_SESSION['parent_pic'] = $new_img_name; // Update session pic
                 } else {
                     $msg = "Gagal mengupload gambar.";
                     $icon = "error";
                 }
            } else {
                 $msg = "Format gambar harus jpg, jpeg, atau png.";
                 $icon = "warning";
            }
        } else {
             // Update query without image
             $update_sql = "UPDATE `orang_tua` SET nama_ortu = '$new_name' WHERE id_ortu = '$parent_id'";
        }

        // Execute Update
        if (empty($msg)) {
            if ($conn->query($update_sql)) {
                $_SESSION['parent_name'] = $new_name;
                $update_success = true;
                $msg = "Profil berhasil diperbarui.";
            } else {
                $msg = "Terjadi kesalahan database.";
                $icon = "error";
            }
        }

        // Response
        if ($update_success) {
            echo "<script>
                Swal.fire({
                    title: 'Berhasil!',
                    text: '$msg',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'index.php?profil_ortu';
                });
            </script>";
        } else {
             echo "<script>Swal.fire('Gagal!', '$msg', '$icon');</script>";
        }

    } else {
         echo "<script>Swal.fire('Peringatan!', 'Nama tidak boleh kosong.', 'warning');</script>";
    }
}
?>