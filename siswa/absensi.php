<div class="p-4 sm:ml-64">
    <div class="max-w-4xl mx-auto mt-4">
        
        <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                 <h1 class="text-3xl font-bold text-gray-800">Rekap Absensi</h1>
                 <p class="text-gray-600 mt-1">Cek kehadiran Anda di sini</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-6">
            <div class="p-4 bg-gray-50 border-b border-gray-100">
                <form method="post" class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="w-full md:w-1/3">
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                        <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="start_date" name="start_date" value="<?= isset($_POST['start_date']) ? $_POST['start_date'] : '' ?>">
                    </div>

                    <div class="w-full md:w-1/3">
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                        <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" id="end_date" name="end_date" value="<?= isset($_POST['end_date']) ? $_POST['end_date'] : '' ?>">
                    </div>
                    
                    <div class="w-full md:w-auto">
                        <button class="w-full bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition flex items-center justify-center gap-2" id="date_filter" name="date_filter" type="submit">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500" id="my-dataTable"> <!-- ID kept for potential DataTables usage if needed later -->
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Tanggal</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $student_id = $_SESSION['student_id'];
                        $student_class = $_SESSION['student_class'];
                        
                        $where_clause = "WHERE a_id_kelas = '$student_class' AND a_id_siswa = '$student_id'";

                        if (isset($_POST['start_date']) && !empty($_POST['start_date']) && isset($_POST['end_date']) && !empty($_POST['end_date'])) {
                            $start_date = $_POST['start_date'];
                            $end_date = $_POST['end_date'];
                            // Pastikan format tanggal match dengan DB (biasanya Y-m-d)
                            $where_clause .= " AND tanggal_absensi BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";
                        }

                        $att_sql = "SELECT * FROM `absensi` $where_clause ORDER BY tanggal_absensi DESC";
                        $att_result = $conn->query($att_sql);
                        $sno = 1;

                        if ($att_result && $att_result->num_rows > 0) {
                            while ($att_row = $att_result->fetch_assoc()) {
                                $status = $att_row['status_absensi'];
                                $dateStr = $att_row['tanggal_absensi'];
                                $convertedDate = date("d F Y H:i", strtotime($dateStr));
                                
                                // Color logic
                                $statusClass = "bg-gray-100 text-gray-800";
                                $statusIcon = "";
                                if ($status === "Hadir") { 
                                    $statusClass = "bg-green-100 text-green-800 border border-green-200";
                                    $statusIcon = "<i class='fas fa-check-circle mr-1'></i>";
                                } else if ($status === "Alpha") { 
                                    $statusClass = "bg-red-100 text-red-800 border border-red-200";
                                    $statusIcon = "<i class='fas fa-times-circle mr-1'></i>";
                                } else if ($status === "Izin") {
                                    $statusClass = "bg-yellow-100 text-yellow-800 border border-yellow-200";
                                    $statusIcon = "<i class='fas fa-info-circle mr-1'></i>";
                                } else if ($status === "Sakit") {
                                    $statusClass = "bg-orange-100 text-orange-800 border border-orange-200";
                                    $statusIcon = "<i class='fas fa-notes-medical mr-1'></i>";
                                }
                        ?>
                            <tr class="bg-white border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-medium"><?= $sno++ ?></td>
                                <td class="px-6 py-4 font-medium text-gray-900"><?= $convertedDate ?></td>
                                <td class="px-6 py-4">
                                    <span class="<?= $statusClass ?> px-3 py-1 rounded-full text-xs font-semibold inline-flex items-center">
                                        <?= $statusIcon . $status ?>
                                    </span>
                                </td>
                            </tr>
                        <?php
                            }
                        } else {
                        ?>
                            <tr class="bg-white border-b">
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-calendar-times text-4xl text-gray-300 mb-2"></i>
                                        <p>Tidak ada data absensi ditemukan untuk periode ini.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
             <!-- Pagination could go here -->
             <div class="p-4 bg-gray-50 border-t border-gray-100 text-xs text-gray-500 text-center">
                Menampilkan data absensi terbaru
             </div>
        </div>
        
        <div class="h-20"></div>
    </div>
</div>