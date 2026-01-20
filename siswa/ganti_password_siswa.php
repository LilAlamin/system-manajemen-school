<div class="p-4 sm:ml-64">
    <div class="max-w-xl mx-auto mt-4">
        
        <div class="mb-6 text-center md:text-left">
             <h1 class="text-3xl font-bold text-gray-800">Ganti Password</h1>
             <p class="text-gray-600 mt-1">Perbarui kata sandi akun Anda untuk keamanan</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
             <div class="p-6">
                <!-- Logic PHP -->
                <?php
                $student_email = $_SESSION['student_email'];
                // Use correct table and columns
                $sql = "SELECT * FROM `siswa` WHERE email_siswa = '$student_email'";
                $result = $conn->query($sql);
                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    $student_old_password = $row['password_siswa'];
                }

                if (isset($_POST['stu_new_pass_btn'])) {
                    $old_password = $_POST['old_password'];
                    $new_password = $_POST['new_password'];
                    $confirm_password = $_POST['confirm_password'];
                    
                    if ($old_password == $student_old_password) {
                        if ($new_password == $confirm_password) {
                            $sql = "UPDATE `siswa` SET `password_siswa` = '$new_password' WHERE email_siswa = '$student_email' ";
                            $conn->query($sql);
                ?>
                            <script>
                                $(document).ready(function() {
                                    Swal.fire({
                                        title: 'Berhasil!',
                                        text: 'Password Anda berhasil diperbarui!',
                                        icon: 'success'
                                    }).then(() => {
                                        window.location.href = 'index.php?ganti_password';
                                    });
                                });
                            </script>
                        <?php
                        } else {
                        ?>
                            <script>
                                $(document).ready(function() {
                                    Swal.fire('Gagal!', 'Konfirmasi password baru tidak cocok. Silakan coba lagi.', 'error');
                                });
                            </script>
                        <?php
                        }
                    } else {
                        ?>
                        <script>
                            $(document).ready(function() {
                                Swal.fire('Gagal!', 'Password lama Anda salah. Silakan coba lagi.', 'error');
                            });
                        </script>
                    <?php
                    }
                }
                ?>
                
                <form method="post" class="space-y-4">
                    <!-- Old Password -->
                    <div>
                        <label for="old_password" class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                        <div class="relative">
                            <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="old_password" name="old_password" required>
                             <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <input type="checkbox" onclick="togglePassword('old_password')" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Centang kotak untuk melihat password</p>
                    </div>

                    <!-- New Password -->
                    <div>
                        <label for="txtNewPassword" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <div class="relative">
                            <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="txtNewPassword" name="new_password" required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <input type="checkbox" onclick="togglePassword('txtNewPassword')" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
                            </div>
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="txtConfirmPassword" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input type="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="txtConfirmPassword" name="confirm_password" required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                <input type="checkbox" onclick="togglePassword('txtConfirmPassword')" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
                            </div>
                        </div>
                         <div id="CheckPasswordMatch" class="text-sm mt-1 font-medium"></div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300 shadow-md" name="stu_new_pass_btn" id="stu_new_pass_btn">
                            Simpan Password Baru
                        </button>
                    </div>
                </form>

             </div>
        </div>
        
        <div class="h-20"></div>
    </div>
</div>

<script>
    function togglePassword(id) {
        var x = document.getElementById(id);
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function checkPasswordMatch() {
        var password = $("#txtNewPassword").val();
        var confirmPassword = $("#txtConfirmPassword").val();
        if (password != confirmPassword && confirmPassword != "") {
             $("#CheckPasswordMatch").html("Password tidak cocok!").css("color", "red");
        } else if (password == confirmPassword && confirmPassword != "") {
            $("#CheckPasswordMatch").html("Password cocok.").css("color", "green");
        } else {
             $("#CheckPasswordMatch").html("");
        }
    }
    
    $(document).ready(function() {
        $("#txtConfirmPassword").keyup(checkPasswordMatch);
        $("#txtNewPassword").keyup(checkPasswordMatch);
    });
</script>