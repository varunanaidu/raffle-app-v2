-- Script untuk mengupdate tabel registran dan winners agar sesuai dengan aplikasi
-- Jalankan script ini jika tabel sudah ada

-- ============================================
-- ALTER TABLE REGISTRAN
-- ============================================

-- Tambahkan kolom email jika belum ada
ALTER TABLE `registran` 
ADD COLUMN IF NOT EXISTS `email` VARCHAR(255) NULL AFTER `name`;

-- Tambahkan kolom company jika belum ada
ALTER TABLE `registran` 
ADD COLUMN IF NOT EXISTS `company` VARCHAR(255) NULL AFTER `phone_number`;

-- Tambahkan kolom inputed_time jika belum ada
ALTER TABLE `registran` 
ADD COLUMN IF NOT EXISTS `inputed_time` VARCHAR(255) NULL AFTER `bisnis_unit`;

-- Ubah bisnis_unit menjadi nullable
ALTER TABLE `registran` 
MODIFY `bisnis_unit` VARCHAR(100) NULL;

-- Tambahkan index untuk email
ALTER TABLE `registran` 
ADD INDEX IF NOT EXISTS `email` (`email`);

-- Update data existing: copy bisnis_unit ke company jika company kosong
UPDATE `registran` 
SET `company` = `bisnis_unit` 
WHERE (`company` IS NULL OR `company` = '') AND `bisnis_unit` IS NOT NULL;

-- ============================================
-- ALTER TABLE WINNERS
-- ============================================

-- Hapus tabel winner lama jika ada
DROP TABLE IF EXISTS `winner`;

-- Buat tabel winners jika belum ada
CREATE TABLE IF NOT EXISTS `winners` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `registrant_id` INT(11) UNSIGNED NOT NULL,
  `prize_id` INT(11) UNSIGNED NOT NULL,
  `created_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  KEY `registrant_id` (`registrant_id`),
  KEY `prize_id` (`prize_id`),
  CONSTRAINT `fk_winners_registrant` FOREIGN KEY (`registrant_id`) REFERENCES `registran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_winners_prize` FOREIGN KEY (`prize_id`) REFERENCES `prizes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Jika tabel winners sudah ada dengan struktur lama, tambahkan kolom baru
ALTER TABLE `winners` 
ADD COLUMN IF NOT EXISTS `registrant_id` INT(11) UNSIGNED NULL AFTER `id`;

ALTER TABLE `winners` 
ADD COLUMN IF NOT EXISTS `prize_id` INT(11) UNSIGNED NULL AFTER `registrant_id`;

-- Hapus kolom lama jika ada
ALTER TABLE `winners` 
DROP COLUMN IF EXISTS `name`,
DROP COLUMN IF EXISTS `bisnis_unit`,
DROP COLUMN IF EXISTS `handphone`,
DROP COLUMN IF EXISTS `prize_name`,
DROP COLUMN IF EXISTS `updated_at`;

