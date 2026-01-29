-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2026 at 05:58 AM
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
-- Database: `sibeauty`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`) VALUES
(1, 'Skincare', 'skincare', '2026-01-15 16:53:46'),
(2, 'Bodycare', 'bodycare', '2026-01-15 16:53:46'),
(3, 'Fragrance', 'fragrance', '2026-01-15 16:53:46'),
(4, 'Make Up', 'make-up', '2026-01-15 16:53:46'),
(5, 'Hair Care', '', '2026-01-16 00:48:45');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `invoice_number` varchar(50) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `status` enum('pending','paid','shipped','completed','cancelled') DEFAULT 'pending',
  `shipping_address` text NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_proof` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `invoice_number`, `total_amount`, `payment_method`, `status`, `shipping_address`, `order_date`, `payment_proof`, `created_at`) VALUES
(1, 3, 'INV-1768526881957', 520000.00, 'Bank BRI', 'completed', 'jalancagak, subang, 33333', '2026-01-16 01:28:01', 'PAY-1768526918.jpeg', '2026-01-16 01:28:01'),
(2, 3, 'INV-1768527683444', 900000.00, 'Bank BCA', 'completed', 'subanghuh, subang, 33333', '2026-01-16 01:41:23', 'PAY-1768527725.jpeg', '2026-01-16 01:41:23'),
(3, 4, 'INV-1768896647614', 580000.00, 'Bank BRI', 'shipped', 'Rancasari, Pamanukan, Subang, Subang, 41254', '2026-01-20 08:10:47', 'PAY-1768896675.png', '2026-01-20 08:10:47'),
(4, 4, 'INV-1768896958565', 520000.00, 'Bank BCA', 'paid', 'Rancasari, Pamanukan, Subang, Subang, 41254', '2026-01-20 08:15:58', 'PAY-1768896976.png', '2026-01-20 08:15:58');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `price`, `quantity`) VALUES
(1, 1, 34, 520000.00, 1),
(2, 2, 35, 480000.00, 1),
(3, 2, 32, 420000.00, 1),
(4, 3, 30, 580000.00, 1),
(5, 4, 34, 520000.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(160) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `gender` enum('women','men','unisex') DEFAULT 'women',
  `image` varchar(255) DEFAULT 'default.jpg',
  `is_bestseller` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `stock`, `gender`, `image`, `is_bestseller`, `created_at`) VALUES
