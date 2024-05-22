<?php
session_start(); // Oturumu başlat

require_once "config.php";

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form_username = $_POST["username"];
    $form_password = $_POST["password"];
    $form_email = $_POST["email"];
    $form_firstname = $_POST["firstname"];
    $form_lastname = $_POST["lastname"];
    $form_gsm = $_POST["gsm"];
    $form_birth = $_POST["birth"];

    $passlen = strlen($form_password);
    if ($passlen < 0 || $passlen > 15) {
        $message = "<div class='alert alert-danger'>Şifre en az 6, en fazla 15 karakterden oluşmalıdır!</div>";
    } else {
        $form_password_hash = password_hash($form_password, PASSWORD_BCRYPT);

        $rt = mysqli_query($db, "INSERT INTO `users` (`User_Name`, `Password`, `E_Mail`, `First_Name`, `Last_Name`, `GSM_No`, `Birth_Date`) VALUES ('$form_username', '$form_password_hash', '$form_email', '$form_firstname', '$form_lastname', '$form_gsm', '$form_birth')");

        if (mysqli_errno($db) != 0) {
            $message = "<div class='alert alert-danger'>Bir hata meydana geldi!</div>";
        } else {
            $message = "<div class='alert alert-success'>Kullanıcı kaydınız başarılı!<br><form action='login.php' method='GET' style='display:inline;'><button type='submit' class='btn btn-success btn-sm'>Giriş Yap</button></form></div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
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
            max-width: 500px; /* Adjusted width */
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
        <h1 class="text-center">Kayıt Ol</h1>
        <?php echo $message; ?>
        <form action="signup.php" method="POST">
            <div class="form-group">
                <label for="username">Kullanıcı adı:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Şifre:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="email">Eposta:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="firstname">İsminiz:</label>
                <input type="text" class="form-control" id="firstname" name="firstname" required>
            </div>
            <div class="form-group">
                <label for="lastname">Soyadınız:</label>
                <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>
            <div class="form-group">
                <label for="gsm">Telefon:</label>
                <input type="tel" class="form-control" id="gsm" name="gsm" pattern="\d{11}" required>
            </div>
            <div class="form-group">
                <label for="birth">Doğum Tarihi:</label>
                <input type="date" class="form-control" id="birth" name="birth" required>
            </div>
            <button type="submit" class="btn btn-primary">Kayıt Ol!</button>
        </form>
        <a href="girskayit.php" class="back-link">Geri dön</a>
    </div>
</body>
</html>

<?php
?>
