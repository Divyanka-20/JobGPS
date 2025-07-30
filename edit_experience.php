<?php
session_start();

if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'database_connection.php'; // Your DB connection file

$success = "";
$error = "";

$user_id = $_SESSION['user_id'];

// Validate and get ref_id from GET
if (!isset($_GET['ref_id']) || !is_numeric($_GET['ref_id'])) {
    die("Invalid experience ID.");
}
$ref_id = (int)$_GET['ref_id'];

// Fetch existing experience data for this user and ref_id
$stmt = $conn->prepare("SELECT job_title, company, rounds, interview_questions, preparation_technique, tips FROM experiences WHERE ref_id = ? AND user_id = ?");
$stmt->bind_param("ii", $ref_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Experience not found or you don't have permission to edit it.");
}

$experience = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $job_title = trim($_POST['job_title']);
    $company = trim($_POST['company']);
    $rounds = trim($_POST['rounds']);
    $questions = trim($_POST['interview_questions']);
    $preparation = trim($_POST['preparation_technique']);
    $tips = trim($_POST['tips']);

    if ($job_title && $company && $rounds && $questions && $preparation && $tips) {
        $update_stmt = $conn->prepare("UPDATE experiences SET job_title=?, company=?, rounds=?, interview_questions=?, preparation_technique=?, tips=?, updated_at=NOW() WHERE ref_id=? AND user_id=?");
        $update_stmt->bind_param("ssssssii", $job_title, $company, $rounds, $questions, $preparation, $tips, $ref_id, $user_id);

        if ($update_stmt->execute()) {
            $success = "Your experience has been updated successfully!";
            // Refresh $experience to updated values
            $experience = [
                'job_title' => $job_title,
                'company' => $company,
                'rounds' => $rounds,
                'interview_questions' => $questions,
                'preparation_technique' => $preparation,
                'tips' => $tips
            ];
        } else {
            $error = "Something went wrong. Please try again.";
        }
        $update_stmt->close();
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Interview Experience</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <style>
    body {
      font-family: Arial, sans-serif;
      background: url("https://www.elegantthemes.com/blog/wp-content/uploads/2013/09/bg-11-full.jpg");
      margin: 0;
      padding: 0;
      text-align: center;
    }

    .container {
      max-width: 700px;
      margin: 100px auto 30px;
      padding: 30px;
      background-color: transparent;
    }

    h1 {
      text-align: center;
      color: crimson;
      font-family: 'Times New Roman', Times, serif;
      font-weight: bold;
      font-size: 35px;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    input, textarea {
      padding: 12px;
      font-size: 16px;
      border: 1px solid #ccc;
      font-family: 'Times New Roman', Times, serif;
      border-radius: 6px;
      resize: vertical;
    }

    button {
      background-color: #007bff;
      color: white;
      font-size: 16px;
      padding: 10px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.2s;
    }

    button:hover {
      background-color: #0056b3;
    }

    .message {
      padding: 10px;
      border-radius: 6px;
      font-weight: bold;
      text-align: center;
      max-width: 700px;
      margin: 10px auto;
    }

    .success {
      background-color: #d4edda;
      color: #155724;
    }

    .error {
      background-color: #f8d7da;
      color: #721c24;
    }

    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
    }
    footer {
      flex-shrink: 0;
      background-color: #333;
      color: white;
      padding: 15px 20px;
      text-align: center;
    }
    body > .container {
      flex: 1 0 auto;
    }
    @media screen and (max-width: 786px) {
      .container {
        width: 90%;
        margin-right: 0px;
        margin-top: 100px;
      }
      h1 {
        font-size: 35px;
      }
      input, textarea {
        padding: 12px;
        font-size: 14px;
        border: 1px solid #ccc;
        font-family: 'Times New Roman', Times, serif;
        border-radius: 6px;
        resize: vertical;
      }
    }
  </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
  <h1>EDIT YOUR INTERVIEW EXPERIENCE</h1>

  <?php if ($success): ?>
    <div class="message success"><?= htmlspecialchars($success) ?></div>
  <?php elseif ($error): ?>
    <div class="message error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <input type="text" name="job_title" placeholder="Job Title (e.g., SDE Intern)" required
      value="<?= htmlspecialchars($experience['job_title']) ?>" />
    <input type="text" name="company" placeholder="Company (e.g., Infosys, Google)" required
      value="<?= htmlspecialchars($experience['company']) ?>" />

    <textarea name="rounds" placeholder="Mention the rounds (e.g., Aptitude, Technical, HR)" rows="3" required><?= htmlspecialchars($experience['rounds']) ?></textarea>
    <textarea name="interview_questions" placeholder="List key questions asked during the interview" rows="4" required><?= htmlspecialchars($experience['interview_questions']) ?></textarea>
    <textarea name="preparation_technique" placeholder="How did you prepare for the interview?" rows="4" required><?= htmlspecialchars($experience['preparation_technique']) ?></textarea>
    <textarea name="tips" placeholder="Tips for future candidates" rows="3" required><?= htmlspecialchars($experience['tips']) ?></textarea>

    <button type="submit">Update Experience</button>
  </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
