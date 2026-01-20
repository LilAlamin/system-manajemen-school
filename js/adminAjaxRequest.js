function check_admin_login() {
    console.log('Login Button Clicked');
    let admin_email = $('#admin_email').val();
    let admin_password = $('#admin_password').val();

    $.ajax({
        url: './admin/admin_login_handler.php',
        method: 'POST',
        data: {
            checkAdmin: 'checkAdmin',
            admin_email: admin_email,
            admin_password: admin_password,
        },
        success: function(data) {
            console.log(data);
            if (data == 0) {
                $('.statusAdminMsg').html('<small class="alert alert-danger">Invalid Email or Password!!</small>');
            } else if (data == 1) {
                $('.adminSpinner').html('<div class="spinner-border text-success role="status"> </div>');
                $('.statusAdminMsg').html('<small class="alert alert-success">Login Successfully</small>');
                setTimeout(() => {
                    window.location.href = './admin/index.php?dashboard';
                }, 1500);
            }
        }
    })
}

// Show Password Function For Admin Login
function showAdminPass() {
    var x = document.getElementById("admin_password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}