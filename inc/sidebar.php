<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon"> <i class="fas fa-home"></i>  </div>
    <div class="sidebar-brand-text"><?=$_SESSION['role']?> Panel</div>
  </a>
  <!-- Nav Item - Dashboard -->
  <li class="nav-item">
    <a class="nav-link " href="dashboard.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>
<!-- Divider -->
<hr class="sidebar-divider">
  <!-- Nav Item - Dashboard -->
  <li class="nav-item ">
    <a class="nav-link" href="attendance.php">
      <i class="fas fa-address-book"></i>
      <span>Attendance</span></a>
  </li>
  <!-- Divider -->
  <hr class="sidebar-divider">
  <!-- Nav Item - Dashboard -->
  <li class="nav-item">
    <a class="nav-link" href="classes.php">
      <i class="fas fa-university"></i>
      <span>Classes</span></a>
  </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
      <a class="nav-link" href="subjects.php">
        <i class="fas fa-fw fa-book"></i>
        <span>Subjects</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
      <a class="nav-link" href="students.php">
        <i class="fas fa-fw fa-users"></i>
        <span>Students</span></a>
    </li>

      <!-- Divider -->
  <hr class="sidebar-divider">
<!-- Nav Item - Dashboard -->
<li class="nav-item">
  <a class="nav-link" href="teachers.php">
    <i class="fas fa-fw fa-users"></i>
    <span>Teachers</span></a>
</li>
  <!-- Divider -->
  <hr class="sidebar-divider">
  <!-- Nav Item - Dashboard -->
  <li class="nav-item">
    <a class="nav-link" href="exams.php">
      <i class="fas fa-fw fa-calendar"></i>
      <span>Exams</span></a>
  </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
  <!-- Nav Item - Dashboard -->
  <li class="nav-item">
    <a class="nav-link" href="results.php">
      <i class="fas fa-fw fa-graduation-cap"></i>
      <span>Results </span></a>
  </li>
  <!-- Divider -->
<hr class="sidebar-divider">
  <!-- Nav Item - Dashboard -->
  <li class="nav-item ">
    <a class="nav-link" href="uploads.php">
      <i class="fas fa-address-book"></i>
      <span>Upload</span></a>
  </li>
  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
</ul>
<!-- End of Sidebar -->