<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Veritabanı bağlantısı
require_once "config.php";

$username = $_SESSION['username'];

// Kullanıcı bilgilerini al
$q = mysqli_query($db, "SELECT * FROM users WHERE `User_Name`='$username'");
$user = mysqli_fetch_assoc($q);
$role = $user['yetki'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Özer Market</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5; /* Soft light grey */
            color: #333333; /* Dark grey for text */
            font-family: 'Arial', sans-serif;
            position: relative;
            min-height: 100vh;
            padding-bottom: 100px; /* Height of the footer + additional spacing */
            box-sizing: border-box;
        }
        .navbar {
            background-color: #ffffff; /* White navbar */
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar-nav > li > a {
            color: #333333; /* Dark grey for links */
        }
        .navbar-nav > li > a:hover {
            background-color: #e7e7e7; /* Light grey on hover */
        }
        .jumbotron {
            background-color: #e9f7fc; /* Soft blue background */
            color: #007bff; /* Blue text */
            padding: 2rem 1rem;
            border-radius: .3rem;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .panel-heading {
            background-color: #007bff; /* Blue */
            color: #ffffff;
            padding: 10px;
            border-top-left-radius: .3rem;
            border-top-right-radius: .3rem;
        }
        .panel-body {
            background-color: #ffffff; /* White panel body */
            color: #333333; /* Dark grey text */
            padding: 15px;
            border-bottom-left-radius: .3rem;
            border-bottom-right-radius: .3rem;
        }
        .panel {
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .container h1 a {
            color: #007bff; /* Blue */
            text-decoration: none;
        }
        .container h1 a:hover {
            color: #0056b3; /* Dark blue */
        }
        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 60px; /* Height of the footer */
            background-color: #007bff; /* Blue background */
            color: white; /* White text */
            text-align: center;
            padding: 20px 0;
            font-size: 14px;
            margin-top: 20px; /* Space between content and footer */
        }
        a{
            color: #e9967a;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        function redirectToLogin() {
            window.location.replace('girskayit.php'); // Yönlendirme URL'si
        }
    </script>
</head>
<body>
<div class="container">
    <h1>Hakkımda</h1>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Ana Sayfa</a></li>
                <li><a href="urunler.php">Ürünler</a></li>
                <li class="active"><a href="hakkimizda.php">Hakkımızda</a></li>
                <?php if ($role == '2'): ?>
                    <li><a href="yetkiduzenle.php">Yetkiler</a></li>
                <?php elseif ($role == '3'): ?>
                    <li><a href="urun_ekle.php">Ürün Ekle</a></li>
                    <li><a href="kategori_duzenle.php">Kategori Düzenle</a></li>
                <?php endif; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if ($role == '1'): ?>
                <li><a href="#">Sepet </a></li>
                <?php endif; ?>
                <li><a href="hesapbilgileri.php">Hesap </a></li>
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Çıkış Yap</a></li>
            </ul>
        </div>
    </nav>
    <div class="jumbotron">
        <h1>ÖZER MARKET</h1>
        <p>Siz değerli müşterilerimize hizmet vermekten mutluluk duyarız.</p>
        <br>            
        <p><a href="https://github.com/Eren0zer">GitHub Sayfam</a></p>
        <p><a href="https://github.com/Eren0zer/Web-Tabanli-Programlama-Eren-Market" style="color: red;">Bu projenin GitHub sayfası</a></p>
        <p><a href="https://www.linkedin.com/in/eren-%C3%B6zer-845314291/">Linkedln Sayfam</a></p>
        <p>Web tabanlı programlama için yapmış olduğum <a href="https://oskarandmia.erenozer.com.tr/">oyuna buradan ulaşabilirsiniz</a></p>
        <p>Bilgisayar mimarisi için yapmış olduğum Hamming Code <a href="http://hammingcode.erenozer.com.tr/">projesine buradan ulaşabilirsiniz</a></p>
    </div>
    <div class="panel">
        <div class="panel-heading">Neden Özer Market?</div>
        <div class="panel-body">
            <p align="justify">Eren Market, sizlere evinizin konforunda kaliteli ve taze ürünlere ulaşma imkanı sunuyor. Zengin ürün yelpazemizle, günlük ihtiyaçlarınızı zahmetsizce karşılayabilir, zamandan tasarruf edebilirsiniz. Geniş ürün yelpazemizde yer alan taze meyve-sebzeler, et ve süt ürünleri, temizlik malzemeleri ve daha fazlası, kapınıza kadar güvenle teslim edilir.</p>
        </div>
    </div>
</div>
<footer>
    Sayfanın GitHub Linkine buradan ulaşabilirsiniz <a href="https://github.com/Eren0zer/Web-Tabanli-Programlama-Eren-Market" style="color: white;">Eren0zer</a>
</footer>
</body>
</html>
