<?php
include 'init.php';
?>

<nav style="background:#3498db; padding: 12px; color: white; display: flex; justify-content: space-between;">
    <div>
        <a href="index.php" style="color:white; text-decoration:none; font-weight:bold; margin-right:15px;">Home</a>
        <a href="list_students.php" style="color:white; text-decoration:none; margin-right:15px;">Students</a>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="admin_dashboard.php" style="color:white; text-decoration:none; margin-right:15px;">Admin Dashboard</a>
        <?php endif; ?>
    </div>
    <div>
        <?php if (isset($_SESSION['username'])): ?>
            Welcome, <?= htmlspecialchars($_SESSION['username']) ?> |
            <a href="logout.php" style="color:white; text-decoration:none;">Logout</a>
        <?php else: ?>
            <a href="login.php" style="color:white; text-decoration:none; margin-right:15px;">Login</a>
            <a href="register.php" style="color:white; text-decoration:none;">Register</a>
        <?php endif; ?>
    </div>
</nav>
