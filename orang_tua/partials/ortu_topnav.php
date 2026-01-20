<?php 
    $parent_name = $_SESSION['parent_name'];
?>
<nav class="bg-gradient-to-r from-blue-800 to-blue-600 fixed w-full z-20 top-0 left-0 shadow-lg border-b border-blue-500/50">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <div class="flex items-center">
            <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-blue-100 rounded-lg sm:hidden hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 mr-2">
                <span class="sr-only">Open sidebar</span>
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                   <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 5A.75.75 0 012.75 9h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 9.75zm0 5A.75.75 0 012.75 14h14.5a.75.75 0 010 1.5H2.75a.75.75 0 01-.75-.75z"></path>
                </svg>
             </button>
            <a href="index.php?dashboard" class="flex items-center space-x-3 rtl:space-x-reverse">
                 <div class="bg-white p-1.5 rounded-full">
                    <i class="fas fa-user-friends text-blue-700 text-xl"></i>
                </div>
                <span class="self-center text-xl font-bold whitespace-nowrap text-white tracking-wide">Parent Portal</span>
            </a>
        </div>
        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            <span class="text-white font-medium mr-4 hidden md:block">Selamat Datang, <?= htmlspecialchars($parent_name) ?></span>
            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white border-2 border-white/30">
                 <i class="fas fa-user"></i>
            </div>
        </div>
    </div>
</nav>
<div class="h-16"></div> <!-- Spacer for fixed navbar -->