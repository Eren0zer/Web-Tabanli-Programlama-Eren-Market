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

// Bilgiyi güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $column = $_POST['column'];
    $value = $_POST['value'];
    $user_id = $user['User_ID'];

    $update_query = "UPDATE users SET `$column`='$value' WHERE `User_ID`='$user_id'";
    mysqli_query($db, $update_query);
    header("Location: hesapbilgileri.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hesap Bilgileri</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
         body {
            background-color: #f5f5f5; /* Soft light grey */
            color: #333333; /* Dark grey for text */
            font-family: 'Arial', sans-serif;
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
    <script>
        function enableEditing(field) {
            document.getElementById(field + '_text').style.display = 'none';
            document.getElementById(field + '_input').style.display = 'block';
            document.getElementById(field + '_edit_btn').style.display = 'none';
            document.getElementById(field + '_save_btn').style.display = 'inline-block';
        }

        function saveChanges(field) {
            document.getElementById(field + '_form').submit();
        }
    </script>
</head>
<body>
<div class="container">
    <h1>Hesap Bilgileri</h1>
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
                    <li><a href="kategori_duzenle.php">Kategori Düzenle</a></li>
                <?php endif; ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if ($role == '1'): ?>
                <li><a href="#">Sepet </a></li>
                <?php endif; ?>
                <li class="active"><a href="hesapbilgileri.php">Hesap</a></li>
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Çıkış Yap</a></li>
            </ul>
        </div>
    </nav>
    <table class="table table-striped">
        <tr>
            <th>Kullanıcı Adı:</th>
            <td><?php echo $user['User_Name']; ?></td>
            <td></td> <!-- Düzenle ve Kaydet butonları boş bırakıldı -->
        </tr>
        <?php 
        $fields = [
            'E_Mail' => 'E-posta',
            'First_Name' => 'İsim',
            'Last_Name' => 'Soyisim',
            'GSM_No' => 'Telefon',
            'Birth_Date' => 'Doğum Tarihi'
        ];
        foreach ($fields as $db_field => $display_name): ?>
        <tr>
            <th><?php echo $display_name; ?>:</th>
            <td>
                <span id="<?php echo $db_field; ?>_text"><?php echo $user[$db_field]; ?></span>
                <form id="<?php echo $db_field; ?>_form" action="hesapbilgileri.php" method="POST" style="display:inline;">
                    <input type="hidden" name="column" value="<?php echo $db_field; ?>">
                    <input type="text" name="value" id="<?php echo $db_field; ?>_input" value="<?php echo $user[$db_field]; ?>" class="form-control" style="display:none;">
                </form>
            </td>
            <td>
                <button id="<?php echo $db_field; ?>_edit_btn" class="btn btn-warning" onclick="enableEditing('<?php echo $db_field; ?>')">Düzenle</button>
                <button id="<?php echo $db_field; ?>_save_btn" class="btn btn-success" style="display:none;" onclick="saveChanges('<?php echo $db_field; ?>')">Kaydet</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="index.php" class="btn btn-primary">Ana Sayfa</a>
    <a href="logout.php" class="btn btn-danger">Çıkış Yap</a>
</div>
</body>
</html>
