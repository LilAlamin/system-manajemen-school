<?php
// Insert Room (Ruangan)
if (isset($_POST['create_room'])) {
    $nama_ruangan = $_POST['room_name'];
    $kapasitas_ruangan = $_POST['room_capacity'];
    $r_id_kelas = $_POST['room_class'];
    // r_id_seksi bisa kosong jika kelas tidak punya seksi spesifik atau user tidak pilih
    $r_id_seksi = isset($_POST['room_class_section']) ? $_POST['room_class_section'] : 0; 

    // Insert to DB (Assuming r_id_seksi is integer, defaulting to 0 if null/empty)
    if(empty($r_id_seksi)) $r_id_seksi = 0;

    $insert_room_sql = "INSERT INTO `ruangan` (`nama_ruangan`, `kapasitas_ruangan`, `r_id_kelas`, `r_id_seksi`, `created_at`)
    VALUES ('$nama_ruangan', '$kapasitas_ruangan', '$r_id_kelas', '$r_id_seksi', current_timestamp())";
    
    if ($conn->query($insert_room_sql)) {
         echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Ruangan berhasil ditambahkan!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'index.php?ruangan';
                });
            });
        </script>";
    } else {
         echo "<script>
            $(document).ready(function() {
                Swal.fire('Gagal!', 'Gagal menambahkan ruangan: " . $conn->error . "', 'error');
            });
        </script>";
    }
}


