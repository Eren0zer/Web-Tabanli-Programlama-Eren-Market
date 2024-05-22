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

// Kategori ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    $categoryName = $_POST['category_name'];
    $sql = "INSERT INTO kategori (isim) VALUES ('$categoryName')";
    mysqli_query($db, $sql);
    header("Location: kategori_duzenle.php");
    exit();
}

// Kategori düzenleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_category'])) {
    $categoryId = $_POST['category_id'];
    $newCategoryName = $_POST['new_category_name'];
    $sql = "UPDATE kategori SET isim='$newCategoryName' WHERE id='$categoryId'";
    mysqli_query($db, $sql);
    header("Location: kategori_duzenle.php");
    exit();
}

// Kategori silme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_category'])) {
    $categoryId = $_POST['category_id'];
    $sql = "DELETE FROM kategori WHERE id='$categoryId'";
    mysqli_query($db, $sql);
    header("Location: kategori_duzenle.php");
    exit();
}

// Kategorileri veritabanından çek
$categories = mysqli_query($db, "SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kategori Düzenle</title>
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
    </style>
</head>
<body>
<div class="container">
    <h1>Kategori Yönetimi</h1>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Ana Sayfa</a></li>
                <li><a href="urunler.php">Ürünler</a></li>
                <li><a href="hakkimizda.php">Hakkımızda</a></li>
                <?php if ($role == '2'): ?>
                    <li><a href="yetkiduzenle.php">Yetkiler</a></li>
                <?php elseif ($role == '3'): ?>
                    <li><a href="urun_ekle.php">Ürün Ekle</a></li>
                    <li class="active"><a href="kategori_duzenle.php">Kategori Düzenle</a></li>
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
    
    <form method="post" action="kategori_duzenle.php" class="form-inline">
        <div class="form-group">
            <label for="category_name">Kategori Adı:</label>
            <input type="text" class="form-control" id="category_name" name="category_name" required>
        </div>
        <button type="submit" name="add_category" class="btn btn-primary">Kategori Ekle</button>
    </form>

    <h2>Mevcut Kategoriler</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Kategori Adı</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($category = mysqli_fetch_assoc($categories)): ?>
                <tr>
                    <td>
                        <span id="category_name_<?php echo $category['id']; ?>"><?php echo $category['isim']; ?></span>
                        <form id="edit_form_<?php echo $category['id']; ?>" method="post" action="kategori_duzenle.php" class="form-inline" style="display:none;">
                            <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                            <div class="form-group">
                                <input type="text" class="form-control" name="new_category_name" value="<?php echo $category['isim']; ?>" required>
                            </div>
                            <button type="submit" name="update_category" class="btn btn-success">Kaydet</button>
                        </form>
                    </td>
                    <td>
                        <button class="btn btn-warning" onclick="toggleEditForm(<?php echo $category['id']; ?>)">Düzenle</button>
                        <form method="post" action="kategori_duzenle.php" style="display:inline;">
                            <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                            <button type="submit" name="delete_category" class="btn btn-danger">Sil</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-primary">Ana Sayfa</a>
    <a href="logout.php" class="btn btn-danger">Çıkış Yap</a>
</div>

<script>
    function toggleEditForm(categoryId) {
        var editForm = document.getElementById('edit_form_' + categoryId);
        var categoryName = document.getElementById('category_name_' + categoryId);
        if (editForm.style.display === 'none') {
            editForm.style.display = 'inline';
            categoryName.style.display = 'none';
        } else {
            editForm.style.display = 'none';
            categoryName.style.display = 'inline';
        }
    }
</script>
</body>
</html>
