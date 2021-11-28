CREATE TABLE tx_owlcal_domain_model_event (
    title varchar(255) DEFAULT '' NOT NULL,
    place varchar(255) DEFAULT '' NOT NULL,
    recurring TINYINT(3) DEFAULT '0' NOT NULL,
    recurrence_timing int(11) unsigned DEFAULT '0' NOT NULL,
    recurring_times int(11) DEFAULT '0' NOT NULL,
    recurring_until DATETIME DEFAULT NULL,
    starttime DATETIME DEFAULT '0001-01-01 00:00:00' NOT NULL,
    endtime DATETIME DEFAULT NULL,
    timezone varchar(255) DEFAULT '' NOT NULL,
    whole_day TINYINT(3) DEFAULT '0' NOT NULL,
    status varchar(255) DEFAULT 'none' NOT NULL,
    www_address varchar(1048) DEFAULT '' NOT NULL,
    description text,
    icon varchar(255) DEFAULT '' NOT NULL,
    calendar int(11) unsigned DEFAULT '0' NOT NULL,
    attendees int(11) unsigned DEFAULT '0' NOT NULL,
    reminders int(11) unsigned DEFAULT '0' NOT NULL,
    files int(11) unsigned DEFAULT '0' NOT NULL,
);

CREATE TABLE tx_owlcal_domain_model_calendar (
    title varchar(255) DEFAULT '' NOT NULL,
    events int(11) unsigned DEFAULT '0' NOT NULL,
    owner int(11) unsigned DEFAULT '0' NOT NULL,
    color varchar(7) DEFAULT '#000000' NOT NULL
);

CREATE TABLE tx_owlcal_domain_model_attendee (
    name varchar(255) DEFAULT '' NOT NULL,
    email varchar(255) DEFAULT '' NOT NULL,
    participation varchar(255) DEFAULT '' NOT NULL,
    role varchar(255) DEFAULT '' NOT NULL,
    event int(11) unsigned DEFAULT '0' NOT NULL
);

CREATE TABLE tx_owlcal_domain_model_reminder (
    type varchar(255) DEFAULT '' NOT NULL,
    timing int(11) unsigned DEFAULT '0' NOT NULL,
    recurring TINYINT(3) DEFAULT '0' NOT NULL,
    recurrence_times int(11) DEFAULT '0' NOT NULL,
    recurrence_timing int(11) unsigned DEFAULT '0' NOT NULL,
    remindAt varchar(255) DEFAULT '' NOT NULL,
    event int(11) unsigned DEFAULT '0' NOT NULL
);

CREATE TABLE tx_owlcal_domain_model_timing (
    time int(11) unsigned DEFAULT '0' NOT NULL,
    scale varchar(255) DEFAULT '' NOT NULL,
    foreign_uid int(11) unsigned DEFAULT '0' NOT NULL
    foreign_table varchar(255) DEFAULT '' NOT NULL
);
