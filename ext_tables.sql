CREATE TABLE tx_owlcal_domain_model_event (
    title varchar(255) DEFAULT '' NOT NULL,
    place varchar(255) DEFAULT '' NOT NULL,
    recurring TINYINT(3) DEFAULT '0' NOT NULL,
    starttime DATETIME DEFAULT '0001-01-01 00:00:00' NOT NULL,
    endtime DATETIME DEFAULT '0001-01-01 00:00:00' NOT NULL,
    timezone varchar(255) DEFAULT '' NOT NULL,
    whole_day TINYINT(3) DEFAULT '0' NOT NULL,
    status int(11) unsigned DEFAULT '0' NOT NULL,
    www_address varchar(1048) DEFAULT '' NOT NULL,
    description text,
    calendar  int(11) unsigned DEFAULT '0' NOT NULL
);

CREATE TABLE tx_owlcal_domain_model_calendar (
    title varchar(255) DEFAULT '' NOT NULL,
    events int(11) unsigned DEFAULT '0' NOT NULL,
    owner int(11) unsigned DEFAULT '0' NOT NULL,
    color varchar(7) DEFAULT '#000000' NOT NULL
);

CREATE TABLE tx_owlcal_domain_model_status (
    title varchar(255) DEFAULT '' NOT NULL
);
