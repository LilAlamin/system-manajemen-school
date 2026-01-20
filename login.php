<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['teacher_name'])) {
    header("location: guru/index.php");
}
if (isset($_SESSION['student_name'])) {
    header("location: siswa/index.php");
}
$title = "Login - SMA10";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            /* Fallback color */
            background-color: #1a202c; 
        }
        .bg-image {
            background-image: url('assets/images/school.avif'); /* Updated path */
            background-size: cover;
            background-position: center;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6); /* Dark overlay */
            z-index: -1;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col font-sans">

    <!-- Background Image & Overlay -->
    <div class="bg-image"></div>
    <div class="overlay"></div>

    <!-- Navbar (New Tailwind Version) -->
    <nav class="w-full z-20 top-0 left-0 border-b border-gray-600/30 bg-gray-900/80 backdrop-blur-md fixed text-white">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="index.php" class="flex items-center">
                <!-- <img src="assets/images/logo.png" class="h-8 mr-3" alt="Logo" /> -->
                <span class="self-center text-2xl font-semibold whitespace-nowrap text-white">iSchool</span>
                <span class="ml-3 text-sm font-light text-gray-300 hidden md:block border-l border-gray-500 pl-3">Learn and Implement</span>
            </a>
            <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-400 rounded-lg md:hidden hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-700 rounded-lg md:flex-row md:space-x-8 md:mt-0 md:border-0">
                    <!-- <li>
                        <a href="index.php" class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-400 md:p-0" aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 pl-3 pr-4 text-gray-300 rounded hover:bg-gray-700 md:hover:bg-transparent md:hover:text-white md:p-0">About</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 pl-3 pr-4 text-gray-300 rounded hover:bg-gray-700 md:hover:bg-transparent md:hover:text-white md:p-0">Admission</a>
                    </li>
                    <li>
                        <a href="#" class="block py-2 pl-3 pr-4 text-gray-300 rounded hover:bg-gray-700 md:hover:bg-transparent md:hover:text-white md:p-0">Contact Us</a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>

    <!-- Login Container -->
    <div class="flex-grow flex items-center justify-center py-24 px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-md w-full space-y-8 glass-effect p-8 rounded-2xl shadow-2xl transform transition-all duration-500 hover:scale-[1.01]">
            <div class="text-center">
                <h2 class="mt-2 text-3xl font-extrabold text-gray-800 tracking-tight">
                    Sistem Manajemen Sekolah
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Masuk ke akun Anda untuk melanjutkan
                </p>
                <div class="h-1 w-20 bg-blue-500 mx-auto mt-4 rounded-full"></div>
            </div>
            
            <form class="mt-8 space-y-6" method="post" id="student_login_form">
                <div class="rounded-md shadow-sm space-y-4">
                    
                    <!-- Login Type -->
                    <div>
                        <label for="login_type" class="block text-sm font-semibold text-gray-700 mb-1">Login Sebagai</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-users text-blue-500"></i>
                            </div>
                            <select id="login_type" name="login_type" class="appearance-none rounded-lg relative block w-full pl-10 pr-10 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm bg-white/50 transition-all">
                                <option selected disabled>Pilih Peran...</option>
                                <option value="1">Guru</option>
                                <option value="2">Siswa</option>
                                <option value="3">Admin</option>
                                <option value="4">Orang Tua</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="login_email" class="block text-sm font-semibold text-gray-700 mb-1">Email / Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                 <i class="fas fa-envelope text-blue-500"></i>
                            </div>
                            <input id="login_email" name="login_email" type="text" autocomplete="username" required class="appearance-none rounded-lg relative block w-full pl-10 pr-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm bg-white/50 transition-all" placeholder="Email atau Nama Lengkap">
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="login_password" class="block text-sm font-semibold text-gray-700 mb-1">Kata Sandi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-blue-500"></i>
                            </div>
                            <input id="login_password" name="login_password" type="password" autocomplete="current-password" required class="appearance-none rounded-lg relative block w-full pl-10 pr-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm bg-white/50 transition-all" placeholder="••••••••">
                        </div>
                        <div class="flex justify-between items-center mt-3">
                            <div class="flex items-center">
                                <input id="show_password" type="checkbox" onclick="showLoginPass()" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer">
                                <label for="show_password" class="ml-2 block text-sm text-gray-600 cursor-pointer hover:text-gray-800">
                                    Lihat Password
                                </label>
                            </div>
                            <!-- <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500">Lupa Password?</a> -->
                        </div>
                    </div>

                </div>

                <div>
                    <button type="submit" name="login" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg transform transition hover:-translate-y-0.5 duration-200">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-arrow-right text-blue-100 group-hover:text-white transition ease-in-out duration-150"></i>
                        </span>
                        Masuk Sistem
                    </button>
                    <p class="mt-4 text-center text-xs text-gray-500">
                        &copy; <?= date('Y') ?> iSchool Management System. All rights reserved.
                    </p>
                </div>
                
            </form>
        </div>
    </div>

