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

// Yetki kontrolü (sadece admin kullanıcılar silme işlemi yapabilir)
if ($role != '2') {
    header("Location: index.php");
    exit();
}

// Kullanıcıyı silme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];

    // Kullanıcıyı silme sorgusu
    $delete_query = "DELETE FROM users WHERE User_ID = '$user_id'";
    $delete_result = mysqli_query($db, $delete_query);

    if ($delete_result) {
        header("Location: yetkiduzenle.php"); // Başarılı silme işlemi durumunda yetkiler sayfasına yönlendirme
        exit();
    } else {
        echo "Kullanıcı silme işlemi başarısız!";
    }
}
?>
