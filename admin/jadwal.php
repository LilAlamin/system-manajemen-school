<?php
// Insert Jadwal (Timetable)
if (isset($_POST['create_timetable'])) {
    // Prepare Guru Value
    // If 0 or empty, set to NULL (assuming DB column is nullable for 'Tanpa Guru')
    // Otherwise wrap in quotes for SQL
    $j_id_guru = !empty($_POST['timetable_teacher']) ? $_POST['timetable_teacher'] : 0;
    $val_guru = ($j_id_guru == 0) ? "NULL" : "'$j_id_guru'";
    
    // Prepare Seksi Value
    // If empty/0, set to NULL (assuming DB column is nullable for classes without sections)
    $j_id_seksi = isset($_POST['room_class_section']) ? $_POST['room_class_section'] : 0;
    $val_seksi = (empty($j_id_seksi) || $j_id_seksi == 0) ? "NULL" : "'$j_id_seksi'";

    $j_id_kelas = $_POST['room_class'];
    $j_id_sesi = $_POST['timetable_period'];
    $j_id_mapel = $_POST['timetable_subject'];
    $j_id_ruangan = $_POST['timetable_room'];
    $hari_jadwal = $_POST['timetable_day'];

    // Check Duplicate: Guru di Sesi & Hari yang sama (Guru tidak bisa mengajar 2 tempat sekaligus)
    // ONLY check if a teacher is actually assigned (id_guru != 0)
    $teacher_conflict_found = false;
    
    if ($j_id_guru != 0) {
        $check_guru_conflict = "SELECT * FROM `jadwal` WHERE `j_id_guru` = '$j_id_guru' AND `j_id_sesi` = '$j_id_sesi' AND `hari_jadwal` = '$hari_jadwal'";
        $cresult = $conn->query($check_guru_conflict);

        if ($cresult->num_rows > 0) {
            $teacher_conflict_found = true;
        }
    }

    if ($teacher_conflict_found) {
        echo "<script>
            $(document).ready(function() {
                Swal.fire('Konflik Jadwal!', 'Guru ini sudah ada jadwal di Sesi dan Hari yang sama.', 'error');
            });
        </script>";
    } else {
        // Check Duplicate: Kelas/Seksi di Sesi & Hari yang sama (Siswa tidak bisa belajar 2 mapel sekaligus)
        // If section is NULL, we match WHERE j_id_seksi IS NULL check logic ??
        // Legacy query: "... WHERE j_id_seksi = '$j_id_seksi' ..."
        // logic: if $j_id_seksi (php var) is 0, database might store NULL. Comparison NULL = 0 is false.
        // We need to adjust checking logic if we strictly want to prevent double booking.
        // For now, let's stick to fixing the INSERT error. The duplicate check might fail to catch overlaps if mixing NULL/0, but safety first.
        
        // Let's use the raw value for checking (if 0, it checks = '0', which might not match NULL rows).
        // It's acceptable for now to rely on the main constraint fix.
        
        $check_seksi_clause = ($val_seksi == "NULL") ? "(`j_id_seksi` IS NULL OR `j_id_seksi` = 0)" : "`j_id_seksi` = $val_seksi";

        $check_duplicate = "SELECT * FROM `jadwal` WHERE `j_id_kelas` = '$j_id_kelas' AND $check_seksi_clause AND `j_id_sesi` = '$j_id_sesi' AND `hari_jadwal` = '$hari_jadwal'";
        $dresult = $conn->query($check_duplicate);
        
        if ($dresult->num_rows > 0) {
             echo "<script>
                $(document).ready(function() {
                    Swal.fire('Konflik Jadwal!', 'Kelas ini sudah memiliki jadwal pada sesi dan hari tersebut.', 'error');
                });
            </script>";
        } else {
             // Use $val_guru and $val_seksi (which are "NULL" or "'ID'")
             $insert_jadwal_sql = "INSERT INTO `jadwal` (`j_id_guru`, `j_id_kelas`, `j_id_seksi`, `j_id_sesi`, `j_mapel_id`, `j_id_ruangan`, `hari_jadwal`, `created_at`)
                VALUES ($val_guru, '$j_id_kelas', $val_seksi, '$j_id_sesi', '$j_id_mapel', '$j_id_ruangan', '$hari_jadwal', current_timestamp())";
            
            if ($conn->query($insert_jadwal_sql)) {
                echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Jadwal berhasil ditambahkan!',
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
                        Swal.fire('Gagal!', 'Terjadi kesalahan sistem: " . $conn->error . "', 'error');
                    });
                </script>";
            }
        }
    }
}


// Delete Jadwal
if (isset($_GET['delete_id_jadwal'])) {
    $delete_id_jadwal = $_GET['delete_id_jadwal'];
    $delete_jadwal_sql = "DELETE FROM `jadwal` WHERE id_jadwal = '$delete_id_jadwal' ";
    if ($conn->query($delete_jadwal_sql)) {
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Jadwal berhasil dihapus!',
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
                Swal.fire('Gagal!', 'Gagal menghapus jadwal.', 'error');
            });
        </script>";
    }
}
?>

