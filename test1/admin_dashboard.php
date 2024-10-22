<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin Dashboard</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        h1, h2 {
            color: #343a40;
        }
        .table {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php
// Database connection details
$host = 'localhost'; // or your host
$username = 'root'; // your database username
$password = ''; // your database password
$database = 'tick&style'; // your database name

try {
    // Create a PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>

<div class="container mt-5">
    <h1 class="mb-4">Admin Dashboard</h1>

    <div class="row">
        <div class="col-md-6">
            <h2>User Profiles</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT user_id, user_name, user_email, user_phoneNum FROM users WHERE isDeleted = 0";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>{$row['user_id']}</td>
                                <td>{$row['user_name']}</td>
                                <td>{$row['user_email']}</td>
                                <td>{$row['user_phoneNum']}</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="col-md-6">
            <h2>Order History</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>User ID</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $order_query = "SELECT * FROM orders";
                    $order_stmt = $conn->prepare($order_query);
                    $order_stmt->execute();
                    while ($order = $order_stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>{$order['order_id']}</td>
                                <td>{$order['user_id']}</td>
                                <td>{$order['order_total']}</td>
                                <td>{$order['order_status']}</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
