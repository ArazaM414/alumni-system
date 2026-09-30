<?php
include('config/db.php');
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $batch = mysqli_real_escape_string($conn, $_POST['batch']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $organization = mysqli_real_escape_string($conn, $_POST['organization']);
    $password = $_POST['password'];

    // Password Hash
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Email duplication check
    $check_email = "SELECT * FROM users WHERE email='$email'";
    $res = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($res) > 0) {
      $message = "This email is already registered!";
    } else {
        $sql = "INSERT INTO users (full_name, email, batch, department, organization, password) 
                VALUES ('$full_name', '$email', '$batch', '$department', '$organization', '$hashed_password')";
        
        if (mysqli_query($conn, $sql)) {
            header("Location: login.php?msg=registered");
            exit();
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlumniConnect - Registration</title>
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
            max-width: 450px;
            background: white;
            margin: 40px auto;
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

        .form-group input, 
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 14px;
        }

        .form-group input:focus, 
        .form-group select:focus {
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

        .error-msg {
            color: #dc2626;
            background: #fef2f2;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 14px;
            border: 1px solid #fecaca;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">AlumniConnect</div>
        <nav>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php" class="active">Register</a></li>
            </ul>
        </nav>
    </header>

    <div class="form-container">
        <h2>Alumni Registration</h2>

        <?php if ($message != ""): ?>
            <div class="error-msg"><?php echo $message; ?></div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" id="fullname" name="full_name" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter email address" required>
            </div>

            <div class="form-group">
                <label for="batch">Batch</label>
                <input type="text" id="batch" name="batch" placeholder="e.g. 2022" required>
            </div>

            <div class="form-group">
                <label for="department">Department</label>
                <select id="department" name="department" required>
                    <option value="" disabled selected>Select Department</option>
                    <option value="Computer Science">Computer Science</option>
                    <option value="Software Engineering">Software Engineering</option>
                    <option value="Information Technology">Information Technology</option>
                </select>
            </div>

            <div class="form-group">
                <label for="organization">Current Organization</label>
                <input type="text" id="organization" name="organization" placeholder="Company or University">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password" required>
            </div>

            <button type="submit">Register</button>
        </form>

        <p class="footer-text">Already registered? <a href="login.php">Login here</a></p>
    </div>

</body>
</html>