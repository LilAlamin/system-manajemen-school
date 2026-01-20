<?php
// Function to calculate percentage
function calculate_percentage($obtained, $total) {
    if ($total > 0) {
        return round(($obtained / $total) * 100);
    }
    return 0;
}

// Function to determine Grade based on percentage
function get_grade($percentage) {
    if ($percentage >= 86) return 'Sangat Baik (A)';
    if ($percentage >= 71) return 'Baik (B)';
    if ($percentage >= 56) return 'Cukup (C)';
    // Less than 56
    return 'Kurang (D)';
}

// Function to determine Status
function get_status($percentage) {
    return ($percentage >= 70 ) ? 'LULUS' : 'GAGAL';
}
?>

<div class="p-4 sm:ml-64" id="print-area">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg mt-14 print:border-none print:m-0 print:p-0">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 print:hidden">
            <div class="mb-4 md:mb-0">
                 <h1 class="text-3xl font-bold text-gray-800">Rekap Nilai</h1>
                 <p class="text-gray-600 mt-1">Ringkasan seluruh hasil belajar akademik</p>
            </div>
            <button onclick="window.print()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none flex items-center shadow-lg transform transition hover:scale-105 duration-200">
                <i class="fas fa-print mr-2"></i> Cetak PDF
            </button>
        </div>

        <!-- Print Header (Hidden on Screen) -->
        <div class="hidden print:block mb-4 text-center">
            <h2 class="text-xl font-bold uppercase tracking-wide">SMA NEGERI 10 TEBO</h2>
            <h1 class="text-2xl font-bold uppercase tracking-wide">CAPAIAN BELAJAR SISWA</h1>
            <p class="text-sm">Jl. Pendidikan No. 10, Kabupaten Tebo, Jambi</p>
            <p class="text-sm">Email: sman10tebo@gmail.com | Telp: (0748) 123456</p>
            <div class="border-b-2 border-black my-2"></div>
            
            <h3 class="text-lg font-bold uppercase tracking-wide mt-4">KARTU HASIL BELAJAR SISWA</h3>
            
            <?php
            // Logic for Semester and Academic Year
            // Assuming current logic based on real date or fixed as requested
            // User requested: "generate aja tahun 2025/2026"
            // We can infer semester from month: Jan-Jun = Genap, Jul-Dec = Ganjil
            $month = date('n');
            $semester_display = ($month >= 7) ? 'Ganjil' : 'Genap';
            $tahun_ajaran_display = '2025/2026'; // Hardcoded as per specific request for this example
            ?>

            <div class="flex justify-between text-sm mt-4 px-4 font-bold">
                <div class="text-left">
                    <p>Nama: <?= $_SESSION['student_name'] ?></p>
                    <p>NIS/ID: <?= $_SESSION['student_rollno'] ?></p>
                    <p>Kelas: <?= isset($student_class) ? $student_class : '-' ?></p>
                </div>
                <div class="text-right">
                    <p>Semester: <?= $semester_display ?></p>
                    <p>Tahun Ajaran: <?= $tahun_ajaran_display ?></p>
                </div>
            </div>
        </div>

        <?php
        $student_id = $_SESSION['student_id'];
        
        // Fetch all subjects for this student
        $mapel_sql = "SELECT DISTINCT n.n_id_mapel, m.nama_mapel 
                      FROM nilai n 
                      JOIN mapel m ON n.n_id_mapel = m.id_mapel 
                      WHERE n.n_id_siswa = '$student_id'";
        $mapel_result = $conn->query($mapel_sql);
        
        // Group grades by subject
        $rekap_data = [];
        
        if ($mapel_result && $mapel_result->num_rows > 0) {
            while ($subject = $mapel_result->fetch_assoc()) {
                $id_mapel = $subject['n_id_mapel'];
                $nama_mapel = $subject['nama_mapel'];
                
                // Initialize categories for this subject
                $categories = ['Tugas' => ['obt'=>0, 'tot'=>0], 
                               'Ulangan' => ['obt'=>0, 'tot'=>0], 
                               'MID' => ['obt'=>0, 'tot'=>0], 
                               'UAS' => ['obt'=>0, 'tot'=>0]];
                
                $grand_obt = 0;
                $grand_tot = 0;

                // Fetch all grades for this subject
                $grades_sql = "SELECT * FROM nilai WHERE n_id_mapel = '$id_mapel' AND n_id_siswa = '$student_id'";
                $grades_q = $conn->query($grades_sql);
                
                while($g = $grades_q->fetch_assoc()) {
                    $type = $g['tipe_nilai']; // Tugas, Ulangan, MID, UAS
                    if (isset($categories[$type])) {
                        $categories[$type]['obt'] += $g['capaian_nilai'];
                        $categories[$type]['tot'] += $g['total_nilai'];
                    }
                    $grand_obt += $g['capaian_nilai'];
                    $grand_tot += $g['total_nilai'];
                }

                $rekap_data[] = [
                    'nama_mapel' => $nama_mapel,
                    'categories' => $categories,
                    'grand_obt' => $grand_obt,
                    'grand_tot' => $grand_tot
                ];
            }
        }
        ?>

        <!-- Table Container -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white print:shadow-none">
            <?php if (empty($rekap_data)): ?>
                <div class="p-8 text-center">
                    <div class="inline-block p-4 rounded-full bg-yellow-100 mb-4">
                        <i class="fas fa-folder-open text-yellow-500 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada data nilai</h3>
                    <p class="text-gray-500">Nilai-nilai Anda akan muncul di sini setelah diinput oleh guru.</p>
                </div>
            <?php else: ?>
                <table class="w-full text-sm text-center text-gray-500 print:text-black print:border-collapse border border-gray-200">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100 print:bg-white">
                        <tr>
                            <th scope="col" class="px-6 py-4 border-b border-gray-200 print:border-black font-bold">Mata Pelajaran</th>
                            <th scope="col" class="px-6 py-4 border text-center print:border-black">Penugasan</th>
                            <th scope="col" class="px-6 py-4 border text-center print:border-black">Tes</th>
                            <th scope="col" class="px-6 py-4 border text-center print:border-black">Mid</th>
                            <th scope="col" class="px-6 py-4 border text-center print:border-black">UAS</th>
                            <th scope="col" class="px-6 py-4 border text-center print:border-black">Total</th>
                            <th scope="col" class="px-6 py-4 border text-center print:border-black">Predikat</th>
                            <th scope="col" class="px-6 py-4 border text-center print:border-black">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($rekap_data as $row): 
                            $total_percent = calculate_percentage($row['grand_obt'], $row['grand_tot']);
                            $grade = get_grade($total_percent);
                            //$status_text = ($total_percent >= 70) ? 'LULUS' : 'GAGAL'; // Old logic
                            $is_passed = ($total_percent >= 70);
                            $status_display = $is_passed ? 'Tercapai' : 'Gagal';
                            $row_class = $is_passed ? 'bg-green-100 text-black font-bold' : 'bg-red-200 text-black font-bold'; // Only for status cell
                            $print_bg = $is_passed ? 'bg-green-300' : 'bg-red-400';
                        ?>
                        <tr class="bg-white border-b hover:bg-gray-50 print:hover:bg-transparent">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap print:border print:border-black capitalize text-left">
                                <?= $row['nama_mapel'] ?>
                            </td>
                            <?php 
                                // Mapping old keys to new header names (cosmetic only, data keys remain same)
                                // keys: Tugas, Ulangan, MID, UAS
                                foreach(['Tugas', 'Ulangan', 'MID', 'UAS'] as $cat): 
                                $p = calculate_percentage($row['categories'][$cat]['obt'], $row['categories'][$cat]['tot']);
                            ?>
                                <td class="px-6 py-4 border print:border-black">
                                    <?= $p ?>
                                </td>
                            <?php endforeach; ?>
                            
                            <td class="px-6 py-4 border font-bold text-blue-600 print:text-black print:border-black">
                                <?= $total_percent ?>
                            </td>
                            <td class="px-6 py-4 border print:border-black">
                                <?= $grade ?>
                            </td>
                            <td class="px-6 py-4 border print:border-black <?= $is_passed ? 'bg-green-200 print:bg-green-200' : 'bg-red-200 print:bg-red-200' ?>">
                                <span class="text-black font-bold">
                                    <?= $status_display ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <div class="hidden print:flex mt-20 justify-end px-12">
            <div class="text-center">
                <p>Tebo, <?= date('d F Y') ?></p>
                <p>Kepala Sekolah</p>
                <div class="h-24"></div>
                <p class="font-bold border-b border-black inline-block min-w-[200px]">( Norkholis, M.Pd )</p>
                <p class="mt-1">NIP. 19650505 199003 1 001</p>
            </div>
        </div>

    </div>
