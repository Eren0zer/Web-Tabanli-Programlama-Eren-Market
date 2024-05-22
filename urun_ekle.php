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

// Yetki kontrolü - Sadece personel ve yöneticilere izin ver
if ($role != '3' && $role != '2') {
    header("Location: index.php");
    exit();
}

// Kategori isimlerini getir
$kategori_query = "SELECT * FROM kategori";
$kategori_result = mysqli_query($db, $kategori_query);
$kategoriler = [];
while ($row = mysqli_fetch_assoc($kategori_result)) {
    $kategoriler[$row['id']] = $row['isim'];
}

// Ürün ekleme ve güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_product'])) {
        $product_name = $_POST['product_name'];
        $product_quantity = $_POST['product_quantity'];
        $product_category_id = $_POST['product_category_id'];
        $product_price = $_POST['product_price']; // Fiyat eklendi

        // Aynı isimde bir ürün var mı kontrol et
        $check_query = "SELECT * FROM urunler WHERE isim='$product_name' AND kategori_id='$product_category_id'";
        $check_result = mysqli_query($db, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
            // Ürün zaten varsa, stok adedini artır
            $existing_product = mysqli_fetch_assoc($check_result);
            $new_quantity = $existing_product['adet'] + $product_quantity;
            $update_query = "UPDATE urunler SET adet='$new_quantity', birimfiyat='$product_price' WHERE id='" . $existing_product['id'] . "'"; // Fiyat güncelleniyor
            if (mysqli_query($db, $update_query)) {
                if ($new_quantity < 5) {
                    echo "<script>alert('Stok sayısı 5\'ten az olan bir ürün güncellediniz!');</script>";
                }
            } else {
                echo "Ürün güncellenirken bir hata oluştu: " . mysqli_error($db);
            }
        } else {
            // Ürün yoksa, yeni ürünü ekle
            $insert_query = "INSERT INTO urunler (kategori_id, isim, adet, birimfiyat) VALUES ('$product_category_id', '$product_name', '$product_quantity', '$product_price')"; // Fiyat ekleniyor
            if (mysqli_query($db, $insert_query)) {
                if ($product_quantity < 5) {
                    echo "<script>alert('Stok sayısı 5\'ten az olan bir ürün eklediniz!');</script>";
                }
            } else {
                echo "Ürün eklenirken bir hata oluştu: " . mysqli_error($db);
            }
        }
    } elseif (isset($_POST['edit_product'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_quantity = $_POST['product_quantity'];
        $product_category_id = $_POST['product_category_id'];
        $product_price = $_POST['product_price']; // Fiyat eklendi

        // Ürünü güncelle
        $update_query = "UPDATE urunler SET kategori_id='$product_category_id', isim='$product_name', adet='$product_quantity', birimfiyat='$product_price' WHERE id='$product_id'"; // Fiyat güncelleniyor
        if (mysqli_query($db, $update_query)) {
            if ($product_quantity < 5) {
                echo "<script>alert('Stok sayısı 5\'ten az olan bir ürün güncellediniz!');</script>";
            }
        } else {
            echo "Ürün güncellenirken bir hata oluştu: " . mysqli_error($db);
        }
    } elseif (isset($_POST['delete_product'])) {
        $product_id = $_POST['product_id'];

        // Ürünü veritabanından sil
        $delete_query = "DELETE FROM urunler WHERE id='$product_id'";
        if (!mysqli_query($db, $delete_query)) {
            echo "Ürün silinirken bir hata oluştu: " . mysqli_error($db);
        }
    }
}

// Ürünleri getir
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';
$order_by = $order === 'desc' ? 'desc' : 'asc';
$query = "SELECT urunler.*, kategori.isim as kategori_isim FROM urunler INNER JOIN kategori ON urunler.kategori_id = kategori.id ORDER BY urunler.adet $order_by";
$result = mysqli_query($db, $query);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Ürün Yönetimi</title>
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
        .container {
            margin-bottom: 50px;
        }
        .form-inline .form-group {
            margin-right: 2px;
        }
        .form-inline input, .form-inline select {
            width: auto;
            display: inline-block;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Ürün Yönetimi</h1>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Ana Sayfa</a></li>
                <li><a href="urunler.php">Ürünler</a></li>
                <li><a href="hakkimizda.php">Hakkımızda</a></li>
                <?php if ($role == '2'): ?>
                    <li><a href="yetkiduzenle.php">Yetkiler</a></li>
                <?php elseif ($role == '3'): ?>
                    <li class="active"><a href="urun_ekle.php">Ürün Ekle</a></li>
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
    <form method="POST" action="urun_ekle.php" class="form-inline" style="margin-bottom: 20px;">
        <div class="form-group">
            <label for="product_name">Ürün Adı:</label>
            <input type="text" class="form-control" id="product_name" name="product_name" required>
        </div>
        <div class="form-group">
            <label for="product_quantity">Stok Adedi:</label>
            <input type="number" step="0.01" class="form-control" id="product_quantity" name="product_quantity" required>
        </div>
        <div class="form-group">
            <label for="product_price">Fiyat:</label>
            <input type="text" class="form-control" id="product_price" name="product_price" required> <!-- Fiyat alanı -->
        </div>
        <div class="form-group">
            <label for="product_category_id">Kategori:</label>
            <select class="form-control" id="product_category_id" name="product_category_id" required>
                <?php foreach ($kategoriler as $id => $isim): ?>
                    <option value="<?php echo $id; ?>"><?php echo $isim; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" name="add_product" class="btn btn-primary">Ürün Ekle</button>
    </form>
    <div style="margin-bottom: 20px;">
        <a href="?order=<?php echo $order_by === 'asc' ? 'desc' : 'asc'; ?>" class="btn btn-default">
            Stok Adedine Göre Sırala
        </a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Ürün Adı</th>
                <th>Stok Adedi</th>
                <th>Kategori</th>
                <th>Fiyat</th> <!-- Fiyat başlığı eklendi -->
                <th>Düzenle</th>
                <th>Sil</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['isim']; ?></td>
                    <td>
                        <?php
                        $quantity = $row['adet'];
                        if ($quantity < 5) {
                            echo "<span style='color: red;'>$quantity</span>";
                        } else {
                            echo $quantity;
                        }
                        ?>
                    </td>
                    <td><?php echo $row['kategori_isim']; ?></td>
                    <td><?php echo number_format($row['birimfiyat'], 2) . ' TL'; ?></td> <!-- Fiyat gösteriliyor ve 'TL' ekleniyor -->
                    <td>
                        <button class="btn btn-warning" onclick="enableEditing('<?php echo $row['id']; ?>')">Düzenle</button>
                    </td>
                    <td>
                        <form method="POST" action="urun_ekle.php">
                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete_product" class="btn btn-danger" onclick="return confirm('Silmek istediğinizden emin misiniz?')">Sil</button>
                        </form>
                    </td>
                </tr>
                <tr id="<?php echo $row['id']; ?>_edit_row" style="display: none;">
                    <form method="POST" action="urun_ekle.php">
                        <td><input type="text" class="form-control" name="product_name" value="<?php echo $row['isim']; ?>"></td>
                        <td><input type="number" step="0.01" class="form-control" name="product_quantity" value="<?php echo $row['adet']; ?>"></td>
                        <td>
                            <select class="form-control" name="product_category_id">
                                <?php foreach ($kategoriler as $id => $isim): ?>
                                    <option value="<?php echo $id; ?>" <?php if ($id == $row['kategori_id']) echo 'selected'; ?>><?php echo $isim; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><input type="text" class="form-control" name="product_price" value="<?php echo $row['birimfiyat']; ?>"></td> <!-- Fiyat düzenlenebilir alan -->
                        <td>
                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="edit_product" class="btn btn-success">Kaydet</button>
                        </td>
                        <td><button type="button" class="btn btn-default" onclick="cancelEditing('<?php echo $row['id']; ?>')">İptal</button></td>
                    </form>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<script>
    function enableEditing(productId) {
        document.getElementById(productId + '_edit_row').style.display = 'table-row';
    }

    function cancelEditing(productId) {
        document.getElementById(productId + '_edit_row').style.display = 'none';
    }
</script>
</body>
</html>
