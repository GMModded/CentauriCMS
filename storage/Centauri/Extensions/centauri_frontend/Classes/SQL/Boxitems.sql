CREATE TABLE IF NOT EXISTS centauri_frontend_boxitems (
    uid int(11) NOT NULL AUTO_INCREMENT,

    created_at int(11) DEFAULT '0' NOT NULL,
    modified_at int(11) DEFAULT '0' NOT NULL,
    deleted_at int(11) DEFAULT '0' NOT NULL,

    icon int(11) UNSIGNED DEFAULT '0' NOT NULL,
    link varchar(255) DEFAULT '' NOT NULL,
    link_label varchar(255) DEFAULT '' NOT NULL,
    header varchar(255) DEFAULT '' NOT NULL,
    description text,
    col_desktop varchar(2) DEFAULT '3' NOT NULL,
    bgcolor_start varchar(50) DEFAULT '' NOT NULL,
    bgcolor_end varchar(50) DEFAULT '' NOT NULL,

    PRIMARY KEY (uid)
)
    COLLATE='utf8mb4_unicode_ci'
    ENGINE=InnoDB
    AUTO_INCREMENT=1
;