<script>
    function showLoginPass() {
        var x = document.getElementById("login_password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    // Toggle Mobile Menu
    document.querySelector('[data-collapse-toggle="navbar-sticky"]').addEventListener('click', function() {
        const target = document.getElementById('navbar-sticky');
        target.classList.toggle('hidden');
    });
</script>

<?php
require_once('partials/_connection.php');

if (isset($_POST['login'])) {
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];
    $type = $_POST['login_type'];

    if(!isset($type)){
          echo "
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Silakan pilih peran login terlebih dahulu!',
                        confirmButtonColor: '#3085d6',
                    });
                });
            </script>
        ";
    } elseif ($type == 1) {
        // Teacher login (Table: guru)
        $teacher_sql = "SELECT * FROM `guru` WHERE `email_guru` = '$email' OR `nama_guru` = '$email'";
        $teacher_result = $conn->query($teacher_sql);
        $teacher_numExist = mysqli_num_rows($teacher_result);

        if ($teacher_numExist > 0) {
            while ($teacher_row = $teacher_result->fetch_assoc()) {
                if ($teacher_row['status_guru'] == 'Disable') {
                    session_destroy();
                    // Show account disabled message
?>
                    <script>
                        $(document).ready(function() {
                            Swal.fire('Login Gagal!', "Akun Anda dinonaktifkan sementara. Hubungi Tata Usaha.", "info");
                        });
                    </script>
                <?php
                } elseif ($teacher_row['password_guru'] === $password) {
                    $_SESSION['teacher_login'] = TRUE;
                    $_SESSION['teacher_id'] = $teacher_row['id_guru'];
                    $_SESSION['teacher_name'] = $teacher_row['nama_guru'];
                    $_SESSION['teacher_email'] = $teacher_row['email_guru'];
                    $_SESSION['teacher_pic'] = $teacher_row['foto_guru'];
                    $_SESSION['teacher_gender'] = $teacher_row['jekel_guru'];
                    echo "<script> window.location.href='guru/index.php?profil' </script>";
                    exit;
                } else {
                    // Show wrong password message
                ?>
                    <script>
                        $(document).ready(function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Password Salah!',
                                text: 'Password yang Anda masukkan salah.',
                                confirmButtonColor: '#d33',
                            });
                        });
                    </script>
            <?php
                }
            }
        } else {
            // Show wrong email message
            ?>
            <script>
                $(document).ready(function() {
                     Swal.fire({
                        icon: 'error',
                        title: 'Akun Tidak Ditemukan',
                        text: 'Email atau tipe akun salah.',
                        confirmButtonColor: '#d33',
                    });
                });
            </script>
            <?php
            session_destroy();
        }
    } elseif ($type == 2) {
        // Student login (Table: siswa)
        $student_sql = "SELECT * FROM `siswa` WHERE `email_siswa` = '$email' OR `nama_siswa` = '$email'";
        $student_result = $conn->query($student_sql);
        $student_numExist = mysqli_num_rows($student_result);

        if ($student_numExist > 0) {
            while ($student_row = $student_result->fetch_assoc()) {
                if ($student_row['status_siswa'] == 'Disable') {
                    session_destroy();
                    // Show account disabled message
            ?>
                    <script>
                        $(document).ready(function() {
                            Swal.fire('Login Gagal!', "Akun Anda dinonaktifkan sementara. Hubungi Tata Usaha.", "info");
                        });
                    </script>
                <?php
                } elseif ($student_row['password_siswa'] === $password) {
                    $_SESSION['student_login'] = TRUE;
                    $_SESSION['student_id'] = $student_row['id_siswa'];
                    $_SESSION['student_name'] = $student_row['nama_siswa'];
                    $_SESSION['student_email'] = $student_row['email_siswa'];
                    $_SESSION['student_rollno'] = $student_row['id_sims']; // mapped from id_sims
                    $_SESSION['student_class'] = $student_row['kelas_siswa'];
                    $_SESSION['student_pic'] = $student_row['foto_siswa'];
                    echo "<script> window.location.href='siswa/index.php?profil' </script>";
                    exit;
                } else {
                    // Show wrong password message
                ?>
                    <script>
                        $(document).ready(function() {
                             Swal.fire({
                                icon: 'error',
                                title: 'Password Salah!',
                                text: 'Password yang Anda masukkan salah.',
                                confirmButtonColor: '#d33',
                            });
                        });
                    </script>
            <?php
                }
            }
        } else {
            // Show wrong email message
            ?>
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Akun Tidak Ditemukan',
                        text: 'Email atau tipe akun salah.',
                        confirmButtonColor: '#d33',
                    });
                });
            </script>
            <?php
            session_destroy();
        }
    } elseif ($type == 3) {
        // Admin login (Table: admin)
        $admin_sql = "SELECT * FROM `admin` WHERE `email_admin` = '$email' OR `nama_admin` = '$email'";
        $admin_result = $conn->query($admin_sql);
        $admin_numExist = mysqli_num_rows($admin_result);

        if ($admin_numExist > 0) {
            while ($admin_row = $admin_result->fetch_assoc()) {
                if ($admin_row['password_admin'] === $password) {
                    $_SESSION['admin_login'] = TRUE;
                    $_SESSION['admin_id'] = $admin_row['id_admin'];
                    $_SESSION['admin_name'] = $admin_row['nama_admin'];
                    $_SESSION['admin_email'] = $admin_row['email_admin'];
                    echo "<script> window.location.href='admin/index.php?teacher' </script>";
                    exit;
                } else {
                    // Show wrong password message
            ?>
                    <script>
                        $(document).ready(function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Password Salah!',
                                text: 'Password yang Anda masukkan salah.',
                                confirmButtonColor: '#d33',
                            });
                        });
                    </script>
            <?php
                }
            }
        } else {
            // Show wrong email message
            ?>
            <script>
                $(document).ready(function() {
                     Swal.fire({
                        icon: 'error',
                        title: 'Akun Tidak Ditemukan',
                        text: 'Email atau tipe akun salah.',
                        confirmButtonColor: '#d33',
                    });
                });
            </script>
            <?php
            session_destroy();
        }
    } elseif ($type == 4) {
        // Parent login (Table: orang_tua)
        $parent_sql = "SELECT * FROM `orang_tua` WHERE `email_ortu` = '$email' OR `nama_ortu` = '$email'";
        $parent_result = $conn->query($parent_sql);
        $parent_numExist = mysqli_num_rows($parent_result);

        if ($parent_numExist > 0) {
            $parent_row = $parent_result->fetch_assoc();
            if ($parent_row['password_ortu'] === $password) {
                $_SESSION['parent_login'] = TRUE;
                $_SESSION['parent_id'] = $parent_row['id_ortu'];
                $_SESSION['parent_name'] = $parent_row['nama_ortu'];
                $_SESSION['parent_email'] = $parent_row['email_ortu'];
                // Note: 'foro_ortu' based on DB structure, might be typo in DB
                $_SESSION['parent_pic'] = $parent_row['foro_ortu']; 
                $_SESSION['kids'] = $parent_row['anak'];
                echo "<script> window.location.href='orang_tua/index.php?dashboard' </script>";
                exit;
            } else {
                // Show wrong password message
            ?>
                <script>
                    $(document).ready(function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Password Salah!',
                            text: 'Password yang Anda masukkan salah.',
                            confirmButtonColor: '#d33',
                        });
                    });
                </script>
            <?php
            }
        } else {
            // Show wrong email message
            ?>
            <script>
                $(document).ready(function() {
                     Swal.fire({
                        icon: 'error',
                        title: 'Akun Tidak Ditemukan',
                        text: 'Email atau tipe akun salah.',
                        confirmButtonColor: '#d33',
                    });
                });
            </script>
        <?php
            session_destroy();
        }
    } else {
        // Show account type error message
        ?>
        <script>
            $(document).ready(function() {
                Swal.fire('Error!', "Log In Failed", "error");
            });
        </script>
<?php
        session_destroy();
    }
}
?>
</body>
</html>