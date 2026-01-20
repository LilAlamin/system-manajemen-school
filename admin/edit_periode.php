<?php
// Validate ID
$edit_id_periode = "";
if (isset($_GET['edit_id_periode'])) {
    $edit_id_periode = $_GET['edit_id_periode'];
} else {
    echo "<script>window.location.href = 'index.php?periode';</script>";
    exit;
}

// Update Logic
if (isset($_POST['update_period'])) {
    $nama_sesi = $_POST['period_name'];
    $jam_mulai_sesi = $_POST['period_start_time'];
    $jam_berakhir_sesi = $_POST['period_end_time'];

    $update_sql = "UPDATE `sesi` SET 
        nama_sesi = '$nama_sesi', 
        jam_mulai_sesi = '$jam_mulai_sesi', 
        jam_berakhir_sesi = '$jam_berakhir_sesi' 
        WHERE id_sesi = '$edit_id_periode' ";
    
    if ($conn->query($update_sql)) {
         echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data Sesi berhasil diperbarui!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'index.php?periode';
                });
            });
        </script>";
    } else {
         echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Gagal update sesi: " . $conn->error . "',
                    icon: 'error'
                });
            });
        </script>";
    }
}

// Fetch Existing Data
$row = null;
if (!empty($edit_id_periode)) {
    $sql = "SELECT * FROM `sesi` WHERE id_sesi = '$edit_id_periode' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-8 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <span class="bg-pink-100 text-pink-600 p-2 rounded-lg mr-3">
                    <i class="fas fa-edit text-lg"></i>
                </span>
                Edit Sesi/Periode
            </h2>
            <a href="index.php?periode" class="text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </a>
        </div>
        
        <?php if ($row): ?>
        <form method="post" class="p-8">
            <div class="mb-4">
                <label for="period_name" class="block mb-2 text-sm font-semibold text-gray-700">Nama Sesi</label>
                <input type="text" id="period_name" name="period_name" value="<?= htmlspecialchars($row['nama_sesi']) ?>" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block w-full p-3 transition-all duration-200 hover:bg-white">
            </div>
             <div class="mb-4">
                <label for="period_start_time" class="block mb-2 text-sm font-semibold text-gray-700">Jam Mulai</label>
                <input type="time" id="period_start_time" name="period_start_time" value="<?= htmlspecialchars($row['jam_mulai_sesi']) ?>" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block w-full p-3 transition-all duration-200 hover:bg-white">
            </div>
            <div class="mb-5">
                <label for="period_end_time" class="block mb-2 text-sm font-semibold text-gray-700">Jam Selesai</label>
                <input type="time" id="period_end_time" name="period_end_time" value="<?= htmlspecialchars($row['jam_berakhir_sesi']) ?>" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block w-full p-3 transition-all duration-200 hover:bg-white">
            </div>
            
            <div class="flex gap-3 justify-end mt-8">
                <a href="index.php?periode" class="px-6 py-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all duration-200">
                    Batal
                </a>
                <button type="submit" name="update_period" class="px-8 py-3 text-base font-bold text-white bg-gradient-to-r from-pink-500 to-rose-600 rounded-xl hover:shadow-lg hover:from-pink-600 hover:to-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i> Update
                </button>
            </div>
        </form>
        <?php else: ?>
             <div class="p-8 text-center text-gray-500">
                <i class="fas fa-exclamation-circle text-4xl text-gray-300 mb-3"></i>
                <p>Data sesi tidak ditemukan.</p>
                <a href="index.php?periode" class="mt-4 inline-block text-blue-600 hover:underline">Kembali</a>
            </div>
        <?php endif; ?>
    </div>
</div>