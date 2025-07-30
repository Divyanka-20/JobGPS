<?php
$msg = ""; // Initialize message to avoid undefined error

if (isset($_POST['s'])) {
    include 'database_connection.php';
    
    $name = $_POST['name'];
    $phno = $_POST['phno'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    // Check if email already exists
    $check = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $msg = "Email already exists. Please use a different one.";
    } else {
        $sql = "INSERT INTO users(name, phno, email, password) VALUES (?, ?, ?, ?)";
        $st = $conn->prepare($sql);
        $st->bind_param("sssss", $name, $phno, $email, $password);

        if ($st->execute()) {
            header("Location: login.php");
            exit();
        } else {
            $msg = "Registration failed. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Cracker - Signup</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            background-image: url('https://www.elegantthemes.com/blog/wp-content/uploads/2013/09/bg-11-full.jpg');
            background-size: cover;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            margin-top: 100px;
            padding: 20px;
            background-color:rgba(0, 0, 0, 0); /* Transparent black background */
            color: black; /* Ensures text is readable on dark background */
            border-radius: 8px;
            /*box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);*/
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-family: 'Times New Roman', Times, serif; font-size: 32px; color: black
        }

        p{
            font-family: 'Times New Roman', Times, serif; color:black
        }

        .login-container form {
            display: flex;
            flex-direction: column;
        }

        .login-container label {
            margin-bottom: 5px;
            font-family: 'Times New Roman', Times, serif;
            font-size: 16px;
            color: black;
        }

        .login-container input[type="name"],
            .login-container input[type="phno"],
            .login-container input[type="cpassword"],
            .login-container input[type="email"],
            .login-container input[type="password"] {
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #555; /* Darker border for better contrast */
                border-radius: 4px;
                font-size: 16px;
                font-family: 'Times New Roman', Times, serif;
                background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent white background for inputs */
            }


        .login-container button {
            padding: 10px;
            background-color:rgba(22, 143, 78, 0.79);
            border: 2px;
            border-radius: 4px;
            color: white;
            font-size: 16px;
            cursor: pointer;
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

        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
            text-align: center;
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
        <div class="login-container">
            <h2>
            <i class="fas fa-user-plus" style="color:rgb(220, 99, 55);"></i> <strong>Register Yourself</strong>
            </h2>
            <p align="center">Create an account to explore services</p>
            <div class="error-message" id="error"></div><br>
            <form method="post" onsubmit="return validatePasswords()">
                <label for="name">Full Name</label>
                <input type="name" id="name" name="name" placeholder="Name" required>

                <label for="phno">Contact Number</label>
                <input type="phno" id="phno" name="phno" placeholder="Contact Number" required>

                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Email Id" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" required>

                <label for="cpassword">Confirm Password</label>
                <input type="password" id="cpassword" name="cpassword" placeholder="Confirm Password" required>
                
                <button type="submit" name="s" style="font-weight: bold; font-family:Georgia, 'Times New Roman', Times, serif;">Register</button>

            </form>
            <div class="links">
                <a href="login.php">Already a User? Sign In</a>
            </div>
        </div>
<?php include 'footer.php'; ?>

          <script>
            function togglePassword(id) {
                const input = document.getElementById(id);
                if (input.type === "password") {
                    input.type = "text";
                } else {
                    input.type = "password";
                }
            }

            function validatePasswords() {
                const password = document.getElementById("password").value;
                const cpassword = document.getElementById("cpassword").value;
                const errorDiv = document.getElementById("error");

                if (password !== cpassword) {
                    errorDiv.textContent = "Passwords do not match!";
                    return false;
                }

                errorDiv.textContent = "";
                return true;
            }
        </script>
</body>
</html>