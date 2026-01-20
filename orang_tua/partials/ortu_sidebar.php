<?php
    require_once('../partials/_connection.php');
    
    // Ensure session is started (usually handled by index, but safe to check)
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $parent_pic = isset($_SESSION['parent_pic']) ? $_SESSION['parent_pic'] : 'default.jpg';
    $parent_name = isset($_SESSION['parent_name']) ? $_SESSION['parent_name'] : 'Orang Tua';
    $parent_id = isset($_SESSION['parent_id']) ? $_SESSION['parent_id'] : 0;
    
    $parent_kids = [];
    
    if ($parent_id) {
        // 1. Get Parent NIK
        // Optimization: Check session first, if not query DB
        if (isset($_SESSION['parent_nik'])) {
             $parent_nik = $_SESSION['parent_nik'];
             // OPTIONAL: Refresh photo and name from DB to ensure sidebar is up to date 
             // (in case admin updated it while user was logged in, though user usually needs to relogin or refresh session)
             // But let's do a quick check if we are already querying the DB.
             // Ideally we query the DB for the user info *always* if we want real-time updates without relogin.
        } 
        
        // Force refresh user info from DB to handle updates
        $ortu_sql = "SELECT nik, foto_ortu, nama_ortu FROM orang_tua WHERE id_ortu = '$parent_id'";
        $ortu_res = $conn->query($ortu_sql);
        if ($ortu_res && $ortu_res->num_rows > 0) {
             $d = $ortu_res->fetch_assoc();
             $parent_nik = $d['nik'];
             // Update variables and session
             $parent_pic = !empty($d['foto_ortu']) ? $d['foto_ortu'] : 'default.jpg';
             $parent_name = $d['nama_ortu'];
             
             $_SESSION['parent_nik'] = $parent_nik;
             $_SESSION['parent_pic'] = $parent_pic;  
             $_SESSION['parent_name'] = $parent_name;
        } else {
             $parent_nik = '';
        }

        // 2. Fetch Kids by NIK
        if (!empty($parent_nik)) {
            $kids_sql = "SELECT nama_siswa FROM siswa WHERE nik_ortu = '$parent_nik' ORDER BY nama_siswa ASC";
            $kids_res = $conn->query($kids_sql);
            if ($kids_res && $kids_res->num_rows > 0) {
                while($k = $kids_res->fetch_assoc()) {
                    $parent_kids[] = $k['nama_siswa'];
                }
            }
        }
    }
?>

<aside class="fixed left-0 top-16 w-64 h-full bg-white shadow-xl overflow-y-auto border-r border-gray-200 z-40 transition-transform -translate-x-full sm:translate-x-0" id="logo-sidebar" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-white pb-24">
        <!-- User Info -->
        <div class="flex flex-col items-center pb-6 border-b border-gray-200 mb-4">
            <div class="relative">
                <img class="w-24 h-24 rounded-full object-cover border-4 border-blue-50 shadow-md" src="../admin/admin_images/registration/<?= $parent_pic ?>" alt="Profile" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($parent_name) ?>&background=random'">
                <div class="absolute bottom-0 right-0 w-6 h-6 bg-green-500 border-2 border-white rounded-full"></div>
            </div>
            <h5 class="mt-3 text-lg font-bold text-gray-800 text-center"><?= htmlspecialchars($parent_name) ?></h5>
            <div class="flex flex-col items-center text-sm text-gray-500 mt-1">
                <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-indigo-400">Orang Tua</span>
            </div>
            
            <?php if (!empty($parent_kids)): ?>
            <div class="mt-4 w-full px-2">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 text-center">Data Anak</p>
                <div class="flex flex-col space-y-1">
                    <?php foreach ($parent_kids as $kid): ?>
                    <span class="text-sm bg-gray-50 text-gray-700 px-2 py-1 rounded text-center border border-gray-100">
                        <i class="fas fa-child text-indigo-400 mr-1"></i> <?= htmlspecialchars($kid) ?>
                    </span>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php else: ?>
            <div class="mt-4 w-full px-2">
                 <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 text-center">Data Anak</p>
                 <div class="bg-yellow-50 border border-yellow-100 text-yellow-800 text-xs px-3 py-2 rounded text-center">
                    <i class="fas fa-exclamation-circle mr-1"></i> Belum ada data siswa
                 </div>
            </div>
            <?php endif; ?>
        </div>

        <ul class="space-y-2 font-medium">
            <li>
                <a href="index.php?dashboard" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 group transition duration-200">
                    <i class="fas fa-tachometer-alt w-6 h-6 text-xl text-blue-500 group-hover:text-blue-700"></i>
                    <span class="ml-3 group-hover:translate-x-1 transition-transform">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="index.php?profil_ortu" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 group transition duration-200">
                    <i class="fas fa-users w-6 h-6 text-xl text-indigo-500 group-hover:text-indigo-700"></i>
                    <span class="ml-3 group-hover:translate-x-1 transition-transform">Profil</span>
                </a>
            </li>
            <li>
                <a href="index.php?ganti_password_ortu" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 group transition duration-200">
                    <i class="fas fa-key w-6 h-6 text-xl text-gray-500 group-hover:text-gray-700"></i>
                    <span class="ml-3 group-hover:translate-x-1 transition-transform">Ganti Password</span>
                </a>
            </li>
             <li>
                <!-- <a href="../index.php" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 group transition duration-200">
                    <i class="fas fa-arrow-left w-6 h-6 text-xl text-gray-500 group-hover:text-gray-700"></i>
                    <span class="ml-3 group-hover:translate-x-1 transition-transform">Kembali</span>
                </a> -->
            </li>
        </ul>
        
        <div class="mt-8 border-t border-gray-200 pt-4">
            <ul class="space-y-2 font-medium">
                <li>
                     <a href="index.php?logout_ortu" class="flex items-center p-3 text-red-600 rounded-lg hover:bg-red-50 group transition duration-200">
                        <i class="fas fa-sign-out-alt w-6 h-6 text-xl"></i>
                        <span class="ml-3">Keluar</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>