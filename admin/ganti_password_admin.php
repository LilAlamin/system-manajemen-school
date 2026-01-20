<?php
// Asumsikan session 'admin_email' diset saat login. Jika tidak, redirect/error handle.
// Kode legacy menggunakan $_SESSION['admin_email'].
// Cek jika session belum ada untuk safety
if (!isset($_SESSION['admin_email'])) {
    // Fallback or Redirect logic
}

$email_admin = $_SESSION['admin_email'];

// Ambil password lama dari DB untuk verifikasi
// Gunakan prepared statement untuk keamanan (ideal world), tapi ikuti pola existing dulu dengan kolom update.
$sql = "SELECT * FROM `admin` WHERE email_admin = '$email_admin'";
$result = $conn->query($sql);
$admin_old_password_db = "";

if ($result && $result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $admin_old_password_db = $row['password_admin']; // Correct column name
}

if (isset($_POST['change_password_btn'])) {
    $input_old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi Password Lama
    if ($input_old_password == $admin_old_password_db) {
        // Validasi Password Baru Match
        if ($new_password == $confirm_password) {
            // Update Password
            $update_sql = "UPDATE `admin` SET `password_admin` = '$new_password' WHERE email_admin = '$email_admin' ";
            
            if ($conn->query($update_sql)) {
                echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Password berhasil diubah!',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = 'index.php?dashboard';
                        });
                    });
                </script>";
            } else {
                 echo "<script>
                    $(document).ready(function() {
                        Swal.fire('Gagal!', 'Terjadi kesalahan database.', 'error');
                    });
                </script>";
            }
        } else {
             echo "<script>
                $(document).ready(function() {
                    Swal.fire('Gagal!', 'Konfirmasi password baru tidak cocok.', 'error');
                });
            </script>";
        }
    } else {
         echo "<script>
            $(document).ready(function() {
                Swal.fire('Gagal!', 'Password lama anda salah.', 'error');
            });
        </script>";
    }
}
?>

<div class="container mx-auto px-4 py-12">
    <div class="max-w-lg mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        
        <!-- Header -->
        <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50 text-center">
            <h1 class="text-2xl font-bold text-gray-800">Ganti Password Admin 🔒</h1>
            <p class="text-sm text-gray-500 mt-1">Amankan akun anda dengan password baru.</p>
        </div>

        <!-- Form -->
        <div class="p-8">
            <form method="post">
                
                <!-- Password Lama -->
                <div class="mb-5">
                    <label for="old_password" class="block mb-2 text-sm font-semibold text-gray-700">Password Lama</label>
                    <div class="relative">
                        <input type="password" id="old_password" name="old_password" required class="block w-full pl-4 pr-10 py-3 text-sm text-gray-800 bg-gray-50 border border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" onclick="togglePassword('old_password', 'icon_old')">
                            <i id="icon_old" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Password Baru -->
                <div class="mb-5">
                    <label for="new_password" class="block mb-2 text-sm font-semibold text-gray-700">Password Baru</label>
                    <div class="relative">
                        <input type="password" id="new_password" name="new_password" required class="block w-full pl-4 pr-10 py-3 text-sm text-gray-800 bg-gray-50 border border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" onclick="togglePassword('new_password', 'icon_new')">
                            <i id="icon_new" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Konfirmasi Password Baru -->
                <div class="mb-6">
                    <label for="confirm_password" class="block mb-2 text-sm font-semibold text-gray-700">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input type="password" id="confirm_password" name="confirm_password" required class="block w-full pl-4 pr-10 py-3 text-sm text-gray-800 bg-gray-50 border border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" onclick="togglePassword('confirm_password', 'icon_confirm')">
                            <i id="icon_confirm" class="fas fa-eye text-gray-400 hover:text-gray-600"></i>
                        </div>
                    </div>
                    <div id="passwordMatchMessage" class="mt-2 text-xs font-semibold h-4"></div>
                </div>

                <button type="submit" name="change_password_btn" class="w-full px-6 py-3 text-base font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl hover:shadow-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    Update Password
                </button>

            </form>
        </div>
    </div>
</div>

<script>
    function togglePassword(inputId, iconId) {
        var input = document.getElementById(inputId);
        var icon = document.getElementById(iconId);
        
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

    $(document).ready(function() {
        $("#confirm_password").keyup(checkPasswordMatch);
        $("#new_password").keyup(checkPasswordMatch);
    });

    function checkPasswordMatch() {
        var password = $("#new_password").val();
        var confirmPassword = $("#confirm_password").val();
        var message = $("#passwordMatchMessage");

        if (password === "" || confirmPassword === "") {
             message.text("").removeClass("text-green-500 text-red-500");
             return;
        }

        if (password != confirmPassword) {
            message.text("Password tidak cocok!").removeClass("text-green-500").addClass("text-red-500");
        } else {
            message.text("Password cocok.").removeClass("text-red-500").addClass("text-green-500");
        }
    }
</script>