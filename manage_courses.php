<?php
session_start();
include 'db.php';

// Only allow logged-in admins
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $course_name = trim($_POST['course_name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($course_name !== '' && $description !== '') {
            $stmt = $conn->prepare("INSERT INTO courses (course_name, description) VALUES (?, ?)");
            $stmt->bind_param("ss", $course_name, $description);
            $stmt->execute();
            $stmt->close();
        }
    } elseif ($action === 'edit') {
        $id = intval($_POST['id'] ?? 0);
        $course_name = trim($_POST['course_name'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($id > 0 && $course_name !== '' && $description !== '') {
            $stmt = $conn->prepare("UPDATE courses SET course_name = ?, description = ? WHERE id = ?");
            $stmt->bind_param("ssi", $course_name, $description, $id);
            $stmt->execute();
            $stmt->close();
        }
    } elseif ($action === 'delete') {
        $id = intval($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $conn->prepare("DELETE FROM courses WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// After handling the action, redirect back to the courses page
header("Location: courses.php");
exit;
