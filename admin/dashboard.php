<?php
$title = "Dashboard";
require_once('../partials/_connection.php');

// Fetch Real Data

// 1. Total Siswa (Students)
$student_sql = "SELECT count(*) as total FROM siswa";
$student_result = $conn->query($student_sql);
$student_count = $student_result->fetch_assoc()['total'];

// 2. Total Guru (Teachers)
$teacher_sql = "SELECT count(*) as total FROM guru"; 
$teacher_result = $conn->query($teacher_sql);
$teacher_count = $teacher_result->fetch_assoc()['total'];


// 3. Total Mapel (Subjects)
$subject_sql = "SELECT count(*) as total FROM mapel"; 
$subject_result = $conn->query($subject_sql);
$subject_count = $subject_result->fetch_assoc()['total'];


// 4. Total Kelas (Classes)
$class_sql = "SELECT count(*) as total FROM kelas"; 
$class_result = $conn->query($class_sql);
$class_count = $class_result->fetch_assoc()['total'];

?>

<!-- Welcome Banner -->
<div class="relative w-full bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl overflow-hidden mb-8 p-8 text-white">
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-center">
        <div>
            <h1 class="text-4xl font-extrabold mb-2 tracking-tight">Selamat Datang, Admin! 👋</h1>
            <p class="text-blue-100 text-lg">Berikut adalah ringkasan aktivitas sekolah hari ini.</p>
        </div>
        <div class="mt-6 md:mt-0 text-right hidden md:block">
            <p class="text-sm font-light text-blue-200 uppercase tracking-widest">Hari Ini</p>
            <p class="text-3xl font-bold"><?php echo date("d M Y"); ?></p>
        </div>
    </div>
    <!-- Decorative Circle -->
    <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-10"></div>
    <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-40 h-40 rounded-full bg-white opacity-10"></div>
</div>

