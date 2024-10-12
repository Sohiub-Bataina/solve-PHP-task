<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px 0;
            display: none; 
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <script>
        function toggleTable() {
            var table = document.getElementById("dataTable");
            if (table.style.display === "none") {
                table.style.display = "table"; 
            } else {
                table.style.display = "none"; 
            }
        }
    </script>
</head>
<body>

<form method="POST">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" required><br><br>
    
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>
    
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>
    
    <input type="submit" value="Submit" >
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']); 

    $_SESSION['user'] = [
        'username' => $username,
        'email' => $email,
        'password' => $password 
    ];

    echo '<button onclick="toggleTable()">Show Data</button>';
    echo "<table id='dataTable'>
            <tr>
                <th>Field</th>
                <th>Value</th>
            </tr>
            <tr>
                <td>Username</td>
                <td>" . htmlspecialchars($_SESSION['user']['username']) . "</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>" . htmlspecialchars($_SESSION['user']['email']) . "</td>
            </tr>
            <tr>
                <td>Password</td>
                <td>" . htmlspecialchars($_SESSION['user']['password']) . " (do not store plain passwords in production)</td>
            </tr>
        </table>";
}
?>

</body>
</html>