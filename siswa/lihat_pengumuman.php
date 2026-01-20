<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg mt-14">
        
        <div class="mb-6">
             <a href="index.php?pengumuman" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Pengumuman
             </a>
        </div>

        <?php
        $id_pengumuman = isset($_GET['id']) ? $_GET['id'] : (isset($_GET['view_notice_id']) ? $_GET['view_notice_id'] : 0);
        
        // Secure Input
        $id_pengumuman = $conn->real_escape_string($id_pengumuman);

        $notice_sql = "SELECT * FROM `pengumuman` WHERE `id_pengumuman` = '$id_pengumuman'";
        $notice_result = $conn->query($notice_sql);
        
        if ($notice_result && $notice_result->num_rows > 0) {
            $notice = $notice_result->fetch_assoc();

            $is_global = is_null($notice['p_id_kelas']);
            $badge_class = $is_global ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800';
            $badge_text = $is_global ? 'Umum' : 'Kelas Pembelajaran';
        ?>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-4">
                 <h2 class="text-2xl font-bold text-white text-center uppercase tracking-wide"><?= htmlspecialchars($notice['judul_pengumuman']) ?></h2>
            </div>
            
            <div class="p-8">
                <div class="flex flex-wrap justify-between items-center mb-6">
                     <span class="<?= $badge_class ?> text-sm font-semibold px-3 py-1 rounded-full border border-opacity-20">
                        <?= $badge_text ?>
                     </span>
                     
                     <div class="flex items-center text-gray-500 text-sm mt-2 sm:mt-0">
                        <i class="far fa-calendar-alt mr-2"></i>
                        <?= date('d F Y', strtotime($notice['tanggal_pengumuman'])) ?>
                     </div>
                </div>

                <div class="prose max-w-none text-gray-700 leading-relaxed mb-8">
                    <?= nl2br($notice['ket_pengumuman']) // Assuming plain text, use nl2br. If HTML, just output. ?>
                </div>

                <div class="border-t border-gray-100 pt-6 flex justify-end items-center">
                    <div class="text-right">
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Diterbitkan Oleh</p>
                        <p class="text-sm font-bold text-gray-700 flex items-center justify-end">
                            <i class="fas fa-user-circle mr-2 text-blue-500 text-lg"></i>
                            <?= htmlspecialchars($notice['pengirim']) ?>
                        </p>
                    </div>
                </div>

            </div>
        </div>

        <?php 
        } else {
        ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                <p class="font-bold">Error</p>
                <p>Pengumuman tidak ditemukan atau telah dihapus.</p>
            </div>
        <?php } ?>

        <div class="h-20"></div>
    </div>
</div>