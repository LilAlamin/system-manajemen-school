<?php
// Delete Exam Record (Nilai)
if (isset($_GET['delete_id_ujian'])) {
    $delete_id_ujian = $_GET['delete_id_ujian'];
    $delete_ujian_sql = "DELETE FROM `nilai` WHERE id_nilai = '$delete_id_ujian' ";
    
    if ($conn->query($delete_ujian_sql)) {
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data nilai ujian berhasil dihapus!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'index.php?ujian';
                });
            });
        </script>";
    } else {
        echo "<script>
            $(document).ready(function() {
                Swal.fire('Gagal!', 'Gagal menghapus data: " . $conn->error . "', 'error');
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
    <div class="relative w-full bg-gradient-to-r from-pink-500 to-rose-600 rounded-2xl shadow-xl overflow-hidden mb-8 p-8 text-white">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-3xl font-extrabold mb-2 tracking-tight">Data Nilai Ujian 📝</h1>
                <p class="text-pink-100 text-lg">Kelola dan pantau hasil ujian siswa.</p>
            </div>
            <div class="mt-6 md:mt-0">
                <!-- Maybe Add Exam functionality could be here if Admin allowed to add exams -->
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
                <h2 class="text-lg font-bold text-gray-800">Daftar Nilai Siswa</h2>
                
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="customSearch" placeholder="Cari data nilai..." class="block w-full pl-10 pr-4 py-2 text-sm text-gray-800 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200">
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="ujian-dataTable">
                <thead>
                    <tr>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">No</th>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Siswa</th>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Detail Ujian</th>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Nilai</th>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Grade</th>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Status</th>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php
                    // Optimization: Use JOINS to fetch all related names in one go
                    $exam_sql = "SELECT n.*, 
                                    s.nama_siswa, 
                                    k.nama_kelas, 
                                    g.nama_guru, g.jekel_guru,
                                    m.nama_mapel
                                 FROM nilai n
                                 LEFT JOIN siswa s ON n.n_id_siswa = s.id_siswa
                                 LEFT JOIN kelas k ON n.n_id_kelas = k.id_kelas
                                 LEFT JOIN guru g ON n.n_id_guru = g.id_guru
                                 LEFT JOIN mapel m ON n.n_id_mapel = m.id_mapel
                                 ORDER BY n.nilai_date DESC, n.id_nilai DESC";

                    $exam_result = $conn->query($exam_sql);
                    $sno = 1;

                    if ($exam_result && $exam_result->num_rows > 0) {
                        while ($exam_row = $exam_result->fetch_assoc()) {
                            
                            // Calculation Logic from legacy code
                            $total_marks = $exam_row['total_nilai'];
                            $obtained_marks = $exam_row['capaian_nilai'];
                            
                            $percentage = ($total_marks > 0) ? (($obtained_marks / $total_marks) * 100) : 0;
                            
                             // Calculate Grade
                            if ($percentage >= 90) { $grade = 'A+'; }
                            else if ($percentage >= 80) { $grade = 'A'; }
                            else if ($percentage >= 70) { $grade = 'B+'; }
                            else if ($percentage >= 60) { $grade = 'B'; }
                            else if ($percentage >= 50) { $grade = 'C'; }
                            else { $grade = 'F'; }

                            $pass_fail_status = ($percentage >= 50) ? 'LULUS' : 'GAGAL'; // Keeping logical 50 cutoff
                            
                            $statusBadge = ($pass_fail_status == 'LULUS') 
                                ? 'bg-green-100 text-green-700' 
                                : 'bg-red-100 text-red-700';
                            
                            // Formating teacher gender
                            $teacher_prefix = ($exam_row['jekel_guru'] == 'Laki-laki' || $exam_row['jekel_guru'] == 'Laki_Laki') ? 'Bpk. ' : 'Ibu. '; 

                    ?>
                        <tr class="hover:bg-pink-50/30 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-gray-600 font-medium"><?= $sno++ ?></td>
                            
                            <!-- Siswa Info -->
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-800"><?= htmlspecialchars($exam_row['nama_siswa']) ?></div>
                                <div class="text-xs text-gray-500"><?= htmlspecialchars($exam_row['nama_kelas']) ?></div>
                            </td>

                            <!-- Ujian Info -->
                            <td class="px-6 py-4">
                                <div class="text-sm font-semibold text-gray-700"><?= htmlspecialchars($exam_row['nama_nilai']) ?> <span class="text-xs text-gray-400 font-normal">(<?= htmlspecialchars($exam_row['tipe_nilai']) ?>)</span></div>
                                <div class="text-xs text-gray-500"><?= htmlspecialchars($exam_row['nama_mapel']) ?></div>
                                <div class="text-xs text-gray-400 mt-1">Pengajar: <?= $teacher_prefix . htmlspecialchars($exam_row['nama_guru']) ?></div>
                            </td>

                            <!-- Nilai -->
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-800"><?= $obtained_marks ?> <span class="text-gray-400 font-normal">/ <?= $total_marks ?></span></div>
                                <div class="text-xs text-pink-500"><?= number_format($percentage, 1) ?>%</div>
                            </td>

                             <!-- Grade -->
                             <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded text-xs font-bold bg-gray-100 text-gray-700 border border-gray-200">
                                    <?= $grade ?>
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase <?= $statusBadge ?>">
                                    <?= $pass_fail_status ?>
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <button onclick="confirmDelete(<?= $exam_row['id_nilai'] ?>)" class="text-gray-400 hover:text-red-500 transition-colors" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    <?php 
                        }
                    } else {
                         echo "<tr><td colspan='7' class='text-center py-4 text-gray-500'>Belum ada data nilai ujian.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#ujian-dataTable')) {
            $('#ujian-dataTable').DataTable().destroy();
        }
        
        var table = $('#ujian-dataTable').DataTable({
            responsive: true,
            pageLength: 10,
            ordering: true,
            info: true,
            lengthChange: false, // Hide default length change
            searching: true,
            language: {
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data ujian",
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
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Data Nilai?',
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
                 window.location.href = 'index.php?delete_id_ujian=' + id + '&ujian';
            }
        })
    }
</script>