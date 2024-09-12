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

        // Prepare and execute the query to find the user
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the user exists and the password is correct
        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Invalid username or password.";
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
    <html lang="ar" dir="rtl">
    <link rel="stylesheet" href="admin-login.css">
    <title>Admin Login</title>
    
</head>
<body>
    <div class="login-container">
        <h1>تسجيل الدخول للإدارة</h1>
        <form action="login.php" method="POST">
            <label for="username">اسم المستخدم:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">كلمة المرور:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">تسجيل الدخول</button>

            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
