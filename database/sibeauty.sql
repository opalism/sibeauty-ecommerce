-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2026 at 09:37 AM
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
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
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
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `slug`, `created_at`) VALUES
(1, NULL, 'Skincare', '', '2026-01-31 08:34:39'),
(2, NULL, 'Make Up', '', '2026-01-31 08:34:39'),
(3, NULL, 'Body Care', '', '2026-01-31 08:34:39'),
(4, NULL, 'Hair Care', '', '2026-01-31 08:34:39'),
(5, NULL, 'Fragrance', '', '2026-01-31 08:34:39'),
(6, 1, 'Facial Wash & Cleanser', '', '2026-01-31 08:34:39'),
(7, 1, 'Toner & Essence', '', '2026-01-31 08:34:39'),
(8, 1, 'Serum & Ampoule', '', '2026-01-31 08:34:39'),
(9, 1, 'Moisturizer & Cream', '', '2026-01-31 08:34:39'),
(10, 1, 'Sunscreen', '', '2026-01-31 08:34:39'),
(11, 1, 'Masker Wajah', '', '2026-01-31 08:34:39'),
(12, 2, 'Complexion (Face)', '', '2026-01-31 08:34:39'),
(13, 2, 'Lip Products', '', '2026-01-31 08:34:39'),
(14, 2, 'Eye Make Up', '', '2026-01-31 08:34:39'),
(15, 3, 'Sabun Mandi', '', '2026-01-31 08:34:39'),
(16, 3, 'Body Lotion & Serum', '', '2026-01-31 08:34:39'),
(17, 3, 'Scrub & Lulur', '', '2026-01-31 08:34:39'),
(18, 4, 'Shampoo', '', '2026-01-31 08:34:39'),
(19, 4, 'Hair Treatment & Vitamin', '', '2026-01-31 08:34:39'),
(20, 5, 'Parfum Wanita', '', '2026-01-31 08:34:39'),
(21, 5, 'Parfum Pria & Unisex', '', '2026-01-31 08:34:39');

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
  `status` enum('pending','paid','shipping','completed','cancelled') DEFAULT 'pending',
  `shipping_address` text NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_proof` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 9, 'The Originote Hyalucera Moisturizer', '', 'Moisturizer viral 40rb-an dengan Hyaluron & Ceramide.', 42000.00, 500, 'women', 'originote-mois.jpg', 0, '2026-01-31 08:34:39'),
(2, 9, 'Glad2Glow Blueberry 5% Ceramide', '', 'Moisturizer blueberry wangi segar untuk kulit berjerawat.', 39000.00, 450, 'women', 'glad2glow-berry.jpg', 0, '2026-01-31 08:34:39'),
(3, 9, 'Skintific 5X Ceramide Barrier Repair', '', 'Ratu moisturizer! Memperbaiki skin barrier rusak dalam 24 jam.', 139000.00, 200, 'women', 'skintific-blue.jpg', 0, '2026-01-31 08:34:39'),
(4, 9, 'Wardah Lightening Day Cream 30g', '', 'Krim pagi pencerah halal dengan Advanced Niacinamide.', 42000.00, 200, 'women', 'wardah-day.jpg', 0, '2026-01-31 08:34:39'),
(5, 9, 'Ponds Age Miracle Night Cream', '', 'Krim malam anti-aging untuk usia 25 tahun ke atas.', 120000.00, 60, 'women', 'ponds-night.jpg', 0, '2026-01-31 08:34:39'),
(6, 8, 'Somethinc 5% Niacinamide Sabi Beet', '', 'Serum pencerah kulit kusam, samarkan noda hitam.', 89000.00, 150, 'women', 'somethinc-niacin.jpg', 0, '2026-01-31 08:34:39'),
(7, 8, 'Whitelab Brightening Face Serum', '', 'Serum Niacinamide 10% + Collagen. Glowing maksimal.', 76000.00, 120, 'women', 'whitelab-serum.jpg', 0, '2026-01-31 08:34:39'),
(8, 8, 'Lacoco Dark Spot Essence', '', 'Essence ajaib penghilang bekas jerawat hitam membandel.', 190000.00, 40, 'women', 'lacoco-darkspot.jpg', 0, '2026-01-31 08:34:39'),
(9, 8, 'Scarlett Whitening Acne Serum', '', 'Serum khusus kulit berjerawat dengan Tea Tree Water.', 75000.00, 100, 'women', 'scarlett-acne.jpg', 0, '2026-01-31 08:34:39'),
(10, 8, 'Implora Luminous Brightening Serum', '', 'Serum 20 ribuan yang bagus buat mencerahkan.', 29000.00, 300, 'women', 'implora-serum.jpg', 0, '2026-01-31 08:34:39'),
(11, 8, 'Hanasui Serum Vitamin C + Collagen', '', 'Serum oren legendaris, bikin wajah kenyal.', 25000.00, 250, 'women', 'hanasui-vitc.jpg', 0, '2026-01-31 08:34:39'),
(12, 8, 'Bio Beauty Lab Luxurious Facial Oil', '', 'Face oil mewah untuk kulit kering dan anti-aging.', 195000.00, 30, 'women', 'biobeautylab.jpg', 0, '2026-01-31 08:34:39'),
(13, 8, 'ElsheSkin Retinol Rejuvenating Serum', '', 'Serum retinol pemula untuk mencegah penuaan dini.', 139000.00, 50, 'women', 'elsheskin-retinol.jpg', 0, '2026-01-31 08:34:39'),
(14, 8, 'Cosrx Snail Mucin Power Essence', '', 'Essence lendir siput Korea yang bikin kulit kenyal.', 180000.00, 40, 'women', 'cosrx-snail.jpg', 0, '2026-01-31 08:34:39'),
(15, 7, 'Avoskin Miraculous Refine Toner', '', 'Exfoliating toner terbaik (AHA BHA PHA).', 149000.00, 80, 'women', 'avoskin-toner.jpg', 0, '2026-01-31 08:34:39'),
(16, 7, 'NPURE Cica Toner Centella Asiatica', '', 'Toner wajah berjerawat, ada daun asli di dalamnya.', 100000.00, 90, 'women', 'npure-toner.jpg', 0, '2026-01-31 08:34:39'),
(17, 7, 'Studio Tropik Priming Water', '', 'Setting spray dan primer makeup agar tahan lama.', 99000.00, 85, 'women', 'studiotropik.jpg', 0, '2026-01-31 08:34:39'),
(18, 7, 'Viva Face Tonic Bengkuang', '', 'Penyegar wajah legendaris super murah.', 7500.00, 500, 'women', 'viva-tonic.jpg', 0, '2026-01-31 08:34:39'),
(19, 10, 'Azarine Hydrasoothe Sunscreen Gel', '', 'Sunscreen gel ringan, dingin, tanpa whitecast.', 65000.00, 300, 'women', 'azarine-spf.jpg', 0, '2026-01-31 08:34:39'),
(20, 10, 'Facetology Triple Care Sunscreen', '', 'Hybrid sunscreen dengan tekstur seringan air.', 79000.00, 100, 'women', 'facetology.jpg', 0, '2026-01-31 08:34:39'),
(21, 10, 'Madam Gie Protect Me Sunscreen', '', 'Sunscreen murah meriah milik Gisella Anastasia.', 28000.00, 200, 'women', 'madamgie.jpg', 0, '2026-01-31 08:34:39'),
(22, 6, 'Emina Bright Stuff Face Wash', '', 'Sabun cuci muka remaja, mencerahkan dan lembut.', 25000.00, 300, 'women', 'emina-wash.jpg', 0, '2026-01-31 08:34:39'),
(23, 6, 'Hada Labo Gokujyun Face Wash', '', 'Facial wash super lembap, pH balanced, tanpa parfum.', 45000.00, 150, 'women', 'hadalabo-wash.jpg', 0, '2026-01-31 08:34:39'),
(24, 6, 'Cleanface Micellar Water 100ml', '', 'Pembersih makeup termurah tapi bersih banget.', 15000.00, 400, 'women', 'cleanface.jpg', 0, '2026-01-31 08:34:39'),
(25, 6, 'Garnier Micellar Water Pink', '', 'Pembersih wajah untuk kulit sensitif, tanpa bilas.', 35000.00, 250, 'women', 'garnier-pink.jpg', 0, '2026-01-31 08:34:39'),
(26, 6, 'Viva Milk Cleanser Bengkuang', '', 'Pembersih susu legendaris ibu-ibu Indonesia.', 8000.00, 500, 'women', 'viva-milk.jpg', 0, '2026-01-31 08:34:39'),
(27, 11, 'Dorskin Matcha Glow Dream Mask', '', 'Sleeping mask teh hijau untuk meredakan kemerahan.', 129000.00, 60, 'women', 'dorskin.jpg', 0, '2026-01-31 08:34:39'),
(28, 11, 'True to Skin Mugwort Tripeptide', '', 'Gel mask mugwort untuk menenangkan kulit iritasi.', 85000.00, 70, 'women', 'truetoskin.jpg', 0, '2026-01-31 08:34:39'),
(29, 11, 'Sariayu Masker Jerawat Sachet', '', 'Masker bubuk tradisional ampuh kempiskan jerawat.', 12000.00, 200, 'women', 'sariayu-masker.jpg', 0, '2026-01-31 08:34:39'),
(30, 11, 'Mustika Ratu Peeling Mundisari', '', 'Scrub wajah tradisional angkat sel kulit mati.', 18000.00, 150, 'women', 'mustika-peeling.jpg', 0, '2026-01-31 08:34:39'),
(31, 11, 'Breylee Blackhead Mask Step 1', '', 'Masker komedo tempel yang super satisfying.', 45000.00, 100, 'women', 'breylee.jpg', 0, '2026-01-31 08:34:39'),
(32, 12, 'Make Over Powerstay Demi-Matte Cushion', '', 'Cushion coverage tinggi tahan 12 jam, hasil natural.', 215000.00, 50, 'women', 'makeover-cushion.jpg', 0, '2026-01-31 08:34:39'),
(33, 12, 'Luxcrime Blur & Cover Two Way Cake', '', 'Bedak padat viral efek blur pori-pori.', 129000.00, 80, 'women', 'luxcrime-twc.jpg', 0, '2026-01-31 08:34:39'),
(34, 12, 'Somethinc Hooman Breathable Cushion', '', 'Cushion hybrid mesh, finish matte anti-geser.', 189000.00, 60, 'women', 'somethinc-hooman.jpg', 0, '2026-01-31 08:34:39'),
(35, 12, 'Looke Holy Flawless BB Cushion', '', 'Cushion brand lokal premium dengan finish satin.', 225000.00, 30, 'women', 'looke-cushion.jpg', 0, '2026-01-31 08:34:39'),
(36, 12, 'BLP Beauty Face Powder', '', 'Bedak tabur super halus, hasil makeup natural.', 149000.00, 45, 'women', 'blp-powder.jpg', 0, '2026-01-31 08:34:39'),
(37, 12, 'Mother of Pearl (MOP) Primer', '', 'Primer Tasya Farasya, makeup nempel seharian.', 169000.00, 35, 'women', 'mop-primer.jpg', 0, '2026-01-31 08:34:39'),
(38, 12, 'ESQA Goddess Cheek Palette', '', 'Palette blush, bronzer, dan highlighter pigmentasi juara.', 295000.00, 25, 'women', 'esqa-palette.jpg', 0, '2026-01-31 08:34:39'),
(39, 12, 'Y.O.U Noutriwear+ Flawless Cushion', '', 'Cushion dengan kandungan skincare, coverage medium.', 145000.00, 50, 'women', 'you-cushion.jpg', 0, '2026-01-31 08:34:39'),
(40, 12, 'Fanbo Acne Solution Loose Powder', '', 'Bedak tabur khusus kulit berjerawat.', 40000.00, 80, 'women', 'fanbo-powder.jpg', 0, '2026-01-31 08:34:39'),
(41, 12, 'Pixy Make It Glow Dewy Cushion', '', 'Cushion hasil glowing basah (dewy) buat kulit kering.', 110000.00, 70, 'women', 'pixy-cushion.jpg', 0, '2026-01-31 08:34:39'),
(42, 13, 'Emina Glossy Stain Lip Tint', '', 'Lip tint glossy cantik ala Korea.', 48000.00, 150, 'women', 'emina-liptint.jpg', 0, '2026-01-31 08:34:39'),
(43, 13, 'Hanasui Mattedorable Lip Cream', '', 'Lip cream matte murah tahan lama wangi boba.', 25000.00, 400, 'women', 'hanasui-lip.jpg', 0, '2026-01-31 08:34:39'),
(44, 13, 'Implora Urban Lip Cream Matte', '', 'Lip cream sejuta umat, warna lengkap.', 18000.00, 500, 'women', 'implora-lip.jpg', 0, '2026-01-31 08:34:39'),
(45, 13, 'Maybelline Superstay Matte Ink', '', 'Lip cream paling tahan banting, anti badai.', 115000.00, 100, 'women', 'maybelline-ink.jpg', 0, '2026-01-31 08:34:39'),
(46, 13, 'Goban Melted Matte Lip', '', 'Lip cream lokal high-end, tekstur cair.', 110000.00, 40, 'women', 'goban-lip.jpg', 0, '2026-01-31 08:34:39'),
(47, 13, 'Secondate Milky Gel Lip Tint', '', 'Lip tint gel yang lembap dan stain banget.', 99000.00, 50, 'women', 'secondate.jpg', 0, '2026-01-31 08:34:39'),
(48, 13, 'Dear Me Beauty Perfect Matte Lip Coat', '', 'Lip cream matte ringan, tidak bikin bibir kering.', 79000.00, 90, 'women', 'dearme-lip.jpg', 0, '2026-01-31 08:34:39'),
(49, 13, 'Pinkflash OhMyKiss Lip Matte', '', 'Lip matte sachet 15 ribuan, warna pigmented.', 15000.00, 200, 'women', 'pinkflash-lip.jpg', 0, '2026-01-31 08:34:39'),
(50, 13, 'Wardah Exclusive Matte Lip Cream', '', 'Lip cream halal dengan pilihan warna nude terbanyak.', 65000.00, 120, 'women', 'wardah-lip.jpg', 0, '2026-01-31 08:34:39'),
(51, 13, 'Barenbliss Peach Makes Perfect', '', 'Lip tint Korea wangi peach, packaging gemes.', 69000.00, 100, 'women', 'bnb-liptint.jpg', 0, '2026-01-31 08:34:39'),
(52, 14, 'Rose All Day Thunder Lash Mascara', '', 'Maskara volumizing & lengthening, lentik seharian.', 129000.00, 60, 'women', 'rad-mascara.jpg', 0, '2026-01-31 08:34:39'),
(53, 14, 'Viva Pensil Alis Legendaris', '', 'Pensil alis sejuta umat, murah meriah.', 35000.00, 600, 'women', 'viva-alis.jpg', 0, '2026-01-31 08:34:39'),
(54, 14, 'Just Miss Pensil Alis', '', 'Pensil alis ada sikatnya, harga cuma ceban.', 10000.00, 300, 'women', 'justmiss.jpg', 0, '2026-01-31 08:34:39'),
(55, 14, 'Focallure Staymax Mascara', '', 'Maskara murah meriah melentikkan bulu mata.', 35000.00, 150, 'women', 'focallure-mascara.jpg', 0, '2026-01-31 08:34:39'),
(56, 16, 'Scarlett Whitening Body Lotion Jolly', '', 'Lotion pencerah wangi YSL Black Opium.', 75000.00, 400, 'women', 'scarlett-jolly.jpg', 0, '2026-01-31 08:34:39'),
(57, 16, 'Herborist Minyak Zaitun 150ml', '', 'Minyak zaitun kaya vitamin E untuk pijat.', 32000.00, 150, 'women', 'herborist-oil.jpg', 0, '2026-01-31 08:34:39'),
(58, 16, 'Vaseline Gluta-Hya Serum Burst', '', 'Lotion serum canggih, mencerahkan seketika.', 55000.00, 250, 'women', 'vaseline-gluta.jpg', 0, '2026-01-31 08:34:39'),
(59, 16, 'Nivea Body Serum Extra White', '', 'Serum tubuh cepat meresap untuk kulit cerah.', 45000.00, 200, 'women', 'nivea-serum.jpg', 0, '2026-01-31 08:34:39'),
(60, 16, 'Bonavie Body Lotion Marie Antoinette', '', 'Lotion wangi mewah tahan lama.', 68000.00, 80, 'women', 'bonavie-lotion.jpg', 0, '2026-01-31 08:34:39'),
(61, 16, 'Marina UV White Hand & Body Lotion', '', 'Lotion pencerah ekonomis dengan UV.', 15000.00, 500, 'women', 'marina-uv.jpg', 0, '2026-01-31 08:34:39'),
(62, 16, 'Citra Pearly White UV', '', 'Lotion dengan bubuk mutiara Korea.', 25000.00, 300, 'women', 'citra-pearly.jpg', 0, '2026-01-31 08:34:39'),
(63, 16, 'Bio Oil Skincare Oil 60ml', '', 'Spesialis penghilang bekas luka dan stretch mark.', 130000.00, 50, 'women', 'bio-oil.jpg', 0, '2026-01-31 08:34:39'),
(64, 15, 'Scarlett Whitening Shower Scrub Pome', '', 'Sabun mandi scrub wangi pomegranate.', 75000.00, 200, 'women', 'scarlett-pome.jpg', 0, '2026-01-31 08:34:39'),
(65, 15, 'Grace and Glow Black Opium Body Wash', '', 'Sabun mandi wangi mewah dengan Niacinamide.', 64000.00, 100, 'women', 'grace-body.jpg', 0, '2026-01-31 08:34:39'),
(66, 15, 'Vitalis Body Wash Perfumed', '', 'Sabun mandi cair dengan wangi parfum.', 25000.00, 200, 'women', 'vitalis-wash.jpg', 0, '2026-01-31 08:34:39'),
(67, 15, 'Lifebuoy Sabun Cair Lemon Fresh', '', 'Sabun keluarga anti kuman wangi lemon.', 28000.00, 400, 'women', 'lifebuoy-lemon.jpg', 0, '2026-01-31 08:34:39'),
(68, 15, 'Lux Botanicals Body Wash', '', 'Sabun mandi wangi bunga mawar mewah.', 30000.00, 300, 'women', 'lux-body.jpg', 0, '2026-01-31 08:34:39'),
(69, 15, 'Dettol Original Body Wash', '', 'Sabun antiseptik perlindungan terpercaya.', 35000.00, 300, 'women', 'dettol-body.jpg', 0, '2026-01-31 08:34:39'),
(70, 15, 'Leivy Goat Milk Shower Cream', '', 'Sabun susu kambing literan bikin kulit halus.', 85000.00, 60, 'women', 'leivy-goat.jpg', 0, '2026-01-31 08:34:39'),
(71, 15, 'Kojie San Skin Lightening Soap', '', 'Sabun oranye viral ampuh memutihkan.', 35000.00, 200, 'women', 'kojiesan.jpg', 0, '2026-01-31 08:34:39'),
(72, 15, 'Shinzui Bar Soap Kirei', '', 'Sabun batang pencerah kulit wangi Jepang.', 5000.00, 600, 'women', 'shinzui-bar.jpg', 0, '2026-01-31 08:34:39'),
(73, 17, 'Shinzui Skin Lightening Body Scrub', '', 'Lulur mandi pencerah dengan Herba Matsu Oil.', 18000.00, 350, 'women', 'shinzui-scrub.jpg', 0, '2026-01-31 08:34:39'),
(74, 17, 'Purbasari Lulur Mandi Bengkoang', '', 'Lulur legendaris murah meriah angkat daki.', 12000.00, 400, 'women', 'purbasari.jpg', 0, '2026-01-31 08:34:39'),
(75, 18, 'Kelaya Hair Treatment Shampoo', '', 'Sampo penumbuh rambut rontok alami.', 115000.00, 60, 'women', 'kelaya-shampoo.jpg', 0, '2026-01-31 08:34:39'),
(76, 18, 'Lab On Hair Anti Hair Fall', '', 'Sampo khusus rambut rontok parah, wangi mewah.', 149000.00, 40, 'women', 'labonhair.jpg', 0, '2026-01-31 08:34:39'),
(77, 18, 'Sunsilk Black Shine Shampoo', '', 'Sampo sejuta umat untuk rambut hitam.', 25000.00, 500, 'women', 'sunsilk-black.jpg', 0, '2026-01-31 08:34:39'),
(78, 18, 'Pantene Anti Dandruff Shampoo', '', 'Sampo anti ketombe paling laris.', 28000.00, 500, 'women', 'pantene-dandruff.jpg', 0, '2026-01-31 08:34:39'),
(79, 18, 'Head & Shoulders Cool Menthol', '', 'Sampo anti ketombe dingin menyegarkan.', 30000.00, 450, 'women', 'hns-cool.jpg', 0, '2026-01-31 08:34:39'),
(80, 18, 'Erha Hairgrow Shampoo', '', 'Sampo klinik Erha untuk atasi kebotakan.', 150000.00, 30, 'women', 'erha-shampoo.jpg', 0, '2026-01-31 08:34:39'),
(81, 19, 'Makarizo Hair Energy Fibertheraphy', '', 'Creambath rumahan wangi kiwi/royal jelly.', 75000.00, 100, 'women', 'makarizo-cream.jpg', 0, '2026-01-31 08:34:39'),
(82, 19, 'Makarizo Vitacaps Hair Vitamin', '', 'Vitamin rambut kapsul mudah dibuka.', 15000.00, 300, 'women', 'makarizo-caps.jpg', 0, '2026-01-31 08:34:39'),
(83, 19, 'Loreal Paris Extraordinary Oil', '', 'Vitamin rambut sejuta umat, rambut berkilau.', 135000.00, 80, 'women', 'loreal-oil.jpg', 0, '2026-01-31 08:34:39'),
(84, 19, 'Ellips Hair Vitamin 50 butir', '', 'Vitamin rambut kapsul legendaris.', 85000.00, 150, 'women', 'ellips-jar.jpg', 0, '2026-01-31 08:34:39'),
(85, 19, 'Ree Derma Hot Oil Hair', '', 'Minyak rambut panas penumbuh rambut.', 100000.00, 50, 'women', 'reederma.jpg', 0, '2026-01-31 08:34:39'),
(86, 19, 'Mustika Ratu Minyak Cem-Ceman', '', 'Minyak rambut tradisional untuk rambut hitam.', 28000.00, 100, 'women', 'mustika-cemceman.jpg', 0, '2026-01-31 08:34:39'),
(87, 19, 'Garnier Hair Color Naturals', '', 'Pewarna rambut alami, menutup uban.', 55000.00, 200, 'women', 'garnier-color.jpg', 0, '2026-01-31 08:34:39'),
(88, 19, 'Natur Hair Tonic Ginseng', '', 'Tonic rambut alami kuatkan akar rambut.', 35000.00, 100, 'women', 'natur-tonic.jpg', 0, '2026-01-31 08:34:39'),
(89, 19, 'Miranda Hair Color Bleaching', '', 'Bleaching rambut murah meriah.', 15000.00, 200, 'women', 'miranda-bleach.jpg', 0, '2026-01-31 08:34:39'),
(90, 20, 'HMNS Perfume - Orgasm 100ml', '', 'Parfum lokal paling viral! Wangi floral vanilla.', 323000.00, 30, 'women', 'hmns-orgasm.jpg', 0, '2026-01-31 08:34:39'),
(91, 20, 'Saff & Co. Extrait de Parfum - SOTB', '', 'Parfum wangi tropis, vanilla, mandarin.', 189000.00, 50, 'women', 'saff-sotb.jpg', 0, '2026-01-31 08:34:39'),
(92, 20, 'Mykonos Vanilla Clouds', '', 'Wangi vanilla manis lembut seperti kue.', 109000.00, 70, 'women', 'mykonos-vanilla.jpg', 0, '2026-01-31 08:34:39'),
(93, 20, 'Miniso Perfume British Pear', '', 'Dupe parfum mahal Jo Malone, wangi segar.', 59000.00, 200, 'women', 'miniso-pear.jpg', 0, '2026-01-31 08:34:39'),
(94, 20, 'Lilith & Eve Daisy Eau De Parfum', '', 'Parfum glitter cantik wangi bunga daisy.', 78000.00, 90, 'women', 'lilith-daisy.jpg', 0, '2026-01-31 08:34:39'),
(95, 20, 'Carl & Claire Black Orchid', '', 'Parfum elegan wangi bunga anggrek hitam.', 279000.00, 25, 'women', 'carlclaire.jpg', 0, '2026-01-31 08:34:39'),
(96, 20, 'Evangeline Eau De Parfum Black Sakura', '', 'Parfum minimarket wangi enak dan murah.', 30000.00, 300, 'women', 'evangeline.jpg', 0, '2026-01-31 08:34:39'),
(97, 21, 'Kahf Revered Oud EDT 35ml', '', 'Parfum pria halal aroma Oud & Amber.', 70000.00, 150, 'women', 'kahf-oud.jpg', 0, '2026-01-31 08:34:39'),
(98, 21, 'Onix Senoparty', '', 'Parfum unisex wangi pesta jaksel.', 165000.00, 40, 'women', 'onix-senoparty.jpg', 0, '2026-01-31 08:34:39'),
(99, 21, 'Gatsby White Up Eau De Toilette', '', 'Parfum pria wangi bersih dan sporty.', 35000.00, 250, 'women', 'gatsby-white.jpg', 0, '2026-01-31 08:34:39');

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
-- Indexes for table `cart`
--
ALTER TABLE `cart`
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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

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
