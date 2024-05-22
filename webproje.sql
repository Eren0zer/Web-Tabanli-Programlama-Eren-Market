-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 22 May 2024, 15:19:47
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `webproje`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `isim` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kategori`
--

INSERT INTO `kategori` (`id`, `isim`) VALUES
(5, 'Meyve ve Sebzeler'),
(6, 'Et ve Balık Ürünleri'),
(7, 'Süt ve Süt Ürünleri'),
(8, 'Temel Gıda Maddeleri'),
(9, 'Kuru Baklagiller'),
(10, 'Konserveler ve Hazır Yiyecekler'),
(11, 'Atıştırmalıklar'),
(12, 'Temel Temizlik ve Kişisel Bakım Ürünleri'),
(13, 'Mutfak Malzemeleri'),
(14, 'İçecekler'),
(15, 'Temizlik Malzemeleri');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

CREATE TABLE `urunler` (
  `id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL DEFAULT 0,
  `isim` varchar(100) NOT NULL,
  `adet` int(11) NOT NULL,
  `birimfiyat` decimal(11,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `urunler`
--

INSERT INTO `urunler` (`id`, `kategori_id`, `isim`, `adet`, `birimfiyat`) VALUES
(25, 5, 'karpuz', 17, 60),
(26, 7, 'Süt 1L ', 143, 353),
(27, 8, 'Ayçiçek Yağı 2L', 24, 125),
(28, 8, 'Un 5Kg', 35, 80),
(29, 14, 'Maden suyu 200Ml ', 51, 7);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `User_ID` int(11) NOT NULL,
  `yetki` tinyint(4) NOT NULL DEFAULT 1,
  `User_Name` varchar(50) DEFAULT NULL,
  `E_Mail` varchar(100) DEFAULT NULL,
  `First_Name` varchar(50) DEFAULT NULL,
  `Last_Name` varchar(50) DEFAULT NULL,
  `GSM_No` varchar(20) DEFAULT NULL,
  `Birth_Date` date DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`User_ID`, `yetki`, `User_Name`, `E_Mail`, `First_Name`, `Last_Name`, `GSM_No`, `Birth_Date`, `Password`) VALUES
(19, 2, 'admin', 'eren12341@gmail.com', 'Erenene', 'Özerwer', '05078223436', '2023-02-12', '$2y$10$9Aaal0.KW5jHvMe8GG391.ibFeSE6hDGGh0Fo96J3S0aLMgInE00m'),
(21, 3, 'erenozer', 'eren45632@gmail.com', 'Mehmet', 'Özer', '05078245678', '2024-05-10', '$2y$10$5atdPoToPHH9ddsj579DyeAZRNLJ1HyWqXYeK7qylvsB/snAAtDqO'),
(29, 1, 'erenozer2', 'er57458465@gmail.com', 'Eren', 'Özer', '05078263486', '2006-06-07', '$2y$10$RmvUZ41FkWaqDNce/sr2ZOcgmIZzCUeqaY0BvBG0dK1lMSUoYltGS');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `urunler`
--
ALTER TABLE `urunler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`User_ID`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Tablo için AUTO_INCREMENT değeri `urunler`
--
ALTER TABLE `urunler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
