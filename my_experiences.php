<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'database_connection.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT e.*, u.name 
        FROM experiences e
        JOIN users u ON e.user_id = u.id
        WHERE e.user_id = ?
        ORDER BY e.updated_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Interview Experiences - Career Cracker</title>
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
      background: url("https://www.elegantthemes.com/blog/wp-content/uploads/2013/09/bg-11-full.jpg") no-repeat center center fixed;
      background-size: cover;
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
      align-items: center;
      background-color: #f9f9f9;
      border-radius: 6px;
      text-align: left;
    }

    .experience-card h3 {
      margin: 5px 0;
      font-size: 20px;
      color:  #0056b3;
      text-align: center;
    }

    .experience-card .meta {
      font-size: 14px;
      color: #666;
      margin-bottom: 10px;
      text-align: center;
    }

    .experience-card p {
      font-size: 14px;
      line-height: 1.5;
      color: #444;
    }

    .experience-card strong.section-title {
      display: block;
      margin-top: 12px;
      color: #333;
    }

    .edit-button {
      text-align: right;
      margin-bottom: 10px;
    }

    .edit-button a {
      text-decoration: none;
      padding: 5px 20px;
      font-size: 15px;
      border: 1px solid #007bff;
      color: #007bff;
      border-radius: 4px;
      transition: 0.2s;
    }

    .edit-button a:hover {
      background-color: #007bff;
      color: white;
    }

    @media screen and (max-width: 600px){
      .container{
          width: 90%;
          margin-top: 60px;
      }
      h1{
          font-size: 28px;
      }
    }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>

  <div class="container">
    <h1>MY INTERVIEW EXPERIENCES</h1>

    <?php if ($result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <div class="experience-card">
          <div class="edit-button">
            <a href="edit_experience.php?ref_id=<?= $row['ref_id'] ?>"><i class="fas fa-edit"></i> Edit</a>
          </div>

          <h3><?= htmlspecialchars($row['job_title']) ?> at <?= htmlspecialchars($row['company']) ?></h3>
          <div class="meta">
            <b>Ref ID:</b> <?= 'EXP' . str_pad($row['ref_id'], 3, '0', STR_PAD_LEFT) ?> <b>|</b>
            <?= date('d M Y', strtotime($row['updated_at'])) ?>
          </div>

          <?php if (!empty($row['rounds'])): ?>
            <p><strong class="section-title">Rounds:</strong>
            <?= nl2br(htmlspecialchars($row['rounds'])) ?></p>
          <?php endif; ?>

          <?php if (!empty($row['interview_questions'])): ?>
            <p><strong class="section-title">Interview Questions:</strong>
            <?= nl2br(htmlspecialchars($row['interview_questions'])) ?></p>
          <?php endif; ?>

          <?php if (!empty($row['preparation_technique'])): ?>
            <p><strong class="section-title">Preparation Techniques:</strong>
            <?= nl2br(htmlspecialchars($row['preparation_technique'])) ?></p>
          <?php endif; ?>

          <?php if (!empty($row['tips'])): ?>
            <p><strong class="section-title">Tips:</strong>
            <?= nl2br(htmlspecialchars($row['tips'])) ?></p>
          <?php endif; ?>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p style="text-align:center; font-weight:bold;">You haven't shared any experiences yet.</p>
    <?php endif; ?>
  </div>

  <?php include 'footer.php'; ?>
</body>
</html>
