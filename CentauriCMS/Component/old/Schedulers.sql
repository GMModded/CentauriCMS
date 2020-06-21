CREATE TABLE IF NOT EXISTS schedulers (
    uid int(11) NOT NULL AUTO_INCREMENT,
    pid int(11) unsigned DEFAULT '0' NOT NULL,
    lid int(11) unsigned DEFAULT '0' NOT NULL,

    created_at int(11) DEFAULT '0' NOT NULL,
    modified_at int(11) DEFAULT '0' NOT NULL,
    deleted_at int(11) DEFAULT '0' NOT NULL,

    name varchar(255) DEFAULT '' NOT NULL,
    namespace varchar(255) DEFAULT '' NOT NULL,
    state tinyint,
    last_runned varchar(255) DEFAULT '' NOT NULL,
    time varchar(255) DEFAULT '' NOT NULL,

    PRIMARY KEY (uid)
)
    COLLATE='utf8mb4_unicode_ci'
    ENGINE=InnoDB
    AUTO_INCREMENT=1
;
