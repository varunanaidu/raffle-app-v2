-- Database Schema untuk Raffle App
-- Jalankan query ini untuk membuat tabel-tabel yang diperlukan

-- Tabel Prizes
CREATE TABLE IF NOT EXISTS `prizes` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `prize_name` VARCHAR(255) NULL,
  `image` VARCHAR(500) NULL,
  `images` VARCHAR(500) NULL,
  `stock` INT(11) DEFAULT 0,
  `raffled` TINYINT(1) DEFAULT 0,
  `is_grand_prize` TINYINT(1) DEFAULT 0,
  `is_grandprize` TINYINT(1) DEFAULT 0,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabel Registran
CREATE TABLE IF NOT EXISTS `registran` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NULL,
  `phone_number` VARCHAR(20) NOT NULL,
  `company` VARCHAR(255) NULL,
  `bisnis_unit` VARCHAR(100) NULL,
  `inputed_time` VARCHAR(255) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabel Winners
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

