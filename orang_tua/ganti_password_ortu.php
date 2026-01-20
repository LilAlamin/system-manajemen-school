<?php
// Initialize variables
$parent_email = $_SESSION['parent_email'];
$msg = "";
$icon = "";

// Handle Form Submission
if (isset($_POST['change_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch current password
    $sql = "SELECT password_ortu FROM `orang_tua` WHERE email_ortu = '$parent_email'";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $current_db_password = $row['password_ortu'];

        // Verify Old Password
        if ($old_password === $current_db_password) {
            // Check New Password match
            if ($new_password === $confirm_password) {
                // Update Password
                $update_sql = "UPDATE `orang_tua` SET password_ortu = '$new_password' WHERE email_ortu = '$parent_email'";
                if ($conn->query($update_sql)) {
                    $msg = "Password berhasil diubah!";
                    $icon = "success";
                } else {
                    $msg = "Gagal memperbarui password di database.";
                    $icon = "error";
                }
            } else {
                $msg = "Password baru dan konfirmasi tidak cocok.";
                $icon = "warning";
            }
        } else {
            $msg = "Password lama salah.";
            $icon = "error";
        }
    } else {
        $msg = "Akun tidak ditemukan.";
        $icon = "error";
    }
}
?>

<div class="p-4 sm:ml-64">
    <div class="max-w-2xl mx-auto mt-10">
        <div class="bg-white rounded-lg shadow-md border border-gray-100 p-6 sm:p-8">
            <div class="flex items-center space-x-3 mb-6">
                <div class="p-2 bg-indigo-100 rounded-lg">
                    <i class="fas fa-key text-indigo-600 text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Ganti Password</h1>
            </div>
            
            <form method="post" class="space-y-6">
                <!-- Old Password -->
                <div>
                    <label for="old_password" class="block mb-2 text-sm font-medium text-gray-900">Password Lama</label>
                    <div class="relative">
                        <input type="password" name="old_password" id="old_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="••••••••" required>
                        <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700" onclick="togglePassword('old_password', 'icon_old')">
                            <i class="fas fa-eye" id="icon_old"></i>
                        </button>
                    </div>
                </div>

                <!-- New Password -->
                <div>
                    <label for="new_password" class="block mb-2 text-sm font-medium text-gray-900">Password Baru</label>
                    <div class="relative">
                        <input type="password" name="new_password" id="new_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="••••••••" required onkeyup="checkPasswordMatch()">
                        <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700" onclick="togglePassword('new_password', 'icon_new')">
                            <i class="fas fa-eye" id="icon_new"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input type="password" name="confirm_password" id="confirm_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="••••••••" required onkeyup="checkPasswordMatch()">
                        <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700" onclick="togglePassword('confirm_password', 'icon_confirm')">
                            <i class="fas fa-eye" id="icon_confirm"></i>
                        </button>
                    </div>
                    <p id="passwordMatchMessage" class="mt-2 text-xs font-semibold h-4"></p>
                </div>

                <button type="submit" name="change_password" class="w-full text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center shadow-md transition-colors">
                    Perbarui Password
                </button>
            </form>
        </div>
    </div>
</div>

<?php if (!empty($msg)): ?>
<script>
    Swal.fire({
        title: '<?= ($icon == "success") ? "Berhasil!" : "Gagal!" ?>',
        text: '<?= $msg ?>',
        icon: '<?= $icon ?>',
        confirmButtonColor: '#4f46e5'
    }).then((result) => {
        if ('<?= $icon ?>' === 'success') {
            window.location.href = 'index.php?ganti_password_ortu';
        }
    });
</script>
<?php endif; ?>

<script>
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }

    function checkPasswordMatch() {
        const password = document.getElementById("new_password").value;
        const confirmPassword = document.getElementById("confirm_password").value;
        const messageDiv = document.getElementById("passwordMatchMessage");

        if (confirmPassword.length === 0) {
            messageDiv.innerHTML = "";
            return;
        }

        if (password === confirmPassword) {
            messageDiv.style.color = "green";
            messageDiv.innerHTML = "<i class='fas fa-check-circle mr-1'></i> Password cocok.";
        } else {
            messageDiv.style.color = "red";
            messageDiv.innerHTML = "<i class='fas fa-times-circle mr-1'></i> Password tidak cocok.";
        }
    }
</script>