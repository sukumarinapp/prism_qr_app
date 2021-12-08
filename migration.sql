CREATE TABLE `set250` (
  `id` int(11) NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `APPDAT` decimal(8,0) NOT NULL,
  `MODCOD` varchar(3) NOT NULL,
  `TAXSTR` decimal(4,0) NOT NULL,
  `SRLNUB` decimal(6,0) NOT NULL,
  `DESCRP` varchar(30) DEFAULT NULL,
  `SCRTAX` varchar(3) DEFAULT NULL,
  `CALTYP` decimal(1,0) DEFAULT NULL,
  `AMOUNT` decimal(15,3) DEFAULT NULL,
  `TRGTAX` decimal(3,0) DEFAULT NULL,
  `TRGSLB` decimal(4,0) DEFAULT NULL,
  `FUTER1` varchar(10) DEFAULT NULL,
  `FUTER2` decimal(15,3) DEFAULT NULL,
  `DELFLG` decimal(1,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `set250` ADD PRIMARY KEY (`id`);
ALTER TABLE `set250` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `posrat` ADD `TAXSTR` INT NULL AFTER `PRICE`;

ALTER TABLE `set090` ADD `taxinc` INT NOT NULL DEFAULT '1' AFTER `shtnam`;
-------------------
ALTER TABLE `poskot` ADD `kotdat` INT NOT NULL AFTER `order_id`;

CREATE TABLE `postax` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `taxcod` varchar(3) NOT NULL,
  `descrp` varchar(50) NOT NULL,
  `taxper` decimal(10,2) NOT NULL,
  `taxabl` decimal(10,2) NOT NULL,
  `taxamt` decimal(10,2) NOT NULL,
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
