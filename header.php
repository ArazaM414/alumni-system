<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <header>
    <div class="logo">AlumniConnect</div>
    <nav>
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="alumni.php">Alumni Directory</a></li>
            <li><a href="profile.php">My Profile</a></li>
            <li><a href="logout.php" class="btn-logout">Logout</a></li>
        </ul>
    </nav>
</header>
</header>