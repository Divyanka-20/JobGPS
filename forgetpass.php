<?php
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'database_connection.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $new_password = $_POST['npassword'];

    // Check if email exists
    $check = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        // Email found — update the password
        $update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $update->bind_param("ss", $new_password, $email);

        if ($update->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $msg = "Failed to update password.";
        }
    } else {
        $msg = "Email not found in records.";
    }

    $check->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Career Cracker - Forgot Password</title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            background-image: url('https://www.elegantthemes.com/blog/wp-content/uploads/2013/09/bg-11-full.jpg');
            background-size: cover;
            background-position: center;
            margin: 0;
            font-family: Arial, sans-serif;
            min-height: 100vh; /* allow auto height based on content */
            display: flex;
            flex-direction: column;
        }

        .forgot-password-container {
        width: 400px;
        margin: 100px auto;
        margin-top: 100px;
        padding: 20px;
        background-color: rgba(0, 0, 0, 0);
        color: black;
        border-radius: 8px;
        /*box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);*/
        }

        .forgot-password-container h2 {
        text-align: center;
        margin-bottom: 20px;
        font-family: 'Times New Roman', Times, serif; font-size: 32px; color: black;
        }

        .forgot-password-container p {
        text-align: center;
        margin-bottom: 30px;
        color: #ccc;
        }

        .forgot-password-container form {
        display: flex;
        flex-direction: column;
        }

        .forgot-password-container label {
        margin-bottom: 5px;
        font-family: 'Times New Roman', Times, serif;
        color: black;
        }

        .forgot-password-container input[type="email"],
        .forgot-password-container input[type="password"] {
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #555;
        border-radius: 4px;
        font-family: 'Times New Roman', Times, serif;
        font-size: 16px;
        background-color: rgba(255, 255, 255, 0.8);
        }

        .forgot-password-container button {
        padding: 10px;
        background-color: rgba(22, 143, 78, 0.79);
        border: none;
        border-radius: 4px;
        color: white;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        }

        .links {
        text-align: center;
        margin-top: 20px;
        }

        .links a {
        color:rgb(13, 50, 131);
        text-decoration: none;
        font-weight: bold;
        font-family: 'Times New Roman', Times, serif;
        font-size: 17px;
        }

        .links a:hover {
        text-decoration: underline;
        }
        @media screen and (max-width: 600px){
            .forgot-password-container{
                width: 80%;
            }
            .forgot-password-container h2{
                font-size: 25px;
            }
            .forgot-password-container label{
                font-size: 14px;
            }
            .forgot-password-container input[type="email"],
            .forgot-password-container input[type="password"]{
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


    <div class="forgot-password-container">
        <h2>
            <i class="fas fa-key" style="color:rgb(220, 99, 55);"></i> <strong>Forgot Password</strong>
            </h2>
        <p align="center" style= " font-family: 'Times New Roman', Times, serif; color:black;">Update your password</p>
        <?php if (!empty($msg)) echo "<p style='color:red;text-align:center;'>$msg</p>"; ?>

        <form method="post">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" required placeholder="Email id" />

        <label for="npassword">Change your password</label>
        <input type="password" id="npassword" name="npassword" required placeholder="New Password" />

        <button type="submit" style="font-weight: bold; font-family:Georgia, 'Times New Roman', Times, serif;">Update Password</button>
        </form>
        <div class="links">
        <a href="login.php">Back to Login</a> <strong>|</strong> 
        <a href="signup.php">New User? Register</a>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    </body>
</html>
