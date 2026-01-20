<?php
// Insert notice
if (isset($_POST['create_notice'])) {
  $judul = $_POST['judul_pengumuman'];
  $ket = $_POST['isi_pengumuman'];
  $kelas_id = $_POST['p_id_kelas'];
  
  // Admin Info from Session (Assuming already set in login)
  // Fallback if not set
  $pengirim = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Admin';
  $admin_id = isset($_SESSION['admin_id']) ? $_SESSION['admin_id'] : 1;
  $p_id_kirim = $admin_id . "888"; // Legacy logic

  if ($kelas_id == 'all') {
      $sql = "INSERT INTO `pengumuman` (`judul_pengumuman`, `ket_pengumuman`, `p_id_kelas`, `p_id_kirim`, `pengirim`, `tanggal_pengumuman`) 
              VALUES ('$judul', '$ket', NULL, '$p_id_kirim', '$pengirim', current_timestamp())";
  } else {
      $sql = "INSERT INTO `pengumuman` (`judul_pengumuman`, `ket_pengumuman`, `p_id_kelas`, `p_id_kirim`, `pengirim`, `tanggal_pengumuman`) 
              VALUES ('$judul', '$ket', '$kelas_id', '$p_id_kirim', '$pengirim', current_timestamp())";
  }

  if ($conn->query($sql)) {
      echo "<script>
        $(document).ready(function() {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Pengumuman berhasil dibuat!',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = 'index.php?pengumuman';
            });
        });
      </script>";
  } else {
      echo "<script>
        $(document).ready(function() {
            Swal.fire('Gagal!', 'Gagal membuat pengumuman: " . $conn->error . "', 'error');
        });
      </script>";
  }
}

