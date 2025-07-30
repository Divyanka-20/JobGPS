<?php 
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

// DB connection
include 'database_connection.php'; // Connect to MySQL

// Fetch experiences
$sql = "SELECT e.*, u.name 
        FROM experiences e
        JOIN users u ON e.user_id = u.id
        ORDER BY RAND()";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Interview Experiences - Career Cracker</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
    }

    body {
      font-family: Arial, sans-serif;
      background: url("https://www.elegantthemes.com/blog/wp-content/uploads/2013/09/bg-11-full.jpg");
      margin: 0;
      padding: 0;
      text-align: center;
    }

    .container {
      max-width: 900px;
      margin: 100px auto 30px;
      padding: 20px;
      flex: 1;
    }

    h1 {
      text-align: center;
      color: crimson;
      font-family: 'Times New Roman', Times, serif;
      font-weight: bold;
      font-size: 35px;
    }

    .experience-card {
      border-left: 5px solid #007bff;
      width: 100%;
      padding: 15px 20px;
      margin-bottom: 25px;
      background-color: #f9f9f9;
      border-radius: 6px;
    }

    .experience-card h3 {
      margin: 5px 0;
      font-size: 20px;
      color: #0056b3;
    }

    .experience-card .meta {
      font-size: 14px;
      color: #666;
      margin-bottom: 10px;
    }

    .experience-card p {
      font-size: 14px;
      line-height: 1.5;
      color: #444;
    }

    .experience-card strong.section-title {
      display: block;
      margin-top: 12px;
      color: #666;
    }

    @media screen and (max-width: 600px){
      .container{
          width: 90%;
      }
      h1{
          font-size: 35px;
      }
    }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>

  <div class="container">
    <h1>INTERVIEW EXPERIENCES</h1>

    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while($row = mysqli_fetch_assoc($result)): ?>
        <div class="experience-card">
          <h3><?= htmlspecialchars($row['job_title']) ?> at <?= htmlspecialchars($row['company']) ?></h3>
          <div class="meta">
            <b>Ref ID:</b> <?= 'EXP' . str_pad($row['ref_id'], 3, '0', STR_PAD_LEFT) ?> <b>|</b>
            <?= date('d M Y', strtotime($row['updated_at'])) ?>
          </div>

          <p align="left"><strong class="section-title">Rounds:</strong>
          <?= nl2br(htmlspecialchars($row['rounds'])) ?></p>

          <p align="left"><strong class="section-title">Interview Questions:</strong>
          <?= nl2br(htmlspecialchars($row['interview_questions'])) ?></p>

          <p align="left"><strong class="section-title">Preparation Techniques:</strong>
          <?= nl2br(htmlspecialchars($row['preparation_technique'])) ?></p>

          <p align="left"><strong class="section-title">Tips:</strong>
          <?= nl2br(htmlspecialchars($row['tips'])) ?></p>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p style="text-align:center;">No experiences shared yet.</p>
    <?php endif; ?>
  </div>

  <?php include 'footer.php'; ?>
</body>
</html>
