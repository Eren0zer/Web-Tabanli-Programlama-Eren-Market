<?php
session_start(); // Oturumu başlat
$mysqli = new mysqli("localhost", "root", "", "webproje");

// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoş Geldiniz!</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        body {
            background-color: #1c1c1c; /* Dark background */
            color: #fff; /* White text color */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }
        .container {
            text-align: center;
            background-color: #333; /* Darker container background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Darker shadow */
            width: 600px; /* Adjusted width */
        }
        .btn {
            margin: 10px;
            width: 150px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        h1 {
            margin-bottom: 30px;
            color: #007bff; /* Blue color for the heading */
        }
        p {
            color: #ccc; /* Light grey color for the paragraph */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Hoş Geldiniz!</h1>
        <p>Lütfen aşağıdaki seçeneklerden birini seçin:</p>

        <form action="signup.php" method="GET" style="display:inline;">
            <button type="submit" class="btn btn-primary">Kayıt Ol</button>
        </form>

        <form action="login.php" method="GET" style="display:inline;">
            <button type="submit" class="btn btn-success">Giriş Yap</button>
        </form>
    </div>
</body>
</html>
