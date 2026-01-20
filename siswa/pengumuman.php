<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg mt-14">
        
        <div class="mb-6 text-center lg:text-left">
             <h1 class="text-3xl font-bold text-gray-800">Pengumuman</h1>
             <p class="text-gray-600 mt-1">Informasi dan berita terbaru dari sekolah</p>
        </div>

        <div class="space-y-6">
            <?php
            // $student_id = $_SESSION['student_id'];
            // $student_class = $_SESSION['student_class']; 
            // The query logic in original file was checking notice.n_class_id
            
            // New logic for 'pengumuman'
            // We need to fetch announcements where p_id_kelas is NULL (for all) OR matches student class.
            // Assumption: student_class is ID.
            
            $student_class = $_SESSION['student_class'];

            $notice_sql = "SELECT * FROM `pengumuman` 
                           WHERE `p_id_kelas` = '$student_class' OR `p_id_kelas` IS NULL 
                           ORDER BY `tanggal_pengumuman` DESC";
            
            $notice_result = $conn->query($notice_sql);
            
            if ($notice_result && $notice_result->num_rows > 0) {
                while ($notice = $notice_result->fetch_assoc()) {
                    $limited_text = substr(strip_tags($notice['ket_pengumuman']), 0, 200);
                    $limited_text = strlen(strip_tags($notice['ket_pengumuman'])) > 200 ? $limited_text . '...' : $limited_text;
                    
                    $is_global = is_null($notice['p_id_kelas']);
                    $badge_class = $is_global ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800';
                    $badge_text = $is_global ? 'Umum' : 'Kelas Pembelajaran';
            ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 border border-gray-100">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="<?= $badge_class ?> text-xs font-semibold px-2.5 py-0.5 rounded mr-2"><?= $badge_text ?></span>
                                <span class="bg-gray-100 text-gray-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded">
                                    <i class="far fa-clock mr-1"></i> <?= date('d M Y', strtotime($notice['tanggal_pengumuman'])) ?>
                                </span>
                            </div>
                        </div>
                        
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900"><?= htmlspecialchars($notice['judul_pengumuman']) ?></h5>
                        <p class="mb-3 font-normal text-gray-700"><?= $limited_text ?></p>
                        
                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                             <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">
                                    <?= strtoupper(substr($notice['pengirim'], 0, 2)) ?>
                                </div>
                                <span class="text-sm font-medium text-gray-900">Oleh: <?= htmlspecialchars($notice['pengirim']) ?></span>
                             </div>
                             
                             <a href="index.php?lihat_pengumuman&id=<?= $notice['id_pengumuman'] ?>" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-colors">
                                Baca Selengkapnya
                                <i class="fas fa-arrow-right ml-2 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php 
                } 
            } else {
            ?>
                <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4" role="alert">
                    <p class="font-bold">Tidak ada pengumuman</p>
                    <p>Belum ada pengumuman baru yang diterbitkan saat ini.</p>
                </div>
            <?php
            }
            ?>
        </div>

        <div class="h-20"></div>
    </div>
</div>
