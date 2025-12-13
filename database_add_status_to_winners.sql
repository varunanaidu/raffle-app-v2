-- Script to add status column to winners table
-- Run this script to add the status column if migration is not used

-- Add status column to winners table
ALTER TABLE `winners` 
ADD COLUMN IF NOT EXISTS `status` VARCHAR(50) NOT NULL DEFAULT 'Pending' AFTER `prize_id`;

-- Update existing records to have 'Pending' status if they are NULL
UPDATE `winners` 
SET `status` = 'Pending' 
WHERE `status` IS NULL OR `status` = '';

