CREATE TABLE IF NOT EXISTS pages (
    uid int(11) NOT NULL AUTO_INCREMENT,
    pid int(11) unsigned DEFAULT '0' NOT NULL,
    lid int(11) unsigned DEFAULT '0' NOT NULL,

    created_at int(11) DEFAULT '0' NOT NULL,
    modified_at int(11) DEFAULT '0' NOT NULL,
    deleted_at int(11) DEFAULT '0' NOT NULL,

    hidden tinyint unsigned DEFAULT '0' NOT NULL,
    hidden_inpagetree tinyint unsigned DEFAULT '0' NOT NULL,

    backend_layout varchar(255) DEFAULT '' NOT NULL,
    page_type varchar(255) DEFAULT '' NOT NULL,

    seo_keywords varchar(255) DEFAULT '' NOT NULL,
    seo_description varchar(255) DEFAULT '' NOT NULL,
    seo_robots_indexpage tinyint,
    seo_robots_followpage tinyint,

    storage_id int(11) unsigned DEFAULT '0' NOT NULL,
    domain_id int(11) unsigned DEFAULT '0' NOT NULL,

    PRIMARY KEY (uid)
)
    COLLATE='utf8mb4_unicode_ci'
    ENGINE=InnoDB
    AUTO_INCREMENT=1
;
