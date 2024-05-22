<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

require_once "config.php";

$username = $_SESSION['username'];

$q = mysqli_query($db, "SELECT * FROM users WHERE `User_Name`='$username'");
$user = mysqli_fetch_assoc($q);
$role = $user['yetki'];

$query = "SELECT urunler.*, kategori.isim as kategori_isim FROM urunler INNER JOIN kategori ON urunler.kategori_id = kategori.id";
$result = mysqli_query($db, $query);

function isCustomer($role) {
    return $role == '1';
}

function isStaffOrAdmin($role) {
    return $role == '2' || $role == '3';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ürünler</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            color: #333333;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: #ffffff;
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar-nav > li > a {
            color: #333333;
        }
        .navbar-nav > li > a:hover {
            background-color: #e7e7e7;
        }
        .container {
            margin-bottom: 50px;
        }
        .product {
            margin-bottom: 20px;
        }
        .product img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Ürünler</h1>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Ana Sayfa</a></li>
                <li class="active"><a href="urunler.php">Ürünler</a></li>
                <li><a href="hakkimizda.php">Hakkımızda</a></li>
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
                <li><a href="hesapbilgileri.php">Hesap</a></li>
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Çıkış Yap</a></li>
            </ul>
        </div>
    </nav>

    <div class="row">
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="col-sm-3 product">
                <div class="thumbnail">
                    <?php if (!empty($row['resim'])): ?>
                        <img src="uploads/<?php echo $row['resim']; ?>" alt="<?php echo $row['isim']; ?>">
                    <?php endif; ?>
                    <div class="caption">
                        <h4><?php echo $row['isim']; ?></h4>
                        <p>Stok: <?php echo $row['adet']; ?></p>
                        <p>Fiyat: <?php echo number_format($row['birimfiyat'], 2); ?> TL</p> <!-- Fiyat bilgisi -->
                        <p>Kategori: <?php echo $row['kategori_isim']; ?></p>
                        <?php if (isCustomer($role)): ?>
                            <form method="POST" action="sepet.php">
                                <div class="form-group">
                                    <label for="quantity_<?php echo $row['id']; ?>">Adet:</label>
                                    <input type="number" class="form-control" id="quantity_<?php echo $row['id']; ?>" name="quantity" min="1" max="<?php echo $row['adet']; ?>" required>
                                </div>
                                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-primary">Sepete Ekle</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>
</body>
</html>
