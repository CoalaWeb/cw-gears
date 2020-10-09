CREATE TABLE IF NOT EXISTS `#__coalaweb_cipher`
(
    `id`         int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
    `extension`  varchar(50)      NOT NULL,
    `key`        varchar(255)     NOT NULL,
    `nonce`      varchar(255)     NOT NULL,
    `extra_info` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
) DEFAULT CHARSET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci;