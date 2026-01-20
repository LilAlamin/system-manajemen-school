<div class="p-4 sm:ml-64">
    <div class="max-w-xl mx-auto mt-10">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-lock text-red-600 mr-2"></i> Ganti Password
            </h1>
        </div>

        <?php
        $teacher_email = $_SESSION['teacher_email'];
        // Fetch current password
        $sql = "SELECT * FROM `guru` WHERE email_guru = '$teacher_email'";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $current_db_password = $row['password_guru'];
        }
        ?>

        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-100">
            <form method="post" id="changePasswordForm">
                <div class="mb-5">
                    <label for="old_password" class="block mb-2 text-sm font-medium text-gray-900">Password Lama</label>
                    <div class="relative">
                        <input type="password" id="old_password" name="old_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-10" required placeholder="Masukkan password lama">
                        <button type="button" onclick="togglePassword('old_password', 'icon_old')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600 hover:text-gray-800 focus:outline-none">
                            <i id="icon_old" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-5">
                    <label for="new_password" class="block mb-2 text-sm font-medium text-gray-900">Password Baru</label>
                    <div class="relative">
                        <input type="password" id="new_password" name="new_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-10" required placeholder="Masukkan password baru">
                        <button type="button" onclick="togglePassword('new_password', 'icon_new')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600 hover:text-gray-800 focus:outline-none">
                            <i id="icon_new" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input type="password" id="confirm_password" name="confirm_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-10" required placeholder="Ulangi password baru">
                        <button type="button" onclick="togglePassword('confirm_password', 'icon_confirm')" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-600 hover:text-gray-800 focus:outline-none">
                            <i id="icon_confirm" class="fas fa-eye"></i>
                        </button>
                    </div>
                    <p id="passwordMatchMessage" class="mt-2 text-xs font-medium"></p>
                </div>

                <div class="flex justify-end">
                    <button type="submit" name="change_password_btn" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center shadow-md">
                        <i class="fas fa-key mr-2"></i> Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if (isset($_POST['change_password_btn'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($old_password == $current_db_password) {
        if ($new_password == $confirm_password) {
            $update_sql = "UPDATE `guru` SET `password_guru` = '$new_password' WHERE email_guru = '$teacher_email'";
            if ($conn->query($update_sql)) {
                echo "<script>
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Password berhasil diperbarui.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = 'index.php?ganti_password';
                    });
                </script>";
            } else {
                 echo "<script>Swal.fire('Gagal!', 'Terjadi kesalahan sistem.', 'error');</script>";
            }
        } else {
             echo "<script>Swal.fire('Error!', 'Konfirmasi password tidak cocok.', 'error');</script>";
        }
    } else {
         echo "<script>Swal.fire('Error!', 'Password lama salah.', 'error');</script>";
    }
}
?>

<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }

    $(document).ready(function() {
        $('#confirm_password').on('keyup', function() {
            if ($('#new_password').val() == $('#confirm_password').val()) {
                $('#passwordMatchMessage').html('Password Cocok').removeClass('text-red-500').addClass('text-green-500');
            } else 
                $('#passwordMatchMessage').html('Password Tidak Cocok').removeClass('text-green-500').addClass('text-red-500');
        });
    });
</script>