<nav class="navbar navbar-expand-sm navbar-dark ps-5 fixed-top">
  <div class="container-fluid">
    <a id="iSchool" class="navbar-brand" href="index.php">iSchool</a>
    <span class="navbar-text">Learn and Implement</span>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ps-5 custom-nav">
        <li class="nav-item">
          <a class="nav-link custom-nav-link" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link custom-nav-link" href="about.php">About</a>
        </li>
        <?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['teacher_login'])) {
    echo '<li class="nav-item">
              <a class="nav-link custom-nav-link" href="guru/index.php?profil">My Profile</a>
          </li>';
} elseif (isset($_SESSION['student_login'])) {
    echo '<li class="nav-item">
              <a class="nav-link custom-nav-link" href="siswa/index.php?student_profile">My Profile</a>
          </li>';
} elseif (isset($_SESSION['admin_login'])) {
    echo '<li class="nav-item">
              <a class="nav-link custom-nav-link" href="admin/index.php?teacher">My Profile</a>
          </li>';
} else {
    echo '<li class="nav-item">
              <a class="nav-link custom-nav-link" href="login.php">Login</a>
          </li>
          <li class="nav-item">
              <a class="nav-link custom-nav-link" href="admission.php">Admission</a>
          </li>';
}
?>
        <li class="nav-item">
          <a class="nav-link custom-nav-link" href="/contact.php">Contact Us</a>
        </li>
        <?php if(isset($_SESSION['admin_login']) || isset($_SESSION['student_login']) || isset($_SESSION['teacher_login']) ) {  ?>
        <li class="nav-item">
              <a class="nav-link custom-nav-link" href="logout.php">Logout</a>
          </li>
          <?php } ?>
      </ul>
    </div>
  </div>
</nav>