<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: login.php");
    exit();
}

$host = 'localhost';
$db = 'store_db';
$user = 'root';
$pass = '';

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Determine the status filter
    $statusFilter = isset($_GET['status']) ? $_GET['status'] : 'all';

    // Prepare the SQL query based on the status filter
    if ($statusFilter === 'all') {
        $stmt = $pdo->query("SELECT * FROM sales ORDER BY created_at DESC");
    } else {
        $stmt = $pdo->prepare("SELECT * FROM sales WHERE status = :status ORDER BY created_at DESC");
        $stmt->execute(['status' => $statusFilter]);
    }

    $sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Handle status update
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $status = $_POST['status'];

            if (isset($id) && isset($status)) {
                $stmt = $pdo->prepare("UPDATE sales SET status = :status WHERE id = :id");
                $stmt->execute(['status' => $status, 'id' => $id]);

                // Redirect after updating
                header("Location: admin_dashboard.php");
                exit();
            }
        } elseif (isset($_POST['delete'])) {
            $id = $_POST['id'];

            if (isset($id)) {
                $stmt = $pdo->prepare("DELETE FROM sales WHERE id = :id");
                $stmt->execute(['id' => $id]);

                // Redirect after deleting
                header("Location: admin_dashboard.php");
                exit();
            }
        }
    }
} catch (PDOException $e) {
    // Log database connection errors
    error_log("Database Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="30">

    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style/admin-dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this sale? This action cannot be undone.');
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="navbar">
            <a href="admin_dashboard.php?status=all" class="<?php echo $statusFilter === 'all' ? 'active' : ''; ?>">All</a>
            <a href="admin_dashboard.php?status=confirmed" class="<?php echo $statusFilter === 'confirmed' ? 'active' : ''; ?>">Confirmed</a>
            <a href="admin_dashboard.php?status=canceled" class="<?php echo $statusFilter === 'canceled' ? 'active' : ''; ?>">Canceled</a>
            <a href="admin_dashboard.php?status=shipped" class="<?php echo $statusFilter === 'shipped' ? 'active' : ''; ?>">Shipped</a>
            <a href="admin_dashboard.php?status=non confirmed" class="<?php echo $statusFilter === 'non confirmed' ? 'active' : ''; ?>">Non Confirmed</a>
        </div>

        <h1>Admin Dashboard</h1>

        <div class="statistics">
            <h2>Sales Statistics</h2>
            <?php
            $totalSales = count($sales);
            $confirmedSales = count(array_filter($sales, fn($sale) => $sale['status'] === 'confirmed'));
            $canceledSales = count(array_filter($sales, fn($sale) => $sale['status'] === 'canceled'));
            $shippedSales = count(array_filter($sales, fn($sale) => $sale['status'] === 'shipped'));
            $nonConfirmedSales = count(array_filter($sales, fn($sale) => $sale['status'] === 'non confirmed'));

            echo "<p>Total Sales: $totalSales</p>";
            echo "<p>Confirmed Sales: $confirmedSales</p>";
            echo "<p>Canceled Sales: $canceledSales</p>";
            echo "<p>Shipped Sales: $shippedSales</p>";
            echo "<p>Non Confirmed Sales: $nonConfirmedSales</p>";
            ?>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Pack Option</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sales as $sale): ?>
                <tr>
                    <td><?php echo htmlspecialchars($sale['id']); ?></td>
                    <td><?php echo htmlspecialchars($sale['customer_name']); ?></td>
                    <td><?php echo htmlspecialchars($sale['email']); ?></td>
                    <td><?php echo htmlspecialchars($sale['phone']); ?></td>
                    <td><?php echo htmlspecialchars($sale['pack_option']); ?></td>
                    <td><?php echo htmlspecialchars($sale['status']); ?></td>
                    <td>
                        <form class="status-form" method="POST" action="admin_dashboard.php" style="display: inline-block;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($sale['id']); ?>">
                            <select name="status" class="status-select">
                                <option value="non confirmed" <?php echo $sale['status'] === 'non confirmed' ? 'selected' : ''; ?>>Non Confirmed</option>
                                <option value="confirmed" <?php echo $sale['status'] === 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                <option value="canceled" <?php echo $sale['status'] === 'canceled' ? 'selected' : ''; ?>>Canceled</option>
                                <option value="shipped" <?php echo $sale['status'] === 'shipped' ? 'selected' : ''; ?>>Shipped</option>
                </select>

                <button type="submit" name="update" class="status-button">Update Status</button>
                        </form>
                        <form method="POST" action="admin_dashboard.php" style="display: inline-block;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($sale['id']); ?>">
                            <button type="submit" name="delete" class="trash-button" onclick="return confirmDelete();"></button>
                        </form>

                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>