<?php
// Insert Period (Sesi)
if (isset($_POST['create_period'])) {
    $nama_sesi = $_POST['period_name'];
    $jam_mulai_sesi = $_POST['period_start_time'];
    $jam_berakhir_sesi = $_POST['period_end_time'];

    $insert_period_sql = "INSERT INTO `sesi` (`nama_sesi`, `jam_mulai_sesi`, `jam_berakhir_sesi`, `created_at`)
    VALUES ('$nama_sesi', '$jam_mulai_sesi', '$jam_berakhir_sesi', current_timestamp())";
    
    if ($conn->query($insert_period_sql)) {
         echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Sesi/Periode berhasil ditambahkan!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'index.php?periode';
                });
            });
        </script>";
    } else {
         echo "<script>
            $(document).ready(function() {
                Swal.fire('Gagal!', 'Gagal menambahkan sesi: " . $conn->error . "', 'error');
            });
        </script>";
    }
}


// Delete Period
if (isset($_GET['delete_id_periode'])) {
    $delete_id_periode = $_GET['delete_id_periode'];
    $delete_period_sql = "DELETE FROM `sesi` WHERE id_sesi = '$delete_id_periode' ";
    if ($conn->query($delete_period_sql)) {
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Sesi/Periode berhasil dihapus!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'index.php?periode';
                });
            });
        </script>";
    } else {
        echo "<script>
            $(document).ready(function() {
                Swal.fire('Gagal!', 'Gagal menghapus sesi.', 'error');
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
                <h1 class="text-3xl font-extrabold mb-2 tracking-tight">Kelola Sesi/Periode ⏰</h1>
                <p class="text-pink-100 text-lg">Manajemen waktu dan sesi pembelajaran.</p>
            </div>
        </div>
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-10"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-40 h-40 rounded-full bg-white opacity-10"></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Form Create Data -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden sticky top-24">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center">
                        <span class="bg-pink-100 text-pink-600 p-2 rounded-lg mr-3">
                            <i class="fas fa-plus-circle"></i>
                        </span>
                        Tambah Sesi
                    </h2>
                </div>
                <div class="p-6">
                    <form method="post">
                        <div class="mb-4">
                            <label for="period_name" class="block mb-2 text-sm font-semibold text-gray-700">Nama Sesi</label>
                            <input type="text" id="period_name" name="period_name" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block w-full p-3 transition-all duration-200 hover:bg-white" placeholder="Contoh: Sesi 1, Istirahat">
                        </div>
                        <div class="mb-4">
                            <label for="period_start_time" class="block mb-2 text-sm font-semibold text-gray-700">Jam Mulai</label>
                            <input type="time" id="period_start_time" name="period_start_time" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block w-full p-3 transition-all duration-200 hover:bg-white">
                        </div>
                        <div class="mb-5">
                            <label for="period_end_time" class="block mb-2 text-sm font-semibold text-gray-700">Jam Selesai</label>
                            <input type="time" id="period_end_time" name="period_end_time" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-pink-500 focus:border-pink-500 block w-full p-3 transition-all duration-200 hover:bg-white">
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" name="create_period" class="flex-1 px-6 py-3 text-sm font-bold text-white bg-gradient-to-r from-pink-500 to-rose-600 rounded-xl hover:shadow-lg hover:from-pink-600 hover:to-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all duration-200">
                                <i class="fas fa-save mr-2"></i> Simpan
                            </button>
                            <button type="reset" class="px-4 py-3 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 focus:outline-none transition-all duration-200">
                                <i class="fas fa-undo"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table Data -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <!-- Header with Search -->
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <h2 class="text-lg font-bold text-gray-800">Daftar Sesi</h2>
                        
                        <div class="relative w-full sm:w-64">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="customSearch" placeholder="Cari sesi..." class="block w-full pl-10 pr-4 py-2 text-sm text-gray-800 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all duration-200">
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="periode-dataTable">
                        <thead>
                            <tr>
                                <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">No</th>
                                <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Nama Sesi</th>
                                <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Mulai</th>
                                <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Selesai</th>
                                <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php
                            $period_sql = "SELECT * FROM `sesi` ORDER BY jam_mulai_sesi ASC";
                            $period_result = $conn->query($period_sql);
                            $sno = 1;

                            if ($period_result && $period_result->num_rows > 0) {
                                while ($period_row = $period_result->fetch_assoc()) {
                            ?>
                                <tr class="hover:bg-pink-50/30 transition-colors duration-200">
                                    <td class="px-6 py-4 text-sm text-gray-600 font-medium"><?= $sno++ ?></td>
                                    <td class="px-6 py-4 text-sm font-bold text-gray-800"><?= htmlspecialchars($period_row['nama_sesi']) ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold"><?= htmlspecialchars($period_row['jam_mulai_sesi']) ?></span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-semibold"><?= htmlspecialchars($period_row['jam_berakhir_sesi']) ?></span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center space-x-3">
                                            <a href="index.php?edit_id_periode=<?= $period_row['id_sesi'] ?>" class="text-gray-400 hover:text-yellow-500 transition-colors" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button onclick="confirmDelete(<?= $period_row['id_sesi'] ?>)" class="text-gray-400 hover:text-red-500 transition-colors" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php 
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center py-4 text-gray-500'>Belum ada data sesi.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#periode-dataTable')) {
            $('#periode-dataTable').DataTable().destroy();
        }
        
        var table = $('#periode-dataTable').DataTable({
            responsive: true,
            pageLength: 10,
            ordering: true,
            info: true,
            lengthChange: false, // Hide default length change
            searching: true,
            language: {
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ sesi",
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
                { orderable: false, targets: [4] }
            ]
        });
        
        $('#customSearch').on('keyup', function() {
            table.search(this.value).draw();
        });
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Sesi?',
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
                 window.location.href = 'index.php?delete_id_periode=' + id + '&periode';
            }
        })
    }
</script>