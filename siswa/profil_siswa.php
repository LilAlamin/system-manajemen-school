<div class="p-4 sm:ml-64">
    <div class="max-w-4xl mx-auto">
        <?php
        $student_id = $_SESSION['student_id'];
        $student_sql = "SELECT * FROM `siswa` WHERE id_siswa='$student_id'";
        $student_result = $conn->query($student_sql);
        $sno = 1;
        $student_row = $student_result->fetch_assoc();
        ?>
        
        <div class="mb-6 mt-4">
             <h1 class="text-3xl font-bold text-gray-800">Profil Siswa</h1>
             <p class="text-gray-600 mt-1">Kelola informasi pribadi Anda</p>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-700">Detail Informasi</h2>
            </div>
            
            <form method="post" enctype='multipart/form-data' class="p-6">
                <!-- Name -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 pb-6 border-b border-gray-100 items-center">
                    <div class="font-medium text-gray-600">Nama Lengkap</div>
                    <div class="md:col-span-2">
                         <div class="flex items-center justify-between group">
                            <span class="text-gray-900 font-semibold text-lg"><?= $student_row['nama_siswa'] ?></span>
                            <button type="button" id="name-edit" class="text-blue-500 hover:text-blue-700 hover:bg-blue-100 p-2 rounded transition"><i class="fa fa-edit"></i></button>
                        </div>
                        <div id="name" class="hidden mt-3 bg-gray-50 p-4 rounded-lg border border-gray-200">
                             <label class="block text-sm font-medium text-gray-700 mb-1">Update Nama</label>
                             <div class="flex gap-2">
                                <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= $student_row['nama_siswa'] ?>">
                                <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition" name="name-update">Simpan</button>
                                <button type="button" id="name-cancel" class="bg-white text-gray-600 border border-gray-300 px-4 py-2 rounded-md hover:bg-gray-50 transition">Batal</button>
                             </div>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                 <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 pb-6 border-b border-gray-100 items-center">
                    <div class="font-medium text-gray-600">Email</div>
                    <div class="md:col-span-2 text-gray-900"><?= $student_row['email_siswa'] ?></div>
                </div>

                 <!-- SIMS ID -->
                 <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 pb-6 border-b border-gray-100 items-center">
                    <div class="font-medium text-gray-600">Nomor Induk (SIMS)</div>
                    <div class="md:col-span-2 text-gray-900 font-mono bg-gray-100 inline-block px-2 py-1 rounded"><?= $student_row['id_sims'] ?></div>
                </div>

                <!-- Class info -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 pb-6 border-b border-gray-100 items-center">
                     <div class="font-medium text-gray-600">Kelas / Seksi</div>
                    <div class="md:col-span-2 text-gray-900">
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">Kelas <?= $student_row['kelas_siswa'] ?></span>
                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold ml-2">Seksi <?= $student_row['seksi_siswa'] ?></span>
                    </div>
                </div>

                <!-- DOB -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 pb-6 border-b border-gray-100 items-center">
                    <div class="font-medium text-gray-600">Tanggal Lahir</div>
                    <div class="md:col-span-2">
                         <div class="flex items-center justify-between group">
                            <span class="text-gray-900"><?= $student_row['tanggal_lahir_siswa'] ?></span>
                            <button type="button" id="dob-edit" class="text-blue-500 hover:text-blue-700 hover:bg-blue-100 p-2 rounded transition"><i class="fa fa-edit"></i></button>
                        </div>
                         <div id="dob" class="hidden mt-3 bg-gray-50 p-4 rounded-lg border border-gray-200">
                             <label class="block text-sm font-medium text-gray-700 mb-1">Update Tgl Lahir</label>
                             <div class="flex gap-2">
                                <input type="date" name="dob" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= $student_row['tanggal_lahir_siswa'] ?>">
                                <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition" name="dob-update">Simpan</button>
                                <button type="button" id="dob-cancel" class="bg-white text-gray-600 border border-gray-300 px-4 py-2 rounded-md hover:bg-gray-50 transition">Batal</button>
                             </div>
                        </div>
                    </div>
                </div>

                <!-- Phone -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 pb-6 border-b border-gray-100 items-center">
                    <div class="font-medium text-gray-600">No. Telepon</div>
                     <div class="md:col-span-2">
                         <div class="flex items-center justify-between group">
                            <span class="text-gray-900"><?= $student_row['telepon_siswa'] ?></span>
                            <button type="button" id="phone-edit" class="text-blue-500 hover:text-blue-700 hover:bg-blue-100 p-2 rounded transition"><i class="fa fa-edit"></i></button>
                        </div>
                         <div id="phone" class="hidden mt-3 bg-gray-50 p-4 rounded-lg border border-gray-200">
                             <label class="block text-sm font-medium text-gray-700 mb-1">Update Telepon</label>
                             <div class="flex gap-2">
                                <input type="text" name="phone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= $student_row['telepon_siswa'] ?>">
                                <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition" name="phone-update">Simpan</button>
                                <button type="button" id="phone-cancel" class="bg-white text-gray-600 border border-gray-300 px-4 py-2 rounded-md hover:bg-gray-50 transition">Batal</button>
                             </div>
                        </div>
                    </div>
                </div>

                <!-- Address -->
                 <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 pb-6 border-b border-gray-100 items-center">
                    <div class="font-medium text-gray-600">Alamat Rumah</div>
                     <div class="md:col-span-2">
                         <div class="flex items-center justify-between group">
                            <span class="text-gray-900"><?= $student_row['alamat_siswa'] ?></span>
                            <button type="button" id="address-edit" class="text-blue-500 hover:text-blue-700 hover:bg-blue-100 p-2 rounded transition"><i class="fa fa-edit"></i></button>
                        </div>
                         <div id="address" class="hidden mt-3 bg-gray-50 p-4 rounded-lg border border-gray-200">
                             <label class="block text-sm font-medium text-gray-700 mb-1">Update Alamat</label>
                             <div class="flex gap-2">
                                <input type="text" name="address" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= $student_row['alamat_siswa'] ?>">
                                <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition" name="address-update">Simpan</button>
                                <button type="button" id="address-cancel" class="bg-white text-gray-600 border border-gray-300 px-4 py-2 rounded-md hover:bg-gray-50 transition">Batal</button>
                             </div>
                        </div>
                    </div>
                </div>

                 <!-- Age -->
                 <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 pb-6 border-b border-gray-100 items-center">
                    <div class="font-medium text-gray-600">Umur</div>
                     <div class="md:col-span-2">
                         <div class="flex items-center justify-between group">
                            <span class="text-gray-900"><?= $student_row['umur_siswa'] ?> Tahun</span>
                            <button type="button" id="age-edit" class="text-blue-500 hover:text-blue-700 hover:bg-blue-100 p-2 rounded transition"><i class="fa fa-edit"></i></button>
                        </div>
                         <div id="age" class="hidden mt-3 bg-gray-50 p-4 rounded-lg border border-gray-200">
                             <label class="block text-sm font-medium text-gray-700 mb-1">Update Umur</label>
                             <div class="flex gap-2">
                                <input type="number" name="age" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= $student_row['umur_siswa'] ?>">
                                <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition" name="age-update">Simpan</button>
                                <button type="button" id="age-cancel" class="bg-white text-gray-600 border border-gray-300 px-4 py-2 rounded-md hover:bg-gray-50 transition">Batal</button>
                             </div>
                        </div>
                    </div>
                </div>

                 <!-- Gender -->
                 <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <div class="font-medium text-gray-600">Jenis Kelamin</div>
                    <div class="md:col-span-2 text-gray-900"><?= $student_row['jekel_siswa'] ?></div>
                </div>

            </form>
        </div>

         <div class="h-20"></div>
    </div>
