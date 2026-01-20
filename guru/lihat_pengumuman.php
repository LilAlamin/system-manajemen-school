<div class="p-4 sm:ml-64">
    <div class="max-w-4xl mx-auto mt-10">
        
        <?php
        if (isset($_GET['lihat_pengumuman_id'])) {
            $view_notice_id = $_GET['lihat_pengumuman_id'];
            $notice_sql = "SELECT * FROM `pengumuman` WHERE `id_pengumuman` = $view_notice_id";
            $notice_result = $conn->query($notice_sql);
            
            if ($notice_result->num_rows > 0) {
                 $notice_row = $notice_result->fetch_assoc();

                // Fetch Class Name
                $class_name = "Semua Kelas";
                if($notice_row['p_id_kelas']){
                    $notice_class_id = $notice_row['p_id_kelas'];
                    $class_result = $conn->query("SELECT nama_kelas FROM kelas WHERE id_kelas = '$notice_class_id'");
                    if($class_row = $class_result->fetch_assoc()){
                        $class_name = $class_row['nama_kelas'];
                    }
                }
        ?>
            <!-- Header for back -->
            <div class="mb-6">
                 <a href="javascript:history.back()" class="inline-flex items-center text-gray-500 hover:text-gray-700 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            <!-- Detail Card -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <!-- Card Header -->
                <div class="bg-blue-600 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white mb-2"><?= htmlspecialchars($notice_row['judul_pengumuman']) ?></h1>
                    <div class="flex items-center space-x-4 text-blue-100 text-sm">
                         <span class="flex items-center">
                            <i class="far fa-calendar-alt mr-2"></i> <?= date('l, d F Y', strtotime($notice_row['tanggal_pengumuman'])) ?>
                         </span>
                         <span class="flex items-center">
                             <i class="far fa-user mr-2"></i> <?= htmlspecialchars($notice_row['pengirim']) ?>
                         </span>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="p-8">
                     <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full mb-6">
                        Target: <?= htmlspecialchars($class_name) ?>
                    </span>

                    <div class="prose max-w-none text-gray-700 leading-relaxed text-lg">
                        <?= nl2br(htmlspecialchars($notice_row['ket_pengumuman'])) ?>
                    </div>
                </div>
                
                 <!-- Card Footer -->
                <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 flex justify-end">
                    <!-- Optional: Add action buttons here if needed, or just keep it simple -->
                     <span class="text-sm text-gray-400">ID Pengumuman: #<?= $notice_row['id_pengumuman'] ?></span>
                </div>
            </div>

        <?php 
            } else {
                echo "<div class='text-center py-10 text-gray-500'>Pengumuman tidak ditemukan.</div>";
            }
        } 
        ?>

    </div>
</div>