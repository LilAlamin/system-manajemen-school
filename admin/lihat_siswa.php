<?php
if (isset($_GET['lihat_id_siswa'])) {
    $id_siswa = $_GET['lihat_id_siswa'];
    $sql = "SELECT siswa.*, kelas.nama_kelas, seksi.judul_seksi 
            FROM siswa 
            LEFT JOIN kelas ON siswa.kelas_siswa = kelas.id_kelas 
            LEFT JOIN seksi ON siswa.seksi_siswa = seksi.id_seksi 
            WHERE siswa.id_siswa = '$id_siswa'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "<script>window.location.href = 'index.php?siswa';</script>";
        exit;
    }
} else {
   echo "<script>window.location.href = 'index.php?siswa';</script>";
   exit;
}
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-8 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <span class="bg-blue-100 text-blue-600 p-2 rounded-lg mr-3">
                    <i class="fas fa-id-card text-lg"></i>
                </span>
                Detail Siswa
            </h2>
            <a href="index.php?siswa" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 rounded-xl hover:bg-gray-50 text-sm font-medium transition-colors shadow-sm">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        <div class="p-8">
            <div class="flex flex-col md:flex-row gap-8">
                <!-- Foto Section -->
                <div class="w-full md:w-1/3 flex flex-col items-center">
                    <div class="relative group">
                        <?php if (!empty($row['foto_siswa'])): ?>
                            <div class="w-48 h-48 rounded-full overflow-hidden shadow-2xl border-4 border-white ring-1 ring-gray-100">
                                <img src="admin_images/registration/<?= htmlspecialchars($row['foto_siswa']) ?>" alt="Foto Siswa" class="w-full h-full object-cover transform transition duration-500 group-hover:scale-110">
                            </div>
                        <?php else: ?>
                            <div class="w-48 h-48 rounded-full bg-blue-50 flex items-center justify-center text-blue-300 shadow-inner border-4 border-white ring-1 ring-gray-100">
                                <i class="fas fa-user fa-6x"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="absolute bottom-2 right-4">
                            <?php if ($row['status_siswa'] == 'Aktif'): ?>
                                <span class="flex items-center justify-center w-8 h-8 bg-green-500 rounded-full text-white border-2 border-white shadow-md" title="Aktif">
                                    <i class="fas fa-check text-xs"></i>
                                </span>
                            <?php else: ?>
                                <span class="flex items-center justify-center w-8 h-8 bg-red-500 rounded-full text-white border-2 border-white shadow-md" title="Non-Aktif">
                                    <i class="fas fa-times text-xs"></i>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="mt-6 text-center">
                        <h3 class="text-xl font-bold text-gray-800"><?= htmlspecialchars($row['nama_siswa']) ?></h3>
                        <p class="text-blue-600 font-medium"><?= htmlspecialchars($row['id_sims']) ?></p>
                        <div class="mt-3">
                             <?php if ($row['status_siswa'] == 'Aktif'): ?>
                                <span class="bg-green-100 text-green-700 text-sm font-medium px-4 py-1.5 rounded-full ring-1 ring-green-600/20">
                                    Status: Aktif
                                </span>
                            <?php else: ?>
                                <span class="bg-red-100 text-red-700 text-sm font-medium px-4 py-1.5 rounded-full ring-1 ring-red-600/20">
                                    Status: Non-Aktif
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="w-full md:w-2/3">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8">
                        <div class="bg-gray-50/50 p-4 rounded-xl border border-gray-100">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Kelas</p>
                            <p class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($row['nama_kelas'] ?? '-') ?></p>
                        </div>
                        <div class="bg-gray-50/50 p-4 rounded-xl border border-gray-100">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Seksi / Bagian</p>
                            <p class="text-lg font-semibold text-gray-800"><?= htmlspecialchars($row['judul_seksi'] ?? '-') ?></p>
                        </div>
                        
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Email</p>
                            <p class="text-base font-semibold text-gray-800 break-all"><?= htmlspecialchars($row['email_siswa']) ?></p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Telepon</p>
                            <p class="text-base font-semibold text-gray-800"><?= htmlspecialchars($row['telepon_siswa']) ?></p>
                        </div>
                         <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Jenis Kelamin</p>
                             <div class="flex items-center">
                                <?php if ($row['jekel_siswa'] == 'Laki_Laki' || $row['jekel_siswa'] == 'Laki-Laki'): ?>
                                    <i class="fas fa-mars text-blue-500 mr-2"></i>
                                    <span class="text-base text-gray-800">Laki-Laki</span>
                                <?php else: ?>
                                    <i class="fas fa-venus text-pink-500 mr-2"></i>
                                    <span class="text-base text-gray-800">Perempuan</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Tanggal Lahir</p>
                            <p class="text-base font-semibold text-gray-800">
                                <i class="far fa-calendar-alt text-gray-400 mr-2"></i>
                                <?= date('d M Y', strtotime($row['tanggal_lahir_siswa'])) ?>
                            </p>
                        </div>
                         <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Umur</p>
                            <p class="text-base font-semibold text-gray-800"><?= htmlspecialchars($row['umur_siswa']) ?> Tahun</p>
                        </div>
                         <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">NIK Orang Tua</p>
                            <?php if (!empty($row['nik_ortu'])): ?>
                                <p class="text-base font-semibold text-gray-800 font-mono"><?= htmlspecialchars($row['nik_ortu']) ?></p>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-exclamation-circle mr-1"></i> Belum terhubung dengan Orang Tua
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="md:col-span-2">
                             <p class="text-sm font-medium text-gray-500 mb-1">Alamat Lengkap</p>
                            <p class="text-base text-gray-800 bg-gray-50 p-3 rounded-lg border border-gray-100"><?= htmlspecialchars($row['alamat_siswa']) ?></p>
                        </div>
                         <div class="md:col-span-2 flex items-center text-sm text-gray-400 mt-2">
                            <i class="fas fa-clock mr-2"></i>
                            Terdaftar sejak: <?= date('d F Y, H:i', strtotime($row['tanggal_regis_siswa'])) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-8 py-5 bg-gray-50/50 border-t border-gray-100 flex justify-end">
             <a href="index.php?edit_id_siswa=<?= $row['id_siswa'] ?>" class="inline-flex items-center px-6 py-3 bg-yellow-400 hover:bg-yellow-500 text-white font-bold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                <i class="fas fa-user-edit mr-2"></i> Edit Data Siswa
            </a>
        </div>
    </div>
</div>