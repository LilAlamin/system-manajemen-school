<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg mt-14">
        
        <div class="mb-6 text-center">
             <h1 class="text-3xl font-bold text-gray-800">Jadwal Pelajaran</h1>
             <p class="text-gray-600 mt-1">Jadwal kelas mingguan Anda</p>
        </div>

        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-center text-gray-500">
                <thead class="text-xs text-white uppercase bg-blue-600">
                    <?php
                    $days = [
                        'Monday'    => 'Senin', 
                        'Tuesday'   => 'Selasa', 
                        'Wednesday' => 'Rabu', 
                        'Thursday'  => 'Kamis', 
                        'Friday'    => 'Jumat', 
                        'Saturday'  => 'Sabtu', 
                        'Sunday'    => 'Minggu'
                    ];
                    ?>
                    <tr>
                        <th scope="col" class="px-6 py-3 border-r border-blue-500">Waktu</th>
                        <?php foreach ($days as $day_eng => $day_indo) : ?>
                            <th scope="col" class="px-6 py-3 border-r border-blue-500"><?= $day_indo ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $timetable = array();

                    // Using 'sesi' table
                    $fetch_period_sql = "SELECT * FROM `sesi` ORDER BY jam_mulai_sesi ASC";
                    $period_result = $conn->query($fetch_period_sql);

                    if ($period_result) {
                        while ($fetch_period_row = $period_result->fetch_assoc()) {
                            $period_start_time = date('H:i', strtotime($fetch_period_row['jam_mulai_sesi']));
                            $period_end_time = date('H:i', strtotime($fetch_period_row['jam_berakhir_sesi']));
                            $break = $fetch_period_row['nama_sesi']; // Logic: if name contains 'Istirahat'

                            if (stripos($break, 'Istirahat') !== false || stripos($break, 'Break') !== false) {
                                // This is a break
                                $timetable[] = [
                                    'id'   => $fetch_period_row['id_sesi'],
                                    'type' => 'break',
                                    'name' => $break,
                                    'time' => $period_start_time . " - " . $period_end_time
                                ];
                            } else {
                                // This is a regular period
                                $timetable[] = [
                                    'id'   => $fetch_period_row['id_sesi'],
                                    'type' => 'period',
                                    'time' => $period_start_time . " - " . $period_end_time
                                ];
                            }
                        }
                    }
                    ?>
                    
                    <?php foreach ($timetable as $period) : 
                        $period_time_str = $period['time'];
                        // Extract start time for query comparison purposes (approximate)
                        $start_time_limit = explode(' - ', $period_time_str)[0];
                    ?>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <?php if ($period['type'] === 'break') { ?>
                                <td class="px-6 py-4 font-bold text-gray-900 border-r"><?= $period_time_str ?></td>
                                <td class="px-6 py-4 font-bold text-center bg-yellow-100 text-yellow-800" colspan="<?= count($days) ?>">
                                    <?= $period['name'] ?>
                                </td>
                            <?php } else { ?>
                                <td class="px-6 py-4 font-bold text-gray-900 border-r"><?= $period_time_str ?></td>
                                
                                <?php foreach ($days as $day_eng => $day_indo) : ?>
                                    <td class="px-6 py-4 border-r border-gray-100 align-top h-full">
                                        <?php
                                        
                                        $query_sesi_id = $period['id'];
                                        $student_class = $_SESSION['student_class'];

                                        // Query schedule for either English or Indonesian day name AND current class
                                        $sql = "SELECT j.j_id_kelas, j.j_id_seksi, j.j_id_guru, j.j_id_ruangan, j.j_mapel_id
                                        FROM jadwal AS j
                                        WHERE (j.hari_jadwal = '$day_eng' OR j.hari_jadwal = '$day_indo') 
                                        AND j.j_id_sesi = '$query_sesi_id'
                                        AND j.j_id_kelas = '$student_class'
                                        LIMIT 1"; 

                                        $result = $conn->query($sql);

                                        if ($result && $result->num_rows > 0) {
                                            $row = $result->fetch_assoc();

                                            // Fetch the names
                                            $t_class_id = $row['j_id_kelas'];
                                            $t_section_id = $row['j_id_seksi'];
                                            $t_teacher_id = $row['j_id_guru'];
                                            $t_room_id = $row['j_id_ruangan'];
                                            $t_subject_id = $row['j_mapel_id'];

                                            $class_name = fetchNameFromTable($t_class_id, 'kelas', 'id_kelas', 'nama_kelas');
                                            $section_name = fetchNameFromTable($t_section_id, 'seksi', 'id_seksi', 'judul_seksi');
                                            $teacher_name = fetchNameFromTable($t_teacher_id, 'guru', 'id_guru', 'nama_guru');
                                            $room_name = fetchNameFromTable($t_room_id, 'ruangan', 'id_ruangan', 'nama_ruangan');
                                            $subject_name = fetchNameFromTable($t_subject_id, 'mapel', 'id_mapel', 'nama_mapel');

                                            // Display
                                            echo '<div class="text-left space-y-1">';
                                            echo '<div class="font-semibold text-blue-600">' . $subject_name . '</div>';
                                            echo '<div class="text-xs text-gray-500"><i class="fas fa-chalkboard-teacher mr-1"></i> ' . $teacher_name . '</div>';
                                            echo '<div class="text-xs text-gray-500"><i class="fas fa-door-open mr-1"></i> ' . $room_name . '</div>';
                                            // echo '<div class="text-xs text-gray-400">' . $class_name . ($section_name ? ' - ' . $section_name : '') . '</div>';
                                            echo '</div>';
                                        } else {
                                            echo '<span class="text-gray-300">-</span>';
                                        }
                                        ?>
                                    </td>
                                <?php endforeach; ?>
                            <?php } ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <?php
        // Helper function (unchanged logic, just names)
        function fetchNameFromTable($id, $table, $idColumn, $nameColumn)
        {
            global $conn;
            if (!$id) return '';
            
            $sql = "SELECT $nameColumn FROM $table WHERE $idColumn = '$id'";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row[$nameColumn];
            }
            return '-'; // Return dash if not found
        }
        ?>

         <div class="h-20"></div>
    </div>
</div>