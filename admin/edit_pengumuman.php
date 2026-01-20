<div class="row my-5">
  <div class="col-md-6 mx-auto">
    <h1 class="text-center mt-3 bg-dark bg-gradient p-2 my-heading">Edit Notice</h1>
    <form method="post" enctype='multipart/form-data'>
      <?php
      if (isset($_GET['edit_notice_id'])) {
        $edit_notice_id = $_GET['edit_notice_id'];
        $sql = "SELECT * FROM `notice` WHERE notice_id = '$edit_notice_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc()
      ?>
        <div class="mb-3">
          <label for="notice_title" class="form-label">Title</label>
          <input type="text" class="form-control" id="notice_title" name="notice_title" value="<?= $row['notice_title'] ?>">
        </div>
        <div class="mb-3">
          <label for="notice_desc" class="form-label">Description</label>
          <textarea type="text" class="form-control" id="notice_desc" name="notice_desc"> <?= $row['notice_desc'] ?></textarea>
        </div>
        <div class="mb-3">
          <label for="notice_class" class="form-label">Select Class</label>
          <select id="notice_class" class="form-select" name="notice_class">
            <option value="" selected disabled>Select Class</option>
            <?php
            $fetch_class_sql = "SELECT * FROM class";
            $class_result = $conn->query($fetch_class_sql);
            while ($class_row = $class_result->fetch_assoc()) {
            ?>
              <option value="<?= $class_row['class_id'] ?>" <?php if ($row['n_class_id'] == $class_row['class_id']) { ?> selected <?php } ?>> <?php echo $class_row['class_name'] ?></option>
              <?php
            }
            ?>
            <option value="all">All</option>
          </select>
        </div>
      <?php
      }
      ?>
      <div class="mt-2 text-center">
        <button type="submit" class="btn btn-primary" name="update_notice" id="update_notice">Update</button>
        <a href="index.php?notice" class="btn btn-danger">Back</a>
      </div>
    </form>
  </div>
</div>

<?php
if (isset($_POST['update_notice'])) {;
  $notice_title = $_POST['notice_title'];
  $notice_desc = $_POST['notice_desc'];
  $notice_class = $_POST['notice_class'];
  if($_POST['notice_class'] == 'all'){
    $update_sql = "UPDATE `notice` SET notice_title = '$notice_title', notice_desc = '$notice_desc' WHERE notice_id = '$edit_notice_id' ";
  } else{
    $update_sql = "UPDATE `notice` SET notice_title = '$notice_title', notice_desc = '$notice_desc',  n_class_id = '$notice_class' WHERE notice_id = '$edit_notice_id' ";
  }
  if ($conn->query($update_sql)) {
?>
    <script>
      $(document).ready(function() {
        Swal.fire({
          title: 'Good job!',
          text: 'Notice has been Updated Successfully!',
          icon: 'success'
        }).then(() => {
          window.location.href = 'index.php?notice';
        });
      })
    </script>
  <?php
  } else {
  ?>
    <script>
      $(document).ready(function() {
        Swal.fire('Oops!', 'Notice has not been Updated', 'error');
      });
    </script>
<?php
  }
}

?>