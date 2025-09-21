CREATE TABLE IF NOT EXISTS `tkt_passenger` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_no` VARCHAR(20) NULL DEFAULT NULL,
  `firstname` VARCHAR(50) NULL DEFAULT NULL,
  `lastname` VARCHAR(50) NULL DEFAULT NULL,
  `middle_name` VARCHAR(50) NULL DEFAULT NULL,
  `phone` VARCHAR(30) NULL DEFAULT NULL,
  `email` VARCHAR(100) NULL DEFAULT NULL,
  `password` VARCHAR(32) NULL DEFAULT NULL,
  `remember_token` VARCHAR(100) NULL DEFAULT NULL,
  `date_of_birth` DATE NULL DEFAULT NULL,
  `image` VARCHAR(255) NULL DEFAULT NULL,
  `address_line_1` VARCHAR(255) NULL DEFAULT NULL,
  `address_line_2` VARCHAR(255) NULL DEFAULT NULL,
  `city` VARCHAR(255) NULL DEFAULT NULL,
  `zip_code` VARCHAR(10) NULL DEFAULT NULL,
  `country` VARCHAR(20) NULL DEFAULT NULL,
  `status` TINYINT(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=InnoDB ;


CREATE TABLE  IF NOT EXISTS `luggage_booking` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_no` VARCHAR(20) NULL DEFAULT NULL,
  `trip_id_no` VARCHAR(20) NULL DEFAULT NULL,
  `luggage_passenger_id_no` VARCHAR(20) NULL DEFAULT NULL,
  `trip_route_id` INT(11) NULL DEFAULT NULL,
  `pickup_trip_location` VARCHAR(50) NULL DEFAULT NULL,
  `drop_trip_location` VARCHAR(50) NULL DEFAULT NULL,
  `request_facilities` TEXT NULL,
  `price` FLOAT NULL DEFAULT NULL,
  `discount` FLOAT NULL DEFAULT NULL,
  `weight` FLOAT(11) NULL DEFAULT NULL,
  `size` FLOAT(11) NULL DEFAULT NULL,
  `urgency` VARCHAR(255) NULL DEFAULT NULL,
  `offer_code` VARCHAR(255) NULL DEFAULT NULL,
  `luggage_refund_id` INT(11) NULL DEFAULT NULL,
  `tnc_agree` INT(11) NULL DEFAULT NULL,
  `agent_id` INT(11) NULL DEFAULT NULL,
  `booking_date` DATETIME NULL DEFAULT NULL,
  `date` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_no` (`id_no`)
) COLLATE='utf8_general_ci' ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS `luggage_refund` (
  `id` INT(11)  UNSIGNED NOT NULL AUTO_INCREMENT,
  `luggage_booking_id_no` VARCHAR(20) NULL DEFAULT NULL,
  `luggage_passenger_id_no` VARCHAR(20) NULL DEFAULT NULL,
  `cancelation_fees` FLOAT NULL DEFAULT NULL,
  `causes` TEXT NULL,
  `comment` TEXT NULL,
  `refund_by_id` INT(11) NULL DEFAULT NULL,
  `date` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `FK_luggage_refund_luggage_booking` (`luggage_booking_id_no`),
  CONSTRAINT `FK_luggage_refund_luggage_booking` FOREIGN KEY (`luggage_booking_id_no`) REFERENCES `luggage_booking` (`id_no`) ON UPDATE CASCADE ON DELETE CASCADE
) COLLATE='utf8_general_ci' ENGINE=InnoDB;


CREATE TABLE  IF NOT EXISTS `tkt_feedback` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tkt_booking_id_no` VARCHAR(20) NULL DEFAULT NULL,
  `name` VARCHAR(100) NULL DEFAULT NULL,
  `comment` TEXT NULL,
  `rating` TINYINT(1) NULL DEFAULT '1', 
  `add_to_website` TINYINT(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS `luggage_referal` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `luggage_passenger_id_no` INT(11) NULL DEFAULT NULL,
  `date` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS `luggage_booking_downtime` (
  `id` int(11) NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `downtime` varchar(20) NOT NULL,
 PRIMARY KEY (`id`)
) COLLATE='utf8_general_ci' ENGINE=InnoDB;



CREATE TABLE `luggage_price_master` (
    `luggage_price_master_id` int(11) NOT NULL AUTO_INCREMENT,
    `package_name` VARCHAR(250) NULL DEFAULT NULL,
    `fleet_type_id` int(11) NOT NULL,
    `trip_route_id` int(11) NOT NULL,
    `max_weight_carry` float(11,2) DEFAULT NULL,
    `urgency_status` int(11) NOT NULL DEFAULT 0,
    `urgent_price_add` float(11,2) NOT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `user_id` int(11) DEFAULT NULL,
    `delete_status` int(11) NOT NULL DEFAULT 0,
 PRIMARY KEY (`luggage_price_master_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `luggage_price_details` (
    `luggage_price_details_id` int(11) NOT NULL AUTO_INCREMENT,
    `luggage_price_master_id` int(11) NOT NULL,
    `min_weight` float(11,2) NOT NULL,
    `max_weight` float(11,2) NOT NULL,
 PRIMARY KEY (`luggage_price_details_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

