<?php
// Update Mapel Logic
$edit_id_mapel = "";
if (isset($_GET['edit_id_mapel'])) {
    $edit_id_mapel = $_GET['edit_id_mapel'];
} else {
    echo "<script>window.location.href = 'index.php?mapel';</script>";
    exit;
}

if (isset($_POST['update_subject'])) {
    $kode_mapel = $_POST['subject_code'];
    $nama_mapel = $_POST['subject_name'];
    
    $update_sql = "UPDATE `mapel` SET 
        kode_mapel = '$kode_mapel', 
        nama_mapel = '$nama_mapel' 
        WHERE id_mapel = '$edit_id_mapel' ";
    
    if ($conn->query($update_sql)) {
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data Mapel berhasil diperbarui!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'index.php?mapel';
                });
            });
        </script>";
    } else {
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Gagal memperbarui data: " . $conn->error . "',
                    icon: 'error'
                });
            });
        </script>";
    }
}

// Fetch existing data
$row = null;
if (!empty($edit_id_mapel)) {
    $sql = "SELECT * FROM `mapel` WHERE id_mapel = '$edit_id_mapel' ";
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
                <span class="bg-yellow-100 text-yellow-600 p-2 rounded-lg mr-3">
                    <i class="fas fa-edit text-lg"></i>
                </span>
                Edit Mata Pelajaran
            </h2>
            <a href="index.php?mapel" class="text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </a>
        </div>
        
        <?php if ($row): ?>
        <form method="post" class="p-8">
            <div class="mb-4">
                <label for="subject_code" class="block mb-2 text-sm font-semibold text-gray-700">Kode Mapel</label>
                <input type="text" id="subject_code" name="subject_code" value="<?= htmlspecialchars($row['kode_mapel']) ?>" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block w-full p-3 transition-all duration-200 hover:bg-white">
            </div>
            
            <div class="mb-6">
                <label for="subject_name" class="block mb-2 text-sm font-semibold text-gray-700">Nama Mapel</label>
                <input type="text" id="subject_name" name="subject_name" value="<?= htmlspecialchars($row['nama_mapel']) ?>" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block w-full p-3 transition-all duration-200 hover:bg-white">
            </div>
            
            <div class="flex gap-3 justify-end mt-8">
                <a href="index.php?mapel" class="px-6 py-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-200">
                    Batal
                </a>
                <button type="submit" name="update_subject" class="px-8 py-3 text-base font-bold text-white bg-gradient-to-r from-yellow-500 to-orange-500 rounded-xl hover:shadow-lg hover:from-yellow-600 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i> Update
                </button>
            </div>
        </form>
        <?php else: ?>
            <div class="p-8 text-center text-gray-500">
                <i class="fas fa-exclamation-circle text-4xl text-gray-300 mb-3"></i>
                <p>Data mapel tidak ditemukan.</p>
                <a href="index.php?mapel" class="mt-4 inline-block text-blue-600 hover:underline">Kembali</a>
            </div>
        <?php endif; ?>
    </div>
</div>