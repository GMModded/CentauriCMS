ALTER TABLE elements (
    ADD header varchar(255) DEFAULT '' NOT NULL,
    ADD htag varchar(2) DEFAULT '' NOT NULL,

    ADD slideritems int(11) UNSIGNED DEFAULT '0' NOT NULL,
    ADD slideritems_buttons int(11) UNSIGNED DEFAULT '0' NOT NULL,
);
