
CREATE TABLE `pri_price` (
  `price_id` int(11) NOT NULL AUTO_INCREMENT,
  `route_id` varchar(50) DEFAULT NULL,
  `vehicle_type_id` varchar(50) DEFAULT NULL,
  `price` float(13) DEFAULT NULL,
  `group_price_per_person` float(15) DEFAULT NULL,
  `group_size` int(15) DEFAULT NULL,
  PRIMARY KEY (`price_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


CREATE TABLE `luggage_price_master` (
    `luggage_price_master_id` int(11) NOT NULL AUTO_INCREMENT,
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

