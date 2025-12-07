-- Add is_hidden column to mon_an for soft-hide feature
ALTER TABLE `mon_an`
ADD COLUMN IF NOT EXISTS `is_hidden` TINYINT(1) NOT NULL DEFAULT 0 AFTER `trang_thai`;

-- Optional: mark some existing items as hidden for testing
-- UPDATE mon_an SET is_hidden = 1 WHERE id_mon IN (10,11);
