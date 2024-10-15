<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE items SET item_description = :description, item_image = :image, item_total_number = :total_number WHERE item_id = :id");
    $stmt->execute([
        'description' => $_POST['description'],
        'image' => $_POST['image'],
        'total_number' => $_POST['total_number'],
        'id' => $_POST['id']
    ]);
    header("Location: admin_dashboard.php");
}

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM items WHERE item_id = :id");
    $stmt->execute(['id' => $_GET['id']]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Item</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #28a745;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
        a {
            display: inline-block;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Edit Item</h1>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $item['item_id']; ?>">
        <input type="text" name="description" value="<?php echo $item['item_description']; ?>" placeholder="Item Description" required>
        <input type="text" name="image" value="<?php echo $item['item_image']; ?>" placeholder="Image Path" required>
        <input type="number" name="total_number" value="<?php echo $item['item_total_number']; ?>" placeholder="Total Number" required>
        <button type="submit">Update</button>
    </form>
    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
