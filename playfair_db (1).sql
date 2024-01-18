-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Des 2023 pada 12.06
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `playfair_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `data`
--

CREATE TABLE `data` (
  `id_integer` varchar(64) NOT NULL,
  `nama` varchar(512) DEFAULT NULL,
  `email` varchar(512) DEFAULT NULL,
  `alamat` varchar(512) DEFAULT NULL,
  `no_telp` varchar(512) DEFAULT NULL,
  `data_awal` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `data`
--

INSERT INTO `data` (`id_integer`, `nama`, `email`, `alamat`, `no_telp`, `data_awal`) VALUES
('530993', 'OP1L', 'OP1LMALGAOEN', 'KG4LONHLGH', 'YDTMOHOCBOHIUT4YCOTCY4OSYMBOHIUUYMBMQS', '{\"nama\":\"noval\",\"email\":\"noval12@gmail.com\",\"alamat\":\"jalan mana ge\",\"no_telp\":\"098772824\"}'),
('84bd18', '2HRN', '2HRNF8LF8O4M', '8210ONBLFF82', 'PO7SYMSIS66BPTF68YHBHYBHX09HKHIS', '{\"nama\":\"bisma\",\"email\":\"bisma1@gmail.com\",\"alamat\":\"jalan mana aja\",\"no_telp\":\"12345678\"}');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id_integer`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
