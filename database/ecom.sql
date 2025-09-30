-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2025 at 06:26 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecom`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `subtotal` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail`, `id_pesanan`, `id_produk`, `jumlah`, `subtotal`) VALUES
(1, 1, 1, 1, 1200000.00),
(2, 1, 6, 1, 1800000.00),
(3, 1, 2, 1, 700000.00),
(4, 2, 3, 1, 3500000.00),
(5, 2, 4, 1, 4500000.00);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Gitar Akustik'),
(2, 'Gitar Elektrik'),
(3, 'Gitar Klasik'),
(4, 'Gitar Bass');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `email`, `no_hp`, `alamat`) VALUES
(1, 'Dava', 'dava@example.com', '081234567890', 'Jl. Melodi No. 1'),
(2, 'Ropi', 'ropi@example.com', '081298765432', 'Jl. Harmoni No. 2'),
(3, 'Lutfi', 'lutfi@example.com', '081377788899', 'Jl. Irama No. 3'),
(4, 'Andhika', 'andhika@example.com', '081366655544', 'Jl. Nada No. 4');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `tanggal_pesanan` date DEFAULT NULL,
  `total_harga` decimal(12,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_pelanggan`, `tanggal_pesanan`, `total_harga`, `status`) VALUES
(1, 1, '2025-09-20', 3700000.00, 'Selesai'),
(2, 3, '2025-09-25', 8000000.00, 'Dikirim');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(150) DEFAULT NULL,
  `merek` varchar(100) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `harga` decimal(12,2) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `merek`, `gambar`, `harga`, `stok`, `deskripsi`, `id_kategori`) VALUES
(1, 'Yamaha F310', 'Yamaha', 'yamaha_f310.png', 1500000.00, 10, 'Yamaha F310 adalah pilihan utama bagi para gitaris pemula di seluruh dunia. Dikenal karena kualitas build-nya yang solid dan suara yang jernih, gitar ini menawarkan playability yang sangat nyaman dengan neck yang ramping. Menggunakan kayu spruce pada bagian top dan meranti di bagian belakang dan samping, F310 menghasilkan tone yang seimbang dan resonan, cocok untuk berbagai genre musik mulai dari pop, folk, hingga country. Ini adalah instrumen yang tidak akan mengecewakan dan menjadi teman setia dalam perjalanan musik Anda.', 1),
(2, 'Fender CD-60S', 'Fender', 'fender_cd60s.png', 2200000.00, 8, 'Fender CD-60S adalah gitar akustik dreadnought yang memadukan desain klasik Fender dengan suara yang kaya dan penuh. Dengan top solid spruce, gitar ini menghasilkan volume yang keras dan sustain yang panjang, di mana suaranya akan semakin matang seiring berjalannya waktu. Neck dengan profil \"Easy-to-Play\" dan tepian fretboard yang dibulatkan membuatnya sangat nyaman dimainkan, baik untuk pemula maupun pemain berpengalaman. Ideal untuk strumming maupun fingerpicking, CD-60S adalah paket lengkap dari kualitas, suara, dan kenyamanan.', 1),
(3, 'Ibanez GRX70QA', 'Ibanez', 'ibanez_grx70qa.png', 3000000.00, 5, 'Ibanez GRX70QA adalah gitar elektrik yang dirancang untuk kecepatan dan kekuatan. Dengan body poplar yang ringan dan top quilted maple art grain yang menawan, gitar ini tidak hanya terlihat keren tetapi juga nyaman dimainkan. Konfigurasi pickup HSH (Humbucker-Single Coil-Humbucker) memberikan fleksibilitas tonal yang luar biasa, memungkinkan Anda menjelajahi suara dari clean yang jernih hingga distorsi rock dan metal yang berat. Bridge tremolo T106 memungkinkan Anda untuk melakukan aksi dive-bomb dan vibrato dengan stabil. Pilihan sempurna untuk gitaris modern yang butuh Vielseitigkeit.', 2),
(4, 'Epiphone Les Paul', 'Epiphone', 'epiphone_lespaul.png', 4000000.00, 4, 'Epiphone Les Paul menawarkan suara legendaris dan tampilan ikonik dari Gibson Les Paul dengan harga yang jauh lebih terjangkau. Dibuat dengan body mahogany yang solid, gitar ini menghasilkan sustain yang luar biasa dan tone yang hangat serta tebal. Dilengkapi dengan sepasang pickup humbucker Alnico Classic PRO™, gitar ini mampu menghasilkan sound rock klasik yang powerful, blues yang soulful, hingga jazz yang lembut. Jika Anda mencari suara rock n roll abadi, Epiphone Les Paul adalah jawabannya.', 2),
(5, 'Cordoba C5', 'Cordoba', 'cordoba_c5.png', 2500000.00, 6, 'Cordoba C5 adalah gitar klasik nilon yang menjadi favorit di kalangan pelajar dan pemain fingerstyle. Dibuat dengan metode tradisional Spanyol, gitar ini memiliki top solid Canadian cedar dengan back dan sides mahogany yang menghasilkan suara hangat, jernih, dan responsif terhadap sentuhan jari. Fan bracing khas gitar Spanyol memberikan resonansi yang kaya dan kompleks. Dengan finishing high-gloss yang elegan dan detail yang menawan, Cordoba C5 adalah instrumen berkualitas tinggi untuk mendalami musik klasik, flamenco, atau bossa nova.', 3),
(6, 'Yamaha C40', 'Yamaha', 'yamaha_c40.png', 2000000.00, 7, 'Sebagai salah satu gitar klasik terlaris, Yamaha C40 telah membuktikan kualitasnya selama bertahun-tahun. Gitar ini direkomendasikan oleh banyak guru musik karena playability-nya yang mudah dan intonasinya yang akurat, menjadikannya instrumen ideal untuk pemula. Dengan kombinasi kayu spruce dan meranti, C40 menghasilkan tone nilon yang lembut dan natural. Kualitas pengerjaan Yamaha yang presisi memastikan gitar ini tahan lama dan dapat diandalkan untuk latihan sehari-hari. Mulailah perjalanan musik klasik Anda dengan instrumen yang tepat.', 3),
(7, 'Fender Player Jazz Bass', 'Fender', 'fender_jazz_bass.png', 7000000.00, 3, 'Fender Player Jazz Bass adalah evolusi modern dari bass legendaris yang telah membentuk suara musik selama beberapa dekade. Dengan body alder dan neck maple, bass ini terasa nyaman dan seimbang. Dilengkapi dua pickup single-coil Player Series Alnico 5, bass ini menghasilkan suara growl yang khas dan artikulasi yang jernih. Dari funk yang groovy, rock yang menghentak, hingga jazz yang melodis, tone serbaguna dari Jazz Bass ini siap memenuhi segala kebutuhan musik Anda di panggung maupun di studio. Rasakan standar industri dalam genggaman Anda.', 4),
(8, 'Ibanez GSR200', 'Ibanez', 'ibanez_gsr200.png', 3500000.00, 5, 'Ibanez GSR200 dari seri GIO dirancang untuk memberikan kenyamanan, kecepatan, dan suara bass Ibanez yang powerful dengan harga yang sangat bersahabat. Body-nya yang ramping dan neck-nya yang tipis membuatnya sangat mudah dimainkan, bahkan untuk pemain dengan tangan kecil. Kombinasi pickup Dynamix P dan J memberikan fleksibilitas tonal, sementara preamp aktif Phat II EQ boost menambahkan low-end yang kuat dan tebal. Baik Anda seorang pemula atau pemain berpengalaman yang mencari bass andal, GSR200 adalah pilihan cerdas.', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`),
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
