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

// Yetki düzenleme işlemleri
if ($role != '2') {
    header("Location: index.php");
    exit();
}

// Kullanıcıları getir
$query = "SELECT * FROM users";
$result = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Yetkileri Düzenle</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5; /* Soft light grey */
            color: #333333; /* Dark grey for text */
            font-family: 'Arial', sans-serif;
        }

        th, td {
            vertical-align: middle !important;
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
        
    </style>
</head>
<body>
<div class="container">
    <h1>Yetkileri Düzenle</h1>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Ana Sayfa</a></li>
                <li><a href="urunler.php">Ürünler</a></li>
                <li><a href="hakkimizda.php">Hakkımızda</a></li>
                <?php if ($role == '2'): ?>
                    <li class="active"><a href="yetkiduzenle.php">Yetkiler</a></li>
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
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Kullanıcı Adı</th>
            <th>Yetki</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['User_Name']; ?></td>
                <td>
                    <form action="yetkidegistir.php" method="POST">
                        <input type="hidden" name="user_id" value="<?php echo $row['User_ID']; ?>">
                        <select name="new_role" class="form-control">
                            <option value="1" <?php echo ($row['yetki'] == '1') ? 'selected' : ''; ?>>Üye</option>
                            <option value="3" <?php echo ($row['yetki'] == '3') ? 'selected' : ''; ?>>Personel</option>
                            <option value="2" <?php echo ($row['yetki'] == '2') ? 'selected' : ''; ?>>Admin</option>
                        </select>
                </td>
                <td>
                    <button type="submit" class="btn btn-primary">Kaydet</button>
                    </form>
                    <form action="kullanicisil.php" method="POST">
                        <input type="hidden" name="user_id" value="<?php echo $row['User_ID']; ?>">
                        <button type="submit" class="btn btn-danger">Sil</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
