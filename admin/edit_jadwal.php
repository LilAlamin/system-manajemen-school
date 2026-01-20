<?php
// Validate ID
$edit_id_jadwal = "";
if (isset($_GET['edit_id_jadwal'])) {
    $edit_id_jadwal = $_GET['edit_id_jadwal'];
} else {
    echo "<script>window.location.href = 'index.php?jadwal';</script>";
    exit;
}

// Update Logic
if (isset($_POST['update_timetable'])) {
    $j_id_guru = $_POST['timetable_teacher'];
    $j_id_kelas = $_POST['room_class'];
    $j_id_seksi = isset($_POST['room_class_section']) ? $_POST['room_class_section'] : 0;
    if(empty($j_id_seksi)) $j_id_seksi = 0;
    
    $j_id_sesi = $_POST['timetable_period'];
    $j_id_mapel = $_POST['timetable_subject'];
    $j_id_ruangan = $_POST['timetable_room'];
    $hari_jadwal = $_POST['timetable_day'];

    // Optional: Validation like in insert can be added here.
    // Simplifying for now to focus on functional update.

    $update_sql = "UPDATE `jadwal` SET 
        j_id_guru = '$j_id_guru', 
        j_id_kelas = '$j_id_kelas', 
        j_id_seksi = '$j_id_seksi', 
        j_id_sesi = '$j_id_sesi', 
        j_mapel_id = '$j_id_mapel', 
        j_id_ruangan = '$j_id_ruangan', 
        hari_jadwal = '$hari_jadwal'
        WHERE id_jadwal = '$edit_id_jadwal' ";
    
    if ($conn->query($update_sql)) {
         echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Jadwal berhasil diperbarui!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'index.php?jadwal';
                });
            });
        </script>";
    } else {
         echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Gagal!',
                    text: 'Gagal update jadwal: " . $conn->error . "',
                    icon: 'error'
                });
            });
        </script>";
    }
}

