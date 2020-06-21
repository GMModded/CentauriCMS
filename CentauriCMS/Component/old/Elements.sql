CREATE TABLE IF NOT EXISTS elements (
    uid int(11) NOT NULL AUTO_INCREMENT,
    pid int(11) unsigned DEFAULT '0' NOT NULL,
    lid int(11) unsigned DEFAULT '0' NOT NULL,

    created_at int(11) DEFAULT '0' NOT NULL,
    modified_at int(11) DEFAULT '0' NOT NULL,
    deleted_at int(11) DEFAULT '0' NOT NULL,

    hidden tinyint unsigned DEFAULT '0' NOT NULL,
    sorting int(11) unsigned DEFAULT '0' NOT NULL,
    ctype varchar(255) DEFAULT '' NOT NULL,
    plugin varchar(255) DEFAULT '' NOT NULL,

    rowPos int(11) unsigned DEFAULT '0' NOT NULL,
    colPos int(11) unsigned DEFAULT '0' NOT NULL,

    file int(11) unsigned DEFAULT '0' NOT NULL,

    grid varchar(50),
    grids_parent int(11) unsigned DEFAULT '0' NOT NULL,
    grids_sorting_rowpos int(11) unsigned DEFAULT '0' NOT NULL,
    grids_sorting_colpos int(11) unsigned DEFAULT '0' NOT NULL,
    grid_config varchar(255),

    PRIMARY KEY (uid)
)
    COLLATE='utf8mb4_unicode_ci'
    ENGINE=InnoDB
    AUTO_INCREMENT=1
;
