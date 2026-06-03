CREATE DATABASE IF NOT EXISTS `news_db`;
USE `news_db`;

DROP TABLE IF EXISTS `berita`;
DROP TABLE IF EXISTS `kategori`;
DROP TABLE IF EXISTS `notes`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `role`;

CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(3100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `is_active` int(1) NOT NULL DEFAULT '0',
  `created_at` date NOT NULL,
  `updated_at` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `users_ibfk_1` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE berita (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kategori_id INT NOT NULL,
    judul VARCHAR(255) NOT NULL,
    isi TEXT NOT NULL,
    gambar VARCHAR(255) NULL,
    created_at DATE NOT NULL,
    updated_at DATE NOT NULL,
    FOREIGN KEY (kategori_id) REFERENCES kategori(id)
);

CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    judul VARCHAR(255) NOT NULL,
    isi TEXT NOT NULL,
    created_at DATE NOT NULL,
    updated_at DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO `role` (`id`, `role`) VALUES
(1, 'admin'),
(2, 'staff'),
(3, 'member');

INSERT INTO `users` (`id`, `nama`, `username`, `email`, `password`, `role_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', 'indra@bsi.ac.id', '$2y$10$WEDdl2bDkHjaPsBc2irPYuu0QKCGZrq7d2l2Ge0ovYTalKUHQ7B2O', 1, 1, '2024-10-09', '2024-10-09'),
(2, 'Zhafran', 'zhafran', 'zhafran@example.com', '$2y$10$VdMfXeS0C7CmKKQaLwJ4u.6hQasRWYsNKzvLRCrarwF9uNLwcqfzi', 3, 1, '2026-04-29', '2026-04-29');

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(1, 'Teknologi'),
(2, 'Ekonomi'),
(3, 'Olahraga'),
(4, 'Kriminal'),
(5, 'Keagamaan'),
(6, 'Kebudayaan'),
(7, 'Elektronik'),
(8, 'Politik'),
(9, 'Pendidikan'),
(10, 'Hukum');

INSERT INTO `berita` (`id`, `kategori_id`, `judul`, `isi`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 1, 'Update Aplikasi Baru', 'Aplikasi versi terbaru sudah dirilis.', 'gambar1.jpg', '2026-05-20', '2026-05-20'),
(2, 2, 'Ekonomi Indonesia Merosot', 'Nilai ruliah sudah menyentuh Rp. 17.600.', 'gambar-uang.jpg', '2026-05-20', '2026-05-20'),
(3, 3, 'Belajar Lari Sehat', 'Saya sekarang mulai belajar berlari sehat 2 sampai 5 km sehari.', 'gambar-lari.jpg', '2026-05-20', '2026-05-20');