// Delete Room
if (isset($_GET['delete_id_ruangan'])) {
    $delete_id_ruangan = $_GET['delete_id_ruangan'];
    $delete_room_sql = "DELETE FROM `ruangan` WHERE id_ruangan = '$delete_id_ruangan' ";
    if ($conn->query($delete_room_sql)) {
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Ruangan berhasil dihapus!',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'index.php?ruangan';
                });
            });
        </script>";
    } else {
        echo "<script>
            $(document).ready(function() {
                Swal.fire('Gagal!', 'Gagal menghapus ruangan.', 'error');
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
    <div class="relative w-full bg-gradient-to-r from-orange-500 to-red-600 rounded-2xl shadow-xl overflow-hidden mb-8 p-8 text-white">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-3xl font-extrabold mb-2 tracking-tight">Kelola Ruangan 🚪</h1>
                <p class="text-orange-100 text-lg">Manajemen ruangan kelas dan kapasitasnya.</p>
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
                        <span class="bg-orange-100 text-orange-600 p-2 rounded-lg mr-3">
                            <i class="fas fa-plus-circle"></i>
                        </span>
                        Tambah Ruangan
                    </h2>
                </div>
                <div class="p-6">
                    <form method="post">
                        <div class="mb-4">
                            <label for="room_name" class="block mb-2 text-sm font-semibold text-gray-700">Nama Ruangan</label>
                            <input type="text" id="room_name" name="room_name" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-orange-500 focus:border-orange-500 block w-full p-3 transition-all duration-200 hover:bg-white" placeholder="Contoh: R. 101, Lab Komputer">
                        </div>
                        <div class="mb-4">
                            <label for="room_capacity" class="block mb-2 text-sm font-semibold text-gray-700">Kapasitas</label>
                            <input type="number" id="room_capacity" name="room_capacity" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-orange-500 focus:border-orange-500 block w-full p-3 transition-all duration-200 hover:bg-white" placeholder="Contoh: 30">
                        </div>
                         <div class="mb-4">
                            <label for="room_class" class="block mb-2 text-sm font-semibold text-gray-700">Pilih Kelas</label>
                            <div class="relative">
                                <select id="room_class" name="room_class" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-orange-500 focus:border-orange-500 block w-full p-3 transition-all duration-200 hover:bg-white appearance-none">
                                    <option value="">-- Pilih Kelas --</option>
                                    <?php
                                    $class_sql = "SELECT id_kelas, nama_kelas FROM `kelas` ORDER BY nama_kelas ASC";
                                    $class_result = $conn->query($class_sql);
                                    while ($class_row = $class_result->fetch_assoc()) {
                                    ?>
                                        <option value="<?= $class_row['id_kelas'] ?>"><?= htmlspecialchars($class_row['nama_kelas']) ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                         <div class="mb-5 hidden" id="room_class_section_container">
                            <label for="room_class_section" class="block mb-2 text-sm font-semibold text-gray-700">Pilih Jurusan (Opsional)</label>
                             <div class="relative">
                                <select id="room_class_section" name="room_class_section" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-orange-500 focus:border-orange-500 block w-full p-3 transition-all duration-200 hover:bg-white appearance-none">
                                    <option value="">-- Pilih Jurusan --</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" name="create_room" class="flex-1 px-6 py-3 text-sm font-bold text-white bg-gradient-to-r from-orange-500 to-red-600 rounded-xl hover:shadow-lg hover:from-orange-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200">
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
                        <h2 class="text-lg font-bold text-gray-800">Daftar Ruangan</h2>
                        
                        <div class="relative w-full sm:w-64">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="customSearch" placeholder="Cari ruangan..." class="block w-full pl-10 pr-4 py-2 text-sm text-gray-800 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200">
                        </div>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="ruangan-dataTable">
                        <thead>
                            <tr>
                                <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">No</th>
                                <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Nama Ruangan</th>
                                <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Kapasitas</th>
                                <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Kelas</th>
                                <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Jurusan</th>
                                <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php
                            $room_sql = "SELECT ruangan.*, kelas.nama_kelas 
                                         FROM `ruangan` 
                                         LEFT JOIN `kelas` ON ruangan.r_id_kelas = kelas.id_kelas 
                                         ORDER BY id_ruangan DESC";
                            $room_result = $conn->query($room_sql);
                            $sno = 1;

                            if ($room_result && $room_result->num_rows > 0) {
                                while ($room_row = $room_result->fetch_assoc()) {
                            ?>
                                <tr class="hover:bg-orange-50/30 transition-colors duration-200">
                                    <td class="px-6 py-4 text-sm text-gray-600 font-medium"><?= $sno++ ?></td>
                                    <td class="px-6 py-4 text-sm font-bold text-gray-800"><?= htmlspecialchars($room_row['nama_ruangan']) ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600"><?= htmlspecialchars($room_row['kapasitas_ruangan']) ?> Kursi</td>
                                    <td class="px-6 py-4 text-sm text-gray-600"><?= htmlspecialchars($room_row['nama_kelas'] ?? '-') ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        <?php
                                        if(!empty($room_row['r_id_seksi']) && $room_row['r_id_seksi'] != 0) {
                                             $sec_id = $room_row['r_id_seksi'];
                                             $fetch_sec = $conn->query("SELECT judul_seksi FROM seksi WHERE id_seksi = '$sec_id'");
                                             if($fetch_sec->num_rows > 0){
                                                 echo htmlspecialchars($fetch_sec->fetch_assoc()['judul_seksi']);
                                             } else {
                                                 echo "-";
                                             }
                                        } else {
                                            echo "<span class='text-gray-400'>-</span>";
                                        }
                                        ?>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center space-x-3">
                                            <a href="index.php?edit_id_ruangan=<?= $room_row['id_ruangan'] ?>" class="text-gray-400 hover:text-yellow-500 transition-colors" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button onclick="confirmDelete(<?= $room_row['id_ruangan'] ?>)" class="text-gray-400 hover:text-red-500 transition-colors" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php 
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center py-4 text-gray-500'>Belum ada data ruangan.</td></tr>";
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
        if ($.fn.DataTable.isDataTable('#ruangan-dataTable')) {
            $('#ruangan-dataTable').DataTable().destroy();
        }
        
        var table = $('#ruangan-dataTable').DataTable({
            responsive: true,
            pageLength: 10,
            ordering: true,
            info: true,
            lengthChange: false, // Hide default length change
            searching: true,
            language: {
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ ruangan",
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
                { orderable: false, targets: [5] }
            ]
        });
        
        $('#customSearch').on('keyup', function() {
            table.search(this.value).draw();
        });

        // Helper AJAX for Section
        $('#room_class').on('change', function() {
            var classId = $(this).val();
            var sectionSelect = $('#room_class_section');
            var sectionContainer = $('#room_class_section_container');

            if (classId !== '') {
                $.ajax({
                    url: 'ambil_seksi.php',
                    method: 'POST',
                    data: { class_id: classId },
                    dataType: 'json',
                    success: function(data) {
                        sectionSelect.empty().append($('<option>', {
                            value: '',
                            text: '-- Pilih Jurusan --'
                        }));

                        if (data.length > 0) {
                            $.each(data, function(index, section) {
                                // Maps section.id_seksi and section.judul_seksi
                                sectionSelect.append($('<option>', {
                                    value: section.id_seksi,
                                    text: section.judul_seksi 
                                }));
                            });
                            sectionContainer.removeClass('hidden');
                        } else {
                            sectionContainer.addClass('hidden');
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.log('Error fetching sections:', errorThrown);
                        sectionContainer.addClass('hidden');
                    }
                });
            } else {
                sectionContainer.addClass('hidden');
                sectionSelect.empty();
            }
        });

    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Ruangan?',
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
                 window.location.href = 'index.php?delete_id_ruangan=' + id + '&ruangan';
            }
        })
    }
</script>