</div>

<style>
    @media print {
        @page {
            size: landscape;
            margin: 0; /* Use 0 margin for @page to allow full control via padding */
        }
        
        body {
            visibility: hidden;
            background-color: white;
            margin: 0;
            padding: 0;
        }

        /* Hide generic elements */
        footer, aside, nav, header, .fixed, .print\:hidden {
            display: none !important;
        }

        /* Target unique print area */
        #print-area {
            visibility: visible !important;
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 20mm !important; /* Add safe padding directly to content */
            border: none !important;
            z-index: 50;
        }

        /* Make children visible */
        #print-area * {
            visibility: visible !important;
        }

        /* Table styling for print relative to the new padding */
        table {
            width: 100% !important;
            border-collapse: collapse !important;
            font-size: 10pt;
        }
        
        th, td {
            border: 1px solid black !important;
            padding: 4px 8px !important;
            color: black !important;
        }
        
        thead th {
            background-color: #f3f4f6 !important; /* gray-100 */
            -webkit-print-color-adjust: exact; 
        }

        /* Badges/Pills coloring for print */
        .bg-green-100 { background-color: #d1fae5 !important; }
        .bg-red-200 { background-color: #fecaca !important; }
        .bg-green-300 { background-color: #86efac !important; }
        .bg-red-400 { background-color: #f87171 !important; }
        .bg-green-200 { background-color: #bbf7d0 !important; }
        
        /* Ensure text colors print */
        .text-black { color: black !important; }
        
        /* Layout adjustments */
        .mt-14 { margin-top: 0 !important; }
        .border-dashed { border-style: none !important; }
    }
</style>