<section class="content">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Students Card -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute right-0 top-0 h-full w-1 bg-gradient-to-b from-blue-400 to-blue-600"></div>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total Siswa</p>
                    <h3 class="text-3xl font-bold text-gray-800"><?php echo $student_count; ?></h3>
                </div>
                <div class="p-3 bg-blue-50 rounded-full group-hover:bg-blue-100 transition-colors">
                    <i class="fas fa-user-graduate text-blue-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-green-500">
                <i class="fas fa-arrow-up mr-1"></i>
                <span class="font-medium">Terdaftar</span>
            </div>
        </div>

        <!-- Teachers Card -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute right-0 top-0 h-full w-1 bg-gradient-to-b from-purple-400 to-purple-600"></div>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total Guru</p>
                    <h3 class="text-3xl font-bold text-gray-800"><?php echo $teacher_count; ?></h3>
                </div>
                <div class="p-3 bg-purple-50 rounded-full group-hover:bg-purple-100 transition-colors">
                    <i class="fas fa-chalkboard-teacher text-purple-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-purple-500">
                <span class="font-medium">Pengajar Aktif</span>
            </div>
        </div>

        <!-- Subjects Card -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute right-0 top-0 h-full w-1 bg-gradient-to-b from-pink-400 to-pink-600"></div>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Mata Pelajaran</p>
                    <h3 class="text-3xl font-bold text-gray-800"><?php echo $subject_count; ?></h3>
                </div>
                <div class="p-3 bg-pink-50 rounded-full group-hover:bg-pink-100 transition-colors">
                    <i class="fas fa-book text-pink-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-pink-500">
                <span class="font-medium">Kurikulum Tersedia</span>
            </div>
        </div>

        <!-- Classes Card -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 relative overflow-hidden group">
            <div class="absolute right-0 top-0 h-full w-1 bg-gradient-to-b from-yellow-400 to-yellow-600"></div>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Total Kelas</p>
                    <h3 class="text-3xl font-bold text-gray-800"><?php echo $class_count; ?></h3>
                </div>
                <div class="p-3 bg-yellow-50 rounded-full group-hover:bg-yellow-100 transition-colors">
                    <i class="fas fa-school text-yellow-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-yellow-500">
                <span class="font-medium">Ruang Belajar</span>
            </div>
        </div>
    </div>

    <!-- Layout Grid: Quick Actions & Recent Info -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Quick Actions -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-bolt text-yellow-500 mr-2"></i> Aksi Cepat
                </h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="index.php?tambah_siswa" class="flex flex-col items-center justify-center p-4 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 transition-colors group">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm mb-2 group-hover:scale-110 transition-transform">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <span class="text-sm font-semibold">Tambah Siswa</span>
                    </a>
                    <a href="index.php?tambah_guru" class="flex flex-col items-center justify-center p-4 rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-700 transition-colors group">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm mb-2 group-hover:scale-110 transition-transform">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <span class="text-sm font-semibold">Tambah Guru</span>
                    </a>
                     <a href="index.php?tambah_kelas" class="flex flex-col items-center justify-center p-4 rounded-xl bg-pink-50 hover:bg-pink-100 text-pink-700 transition-colors group">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm mb-2 group-hover:scale-110 transition-transform">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <span class="text-sm font-semibold">Tambah Kelas</span>
                    </a>
                     <a href="index.php?pengumuman" class="flex flex-col items-center justify-center p-4 rounded-xl bg-green-50 hover:bg-green-100 text-green-700 transition-colors group">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm mb-2 group-hover:scale-110 transition-transform">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <span class="text-sm font-semibold">Pengumuman</span>
                    </a>
                </div>
            </div>

            <!-- Recent Students Table Placeholder -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-800">Siswa Baru Terdaftar</h2>
                    <a href="index.php?siswa" class="text-sm font-medium text-blue-600 hover:text-blue-800">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Nama Siswa</th>
                                <th class="px-6 py-3">Kelas</th>
                                <th class="px-6 py-3">Tanggal Daftar</th>
                                <th class="px-6 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch last 5 students with proper JOIN
                            $recent_sql = "SELECT siswa.*, kelas.nama_kelas FROM siswa 
                                           LEFT JOIN kelas ON siswa.kelas_siswa = kelas.id_kelas 
                                           ORDER BY siswa.id_siswa DESC LIMIT 5";
                            $recent_result = $conn->query($recent_sql);
                            
                            if ($recent_result && $recent_result->num_rows > 0) {
                                while($row = $recent_result->fetch_assoc()) {
                                    $status_class = $row['status_siswa'] == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                                    $status_badge = '<span class="'.$status_class.' text-xs font-medium mr-2 px-2.5 py-0.5 rounded">'.htmlspecialchars($row['status_siswa']).'</span>';
                                    
                                    echo "<tr class='bg-white border-b hover:bg-gray-50'>";
                                    echo "<td class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap'>" . htmlspecialchars($row['nama_siswa']) . "</td>";
                                    echo "<td class='px-6 py-4'>" . htmlspecialchars($row['nama_kelas'] ?? 'N/A') . "</td>"; 
                                    echo "<td class='px-6 py-4'>" . date('d M Y', strtotime($row['tanggal_regis_siswa'])) . "</td>";
                                    echo "<td class='px-6 py-4'>" . $status_badge . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='px-6 py-4 text-center'>Belum ada data siswa.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Column: Info & Calendar -->
        <div class="space-y-8">
             <!-- School Info Card -->
            <div class="bg-gradient-to-br from-indigo-600 to-blue-700 rounded-2xl p-6 text-white shadow-lg">
                <h3 class="text-lg font-bold mb-2">Informasi Sekolah</h3>
                <p class="opacity-80 text-sm mb-4">Sistem Manajemen Sekolah yang efisien dan modern.</p>
                <div class="space-y-3">
                    <div class="flex items-center text-sm opacity-90">
                        <i class="fas fa-map-marker-alt w-5"></i>
                        <span>Jl. Pendidikan No. 123</span>
                    </div>
                    <div class="flex items-center text-sm opacity-90">
                        <i class="fas fa-phone w-5"></i>
                        <span>(021) 1234-5678</span>
                    </div>
                    <div class="flex items-center text-sm opacity-90">
                        <i class="fas fa-envelope w-5"></i>
                        <span>admin@smhs.sch.id</span>
                    </div>
                </div>
            </div>

            <!-- Simple Calendar Widget (Static for UI) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Agenda</h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-12 text-center">
                            <span class="block text-xs font-bold text-gray-500 uppercase">Sep</span>
                            <span class="block text-xl font-bold text-gray-800">15</span>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-semibold text-gray-900">Rapat Guru</h4>
                            <p class="text-xs text-gray-500">Ruang 101, 09:00 WIB</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                         <div class="flex-shrink-0 w-12 text-center">
                            <span class="block text-xs font-bold text-gray-500 uppercase">Sep</span>
                            <span class="block text-xl font-bold text-gray-800">20</span>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-semibold text-gray-900">Ujian Tengah Semester</h4>
                            <p class="text-xs text-gray-500">Seluruh Kelas</p>
                        </div>
                    </div>
                     <div class="flex items-start">
                         <div class="flex-shrink-0 w-12 text-center">
                            <span class="block text-xs font-bold text-gray-500 uppercase">Oct</span>
                            <span class="block text-xl font-bold text-gray-800">01</span>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-semibold text-gray-900">Penerimaan Siswa Baru</h4>
                            <p class="text-xs text-gray-500">Online</p>
                        </div>
                    </div>
                </div>
                 <button class="w-full mt-6 py-2 text-sm text-blue-600 font-medium hover:bg-blue-50 rounded-lg transition-colors">
                    Lihat Kalender Lengkap
                </button>
            </div>
        </div>
    </div>
</section>