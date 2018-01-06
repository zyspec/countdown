# phpMyAdmin SQL Dump
# version 2.5.6-rc1
# http://www.phpmyadmin.net
#
# --------------------------------------------------------

#
# Table structure for table `countdown_events`
#

CREATE TABLE countdown_events (
    id int(11) NOT NULL auto_increment,
    uid int(11) NOT NULL default '0',
    name varchar(50) NOT NULL default '',
    description mediumtext NOT NULL,
    enddatetime int NOT NULL default '0',
    PRIMARY KEY (id)
) ENGINE=MyISAM;