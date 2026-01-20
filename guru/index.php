<?php
    if (isset($_GET['logout'])) {
        require_once('logout_guru.php');
    }
?>
<?php require_once('partials/teacher_head.php'); ?>
<?php
// session_start();
// $site_url = 'http://localhost/youtube-sms/';
// if(isset($_SESSION['login']) && $_SESSION['login'] == TRUE)
// {
//   if(isset($_SESSION['user_type']) && $_SESSION['user_type'] != 'admin')
//   {
//     $user_type = $_SESSION['user_type'];
//     header('Location: /sms/'.$user_type.'/dashboard.php');
//   }
// }
// else 
// {
//   header('Location: ../login.php');
// }
?>

<!-- Layout Wrapper -->
<div class="antialiased bg-gray-50 min-h-screen">

    <!-- Topnav -->
    <?php require_once('partials/teacher_topnav.php'); ?>

    <!-- Sidebar -->
    <?php require_once('partials/teacher_sidebar.php'); ?>

    <!-- Main Content Area -->
    <main class="">
        <?php
        require_once('../partials/_connection.php');

        // Dashboard
        
        // Exam -> Nilai
        if (isset($_GET['nilai'])) {
            require_once('nilai.php');
        }
        if (isset($_GET['tambah_nilai'])) {
            require_once('tambah_nilai.php');
        }
        if (isset($_GET['edit_nilai_id'])) {
            require_once('edit_nilai.php');
        }
        if (isset($_GET['hapus_nilai_id'])) {
            require_once('nilai.php');
        }

        // Logout
        if (isset($_GET['logout'])) {
            require_once('logout_guru.php');
        }

            // Teacher Change Password -> Ganti Password
            if (isset($_GET['ganti_password'])) {
            require_once('ganti_password_guru.php');
        }

            // Teacher Profile -> Profil Guru
            if (isset($_GET['profil'])) {
            require_once('profil_guru.php');
        }

        // Notice -> Pengumuman
        if (isset($_GET['pengumuman'])) {
            require_once('pengumuman.php');
        }
        if (isset($_GET['lihat_pengumuman_id'])) {
            require_once('lihat_pengumuman.php');
        }
        if (isset($_GET['pengumuman_saya'])) {
            require_once('pengumuman_saya.php');
        }
        if (isset($_GET['edit_pengumuman_id'])) {
            require_once('edit_pengumuman.php');
        }
        if (isset($_GET['hapus_pengumuman_id'])) {
            require_once('pengumuman_saya.php');
        }

        // Attendance -> Absensi
        if (isset($_GET['tambah_absensi'])) {
            require_once('tambah_absensi.php');
        }
        if (isset($_GET['absensi'])) {
            require_once('absensi.php');
        }
        if (isset($_GET['edit_absensi_id'])) {
            require_once('edit_absensi.php');
        }
        if (isset($_GET['hapus_absensi_id'])) {
            require_once('absensi.php');
        }

        // Feedback -> Catatan
        if (isset($_GET['catatan'])) {
            require_once('catatan.php');
        }
        if (isset($_GET['tambah_catatan'])) {
            require_once('tambah_catatan.php');
        }
        if (isset($_GET['edit_catatan_id'])) {
            require_once('edit_catatan.php');
        }
        if (isset($_GET['hapus_catatan_id'])) {
            require_once('catatan.php');
        }

        // Timetable -> Jadwal
        if (isset($_GET['jadwal'])) {
            require_once('jadwal.php');
        }

        // Default: If no param, maybe redirect or show profile?
        // Checking if parameters are empty
        if (empty($_GET)) {
                echo '<script>window.location.href="index.php?profil"</script>';
        }
        ?>
    </main>

</div>

<?php require_once('partials/teacher_footer.php'); ?>