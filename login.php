<?php
session_start();
$errors = [];

// Check if the user is already logged in, if so, redirect to dashboard
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: dashboard.php");
    exit;
}

// Predefined email and password for multiple users
$accounts = [
    "parejustine@gmail.com" => "pass123",
    "Just@example.com" => "justpass",
    "kew@example.com" => "password",
    "sigma@example.com" => "boots",
    "wew@example.com" => "wewpass"
];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if email and password fields are filled
    if (empty($_POST["email"])) {
        $errors[] = "Email is required";
    }
    if (empty($_POST["password"])) {
        $errors[] = "Password is required";
    }

    // If no errors, check credentials
    if (empty($errors)) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Check if credentials match any of the predefined accounts
        if (array_key_exists($email, $accounts) && $accounts[$email] === $password) {
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            header("Location: dashboard.php");
            exit;
        } else {
            $errors[] = "Invalid email or password";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm p-4">
                <h2 class="card-title text-center mb-4">Login</h2>

                <!-- Display error messages if there are any -->
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
