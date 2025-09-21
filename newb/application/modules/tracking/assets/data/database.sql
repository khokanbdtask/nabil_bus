CREATE TABLE IF NOT EXISTS `tracking` (
    `tracking_id` int(11) NOT NULL AUTO_INCREMENT,
    `trips` int(11) NOT NULL,
    `tracking_date` date NOT NULL,
    `reached_points` int(11) NOT NULL,
    `arrival_time` time NOT NULL,
    `user_id` int(11) NOT NULL,
    `create_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
    `update_at` timestamp NOT NULL DEFAULT current_timestamp(),
    `tracking_delete` tinyint(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (`tracking_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `language` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `phrase` varchar(100) NOT NULL,
    `english` varchar(255) NOT NULL,
    `french` text DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `phrase` (`phrase`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--------------------------------------------------------------------------------------------------
-- -- -- In Language Table You have to add these data  -- by using an uninstall.sql file and in config file place - $HmvcConfig['tracking']['_uninstall_query'] = true;
------------------------------------------------------------------------------------------------
--
--
-- INSERT INTO `language` (`phrase`, `english`, `french`) VALUES('tracking_list', 'Tracking List', NULL);
-- INSERT INTO `language` (`phrase`, `english`, `french`) VALUES('progress', 'Trip Progress (%)', NULL);
-- INSERT INTO `language` (`phrase`, `english`, `french`) VALUES('reached_points', 'Current Position', NULL);
-- INSERT INTO `language` (`phrase`, `english`, `french`) VALUES('arrival_time', 'Arrival Time', 'Arrival Time');
-- INSERT INTO `language` (`phrase`, `english`, `french`) VALUES('tracking_route_id', 'Route', NULL);
-- INSERT INTO `language` (`phrase`, `english`, `french`) VALUES('tracking_date', 'Tracking Date', NULL);
-- INSERT INTO `language` (`phrase`, `english`, `french`) VALUES('tracking_fleet_id', 'Fleet ', NULL);
-- INSERT INTO `language` (`phrase`, `english`, `french`) VALUES('delete_tracking', 'Delete Tracking', NULL);
-- INSERT INTO `language` (`phrase`, `english`, `french`) VALUES('edit_tracking', 'Edit Tracking', NULL);
-- INSERT INTO `language` (`phrase`, `english`, `french`) VALUES('tracking', 'Tracking', NULL);
-- INSERT INTO `language` (`phrase`, `english`, `french`) VALUES('add_tracking', 'Add Tracking', NULL);
--