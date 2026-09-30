<?php
session_start();
include('config/db.php');
$message = "";

if (isset($_GET['msg']) && $_GET['msg'] == 'registered') {
    $message = "Account created sucessfully.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['full_name'];
            header("Location: index.php");
            exit();
        } else {
            $message = "Incorrect Password!";
        }
    } else {
        $message = "this email id is not registeerd!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlumniConnect - Login</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f4f7f6;
            color: #333;
        }

        header {
            background-color: #1e3a8a;
            color: white;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        nav a {
            color: #cbd5e1;
            text-decoration: none;
            font-weight: 600;
        }

        nav a:hover, nav a.active {
            color: #ffffff;
        }

        .form-container {
            max-width: 400px;
            background: white;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border: 1px solid #e2e8f0;
        }

        .form-container h2 {
            color: #1e3a8a;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #475569;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 14px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #1d4ed8;
        }

        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .footer-text a {
            color: #2563eb;
            text-decoration: none;
            font-weight: bold;
        }

        .alert-box {
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 14px;
        }

        .alert-error {
            color: #dc2626;
            background: #fef2f2;
            border: 1px solid #fecaca;
        }

        .alert-success {
            color: #166534;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">AlumniConnect</div>
        <nav>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="login.php" class="active">Login</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </nav>
    </header>

    <div class="form-container">
        <h2>Alumni Login</h2>

        <?php if ($message != ""): ?>
            <div class="alert-box <?php echo (isset($_GET['msg']) && $_GET['msg'] == 'registered') ? 'alert-success' : 'alert-error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="Enter email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password" required>
            </div>

            <button type="submit">Login</button>
        </form>

        <p class="footer-text">New user? <a href="register.php">Register here</a></p>
    </div>

</body>
</html>