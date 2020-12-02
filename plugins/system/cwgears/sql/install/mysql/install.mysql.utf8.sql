CREATE TABLE IF NOT EXISTS `#__cwgears`
(
    `id`          int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
    `url`         varchar(255)     NOT NULL,
    `time`        int              NOT NULL,
    `facebook_js` int(11)          NOT NULL,
    `uikit`       int(11)          NOT NULL,
    `uikit_plus`  int(11)          NOT NULL,
    PRIMARY KEY (`id`)
) DEFAULT CHARSET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__cwgears_schedule`
(
    `id`   int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
    `time` int              NOT NULL,
    PRIMARY KEY (`id`)
) DEFAULT CHARSET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__coalaweb_common`
(
    `key`   varchar(190) NOT NULL COMMENT 'Primary Key',
    `value` longtext     NOT NULL,
    PRIMARY KEY (`key`)
) DEFAULT CHARSET = utf8mb4
  DEFAULT COLLATE = utf8mb4_unicode_ci;

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