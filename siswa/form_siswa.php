<div class="container my-5">
    <form action="" id="student-registration" method="post">
        <fieldset class="border border-secondary p-3 form-group">
            <legend class="d-inline w-auto h2 my-heading">Student Information</legend>
            <hr>
            <div class="row mb-3">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="student_name">Full Name</label>
                        <input type="text" class="form-control" placeholder="Full Name" name="student_name">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="student_dob">DOB</label>
                        <input type="date" required class="form-control" placeholder="DOB" name="student_dob">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="student_mobile">Phone</label>
                        <input type="text" class="form-control" placeholder="Mobile" name="student_mobile">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="student_email">Email</label>
                        <input type="email" required class="form-control" placeholder="Email Address" name="student_email">
                    </div>
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="student_country">Age</label>
                        <input type="number" class="form-control" placeholder="Country" name="student_country">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="student_gender">Select Gender</label>
                    <select class="form-select" aria-label="Default select example" name="student_gender">
                        <option selected>Gender</option>
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                        <option value="3">Other</option>
                    </select>
                </div>
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label for="student_pic" class="form-label">Insert Picture</label>
                        <input type="file" class="form-control" name="student_pic">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="father_name">Father's Name</label>
                        <input type="text" class="form-control" placeholder="Father's Name" name="father_name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="father_mobile">Father's Mobile</label>
                        <input type="number" class="form-control" placeholder="Father's Mobile" name="father_mobile">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="father_occ">Father's Occupation</label>
                        <input type="text" class="form-control" placeholder="Father's Occupation" name="father_occ">
                    </div>
                </div>
            </div>
        </fieldset>
        <!-- <div class="form-group">
            <label for="online-payment"><input type="radio" name="payment_method" value="online" id="online-payment"> Online Payment</label>
            <label for="offline-payment"><input type="radio" name="payment_method" value="offline" id="offline-payment"> Offline Payment</label>
        </div> -->
        <button type="submit" name="add_student" class="btn btn-primary"></i></span> Register</button>
    </form>
</div>