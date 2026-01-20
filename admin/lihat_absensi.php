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
    <div class="relative w-full bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl shadow-xl overflow-hidden mb-8 p-8 text-white">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-3xl font-extrabold mb-2 tracking-tight">Rekap Absensi 📝</h1>
                <p class="text-purple-100 text-lg">Pantau kehadiran siswa secara real-time.</p>
            </div>
        </div>
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-10"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-40 h-40 rounded-full bg-white opacity-10"></div>
    </div>

    <!-- Table Data -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Header with Search -->
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                <h2 class="text-lg font-bold text-gray-800">Data Absensi Siswa</h2>
                
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="customSearch" placeholder="Cari data absensi..." class="block w-full pl-10 pr-4 py-2 text-sm text-gray-800 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="absensi-dataTable">
                <thead>
                    <tr>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">No</th>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Tanggal</th>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Siswa</th>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Kelas</th>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Guru (Pencatat)</th>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php
                    // Optimized Query with Joins
                    $att_sql = "SELECT a.*, 
                                s.nama_siswa, 
                                k.nama_kelas, 
                                g.nama_guru, g.jekel_guru
                               FROM absensi a
                               LEFT JOIN siswa s ON a.a_id_siswa = s.id_siswa
                               LEFT JOIN kelas k ON a.a_id_kelas = k.id_kelas
                               LEFT JOIN guru g ON a.a_id_guru = g.id_guru
                               ORDER BY a.tanggal_absensi DESC";
                    
                    $att_result = $conn->query($att_sql);
                    $sno = 1;

                    if ($att_result && $att_result->num_rows > 0) {
                        while ($row = $att_result->fetch_assoc()) {
                            $status = ucfirst(strtolower($row['status_absensi'])); // Ensure format like "Hadir", "Absen"
                            
                            $dateStr = $row['tanggal_absensi'];
                            $convertedDate = date("d F Y", strtotime($dateStr));
                            
                            // Color logic
                            $statusClass = "bg-gray-100 text-gray-800";
                            if ($status == "Hadir" || $status == "Present") {
                                $statusClass = "bg-green-100 text-green-700";
                            } else if ($status == "Absen" || $status == "Absent" || $status == "Alpha") {
                                $statusClass = "bg-red-100 text-red-700";
                            } else if ($status == "Izin" || $status == "Leave" || $status == "Sakit") {
                                $statusClass = "bg-yellow-100 text-yellow-700";
                            }

                            // Guru Title
                            $teacher_title = "";
                            if ($row['jekel_guru'] == 'Laki-laki') {
                                $teacher_title = "Bpk. ";
                            } else if ($row['jekel_guru'] == 'Perempuan') {
                                $teacher_title = "Ibu. ";
                            }

                    ?>
                        <tr class="hover:bg-purple-50/30 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-gray-600 font-medium"><?= $sno++ ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?= $convertedDate ?></td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-800"><?= htmlspecialchars($row['nama_siswa']) ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?= htmlspecialchars($row['nama_kelas']) ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?= $teacher_title . htmlspecialchars($row['nama_guru']) ?></td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase <?= $statusClass ?>">
                                    <?= htmlspecialchars($status) ?>
                                </span>
                            </td>
                        </tr>
                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center py-4 text-gray-500'>Belum ada data absensi.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#absensi-dataTable')) {
            $('#absensi-dataTable').DataTable().destroy();
        }
        
        var table = $('#absensi-dataTable').DataTable({
            responsive: true,
            pageLength: 20,
            ordering: true,
            info: true,
            lengthChange: false, // Hide default length change
            searching: true,
            language: {
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data absensi",
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
        });
        
        $('#customSearch').on('keyup', function() {
            table.search(this.value).draw();
        });
    });
</script>