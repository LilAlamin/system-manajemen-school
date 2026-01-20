<?php require_once('partials/ortu_head.php'); ?>

<!-- Layout Wrapper -->
<div class="antialiased bg-gray-50 min-h-screen">

    <!-- Topnav -->
    <?php require_once('partials/ortu_topnav.php'); ?>

    <!-- Sidebar -->
    <?php require_once('partials/ortu_sidebar.php'); ?>

    <!-- Main Content Area -->
    <main class="">
        <?php
        require_once('../partials/_connection.php');

        // Dashboard
        if (isset($_GET['dashboard'])) {
            require_once('dashboard.php');
        }

        // Logout
        if (isset($_GET['logout_ortu'])) {
            require_once('logout_ortu.php');
        }

        // Change Password -> Ganti Password
        if (isset($_GET['ganti_password_ortu'])) {
            require_once('ganti_password_ortu.php');
        }

        // Profile -> Profil
        if (isset($_GET['profil_ortu'])) {
            require_once('profil_ortu.php');
        }

        // Default: If no param, redirect to dashboard
        if (empty($_GET)) {
             echo '<script>window.location.href="index.php?dashboard"</script>';
        }
        ?>
    </main>

</div>

<?php require_once('partials/ortu_footer.php'); ?>