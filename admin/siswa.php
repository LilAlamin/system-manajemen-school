<?php
// Delete Student Logic
if (isset($_GET['delete_id_siswa'])) {
    $delete_id_siswa = $_GET['delete_id_siswa'];
    $delete_sql = "DELETE FROM `siswa` WHERE id_siswa = '$delete_id_siswa' ";
    if ($conn->query($delete_sql)) {
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data Siswa berhasil dihapus!',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = 'index.php?siswa';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire('Gagal!', 'Data Siswa gagal dihapus', 'error');
        </script>";
    }
}
?>

<!-- Custom DataTables Styling -->
<style>
    /* Hide default DataTables search and length */
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_length {
        display: none;
    }
    
    /* Custom Pagination Styling */
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
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        background: #f3f4f6;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        transform: none;
        box-shadow: none;
        background: #f3f4f6;
        border-color: #e5e7eb;
        color: #9ca3af;
    }
    
    /* Info styling */
    .dataTables_wrapper .dataTables_info {
        padding: 16px 24px;
        color: #6b7280;
        font-size: 14px;
    }
    
    /* Bottom wrapper */
    .dataTables_wrapper .bottom-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #f3f4f6;
        background: #fafbfc;
        border-radius: 0 0 16px 16px;
    }
</style>

<!-- Premium Light Theme Layout -->
<div class="container mx-auto px-4 py-8">
    
    <!-- Banner Section -->
    <div class="relative w-full bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl overflow-hidden mb-8 p-8 text-white">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-3xl font-extrabold mb-2 tracking-tight">Kelola Data Siswa 🎓</h1>
                <p class="text-blue-100 text-lg">Manajemen informasi lengkap siswa sekolah.</p>
            </div>
            <div class="mt-6 md:mt-0">
                <a href="index.php?tambah_siswa" class="group relative inline-flex items-center justify-center px-6 py-3 text-base font-bold text-blue-700 transition-all duration-200 bg-white font-pj rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white hover:bg-blue-50 hover:shadow-lg transform hover:-translate-y-1">
                    <i class="fas fa-plus mr-2"></i> Tambah Siswa Baru
                </a>
            </div>
        </div>
        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-10"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-40 h-40 rounded-full bg-white opacity-10"></div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Header with Search -->
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Daftar Siswa</h2>
                    <p class="text-sm text-gray-500 mt-1">Total: <span class="font-bold text-blue-600"><?php $c = $conn->query("SELECT count(*) as t FROM siswa"); echo $c->fetch_assoc()['t']; ?></span> siswa terdaftar</p>
                </div>
                
                <!-- Custom Search Box -->
                <div class="w-full md:w-auto flex items-center gap-3">
                    <div class="relative flex-grow md:flex-grow-0">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" id="customSearch" placeholder="Cari siswa..." class="block w-full md:w-80 pl-11 pr-4 py-3 text-sm text-gray-800 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm hover:border-gray-300">
                    </div>
                    
                    <!-- Entries Dropdown -->
                    <div class="relative">
                        <select id="customLength" class="appearance-none bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-10 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer shadow-sm hover:border-gray-300 transition-all duration-200">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="student-dataTable">
                <thead>
                    <tr>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">No</th>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Profil</th>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Nama Lengkap</th>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">ID SIMS</th>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Kelas & Seksi</th>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Status</th>
                        <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php
                    $sql = "SELECT siswa.*, kelas.nama_kelas, seksi.judul_seksi 
                            FROM siswa 
                            LEFT JOIN kelas ON siswa.kelas_siswa = kelas.id_kelas 
                            LEFT JOIN seksi ON siswa.seksi_siswa = seksi.id_seksi
                            ORDER BY id_siswa DESC";
                    $result = $conn->query($sql);
                    $no = 1;
                    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                        <tr class="hover:bg-blue-50/30 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                <?= $no++ ?>
                            </td>
                            <td class="px-6 py-4">
                                <?php if (!empty($row['foto_siswa'])): ?>
                                    <div class="h-10 w-10 rounded-full ring-2 ring-white shadow-sm overflow-hidden">
                                        <img src="admin_images/registration/<?= htmlspecialchars($row['foto_siswa']) ?>" alt="Foto" class="h-full w-full object-cover">
                                    </div>
                                <?php else: ?>
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 ring-2 ring-white shadow-sm">
                                        <i class="fas fa-user"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-gray-800"><?= htmlspecialchars($row['nama_siswa']) ?></span>
                                <div class="text-xs text-gray-500 mt-0.5"><?= htmlspecialchars($row['email_siswa']) ?></div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-mono">
                                <?= htmlspecialchars($row['id_sims']) ?>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                    <?= htmlspecialchars($row['nama_kelas'] ?? '-') ?>
                                </span>
                                <span class="text-xs text-gray-400 ml-1"><?= htmlspecialchars($row['judul_seksi'] ?? '') ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <?php if ($row['status_siswa'] == 'Aktif'): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span> Aktif
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/20">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span> Non-Aktif
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center space-x-3">
                                    <a href="index.php?lihat_id_siswa=<?= $row['id_siswa'] ?>" class="text-gray-400 hover:text-blue-600 transition-colors" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="index.php?edit_id_siswa=<?= $row['id_siswa'] ?>" class="text-gray-400 hover:text-yellow-500 transition-colors" title="Edit Data">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="confirmDelete(<?= $row['id_siswa'] ?>)" class="text-gray-400 hover:text-red-500 transition-colors" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='7' class='px-6 py-8 text-center text-gray-500 italic'>Belum ada data siswa. Silahkan tambah siswa baru.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Check if DataTable is already initialized
        if ($.fn.DataTable.isDataTable('#student-dataTable')) {
            // If already initialized, destroy it first
            $('#student-dataTable').DataTable().destroy();
        }
        
        // Initialize DataTable with custom config
        var table = $('#student-dataTable').DataTable({
            responsive: true,
            pageLength: 10,
            ordering: true,
            info: true,
            lengthChange: true,
            searching: true,
            language: {
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ siswa",
                infoEmpty: "Tidak ada data",
                infoFiltered: "(disaring dari _MAX_ total data)",
                zeroRecords: "Tidak ada data yang cocok",
                emptyTable: "Tidak ada data siswa",
                paginate: {
                    first: '<i class="fas fa-angle-double-left"></i>',
                    last: '<i class="fas fa-angle-double-right"></i>',
                    next: '<i class="fas fa-chevron-right"></i>',
                    previous: '<i class="fas fa-chevron-left"></i>'
                }
            },
            dom: '<"top"f>rt<"bottom-wrapper"ip><"clear">',
            columnDefs: [
                { orderable: false, targets: [1, 6] } // Disable sorting on Photo and Action columns
            ]
        });
        
        // Custom search box functionality
        $('#customSearch').on('keyup', function() {
            table.search(this.value).draw();
        });
        
        // Custom length dropdown
        $('#customLength').on('change', function() {
            table.page.len(this.value).draw();
        });
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Siswa?',
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
                window.location.href = 'index.php?delete_id_siswa=' + id;
            }
        })
    }
</script>