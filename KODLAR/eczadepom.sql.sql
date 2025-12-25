-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 23 Ara 2025, 12:50:29
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
-- Veritabanı: `eczadepom`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `medicines`
--

CREATE TABLE `medicines` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ilac_adi` varchar(100) NOT NULL,
  `etken_madde` varchar(100) DEFAULT NULL,
  `son_kullanma_tarihi` date NOT NULL,
  `kutu_konumu` varchar(50) DEFAULT NULL,
  `adet` int(11) DEFAULT 1,
  `kayit_tarihi` timestamp NOT NULL DEFAULT current_timestamp(),
  `kategori` varchar(255) DEFAULT 'Genel'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `medicines`
--

INSERT INTO `medicines` (`id`, `user_id`, `ilac_adi`, `etken_madde`, `son_kullanma_tarihi`, `kutu_konumu`, `adet`, `kayit_tarihi`, `kategori`) VALUES
(1, 1, 'Parol', 'Parasetamol', '2026-05-20', 'Mutfak Dolabı', 2, '2025-12-13 13:53:58', 'Ağrı Kesici'),
(3, 1, 'Arveles', 'Deksketoprofen', '2026-06-01', 'Ecza Dolabı', 1, '2025-12-15 12:15:02', 'Ağrı Kesici'),
(4, 1, 'Tylolhot', 'Parasetamol', '2025-12-22', 'Çekmece', 1, '2025-12-15 12:19:43', 'Grip İlacı'),
(5, 1, 'Augmentin', 'Amoksisilin', '2026-12-02', 'Ecza Dolabı', 1, '2025-12-15 12:42:19', 'Antibiyotik'),
(6, 1, 'Rennie', 'Kalsiyum', '2026-05-20', 'Mutfak Dolabı', 1, '2025-12-15 15:40:06', 'Mide İlacı'),
(7, 1, 'Talcid', 'Hidrotalsit', '2025-11-15', 'Ecza Dolabı', 1, '2025-12-15 15:40:06', 'Mide İlacı'),
(8, 1, 'Gaviscon', 'Sodyum Aljinat', '2026-01-30', 'Çanta', 1, '2025-12-15 15:40:06', 'Mide Şurubu'),
(9, 1, 'Muskazon', 'Klorzoksazon', '2025-08-10', 'Ecza Dolabı', 1, '2025-12-15 15:40:06', 'Kas Gevşetici'),
(10, 1, 'Voltaren', 'Diklofenak', '2026-03-22', 'Banyo Dolabı', 1, '2025-12-15 15:40:06', 'Kas Kremi'),
(11, 1, 'Dikloron', 'Diklofenak', '2025-12-05', 'Çekmece', 1, '2025-12-15 15:40:06', 'Kas Gevşetici'),
(12, 1, 'Bepanthen', 'Dekspantenol', '2027-01-01', 'Banyo', 1, '2025-12-15 15:40:06', 'Cilt Bakımı'),
(13, 1, 'Fito', 'Triticum Vulgare', '2026-09-15', 'Ecza Dolabı', 1, '2025-12-15 15:40:06', 'Cilt Kremi'),
(14, 1, 'Travazol', 'İzokonazol', '2025-06-30', 'Dolap', 1, '2025-12-15 15:40:06', 'Cilt İlacı'),
(15, 1, 'Augmentin', 'Amoksisilin', '2020-10-02', 'Çekmece', 1, '2025-12-15 21:17:02', 'Antibiyotik'),
(16, 1, 'Otrivine', 'Ksilometazolin', '2028-05-22', 'Buzdolabı', 1, '2025-12-15 21:31:06', 'Burun Spreyi'),
(17, 1, 'Theraflu', 'Parasetamol', '2004-09-22', 'Ecza Dolabı', 1, '2025-12-15 21:34:43', 'Grip İlacı'),
(18, 1, 'Dolorex', 'Diklofenak', '2026-03-14', 'Çekmece', 1, '2025-12-16 09:06:44', 'Ağrı Kesici'),
(19, 2, 'Augmentin', 'Amoksisilin', '2025-04-22', 'Ecza Dolabı', 1, '2025-12-16 09:48:43', 'Antibiyotik'),
(20, 2, 'Arveles', 'Deksketoprofen', '2025-11-16', 'Ecza Dolabı', 1, '2025-12-16 09:48:57', 'Ağrı Kesici'),
(21, 2, 'Rennie', 'Kalsiyum Karbonat', '2026-12-30', 'Banyo', 1, '2025-12-16 09:49:17', 'Mide İlacı'),
(22, 2, 'Parol 500mg', 'Parasetamol', '2025-12-22', 'Mutfak', 1, '2025-12-16 10:24:05', 'Ağrı Kesici'),
(23, 2, 'Majezik', 'Flurbiprofen', '2027-02-18', 'Banyo', 1, '2025-12-16 10:24:05', 'Ağrı Kesici'),
(24, 2, 'Vermidon', 'Parasetamol', '2027-07-11', 'Mutfak', 1, '2025-12-16 10:24:05', 'Ağrı Kesici'),
(25, 2, 'Minoset', 'Parasetamol', '2025-12-12', 'Ecza Dolabı', 1, '2025-12-16 10:24:05', 'Ağrı Kesici'),
(26, 2, 'Apranax', 'Naproksen', '2026-10-20', 'Ecza Dolabı', 1, '2025-12-16 10:24:05', 'Ağrı Kesici'),
(27, 2, 'Dolorex', 'Diklofenak Potasyum', '2026-04-04', 'Banyo', 1, '2025-12-16 10:24:05', 'Ağrı Kesici'),
(28, 2, 'Dikloron', 'Diklofenak Sodyum', '2027-09-27', 'Banyo', 1, '2025-12-16 10:24:05', 'Kas Gevşetici'),
(29, 2, 'Muskazon', 'Klorzoksazon', '2026-10-06', 'Mutfak', 1, '2025-12-16 10:24:05', 'Kas Gevşetici'),
(30, 2, 'Voltaren Krem', 'Diklofenak', '2026-08-13', 'Mutfak', 1, '2025-12-16 10:24:05', 'Kas Gevşetici'),
(31, 2, 'Augmentin 1000mg', 'Amoksisilin', '2027-10-09', 'Çanta', 1, '2025-12-16 10:24:05', 'Antibiyotik'),
(32, 2, 'Klamoks', 'Amoksisilin', '2026-10-23', 'Banyo', 1, '2025-12-16 10:24:05', 'Antibiyotik'),
(33, 2, 'Largopen', 'Amoksisilin', '2025-02-13', 'Çekmece', 1, '2025-12-16 10:24:05', 'Antibiyotik'),
(34, 2, 'Zimaks', 'Sefiksim', '2025-09-26', 'Çekmece', 1, '2025-12-16 10:24:05', 'Antibiyotik'),
(35, 2, 'Tylolhot', 'Parasetamol', '2025-04-18', 'Mutfak', 1, '2025-12-16 10:24:05', 'Grip İlacı'),
(36, 2, 'Nurofen Cold', 'İbuprofen', '2027-02-17', 'Çanta', 1, '2025-12-16 10:24:05', 'Grip İlacı'),
(37, 2, 'Aferin', 'Parasetamol', '2026-09-07', 'Çanta', 1, '2025-12-16 10:24:05', 'Grip İlacı'),
(38, 2, 'İburamin Zero', 'İbuprofen', '2027-07-11', 'Mutfak', 1, '2025-12-16 10:24:05', 'Grip İlacı'),
(39, 2, 'Theraflu', 'Parasetamol', '2025-10-28', 'Çanta', 1, '2025-12-16 10:24:05', 'Grip İlacı'),
(40, 2, 'Calpol Şurup', 'Parasetamol', '2026-08-10', 'Ecza Dolabı', 1, '2025-12-16 10:24:05', 'Ateş Düşürücü'),
(42, 2, 'Gaviscon Şurup', 'Sodyum Aljinat', '2027-07-04', 'Çanta', 1, '2025-12-16 10:24:05', 'Mide İlacı'),
(43, 2, 'Rennie Tablet', 'Kalsiyum Karbonat', '2025-06-16', 'Banyo', 1, '2025-12-16 10:24:05', 'Mide İlacı'),
(44, 2, 'Talcid', 'Hidrotalsit', '2027-05-12', 'Mutfak', 1, '2025-12-16 10:24:05', 'Mide İlacı'),
(45, 2, 'Nexium', 'Esomeprazol', '2025-05-17', 'Çekmece', 1, '2025-12-16 10:24:05', 'Mide İlacı'),
(46, 2, 'Lansor', 'Lansoprazol', '2027-05-28', 'Çekmece', 1, '2025-12-16 10:24:05', 'Mide İlacı'),
(47, 2, 'Metpamid', 'Metoklopramid', '2025-10-27', 'Banyo', 1, '2025-12-16 10:24:05', 'Mide İlacı'),
(49, 2, 'Madecassol', 'Centella Asiatica', '2025-02-27', 'Mutfak', 1, '2025-12-16 10:24:05', 'Cilt Bakımı'),
(50, 2, 'Fito Krem', 'Triticum Vulgare', '2026-10-27', 'Mutfak', 1, '2025-12-16 10:24:05', 'Cilt Bakımı'),
(51, 2, 'Silverdin', 'Gümüş Sülfadiazin', '2026-12-11', 'Çanta', 1, '2025-12-16 10:24:05', 'Yanık Kremi'),
(52, 2, 'Furacin', 'Nitrofurazon', '2027-08-25', 'Çanta', 1, '2025-12-16 10:24:05', 'Antibiyotikli Krem'),
(53, 2, 'Benexol', 'B12 Vitamini', '2027-12-16', 'Çekmece', 1, '2025-12-16 10:24:05', 'Vitamin'),
(54, 2, 'Supradyn', 'Multivitamin', '2025-06-24', 'Çekmece', 1, '2025-12-16 10:24:05', 'Vitamin'),
(55, 2, 'Pharmaton', 'Ginseng G115', '2025-01-18', 'Banyo', 1, '2025-12-16 10:24:05', 'Vitamin'),
(56, 2, 'Redoxon', 'C Vitamini', '2026-05-24', 'Çekmece', 1, '2025-12-16 10:24:05', 'Vitamin'),
(57, 2, 'Devit-3', 'D3 Vitamini', '2025-11-08', 'Banyo', 1, '2025-12-16 10:24:05', 'Vitamin'),
(59, 2, 'Zyrtec', 'Setirizin', '2027-08-22', 'Ecza Dolabı', 1, '2025-12-16 10:24:05', 'Alerji İlacı'),
(60, 2, 'Crebros', 'Levosetirizin', '2027-01-19', 'Ecza Dolabı', 1, '2025-12-16 10:24:05', 'Alerji İlacı'),
(61, 2, 'Aspirin', 'Asetilsalisilik Asit', '2027-06-24', 'Çekmece', 1, '2025-12-16 10:24:05', 'Kan Sulandırıcı'),
(62, 2, 'Coraspin', 'Asetilsalisilik Asit', '2025-07-03', 'Ecza Dolabı', 1, '2025-12-16 10:24:05', 'Kan Sulandırıcı'),
(63, 2, 'Buscopan', 'Hiyosin', '2027-02-26', 'Çanta', 1, '2025-12-16 10:24:05', 'Kramp Çözücü'),
(64, 2, 'Majezik Sprey', 'Flurbiprofen', '2027-01-07', 'Banyo', 1, '2025-12-16 10:24:05', 'Boğaz Spreyi'),
(65, 2, 'Tantum Verde', 'Benzidamin', '2026-01-07', 'Çanta', 1, '2025-12-16 10:24:05', 'Boğaz Spreyi'),
(66, 2, 'Otrivine', 'Ksilometazolin', '2027-05-14', 'Mutfak', 1, '2025-12-16 10:24:05', 'Burun Spreyi'),
(67, 2, 'İliadin', 'Oksimetazolin', '2027-05-17', 'Ecza Dolabı', 1, '2025-12-16 10:24:05', 'Burun Spreyi'),
(68, 2, 'Prospan', 'Hedera Helix', '2026-01-12', 'Mutfak', 1, '2025-12-16 10:24:05', 'Öksürük Şurubu'),
(69, 2, 'Perebron', 'Oksolamin', '2027-04-26', 'Çekmece', 1, '2025-12-16 10:24:05', 'Öksürük Şurubu'),
(70, 3, 'Arveles', 'Deksketoprofen', '2028-09-22', 'Ecza Dolabı', 1, '2025-12-16 10:42:46', 'Ağrı Kesici'),
(73, 5, 'Parol 500mg', 'Parasetamol', '2026-01-06', 'Ecza Dolabı', 1, '2025-12-16 13:01:33', 'Ağrı Kesici'),
(75, 7, 'Largopen', 'Amoksisilin', '2026-07-14', 'Çanta', 1, '2025-12-16 18:42:46', 'Antibiyotik'),
(76, 8, 'Arveles', 'Deksketoprofen', '0000-00-00', 'Ecza Dolabı', 1, '2025-12-19 09:32:45', 'Ağrı Kesici'),
(77, 9, 'Vermidon', 'Parasetamol', '2029-12-15', 'Ecza Dolabı', 1, '2025-12-20 15:27:02', 'Ağrı Kesici'),
(78, 9, 'Muskazon', 'Klorzoksazon', '2025-08-30', 'Diğer', 1, '2025-12-20 15:27:21', 'Kas Gevşetici'),
(79, 10, 'Otrivine', 'Ksilometazolin', '2025-12-21', 'Ecza Dolabı', 1, '2025-12-21 12:21:57', 'Burun Spreyi'),
(81, 11, 'Prospan', 'Hedera Helix', '2029-12-25', 'Ecza Dolabı', 1, '2025-12-23 11:11:37', 'Öksürük Şurubu');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'ogrenci', '12345', 'ogrenci@okul.edu.tr', '2025-12-13 13:53:58'),
(2, 'ecren', '1234', NULL, '2025-12-16 09:48:03'),
(3, 'ebrar', '2582', NULL, '2025-12-16 10:42:05'),
(4, 'sami', '1591', NULL, '2025-12-16 11:29:06'),
(5, 'slnerler', 'selen2005', NULL, '2025-12-16 13:01:03'),
(6, 'sude', '1472', NULL, '2025-12-16 15:08:14'),
(7, 'deniz', '1307', NULL, '2025-12-16 18:38:04'),
(8, 'yaren', '123456', NULL, '2025-12-19 09:30:56'),
(9, 'candan', '2209', NULL, '2025-12-20 15:12:54'),
(10, 'ayhan', '2025', NULL, '2025-12-21 12:18:53'),
(11, 'ecrenazlı', '2209', NULL, '2025-12-23 11:09:03');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `medicines`
--
ALTER TABLE `medicines`
  ADD CONSTRAINT `medicines_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
