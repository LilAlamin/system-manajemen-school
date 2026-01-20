<div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg mt-14">
        
        <div class="mb-6">
             <h1 class="text-3xl font-bold text-gray-800">Buku Nilai</h1>
             <p class="text-gray-600 mt-1">Lihat pencapaian akademik Anda per mata pelajaran</p>
        </div>

        <?php
        $student_id = $_SESSION['student_id'];
        // Fetch distinct subjects (mapel) for this student from the grades table
        $mapel_sql = "SELECT DISTINCT n.n_id_mapel, m.nama_mapel 
                      FROM nilai n 
                      JOIN mapel m ON n.n_id_mapel = m.id_mapel 
                      WHERE n.n_id_siswa = '$student_id'";
        $mapel_result = $conn->query($mapel_sql);
        
        $subjects = [];
        if ($mapel_result && $mapel_result->num_rows > 0) {
            while ($row = $mapel_result->fetch_assoc()) {
                $subjects[] = $row;
            }
        }
        ?>

        <?php if (empty($subjects)): ?>
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Belum ada data nilai yang tersedia untuk Anda saat ini.
                        </p>
                    </div>
                </div>
            </div>
        <?php else: ?>

            <!-- Tabs Navigation -->
            <div class="mb-4 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                    <?php foreach ($subjects as $index => $subject): ?>
                        <li class="mr-2" role="presentation">
                            <button class="inline-block p-4 border-b-2 rounded-t-lg hover:text-blue-600 hover:border-blue-600 transition-colors <?php echo $index === 0 ? 'text-blue-600 border-blue-600' : 'border-transparent'; ?>" 
                                    id="tab-btn-<?= $subject['n_id_mapel'] ?>" 
                                    data-tabs-target="#tab-<?= $subject['n_id_mapel'] ?>" 
                                    type="button" 
                                    role="tab" 
                                    aria-controls="tab-<?= $subject['n_id_mapel'] ?>" 
                                    aria-selected="<?= $index === 0 ? 'true' : 'false' ?>"
                                    onclick="switchTab(this)">
                                <?= htmlspecialchars($subject['nama_mapel']) ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Tabs Content -->
            <div id="myTabContent">
                <?php foreach ($subjects as $index => $subject): 
                    $mapel_id = $subject['n_id_mapel'];
                    $mapel_name = $subject['nama_mapel'];
                    $hiddenClass = $index === 0 ? '' : 'hidden'; // Only show first tab by default
                ?>
                    <div class="<?= $hiddenClass ?> p-4 rounded-lg bg-gray-50" id="tab-<?= $mapel_id ?>" role="tabpanel" aria-labelledby="tab-btn-<?= $mapel_id ?>">
                        
                        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
                             <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-4">
                                <h2 class="text-xl font-bold text-white uppercase tracking-wider"><?= $mapel_name ?></h2>
                             </div>
                             
                             <div class="p-6">
                                <!-- Accordion for Exam Types -->
                                <?php
                                $exam_types = [
                                    'Tugas' => 'Tugas (Assignments)',
                                    'Ulangan' => 'Ulangan (Tests)',
                                    'MID' => 'Ujian Tengah Semester (MID)',
                                    'UAS' => 'Ujian Akhir Semester (UAS)'
                                ];

                                foreach ($exam_types as $type_key => $type_label):
                                    // Fetch grades for this subject and type
                                    $grades_sql = "SELECT * FROM nilai WHERE n_id_mapel = '$mapel_id' AND n_id_siswa = '$student_id' AND tipe_nilai = '$type_key'";
                                    $grades_result = $conn->query($grades_sql);
                                    
                                    // Calculations
                                    $total_obtained = 0;
                                    $total_max = 0;
                                    $has_data = ($grades_result && $grades_result->num_rows > 0);
                                ?>
                                    <div class="mb-4 border border-gray-200 rounded-lg overflow-hidden">
                                        <button type="button" class="flex justify-between items-center w-full p-4 font-medium text-left text-gray-700 bg-gray-100 hover:bg-gray-200 focus:outline-none" onclick="toggleAccordion('accordion-<?= $mapel_id ?>-<?= $type_key ?>')">
                                            <span><?= $type_label ?></span>
                                            <i class="fas fa-chevron-down transition-transform" id="icon-accordion-<?= $mapel_id ?>-<?= $type_key ?>"></i>
                                        </button>
                                        
                                        <div id="accordion-<?= $mapel_id ?>-<?= $type_key ?>" class="<?= $has_data ? '' : 'hidden' ?> bg-white">
                                            <div class="overflow-x-auto">
                                                <?php if($has_data): ?>
                                                <table class="w-full text-sm text-center text-gray-500">
                                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                                        <tr>
                                                            <th scope="col" class="px-6 py-3">Judul</th>
                                                            <th scope="col" class="px-6 py-3">Total Nilai</th>
                                                            <th scope="col" class="px-6 py-3">Nilai Diperoleh</th>
                                                            <th scope="col" class="px-6 py-3">Persentase</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php while($grade = $grades_result->fetch_assoc()): 
                                                            $total_obtained += $grade['capaian_nilai'];
                                                            $total_max += $grade['total_nilai'];
                                                            $percentage = ($grade['total_nilai'] > 0) ? round(($grade['capaian_nilai'] / $grade['total_nilai']) * 100) : 0;
                                                        ?>
                                                        <tr class="bg-white border-b hover:bg-gray-50">
                                                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap"><?= $grade['nama_nilai'] ?></td>
                                                            <td class="px-6 py-4"><?= $grade['total_nilai'] ?></td>
                                                            <td class="px-6 py-4 font-bold text-blue-600"><?= $grade['capaian_nilai'] ?></td>
                                                            <td class="px-6 py-4">
                                                                <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                                                    <?= $percentage >= 75 ? 'bg-green-100 text-green-800' : ($percentage >= 50 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') ?>">
                                                                    <?= $percentage ?>%
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <?php endwhile; ?>
                                                    </tbody>
                                                    <tfoot class="bg-gray-100 font-semibold text-gray-900">
                                                        <tr>
                                                            <td class="px-6 py-3 text-right">TOTAL</td>
                                                            <td class="px-6 py-3"><?= $total_max ?></td>
                                                            <td class="px-6 py-3 text-blue-700"><?= $total_obtained ?></td>
                                                            <td class="px-6 py-3">
                                                                <?= ($total_max > 0) ? round(($total_obtained / $total_max) * 100) . '%' : '0%' ?>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <?php else: ?>
                                                    <div class="p-4 text-center text-gray-500 italic">Belum ada nilai untuk kategori ini.</div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                             </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>
    </div>
</div>

<div class="h-20"></div>

<script>
    function switchTab(button) {
        // Hide all tabs
        const targetId = button.getAttribute('data-tabs-target');
        const allTabs = document.querySelectorAll('[role="tabpanel"]');
        allTabs.forEach(tab => {
            tab.classList.add('hidden');
        });
        
        // Show target tab
        document.querySelector(targetId).classList.remove('hidden');

        // Update button states
        const allButtons = document.querySelectorAll('[role="tab"]');
        allButtons.forEach(btn => {
            btn.classList.remove('text-blue-600', 'border-blue-600');
            btn.classList.add('border-transparent');
            btn.setAttribute('aria-selected', 'false');
        });
        
        button.classList.remove('border-transparent');
        button.classList.add('text-blue-600', 'border-blue-600');
        button.setAttribute('aria-selected', 'true');
    }

    function toggleAccordion(id) {
        const element = document.getElementById(id);
        const icon = document.getElementById('icon-' + id);
        
        if (element.classList.contains('hidden')) {
            element.classList.remove('hidden');
            if(icon) icon.classList.add('rotate-180');
        } else {
            element.classList.add('hidden');
            if(icon) icon.classList.remove('rotate-180');
        }
    }
</script>