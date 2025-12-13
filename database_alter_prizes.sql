-- Script untuk mengupdate tabel prizes agar sesuai dengan aplikasi
-- Jalankan script ini jika tabel prizes sudah ada

-- Tambahkan kolom name jika belum ada
ALTER TABLE `prizes` 
ADD COLUMN IF NOT EXISTS `name` VARCHAR(255) NULL AFTER `id`;

-- Tambahkan kolom image jika belum ada
ALTER TABLE `prizes` 
ADD COLUMN IF NOT EXISTS `image` VARCHAR(500) NULL AFTER `prize_name`;

-- Tambahkan kolom raffled jika belum ada
ALTER TABLE `prizes` 
ADD COLUMN IF NOT EXISTS `raffled` TINYINT(1) DEFAULT 0 AFTER `stock`;

-- Tambahkan kolom is_grand_prize jika belum ada
ALTER TABLE `prizes` 
ADD COLUMN IF NOT EXISTS `is_grand_prize` TINYINT(1) DEFAULT 0 AFTER `raffled`;

-- Tambahkan kolom is_grandprize jika belum ada
ALTER TABLE `prizes` 
ADD COLUMN IF NOT EXISTS `is_grandprize` TINYINT(1) DEFAULT 0 AFTER `is_grand_prize`;

-- Update data existing: copy prize_name ke name jika name kosong
UPDATE `prizes` 
SET `name` = `prize_name` 
WHERE (`name` IS NULL OR `name` = '') AND `prize_name` IS NOT NULL;

-- Update data existing: copy images ke image jika image kosong
UPDATE `prizes` 
SET `image` = `images` 
WHERE (`image` IS NULL OR `image` = '') AND `images` IS NOT NULL;