</div>

<?php
if (isset($_POST['name-update'])) {
    $name = $_POST['name'];
    $name_sql = "UPDATE `siswa` SET nama_siswa = '$name'  WHERE id_siswa = '$student_id'";
    if ($conn->query($name_sql)) {
        ?>
        <script>
        $(document).ready(function() {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Nama Siswa Berhasil Diperbarui!',
                icon: 'success'
            }).then(() => {
                    window.location.href = 'index.php?profil';
            });
        });
        </script>
        <?php
            } else {
            ?>
        <script>
        $(document).ready(function() {
            Swal.fire('Gagal!', 'Nama Siswa Tidak Dapat Diperbarui', 'error');
        });
        </script>
        <?php
            }
}
if (isset($_POST['dob-update'])) {
    $dob = $_POST['dob'];
    $dob_sql = "UPDATE `siswa` SET tanggal_lahir_siswa = '$dob'  WHERE id_siswa = '$student_id'";
    if ($conn->query($dob_sql)) {
        ?>
        <script>
        $(document).ready(function() {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Tanggal Lahir Berhasil Diperbarui!',
                icon: 'success'
            }).then(() => {
                    window.location.href = 'index.php?profil';
            });
        });
        </script>
        <?php
            } else {
            ?>
        <script>
        $(document).ready(function() {
            Swal.fire('Gagal!', 'Tanggal Lahir Tidak Dapat Diperbarui', 'error');
        });
        </script>
        <?php
            }
}
if (isset($_POST['phone-update'])) {
    $phone = $_POST['phone'];
    $phone_sql = "UPDATE `siswa` SET telepon_siswa = '$phone'  WHERE id_siswa = '$student_id'";
    if ($conn->query($phone_sql)) {
        ?>
        <script>
        $(document).ready(function() {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Nomor Telepon Berhasil Diperbarui!',
                icon: 'success'
            }).then(() => {
                    window.location.href = 'index.php?profil';
            });
        });
        </script>
        <?php
            } else {
            ?>
        <script>
        $(document).ready(function() {
            Swal.fire('Gagal!', 'Nomor Telepon Tidak Dapat Diperbarui', 'error');
        });
        </script>
        <?php
            }
}
if (isset($_POST['address-update'])) {
    $address = $_POST['address'];
    $address_sql = "UPDATE `siswa` SET alamat_siswa = '$address'  WHERE id_siswa = '$student_id'";
    if ($conn->query($address_sql)) {
        ?>
        <script>
        $(document).ready(function() {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Alamat Berhasil Diperbarui!',
                icon: 'success'
            }).then(() => {
                    window.location.href = 'index.php?profil';
            });
        });
        </script>
        <?php
            } else {
            ?>
        <script>
        $(document).ready(function() {
            Swal.fire('Gagal!', 'Alamat Tidak Dapat Diperbarui', 'error');
        });
        </script>
        <?php
            }
}
if (isset($_POST['age-update'])) {
    $age = $_POST['age'];
    $age_sql = "UPDATE `siswa` SET umur_siswa = '$age'  WHERE id_siswa = '$student_id'";
    if ($conn->query($age_sql)) {
        ?>
        <script>
        $(document).ready(function() {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Umur Berhasil Diperbarui!',
                icon: 'success'
            }).then(() => {
                    window.location.href = 'index.php?profil';
            });
        });
        </script>
        <?php
            } else {
            ?>
        <script>
        $(document).ready(function() {
            Swal.fire('Gagal!', 'Umur Tidak Dapat Diperbarui', 'error');
        });
        </script>
        <?php
            }
}
?>

<script>
    // Simple helper to toggle visibility logic (using jQuery as it was included in header)
    $(document).ready(function() {
        // Toggle helper
        function setupToggle(editId, areaId, cancelId) {
            $(editId).click(function() {
                $(areaId).removeClass('hidden');
            });
            $(cancelId).click(function() {
                $(areaId).addClass('hidden');
            });
        }

        setupToggle("#name-edit", "#name", "#name-cancel");
        setupToggle("#dob-edit", "#dob", "#dob-cancel");
        setupToggle("#phone-edit", "#phone", "#phone-cancel");
        setupToggle("#address-edit", "#address", "#address-cancel");
        setupToggle("#age-edit", "#age", "#age-cancel");
    });
</script>