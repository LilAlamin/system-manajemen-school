<?php
    if (isset($_GET['logout'])) {
        require_once('logout_siswa.php');
    }
?>
<?php require_once('partials/student_head.php'); ?>
<?php
if (!isset($_SESSION)) {
    session_start();
}
// $site_url = 'http://localhost/youtube-sms/';
if (isset($_SESSION['student_login']) && $_SESSION['student_login'] == TRUE) {
    if (isset($_SESSION['student_id'])) {
        // Logged in
    } else {
        header('Location: ../login.php');
    }
} else {
    header('Location: ../login.php');
}
?>

<!-- Layout Wrapper -->
<div class="antialiased bg-gray-50 min-h-screen">

    <!-- Topnav -->
    <?php require_once('partials/student_topnav.php'); ?>

    <!-- Sidebar -->
    <?php require_once('partials/student_sidebar.php'); ?>

    <!-- Main Content Area -->
    <main class="">
        <?php
        require_once('../partials/_connection.php');

        // Dashboard (Default?) or Profile?
        // Logic below handles specific pages based on GET params

        if (isset($_GET['tambah_siswa'])) {
            require_once('form_siswa.php');
        }

        // Grade -> Nilai
        if (isset($_GET['nilai'])) {
            require_once('nilai.php');
        }

        // Grade Recap -> Rekap Nilai
        if (isset($_GET['rekap_nilai'])) {
            require_once('rekap_nilai.php');
        }

        // Result -> Hasil
        if (isset($_GET['hasil'])) {
            require_once('hasil.php');
        }



        // Student Change Password -> Ganti Password
        if (isset($_GET['ganti_password'])) {
            require_once('ganti_password_siswa.php');
        }

        // Student Fee -> Biaya
        if (isset($_GET['biaya'])) {
            require_once('biaya.php');
        }
        if (isset($_GET['bayar_biaya_id'])) {
            require_once('tambah_biaya.php');
        }

        // Notice -> Pengumuman
        if (isset($_GET['pengumuman'])) {
            require_once('pengumuman.php');
        }
        if (isset($_GET['lihat_pengumuman']) || isset($_GET['lihat_pengumuman_id'])) {
            require_once('lihat_pengumuman.php');
        }
        
        // Attendance -> Absensi
        if (isset($_GET['absensi'])) {
            require_once('absensi.php');
        }

        // Feedback -> Catatan
        if (isset($_GET['catatan'])) {
            require_once('catatan.php');
        }

        // Timetable -> Jadwal
        if (isset($_GET['jadwal'])) {
            require_once('jadwal.php');
        }

        // Profile -> Profil
        if (isset($_GET['profil'])) {
            require_once('profil_siswa.php');
        }

        // Default: If no param, maybe redirect or show profile?
        // Checking if parameters are empty
        if (empty($_GET)) {
             echo '<script>window.location.href="index.php?profil"</script>';
        }
        ?>
    </main>

</div>

<?php require_once('partials/student_footer.php'); ?>