<?php 
$title = 'Hasil Studi Siswa'; 
?>
<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg mt-14">
        
        <div class="mb-6 text-center">
             <h1 class="text-3xl font-bold text-gray-800">Kartu Hasil Studi</h1>
             <p class="text-gray-600 mt-1">Ringkasan pencapaian akademik Anda</p>
        </div>

        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-center text-gray-500">
                <thead class="text-xs text-white uppercase bg-blue-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">Mata Pelajaran</th>
                        <th scope="col" class="px-6 py-3">Tugas</th>
                        <th scope="col" class="px-6 py-3">Ulangan</th>
                        <th scope="col" class="px-6 py-3">MID</th>
                        <th scope="col" class="px-6 py-3">UAS</th>
                        <th scope="col" class="px-6 py-3">Total</th>
                        <th scope="col" class="px-6 py-3">Persentase</th>
                        <th scope="col" class="px-6 py-3">Grade</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $student_id = $_SESSION['student_id'];
                    $student_class = $_SESSION['student_class'];

                    // Fetch distinct subjects
                    $mapel_sql = "SELECT DISTINCT n.n_id_mapel, m.nama_mapel 
                                  FROM nilai n 
                                  JOIN mapel m ON n.n_id_mapel = m.id_mapel 
                                  WHERE n.n_id_siswa = '$student_id'";
                    $mapel_result = $conn->query($mapel_sql);

                    if ($mapel_result && $mapel_result->num_rows > 0) {
                        while ($mapel_row = $mapel_result->fetch_assoc()) {
                            $mapel_id = $mapel_row['n_id_mapel'];
                            $mapel_name = $mapel_row['nama_mapel'];
                            
                            // Initialize scores
                            $scores = ['Tugas' => 0, 'Ulangan' => 0, 'MID' => 0, 'UAS' => 0];
                            $max_scores = ['Tugas' => 0, 'Ulangan' => 0, 'MID' => 0, 'UAS' => 0];
                            
                            // Get all grades for this subject
                            $grades_sql = "SELECT tipe_nilai, total_nilai, capaian_nilai FROM nilai WHERE n_id_mapel = '$mapel_id' AND n_id_siswa = '$student_id'";
                            $grades_result = $conn->query($grades_sql);
                            
                            while ($g = $grades_result->fetch_assoc()) {
                                if (isset($scores[$g['tipe_nilai']])) {
                                    $scores[$g['tipe_nilai']] += $g['capaian_nilai'];
                                    $max_scores[$g['tipe_nilai']] += $g['total_nilai'];
                                }
                            }
                            
                            $total_obtained = array_sum($scores);
                            $total_max = array_sum($max_scores);
                            $percentage = ($total_max > 0) ? ($total_obtained / $total_max) * 100 : 0;
                            
                            // Calculate Grade & Status
                            if ($percentage >= 90) $grade = 'A+';
                            elseif ($percentage >= 80) $grade = 'A';
                            elseif ($percentage >= 70) $grade = 'B+';
                            elseif ($percentage >= 60) $grade = 'B';
                            elseif ($percentage >= 50) $grade = 'C';
                            else $grade = 'F'; // Fail
                            
                            $status = ($percentage >= 50) ? 'LULUS' : 'GAGAL';
                            $status_class = ($status === 'LULUS') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                    ?>
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium text-gray-900"><?= $mapel_name ?></td>
                            <td class="px-6 py-4"><?= $scores['Tugas'] ?> <span class="text-xs text-gray-400">/<?= $max_scores['Tugas'] ?></span></td>
                            <td class="px-6 py-4"><?= $scores['Ulangan'] ?> <span class="text-xs text-gray-400">/<?= $max_scores['Ulangan'] ?></span></td>
                            <td class="px-6 py-4"><?= $scores['MID'] ?> <span class="text-xs text-gray-400">/<?= $max_scores['MID'] ?></span></td>
                            <td class="px-6 py-4"><?= $scores['UAS'] ?> <span class="text-xs text-gray-400">/<?= $max_scores['UAS'] ?></span></td>
                            <td class="px-6 py-4 font-bold"><?= $total_obtained ?> <span class="text-xs font-normal text-gray-400">/<?= $total_max ?></span></td>
                            <td class="px-6 py-4"><?= number_format($percentage, 2) ?>%</td>
                            <td class="px-6 py-4 font-bold text-blue-600"><?= $grade ?></td>
                            <td class="px-6 py-4">
                                <span class="<?= $status_class ?> px-2 py-1 rounded-full text-xs font-semibold"><?= $status ?></span>
                            </td>
                        </tr>
                    <?php 
                        } 
                    } else { 
                    ?>
                        <tr class="bg-white border-b">
                            <td colspan="9" class="px-6 py-4 text-center text-gray-500 italic">Belum ada data nilai.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="h-20"></div>
    </div>
</div>