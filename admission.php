<style>
 #admission-body {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .my-heading {
            font-size: 28px;
            text-transform: uppercase;
            color: #333;
        }

        .form-group {
            margin: 10px 0;
            text-align: left;
        }

        label {
            display: block;
            font-weight: bold;
            color: #333;
        }

        .form-control {
            background: #f2f2f2;
            border: 1px solid #ccc;
            border-radius: 5px;
            color: #333;
            padding: 10px;
            width: 100%;
            transition: background 0.3s, border-color 0.3s, transform 0.3s;
        }

        .form-control:focus {
            background: #fff;
            border-color: #FF8C00;
            outline: none;
            transform: scale(1.02);
        }

        .btn-primary {
            background-color: #FF8C00;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
            padding: 10px 20px;
            cursor: pointer;
            text-align: center; /* Added text-align to center the button text */
        }

        /* Add animation to labels */
        .form-group label {
            transition: color 0.3s;
        }

        .form-group:hover label {
            color: #FF8C00;
        }
</style>


<?php
$title = 'iSchool - Student Admission';
require_once('partials/_head.php');
require_once('partials/_navbar.php');
require_once('partials/_connection.php');
?>

<?php
// Insert Student
if (isset($_POST['add_student'])) {
    for ($i = 0; $i < 20; $i++) {
        $stu_id = 11;
    }
    $stu_id++;
    $formatted_student_id = str_pad($stu_id, 4, '0', STR_PAD_LEFT);
    $student_class = $_POST['student_class'];
    $formatted_class_id = str_pad($student_class, 2, '0', STR_PAD_LEFT);
    $student_rollno = $formatted_student_id . "-SMHS -" .  $formatted_class_id;
    $student_name = $_POST['student_name'];
    $student_email = $_POST['student_email'];
    $student_password = $_POST['student_password'];
    $student_cpassword = $_POST['student_cpassword'];
    $student_dob = $_POST['student_dob'];
    $student_phone = $_POST['student_phone'];
    if (isset($_POST['student_class_section'])) {
        $student_class_section = $_POST['student_class_section'];
    } else {
        $student_class_section = NULL;
    }
    $student_address = $_POST['student_address'];
    $student_age = $_POST['student_age'];
    $student_gender = $_POST['student_gender'];

    $random_nums = strtotime("now");
    $student_pic = $random_nums . "_" . $_FILES['student_pic']['name'];
    $temp_pic = $_FILES['student_pic']['tmp_name'];
    move_uploaded_file($temp_pic, "admin_images/registration/$student_pic");

    $father_cnic = $_POST['cnic'];

    $check_sql = "SELECT * FROM students WHERE student_email = '$student_email' ";
    $check_result = $conn->query($check_sql);
    $check_count = mysqli_num_rows($check_result);
    if ($check_count > 0) {
?>
        <script>
            $(document).ready(function() {
                Swal.fire('Registration Failed!',
                    'This Email is already Registered, So try a different Email',
                    'error')
            });
        </script>
        <?php
    } else {
        if ($student_password == $student_cpassword) {

            $insert_student_sql = "INSERT INTO `students` (`student_rollno`, `student_name`, `student_email`, `student_password`, `student_dob`,`student_phone`, `student_class`, `student_section`, `student_address`, `student_age`,`student_gender`, `student_pic`, `father_cnic`, `student_admission_date`) VALUES ('$student_rollno', '$student_name', '$student_email', '$student_password', '$student_dob','$student_phone', '$student_class', '$student_class_section', '$student_address', '$student_age','$student_gender', '$student_pic', '$father_cnic', current_timestamp());";
            if ($conn->query($insert_student_sql)) {
        ?>
                <script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Good job!',
                            text: 'Student Record has been Added Successfully!',
                            icon: 'success'
                        }).then(() => {
                            window.location.href = 'index.php?student';
                        });
                    });
                </script>
            <?php
            } else {

            ?>
                <script>
                    $(document).ready(function() {
                        Swal.fire('Error!',
                            'Student Record has not been Inserted!',
                            'error')
                    });
                </script>;
            <?php
            }
        } else {
            ?>
            <script>
                $(document).ready(function() {
                    Swal.fire('Error!',
                        'Your Password must be same, So Please try again and type same Password',
                        'error')
                });
            </script>
<?php
        }
    }
}
?>

<div class="bg-dark">
    <div class="row">
        <img src="assets/images//banner.jpg" alt="Banner" style="height: 100px; width:100%; object-fit: cover; box-shadow: 10px;">
    </div>
