<div class="p-4 sm:ml-64">
    <div class="max-w-6xl mx-auto mt-10">
        
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-calendar-alt text-blue-600 mr-2"></i> Jadwal Mengajar Saya
            </h1>
            <p class="text-gray-500 text-sm mt-1">Jadwal pelajaran yang Anda ampu minggu ini.</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-white uppercase bg-blue-600 text-center">
                        <tr>
                            <th scope="col" class="px-6 py-4 border-r border-blue-500">
                                <i class="far fa-clock mr-1"></i> Waktu
                            </th>
                            <?php
                            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                            foreach ($days as $day) : ?>
                                <th scope="col" class="px-6 py-4 border-r border-blue-500 last:border-r-0">
                                    <?= $day ?>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                        // 1. Get Logged In Teacher ID
                        $teacher_id = $_SESSION['teacher_id'];

                        // 2. Fetch All Sessions
                        $sessions = [];
                        $sesi_sql = "SELECT * FROM `sesi` ORDER BY jam_mulai_sesi ASC";
                        $sesi_result = $conn->query($sesi_sql);
                        while ($row = $sesi_result->fetch_assoc()) {
                            $sessions[] = $row;
                        }

                        // 3. Fetch Teacher's Schedule & Map it for O(1) Access
                        // Mapping: $schedule_map['Senin'][sys_id] =Details
                        $schedule_map = [];
                        $jadwal_sql = "SELECT j.*, 
                                              k.nama_kelas, 
                                              m.nama_mapel, 
                                              r.nama_ruangan,
                                              s.judul_seksi
                                       FROM `jadwal` j
                                       LEFT JOIN `kelas` k ON j.j_id_kelas = k.id_kelas
                                       LEFT JOIN `mapel` m ON j.j_mapel_id = m.id_mapel
                                       LEFT JOIN `ruangan` r ON j.j_id_ruangan = r.id_ruangan
                                       LEFT JOIN `seksi` s ON j.j_id_seksi = s.id_seksi
                                       WHERE j.j_id_guru = '$teacher_id'";
                        
                        $jadwal_result = $conn->query($jadwal_sql);
                        while ($row = $jadwal_result->fetch_assoc()) {
                            // Key: Day + SessionID
                            $day_name = $row['hari_jadwal']; // e.g., 'Senin'
                            $session_id = $row['j_id_sesi'];
                            $schedule_map[$day_name][$session_id] = $row;
                        }

                        // 4. Build Matrix
                        foreach ($sessions as $sesi) :
                            $sesi_id = $sesi['id_sesi'];
                            $is_break = stripos($sesi['nama_sesi'], 'Rest') !== false || stripos($sesi['nama_sesi'], 'Break') !== false || stripos($sesi['nama_sesi'], 'Istirahat') !== false || stripos($sesi['nama_sesi'], 'Lunch') !== false;
                            
                            $row_class = $is_break ? "bg-orange-50" : "hover:bg-gray-50";
                            $time_display = date('H:i', strtotime($sesi['jam_mulai_sesi'])) . ' - ' . date('H:i', strtotime($sesi['jam_berakhir_sesi']));
                        ?>
                            <tr class="<?= $row_class ?>">
                                <!-- Time Column -->
                                <td class="px-4 py-4 font-medium text-gray-900 border-r text-center whitespace-nowrap bg-gray-50">
                                    <div class="text-sm font-bold"><?= $time_display ?></div>
                                    <div class="text-xs text-gray-500 mt-1"><?= $sesi['nama_sesi'] ?></div>
                                </td>

                                <?php foreach ($days as $day) : ?>
                                    <td class="px-2 py-3 border-r border-gray-200 last:border-r-0 text-center align-top h-full">
                                        <?php
                                        if ($is_break) {
                                           echo "<span class='text-orange-400 font-medium text-xs uppercase tracking-wider'>Istirahat</span>";
                                        } else {
                                            if (isset($schedule_map[$day][$sesi_id])) {
                                                $data = $schedule_map[$day][$sesi_id];
                                        ?>
                                                <!-- Schedule Card -->
                                                <div class="bg-blue-50 border border-blue-100 rounded-lg p-3 text-left shadow-sm hover:shadow-md transition">
                                                    <div class="font-bold text-blue-800 text-sm mb-1 truncate" title="<?= $data['nama_mapel'] ?>">
                                                        <?= $data['nama_mapel'] ?>
                                                    </div>
                                                    <div class="flex items-center text-xs text-gray-600 mb-1">
                                                        <i class="fas fa-chalkboard-teacher w-4 text-center mr-1"></i> 
                                                        Kelas <?= $data['nama_kelas'] ?>
                                                    </div>
                                                    <?php if($data['judul_seksi']) { ?>
                                                    <div class="flex items-center text-xs text-gray-500 mb-1">
                                                        <i class="fas fa-layer-group w-4 text-center mr-1"></i>
                                                        <?= $data['judul_seksi'] ?>
                                                    </div>
                                                    <?php } ?>
                                                    <div class="flex items-center text-xs text-gray-500">
                                                        <i class="fas fa-map-marker-alt w-4 text-center mr-1"></i>
                                                        <?= $data['nama_ruangan'] ?? 'R. -' ?>
                                                    </div>
                                                </div>
                                        <?php
                                            } else {
                                                echo "<span class='text-gray-300 text-2xl font-thin'>-</span>";
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
            <?php if (empty($sessions)) : ?>
                <div class="p-8 text-center text-gray-500">
                    Belum ada data sesi/jadwal yang diatur oleh Admin.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>