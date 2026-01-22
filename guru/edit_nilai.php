<div class="p-4 sm:ml-64">
    <div class="max-w-4xl mx-auto mt-10">
        <!-- Header -->
         <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-edit text-yellow-500 mr-2"></i> Edit Data Nilai
            </h1>
        </div>

        <?php
        if (isset($_GET['edit_nilai_id'])) {
            $id = $_GET['edit_nilai_id'];
            $teacher_id = $_SESSION['teacher_id'];
            $sql = "SELECT * FROM `nilai` WHERE id_nilai = '$id' AND n_id_guru = '$teacher_id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
        ?>
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-100">
            <form method="post" action="">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Nama Penilaian</label>
                            <input type="text" name="nama_nilai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= htmlspecialchars($row['nama_nilai']) ?>" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Tipe Nilai</label>
                            <select name="tipe_nilai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                <option value="Ulangan" <?= $row['tipe_nilai'] == 'Ulangan' ? 'selected' : '' ?>>Ulangan</option>
                                <option value="Tugas" <?= $row['tipe_nilai'] == 'Tugas' ? 'selected' : '' ?>>Tugas</option>
                                <option value="MID" <?= $row['tipe_nilai'] == 'MID' ? 'selected' : '' ?>>MID Semester</option>
                                <option value="UAS" <?= $row['tipe_nilai'] == 'UAS' ? 'selected' : '' ?>>UAS</option>
                            </select>
                        </div>
                         <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                            <input type="date" name="nilai_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= $row['nilai_date'] ?>" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Mata Pelajaran</label>
                            <select name="mapel_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                <?php
                                $mapel_res = $conn->query("SELECT * FROM `mapel` ORDER BY nama_mapel ASC");
                                while($m = $mapel_res->fetch_assoc()){
                                    $sel = ($row['n_id_mapel'] == $m['id_mapel']) ? 'selected' : '';
                                    echo "<option value='{$m['id_mapel']}' $sel>{$m['nama_mapel']} ({$m['kode_mapel']})</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Kelas</label>
                            <select name="kelas_id" id="kelas_selector" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                <?php
                                $kelas_res = $conn->query("SELECT * FROM `kelas` ORDER BY nama_kelas ASC");
                                while($k = $kelas_res->fetch_assoc()){
                                    $sel = ($row['n_id_kelas'] == $k['id_kelas']) ? 'selected' : '';
                                    echo "<option value='{$k['id_kelas']}' $sel>{$k['nama_kelas']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                         <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Siswa</label>
                            <select name="siswa_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                                <!-- Ideally fetch students by class via AJAX if class changes, but for edit simple fetch all or current class students -->
                                <?php
                                $curr_class = $row['n_id_kelas'];
                                $sis_res = $conn->query("SELECT * FROM `siswa` WHERE kelas_siswa = '$curr_class' ORDER BY nama_siswa ASC");
                                while($s = $sis_res->fetch_assoc()){
                                    $sel = ($row['n_id_siswa'] == $s['id_siswa']) ? 'selected' : '';
                                    echo "<option value='{$s['id_siswa']}' $sel>{$s['nama_siswa']}</option>";
                                }
                                ?>
                            </select>
                            <p class="mt-1 text-xs text-gray-500">Note: Hanya menampilkan siswa dari kelas yang tersimpan saat ini.</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Total Nilai (Max)</label>
                                <input type="number" name="total_nilai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= $row['total_nilai'] ?>" required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900">Nilai Capaian</label>
                                <input type="number" name="capaian_nilai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="<?= $row['capaian_nilai'] ?>" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end space-x-2 border-t pt-6 mt-6">
                    <a href="index.php?nilai" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">Batal</a>
                    <button type="submit" name="update_nilai" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
        <?php
            } else {
                 echo "<div class='p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50'>Data tidak ditemukan.</div>";
            }
        }
        ?>
    </div>
</div>

<?php
if(isset($_POST['update_nilai'])) {
    $id = $_GET['edit_nilai_id'];
    $nama = $_POST['nama_nilai'];
    $tipe = $_POST['tipe_nilai'];
    $mapel = $_POST['mapel_id'];
    $kelas = $_POST['kelas_id'];
    $siswa = $_POST['siswa_id'];
    $total = $_POST['total_nilai'];
    $capaian = $_POST['capaian_nilai'];
    $date = $_POST['nilai_date'];
    
    // Validation
    if($capaian > $total) {
        echo "<script>Swal.fire('Gagal!', 'Nilai capaian tidak boleh lebih besar dari total nilai.', 'error');</script>";
    } else {
        $sql = "UPDATE `nilai` SET 
                nama_nilai = '$nama',
                tipe_nilai = '$tipe',
                total_nilai = '$total',
                capaian_nilai = '$capaian',
                n_id_kelas = '$kelas',
                n_id_siswa = '$siswa',
                n_id_mapel = '$mapel',
                nilai_date = '$date'
                WHERE id_nilai = '$id' AND n_id_guru = '$teacher_id'";
        
        if($conn->query($sql)) {
             echo "<script>
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data nilai telah diperbarui.',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'index.php?nilai';
                });
            </script>";
        } else {
             echo "<script>Swal.fire('Gagal!', 'Gagal memperbarui database.', 'error');</script>";
        }
    }
}
?>