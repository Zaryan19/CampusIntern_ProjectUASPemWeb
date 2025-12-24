-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2025 at 09:22 AM
-- Server version: 9.2.0
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uaswebbb`
--

-- --------------------------------------------------------

--
-- Table structure for table `lowongan_magang`
--

CREATE TABLE `lowongan_magang` (
  `id` int NOT NULL,
  `company_id` int NOT NULL,
  `perusahaan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `posisi` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ringkasan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `kualifikasi_jurusan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `durasi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `lokasi_penempatan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `deskripsi_pekerjaan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `requirements` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `tanggal_mulai` datetime DEFAULT NULL,
  `tanggal_selesai` datetime DEFAULT NULL,
  `website` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `instagram_link` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `logo_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `lowongan_magang`
--

INSERT INTO `lowongan_magang` (`id`, `company_id`, `perusahaan`, `posisi`, `ringkasan`, `kualifikasi_jurusan`, `durasi`, `lokasi_penempatan`, `deskripsi_pekerjaan`, `requirements`, `tanggal_mulai`, `tanggal_selesai`, `website`, `instagram_link`, `logo_url`, `created_at`) VALUES
(6, 6, 'PT Samudra Niaga Digital', 'Marketing Communication', 'Kesempatan berharga untuk terlibat langsung dalam merancang, mengimplementasikan, dan mengevaluasi strategi komunikasi pemasaran digital untuk meningkatkan brand awareness dan engagement pengguna platform e-commerce.', 'Ilmu Komunikasi, Manajemen Pemasaran, Hubungan Masyarakat', '6 Bulan', 'Surabaya', 'Peserta magang akan membantu tim MarCom dalam penyusunan konten promosi digital, termasuk penulisan copywriting untuk media sosial, email marketing, dan banner aplikasi. Tugas mencakup koordinasi dengan tim kreatif, memantau kinerja kampanye komunikasi, menganalisis data engagement, serta melakukan riset tren pasar untuk mendukung strategi pemasaran digital perusahaan.', 'Mahasiswa aktif semester akhir atau fresh graduate dari jurusan yang relevan.\r\nMemiliki pemahaman dasar tentang prinsip-prinsip pemasaran digital dan media sosial.\r\nMampu menulis copywriting dengan baik, kreatif, dan persuasif (Bahasa Indonesia dan/atau Inggris).\r\nFamiliar dengan tools analisis media sosial (misalnya: Google Analytics, Instagram Insight, dsb.) menjadi nilai tambah.\r\nMemiliki inisiatif tinggi, mampu bekerja dalam tim, dan dapat mengikuti deadline yang ketat.\r\nDomisili di Surabaya dan siap bekerja secara Work From Office di Surabaya.', '2028-10-24 00:00:00', '2028-11-24 23:59:59', 'https://www.linkedin.com/company/samudera-digital/about/', 'https://www.instagram.com/samudra.digital/?utm_source=ig_web_button_share_sheet', 'uploads/logos/6_1765218480.jpg', '2025-12-09 01:28:00'),
(7, 7, 'PT Energi Nusantara Hijau', 'Financial Planning & Analysis', 'Program magang yang menawarkan pengalaman langsung dalam proses perencanaan anggaran, analisis kinerja keuangan, dan dukungan pengambilan keputusan investasi di sektor energi terbarukan yang sedang berkembang pesat.', 'Akuntansi, Manajemen Keuangan, Ekonomi Pembangunan, Teknik Industri, Statistika', '6 Bulan', 'Tegal', 'Peserta magang akan membantu tim FP&A dalam penyusunan laporan keuangan rutin dan proyeksi anggaran untuk kuartal mendatang. Tugas utama meliputi pengumpulan dan validasi data finansial, melakukan analisis varians antara anggaran dan realisasi, serta membantu dalam pemodelan keuangan (financial modelling) untuk proyek-proyek investasi baru di bidang energi hijau. Selain itu, peserta akan membantu tim dalam menyiapkan materi presentasi kinerja keuangan untuk manajemen.', 'Mahasiswa aktif semester akhir atau fresh graduate dari jurusan yang relevan.\r\nMemiliki pemahaman kuat mengenai prinsip-prinsip akuntansi dan analisis keuangan.\r\nMahir dalam penggunaan Microsoft Excel (VLOOKUP, Pivot Table, fungsi finansial).\r\nMampu bekerja dengan data yang detail dan memiliki kemampuan pemecahan masalah yang baik.\r\nMemiliki kemampuan komunikasi yang baik untuk menyajikan laporan keuangan.', '2028-10-24 00:00:00', '2028-11-24 23:59:59', 'https://nei.co.id/', 'https://www.instagram.com/nusantaraenergy_id?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw%3D%3D', 'uploads/logos/7_1765253560.png', '2025-12-09 11:12:40'),
(8, 8, 'PT. Pertamina', 'Petroleum Engineering', 'Program magang eksklusif untuk memahami dan terlibat langsung dalam analisis data reservoar, optimasi produksi sumur, serta pemantauan kinerja lapangan migas di salah satu wilayah kerja utama Pertamina.', 'Teknik Perminyakan, Teknik Geologi, Teknik Kimia, Teknik Mesin.', '6 Bulan', 'Jakarta', 'Program magang eksklusif untuk memahami dan terlibat langsung dalam analisis data reservoar, optimasi produksi sumur, serta pemantauan kinerja lapangan migas di salah satu wilayah kerja utama Pertamina.', 'Lulusan D4/S1 atau mahasiswa aktif tingkat akhir dari jurusan Teknik Perminyakan atau bidang terkait.\r\nIPK minimal 3.00 (skala 4.00) dan berasal dari perguruan tinggi dengan akreditasi minimal B/Baik Sekali.\r\nMemiliki pemahaman dasar tentang reservoar, teknik produksi, dan pengolahan data sumur (pressure/flow data).\r\nMahir dalam pengolahan data menggunakan Microsoft Excel; penguasaan software simulasi migas (Petroleum Software) menjadi nilai tambah.\r\nMampu bekerja mandiri maupun dalam tim dengan komitmen tinggi, serta siap ditempatkan di lokasi site (jika diperlukan untuk kunjungan).', '2027-02-09 00:00:00', '2027-03-09 23:59:59', 'https://pertamina.com/', 'https://www.instagram.com/pertamina?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw%3D%3D', 'uploads/logos/8_1765253736.png', '2025-12-09 11:15:36'),
(9, 9, 'PT. Perusahaan Listrik Negara', 'Pembangkitan dan Transmisi', 'Program magang di perusahaan energi terbesar di Indonesia, memberikan pengalaman praktis dalam operasi, pemeliharaan, dan pengawasan sistem pembangkitan dan jaringan transmisi listrik.', 'Teknik Elektro, Teknik Tenaga Listrik, Teknik Mesin, Teknik Fisika, Teknik Industri.', '6 Bulan', 'Surabaya', 'Peserta magang akan membantu tim Engineer dalam pemantauan operasional harian di ruang kontrol dan area Gardu Induk. Tugas mencakup asistensi dalam inspeksi rutin peralatan utama (seperti turbin, generator, dan transformator), membantu menganalisis data beban dan gangguan pada sistem transmisi, serta mendokumentasikan prosedur Standard Operating Procedure (SOP) dan laporan kerusakan mesin. Selain itu, peserta akan terlibat dalam kegiatan predictive maintenance untuk memastikan keandalan pasokan listrik.', 'Lulusan D3/D4/S1 atau mahasiswa aktif tingkat akhir dari jurusan Teknik Elektro (Arus Kuat) atau bidang terkait.\r\nMemiliki pemahaman dasar tentang rangkaian listrik, mesin listrik, dan sistem proteksi tenaga listrik.\r\nMampu membaca dan menafsirkan single-line diagram (SLD) dan skema kontrol.\r\nBersedia ditempatkan di lokasi power plant (Pembangkit Listrik) atau Gardu Induk dan mengikuti protokol keselamatan kerja (K3).\r\nMemiliki kemampuan analisis masalah teknis yang baik dan siap belajar dalam lingkungan operasional yang ketat.', '2025-12-09 00:00:00', '2026-01-09 23:59:59', 'https://web.pln.co.id/', 'https://www.instagram.com/pln_id?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==', 'uploads/logos/9_1765254352.png', '2025-12-09 11:25:52'),
(10, 10, 'PT. Bank Mandiri', 'Digital Banking Analyst', 'Program magang untuk menganalisis tren penggunaan produk digital banking (seperti Livin\' by Mandiri), memberikan insight yang berharga, dan mendukung pengembangan fitur baru untuk meningkatkan pengalaman pengguna (UX) dan pertumbuhan bisnis.', 'Sistem Informasi, Teknik Informatika, Ilmu Komputer, Statistika, Manajemen Bisnis', '6 Bulan', 'Jakarta', 'Peserta magang akan membantu tim Digital Product dalam melacak dan menganalisis metrik utama (Key Performance Indicators - KPI) dari aplikasi mobile banking. Tugas mencakup penarikan dan pembersihan data transaksi harian/mingguan, membuat dashboard sederhana menggunakan Business Intelligence Tools (seperti Power BI/Tableau), serta menyusun laporan analisis tentang perilaku pengguna untuk mengidentifikasi bottleneck atau peluang pengembangan fitur. Peserta akan berkolaborasi erat dengan Product Manager dan UX Researcher untuk mendukung inisiatif digital bank.', 'Lulusan S1 atau mahasiswa aktif semester akhir dari jurusan yang relevan (terutama di bidang IT dan Data).\r\nIPK minimal 3.00 (skala 4.00).\r\nMemiliki pemahaman dasar tentang metodologi Agile atau Scrum dalam pengembangan produk digital.\r\nMahir dalam pengolahan data menggunakan Excel dan familiar dengan konsep dasar SQL.\r\nKetertarikan yang kuat pada tren teknologi finansial (FinTech) dan aplikasi mobile banking.\r\nMampu berpikir analitis, teliti, dan komunikatif dalam menyampaikan temuan berbasis data.', '2025-10-09 00:00:00', '2025-11-09 23:59:59', 'https://www.bankmandiri.co.id/', 'https://www.instagram.com/bankmandiri?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==', 'uploads/logos/10_1765254485.png', '2025-12-09 11:28:05'),
(11, 11, 'PT. Telkom Indonesia', 'UX Researcher', 'Program magang yang memberikan pengalaman langsung dalam merencanakan, melaksanakan, dan menganalisis riset pengguna (User Experience) untuk meningkatkan kualitas dan daya saing produk digital Telkom Group.', 'Psikologi, Desain Komunikasi Visual (DKV), Teknik Informatika, Ilmu Komunikasi, Statistika.', '6 Bulan', 'Banjarmasin', 'Selama magang, peserta akan membantu dalam penerapan dan pengawasan prosedur keselamatan kerja di lingkungan perusahaan. Kegiatan meliputi pemantauan area kerja, pengecekan alat pelindung diri (APD), pencatatan insiden, ikut serta dalam pelatihan K3, serta membantu pembuatan laporan dan dokumentasi keselamatan kerja.', 'Lulusan S1 atau mahasiswa aktif semester akhir (min. semester 6) dari jurusan yang relevan.\r\nMemiliki pemahaman yang kuat mengenai metodologi riset pengguna (e.g., in-depth interview, usability testing, survey, A/B testing).\r\nFamiliar dalam menggunakan tools riset dan desain seperti Figma, Miro, atau survey tools (Google Forms/Qualtrics).\r\nMampu menganalisis data kualitatif dan kuantitatif untuk diubah menjadi actionable insight.\r\nMemiliki portofolio sederhana terkait proyek desain atau riset pengguna (nilai tambah).\r\nBersedia ditempatkan di Bandung atau Jakarta dan berkomitmen penuh waktu.', '2025-04-09 00:00:00', '2025-05-09 23:59:59', 'https://www.telkom.co.id/sites', 'https://www.instagram.com/telkomindonesia?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==', 'uploads/logos/11_1765254928.png', '2025-12-09 11:35:28'),
(12, 12, 'PT Freeport', 'Junior Mining Engineer Intern', 'Magang 6 bulan sebagai Junior Mining Engineer Intern di jantung operasi pertambangan PTFI, Tembagapura. Peluang emas mendalami perencanaan tambang bawah tanah dan terbuka, optimasi operasional, serta standar K3 ketat. Wajib Mahasiswa/Fresh Grad Teknik Per', 'Teknik Pertambangan, Teknik Geologi, Teknik Sipil, Teknik Mesin, Teknik Elektro, K3 (Keselamatan dan Kesehatan Kerja)', '6 Bulan', 'Papua Tengah', 'Program magang enam bulan ini di Tembagapura, Papua Tengah, menawarkan pengalaman langsung dalam perencanaan dan optimasi operasional tambang skala dunia. Intern akan bertanggung jawab membantu penyusunan jadwal penambangan, menganalisis data produksi untuk efisiensi, dan menyusun laporan kemajuan. Tugas inti lainnya meliputi partisipasi aktif dalam penerapan prosedur keselamatan (K3) yang ketat di lapangan dan mendukung insinyur senior dalam proyek-proyek teknis (seperti studi ventilasi/geoteknik).', 'Mahasiswa tingkat akhir (semester 7 atau 8) atau Fresh Graduate (maksimal 1 tahun lulus) dari jurusan terkait.\r\nMemiliki IPK minimal 3.00 dari skala 4.00.\r\nWajib memiliki pemahaman dasar yang kuat tentang prinsip-prinsip pertambangan, geomekanika, atau mekanika tanah.\r\nBersedia ditempatkan di Tembagapura, Papua Tengah, dan mengikuti semua peraturan dan jadwal kerja di area terpencil.\r\nMemiliki kemampuan analisis yang baik dan mahir dalam penggunaan Microsoft Excel (atau software perencanaan tambang dasar seperti AutoCAD/Surpac, jika ada).\r\nSehat jasmani dan rohani (akan menjalani pemeriksaan kesehatan ketat sebelum diterima).\r\nDisiplin, memiliki inisiatif tinggi, dan berkomitmen kuat terhadap Keselamatan dan Kualitas.', '2025-11-09 00:00:00', '2025-12-09 23:59:59', 'https://ptfi.co.id/en', 'https://www.instagram.com/freeportindonesia/', 'uploads/logos/12_1765255436.png', '2025-12-09 11:43:56');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftar`
--

