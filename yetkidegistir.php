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

// Yetki kontrolü (sadece admin kullanıcılar yetki değiştirme işlemi yapabilir)
if ($role != '2') {
    header("Location: index.php");
    exit();
}

// Yetki değiştirme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['new_role'];

    // Yetki değiştirme sorgusu
    $update_query = "UPDATE users SET yetki = '$new_role' WHERE User_ID = '$user_id'";
    $update_result = mysqli_query($db, $update_query);

    if ($update_result) {
        header("Location: yetkiduzenle.php"); // Başarılı yetki değiştirme işlemi durumunda yetkiler sayfasına yönlendirme
        exit();
    } else {
        echo "Yetki değiştirme işlemi başarısız!";
    }
}
?>
