<?php
// Validate ID
$edit_id_ruangan = "";
if (isset($_GET['edit_id_ruangan'])) {
    $edit_id_ruangan = $_GET['edit_id_ruangan'];
} else {
    echo "<script>window.location.href = 'index.php?ruangan';</script>";
    exit;
}

// Update Logic
if (isset($_POST['update_room'])) {
    $nama_ruangan = $_POST['room_name'];
    $kapasitas_ruangan = $_POST['room_capacity'];
    $r_id_kelas = $_POST['room_class'];
    $r_id_seksi = isset($_POST['room_class_section']) ? $_POST['room_class_section'] : 0;
    
    if(empty($r_id_seksi)) $r_id_seksi = 0;

    $update_sql = "UPDATE `ruangan` SET 
        nama_ruangan = '$nama_ruangan', 
        kapasitas_ruangan = '$kapasitas_ruangan', 
        r_id_kelas = '$r_id_kelas', 
        r_id_seksi = '$r_id_seksi' 
        WHERE id_ruangan = '$edit_id_ruangan' ";
    
    if ($conn->query($update_sql)) {
         echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data Ruangan berhasil diperbarui!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'index.php?ruangan';
                });
            });
        </script>";
    } else {
         echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Gagal update ruangan: " . $conn->error . "',
                    icon: 'error'
                });
            });
        </script>";
    }
}

// Fetch Existing Data
$row = null;
if (!empty($edit_id_ruangan)) {
    $sql = "SELECT * FROM `ruangan` WHERE id_ruangan = '$edit_id_ruangan' ";
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
                <span class="bg-orange-100 text-orange-600 p-2 rounded-lg mr-3">
                    <i class="fas fa-edit text-lg"></i>
                </span>
                Edit Ruangan
            </h2>
            <a href="index.php?ruangan" class="text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </a>
        </div>
        
        <?php if ($row): ?>
        <form method="post" class="p-8">
             <div class="mb-4">
                <label for="room_name" class="block mb-2 text-sm font-semibold text-gray-700">Nama Ruangan</label>
                <input type="text" id="room_name" name="room_name" value="<?= htmlspecialchars($row['nama_ruangan']) ?>" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-orange-500 focus:border-orange-500 block w-full p-3 transition-all duration-200 hover:bg-white">
            </div>
            <div class="mb-4">
                <label for="room_capacity" class="block mb-2 text-sm font-semibold text-gray-700">Kapasitas</label>
                <input type="number" id="room_capacity" name="room_capacity" value="<?= htmlspecialchars($row['kapasitas_ruangan']) ?>" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-orange-500 focus:border-orange-500 block w-full p-3 transition-all duration-200 hover:bg-white">
            </div>

            <div class="mb-4">
                <label for="room_class" class="block mb-2 text-sm font-semibold text-gray-700">Pilih Kelas</label>
                <div class="relative">
                    <select id="room_class" name="room_class" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-orange-500 focus:border-orange-500 block w-full p-3 transition-all duration-200 hover:bg-white appearance-none">
                        <option value="">-- Pilih Kelas --</option>
                        <?php
                        $class_sql = "SELECT id_kelas, nama_kelas FROM `kelas` ORDER BY nama_kelas ASC";
                        $class_result = $conn->query($class_sql);
                        while ($class_row = $class_result->fetch_assoc()) {
                            $selected = ($class_row['id_kelas'] == $row['r_id_kelas']) ? 'selected' : '';
                        ?>
                            <option value="<?= $class_row['id_kelas'] ?>" <?= $selected ?>><?= htmlspecialchars($class_row['nama_kelas']) ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <div class="mb-5 <?= ($row['r_id_seksi'] == 0) ? 'hidden' : '' ?>" id="room_class_section_container">
                <label for="room_class_section" class="block mb-2 text-sm font-semibold text-gray-700">Pilih Jurusan</label>
                <div class="relative">
                    <select id="room_class_section" name="room_class_section" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-orange-500 focus:border-orange-500 block w-full p-3 transition-all duration-200 hover:bg-white appearance-none">
                        <option value="">-- Pilih Jurusan --</option>
                        <!-- Options populated via AJAX or PHP on load if possible -->
                        <?php 
                        // Pre-populate if class is selected
                        if ($row['r_id_kelas']) {
                             // Copied logic from ambil_seksi.php roughly just for initial render
                             $cid = $row['r_id_kelas'];
                             $c_res = $conn->query("SELECT nama_seksi FROM kelas WHERE id_kelas = '$cid'");
                             if($c_res->num_rows > 0) {
                                 $nama_seksi_ids = $c_res->fetch_assoc()['nama_seksi'];
                                 if(!empty($nama_seksi_ids)) {
                                     $s_res = $conn->query("SELECT id_seksi, judul_seksi FROM seksi WHERE id_seksi IN ($nama_seksi_ids)");
                                     while($s_row = $s_res->fetch_assoc()) {
                                         $sel = ($s_row['id_seksi'] == $row['r_id_seksi']) ? 'selected' : '';
                                         echo "<option value='".$s_row['id_seksi']."' $sel>".htmlspecialchars($s_row['judul_seksi'])."</option>";
                                     }
                                 }
                             }
                        }
                        ?>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>
            
            <div class="flex gap-3 justify-end mt-8">
                <a href="index.php?ruangan" class="px-6 py-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200">
                    Batal
                </a>
                <button type="submit" name="update_room" class="px-8 py-3 text-base font-bold text-white bg-gradient-to-r from-orange-500 to-red-600 rounded-xl hover:shadow-lg hover:from-orange-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i> Update
                </button>
            </div>
        </form>
        <?php else: ?>
             <div class="p-8 text-center text-gray-500">
                <i class="fas fa-exclamation-circle text-4xl text-gray-300 mb-3"></i>
                <p>Data ruangan tidak ditemukan.</p>
                <a href="index.php?ruangan" class="mt-4 inline-block text-blue-600 hover:underline">Kembali</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
$(document).ready(function() {
    // Reuse Ajax Logic
     $('#room_class').on('change', function() {
        var classId = $(this).val();
        var sectionSelect = $('#room_class_section');
        var sectionContainer = $('#room_class_section_container');

        if (classId !== '') {
            $.ajax({
                url: 'ambil_seksi.php',
                method: 'POST',
                data: { class_id: classId },
                dataType: 'json',
                success: function(data) {
                    sectionSelect.empty().append($('<option>', {
                        value: '',
                        text: '-- Pilih Jurusan --'
                    }));

                    if (data.length > 0) {
                        $.each(data, function(index, section) {
                            sectionSelect.append($('<option>', {
                                value: section.id_seksi,
                                text: section.judul_seksi 
                            }));
                        });
                        sectionContainer.removeClass('hidden');
                    } else {
                        sectionContainer.addClass('hidden');
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    sectionContainer.addClass('hidden');
                }
            });
        } else {
            sectionContainer.addClass('hidden');
            sectionSelect.empty();
        }
    });
});
</script>