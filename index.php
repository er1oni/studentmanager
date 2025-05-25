<?php
session_start();
include 'db.php';
include 'header.php';  // contains the <html>, <head>, navbar, and <body> opening

$username = $_SESSION['username'] ?? 'Guest';
$role = $_SESSION['role'] ?? 'user';
?>

<main class="container" style="max-width: 900px; margin: auto; padding: 20px;">
    <header style="margin-bottom: 20px;">
        You are logged in as <strong><?= htmlspecialchars($username) ?></strong> (<?= htmlspecialchars($role) ?>)
    </header>

    <h1>Welcome to Student Course Manager</h1>
    <p>Use the navigation above to manage students, courses, and enrollments.</p>

    <div class="dashboard" style="display: flex; gap: 2rem; flex-wrap: wrap; justify-content: center; margin-top: 30px;">
        <div class="card" style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 260px; text-align: center;">
            <h2 style="color: #2980b9;">📋 Students</h2>
            <p>View and manage all enrolled students.</p>
            <a href="list_students.php" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background-color: #2980b9; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s;">View Students</a>
        </div>

        <div class="card" style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 260px; text-align: center;">
            <h2 style="color: #2980b9;">📚 Courses</h2>
            <p>Browse all available courses.</p>
            <a href="list_courses.php" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background-color: #2980b9; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s;">View Courses</a>
        </div>

        <div class="card" style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 260px; text-align: center;">
            <h2 style="color: #2980b9;">➕ Enroll</h2>
            <p>Enroll students in courses.</p>
            <a href="enroll_student.php" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background-color: #2980b9; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s;">Enroll Student</a>
        </div>
    </div>
</main>

<?php
include 'footer.php';  // closes the </body> and </html>

