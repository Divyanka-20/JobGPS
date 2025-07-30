<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['user_email'];  // Use email for DB queries

include 'database_connection.php';

// ✅ Show message only if set in session
$message = $_SESSION['profile_update_message'] ?? "";
unset($_SESSION['profile_update_message']); // ✅ Clear after showing once

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $phno = $conn->real_escape_string($_POST['phno']);

    $update_sql = "UPDATE users SET name='$name', phno='$phno' WHERE email='$email'";
    if ($conn->query($update_sql) === TRUE) {
        $_SESSION['user_name'] = $name; // Update session
        $_SESSION['profile_update_message'] = "Profile updated successfully."; // ✅ Store in session
        header("Location: profile.php"); // ✅ Redirect to prevent form resubmission
        exit();
    } else {
        $message = "Error updating profile: " . $conn->error;
    }
}

$sql = "SELECT name, phno, email FROM users WHERE email='$email' LIMIT 1";
$result = $conn->query($sql);

if (!$result || $result->num_rows !== 1) {
    echo "User not found.";
    exit();
}

$user = $result->fetch_assoc();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <!-- your head content & styles -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GarmentGrid - Your Profile</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      background-image: url('https://www.elegantthemes.com/blog/wp-content/uploads/2013/09/bg-11-full.jpg');
      background-size: cover;
      margin: 0;
      font-family: Arial, sans-serif;
    }
    
    .container {
      width: 400px;
      margin: 40px auto;
      background: transparent;
      padding: 30px;
      text-decoration: none;
      font-family: 'Times New Roman', Times, serif;
    }

    h1 {
      text-align: center;
      margin: 40px 0 20px;
      margin-top: 143px;
      font-family: 'Times New Roman', Times, serif; 
      font-size: 32px; 
      color: black; /* Make it visible on dark background */
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    form label {
      display: block;
      margin-top: 10px;
      margin-bottom: 6px;
      font-weight: bold;
    }

    input, textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      font-family: 'Times New Roman', Times, serif;
      border-radius: 6px;
      font-size: 16px;
    }

    textarea {
      resize: vertical;
    }

    .container button {
      padding: 10px;
      background-color: rgba(22, 143, 78, 0.79);
      border: none;
      border-radius: 8px;
      color: white;
      font-size: 16px;
      font-weight: bold;
      width: 106%;
      font-family: 'Times New Roman', Times, serif;
      cursor: pointer;
      display: block;
      margin: 20px auto 0;
      justify-content: center;
      text-align: center;
      text-decoration: none;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .message {
      text-align: center;
      margin-top: 15px;
      font-weight: bold;
      color: green;
    }

    .back-link {
      text-align: center; /* Center content inside the container */
      margin-top: 20px;   /* Add top margin to the container */
    }

    .back-link a {
      color: rgb(13, 50, 131);
      text-decoration: none;
      font-weight: bold;
      font-family: 'Times New Roman', Times, serif;
      display: inline-block; /* Allow margin to apply */
    }

    .back-link a:hover {
      text-decoration: underline;
    }

    @media screen and (max-width: 600px){
            .container{
                width: 80%;
                justify-content: center;
                margin-left: -3px;
            }
            .container h1{
                font-size: 25px;
            }
            p{
                font-size: 15px;
            }
            .container label{
                font-size: 14px;
            }
            .links a{
                font-size: 13px;
            }
         }
</style>
</head>
<body>

<?php include 'navbar.php'; ?>
  <h1>My Profile
  <i class="fas fa-user" style="color: #dc3545;"></i>
  </h1>
<div class="container">

  <?php if ($message): ?>
    <p class="message"><?php echo htmlspecialchars($message); ?></p>
  <?php endif; ?>

  <form method="POST" action="profile.php">
    <label>Email (cannot change)</label>
    <input type="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly />

    <label>Name</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required />

    <label>Contact Number</label>
    <input type="text" name="phno" value="<?php echo htmlspecialchars($user['phno']); ?>" required />

    <button type="submit">Update Profile</button>
  </form>

  <div class="back-link">
    <a href="index.php">&larr; Back to Dashboard</a>
  </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
