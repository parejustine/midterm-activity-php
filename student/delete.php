<?php
session_start();

// Ensure the student data exists in the session
if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [];
}

// Get student information from the URL parameters if they exist
$student_id = isset($_GET['id']) ? $_GET['id'] : '';

// Check if the student exists in the session
$student_index = null;
$student_to_delete = null;

foreach ($_SESSION['students'] as $index => $student) {
    if ($student['id'] == $student_id) {  // Match by unique student ID
        $student_index = $index;
        $student_to_delete = $student;
        break;
    }
}

// If the student is found, handle the deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    if ($student_index !== null) {
        // Remove the student from the session array
        unset($_SESSION['students'][$student_index]);
        
        // Re-index the session array to avoid gaps in the index
        $_SESSION['students'] = array_values($_SESSION['students']);
    }

    // Redirect back to the register page after deletion
    header("Location: register.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete a Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Delete a Student</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Register Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delete Student</li>
        </ol>
    </nav>
    
    <?php if ($student_to_delete): ?>
    <div class="card p-4">
        <ul>
            <li><strong>Student ID:</strong> <?= htmlspecialchars($student_to_delete['studentID']) ?></li>
            <li><strong>First Name:</strong> <?= htmlspecialchars($student_to_delete['firstName']) ?></li>
            <li><strong>Last Name:</strong> <?= htmlspecialchars($student_to_delete['lastName']) ?></li>
        </ul>
        
        <form method="POST">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='register.php'">Cancel</button>
            <button type="submit" name="confirm_delete" class="btn btn-danger">Delete Student Record</button>
        </form>
    </div>
    <?php else: ?>
        <p class="alert alert-warning">Student not found.</p>
    <?php endif; ?>

</div>

</body>
</html>
