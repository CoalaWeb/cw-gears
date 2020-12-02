CREATE TABLE IF NOT EXISTS `#__coalaweb_cipher`
(
    `id`         int(11) UNSIGNED                        NOT NULL COMMENT 'Primary Key',
    `extension`  varchar(50) COLLATE utf8mb4_unicode_ci  NOT NULL,
    `everyone`   varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `shh`        varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `nonce`      varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `extra_info` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`id`)
) DEFAULT CHARSET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci;