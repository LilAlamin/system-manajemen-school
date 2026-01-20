<!-- Modal Tambah Pengumuman (Sama dengan pengumuman.php untuk konsistensi) -->
<div id="noticeModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center bg-gray-900/50 backdrop-blur-sm">
    <div class="relative w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-xl">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900">
                    Tambah Pengumuman
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="noticeModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form method="post">
                <div class="p-6 space-y-6">
                    <div>
                        <label for="judul_pengumuman" class="block mb-2 text-sm font-medium text-gray-900">Judul</label>
                        <input type="text" name="judul_pengumuman" id="judul_pengumuman" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Contoh: Libur Nasional" required>
                    </div>
                    <div>
                        <label for="ket_pengumuman" class="block mb-2 text-sm font-medium text-gray-900">Isi Pengumuman</label>
                        <textarea name="ket_pengumuman" id="ket_pengumuman" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Tulis isi pengumuman di sini..." required></textarea>
                    </div>
                    <div>
                        <label for="p_id_kelas" class="block mb-2 text-sm font-medium text-gray-900">Target Kelas (Opsional)</label>
                        <select id="p_id_kelas" name="p_id_kelas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">Semua Kelas</option>
                            <?php
                            $kelas_sql = "SELECT * FROM `kelas` ORDER BY nama_kelas ASC";
                            $kelas_result = $conn->query($kelas_sql);
                            while ($kelas_row = $kelas_result->fetch_assoc()) {
                            ?>
                                <option value="<?= $kelas_row['id_kelas'] ?>"><?= $kelas_row['nama_kelas'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Biarkan kosong jika untuk semua siswa.</p>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b">
                    <button type="submit" name="tambah_pengumuman" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Posting</button>
                    <button data-modal-hide="noticeModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="p-4 sm:ml-64">
    <div class="max-w-4xl mx-auto mt-10">
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-bullhorn text-blue-600 mr-2"></i> Pengumuman Saya
            </h1>
            <button data-modal-target="noticeModal" data-modal-toggle="noticeModal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center shadow-lg transform hover:-translate-y-0.5 transition" type="button">
                <i class="fas fa-plus mr-1"></i> Buat Pengumuman
            </button>
        </div>

        <div class="space-y-6">
            <?php
            $teacher_id = $_SESSION['teacher_id'];
            $p_id_kirim = $teacher_id . '555';

            $notice_sql = "SELECT * FROM `pengumuman` WHERE p_id_kirim = '$p_id_kirim' ORDER BY id_pengumuman DESC";
            $notice_result = $conn->query($notice_sql);
            
            if ($notice_result->num_rows > 0) {
                while ($notice_row = $notice_result->fetch_assoc()) {
                    $desc = strip_tags($notice_row['ket_pengumuman']);
                    $limited_text = strlen($desc) > 200 ? substr($desc, 0, 200) . "..." : $desc;

                    // Fetch Class Name
                    $class_name = "Semua";
                    if($notice_row['p_id_kelas']){
                        $notice_class_id = $notice_row['p_id_kelas'];
                        $class_result = $conn->query("SELECT nama_kelas FROM kelas WHERE id_kelas = '$notice_class_id'");
                        if($class_row = $class_result->fetch_assoc()){
                            $class_name = $class_row['nama_kelas'];
                        }
                    }
            ?>
                <!-- Card -->
                <div class="bg-white rounded-lg shadow-md border border-gray-100 hover:shadow-lg transition duration-200 overflow-hidden relative">
                    <!-- Color Line -->
                    <div class="h-1 w-full bg-gradient-to-r from-green-500 to-teal-400"></div>
                     <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h5 class="text-xl font-bold text-gray-800 mb-1"><?= htmlspecialchars($notice_row['judul_pengumuman']) ?></h5>
                                <span class="text-xs text-gray-500">
                                   <i class="far fa-calendar-alt mr-1"></i> <?= date('d M Y', strtotime($notice_row['tanggal_pengumuman'])) ?>
                                </span>
                            </div>
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded border border-blue-400">
                                <?= htmlspecialchars($class_name) ?>
                            </span>
                        </div>
                        
                        <p class="text-gray-600 mb-6">
                            <?= htmlspecialchars($limited_text) ?>
                        </p>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <a href="index.php?lihat_pengumuman_id=<?= $notice_row['id_pengumuman'] ?>" class="text-blue-600 hover:text-blue-800 font-medium text-sm">Read More</a>
                            
                            <div class="flex space-x-2">
                                <a href="index.php?edit_pengumuman_id=<?= $notice_row['id_pengumuman'] ?>" class="text-yellow-500 hover:text-yellow-600 border border-yellow-200 bg-yellow-50 hover:bg-yellow-100 font-medium rounded-lg text-xs px-3 py-1.5 transition">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <a href="index.php?hapus_pengumuman_id=<?= $notice_row['id_pengumuman'] ?>" class="text-red-600 hover:text-red-700 border border-red-200 bg-red-50 hover:bg-red-100 font-medium rounded-lg text-xs px-3 py-1.5 transition delete-btn">
                                    <i class="fas fa-trash-alt mr-1"></i> Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                }
            } else {
                 echo "<div class='text-center py-10 bg-white rounded-lg shadow-sm border border-gray-200'>
                        <div class='text-gray-400 mb-3'><i class='fas fa-file-alt text-4xl'></i></div>
                        <p class='text-gray-500'>Anda belum membuat pengumuman apapun.</p>
                      </div>";
            }
            ?>
        </div>
    </div>
</div>

<?php
// Handle Add Notice Logic
if (isset($_POST['tambah_pengumuman'])) {
    $judul = $_POST['judul_pengumuman'];
    $ket = $_POST['ket_pengumuman'];
    $kelas_id = !empty($_POST['p_id_kelas']) ? $_POST['p_id_kelas'] : "NULL";
    
    // Identity logic
    $teacher_id = $_SESSION['teacher_id'];
    $teacher_name = $_SESSION['teacher_name']; 
    $p_id_kirim = $teacher_id . '555'; 
    
    $kelas_val = ($kelas_id === "NULL") ? "NULL" : "'$kelas_id'";

    $sql = "INSERT INTO `pengumuman` (`judul_pengumuman`, `ket_pengumuman`, `p_id_kelas`, `p_id_kirim`, `pengirim`, `tanggal_pengumuman`) 
            VALUES ('$judul', '$ket', $kelas_val, '$p_id_kirim', '$teacher_name', NOW())";

    if ($conn->query($sql)) {
        echo "<script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Pengumuman berhasil ditambahkan!',
                icon: 'success'
            }).then(() => {
                window.location.href = 'index.php?pengumuman_saya';
            });
        </script>";
    } else {
        echo "<script>Swal.fire('Gagal!', 'Terjadi kesalahan: " . $conn->error . "', 'error');</script>";
    }
}

// Handle Delete Logic
if (isset($_GET['hapus_pengumuman_id'])) {
    $id = $_GET['hapus_pengumuman_id'];
    // Validasi hapus hanya milik sendiri
    $del_sql = "DELETE FROM `pengumuman` WHERE id_pengumuman = '$id' AND p_id_kirim = '$p_id_kirim'";
    if($conn->query($del_sql)){
         echo "<script>
            Swal.fire({
                title: 'Terhapus!',
                text: 'Pengumuman berhasil dihapus.',
                icon: 'success'
            }).then(() => {
                window.location.href = 'index.php?pengumuman_saya';
            });
        </script>";
    } else {
        echo "<script>Swal.fire('Gagal!', 'Gagal menghapus pengumuman.', 'error');</script>";
    }
}
?>

<!-- Flowbite JS for Modal -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>

<script>
    $('.delete-btn').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak akan dapat mengembalikan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
            }
        })
    });
</script>