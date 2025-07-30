<?php
session_start();
$name = $_SESSION['user_name'] ?? null;
$isLoggedIn = isset($_SESSION['user_name']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Career Cracker</title>

  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      font-family: Arial, sans-serif;
      background: url("https://www.elegantthemes.com/blog/wp-content/uploads/2013/09/bg-11-full.jpg");
      margin: 0;
      padding: 0;
      text-align: center;
    }

    .landing-container {
      padding: 2rem;
    }

    .landing-title {
      color: rgb(179, 7, 64);
      font-size: 35px;
      font-family: Georgia, 'Times New Roman', Times, serif;
      font-weight: bold;
    }

    .subtitle {
      color: rgb(16, 107, 173);
      margin-bottom: 2rem;
      font-size: 18px;
    }

    .services-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 25px;
      padding: 20px;
      justify-content: center;
    }

    .service-card {
      background: rgba(237, 241, 241, 0.9);
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      padding: 1.5rem;
      transition: transform 0.3s ease;
    }

    .service-icon {
      font-size: 2.5rem;
      margin-bottom: 0.5rem;
    }

    .service-card h3 {
      margin: 0.5rem 0;
    }

    .service-card p {
      color: #555;
    }

    a.service-link {
      text-decoration: none;
      color: inherit;
      display: block;
    }

    @media screen and (max-width: 786px) {
      .landing-container {
      padding: 2rem;
    }

    .landing-title {
      font-size: 35px;
    }

    .subtitle {
      font-size: 14px;
    }

    .services-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1rem;
      padding: 1rem;
    }

    .service-card {
      width: 145px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      padding: 15px;
    }

    .service-icon {
      font-size: 2rem;
      margin-bottom: 0.5rem;
    }

    .service-card h3 {
      margin: 0.2rem 0;
    }

    .service-card p {
      color: #555;
      font-size: 12px;
    }

    a.service-link {
      text-decoration: none;
      color: inherit;
      display: block;
    }
    }

  </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<main class="landing-container">
  <br><br><br>
  <h1 class="landing-title">JobGPS</h1>

  <p class="subtitle">
    <strong> "Map Your Future with Real Insights and Smart Prep."</strong><br>
    Prepare smarter with real interview experiences, FAQs, free courses, and job updates — All in one place.
  </p>

  <div class="services-grid" id="servicesGrid">
    <!-- Cards will be dynamically inserted -->
  </div>
</main>

<script>
  const isLoggedIn = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;

  const services = [
    {
      title: 'Interview Experiences',
      description: 'Read interview experiences of others.',
      icon: 'fa-book-open',
      color: '#1E90FF',
      linkTo: 'experiences.php',
      requiresLogin: true
    },
    {
      title: 'Recent Job Listings',
      description: 'Browse through latest job openings and internships.',
      icon: 'fa-briefcase',
      color: '#8A2BE2',
      linkTo: 'job_listings.php',
      requiresLogin: true
    },
    {
      title: 'Share Your Experience',
      description: 'Contribute your personal interview stories and tips.',
      icon: 'fa-pen-fancy',
      color: '#FFA500',
      linkTo: 'share_experience.php',
      requiresLogin: true
    },
    {
      title: 'Interview Courses',
      description: 'Access curated courses to prepare for interviews.',
      icon: 'fa-graduation-cap',
      color: '#32CD32',
      linkTo: 'courses.php',
      requiresLogin: true
    },
    {
      title: 'Interview FAQs',
      description: 'Find answers to common interview questions and doubts.',
      icon: 'fa-question-circle',
      color: '#FF6347',
      linkTo: 'interview_faqs.php',
      requiresLogin: true
    },
    {
      title: 'Login / Register',
      description: 'Register or Login to explore and avail services.',
      icon: 'fa-user',
      color: '#ffc107',
      linkTo: 'login.php',
      requiresLogin: false
    }
  ];

  const grid = document.getElementById('servicesGrid');

  services.forEach(service => {
    const card = document.createElement('div');
    card.className = 'service-card';

    const icon = `<i class="fas ${service.icon} service-icon" style="color: ${service.color};"></i>`;
    const title = `<h3>${service.title}</h3>`;
    const desc = `<p>${service.description}</p>`;
    const content = icon + title + desc;

    const link = document.createElement('a');
    link.className = 'service-link';
    link.innerHTML = content;

    // Control access
    if (service.requiresLogin && !isLoggedIn) {
      link.href = "login.php";
    } else {
      link.href = service.linkTo;
    }

    card.appendChild(link);
    grid.appendChild(card);
  });
</script>

<?php include 'footer.php'; ?>
</body>
</html>