CREATE TABLE `pendaftar` (
  `id` int NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `nomor_hp` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `pendidikan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `instansi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `prodi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `jurusan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `semester` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `ipk` decimal(3,2) DEFAULT NULL,
  `jabatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `alasan_magang` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `sumber_info` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `cv_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `portofolio_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `user_id` int NOT NULL,
  `NIK` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pendaftar`
--

INSERT INTO `pendaftar` (`id`, `nama`, `email`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `nomor_hp`, `pendidikan`, `instansi`, `prodi`, `jurusan`, `semester`, `ipk`, `jabatan`, `alasan_magang`, `sumber_info`, `cv_path`, `portofolio_path`, `created_at`, `updated_at`, `user_id`, `NIK`) VALUES
(9, 'josep', 'aboga@gmail.com', '2025-12-03', 'lakilaki', 'kamjet', '085746938810', 'SD', 's', 'd', 'f', '3', 4.00, 's', 'd', 'Media Partner', 'uploads/CV_14_1766243135.pdf', 'uploads/PORT_14_1766243135.pdf', '2025-12-20 22:05:35', NULL, 14, '1234567891234567');

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `user_id` int NOT NULL,
  `lowongan_id` int NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `tanggal_daftar` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pendaftaran`
--

INSERT INTO `pendaftaran` (`user_id`, `lowongan_id`, `status`, `tanggal_daftar`) VALUES
(14, 11, 'Pending', '2025-12-20 22:05:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `role` varchar(50) NOT NULL,
  `status` enum('active','banned') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `role`, `status`) VALUES
(4, 'mana', 'mana@gmail.com', '$2y$10$eOWe/i/alNd.vkm/YQsWTekwrmRNO.7jW1Y1EgNiVJ/ATUHIrK/t.', '2025-12-08 21:24:46', 'user', 'active'),
(6, 'PT Samudra Niaga Digital', 'samudradigital@gmail.com', '$2y$10$erREIaPtcStHO93WIhe5GuOBYScMZR.f8XU9RYZ5crC3Cg5Bc9/qm', '2025-12-09 01:25:08', 'company', 'active'),
(7, 'PT Energi Nusantara Hijau', 'energinusantara@gmail.com', '$2y$10$0VHRB96ODHz1U9DVAaBP7.VVeW.do.GF7Qs5lKXIp8PDJYmaS5AgO', '2025-12-09 11:10:41', 'company', 'active'),
(8, 'PT. Pertamina', 'pertamina@gmail.com', '$2y$10$ItsRcZ..Y7P4snrPKmeMEubUEBw1xKZLSMgL8K82eXSeKkb3xdGCO', '2025-12-09 11:13:46', 'company', 'active'),
(9, 'PT. Perusahaan Listrik Negara', 'pln@gmail.com', '$2y$10$5Il/yB5c0vr1lhKeofsMb.uO9tf4I4XiB.609ko4uJKDwb5Ad8G1u', '2025-12-09 11:16:32', 'company', 'active'),
(10, 'PT. Bank Mandiri', 'mandiri@gmail.com', '$2y$10$JJ.eEMay31FDi0F.LRvTreSxvaFwDh6hH9Ftn4mROsUt28lbLFzK6', '2025-12-09 11:26:37', 'company', 'active'),
(11, 'PT. Telkom Indonesia', 'telkom@gmail.com', '$2y$10$dH2KVLtA35NR4lsFvliaQuVMwrrjyspJs.eW3lFNyg1jrfdlJ/z7i', '2025-12-09 11:29:28', 'company', 'active'),
(12, 'PT Freeport', 'freeport@gmail.com', '$2y$10$AgYxRaoQHik6flsbh.fu8.tNgn1QccS.xLO9UXcCEtxRgfDctI1Rq', '2025-12-09 11:37:41', 'company', 'active'),
(13, 'Super Admin', 'super@admin.com', '$2y$10$rB8UUOAhNC3H/dHvHLd.du3ZLlHY.mMmhWgz8njSxOzNeNrrxj4WC', '2025-12-20 17:06:31', 'admin', 'active'),
(14, 'josep', 'josep@gmail.com', '$2y$10$yFFvGbsVWmlS1r7IUQ5Moel95FHDCe50JdTAennwkrl7z3qW5vkC2', '2025-12-20 22:03:40', 'user', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lowongan_magang`
--
ALTER TABLE `lowongan_magang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `lowongan_id` (`lowongan_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lowongan_magang`
--
ALTER TABLE `lowongan_magang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pendaftar`
--
ALTER TABLE `pendaftar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lowongan_magang`
--
ALTER TABLE `lowongan_magang`
  ADD CONSTRAINT `lowongan_magang_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `pendaftaran_ibfk_2` FOREIGN KEY (`lowongan_id`) REFERENCES `lowongan_magang` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
