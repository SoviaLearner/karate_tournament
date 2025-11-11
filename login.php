<?php
require_once 'config.php';
// Jika sudah login, redirect ke index.php
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit;
}

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Contoh autentikasi sederhana (Ganti dengan cek ke database di produksi!)
    // Username: admin, Password: admin123
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error_message = 'Username atau Password salah! (Default: admin/admin123)';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .login-body { background-color: #e9ecef; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .login-container { max-width: 400px; padding: 30px; border: 1px solid #ccc; border-radius: 8px; background-color: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .login-container h2 { text-align: center; margin-bottom: 25px; color: #007bff; }
        .login-container form div { margin-bottom: 15px; }
        .login-container label { display: block; margin-bottom: 5px; font-weight: bold; }
        .login-container input[type="text"], .login-container input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .login-container button { width: 100%; padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        .login-container button:hover { background-color: #0056b3; }
        .error { color: #dc3545; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 4px; text-align: center; margin-bottom: 15px; }
    </style>
</head>
<body class="login-body">
    <div class="login-container">
        <h2>Login Admin</h2>
        <?php if ($error_message): ?>
            <p class="error"><?= $error_message ?></p>
        <?php endif; ?>
        <form method="POST">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>