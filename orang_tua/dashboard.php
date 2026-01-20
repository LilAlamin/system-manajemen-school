<div class="p-4 sm:ml-64">
    <div class="max-w-6xl mx-auto mt-10">
        <!-- Header -->
        <div class="mb-8 text-center sm:text-left">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center justify-center sm:justify-start">
                <i class="fas fa-child text-blue-500 mr-3"></i> Akun Anak Anda
            </h1>
            <p class="mt-2 text-gray-600">Pilih akun anak untuk melihat detail akademik.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <?php
            // OLD LOGIC: $my_kids = isset($_SESSION['kids']) ? $_SESSION['kids'] : '';
            // NEW LOGIC: Connect via NIK Parent
            
            $parent_id = $_SESSION['parent_id'] ?? 0;
            $has_kids = false;

            // 1. Get Parent NIK
            $sql_parent = "SELECT nik FROM orang_tua WHERE id_ortu = '$parent_id'";
            $res_parent = $conn->query($sql_parent);
            if ($res_parent && $res_parent->num_rows > 0) {
                $p_row = $res_parent->fetch_assoc();
                $parent_nik = $p_row['nik'];

                if (!empty($parent_nik)) {
                    // 2. Get Students by NIK
                    $fetch_student_sql = "
                        SELECT s.*, k.nama_kelas 
                        FROM `siswa` s 
                        LEFT JOIN `kelas` k ON s.kelas_siswa = k.id_kelas 
                        WHERE s.nik_ortu = '$parent_nik' AND s.status_siswa = 'Aktif'
                    ";
                    $fetch_student_result = $conn->query($fetch_student_sql);

                    if ($fetch_student_result && $fetch_student_result->num_rows > 0) {
                        $has_kids = true;
                        while ($row = $fetch_student_result->fetch_assoc()) {
                            $student_id = $row['id_siswa'];
                            $student_name = $row['nama_siswa'];
                            $student_pic = $row['foto_siswa'];
                            $class_name = isset($row['nama_kelas']) ? $row['nama_kelas'] : 'Kelas ID: ' . $row['kelas_siswa'];
            ?>
            
            <!-- Student Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300 border border-gray-100 group">
                <div class="h-48 bg-gray-200 relative overflow-hidden">
                    <!-- Background pattern or blur -->
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-500 opacity-90"></div>
                    <img src="../admin/admin_images/registration/<?= $student_pic ?>" alt="<?= $student_name ?>" class="absolute inset-0 w-full h-full object-cover object-top opacity-30 group-hover:scale-105 transition-transform duration-500">
                    
                    <div class="absolute bottom-0 left-0 w-full p-4 bg-gradient-to-t from-black/70 to-transparent">
                         <div class="flex items-end">
                            <img class="w-16 h-16 rounded-full border-4 border-white shadow-md object-cover mr-3 bg-white" src="../admin/admin_images/registration/<?= $student_pic ?>" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($student_name) ?>&background=random'">
                            <div class="text-white">
                                <h2 class="text-lg font-bold leading-tight"><?= htmlspecialchars($student_name) ?></h2>
                                <span class="text-xs bg-white/20 px-2 py-0.5 rounded backdrop-blur-sm border border-white/30"><?= htmlspecialchars($class_name) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="p-5">
                    <div class="flex justify-between items-center mb-4">
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-id-card mr-1 text-gray-400"></i> ID: <?= $row['id_sims'] ?? '-' ?>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Aktif</span>
                    </div>
                    
                    <a href="direct_access.php?student_id=<?= $student_id ?>" class="block w-full text-center text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-3 transition-colors duration-200 shadow-md hover:shadow-lg focus:ring-4 focus:ring-blue-300">
                        <i class="fas fa-sign-in-alt mr-2"></i> Akses Dashboard Siswa
                    </a>
                </div>
            </div>

            <?php
                        } // End while
                    }
                }
            }

            if (!$has_kids) {
            ?>
                <div class="col-span-full text-center py-10">
                    <div class="inline-block p-4 rounded-full bg-yellow-100 text-yellow-500 mb-4">
                        <i class="fas fa-child text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada data anak terhubung.</h3>
                    <p class="text-gray-500 max-w-sm mx-auto mt-2">Silakan hubungi admin sekolah untuk menghubungkan akun anak Anda.</p>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>