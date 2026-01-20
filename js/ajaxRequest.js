$(document).ready(function() {
    // Ajax Call form Already Exists Email Verification
    const regex_email_check = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    $('#signup_email').on('keypress blur', function() {
        let student_email = $('#signup_email').val();
        $.ajax({
            url: 'Student/addStudent.php',
            method: 'POST',
            data: {
                checkmail: 'checkmail',
                student_email: student_email,
            },
            success: function(data) {
                // console.log(data);
                if (data != 0) {
                    $('#msgStatus2').html('<span style="color: red;"> This Email is already Exists!! Please try a different Email </span>');
                    $('#signup-btn').attr('disabled', true);
                } else if (data == 0 && regex_email_check.test(student_email)) {
                    $('#msgStatus2').html('<span style="color: green;"> There You Go!! </span>');
                    $('#signup-btn').attr('disabled', false);
                } else if (!regex_email_check.test(student_email)) {
                    $('#msgStatus2').html('<span style="color: red;"> Please Enter Valid Email e.g example@email.com </span>');
                    $('#signup-btn').attr('disabled', true);
                }
                if (student_email == "") {
                    $('#msgStatus2').html('<span style="color: red;"> Please Enter Your Email!!! </span>');
                }
            }
        })
    });
});

console.log('Ajax Request');

function addStudent(e) {

    // console.log('Signup Button Clicked');
    let signup_name = $('#signup_name').val();
    let signup_email = $('#signup_email').val();
    let signup_password = $('#signup_password').val();
    const regex_email = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

    // Form Empty Check
    if (signup_name.trim() == "") {
        $('#msgStatus1').html('<span style="color: red;"> Please Enter Your Name!!! </span>');
        $('#signup_name').focus();
        return false;
    } else if (signup_email.trim() == "") {
        $('#msgStatus2').html('<span style="color: red;"> Please Enter Your Email!!! </span>');
        $('#signup_email').focus();
        return false;
    } else if (signup_email.trim() != "" && !regex_email.test(signup_email)) {
        $('#msgStatus2').html('<span style="color: red;"> Please Enter Valid Email e.g example@email.com </span>');
        $('#signup_email').focus();
        return false;
    } else if (signup_password.trim() == "") {
        $('#msgStatus3').html('<span style="color: red;"> Please Enter Your Password!!! </span>');
        $('#signup_password').focus();
        return false;
    } else {
        $.ajax({
            url: 'Student/addStudent.php',
            method: 'POST',
            dataType: 'json',
            data: {
                signup: 'student_signup',
                student_name: signup_name,
                student_email: signup_email,
                student_password: signup_password,
            },
            success: function(data) {
                // console.log(data);
                let msg = "";
                if (data == 'OK') {
                    $('#msgAlert').html('<span class="alert alert-success"> Registration Successfully!!!</span>');
                    clearSignupFrom();
                } else if (data == 'Failed') {
                    $('#msgAlert').html('<span class="alert alert-danger"> Registration Failed!!!</span>');
                }
            }
        })
    }
}

// Empty signup Form after sending data 
function clearSignupFrom() {
    $('#student_signup_form').trigger("reset");
    // document.getElementById("student_signup_form").reset();

    $('#msgStatus1').html("");
    $('#msgStatus2').html("");
    $('#msgStatus3').html("");
}
// Show Password Function For Student Signup
function showSignupPass() {
    var x = document.getElementById("signup_password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

// Ajax Request for Login System 
function check_student_login() {
    console.log('Login Button Clicked');
    let stuLogEmail = $('#login_email').val();
    let stuLogPassword = $('#login_password').val();

    $.ajax({
        url: 'Student/addStudent.php',
        method: 'POST',
        data: {
            checkLogin: 'checkLogin',
            stuLogEmail: stuLogEmail,
            stuLogPassword: stuLogPassword,
        },
        success: function(data) {
            // console.log(data);
            if (data == 0) {
                $('.statusLogMsg').html('<small class="alert alert-danger">Invalid Email or Password!!</small>');
            } else if (data == 1) {
                $('.statusSpinner').html('<div class="spinner-border text-success role="status"> </div>');
                $('.statusLogMsg').html('<small class="alert alert-success">Login Successfully</small>');
                setTimeout(() => {
                    window.location.href = 'index.php';
                }, 1500);
            }
        }
    })
}

// Show Password Function For Student Login
function showLoginPass() {
    var x = document.getElementById("login_password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}