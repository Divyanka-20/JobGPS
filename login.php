<?php
session_start();

$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'database_connection.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $name, $db_password);
        $stmt->fetch();

        // Plain text password comparison - use hashing in production!
        if ($password === $db_password) {
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_id'] = $id;  // Now correctly set!
            header("Location: index.php");
            exit();
        } else {
            $msg = "Invalid password!";
        }
    } else {
        $msg = "Email id not found!";
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Career Cracker - Login</title>
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

    .main-content {
        flex: 1; /* grow to push footer down */
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px; /* Add padding for smaller screens */
        flex-direction: column;
    }

    .login-container {
         width: 400px;
        margin: 100px auto;
        margin-top: 100px;
        padding: 20px;
        background-color: rgba(0, 0, 0, 0);
        color: black;
        border-radius: 8px;
    }

    .login-container h2 {
        text-align: center;
        margin-bottom: 20px;
        font-family: 'Times New Roman', Times, serif; 
        font-size: 32px;
        color: black;
    }

    .login-container form {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .login-container label {
        margin-bottom: 5px;
        font-family: 'Times New Roman', Times, serif;
        color: black;
    }

    .login-container input[type="email"],
    .login-container input[type="password"] {
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #555;
        border-radius: 4px;
        font-size: 16px;
        font-family: 'Times New Roman', Times, serif;
        background-color: rgba(255, 255, 255, 0.8);
        color: black;
    }

    .login-container button {
        padding: 10px;
        background-color:rgba(22, 143, 78, 0.79);
        border: none;
        border-radius: 4px;
        color: white;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
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

    p{
        font-family: 'Times New Roman', Times, serif;
        color: black;
    }
    @media screen and (max-width: 600px){
            .login-container{
                width: 80%;
            }
            .login-container h2{
                font-size: 25px;
            }
            p{
                font-size: 15px;
            }
            .login-container label{
                font-size: 14px;
            }
            .login-container input[type="name"],
            .login-container input[type="phno"],
            .login-container input[type="cpassword"],
            .login-container input[type="email"],
            .login-container input[type="password"]{
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

<div class="main-content">
  <div class="login-container">
    <h2>
    <i class="fas fa-sign-in-alt" style="color: rgb(220, 99, 55);"></i> <strong>Welcome Back</strong>
    </h2>
    <p align="center">Login to your existing account</strong></p>
    <?php if (!empty($msg)) echo "<p style='color:red;text-align:center;'>$msg</p>"; ?>
    <form method="post" action="">
      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" placeholder="Email id" required>

      <label for="password">Valid Password</label>
      <input type="password" id="password" name="password" placeholder="Existing Password" required>

      <button type="submit" style="font-weight: bold; font-family:Georgia, 'Times New Roman', Times, serif;">Login</button>
    </form>
    <div class="links">
      <a href="signup.php">New User? Register</a> <strong>|</strong> 
      <a href="forgetpass.php">Forgot Password?</a>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