(1, 1, 'Lancôme Advanced Génifique Serum', 'lancome-genifique-serum', 'Serum anti-aging nomor 1 untuk memperkuat skin barrier dan kilau wajah.', 1500000.00, 0, '', 'default.jpg', 0, '2026-01-16 00:55:53'),
(2, 1, 'Clinique Moisture Surge 100H', 'clinique-moisture-surge-100h', 'Pelembap bertekstur gel-krim yang menghidrasi hingga lapisan terdalam.', 850000.00, 0, 'unisex', 'default.jpg', 0, '2026-01-16 00:55:53'),
(3, 1, 'Origins GinZing Energy-Boosting Gel', 'origins-ginzing-gel', 'Pelembap wajah yang memberikan energi instan dengan kandungan kafein dan ginseng.', 550000.00, 0, 'unisex', 'default.jpg', 0, '2026-01-16 00:55:53'),
(4, 1, 'Drunk Elephant Lala Retro Whipped Cream', 'drunk-elephant-lala-retro', 'Krim penyelamat kulit kering dengan campuran 6 minyak Afrika langka.', 980000.00, 0, 'unisex', 'default.jpg', 0, '2026-01-16 00:55:53'),
(5, 1, 'Sunday Riley Good Genes Glycolic Acid', 'sunday-riley-good-genes', 'Perawatan eksfoliasi yang mencerahkan dan menghaluskan tekstur kulit seketika.', 1650000.00, 0, '', 'default.jpg', 0, '2026-01-16 00:55:53'),
(6, 1, 'Shiseido Ultimune Power Infusing Concentrate', 'shiseido-ultimune-concentrate', 'Serum penambah imunitas kulit untuk tampilan lebih sehat dan kenyal.', 1800000.00, 0, 'unisex', 'default.jpg', 0, '2026-01-16 00:55:53'),
(7, 1, 'Glow Recipe Watermelon Glow PHA+BHA Toner', 'glow-recipe-watermelon-toner', 'Toner viral yang membantu mengecilkan pori-pori dan menghidrasi kulit.', 580000.00, 0, '', 'default.jpg', 0, '2026-01-16 00:55:53'),
(8, 2, 'Lush Dream Cream Body Lotion', 'lush-dream-cream', 'Lotion tubuh dengan bahan oat milk dan lavender untuk menenangkan kulit sensitif.', 420000.00, 0, 'unisex', 'default.jpg', 0, '2026-01-16 00:55:53'),
(9, 2, 'Bio-Oil Skincare Oil', 'bio-oil-skincare-oil', 'Minyak spesialis untuk membantu menyamarkan bekas luka dan stretch marks.', 185000.00, 0, 'unisex', 'default.jpg', 0, '2026-01-16 00:55:53'),
(10, 2, 'Sol de Janeiro Bom Dia Bright Cream', 'sol-de-janeiro-bom-dia', 'Krim tubuh dengan AHA buah-buahan untuk menghaluskan tekstur kulit.', 780000.00, 0, '', 'default.jpg', 0, '2026-01-16 00:55:53'),
(11, 2, 'Dove Deeply Nourishing Body Wash', 'dove-deeply-nourishing-wash', 'Sabun mandi cair yang memberikan kelembapan hingga ke dalam lapisan kulit.', 55000.00, 0, 'unisex', 'default.jpg', 0, '2026-01-16 00:55:53'),
(12, 2, 'Nivea Creme Tin Blue', 'nivea-creme-tin', 'Pelembap ikonik multifungsi untuk seluruh area kulit yang sangat kering.', 35000.00, 0, 'unisex', 'default.jpg', 0, '2026-01-16 00:55:53'),
(13, 2, 'Elemis Frangipani Monoi Body Oil', 'elemis-frangipani-oil', 'Minyak tubuh mewah dengan aroma bunga tropis yang menenangkan.', 950000.00, 0, '', 'default.jpg', 0, '2026-01-16 00:55:53'),
(14, 2, 'Glossier Body Hero Daily Oil Wash', 'glossier-body-hero-wash', 'Pembersih tubuh berbahan minyak yang membersihkan tanpa membuat kulit kering.', 450000.00, 0, '', 'default.jpg', 0, '2026-01-16 00:55:53'),
(15, 3, 'Versace Eros Eau de Toilette', 'versace-eros-edt', 'Aroma maskulin yang segar dengan campuran mint, apel hijau, dan vanilla.', 1650000.00, 0, '', 'default.jpg', 0, '2026-01-16 00:55:53'),
(16, 3, 'Viktor&Rolf Flowerbomb EDP', 'viktor-rolf-flowerbomb', 'Ledakan aroma floral dari melati, mawar, dan anggrek yang sangat feminin.', 2550000.00, 0, '', 'default.jpg', 0, '2026-01-16 00:55:53'),
(17, 3, 'Prada Paradoxe Eau de Parfum', 'prada-paradoxe', 'Parfum floral amber yang modern dan ikonik dalam botol segitiga.', 2300000.00, 0, '', 'default.jpg', 0, '2026-01-16 00:55:53'),
(18, 3, 'Creed Aventus', 'creed-aventus', 'Parfum mewah legendaris untuk pria dengan aroma nanas dan smoky birch.', 6800000.00, 0, '', 'default.jpg', 0, '2026-01-16 00:55:53'),
(19, 3, 'Marc Jacobs Daisy Eau de Toilette', 'marc-jacobs-daisy', 'Aroma yang ringan, ceria, dan klasik dengan sentuhan strawberry dan violet.', 1550000.00, 0, '', 'default.jpg', 0, '2026-01-16 00:55:53'),
(20, 3, 'Byredo Gypsy Water Eau de Parfum', 'byredo-gypsy-water', 'Aroma woody yang unik dengan sentuhan pinus, lemon, dan vanilla.', 3800000.00, 0, 'unisex', 'default.jpg', 0, '2026-01-16 00:55:53'),
(21, 3, 'Yves Saint Laurent Libre EDP', 'ysl-libre-edp', 'Aroma lavender yang dipadukan dengan orange blossom untuk wanita pemberani.', 2150000.00, 0, '', 'default.jpg', 0, '2026-01-16 00:55:53'),
(22, 4, 'Urban Decay Naked3 Eyeshadow Palette', 'urban-decay-naked3', 'Palet eyeshadow dengan 12 warna bernuansa rose-gold yang cantik.', 920000.00, 0, '', 'default.jpg', 0, '2026-01-16 00:55:53'),
(23, 4, 'Anastasia Beverly Hills Dipbrow Pomade', 'abh-dipbrow-pomade', 'Pomade alis waterproof untuk membentuk alis yang presisi dan tahan lama.', 380000.00, 0, '', 'default.jpg', 0, '2026-01-16 00:55:53'),
(24, 4, 'Too Faced Better Than Sex Mascara', 'too-faced-better-than-sex', 'Maskara dengan pigmentasi hitam pekat untuk volume bulu mata dramatis.', 450000.00, 0, '', 'default.jpg', 0, '2026-01-16 00:55:53'),
(25, 4, 'Laura Mercier Translucent Loose Setting Powder', 'laura-mercier-setting-powder', 'Bedak tabur legendaris yang memberikan hasil smooth dan flawless.', 750000.00, 0, '', 'default.jpg', 0, '2026-01-16 00:55:53'),
(26, 4, 'Hourglass Ambient Lighting Palette', 'hourglass-ambient-lighting', 'Palet finishing powder untuk menciptakan efek pencahayaan sempurna di wajah.', 1200000.00, 0, '', '6969921889f77.jpg', 0, '2026-01-16 00:55:53'),
(27, 4, 'Benefit Cosmetics Hoola Matte Bronzer', 'benefit-hoola-bronzer', 'Bronzer matte pemenang penghargaan untuk hasil contour alami.', 550000.00, 100, '', '696991e02ba9b.jpg', 0, '2026-01-16 00:55:53'),
(28, 4, 'Rare Beauty Positive Light Liquid Luminizer', 'rare-beauty-highlighter', 'Highlighter cair yang memberikan kilau sehat dan menyatu dengan kulit.', 420000.00, 100, '', '696991934f5b0.jpg', 0, '2026-01-16 00:55:53'),
(29, 5, 'Aveda Botanical Repair Strengthening Leave-In', 'aveda-botanical-repair', 'Perawatan tanpa bilas untuk memperbaiki rambut dari dalam ke luar.', 620000.00, 100, 'unisex', '69699160ecce6.jpg', 0, '2026-01-16 00:55:53'),
(30, 5, 'Bumble and bumble Hairdresser’s Invisible Oil', 'bumble-and-bumble-oil', 'Campuran 6 minyak ringan yang menghaluskan dan melindungi rambut.', 580000.00, 99, 'unisex', '696990ceba7c6.webp', 0, '2026-01-16 00:55:53'),
(31, 5, 'Living Proof Perfect Hair Day Dry Shampoo', 'living-proof-dry-shampoo', 'Dry shampoo yang benar-benar membersihkan rambut dari minyak dan keringat.', 450000.00, 100, 'unisex', '6969909a6583d.jpeg', 0, '2026-01-16 00:55:53'),
(32, 5, 'Redken Extreme Shampoo for Damaged Hair', 'redken-extreme-shampoo', 'Sampo khusus untuk rambut yang mengalami kerusakan kimia dan panas.', 420000.00, 99, 'unisex', '69698dd579c65.jpg', 0, '2026-01-16 00:55:53'),
(33, 5, 'Ghd Bodyguard - Heat Protect Spray', 'ghd-bodyguard-spray', 'Semprotan pelindung panas esensial sebelum menggunakan alat styling.', 390000.00, 100, 'unisex', '69698d99b56e2.jpg', 0, '2026-01-16 00:55:53'),
(34, 5, 'Ouai Detox Shampoo', 'ouai-detox-shampoo', 'Sampo penjernih untuk mengangkat sisa produk dan kotoran di kulit kepala.', 520000.00, 98, 'unisex', '69698d4bb76ec.jpg', 0, '2026-01-16 00:55:53'),
(35, 5, 'Kérastase Specifique Bain Divalent', 'kerastase-bain-divalent', 'Sampo penyeimbang untuk akar rambut berminyak dan ujung rambut kering.', 480000.00, 99, 'unisex', '69698ced7c087.jpg', 0, '2026-01-16 00:55:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `phone`, `address`, `created_at`) VALUES
(1, 'Naufal Alief Alghifari', 'naufalbravo1313@gmail.com', '$2y$10$GaqrWDhNBIC55zP6rWlzCuGjmLcS.Qv3YZtDWmShNTw/6ptOLE6m.', 'admin', '083195725280', 'Jl. Marsinu No 5, Tegalkalapa Subang, Telp 0260-417853 Fax 0260-41411873', '2026-01-15 17:39:30'),
(3, 'Afif Al Asad', 'Afif1212@gmail.co', '$2y$10$yDt.gvuAAtLu34C9UZxQNeOg3UlP4byIlZitUgyhklK58DBZSTZMy', 'user', NULL, NULL, '2026-01-16 01:02:15'),
(4, 'wahab', 'wahab1212@gmail.com', '$2y$10$XsgP0wTtXd2JM3Rj8WgzkOqgYozktCzfoNgXs7feUpNqeyFZgBSCK', 'user', NULL, NULL, '2026-01-20 08:09:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
