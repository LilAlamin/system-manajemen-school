<?php require_once('partials/admin_head.php'); ?>
<?php require_once('partials/admin_topnav.php'); ?>
<?php require_once('partials/admin_sidebar.php'); ?>

<div class="p-4 sm:ml-64 pt-20 pb-20 min-h-screen">
    <?php
    require_once('../partials/_connection.php');
    
    // Sections (Jurusan/Section)
    if (isset($_GET['section'])) {
        require_once('seksi.php');
    }
    if (isset($_GET['edit_id_seksi'])) {
        require_once('edit_seksi.php');
    }
    if (isset($_GET['delete_id_seksi'])) {
        require_once('seksi.php');
    }

    // Classes (Kelas)
    if (isset($_GET['kelas'])) {
        require_once('kelas.php');
    }
    if (isset($_GET['tambah_kelas'])) {
        require_once('tambah_kelas.php');
    }
    if (isset($_GET['delete_id_kelas'])) {
        require_once('kelas.php');
    }
    if (isset($_GET['edit_id_kelas'])) {
        require_once('edit_kelas.php');
    }

    // Subjects (Mata Pelajaran)
    if (isset($_GET['mapel'])) {
        require_once('mapel.php');
    }
    if (isset($_GET['delete_id_mapel'])) {
        require_once('mapel.php');
    }
    if (isset($_GET['edit_id_mapel'])) {
        require_once('edit_mapel.php');
    }

    // Rooms (Ruangan)
    if (isset($_GET['ruangan'])) {
        require_once('ruangan.php');
    }
    if (isset($_GET['delete_id_ruangan'])) {
        require_once('ruangan.php');
    }
    if (isset($_GET['edit_id_ruangan'])) {
        require_once('edit_ruangan.php');
    }

    // Period (Periode/Sesi)
    if (isset($_GET['periode'])) {
        require_once('periode.php');
    }
    if (isset($_GET['delete_id_periode'])) {
        require_once('periode.php');
    }
    if (isset($_GET['edit_id_periode'])) {
        require_once('edit_periode.php');
    }

    // Timetable (Jadwal)
    if (isset($_GET['jadwal'])) {
        require_once('jadwal.php');
    }
    if (isset($_GET['delete_id_jadwal'])) {
        require_once('jadwal.php');
    }
    if (isset($_GET['edit_id_jadwal'])) {
        require_once('edit_jadwal.php');
    }
    if (isset($_GET['lihat_jadwal'])) {
        require_once('lihat_jadwal.php');
    }

    // Student (Siswa)
    if (isset($_GET['siswa'])) {
        require_once('siswa.php');
    }
    if (isset($_GET['tambah_siswa'])) {
        require_once('tambah_siswa.php');
    }
    if (isset($_GET['delete_id_siswa'])) {
        require_once('siswa.php');
    }
    if (isset($_GET['edit_id_siswa'])) {
        require_once('edit_siswa.php');
    }
    if (isset($_GET['lihat_id_siswa'])) {
        require_once('lihat_siswa.php');
    }

    // Teacher (Guru)
    if (isset($_GET['guru'])) {
        require_once('guru.php');
    }
    if (isset($_GET['tambah_guru'])) {
        require_once('tambah_guru.php');
    }
    if (isset($_GET['delete_id_guru'])) {
        require_once('guru.php');
    }
    if (isset($_GET['edit_id_guru'])) {
        require_once('edit_guru.php');
    }
    if (isset($_GET['lihat_id_guru'])) {
        require_once('lihat_guru.php');
    }

    // Parent (Orang Tua)
    if (isset($_GET['ortu'])) {
        require_once('ortu.php');
    }
    if (isset($_GET['tambah_ortu'])) {
        require_once('tambah_ortu.php');
    }
    if (isset($_GET['delete_id_ortu'])) {
        require_once('ortu.php');
    }
    if (isset($_GET['edit_id_ortu'])) {
        require_once('edit_ortu.php');
    }

    // Logout
    if (isset($_GET['logout'])) {
        require_once('logout_admin.php');
    }

    // Admin Change Password (Ganti Password)
    if (isset($_GET['ganti_password_admin'])) {
        require_once('ganti_password_admin.php');
    }

    // View Exam (Ujian)
    if (isset($_GET['ujian'])) {
        require_once('ujian.php');
    }
    if (isset($_GET['delete_id_ujian'])) {
        require_once('ujian.php');
    }

    // Fees (Biaya)
    if (isset($_GET['tambah_biaya'])) {
        require_once('tambah_biaya.php');
    }
    if (isset($_GET['biaya'])) {
        require_once('biaya.php');
    }
    if (isset($_GET['delete_id_biaya'])) {
        require_once('biaya.php');
    }
    if (isset($_GET['edit_id_biaya'])) {
        require_once('edit_biaya.php');
    }

    // Notice (Pengumuman)
    if (isset($_GET['pengumuman'])) {
        require_once('pengumuman.php');
    }
    // Handling both potential typo/legacy 'delete_noticce_id' if needed, but standardizing to 'delete_id_pengumuman'
    if (isset($_GET['delete_id_pengumuman'])) {
        require_once('pengumuman.php');
    }
    if (isset($_GET['edit_id_pengumuman'])) {
        require_once('edit_pengumuman.php');
    }

    // Attendance (Absensi)
    if (isset($_GET['lihat_absensi'])) {
        require_once('lihat_absensi.php');
    }

    // Feedback (Catatan)
    if (isset($_GET['lihat_catatan'])) {
        require_once('lihat_catatan.php');
    }
    
     // Default dashboard
    if (empty($_GET) || isset($_GET['dashboard'])) {
         require_once('dashboard.php');
    }
    ?>
</div>

<?php require_once('partials/admin_footer.php'); ?>