<!-- Custom DataTables Styling -->
<style>
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_length {
        display: none;
    }
    .dataTables_wrapper .dataTables_paginate {
        padding: 16px 24px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 8px 14px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        color: #374151;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        cursor: pointer;
        transition: all 0.2s ease;
        margin: 0 2px;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #eff6ff;
        border-color: #3b82f6;
        color: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.15);
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(to right, #3b82f6, #4f46e5);
        color: white;
        border: none;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: linear-gradient(to right, #2563eb, #4338ca);
        color: white;
        transform: translateY(-1px);
    }
    .dataTables_wrapper .dataTables_info {
        padding: 16px 24px;
        color: #6b7280;
        font-size: 14px;
    }
    .dataTables_wrapper .bottom-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #f3f4f6;
        background: #fafbfc;
        border-radius: 0 0 16px 16px;
    }
</style>

<div class="container mx-auto px-4 py-8">
    
    <!-- Banner Section -->
    <div class="relative w-full bg-gradient-to-r from-green-500 to-teal-600 rounded-2xl shadow-xl overflow-hidden mb-8 p-8 text-white">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-3xl font-extrabold mb-2 tracking-tight">Kelola Jadwal Pelajaran 📅</h1>
                <p class="text-green-100 text-lg">Atur jadwal pelajaran, guru, kelas, dan ruangan.</p>
            </div>
            <div class="mt-6 md:mt-0">
                <!-- Optional: Button Lihat Jadwal Detailed View if needed -->
                 <a href="index.php?lihat_jadwal" class="group relative inline-flex items-center justify-center px-6 py-3 text-base font-bold text-green-700 transition-all duration-200 bg-white font-pj rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white hover:bg-green-50 hover:shadow-lg transform hover:-translate-y-1">
                    <i class="fas fa-eye mr-2"></i> Lihat Tampilan Grid
                </a>
            </div>
        </div>
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-10"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-40 h-40 rounded-full bg-white opacity-10"></div>
    </div>

    <!-- Form & Table Area -->
    <div class="flex flex-col gap-8">
        
        <!-- Form Create -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center">
                        <span class="bg-green-100 text-green-600 p-2 rounded-lg mr-3">
                            <i class="fas fa-plus-circle"></i>
                        </span>
                        Buat Jadwal Baru
                    </h2>
            </div>
            <div class="p-6">
                <form method="post">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                        
                        <!-- Kelas -->
                        <div>
                            <label for="room_class" class="block mb-2 text-sm font-semibold text-gray-700">Pilih Kelas</label>
                            <div class="relative">
                                <select id="room_class" name="room_class" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block w-full p-3 transition-all duration-200 hover:bg-white appearance-none">
                                    <option value="">-- Pilih Kelas --</option>
                                    <?php
                                    $class_res = $conn->query("SELECT id_kelas, nama_kelas FROM kelas ORDER BY nama_kelas ASC");
                                    while ($r = $class_res->fetch_assoc()) {
                                        echo "<option value='{$r['id_kelas']}'>{$r['nama_kelas']}</option>";
                                    }
                                    ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Jurusan (Conditional) -->
                        <div id="room_class_section_container" class="hidden">
                            <label for="room_class_section" class="block mb-2 text-sm font-semibold text-gray-700">Pilih Jurusan</label>
                            <div class="relative">
                                <select id="room_class_section" name="room_class_section" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block w-full p-3 transition-all duration-200 hover:bg-white appearance-none">
                                    <option value="">-- Pilih Jurusan --</option>
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
                                <select id="timetable_teacher" name="timetable_teacher" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-green-500 focus:border-green-500 block w-full p-3 transition-all duration-200 hover:bg-white appearance-none">
                                    <option value="">-- Tanpa Guru (Istirahat/Upacara) --</option>
                                    <?php
                                    $guru_res = $conn->query("SELECT id_guru, nama_guru FROM guru WHERE status_guru='Aktif' ORDER BY nama_guru ASC");
                                    while ($r = $guru_res->fetch_assoc()) {
                                        echo "<option value='{$r['id_guru']}'>{$r['nama_guru']}</option>";
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
                                        echo "<option value='{$r['id_sesi']}'>{$r['nama_sesi']} ({$r['jam_mulai_sesi']})</option>";
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
                                        echo "<option value='{$r['id_ruangan']}'>{$r['nama_ruangan']}</option>";
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
                                        echo "<option value='{$r['id_mapel']}'>{$r['nama_mapel']}</option>";
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
                                        echo "<option value='$day'>{$days_indo[$index]} ($day)</option>";
                                    }
                                    ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="flex gap-3 justify-end">
                        <button type="submit" name="create_timetable" class="px-6 py-3 text-sm font-bold text-white bg-gradient-to-r from-green-500 to-teal-600 rounded-xl hover:shadow-lg hover:from-green-600 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                            <i class="fas fa-save mr-2"></i> Tambah Jadwal
                        </button>
                        <button type="reset" class="px-4 py-3 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 focus:outline-none transition-all duration-200">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Table Data -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <!-- Header with Search -->
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <h2 class="text-lg font-bold text-gray-800">Daftar Jadwal Pelajaran</h2>
                    
                    <div class="relative w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" id="customSearch" placeholder="Cari jadwal..." class="block w-full pl-10 pr-4 py-2 text-sm text-gray-800 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse" id="jadwal-dataTable">
                    <thead>
                        <tr>
                            <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">No</th>
                            <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Kelas/Jurusan</th>
                            <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Guru</th>
                            <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Mapel</th>
                            <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Sesi & Hari</th>
                            <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Ruangan</th>
                            <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php
                        // Optimized Query with Joins
                        $jadwal_sql = "SELECT j.*, 
                                        k.nama_kelas, 
                                        s.judul_seksi, 
                                        g.nama_guru, 
                                        m.nama_mapel, 
                                        ss.nama_sesi, ss.jam_mulai_sesi, ss.jam_berakhir_sesi,
                                        r.nama_ruangan
                                       FROM jadwal j
                                       LEFT JOIN kelas k ON j.j_id_kelas = k.id_kelas
                                       LEFT JOIN seksi s ON j.j_id_seksi = s.id_seksi
                                       LEFT JOIN guru g ON j.j_id_guru = g.id_guru
                                       LEFT JOIN mapel m ON j.j_mapel_id = m.id_mapel
                                       LEFT JOIN sesi ss ON j.j_id_sesi = ss.id_sesi
                                       LEFT JOIN ruangan r ON j.j_id_ruangan = r.id_ruangan
                                       ORDER BY j.hari_jadwal, ss.jam_mulai_sesi ASC";
                        
                        $jadwal_res = $conn->query($jadwal_sql);
                        $sno = 1;

                        if ($jadwal_res && $jadwal_res->num_rows > 0) {
                            while ($row = $jadwal_res->fetch_assoc()) {
                                $section_display = (!empty($row['judul_seksi'])) ? " ({$row['judul_seksi']})" : "";
                                $class_display = htmlspecialchars($row['nama_kelas']) . htmlspecialchars($section_display);
                        ?>
                            <tr class="hover:bg-green-50/30 transition-colors duration-200">
                                <td class="px-6 py-4 text-sm text-gray-600 font-medium"><?= $sno++ ?></td>
                                <td class="px-6 py-4 text-sm font-bold text-gray-800"><?= $class_display ?></td>
                                <td class="px-6 py-4 text-sm text-gray-600"><?= !empty($row['nama_guru']) ? htmlspecialchars($row['nama_guru']) : '<span class="text-gray-400 italic">Tanpa Guru</span>' ?></td>
                                <td class="px-6 py-4 text-sm text-gray-600"><?= htmlspecialchars($row['nama_mapel']) ?></td>
                                <td class="px-6 py-4">
                                     <div class="text-sm font-semibold text-gray-700"><?= htmlspecialchars($row['hari_jadwal']) ?></div>
                                     <div class="text-xs text-gray-500"><?= htmlspecialchars($row['nama_sesi']) ?> (<?= htmlspecialchars($row['jam_mulai_sesi']) ?>)</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600"><?= htmlspecialchars($row['nama_ruangan']) ?></td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-3">
                                        <a href="index.php?edit_id_jadwal=<?= $row['id_jadwal'] ?>" class="text-gray-400 hover:text-yellow-500 transition-colors" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="confirmDelete(<?= $row['id_jadwal'] ?>)" class="text-gray-400 hover:text-red-500 transition-colors" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center py-4 text-gray-500'>Belum ada data jadwal.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#jadwal-dataTable')) {
            $('#jadwal-dataTable').DataTable().destroy();
        }
        
        var table = $('#jadwal-dataTable').DataTable({
            responsive: true,
            pageLength: 10,
            ordering: true,
            info: true,
            lengthChange: false, // Hide default length change
            searching: true,
            language: {
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ jadwal",
                infoEmpty: "Tidak ada data",
                infoFiltered: "(filter dari _MAX_ total)",
                zeroRecords: "Tidak ada data yang cocok",
                paginate: {
                    first: '<i class="fas fa-angle-double-left"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>',
                    next: '<i class="fas fa-chevron-right"></i>',
                    previous: '<i class="fas fa-chevron-left"></i>'
                }
            },
            dom: '<"top"f>rt<"bottom-wrapper"ip><"clear">',
            columnDefs: [
                { orderable: false, targets: [6] }
            ]
        });
        
        $('#customSearch').on('keyup', function() {
            table.search(this.value).draw();
        });

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

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Jadwal?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-xl',
                confirmButton: 'rounded-lg px-4 py-2',
                cancelButton: 'rounded-lg px-4 py-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                 window.location.href = 'index.php?delete_id_jadwal=' + id + '&jadwal';
            }
        })
    }
</script>