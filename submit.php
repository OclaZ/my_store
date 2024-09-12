<?php
$host = 'localhost';
$db = 'store_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $packs = $_POST['packs'];

    // Insert data into the database
    $stmt = $pdo->prepare("INSERT INTO sales (customer_name, email, phone, pack_option) VALUES (:name, :email, :phone, :packs)");
    $stmt->execute(['name' => $name, 'email' => $email, 'phone' => $phone, 'packs' => $packs]);

    // Redirect to thank you page
    header("Location: thankyou.html");
    exit();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
