<?php
session_start(); // Oturumu başlat

// Oturumu sonlandır
session_unset();
session_destroy();

// Yeni bir oturum başlat (opsiyonel)
session_start();

// Kullanıcıyı başka bir sayfaya yönlendir (opsiyonel)
header("Location: girskayit.php");
exit;
?>