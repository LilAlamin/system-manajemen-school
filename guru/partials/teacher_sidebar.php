<?php
    require_once('../partials/_connection.php');
    $teacher_id = $_SESSION['teacher_id'];
    
    // Fetch latest data from DB to ensure updates (like photo) are reflected immediately
    $sidebar_sql = "SELECT * FROM `guru` WHERE id_guru = '$teacher_id'";
    $sidebar_result = $conn->query($sidebar_sql);
    if ($sidebar_result && $sidebar_result->num_rows > 0) {
        $sidebar_row = $sidebar_result->fetch_assoc();
        $teacher_pic = $sidebar_row['foto_guru'];
        $teacher_name = $sidebar_row['nama_guru'];
        $teacher_email = $sidebar_row['email_guru'];
        // Update session to keep it in sync (optional but good)
        $_SESSION['teacher_pic'] = $teacher_pic;
        $_SESSION['teacher_name'] = $teacher_name;
    } else {
        // Fallback to session if DB fails
        $teacher_pic = $_SESSION['teacher_pic'];
        $teacher_name = $_SESSION['teacher_name'];
        $teacher_email = $_SESSION['teacher_email'];
    }

?>

<aside class="fixed left-0 top-16 w-64 h-full bg-white shadow-xl overflow-y-auto border-r border-gray-200 z-40 transition-transform -translate-x-full sm:translate-x-0" id="logo-sidebar" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-white pb-24">
        <!-- User Info -->
        <div class="flex flex-col items-center pb-6 border-b border-gray-200 mb-4">
            <div class="relative">
                <img class="w-24 h-24 rounded-full object-cover border-4 border-blue-50 shadow-md" src="../admin/admin_images/registration/<?= $teacher_pic ?>" alt="Profile" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($teacher_name) ?>&background=random'">
                <div class="absolute bottom-0 right-0 w-6 h-6 bg-green-500 border-2 border-white rounded-full"></div>
            </div>
            <h5 class="mt-3 text-lg font-bold text-gray-800 text-center"><?= htmlspecialchars($teacher_name) ?></h5>
            <div class="flex flex-col items-center text-sm text-gray-500 mt-1">
                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded border border-blue-400">Guru</span>
                <!-- <span class="mt-1"><?= htmlspecialchars($teacher_email) ?></span> -->
            </div>
        </div>

        <ul class="space-y-2 font-medium">
            <li>
                <a href="index.php?profil" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 group transition duration-200">
                    <i class="fas fa-users w-6 h-6 text-xl text-blue-500 group-hover:text-blue-700"></i>
                    <span class="ml-3 group-hover:translate-x-1 transition-transform">Profil</span>
                </a>
            </li>
            <li>
                <a href="index.php?pengumuman" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 group transition duration-200">
                    <i class="fas fa-bullhorn w-6 h-6 text-xl text-red-500 group-hover:text-red-700"></i>
                    <span class="ml-3 group-hover:translate-x-1 transition-transform">Pengumuman</span>
                </a>
            </li>
            <li>
                <a href="index.php?pengumuman_saya" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 group transition duration-200">
                    <i class="fas fa-bell w-6 h-6 text-xl text-orange-500 group-hover:text-orange-700"></i>
                    <span class="ml-3 group-hover:translate-x-1 transition-transform">Pengumuman Saya</span>
                </a>
            </li>
            <li>
                <a href="index.php?jadwal" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 group transition duration-200">
                    <i class="fas fa-calendar-alt w-6 h-6 text-xl text-purple-500 group-hover:text-purple-700"></i>
                    <span class="ml-3 group-hover:translate-x-1 transition-transform">Jadwal</span>
                </a>
            </li>
            <li>
                <a href="index.php?absensi" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 group transition duration-200">
                    <i class="fas fa-calendar-check w-6 h-6 text-xl text-green-500 group-hover:text-green-700"></i>
                    <span class="ml-3 group-hover:translate-x-1 transition-transform">Absensi</span>
                </a>
            </li>
            <li>
                <a href="index.php?nilai" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 group transition duration-200">
                    <i class="fas fa-book w-6 h-6 text-xl text-yellow-500 group-hover:text-yellow-700"></i>
                    <span class="ml-3 group-hover:translate-x-1 transition-transform">Nilai</span>
                </a>
            </li>
            <li>
                <a href="index.php?catatan" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 group transition duration-200">
                    <i class="fas fa-comments w-6 h-6 text-xl text-teal-500 group-hover:text-teal-700"></i>
                    <span class="ml-3 group-hover:translate-x-1 transition-transform">Catatan</span>
                </a>
            </li>
            <li>
                <a href="index.php?ganti_password" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 group transition duration-200">
                    <i class="fas fa-key w-6 h-6 text-xl text-gray-500 group-hover:text-gray-700"></i>
                    <span class="ml-3 group-hover:translate-x-1 transition-transform">Ganti Password</span>
                </a>
            </li>
             <li>
                <a href="../index.php" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 group transition duration-200">
                    <i class="fas fa-arrow-left w-  6 h-6 text-xl text-gray-500 group-hover:text-gray-700"></i>
                    <span class="ml-3 group-hover:translate-x-1 transition-transform">Kembali</span>
                </a>
            </li>
        </ul>
        
        <div class="mt-8 border-t border-gray-200 pt-4">
            <ul class="space-y-2 font-medium">
                <li>
                     <a href="index.php?logout" class="flex items-center p-3 text-red-600 rounded-lg hover:bg-red-50 group transition duration-200">
                        <i class="fas fa-sign-out-alt w-6 h-6 text-xl"></i>
                        <span class="ml-3">Keluar</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>

<!-- Mobile Overlay (Optional logic needed in JS to toggle sidebar) -->
<!-- For now assuming desktop-first for 'pake tailwind aja biar bagus' but responsiveness is handled by 'sm:translate-x-0' -->