// Delete notice
if (isset($_GET['delete_id_pengumuman'])) {
  $delete_id = $_GET['delete_id_pengumuman'];
  $sql = "DELETE FROM `pengumuman` WHERE id_pengumuman = '$delete_id' ";
  if ($conn->query($sql)) {
      echo "<script>
        $(document).ready(function() {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Pengumuman berhasil dihapus!',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                window.location.href = 'index.php?pengumuman';
            });
        });
      </script>";
  } else {
      echo "<script>
        $(document).ready(function() {
            Swal.fire('Gagal!', 'Gagal menghapus pengumuman.', 'error');
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
    <div class="relative w-full bg-gradient-to-r from-orange-500 to-amber-500 rounded-2xl shadow-xl overflow-hidden mb-8 p-8 text-white">
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center">
            <div>
                <h1 class="text-3xl font-extrabold mb-2 tracking-tight">Papan Pengumuman 📢</h1>
                <p class="text-orange-100 text-lg">Buat dan kelola pengumuman sekolah.</p>
            </div>
        </div>
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-10"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-40 h-40 rounded-full bg-white opacity-10"></div>
    </div>


    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Form Create -->
        <div class="w-full lg:w-1/3">
             <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden sticky top-8">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center">
                        <span class="bg-orange-100 text-orange-600 p-2 rounded-lg mr-3">
                            <i class="fas fa-plus-circle"></i>
                        </span>
                        Buat Pengumuman Baru
                    </h2>
                </div>
                <div class="p-6">
                    <form method="post">
                        <!-- Judul -->
                        <div class="mb-4">
                            <label for="judul_pengumuman" class="block mb-2 text-sm font-semibold text-gray-700">Judul Pengumuman</label>
                            <input type="text" id="judul_pengumuman" name="judul_pengumuman" required placeholder="Contoh: Libur Nasional" class="block w-full px-4 py-3 text-sm text-gray-800 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all">
                        </div>
                        
                        <!-- Isi -->
                        <div class="mb-4">
                            <label for="isi_pengumuman" class="block mb-2 text-sm font-semibold text-gray-700">Isi Pengumuman</label>
                            <textarea id="isi_pengumuman" name="isi_pengumuman" required rows="4" placeholder="Tulis detail pengumuman..." class="block w-full px-4 py-3 text-sm text-gray-800 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all"></textarea>
                        </div>

                         <!-- Target Kelas -->
                         <div class="mb-6">
                            <label for="p_id_kelas" class="block mb-2 text-sm font-semibold text-gray-700">Target Kelas</label>
                            <div class="relative">
                                <select id="p_id_kelas" name="p_id_kelas" required class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-orange-500 focus:border-orange-500 block w-full p-3 transition-all appearance-none cursor-pointer">
                                    <option value="" disabled selected>-- Pilih Target --</option>
                                    <option value="all">Semua Kelas</option>
                                    <?php
                                    $class_sql = "SELECT * FROM `kelas` ORDER BY nama_kelas ASC";
                                    $class_result = $conn->query($class_sql);
                                    while ($class_row = $class_result->fetch_assoc()) {
                                        echo "<option value='{$class_row['id_kelas']}'>{$class_row['nama_kelas']}</option>";
                                    }
                                    ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <button type="submit" name="create_notice" class="w-full px-6 py-3 text-sm font-bold text-white bg-gradient-to-r from-orange-500 to-amber-500 rounded-xl hover:shadow-lg hover:from-orange-600 hover:to-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all duration-200">
                            <i class="fas fa-paper-plane mr-2"></i> Publikasikan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table List -->
        <div class="w-full lg:w-2/3">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <!-- Header with Search -->
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <h2 class="text-lg font-bold text-gray-800">Daftar Pengumuman</h2>
                        
                        <div class="relative w-full sm:w-64">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="customSearch" placeholder="Cari pengumuman..." class="block w-full pl-10 pr-4 py-2 text-sm text-gray-800 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all duration-200">
                        </div>
                    </div>
                </div>
        
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="pengumuman-dataTable">
                        <thead>
                            <tr>
                                <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">No</th>
                                <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100 w-1/3">Judul/Isi</th>
                                <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Target</th>
                                <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Pengirim</th>
                                <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">Tanggal</th>
                                <th class="px-6 py-4 bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php
                            $sql1 = "SELECT p.*, k.nama_kelas 
                                     FROM pengumuman p 
                                     LEFT JOIN kelas k ON p.p_id_kelas = k.id_kelas
                                     ORDER BY p.tanggal_pengumuman DESC";
                            $result1 = $conn->query($sql1);
                            $sno = 1;

                            if ($result1 && $result1->num_rows > 0) {
                                while ($row = $result1->fetch_assoc()) {
                                    $target = ($row['p_id_kelas']) ? htmlspecialchars($row['nama_kelas']) : "Semua Kelas";
                                    $dateStr = date('d M Y, H:i', strtotime($row['tanggal_pengumuman']));
                            ?>
                                <tr class="hover:bg-orange-50/30 transition-colors duration-200">
                                    <td class="px-6 py-4 text-sm text-gray-600 font-medium"><?= $sno++ ?></td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-800 mb-1"><?= htmlspecialchars($row['judul_pengumuman']) ?></div>
                                        <div class="text-xs text-gray-500 line-clamp-2" title="<?= htmlspecialchars($row['ket_pengumuman']) ?>">
                                            <?= htmlspecialchars($row['ket_pengumuman']) ?>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        <?php if($row['p_id_kelas']): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <?= $target ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Global
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                         <?= htmlspecialchars($row['pengirim']) ?>
                                    </td>

                                    <td class="px-6 py-4 text-xs text-gray-500">
                                        <?= $dateStr ?>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                         <div class="flex items-center justify-center space-x-2">
                                            <!-- Edit removed as user didn't request edit. But typically edit is good. Keeping delete. -->
                                            <!-- Route for delete: index.php?delete_id_pengumuman=ID -->
                                            <button onclick="confirmDelete(<?= $row['id_pengumuman'] ?>)" class="text-gray-400 hover:text-red-500 transition-colors" title="Hapus">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php 
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center py-4 text-gray-500'>Belum ada pengumuman.</td></tr>";
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
        if ($.fn.DataTable.isDataTable('#pengumuman-dataTable')) {
            $('#pengumuman-dataTable').DataTable().destroy();
        }
        
        var table = $('#pengumuman-dataTable').DataTable({
            responsive: true,
            pageLength: 5,
            ordering: true,
            info: true,
            lengthChange: false, // Hide default length change
            searching: true,
             language: {
                info: "Menampilkan _START_ - _END_ dari _TOTAL_",
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
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Pengumuman?',
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
                 window.location.href = 'index.php?delete_id_pengumuman=' + id + '&pengumuman';
            }
        })
    }
</script>