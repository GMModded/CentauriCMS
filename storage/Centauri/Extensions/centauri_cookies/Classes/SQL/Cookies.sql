CREATE TABLE IF NOT EXISTS cookies (
    uid int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) DEFAULT '' NOT NULL,
    description text,
    cookie int(11) UNSIGNED DEFAULT '0' NOT NULL,

    created_at int(11) DEFAULT '0' NOT NULL,
    modified_at int(11) DEFAULT '0' NOT NULL,
    deleted_at int(11) DEFAULT '0' NOT NULL,

    PRIMARY KEY (uid)
)
    COLLATE='utf8mb4_unicode_ci'
    ENGINE=InnoDB
    AUTO_INCREMENT=1
;