</div>
<div id="admission-body">
    <div class="container my-5">
        <form action="" class="mt-5" id="student-registration" method="post" enctype="multipart/form-data">
            <h1 class="text-center my-3 bg-dark bg-gradient p-2 my-heading">Get Admission in School Management System</h1>
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="student_name">Full Name</label>
                        <input type="hidden" name="student_id">
                        <input type="text" class="form-control" placeholder="Full Name" name="student_name">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="student_email">Email</label>
                        <input type="email" required class="form-control" placeholder="Email Address" name="student_email">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="student_password">Password</label>
                        <input type="password" required class="form-control" placeholder="Password" name="student_password" id="student_password">
                        <div class="ms-3 mt-1">
                            <input type="checkbox" class="my-1 form-check-input" onClick="myFunction()"> &nbsp;Show Password
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="student_password">Confirm Password</label>
                        <input type="password" required class="form-control" placeholder="Password" name="student_cpassword" id="student_cpassword">
                        <div class="ms-3 mt-1">
                            <input type="checkbox" class="my-1 form-check-input" onClick="myFunction1()"> &nbsp;Show Password
                        </div>
                    </div>
                </div>
            </div>
            <div class="registrationFormAlert mb-3" style="color:green;" id="CheckPasswordMatch"></div>
            <div class="row mb-3">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="student_dob">DOB</label>
                        <input type="date" required class="form-control" placeholder="DOB" name="student_dob">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="student_phone">Phone</label>
                        <input type="text" class="form-control" placeholder="Phone" name="student_phone">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6" id="student_class_container">
                    <label for="student_class" class="form-label">Select Class</label>
                    <select id="student_class" class="form-select" name="student_class" required>
                        <option value="" selected>Select Class</option>
                        <?php
                        $class_sql = "SELECT * FROM `class`";
                        $class_result = $conn->query($class_sql);
                        while ($class_row = $class_result->fetch_assoc()) {
                        ?>
                            <option value="<?= $class_row['class_id'] ?>"><?= $class_row['class_name'] ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6" id="student_class_section_container">
                    <label for="student_class_section" class="form-label">Select Section</label>
                    <select id="student_class_section" class="form-select" name="student_class_section">
                        <option value="" selected>Select Section</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="student_address">Address</label>
                        <input type="text" class="form-control" placeholder="Address" name="student_address">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md">
                    <div class="form-group">
                        <label for="student_age">Age</label>
                        <input type="number" class="form-control" placeholder="Age" name="student_age">
                    </div>
                </div>
                <div class="col-md mt-4 ms-5">
                    <label for="student_gender" class="form-label">Gender &nbsp;&nbsp;&nbsp;</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="male" value="Male" name="student_gender">
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="female" value="Female" name="student_gender">
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="student_pic" class="form-label">Insert Picture</label>
                        <input type="file" class="form-control" name="student_pic">
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="cnic">Father CNIC</label>
                    <input type="text" class="form-control" placeholder="CNIC" name="cnic" required>
                    <span id="cnic-error-message" style="color: red;"></span>
                </div>
            </div>
            <button type="submit" name="add_student" id="add_student" class="btn btn-primary"></i></span> Register</button>
        </form>
    </div>
</div>

<script>
    function myFunction() {
        var x = document.getElementById("student_password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function myFunction1() {
        var cx = document.getElementById("student_cpassword");
        if (cx.type === "password") {
            cx.type = "text";
        } else {
            cx.type = "password";
        }
    }

    function checkPasswordMatch() {
        var password = $("#student_password").val();
        var confirmPassword = $("#student_cpassword").val();
        if (password != confirmPassword)
            $("#CheckPasswordMatch").html("Passwords do not match!");
        else
            $("#CheckPasswordMatch").html("Passwords match.");
    }

    $(document).ready(function() {
        $("#student_cpassword").keyup(checkPasswordMatch);
    });
</script>

<script>
    $(document).ready(function() {
        $('#student_class').on('change', function() {
            var classId = $(this).val();
            if (classId !== '') {
                $.ajax({
                    url: 'admin/get_sections.php',
                    method: 'POST',
                    data: {
                        class_id: classId
                    },
                    dataType: 'json',
                    success: function(data) {
                        var sectionContainer = $('#student_class_section_container');
                        var sectionSelect = $('#student_class_section');

                        sectionSelect.empty().append($('<option>', {
                            value: '',
                            text: 'Select Class Section'
                        }));

                        if (data.length > 0) {
                            $.each(data, function(index, section) {
                                sectionSelect.append($('<option>', {
                                    value: section.section_id,
                                    text: section.section_title
                                }));
                            });

                            // Show the section selection container
                            sectionContainer.show();
                        } else {
                            // Hide the section selection container
                            sectionContainer.hide();
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.log('Error:', errorThrown);
                    }
                });
            } else {
                // Hide the section selection container
                $('#student_class_section_container').hide();
                $('#student_class_section').empty().append($('<option>', {
                    value: '',
                    text: 'Select Class Section'
                }));
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $("#parent_cpassword").keyup(checkPasswordMatch);

        $("input[name='cnic']").change(function() {
            var cnicInput = $(this);
            var cnic = cnicInput.val();
            var cnicRegex = /^[0-9]{5}-[0-9]{7}-[0-9]$/;
            var errorMessage = $("#cnic-error-message");

            if (cnicRegex.test(cnic)) {
                errorMessage.html("<span class='text-success'>Valid CNIC</span>");
            } else {
                errorMessage.html("CNIC is not valid. Please enter a valid CNIC in the format: 12345-1234567-1");
                cnicInput.val("0");
            }
        });
    });
</script>

<?php
require_once('partials/_footer.php');
require_once('partials/_bottom.php');
?>