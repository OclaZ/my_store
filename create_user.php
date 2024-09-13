<?php
session_start();

$host = 'localhost';
$db = 'store_db';
$user = 'root';
$pass = '';

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Process the form if it is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Check if password and confirm password match
        if ($password !== $confirm_password) {
            $error = "Passwords do not match.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare and execute the query to insert the new admin user
            $stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES (:username, :password)");
            $stmt->execute(['username' => $username, 'password' => $hashed_password]);

            $success = "New admin user created successfully.";
        }
    }
} catch (PDOException $e) {
    $error = "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/admin-login.css">
    <title>Create Admin User</title>
</head>
<body>
    <div class="login-container">
        <h1>إنشاء مستخدم جديد</h1>
        <form action="create_user.php" method="POST">
            <label for="username">اسم المستخدم:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">كلمة المرور:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">تأكيد كلمة المرور:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">إنشاء مستخدم</button>

            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php elseif (isset($success)): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>
        </form>

        <a href="login.php">الرجوع لتسجيل الدخول</a>
    </div>
</body>
</html>
