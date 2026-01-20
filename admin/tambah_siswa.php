<?php
// Insert Student Logic
if (isset($_POST['tambah_siswa'])) {
    $nama_siswa = $_POST['nama_siswa'];
    $email_siswa = $_POST['email_siswa'];
    $password_siswa = $_POST['password_siswa'];
    $cpassword_siswa = $_POST['cpassword_siswa'];
    $kelas_siswa = $_POST['kelas_siswa'];
    $seksi_siswa = $_POST['seksi_siswa'] ?? 0;
    $tanggal_lahir_siswa = $_POST['tanggal_lahir_siswa'];
    $telepon_siswa = $_POST['telepon_siswa'];
    $alamat_siswa = $_POST['alamat_siswa'];
    $umur_siswa = $_POST['umur_siswa'];
    $jekel_siswa = $_POST['jekel_siswa'];

    
    // Generate ID SIMS
    $id_sims = date("Y") . "-SMHS-" . rand(1000, 9999);

    // Image Upload
    $foto_siswa = "";
    if (isset($_FILES['foto_siswa']['name']) && $_FILES['foto_siswa']['name'] != "") {
        $foto_siswa = time() . "_" . $_FILES['foto_siswa']['name'];
        $temp_name = $_FILES['foto_siswa']['tmp_name'];
        move_uploaded_file($temp_name, "admin_images/registration/" . $foto_siswa);
    }

    // Check Email
    $check_sql = "SELECT * FROM siswa WHERE email_siswa = '$email_siswa'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "<script>$(document).ready(function() { Swal.fire('Gagal!', 'Email sudah terdaftar!', 'error'); });</script>";
    } else {
        if ($password_siswa == $cpassword_siswa) {
            $sql = "INSERT INTO siswa (id_sims, nama_siswa, email_siswa, password_siswa, kelas_siswa, seksi_siswa, tanggal_lahir_siswa, foto_siswa, telepon_siswa, alamat_siswa, umur_siswa, jekel_siswa, tanggal_regis_siswa, status_siswa) 
                    VALUES ('$id_sims', '$nama_siswa', '$email_siswa', '$password_siswa', '$kelas_siswa', '$seksi_siswa', '$tanggal_lahir_siswa', '$foto_siswa', '$telepon_siswa', '$alamat_siswa', '$umur_siswa', '$jekel_siswa', NOW(), 'Aktif')";

            if ($conn->query($sql)) {
                echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Siswa baru berhasil ditambahkan!',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = 'index.php?siswa';
                        });
                    });
                </script>";
            } else {
                echo "<script>Swal.fire('Error!', 'Gagal menyimpan data siswa: " . $conn->error . "', 'error');</script>";
            }
        } else {
             echo "<script>$(document).ready(function() { Swal.fire('Password Salah!', 'Konfirmasi password tidak cocok.', 'error'); });</script>";
        }
    }
}
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="px-8 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <span class="bg-blue-100 text-blue-600 p-2 rounded-lg mr-3">
                    <i class="fas fa-user-plus text-lg"></i>
                </span>
                Tambah Siswa Baru
            </h2>
            <a href="index.php?siswa" class="text-gray-500 hover:text-gray-700 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </a>
        </div>
        
        <form action="" method="post" enctype="multipart/form-data" class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                
                <!-- Nama Lengkap -->
                <div class="col-span-2">
                    <label for="nama_siswa" class="block mb-2 text-sm font-semibold text-gray-700">Nama Lengkap</label>
                    <input type="text" name="nama_siswa" id="nama_siswa" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200" placeholder="Masukkan nama lengkap siswa" required>
                </div>

                <!-- Email -->
                <div>
                    <label for="email_siswa" class="block mb-2 text-sm font-semibold text-gray-700">Email / Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" name="email_siswa" id="email_siswa" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all duration-200" placeholder="email@sekolah.sch.id" required>
                    </div>
                </div>

                <!-- Telepon -->
                <div>
                    <label for="telepon_siswa" class="block mb-2 text-sm font-semibold text-gray-700">Nomor Telepon</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        <input type="text" name="telepon_siswa" id="telepon_siswa" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-3 transition-all duration-200" placeholder="08..." required>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password_siswa" class="block mb-2 text-sm font-semibold text-gray-700">Password</label>
                    <input type="password" name="password_siswa" id="password_siswa" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200" placeholder="********" required>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="cpassword_siswa" class="block mb-2 text-sm font-semibold text-gray-700">Konfirmasi Password</label>
                    <input type="password" name="cpassword_siswa" id="cpassword_siswa" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200" placeholder="********" required>
                    <p id="passwordMatchMessage" class="text-xs mt-1 font-medium min-h-[1.25rem]"></p>
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label for="tanggal_lahir_siswa" class="block mb-2 text-sm font-semibold text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir_siswa" id="tanggal_lahir_siswa" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200" required>
                </div>

                <!-- Umur -->
                <div>
                    <label for="umur_siswa" class="block mb-2 text-sm font-semibold text-gray-700">Umur (Tahun)</label>
                    <input type="number" name="umur_siswa" id="umur_siswa" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200" placeholder="Contoh: 15" required>
                </div>

                <!-- Kelas -->
                <div>
                    <label for="kelas_siswa" class="block mb-2 text-sm font-semibold text-gray-700">Kelas</label>
                    <select name="kelas_siswa" id="kelas_siswa" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200" required>
                        <option value="">-- Pilih Kelas --</option>
                        <?php
                        $class_sql = "SELECT * FROM kelas";
                        $class_result = $conn->query($class_sql);
                        while ($row = $class_result->fetch_assoc()) {
                            echo "<option value='" . $row['id_kelas'] . "'>" . $row['nama_kelas'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Seksi -->
                <div id="seksi_container" style="display:none;">
                    <label for="seksi_siswa" class="block mb-2 text-sm font-semibold text-gray-700">Seksi / Bagian</label>
                    <select name="seksi_siswa" id="seksi_siswa" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200">
                        <option value="">-- Pilih Seksi --</option>
                    </select>
                </div>

                <!-- Alamat -->
                <div class="col-span-2">
                    <label for="alamat_siswa" class="block mb-2 text-sm font-semibold text-gray-700">Alamat Lengkap</label>
                    <textarea name="alamat_siswa" id="alamat_siswa" rows="3" class="bg-gray-50 border border-gray-200 text-gray-800 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-3 transition-all duration-200 resize-none" placeholder="Alamat lengkap siswa..."></textarea>
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">Jenis Kelamin</label>
                    <div class="flex items-center space-x-6 mt-3">
                        <div class="flex items-center">
                            <input id="laki_laki" type="radio" value="Laki_Laki" name="jekel_siswa" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2" checked>
                            <label for="laki_laki" class="ml-2 text-sm font-medium text-gray-700">Laki-Laki</label>
                        </div>
                        <div class="flex items-center">
                            <input id="perempuan" type="radio" value="Perempuan" name="jekel_siswa" class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="perempuan" class="ml-2 text-sm font-medium text-gray-700">Perempuan</label>
                        </div>
                    </div>
                </div>

                <!-- Foto Siswa -->
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700" for="foto_siswa">Upload Foto</label>
                    <input class="block w-full text-sm text-gray-500 border border-gray-200 rounded-xl cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2.5 file:px-4 file:rounded-l-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700" id="foto_siswa" name="foto_siswa" type="file">
                    <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, GIF (Max. 2MB)</p>
                </div>



            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="index.php?siswa" class="px-6 py-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    Batal
                </a>
                <button type="submit" name="tambah_siswa" class="px-8 py-3 text-base font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl hover:shadow-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <i class="fas fa-save mr-2"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Password Match Check
        $("#cpassword_siswa").keyup(function() {
            var password = $("#password_siswa").val();
            var cpassword = $(this).val();
            if (password != cpassword) {
                $("#passwordMatchMessage").html("Password tidak sama!").css("color", "red");
            } else {
                $("#passwordMatchMessage").html("Password cocok.").css("color", "green");
            }
        });

        // AJAX Fetch Section
        $('#kelas_siswa').on('change', function() {
            var classId = $(this).val();
            if (classId) {
                $.ajax({
                    type: 'POST',
                    url: 'ambil_seksi.php',
                    data: { class_id: classId }, // sending class_id
                    dataType: 'json',
                    success: function(data) {
                        $('#seksi_container').show();
                        $('#seksi_siswa').empty();
                        $('#seksi_siswa').append('<option value="">-- Pilih Seksi --</option>');
                        $.each(data, function(key, value) {
                            // Expecting JSON: [{id_seksi: "1", judul_seksi: "A"}, ...]
                            // But I will fix ambil_seksi.php to return this.
                            $('#seksi_siswa').append('<option value="' + value.id_seksi + '">' + value.judul_seksi + '</option>');
                        });
                    },
                     error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log error for debugging
                        $('#seksi_container').hide(); // Hide if error or no data
                    }
                });
            } else {
                $('#seksi_container').hide();
                $('#seksi_siswa').empty();
            }
        });
    });
</script>