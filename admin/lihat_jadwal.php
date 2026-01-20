<!-- Custom Styling -->
<style>
    .schedule-cell {
        transition: all 0.2s ease;
    }
    .schedule-cell:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        z-index: 10;
        position: relative;
    }
</style>

<?php
// Get Selected Class from Filter
$selected_class_id = isset($_GET['filter_kelas']) ? $_GET['filter_kelas'] : '';

// Days mapping
$days = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'];
$english_days = array_keys($days);

// 1. Fetch All Sessions (Sesi) Ordered by Time
$sessions = [];
$sesi_sql = "SELECT * FROM `sesi` ORDER BY jam_mulai_sesi ASC";
$sesi_res = $conn->query($sesi_sql);
while($row = $sesi_res->fetch_assoc()) {
    $sessions[] = $row;
}

// 2. Fetch Schedule Data (Jadwal)
// If class is selected, filter by it. Else, we might not show anything or show a message.
$schedule_data = []; // Format: $schedule_data[day_name][session_id] = object/array

if ($selected_class_id) {
    $jadwal_sql = "SELECT j.*, 
                    m.nama_mapel, 
                    g.nama_guru, 
                    r.nama_ruangan,
                    s.nama_sesi
                   FROM jadwal j
                   LEFT JOIN mapel m ON j.j_mapel_id = m.id_mapel
                   LEFT JOIN guru g ON j.j_id_guru = g.id_guru
                   LEFT JOIN ruangan r ON j.j_id_ruangan = r.id_ruangan
                   LEFT JOIN sesi s ON j.j_id_sesi = s.id_sesi
                   WHERE j.j_id_kelas = '$selected_class_id'";
    
    $jadwal_res = $conn->query($jadwal_sql);
    while($row = $jadwal_res->fetch_assoc()) {
        $day = $row['hari_jadwal']; // Assuming 'Monday', 'Tuesday' etc in DB
        $sess_id = $row['j_id_sesi'];
        
        // Simpan data di array multidimensi untuk akses cepat O(1) saat rendering grid
        $schedule_data[$day][$sess_id] = $row;
    }
}
?>

<div class="container mx-auto px-4 py-8">
    
    <!-- Header & Filter -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 mb-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <div>
                 <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight flex items-center">
                    <span class="bg-blue-100 text-blue-600 p-2 rounded-lg mr-3">
                        <i class="fas fa-calendar-alt"></i>
                    </span>
                    Lihat Jadwal Pelajaran
                </h1>
                <p class="text-gray-500 mt-2 ml-14">Pilih kelas untuk melihat jadwal pelajaran mingguan.</p>
            </div>

            <div class="w-full md:w-auto">
                <form method="get" action="index.php" class="flex items-center gap-3">
                    <input type="hidden" name="lihat_jadwal" value="true"> <!-- Maintain active tab -->
                    
                    <div class="relative">
                        <select name="filter_kelas" onchange="this.form.submit()" class="pl-4 pr-10 py-3 bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full appearance-none transition-all hover:bg-white cursor-pointer min-w-[200px]">
                            <option value="">-- Pilih Kelas --</option>
                            <?php
                            $c_sql = "SELECT id_kelas, nama_kelas FROM kelas ORDER BY nama_kelas ASC";
                            $c_res = $conn->query($c_sql);
                            while($c = $c_res->fetch_assoc()) {
                                $sel = ($c['id_kelas'] == $selected_class_id) ? 'selected' : '';
                                echo "<option value='{$c['id_kelas']}' $sel>{$c['nama_kelas']}</option>";
                            }
                            ?>
                        </select>
                         <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Schedule Grid -->
    <?php if ($selected_class_id): ?>
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-center border-collapse">
                    <thead>
                        <tr>
                            <th class="px-6 py-4 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200 border-r w-32 sticky left-0 z-10">
                                Jam / Hari
                            </th>
                            <?php foreach ($english_days as $day_eng): ?>
                            <th class="px-6 py-4 bg-gray-50 text-xs font-bold text-gray-500 uppercase tracking-wider border-b border-gray-200 min-w-[160px]">
                                <?= $days[$day_eng] ?>
                            </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($sessions as $sesi): ?>
                            <tr class="group hover:bg-gray-50/50">
                                <!-- Time Column -->
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold text-gray-600 bg-gray-50/80 border-r border-gray-200">
                                    <div class="flex flex-col items-center">
                                        <span class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded mb-1"><?= date('H:i', strtotime($sesi['jam_mulai_sesi'])) ?></span>
                                        <span class="text-gray-400 text-xs">-</span>
                                        <span class="text-xs text-gray-500 mt-1"><?= date('H:i', strtotime($sesi['jam_berakhir_sesi'])) ?></span>
                                    </div>
                                    <div class="text-[10px] text-gray-400 mt-2 uppercase tracking-wide"><?= htmlspecialchars($sesi['nama_sesi']) ?></div>
                                </td>

                                <!-- Days Columns -->
                                <?php foreach ($english_days as $day_eng): ?>
                                    <td class="px-2 py-2 border-r border-gray-100 last:border-r-0 align-top h-full">
                                        <?php 
                                        if (isset($schedule_data[$day_eng][$sesi['id_sesi']])) {
                                            $data = $schedule_data[$day_eng][$sesi['id_sesi']];
                                            ?>
                                            <div class="schedule-cell bg-blue-50 border border-blue-100 rounded-xl p-3 h-full flex flex-col justify-between text-left group-hover:bg-blue-100 transition-colors">
                                                <div>
                                                    <div class="text-sm font-bold text-blue-800 mb-1 leading-tight line-clamp-2">
                                                        <?= htmlspecialchars($data['nama_mapel']) ?>
                                                    </div>
                                                        <i class="fas fa-chalkboard-teacher mr-1.5 opacity-70"></i>
                                                        <span class="truncate"><?= !empty($data['nama_guru']) ? htmlspecialchars($data['nama_guru']) : 'Tanpa Guru' ?></span>
                                                    </div>
                                                </div>
                                                <div class="flex items-center text-[10px] font-medium text-gray-500 bg-white/60 rounded-lg px-2 py-1 self-start">
                                                    <i class="fas fa-door-open mr-1.5 text-gray-400"></i>
                                                    <?= htmlspecialchars($data['nama_ruangan']) ?>
                                                </div>
                                            </div>
                                            <?php
                                        } else {
                                            // Handle "Istirahat" or Empty
                                            if (stripos($sesi['nama_sesi'], 'Istirahat') !== false || stripos($sesi['nama_sesi'], 'Break') !== false) {
                                                ?>
                                                <div class="h-full w-full flex items-center justify-center p-2 opacity-50">
                                                    <span class="text-xs font-bold text-gray-300 tracking-widest uppercase rotate-0">Istirahat</span>
                                                </div>
                                                <?php
                                            } else {
                                                echo "<div class='h-full min-h-[80px]'></div>"; // Empty slot
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl border border-dashed border-gray-300 text-gray-500">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-hand-pointer text-2xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-700">Pilih Kelas Terlebih Dahulu</h3>
            <p class="text-sm text-gray-400 mt-1">Silakan pilih kelas pada menu di atas untuk menampilkan jadwal.</p>
        </div>
    <?php endif; ?>

</div>