<div class="p-4 sm:ml-64">
    <div class="max-w-2xl mx-auto mt-10">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-edit text-yellow-500 mr-2"></i> Edit Absensi Siswa
            </h1>
        </div>

        <?php
        if (isset($_GET['edit_absensi_id'])) {
            $id = $_GET['edit_absensi_id'];
            $sql = "SELECT a.*, s.nama_siswa, s.id_sims, k.nama_kelas 
                    FROM `absensi` a 
                    JOIN `siswa` s ON a.a_id_siswa = s.id_siswa 
                    JOIN `kelas` k ON a.a_id_kelas = k.id_kelas
                    WHERE a.id_absensi = '$id'";
            $result = $conn->query($sql);
            
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
        ?>
        
        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100">
            <div class="p-6">
                <!-- Data Display -->
                <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                    <div>
                        <p class="text-gray-500">Nama Siswa</p>
                        <p class="font-semibold text-gray-900 text-lg"><?= htmlspecialchars($row['nama_siswa']) ?></p>
                        <p class="text-xs text-gray-400"><?= $row['id_sims'] ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-500">Kelas</p>
                        <p class="font-semibold text-gray-900"><?= htmlspecialchars($row['nama_kelas']) ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500">Tanggal Absensi</p>
                        <p class="font-semibold text-gray-900"><?= date('d F Y H:i', strtotime($row['tanggal_absensi'])) ?></p>
                    </div>
                </div>

                <form method="post" class="space-y-6">
                     <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">Status Kehadiran</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="status" value="Hadir" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500" <?= $row['status_absensi'] == 'Hadir' ? 'checked' : '' ?>>
                                <span class="ml-2 text-sm font-medium text-gray-900">Hadir</span>
                            </label>
                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="status" value="Izin" class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 focus:ring-yellow-500" <?= $row['status_absensi'] == 'Izin' ? 'checked' : '' ?>>
                                <span class="ml-2 text-sm font-medium text-gray-900">Izin</span>
                            </label>

                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" name="status" value="Alpha" class="w-4 h-4 text-red-600 bg-gray-100 border-gray-300 focus:ring-red-500" <?= $row['status_absensi'] == 'Alpha' ? 'checked' : '' ?>>
                                <span class="ml-2 text-sm font-medium text-gray-900">Alpha</span>
                            </label>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-2 border-t pt-4">
                        <a href="index.php?absensi" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">Batal</a>
                        <button type="submit" name="update_attendance" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <?php
            } else {
                echo "<div class='p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50' role='alert'>Data tidak ditemukan.</div>";
            }
        }
        ?>
    </div>
</div>

<?php
if (isset($_POST['update_attendance'])) {
    $status = $_POST['status'];
    $id = $_GET['edit_absensi_id'];
    
    $update_sql = "UPDATE `absensi` SET status_absensi = '$status' WHERE id_absensi = '$id'";
    
    if ($conn->query($update_sql)) {
         echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Status absensi diperbarui.',
                icon: 'success'
            }).then(() => {
                window.location.href = 'index.php?absensi';
            });
        </script>";
    } else {
        echo "<script>Swal.fire('Gagal!', 'Gagal memperbarui data.', 'error');</script>";
    }
}
?>