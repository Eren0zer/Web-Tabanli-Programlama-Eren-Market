<?php

$db_host = "localhost"; //127.0.0.1 //sql13.bilmemnehost.com
$db_user = "root";
$db_pass = "";
$db_name = "webproje";


$db = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if(mysqli_connect_errno())
{
    echo "Bağlantı kurulamadı!";
    exit();
}
