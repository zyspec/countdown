# phpMyAdmin SQL Dump
# version 2.5.6-rc1
# http://www.phpmyadmin.net
#
# --------------------------------------------------------

#
# Table structure for table `countdown_events`
#

CREATE TABLE countdown_events (
  id          INT(11)     NOT NULL AUTO_INCREMENT,
  uid         INT(11)     NOT NULL DEFAULT '0',
  name        VARCHAR(50) NOT NULL DEFAULT '',
  description MEDIUMTEXT  NOT NULL,
  enddatetime INT         NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
)
  ENGINE = MyISAM;
