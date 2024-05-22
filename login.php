<?php
session_start();
require_once "config.php";

$message = "";

if (isset($_POST["username"])) {
    $form_username = $_POST["username"];
    $form_password = $_POST["password"];

    $q = mysqli_query($db, "SELECT * FROM users WHERE `User_Name`='$form_username'");
    $num = mysqli_num_rows($q);

    if ($num == 0) {
        $message = "<div class='alert alert-danger'>Böyle bir kullanıcı bulunamadı!</div>";
    } else if ($num == 1) {
        $user = mysqli_fetch_assoc($q);
        if (password_verify($form_password, $user['Password'])) {
            $_SESSION["username"] = $form_username;
            // Kullanıcı başarılı bir şekilde giriş yaptıktan sonra index.php'ye yönlendir
            header("Location: index.php");
            exit;
        } else {
            $message = "<div class='alert alert-danger'>Kullanıcı adı veya şifre yanlış! Lütfen tekrar deneyin.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
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
            margin-top: 50px;
            max-width: 400px; /* Adjusted width */
            padding: 20px;
            background-color: #333; /* Darker container background */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Darker shadow */
        }
        .form-group {
            margin-bottom: 15px;
        }
        .btn {
            width: 100%;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
        }
        .back-link:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Giriş Yap</h1>
        <?php echo $message; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Kullanıcı adı:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Şifre:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Giriş Yap!</button>
        </form>
        <a href="girskayit.php" class="back-link">Geri dön</a>
    </div>
</body>
</html>

<?php
?>
