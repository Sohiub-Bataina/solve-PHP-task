<?php
include 'db.php';

function fetchRecords($table) {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM $table where state=1 ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getData($table,$colum,$user_id) {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM $table where $colum=$user_id ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


$users = fetchRecords('user');
$orders = fetchRecords('orders');
$items = fetchRecords('items');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        h2 {
            margin-top: 20px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        a {
            color: #4CAF50;
            text-decoration: none;
            margin-right: 10px;
        }
        a:hover {
            text-decoration: underline;
        }
        img {
            max-width: 50px;
            height: auto;
        }
        .action-links {
            display: flex;
            justify-content: space-around;
        }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <h2>Users</h2>
    <table>
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['user_id']; ?></td>
            <td><?php echo $user['user_name']; ?></td>
            <td><?php echo $user['user_mobile']; ?></td>
            <td><?php echo $user['user_email']; ?></td>
            <td><?php echo $user['user_address']; ?></td>
            <td class="action-links">
               
                <a href="soft_delete_user.php?id=<?php echo $user['user_id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Orders</h2>
    <table>
        <tr>
            <th>Order ID</th>
            <th>User Order ID</th>
            <th>User Item Order ID</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?php echo $order['order_id']; ?></td>
            <td><?php echo getData('user','user_id',$order['user_order_id'])[0]['user_name']; ?></td>
            <td><?php echo getData('items','item_id',$order['user_item_order_id'])[0]['item_description'];  ?></td>
            <td class="action-links">
                
                <a href="soft_delete_order.php?id=<?php echo $order['order_id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Items</h2>
    <table>
        <tr>
            <th>Item ID</th>
            <th>Description</th>
            <th>Image</th>
            <th>Total Number</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($items as $item): ?>
        <tr>
            <td><?php echo $item['item_id']; ?></td>
            <td><?php echo $item['item_description']; ?></td>
            <td><img src="<?php echo $item['item_image']; ?>" alt="Item Image"></td>
            <td><?php echo $item['item_total_number']; ?></td>
            <td class="action-links">
                <a href="edit_item.php?id=<?php echo $item['item_id']; ?>">Edit</a>
                <a href="soft_delete_item.php?id=<?php echo $item['item_id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="action-links">
        <a href="create_user.php">Create User</a>
      
        <a href="create_item.php">Create Item</a>
    </div>
</body>
</html>
