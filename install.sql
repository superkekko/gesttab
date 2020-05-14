CREATE TABLE changelog (
  updated timestamp NULL DEFAULT NULL,
  user varchar(255) DEFAULT NULL,
  host varchar(255) DEFAULT NULL,
  operation varchar(255) DEFAULT NULL,
  tab varchar(255) DEFAULT NULL,
  rowkey varchar(255) DEFAULT NULL,
  col varchar(255) DEFAULT NULL,
  oldval blob,
  newval blob
);


CREATE TABLE demo (
	codice INT(19) NOT NULL AUTO_INCREMENT,
	variabile1 VARCHAR(4) NULL DEFAULT NULL,
	variabile2 INT(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (codice)
);


CREATE TABLE pages (
  page_id int(19) unsigned NOT NULL AUTO_INCREMENT,
  page_name varchar(50) NOT NULL DEFAULT '',
  page_ref varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (page_id)
);


INSERT INTO pages (page_id, page_name, page_ref)
VALUES
	(1,'demo','demo.php');

CREATE TABLE user (
  usr_id varchar(20) NOT NULL,
  email varchar(100) NOT NULL,
  passwd varchar(128) NOT NULL,
  pages_id varchar(100) NOT NULL,
  tms_upd timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  admin varchar(1) NOT NULL,
  valid varchar(1) NOT NULL,
  csv_export varchar(1) NOT NULL DEFAULT '',
  PRIMARY KEY (usr_id));

CREATE TABLE upload (
	id INT(10) NOT NULL AUTO_INCREMENT,
	file VARCHAR(500) NOT NULL,
	type VARCHAR(500) NOT NULL,
	size INT(100) NOT NULL,
	data LONGBLOB NOT NULL,
	tab VARCHAR(50) NOT NULL,
	table_id VARCHAR(50) NULL,
	PRIMARY KEY (id)
);

/*test/test*/
INSERT INTO user (usr_id, email, passwd, pages_id, tms_upd, admin, valid, csv_export)
VALUES
	('test','','a94a8fe5ccb19ba61c4c0873d391e987982fbbd3','1','2018-04-06 18:43:29','S','S','S');