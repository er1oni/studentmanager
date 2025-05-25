<?php
session_start();
include 'db.php';
include 'header.php';

// Only allow logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] == 1;

// Fetch all courses
$result = $conn->query("SELECT id, course_name, description FROM courses");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Courses</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
            vertical-align: top;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .actions button {
            margin-right: 5px;
            background-color: #3498db;
            border: none;
            padding: 6px 12px;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        .actions button.delete {
            background-color: #e74c3c;
        }
        form.add-course {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }
        form.add-course input, form.add-course textarea {
            padding: 6px;
            font-size: 14px;
        }
        form.add-course input[type="text"] {
            flex: 1 1 200px;
        }
        form.add-course textarea {
            flex: 2 1 300px;
            height: 60px;
            resize: vertical;
        }
        form.add-course button {
            padding: 8px 16px;
            background-color: #2ecc71;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📚 Courses</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Course Name</th>
                    <th>Description</th>
                    <?php if ($isAdmin): ?>
                        <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php while ($course = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $course['id'] ?></td>
                        <td><?= htmlspecialchars($course['course_name']) ?></td>
                        <td><?= nl2br(htmlspecialchars($course['description'])) ?></td>
                        <?php if ($isAdmin): ?>
                            <td class="actions">
                                <form method="POST" action="manage_courses.php" style="display:inline-block;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $course['id'] ?>">
                                    <button class="delete" onclick="return confirm('Delete this course?');">Delete</button>
                                </form>
                                <button onclick="showEditForm(<?= $course['id'] ?>)">Edit</button>
                            </td>
                        <?php endif; ?>
                    </tr>

                    <?php if ($isAdmin): ?>
                        <tr id="edit-row-<?= $course['id'] ?>" style="display:none;">
                            <td colspan="4">
                                <form method="POST" action="manage_courses.php" style="display:flex; gap:10px; align-items:center; flex-wrap: wrap;">
                                    <input type="hidden" name="action" value="edit">
                                    <input type="hidden" name="id" value="<?= $course['id'] ?>">
                                    <input type="text" name="course_name" value="<?= htmlspecialchars($course['course_name']) ?>" required placeholder="Course Name" style="flex:1 1 200px;">
                                    <textarea name="description" required placeholder="Description" style="flex:2 1 300px;"><?= htmlspecialchars($course['description']) ?></textarea>
                                    <button type="submit">Save</button>
                                    <button type="button" onclick="hideEditForm(<?= $course['id'] ?>)">Cancel</button>
                                </form>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No courses found.</p>
    <?php endif; ?>

    <?php if ($isAdmin): ?>
        <form method="POST" action="manage_courses.php" class="add-course">
            <input type="hidden" name="action" value="add">
            <input type="text" name="course_name" placeholder="New course name" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <button type="submit">Add Course</button>
        </form>
    <?php endif; ?>
</div>

<script>
function showEditForm(id) {
    document.getElementById('edit-row-' + id).style.display = 'table-row';
}
function hideEditForm(id) {
    document.getElementById('edit-row-' + id).style.display = 'none';
}
</script>

</body>
</html>
