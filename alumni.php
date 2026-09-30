<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include('config/db.php');

// Alumni list fetch karna
$query = "SELECT full_name, email, batch, department, organization FROM users ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlumniConnect - Directory</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #f4f7f6; color: #333; }
        header { background-color: #1e3a8a; color: white; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 22px; font-weight: bold; }
        nav ul { list-style: none; display: flex; gap: 20px; align-items: center; }
        nav a { color: #cbd5e1; text-decoration: none; font-weight: 600; }
        nav a:hover { color: white; }
        .btn-logout { background-color: #ef4444; padding: 6px 15px; border-radius: 5px; color: white !important; }
        
        .container { max-width: 1000px; margin: 40px auto; padding: 0 20px; }
        h1 { color: #1e3a8a; margin-bottom: 20px; }
        
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        th { background-color: #1e3a8a; color: white; }
        tr:hover { background-color: #f8fafc; }
    </style>
</head>
<body>

    <?php include('header.php'); ?>

    <div class="container">
        <h1>Alumni Directory</h1>
        
        <table>
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Batch</th>
                    <th>Organization</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['department']); ?></td>
                            <td><?php echo htmlspecialchars($row['batch']); ?></td>
                            <td><?php echo htmlspecialchars($row['organization'] ? $row['organization'] : 'N/A'); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">No alumni registered yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>