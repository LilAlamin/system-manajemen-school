<?php
// Delete Class (Kelas)
if (isset($_GET['delete_id_kelas'])) {
    $delete_id_kelas = $_GET['delete_id_kelas'];
    $delete_class_sql = "DELETE FROM `kelas` WHERE id_kelas = '$delete_id_kelas' ";
    if ($conn->query($delete_class_sql)) {
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Kelas berhasil dihapus!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'index.php?kelas';
                });
            });
        </script>";
    } else {
        echo "<script>
            $(document).ready(function() {
                Swal.fire('Gagal!', 'Gagal menghapus kelas.', 'error');
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
    <div class="relative w-full bg-gradient-to-r from-cyan-500 to-blue-600 rounded-2xl shadow-xl overflow-hidden mb-8 p-8 text-white">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-3xl font-extrabold mb-2 tracking-tight">Kelola Kelas 🏫</h1>
                <p class="text-cyan-100 text-lg">Manajemen data kelas, jurusan, dan wali kelas.</p>
            </div>
            <div class="mt-6 md:mt-0">
                <a href="index.php?tambah_kelas" class="group relative inline-flex items-center justify-center px-6 py-3 text-base font-bold text-cyan-700 transition-all duration-200 bg-white font-pj rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white hover:bg-cyan-50 hover:shadow-lg transform hover:-translate-y-1">
                    <i class="fas fa-plus mr-2"></i> Tambah Kelas Baru
                </a>
            </div>
        </div>
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-10"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-40 h-40 rounded-full bg-white opacity-10"></div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Header with Search -->
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Daftar Kelas</h2>
                    <p class="text-sm text-gray-500 mt-1">Total: <span class="font-bold text-cyan-600"><?php $c = $conn->query("SELECT count(*) as t FROM kelas"); echo $c->fetch_assoc()['t']; ?></span> kelas terdaftar</p>
                </div>
                
                <div class="w-full md:w-auto flex items-center gap-3">
                    <div class="relative flex-grow md:flex-grow-0">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" id="customSearch" placeholder="Cari kelas..." class="block w-full md:w-80 pl-11 pr-4 py-3 text-sm text-gray-800 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all duration-200 shadow-sm hover:border-gray-300">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="kelas-dataTable">
                <thead>
                    <tr>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">No</th>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Nama Kelas</th>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Jurusan (Seksi)</th>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Mata Pelajaran</th>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Wali Kelas</th>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php
                    $class_sql = "SELECT * FROM `kelas` ORDER BY id_kelas DESC";
                    $class_result = $conn->query($class_sql);
                    $sno = 1;
                    
                    if ($class_result && $class_result->num_rows > 0) {
                        while ($class_row = $class_result->fetch_assoc()) {
                    ?>
                        <tr class="hover:bg-cyan-50/30 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-gray-600 font-medium"><?= $sno++ ?></td>
                            <td class="px-6 py-4">
                                <span class="text-lg font-bold text-gray-800"><?= htmlspecialchars($class_row['nama_kelas']) ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    <?php
                                    $section_ids = explode(',', $class_row['nama_seksi']);
                                    $shown_section = false;
                                    foreach ($section_ids as $section_id) {
                                        $section_id = trim($section_id);
                                        if(!empty($section_id)) {
                                            $fetch_section_sql = "SELECT `judul_seksi` FROM `seksi` WHERE id_seksi = '$section_id'";
                                            $fetch_section_result = $conn->query($fetch_section_sql);
                                            if($fetch_section_result && $fetch_section_result->num_rows > 0){
                                                $fetch_section_row = $fetch_section_result->fetch_assoc();
                                                echo '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-teal-50 text-teal-700 border border-teal-100">' . htmlspecialchars($fetch_section_row['judul_seksi']) . '</span>';
                                                $shown_section = true;
                                            }
                                        }
                                    }
                                    if (!$shown_section) echo '<span class="text-xs text-gray-400">-</span>';
                                    ?>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    <?php
                                    $subject_ids = explode(',', $class_row['nama_mapel']);
                                    $shown_subject = false;
                                    // Limit display for tidiness if too many
                                    $count = 0;
                                    foreach ($subject_ids as $subject_id) {
                                        $subject_id = trim($subject_id);
                                        if(!empty($subject_id)) {
                                            $fetch_subject_sql = "SELECT `nama_mapel` FROM `mapel` WHERE id_mapel = '$subject_id'";
                                            $fetch_subject_result = $conn->query($fetch_subject_sql);
                                            if($fetch_subject_result && $fetch_subject_result->num_rows > 0){
                                                $fetch_subject_row = $fetch_subject_result->fetch_assoc();
                                                if($count < 5) {
                                                     echo '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-50 text-purple-700 border border-purple-100">' . htmlspecialchars($fetch_subject_row['nama_mapel']) . '</span>';
                                                }
                                                $shown_subject = true;
                                                $count++;
                                            }
                                        }
                                    }
                                     if ($count > 5) echo '<span class="text-xs text-gray-500">+' . ($count - 5) . ' more</span>';
                                     if (!$shown_subject) echo '<span class="text-xs text-gray-400">-</span>';
                                    ?>
                                </div>
                            </td>
                            <td class="px-6 py-4"> 
                                <?php
                                $class_teacher_id = $class_row['k_id_guru'];
                                $fetch_teacher_sql = "SELECT nama_guru FROM guru WHERE id_guru = '$class_teacher_id' ";
                                $teacher_result = $conn->query($fetch_teacher_sql);
                                if ($teacher_result && $teacher_result->num_rows > 0) {
                                    $fetch_teacher_row = $teacher_result->fetch_assoc();
                                    echo '<div class="flex items-center text-sm font-medium text-gray-700"><i class="fas fa-chalkboard-teacher text-cyan-500 mr-2"></i> ' . htmlspecialchars($fetch_teacher_row['nama_guru']) . '</div>';
                                } else {
                                     echo '<span class="text-xs text-gray-400">Belum ditentukan</span>';
                                }
                                ?>
                            </td>
                            <!-- <td class="px-6 py-4 text-sm text-gray-500"> <?= date('d M Y', strtotime($class_row['created_at'])) ?> </td> -->
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center space-x-3">
                                    <a href="index.php?edit_id_kelas=<?= $class_row['id_kelas'] ?>" class="text-gray-400 hover:text-yellow-500 transition-colors" title="Edit Data">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="confirmDelete(<?= $class_row['id_kelas'] ?>)" class="text-gray-400 hover:text-red-500 transition-colors" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='6' class='px-6 py-8 text-center text-gray-500 italic'>Belum ada data kelas.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#kelas-dataTable')) {
            $('#kelas-dataTable').DataTable().destroy();
        }
        
        var table = $('#kelas-dataTable').DataTable({
            responsive: true,
            pageLength: 10,
            ordering: true,
            info: true,
            lengthChange: true,
            searching: true,
            language: {
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ kelas",
                infoEmpty: "Tidak ada data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                zeroRecords: "Tidak ada data yang cocok",
                emptyTable: "Tidak ada data kelas",
                paginate: {
                    first: '<i class="fas fa-angle-double-left"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>',
                    next: '<i class="fas fa-chevron-right"></i>',
                    previous: '<i class="fas fa-chevron-left"></i>'
                }
            },
            dom: '<"top"f>rt<"bottom-wrapper"ip><"clear">',
            columnDefs: [
                { orderable: false, targets: [2, 3, 5] }
            ]
        });
        
        $('#customSearch').on('keyup', function() {
            table.search(this.value).draw();
        });
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Kelas?',
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
                window.location.href = 'index.php?delete_id_kelas=' + id + '&kelas';
            }
        })
    }
</script>