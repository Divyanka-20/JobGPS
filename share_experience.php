<?php
session_start();

if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


include 'database_connection.php'; // Update with your DB connection file

$success = "";
$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $job_title = trim($_POST['job_title']);
    $company = trim($_POST['company']);
    $rounds = trim($_POST['rounds']);
    $questions = trim($_POST['interview_questions']);
    $preparation = trim($_POST['preparation_technique']);
    $tips = trim($_POST['tips']);

    
    if ($job_title && $company && $rounds && $questions && $preparation && $tips) {
        $user_id = $_SESSION['user_id'];
        $stmt = $conn->prepare("INSERT INTO experiences 
            (user_id, job_title, company, rounds, interview_questions, preparation_technique, tips) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssss", $user_id, $job_title, $company, $rounds, $questions, $preparation, $tips);

        if ($stmt->execute()) {
            $success = "Your experience has been shared successfully!";
        } else {
            $error = "Something went wrong. Please try again.";
        }
        $stmt->close();
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
  
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Share Interview Experience</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      font-family: Arial, sans-serif;
      background: url("https://www.elegantthemes.com/blog/wp-content/uploads/2013/09/bg-11-full.jpg");
      margin: 0;
      padding: 0;
      text-align: center;
    }

    .container {
      width: auto;
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
    }

    .success {
      background-color: #d4edda;
      color: #155724;
    }

    .error {
      background-color: #f8d7da;
      color: #721c24;
    }

    label {
      text-align: left;
      font-family: 'Times New Roman', Times, serif;
      margin-bottom : -10px;
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

      h1{
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

<?php include 'navbar.php';?>
  <div class="container">
    <h1>SHARE YOUR INTERVIEW EXPERIENCE</h1>

    <?php if ($success): ?>
      <div class="message success"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
      <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">

      <label for="job_title">Job Role:</label>
      <input type="text" id="job_title" name="job_title" placeholder="e.g., SDE Intern" required />

      <label for="company">Company Name:</label>
      <input type="text" id="company" name="company" placeholder="e.g., Infosys, Google" required />

      <label for="rounds">Interview Rounds:</label>
      <textarea id="rounds" name="rounds" placeholder="e.g., Aptitude, Technical, HR" rows="3" required></textarea>

      <label for="interview_questions">Interview Questions:</label>
      <textarea id="interview_questions" name="interview_questions" placeholder="List key questions asked during the interview" rows="4" required></textarea>

      <label for="preparation_technique">Preparation Techniques:</label>
      <textarea id="preparation_technique" name="preparation_technique" placeholder="e.g., Solved DSA, Web Development" rows="4" required></textarea>

      <label for="tips">Tips for Future Candidates:</label>
      <textarea id="tips" name="tips" placeholder="Tips for future candidates" rows="3" required></textarea>

      <button type="submit">Submit Experience</button>
    </form>

  </div>

  <?php include 'footer.php'; ?>
</body>
</html>