// Fetch Existing Data
$row = null;
if (!empty($edit_id_jadwal)) {
    $sql = "SELECT * FROM `jadwal` WHERE id_jadwal = '$edit_id_jadwal' ";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    }
}
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-8 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
             <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <span class="bg-green-100 text-green-600 p-2 rounded-lg mr-3">
                    <i class="fas fa-edit text-lg"></i>
                </span>
                Edit Jadwal Pelajaran
            </h2>
            <a href="index.php?jadwal" class="text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </a>
        </div>
        
        <?php if ($row): ?>
        <form method="post" class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                
                <!-- Kelas -->
                <div>
                    <label for="room_class" class="block mb-2 text-sm font-semibold text-gray-700">Pilih Kelas</label>
                    <div class="relative">
                        <select id="room_class" name="room_class" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block w-full p-3 transition-all duration-200 hover:bg-white appearance-none">
                            <option value="">-- Pilih Kelas --</option>
                            <?php
                            $class_res = $conn->query("SELECT id_kelas, nama_kelas FROM kelas ORDER BY nama_kelas ASC");
                            while ($r = $class_res->fetch_assoc()) {
                                $sel = ($r['id_kelas'] == $row['j_id_kelas']) ? 'selected' : '';
                                echo "<option value='{$r['id_kelas']}' $sel>{$r['nama_kelas']}</option>";
                            }
                            ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Jurusan (Conditional) -->
                <div id="room_class_section_container" class="<?= ($row['j_id_seksi'] == 0) ? 'hidden' : '' ?>">
                    <label for="room_class_section" class="block mb-2 text-sm font-semibold text-gray-700">Pilih Jurusan</label>
                    <div class="relative">
                        <select id="room_class_section" name="room_class_section" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block w-full p-3 transition-all duration-200 hover:bg-white appearance-none">
                            <option value="">-- Pilih Jurusan --</option>
                            <?php 
                            // Pre-populate if class is selected
                            if ($row['j_id_kelas']) {
                                 $cid = $row['j_id_kelas'];
                                 $c_res = $conn->query("SELECT nama_seksi FROM kelas WHERE id_kelas = '$cid'");
                                 if($c_res->num_rows > 0) {
                                     $nama_seksi_ids = $c_res->fetch_assoc()['nama_seksi'];
                                     if(!empty($nama_seksi_ids)) {
                                         $s_res = $conn->query("SELECT id_seksi, judul_seksi FROM seksi WHERE id_seksi IN ($nama_seksi_ids)");
                                         while($s_row = $s_res->fetch_assoc()) {
                                             $sel = ($s_row['id_seksi'] == $row['j_id_seksi']) ? 'selected' : '';
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

                <!-- Guru -->
                <div>
                    <label for="timetable_teacher" class="block mb-2 text-sm font-semibold text-gray-700">Pilih Guru</label>
                    <div class="relative">
                        <select id="timetable_teacher" name="timetable_teacher" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block w-full p-3 transition-all duration-200 hover:bg-white appearance-none">
                            <option value="">-- Pilih Guru --</option>
                            <?php
                            $guru_res = $conn->query("SELECT id_guru, nama_guru FROM guru WHERE status_guru='Aktif' ORDER BY nama_guru ASC");
                            while ($r = $guru_res->fetch_assoc()) {
                                $sel = ($r['id_guru'] == $row['j_id_guru']) ? 'selected' : '';
                                echo "<option value='{$r['id_guru']}' $sel>{$r['nama_guru']}</option>";
                            }
                            ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Sesi -->
                <div>
                    <label for="timetable_period" class="block mb-2 text-sm font-semibold text-gray-700">Pilih Sesi</label>
                    <div class="relative">
                        <select id="timetable_period" name="timetable_period" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block w-full p-3 transition-all duration-200 hover:bg-white appearance-none">
                            <option value="">-- Pilih Sesi --</option>
                            <?php
                            $sesi_res = $conn->query("SELECT id_sesi, nama_sesi, jam_mulai_sesi FROM sesi ORDER BY jam_mulai_sesi ASC");
                            while ($r = $sesi_res->fetch_assoc()) {
                                $sel = ($r['id_sesi'] == $row['j_id_sesi']) ? 'selected' : '';
                                echo "<option value='{$r['id_sesi']}' $sel>{$r['nama_sesi']} ({$r['jam_mulai_sesi']})</option>";
                            }
                            ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                 <!-- Ruangan -->
                <div>
                    <label for="timetable_room" class="block mb-2 text-sm font-semibold text-gray-700">Pilih Ruangan</label>
                    <div class="relative">
                        <select id="timetable_room" name="timetable_room" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block w-full p-3 transition-all duration-200 hover:bg-white appearance-none">
                            <option value="">-- Pilih Ruangan --</option>
                            <?php
                            $room_res = $conn->query("SELECT id_ruangan, nama_ruangan FROM ruangan ORDER BY nama_ruangan ASC");
                            while ($r = $room_res->fetch_assoc()) {
                                $sel = ($r['id_ruangan'] == $row['j_id_ruangan']) ? 'selected' : '';
                                echo "<option value='{$r['id_ruangan']}' $sel>{$r['nama_ruangan']}</option>";
                            }
                            ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                 <!-- Mapel -->
                <div>
                    <label for="timetable_subject" class="block mb-2 text-sm font-semibold text-gray-700">Pilih Mapel</label>
                    <div class="relative">
                        <select id="timetable_subject" name="timetable_subject" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block w-full p-3 transition-all duration-200 hover:bg-white appearance-none">
                            <option value="">-- Pilih Mapel --</option>
                            <?php
                            $mapel_res = $conn->query("SELECT id_mapel, nama_mapel FROM mapel ORDER BY nama_mapel ASC");
                            while ($r = $mapel_res->fetch_assoc()) {
                                $sel = ($r['id_mapel'] == $row['j_mapel_id']) ? 'selected' : '';
                                echo "<option value='{$r['id_mapel']}' $sel>{$r['nama_mapel']}</option>";
                            }
                            ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                 <!-- Hari -->
                <div>
                    <label for="timetable_day" class="block mb-2 text-sm font-semibold text-gray-700">Pilih Hari</label>
                    <div class="relative">
                        <select id="timetable_day" name="timetable_day" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block w-full p-3 transition-all duration-200 hover:bg-white appearance-none">
                            <option value="">-- Pilih Hari --</option>
                            <?php
                            $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
                             $days_indo = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
                            foreach ($days as $index => $day) {
                                $sel = ($day == $row['hari_jadwal']) ? 'selected' : '';
                                 echo "<option value='$day' $sel>{$days_indo[$index]} ($day)</option>";
                            }
                            ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="flex gap-3 justify-end border-t border-gray-100 pt-6">
                <a href="index.php?jadwal" class="px-6 py-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                    Batal
                </a>
                <button type="submit" name="update_timetable" class="px-8 py-3 text-base font-bold text-white bg-gradient-to-r from-green-500 to-teal-600 rounded-xl hover:shadow-lg hover:from-green-600 hover:to-teal-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i> Update Jadwal
                </button>
            </div>
        </form>
        <?php else: ?>
             <div class="p-8 text-center text-gray-500">
                <i class="fas fa-exclamation-circle text-4xl text-gray-300 mb-3"></i>
                <p>Data jadwal tidak ditemukan.</p>
                <a href="index.php?jadwal" class="mt-4 inline-block text-blue-600 hover:underline">Kembali</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
$(document).ready(function() {
    // AJAX for Section
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
                error: function() {
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