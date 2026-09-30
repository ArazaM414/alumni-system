<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('config/db.php');

$user_id = $_SESSION['user_id'];
$message = "";

// Profile update handle karna
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $organization = mysqli_real_escape_string($conn, $_POST['organization']);
    
    $update_query = "UPDATE users SET organization='$organization' WHERE id='$user_id'";
    if (mysqli_query($conn, $update_query)) {
        $message = "Profile updated successfully!";
    } else {
        $message = "Error updating profile.";
    }
}

// User details fetch karna
$query = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlumniConnect - My Profile</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f7f6; color: #333; }
        header { background-color: #1e3a8a; color: white; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 22px; font-weight: bold; }
        nav ul { list-style: none; display: flex; gap: 20px; align-items: center; }
        nav a { color: #cbd5e1; text-decoration: none; font-weight: 600; }
        nav a:hover { color: white; }
        .btn-logout { background-color: #ef4444; padding: 6px 15px; border-radius: 5px; color: white !important; }
        
        .profile-card { max-width: 500px; background: white; margin: 40px auto; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
        .profile-card h2 { color: #1e3a8a; margin-bottom: 20px; text-align: center; }
        .info-group { margin-bottom: 12px; font-size: 15px; }
        .info-group label { font-weight: bold; color: #475569; }
        
        .form-group { margin-top: 20px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; }
        
        button { width: 100%; padding: 10px; background-color: #2563eb; color: white; border: none; border-radius: 6px; font-weight: bold; margin-top: 15px; cursor: pointer; }
        button:hover { background-color: #1d4ed8; }
        .msg { background: #f0fdf4; color: #166534; padding: 10px; border-radius: 6px; margin-bottom: 15px; text-align: center; border: 1px solid #bbf7d0; }
    </style>
</head>
<body>

    <?php include('header.php'); ?>

    <div class="profile-card">
        <h2>My Profile</h2>

        <?php if ($message != ""): ?>
            <div class="msg"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="info-group">
            <label>Full Name:</label> <?php echo htmlspecialchars($user['full_name']); ?>
        </div>
        <div class="info-group">
            <label>Email:</label> <?php echo htmlspecialchars($user['email']); ?>
        </div>
        <div class="info-group">
            <label>Department:</label> <?php echo htmlspecialchars($user['department']); ?>
        </div>
        <div class="info-group">
            <label>Batch:</label> <?php echo htmlspecialchars($user['batch']); ?>
        </div>

        <form action="profile.php" method="POST">
            <div class="form-group">
                <label for="organization">Update Current Organization:</label>
                <input type="text" id="organization" name="organization" value="<?php echo htmlspecialchars($user['organization']); ?>" required>
            </div>
            <button type="submit">Update Profile</button>
        </form>
    </div>

</body>
</html>