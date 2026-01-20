<?php
// Validasi ID
$edit_id_kelas = "";
if (isset($_GET['edit_id_kelas'])) {
    $edit_id_kelas = $_GET['edit_id_kelas'];
} else {
    echo "<script>window.location.href = 'index.php?kelas';</script>";
    exit;
}

// Logic Update
if (isset($_POST['update_class'])) {
    $nama_kelas = $_POST['class_name'];
    
    // Handle multiple subjects
    $nama_mapel = "";
    if (isset($_POST['subject_name']) && is_array($_POST['subject_name'])) {
        $nama_mapel = implode(',', $_POST['subject_name']);
    }
    
    // Handle wali kelas
    $k_id_guru = $_POST['teacher_name'];

    // Handle multiple sections (jurusan)
    $nama_seksi = "";
    if (isset($_POST['section_name']) && is_array($_POST['section_name'])) {
        $nama_seksi = implode(',', $_POST['section_name']);
    }

    $update_sql = "UPDATE `kelas` SET 
        nama_kelas = '$nama_kelas', 
        nama_mapel = '$nama_mapel', 
        nama_seksi = '$nama_seksi', 
        k_id_guru = '$k_id_guru' 
        WHERE id_kelas = '$edit_id_kelas' ";
    
    if ($conn->query($update_sql)) {
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data Kelas berhasil diperbarui!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'index.php?kelas';
                });
            });
        </script>";
    } else {
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Gagal update kelas: " . $conn->error . "',
                    icon: 'error'
                });
            });
        </script>";
    }
}

// Fetch Existing Data
$row = null;
if (!empty($edit_id_kelas)) {
    $sql = "SELECT * FROM `kelas` WHERE id_kelas = '$edit_id_kelas' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}

// Prepare arrays for checking checked boxes
$current_mapel_ids = [];
$current_seksi_ids = [];

if ($row) {
    if (!empty($row['nama_mapel'])) {
        $current_mapel_ids = explode(',', $row['nama_mapel']);
        // cleaning whitespace just in case
        $current_mapel_ids = array_map('trim', $current_mapel_ids);
    }
    if (!empty($row['nama_seksi'])) {
        $current_seksi_ids = explode(',', $row['nama_seksi']);
        $current_seksi_ids = array_map('trim', $current_seksi_ids);
    }
}
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-8 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <span class="bg-yellow-100 text-yellow-600 p-2 rounded-lg mr-3">
                    <i class="fas fa-edit text-lg"></i>
                </span>
                Edit Data Kelas
            </h2>
            <a href="index.php?kelas" class="text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </a>
        </div>
        
        <?php if ($row): ?>
        <form method="post" class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Nama Kelas -->
                <div class="col-span-1 md:col-span-2">
                    <label for="class_name" class="block mb-2 text-sm font-semibold text-gray-700">Nama Kelas</label>
                    <input type="text" id="class_name" name="class_name" value="<?= htmlspecialchars($row['nama_kelas']) ?>" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block w-full p-3 transition-all duration-200 hover:bg-white">
                </div>

                <!-- Wali Kelas -->
                <div class="col-span-1 md:col-span-2">
                    <label for="teacher_name" class="block mb-2 text-sm font-semibold text-gray-700">Wali Kelas</label>
                    <div class="relative">
                        <select id="teacher_name" name="teacher_name" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-yellow-500 focus:border-yellow-500 block w-full p-3 transition-all duration-200 hover:bg-white appearance-none">
                            <option value="">-- Pilih Wali Kelas --</option>
                            <?php
                            $teacher_sql = "SELECT id_guru, nama_guru FROM `guru` WHERE status_guru = 'Aktif' ORDER BY nama_guru ASC";
                            $teacher_result = $conn->query($teacher_sql);
                            while ($teacher_row = $teacher_result->fetch_assoc()) {
                                $selected = ($teacher_row['id_guru'] == $row['k_id_guru']) ? 'selected' : '';
                            ?>
                                <option value="<?= $teacher_row['id_guru'] ?>" <?= $selected ?>><?= htmlspecialchars($teacher_row['nama_guru']) ?></option>
                            <?php
                            }
                            ?>
                        </select>
                         <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Jurusan (Sections) - Checkboxes -->
                <div class="col-span-1">
                    <label class="block mb-3 text-sm font-semibold text-gray-700">Pilih Jurusan (Seksi)</label>
                    <div class="bg-gray-50 rounded-xl border border-gray-200 p-4 max-h-60 overflow-y-auto">
                        <div class="space-y-3">
                            <?php
                            $section_sql = "SELECT * FROM `seksi` ORDER BY judul_seksi ASC";
                            $section_result = $conn->query($section_sql);
                            if ($section_result && $section_result->num_rows > 0) {
                                while ($section_row = $section_result->fetch_assoc()) {
                                    $checked = (in_array($section_row['id_seksi'], $current_seksi_ids)) ? 'checked' : '';
                            ?>
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="checkbox" name="section_name[]" value="<?= $section_row['id_seksi'] ?>" class="w-5 h-5 text-yellow-600 bg-white border-gray-300 rounded focus:ring-yellow-500 focus:ring-2 transition duration-150 ease-in-out" <?= $checked ?>>
                                    <span class="text-sm text-gray-700 group-hover:text-yellow-700 transition-colors"><?= htmlspecialchars($section_row['judul_seksi']) ?></span>
                                </label>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Mapel (Subjects) - Checkboxes -->
                <div class="col-span-1">
                    <label class="block mb-3 text-sm font-semibold text-gray-700">Pilih Mata Pelajaran</label>
                    <div class="bg-gray-50 rounded-xl border border-gray-200 p-4 max-h-60 overflow-y-auto">
                        <div class="space-y-3">
                            <?php
                            $subject_sql = "SELECT * FROM `mapel` ORDER BY nama_mapel ASC";
                            $subject_result = $conn->query($subject_sql);
                            if ($subject_result && $subject_result->num_rows > 0) {
                                while ($subject_row = $subject_result->fetch_assoc()) {
                                    $checked = (in_array($subject_row['id_mapel'], $current_mapel_ids)) ? 'checked' : '';
                            ?>
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="checkbox" name="subject_name[]" value="<?= $subject_row['id_mapel'] ?>" class="w-5 h-5 text-purple-600 bg-white border-gray-300 rounded focus:ring-purple-500 focus:ring-2 transition duration-150 ease-in-out" <?= $checked ?>>
                                    <span class="text-sm text-gray-700 group-hover:text-purple-700 transition-colors">
                                        <?= htmlspecialchars($subject_row['nama_mapel']) ?> 
                                        <span class="text-xs text-gray-400 ml-1">(<?= htmlspecialchars($subject_row['kode_mapel']) ?>)</span>
                                    </span>
                                </label>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="flex gap-3 justify-end mt-8 border-t border-gray-100 pt-6">
                <a href="index.php?kelas" class="px-6 py-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-200">
                    Batal
                </a>
                <button type="submit" name="update_class" class="px-8 py-3 text-base font-bold text-white bg-gradient-to-r from-yellow-500 to-orange-500 rounded-xl hover:shadow-lg hover:from-yellow-600 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i> Update Kelas
                </button>
            </div>
        </form>
        <?php else: ?>
            <div class="p-8 text-center text-gray-500">
                <i class="fas fa-exclamation-circle text-4xl text-gray-300 mb-3"></i>
                <p>Data kelas tidak ditemukan.</p>
                <a href="index.php?kelas" class="mt-4 inline-block text-blue-600 hover:underline">Kembali</a>
            </div>
        <?php endif; ?>
    </div>
</div>