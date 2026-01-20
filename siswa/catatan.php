<div class="p-4 sm:ml-64">
    <div class="max-w-4xl mx-auto mt-4">
        
        <div class="mb-6">
             <h1 class="text-3xl font-bold text-gray-800">Catatan & Feedback</h1>
             <p class="text-gray-600 mt-1">Pesan dan evaluasi dari guru pengajar</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php
            $student_id = $_SESSION['student_id'];
            $student_class = $_SESSION['student_class'];
            
            $feedback_sql = "SELECT * FROM `catatan_siswa` WHERE `c_id_kelas` = '$student_class' AND `c_id_siswa` = '$student_id' ORDER BY id_catatan DESC";
            $feedback_result = $conn->query($feedback_sql);

            if ($feedback_result && $feedback_result->num_rows > 0) {
                while ($feedback_row = $feedback_result->fetch_assoc()) {
                    $feedback_teacher_id = $feedback_row['c_id_guru'];
                    $status = $feedback_row['status']; // Positif / Negatif
                    
                    // Fetch Teacher Data
                    $fetch_teacher_sql = "SELECT nama_guru, jekel_guru FROM guru WHERE id_guru = '$feedback_teacher_id' ";
                    $teacher_result = $conn->query($fetch_teacher_sql);
                    $fetch_teacher_row = $teacher_result->fetch_assoc();
                    
                    $teacher_name = $fetch_teacher_row['nama_guru'];
                    $teacher_gender = $fetch_teacher_row['jekel_guru'];
                    
                    // Honorifics
                    $gender_prefix = ($teacher_gender === 'Laki_Laki') ? 'Pak ' : (($teacher_gender === 'Perempuan') ? 'Ibu ' : '');
                    $teacher_full =  $gender_prefix . $teacher_name;
                    
                    // Styling based on status
                    $cardBorderColor = $status === 'Positif' ? 'border-green-200' : 'border-red-200';
                    $iconColor = $status === 'Positif' ? 'text-green-500' : 'text-red-500';
                    $bgColor = $status === 'Positif' ? 'bg-green-50' : 'bg-red-50';
                    $iconClass = $status === 'Positif' ? 'fa-thumbs-up' : 'fa-exclamation-circle';
                    
                    // Date formatting
                    $date = date("d M Y · H:i", strtotime($feedback_row['created_at']));
            ?>
                <div class="bg-white rounded-xl shadow-md border <?= $cardBorderColor ?> p-5 transition hover:shadow-lg flex flex-col h-full">
                    <div class="flex items-center gap-3 mb-3 pb-3 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div>
                             <h3 class="font-bold text-gray-800 text-lg"><?= htmlspecialchars($teacher_full) ?></h3>
                             <p class="text-xs text-gray-400">Guru Pengajar</p>
                        </div>
                        <div class="ml-auto">
                            <i class="fas <?= $iconClass ?> <?= $iconColor ?> text-xl"></i>
                        </div>
                    </div>
                    
                    <div class="<?= $bgColor ?> p-4 rounded-lg text-gray-700 italic flex-grow mb-4 relative">
                        <i class="fas fa-quote-left absolute top-2 left-2 text-gray-300 text-xs"></i>
                        <p class="pl-4"><?= htmlspecialchars($feedback_row['catatan']) ?></p>
                    </div>

                     <div class="mt-auto flex justify-between items-center text-xs text-gray-400">
                        <span><i class="far fa-clock mr-1"></i> <?= $date ?></span>
                        <span class="px-2 py-1 rounded bg-gray-100 text-gray-600 font-medium"><?= htmlspecialchars($status) ?></span>
                    </div>
                </div>
            <?php
                }
            } else {
            ?>
                <div class="col-span-1 md:col-span-2">
                     <div class="flex flex-col items-center justify-center p-12 bg-white rounded-xl border-dashed border-2 border-gray-200 text-gray-400">
                        <i class="far fa-comment-dots text-6xl mb-4 text-gray-200"></i>
                        <h3 class="text-lg font-medium text-gray-500">Belum ada catatan</h3>
                        <p class="text-sm">Anda belum menerima feedback atau catatan dari guru.</p>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        
        <div class="h-20"></div>
    </div>
</div>