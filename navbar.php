<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$name = $_SESSION['user_name'] ?? null;
?>

<!-- navbar_guest.php -->
<style>
  nav {
    background-color: rgb(8, 114, 74);
    color: white;
    padding: 5px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
  }

  nav .logo-container {
    display: flex;
    align-items: center;
  }

  nav .logo-container img {
    height: 60px;
    padding-right: 10px;
  }

  nav .site-info {
    display: flex;
    flex-direction: column;
  }

  nav .site-info .site-name {
    font-size: 25px;
    font-weight: bold;
    font-family: Georgia, 'Times New Roman', Times, serif;
  }

  .nav-right {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-right: 50px;
  }

  .hamburger {
    font-size: 26px;
    cursor: pointer;
    background: none;
    border: none;
    color: white;
  }

  /* Right sidebar styles */
  .right-sidebar {
    position: fixed;
    top: 70px;
    right: -350px;
    width: auto;
    height: 100%;
    background-color: white;
    overflow-x: hidden;
    transition: right 0.3s ease;
    z-index: 999;
    padding: 15px;
  }

  .right-sidebar.open {
    right: 0;
  }

  .right-sidebar a {
    display: flex;
    align-items: center;    /* aligns icon and text vertically */
    color: black;
    text-decoration: none;
    font-family: 'Times New Roman', Times, serif;
    font-weight: bold;
    margin: 15px 0;
    font-size: 16px;
    transition: background 0.2s;
    padding: 8px 12px;
    border-radius: 4px;
  }

  .right-sidebar a i {
    margin-right: 10px;
  }

</style>

<nav>
  <a href="index.php" style="text-decoration: none; color: white;">
  <div class="logo-container">
    <img src="/CareerCracker/assets/logo.png" alt="Logo" />
    <div class="site-info">
      <div class="site-name">JobGPS</div>
    </div>
</div>
</a>

  <div class="nav-right">
    <button class="hamburger" onclick="toggleRightSidebar()">
      <i class="fas fa-bars"></i>
    </button>
  </div>
</nav>

<!-- Right sidebar that appears on hamburger click -->
<div id="rightSidebar" class="right-sidebar">
  <a href="index.php"><i class="fas fa-home" style="color: #007bff;"></i> Home</a>

  <a href="<?= isset($_SESSION['user_name']) ? 'experiences.php' : 'login.php' ?>">
    <i class="fas fa-book" style="color: #28a745;"></i> Experiences
  </a>

  <a href="<?= isset($_SESSION['user_name']) ? 'share_experience.php' : 'login.php' ?>">
    <i class="fas fa-pen-fancy" style="color: #ffa500;"></i> Share Experience
  </a>

  <a href="<?= isset($_SESSION['user_name']) ? 'interview_faqs.php' : 'login.php' ?>">
    <i class="fas fa-question-circle" style="color: #17a2b8;"></i> Interview FAQs
  </a>

  <a href="<?= isset($_SESSION['user_name']) ? 'job_listings.php' : 'login.php' ?>">
    <i class="fas fa-briefcase" style="color: #dc3545;"></i> Current Job Listings
  </a>

  <a href="<?= isset($_SESSION['user_name']) ? 'courses.php' : 'login.php' ?>">
    <i class="fas fa-graduation-cap" style="color: #20c997;"></i> Interview Courses
  </a>

  <a href="faqs.php">
    <i class="fas fa-brain" style="color: #6f42c1;"></i> FAQs
  </a>

  <?php if (isset($_SESSION['user_name'])): ?>
    <!-- Logged in user -->
    <a href="profile.php">
      <i class="fas fa-user" style="color: #28a745;"></i> Hello, <?= htmlspecialchars($_SESSION['user_name']) ?>
    </a>
    <a href="my_experiences.php">
      <i class="fas fa-scroll" style="color: #6f42c1;"></i>My Experiences
    </a>
    <a href="logout.php">
      <i class="fas fa-sign-out-alt" style="color: #ff4444;"></i> Logout
    </a>
  <?php else: ?>
    <!-- Guest user -->
    <a href="login.php"><i class="fas fa-sign-in-alt" style="color: #ff7f50;"></i> Login</a>
    <a href="signup.php"><i class="fas fa-user-plus" style="color: #ffc107;"></i> Signup</a>
  <?php endif; ?>
</div>


<script>
function toggleRightSidebar() {
  const sidebar = document.getElementById("rightSidebar");
  sidebar.classList.toggle("open");
  document.body.style.overflow = sidebar.classList.contains("open") ? "hidden" : "auto";
}
</script>