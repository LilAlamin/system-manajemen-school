<?php 
    $student_name = $_SESSION['student_name'];
?>
<nav class="bg-gradient-to-r from-blue-800 to-blue-600 fixed w-full z-20 top-0 left-0 shadow-lg border-b border-blue-500/50">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="index.php?profil" class="flex items-center space-x-3 rtl:space-x-reverse">
             <div class="bg-white p-1.5 rounded-full">
                <i class="fas fa-graduation-cap text-blue-700 text-xl"></i>
            </div>
            <span class="self-center text-xl font-bold whitespace-nowrap text-white tracking-wide">Student Portal</span>
        </a>
        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            <span class="text-white font-medium mr-4 hidden md:block">Selamat Datang, <?= htmlspecialchars($student_name) ?></span>
            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white border-2 border-white/30">
                 <i class="fas fa-user"></i>
            </div>
        </div>
    </div>
</nav>
<div class="h-16"></div> <!-- Spacer for fixed navbar -->