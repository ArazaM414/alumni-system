<?php
session_start();

// Security Check: Agar user login nahi hai toh login page par redirect karein
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('config/db.php');

// Database se total alumni count fetch karna
$total_alumni = 0;
$query = "SELECT COUNT(*) as total FROM users";
$result = mysqli_query($conn, $query);

if ($result) {
    $data = mysqli_fetch_assoc($result);
    $total_alumni = $data['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlumniConnect - Dashboard</title>
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
            align-items: center;
        }

        nav a {
            color: #cbd5e1;
            text-decoration: none;
            font-weight: 600;
        }

        nav a:hover, nav a.active {
            color: #ffffff;
        }

        .btn-logout {
            background-color: #ef4444;
            color: white !important;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.2s;
        }

        .btn-logout:hover {
            background-color: #dc2626;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .welcome-card {
            background: #dbeafe;
            border-left: 5px solid #2563eb;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 30px;
            color: #1e40af;
        }

        .welcome-card h2 {
            font-size: 20px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            text-align: center;
            border: 1px solid #e2e8f0;
        }

        .stat-card h3 {
            color: #64748b;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .stat-card .number {
            font-size: 36px;
            font-weight: bold;
            color: #1e3a8a;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">AlumniConnect</div>
        <nav>
            <ul>
                <li><a href="index.php" class="active">Dashboard</a></li>
                <li><a href="alumni.php">Alumni Directory</a></li>
                <li><a href="profile.php">My Profile</a></li>
                <li><a href="logout.php" class="btn-logout">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        
        <div class="welcome-card">
            <h2>Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
        </div>

        <h1 style="color: #1e3a8a; margin-bottom: 20px;">Dashboard Statistics</h1>

        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Registered Alumni</h3>
                <div class="number"><?php echo $total_alumni; ?></div>
            </div>

            <div class="stat-card">
                <h3>Events</h3>
                <div class="number">25</div>
            </div>

            <div class="stat-card">
                <h3>Jobs Posted</h3>
                <div class="number">87</div>
            </div>
        </div>

    </div>

</body>
</html>