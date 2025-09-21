-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2021 at 06:49 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bus_ticket`
--

-- --------------------------------------------------------

--
-- Table structure for table `acc_account_name`
--

DROP TABLE IF EXISTS `acc_account_name`;
CREATE TABLE IF NOT EXISTS `acc_account_name` (
  `account_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `account_name` varchar(255) NOT NULL,
  `account_type` int(11) NOT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `acc_account_name`
--

INSERT INTO `acc_account_name` (`account_id`, `account_name`, `account_type`) VALUES
(1, 'Fleet Repair', 0),
(2, 'Fleet Rent', 1),
(3, 'Ticket Booking', 1),
(4, 'Ticket Refund', 0),
(5, 'Miscellaneous Expense', 0),
(6, 'Miscellaneous Income', 1),
(7, 'Luggage Booking', 1);

-- --------------------------------------------------------

--
-- Table structure for table `acn_account_transaction`
--

DROP TABLE IF EXISTS `acn_account_transaction`;
CREATE TABLE IF NOT EXISTS `acn_account_transaction` (
  `account_tran_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `transaction_description` varchar(255) NOT NULL,
  `amount` varchar(25) DEFAULT NULL,
  `document_pic` text DEFAULT NULL,
  `create_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`account_tran_id`)
) ENGINE=InnoDB AUTO_INCREMENT=232 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `agent_info`
--

DROP TABLE IF EXISTS `agent_info`;
CREATE TABLE IF NOT EXISTS `agent_info` (
  `agent_id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_first_name` varchar(30) DEFAULT NULL,
  `agent_second_name` varchar(150) DEFAULT NULL,
  `agent_company_name` varchar(150) DEFAULT NULL,
  `agent_document_id` varchar(150) DEFAULT NULL,
  `agent_pic_document` varchar(255) DEFAULT NULL,
  `agent_picture` varchar(255) DEFAULT NULL,
  `agent_phone` varchar(150) DEFAULT NULL,
  `agent_mobile` varchar(150) DEFAULT NULL,
  `agent_email` varchar(150) DEFAULT NULL,
  `agent_address_line_1` varchar(150) DEFAULT NULL,
  `agent_address_line_2` varchar(150) DEFAULT NULL,
  `agent_address_city` varchar(150) DEFAULT NULL,
  `agent_address_zip_code` varchar(150) DEFAULT NULL,
  `agent_country` varchar(150) DEFAULT NULL,
  `agent_commission` float NOT NULL,
  `status` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`agent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `agent_ledger`
--

DROP TABLE IF EXISTS `agent_ledger`;
CREATE TABLE IF NOT EXISTS `agent_ledger` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) NOT NULL,
  `booking_id` varchar(30) NOT NULL,
  `debit` float NOT NULL DEFAULT 0,
  `credit` float NOT NULL DEFAULT 0,
  `date` date NOT NULL,
  `commission_rate` float NOT NULL DEFAULT 0,
  `total_price` float NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=111 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `api_user`
--

DROP TABLE IF EXISTS `api_user`;
CREATE TABLE IF NOT EXISTS `api_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secret_key` varchar(250) NOT NULL,
  `date` timestamp NULL DEFAULT current_timestamp(),
  `create_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bank_info`
--

DROP TABLE IF EXISTS `bank_info`;
CREATE TABLE IF NOT EXISTS `bank_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(200) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `account_number` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `bank_transaction`
--

DROP TABLE IF EXISTS `bank_transaction`;
CREATE TABLE IF NOT EXISTS `bank_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_id` varchar(50) DEFAULT NULL,
  `transaction_id` varchar(50) DEFAULT NULL,
  `payer_name` varchar(200) DEFAULT NULL,
  `booking_id` varchar(50) DEFAULT NULL,
  `note` varchar(250) DEFAULT NULL,
  `refund` varchar(50) DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `b_account_no` varchar(50) DEFAULT NULL,
  `transaction_date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `booking_downtime`
--

DROP TABLE IF EXISTS `booking_downtime`;
CREATE TABLE IF NOT EXISTS `booking_downtime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reg_no` varchar(50) NOT NULL,
  `downtime` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `email_config`
--

DROP TABLE IF EXISTS `email_config`;
CREATE TABLE IF NOT EXISTS `email_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `protocol` text NOT NULL,
  `smtp_host` text NOT NULL,
  `smtp_port` text NOT NULL,
  `smtp_user` varchar(35) NOT NULL,
  `smtp_pass` varchar(35) NOT NULL,
  `mailtype` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employee_history`
--

DROP TABLE IF EXISTS `employee_history`;
CREATE TABLE IF NOT EXISTS `employee_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) DEFAULT NULL,
  `second_name` varchar(30) DEFAULT NULL,
  `position` varchar(30) DEFAULT NULL,
  `phone_no` varchar(30) DEFAULT NULL,
  `email_no` varchar(30) DEFAULT NULL,
  `document_id` varchar(30) DEFAULT NULL,
  `document_pic` varchar(255) DEFAULT NULL,
  `address_line_1` varchar(150) DEFAULT NULL,
  `address_line_2` varchar(150) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `blood_group` varchar(6) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `status` varchar(6) DEFAULT NULL,
  `is_assign` tinyint(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employee_type`
--

DROP TABLE IF EXISTS `employee_type`;
CREATE TABLE IF NOT EXISTS `employee_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(30) DEFAULT NULL,
  `details` varchar(100) DEFAULT NULL,
  `status` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee_type`
--

INSERT INTO `employee_type` (`type_id`, `type_name`, `details`, `status`) VALUES
(1, 'Driver', 'Expert in Driving', NULL),
(8, 'Office Staff', 'regular staff', NULL),
(6, 'Assistant', '', NULL),
(9, 'Hostess', 'Bus Hostess for assistance', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `enquiry`
--

DROP TABLE IF EXISTS `enquiry`;
CREATE TABLE IF NOT EXISTS `enquiry` (
  `enquiry_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `enquiry` text DEFAULT NULL,
  `checked` tinyint(1) DEFAULT NULL,
  `ip_address` varchar(20) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `checked_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`enquiry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fit_fitness`
--

DROP TABLE IF EXISTS `fit_fitness`;
CREATE TABLE IF NOT EXISTS `fit_fitness` (
  `fitness_id` int(11) NOT NULL AUTO_INCREMENT,
  `fitness_name` varchar(50) DEFAULT NULL,
  `fitness_description` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`fitness_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fleet_facilities`
--

DROP TABLE IF EXISTS `fleet_facilities`;
CREATE TABLE IF NOT EXISTS `fleet_facilities` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fleet_registration`
--

DROP TABLE IF EXISTS `fleet_registration`;
CREATE TABLE IF NOT EXISTS `fleet_registration` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `reg_no` varchar(255) DEFAULT NULL,
  `fleet_type_id` int(11) DEFAULT NULL,
  `engine_no` varchar(255) DEFAULT NULL,
  `model_no` varchar(255) DEFAULT NULL,
  `chasis_no` varchar(255) DEFAULT NULL,
  `owner` varchar(255) DEFAULT NULL,
  `owner_phone` varchar(30) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `ac_available` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `is_assign` tinyint(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fleet_type`
--

DROP TABLE IF EXISTS `fleet_type`;
CREATE TABLE IF NOT EXISTS `fleet_type` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `layout` varchar(50) NOT NULL,
  `lastseat` varchar(30) NOT NULL,
  `total_seat` int(11) NOT NULL,
  `seat_numbers` varchar(255) NOT NULL,
  `fleet_facilities` varchar(250) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `total_weight` float(11,2) DEFAULT NULL,
  `luggage_service` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ftn_fitness_period`
--

DROP TABLE IF EXISTS `ftn_fitness_period`;
CREATE TABLE IF NOT EXISTS `ftn_fitness_period` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fitness_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `start_milage` float DEFAULT NULL,
  `end_milage` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `how_to_use`
--

DROP TABLE IF EXISTS `how_to_use`;
CREATE TABLE IF NOT EXISTS `how_to_use` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

DROP TABLE IF EXISTS `language`;
CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phrase` varchar(100) NOT NULL,
  `english` varchar(255) NOT NULL,
  `french` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phrase` (`phrase`)
) ENGINE=InnoDB AUTO_INCREMENT=919 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `phrase`, `english`, `french`) VALUES
(1, 'login', 'Login', 'Se connecter'),
(2, 'email', 'Email', 'Email '),
(3, 'password', 'Password', 'Mot de passe'),
(4, 'reset', 'Reset', 'Reinitialiser'),
(5, 'dashboard', 'Dashboard', 'Tableau de bord'),
(6, 'home', 'HOME', 'Acceuil '),
(7, 'profile', 'Profile', 'Profil'),
(8, 'profile_setting', 'Profile Setting', 'Reglage du profil'),
(9, 'firstname', 'First Name', 'Nom'),
(10, 'lastname', 'Last Name', 'PrÃƒÂ©nom'),
(11, 'about', 'About', 'A propos'),
(12, 'preview', 'Preview', 'Visualiser'),
(13, 'image', 'Image', 'Image'),
(14, 'save', 'Save', 'Sauvegarder'),
(15, 'upload_successfully', 'Upload Successfully!', 'Mise ÃƒÂ  jour reussi'),
(16, 'user_added_successfully', 'User Added Successfully!', 'Utilisateur ajoutÃƒÂ© avec succÃƒÂ¨s'),
(17, 'please_try_again', 'Please Try Again...', 'SVP Essayez encore'),
(18, 'inbox_message', 'Inbox Messages', 'Boite de reception message'),
(19, 'sent_message', 'Sent Message', 'Envoyer un message'),
(20, 'message_details', 'Message Details', 'DÃƒÂ©tails du message'),
(21, 'new_message', 'New Message', 'Nouveau message'),
(22, 'receiver_name', 'Receiver Name', 'Nom du recepteur'),
(23, 'sender_name', 'Sender Name', 'Nom de l\'expediteur'),
(24, 'subject', 'Subject', 'Sujet'),
(25, 'message', 'Message', 'Message'),
(26, 'message_sent', 'Message Sent!', 'Message envoyÃƒÂ©'),
(27, 'ip_address', 'IP Address', 'Adresse IP'),
(28, 'last_login', 'Last Login', 'DerniÃƒÂ¨re connexion'),
(29, 'last_logout', 'Last Logout', 'DerniÃƒÂ¨re dÃƒÂ©connexion'),
(30, 'status', 'Status', 'Status'),
(31, 'delete_successfully', 'Delete Successfully!', 'Suppression rÃƒÂ©ussi'),
(32, 'send', 'Send', 'Envoyer'),
(33, 'date', 'Date', 'Date'),
(34, 'action', 'Action', 'Action'),
(35, 'sl_no', 'SL No.', 'NÃ‚Â° SL'),
(36, 'are_you_sure', 'Are You Sure ? ', 'Etes-vous sure ?'),
(37, 'application_setting', 'Application Setting', 'Reglages d\'application'),
(38, 'application_title', 'Application Title', 'Titre d\'application'),
(39, 'address', 'Address', 'Adresse'),
(40, 'phone', 'Phone', 'Phone'),
(41, 'favicon', 'Favicon', 'Favicon'),
(42, 'logo', 'Logo', 'Logo'),
(43, 'language', 'Language', 'Langue'),
(44, 'left_to_right', 'Left To Right', 'Gauche vers droite'),
(45, 'right_to_left', 'Right To Left', 'Droite vers la gauche'),
(46, 'footer_text', 'Footer Text', 'Texte du footer'),
(47, 'site_align', 'Application Alignment', 'Aligner le site'),
(48, 'welcome_back', 'Welcome Back!', 'Bienvenue ÃƒÂ  nouveau'),
(49, 'please_contact_with_admin', 'Please Contact With Admin', 'Veuillez contacter l\'administrateur'),
(50, 'incorrect_email_or_password', 'Incorrect Email/Password', 'Mot de passe ou Email incorrect'),
(51, 'select_option', 'Select Option', 'Option de selection'),
(52, 'ftp_setting', 'Data Synchronize [FTP Setting]', 'Reglage FTP'),
(53, 'hostname', 'Host Name', 'Hostname'),
(54, 'username', 'User Name', 'Nom d\'utilisateur'),
(55, 'ftp_port', 'FTP Port', 'Port FTP'),
(56, 'ftp_debug', 'FTP Debug', 'Debogage FTP '),
(57, 'project_root', 'Project Root', 'Racine du projet'),
(58, 'update_successfully', 'Update Successfully', 'Mise ÃƒÂ  jour reussi'),
(59, 'save_successfully', 'Save Successfully!', 'Sauvegarde rÃƒÂ©ussie'),
(61, 'internet_connection', 'Internet Connection', 'Connexion internet'),
(62, 'ok', 'Ok', 'Ok'),
(63, 'not_available', 'Not Available', 'Indisponible'),
(64, 'available', 'Available', 'Disponible'),
(65, 'outgoing_file', 'Outgoing File', 'Fichier sortant'),
(66, 'incoming_file', 'Incoming File', 'Fichier entrant '),
(67, 'data_synchronize', 'Data Synchronize', 'Synchroniser les donnÃƒÂ©es'),
(68, 'unable_to_upload_file_please_check_configuration', 'Unable to upload file! please check configuration', 'Impossible de charger les donnÃƒÂ©es veuillez vÃƒÂ©rifier les configurations'),
(69, 'please_configure_synchronizer_settings', 'Please configure synchronizer settings', 'Veuillez configurer les paramÃƒÂ¨tres de synchronisation'),
(70, 'download_successfully', 'Download Successfully', 'TÃƒÂ©lÃƒÂ©chargement rÃƒÂ©ussi'),
(71, 'unable_to_download_file_please_check_configuration', 'Unable to download file! please check configuration', 'TÃƒÂ©lÃƒÂ©chargement impossible, veuillez vÃƒÂ©rifier votre connexion internet'),
(72, 'data_import_first', 'Data Import First', 'Importer d\'abord les donnÃƒÂ©es'),
(73, 'data_import_successfully', 'Data Import Successfully!', 'Import de donnÃƒÂ©es rÃƒÂ©ussi'),
(74, 'unable_to_import_data_please_check_config_or_sql_file', 'Unable to import data! please check configuration / SQL file.', 'Impossible d\'importer les donnÃƒÂ©es, veuillez vÃƒÂ©rifier les configurations'),
(75, 'download_data_from_server', 'Download Data from Server', 'TÃƒÂ©lÃƒÂ©charger les donnÃƒÂ©es du serveur'),
(76, 'data_import_to_database', 'Data Import To Database', 'Import de donnÃƒÂ©es dans la base de donnÃƒÂ©es'),
(77, 'data_upload_to_server', 'Data Upload to Server', 'Charger les donnÃƒÂ©es dans le seveur'),
(78, 'please_wait', 'Please Wait...', 'Veuillez patienter'),
(79, 'ooops_something_went_wrong', ' Ooops something went wrong...', 'Oops, quelque chose a mal fonctionnÃƒÂ©'),
(80, 'module_permission_list', 'Module Permission List', 'Liste de permission du module'),
(81, 'user_permission', 'User Permission', 'Permission utilisateur'),
(82, 'add_module_permission', 'Add Module Permission', 'Ajouter module de permission'),
(83, 'module_permission_added_successfully', 'Module Permission Added Successfully!', 'Permission du module ajoutÃƒÂ©e avec succÃƒÂ¨s'),
(84, 'update_module_permission', 'Update Module Permission', 'Mettre ÃƒÂ  jour le module de permission'),
(85, 'download', 'Download', 'TÃƒÂ©lÃƒÂ©charger'),
(86, 'module_name', 'Module Name', 'Nom du module'),
(87, 'create', 'Create', 'CrÃƒÂ©er'),
(88, 'read', 'Read', 'Lu'),
(89, 'update', 'Update', 'Mettre ÃƒÂ  jour'),
(90, 'delete', 'Delete', 'Supprimer '),
(91, 'module_list', 'Module List', 'Liste de module'),
(92, 'add_module', 'Add Module', 'Ajouter module'),
(93, 'directory', 'Module Direcotory', 'Repertoire'),
(94, 'description', 'Description', 'Description'),
(95, 'image_upload_successfully', 'Image Upload Successfully!', 'Image mis ÃƒÂ  jour avec succÃƒÂ¨s'),
(96, 'module_added_successfully', 'Module Added Successfully', 'Module ajoutÃƒÂ© avec succÃƒÂ¨s'),
(97, 'inactive', 'Inactive', 'Inactif'),
(98, 'active', 'Active', 'Actif'),
(99, 'user_list', 'User List', 'Liste d\'utilisateur'),
(100, 'see_all_message', 'See All Messages', 'Voir tous les messages'),
(101, 'setting', 'Setting', 'Reglages'),
(102, 'logout', 'LOGOUT', 'DÃƒÂ©connexion'),
(103, 'admin', 'Admin', 'Administrateur'),
(104, 'add_user', 'Add User', 'Ajouter un utilisateur'),
(105, 'user', 'User', 'Utilisateur'),
(106, 'module', 'Module', 'Module'),
(107, 'new', 'New', 'Nouveau'),
(108, 'inbox', 'Inbox', 'Boite de reception'),
(109, 'sent', 'Sent', 'EnvoyÃƒÂ©'),
(110, 'synchronize', 'Synchronize', 'Synchroniser'),
(111, 'data_synchronizer', 'Data Synchronizer', 'Synchronisation de donnÃƒÂ©es'),
(112, 'module_permission', 'Module Permission', 'Permission du module'),
(113, 'backup_now', 'Backup Now!', 'Sauvegarder maintenant'),
(114, 'restore_now', 'Restore Now!', 'Restaurer maintenant'),
(115, 'backup_and_restore', 'Data Backup', 'Suavegarde et restauration'),
(116, 'captcha', 'Captcha Word', 'Captcha'),
(117, 'database_backup', 'Database Backup', 'Sauvegarde base de donnÃƒÂ©e'),
(118, 'restore_successfully', 'Restore Successfully', 'Restauration rÃƒÂ©ussi'),
(119, 'backup_successfully', 'Backup Successfully', 'Sauvegarde rÃƒÂ©ussi'),
(120, 'filename', 'File Name', ' Nom du fichier'),
(121, 'file_information', 'File Information', 'Info du fichier'),
(122, 'size', 'Size', 'Taille'),
(123, 'backup_date', 'Backup Date', 'Date de sauvegarde'),
(124, 'overwrite', 'Overwrite', 'Ecraser'),
(125, 'invalid_file', 'Invalid File!', 'Fichier invalide'),
(126, 'invalid_module', 'Invalid Module', 'Module invalide'),
(127, 'remove_successfully', 'Remove Successfully!', 'RetirÃƒÂ© avec succÃƒÂ¨s'),
(128, 'install', 'Install', 'Installer'),
(129, 'uninstall', 'Uninstall', 'DÃƒÂ©sinstaller'),
(130, 'tables_are_not_available_in_database', 'Tables are not available in database.sql', 'Tables indisponibles dans les bases de donnÃƒÂ©es'),
(131, 'no_tables_are_registered_in_config', 'No tables are registerd in config.php', 'Pas de tickets enregistrÃƒÂ©s dans les configurations'),
(132, 'enquiry', 'Enquiry', 'Requetes'),
(133, 'read_unread', 'Read/Unread', 'Lu et non lu'),
(134, 'enquiry_information', 'Enquiry Information', 'info de requete'),
(135, 'user_agent', 'User Agent', 'Utilisateur agent'),
(136, 'checked_by', 'Checked By', 'VerifiÃƒÂ© par'),
(137, 'new_enquiry', 'New Enquiry', 'Nouvelle requÃƒÂªte'),
(138, 'fleet', 'Fleet Management', 'Flotte'),
(139, 'fleet_type', 'Fleet Type', 'Type de vehicule'),
(140, 'add', 'Add', 'Ajouter'),
(141, 'list', 'List', 'Liste'),
(142, 'fleet_facilities', 'Fleet Facilities', 'FacilitÃƒÂ©s du vÃƒÂ©hicule'),
(143, 'fleet_registration', 'Vehicles', 'Enregistrement du vÃƒÂ©hicule'),
(144, 'reg_no', 'Registration No.', 'NÃ‚Â° de reg'),
(145, 'model_no', 'Model No.', 'NÃ‚Â° du modÃƒÂ¨le '),
(146, 'engine_no', 'Engine No.', 'NÃ‚Â° du moteur'),
(147, 'chasis_no', 'Chasis No.', 'NÃ‚Â° de chassis'),
(148, 'total_seat', 'Total Seat', 'SiÃƒÂ¨ges total'),
(149, 'seat_numbers', 'Seat Number', 'NumÃƒÂ©ro des siÃƒÂ¨ges'),
(150, 'owner', 'Owner', 'Auteur'),
(151, 'company', 'Company Name', 'SocietÃƒÂ©'),
(152, 'trip', 'Trip Management', 'Voyage'),
(153, 'location', 'Destination', 'Localication'),
(154, 'route', 'Route', 'Ligne'),
(155, 'assign', 'Assign', 'Assigner'),
(156, 'close', 'Close Trip', 'Fermer'),
(157, 'location_name', 'Destination Name', 'Nom de la localisation'),
(158, 'google_map', 'Google Map', 'Google maps'),
(159, 'start_point', 'Start Point', 'Point de dÃƒÂ©part'),
(160, 'end_point', 'End Point', 'Point d\'arrivÃƒÂ©'),
(161, 'route_name', 'Route Name', 'Nom de la ligne'),
(162, 'distance', 'Distance', 'Distance'),
(163, 'approximate_time', 'Approximate Time', 'Temps approximatif'),
(164, 'stoppage_points', 'Stoppage Points', 'Points d\'arrets'),
(165, 'fleet_registration_no', 'Fleet Registration No.', 'NÃ‚Â° d\'enregistrement du vÃƒÂ©hicule'),
(166, 'start_date', 'Start Date', 'Date de dÃƒÂ©but'),
(167, 'end_date', 'End Date', 'Date de fin'),
(168, 'driver_name', 'Driver Name', 'Nom du chauffeur'),
(169, 'assistants_ids', 'Assistants', 'ID d\'assignations'),
(170, 'sold_ticket', 'Sold Ticket', 'Tickets vendus'),
(171, 'total_income', 'Total Income', 'Revenu total'),
(172, 'total_expense', 'Total Expense', 'Total dÃƒÂ©penses'),
(173, 'total_fuel', 'Total Fuel', 'Total Fuel'),
(174, 'trip_comment', 'Trip Comment', 'Commentaire du voyage'),
(175, 'closed_by', 'Closed by', 'FermÃƒÂ© par '),
(176, 'ticket', 'Ticket Management', 'Ticket'),
(177, 'passenger', 'Passenger', 'Passager'),
(178, 'middle_name', 'Middle Name', 'Autre nom'),
(179, 'date_of_birth', 'Date of Birth', 'Date de naissance'),
(180, 'passenger_id', 'Passenger ID.', 'ID du passager'),
(181, 'address_line_1', 'Address Line 1', 'Adresse 1'),
(182, 'address_line_2', 'Address Line 2', 'Adresse 1'),
(184, 'zip_code', 'Zip Code', 'Code zip'),
(186, 'name', 'Name', 'Nom'),
(187, 'ac_available', 'AC available', 'Clim disponible'),
(188, 'trip_id', 'Trip ID.', 'ID du voyage'),
(189, 'book', 'Book', 'Reserver'),
(190, 'booking_id', 'Booking ID.', 'ID de reservation'),
(191, 'available_seats', 'Available Seats', 'SiÃƒÂ¨ges disponibles'),
(192, 'select_seats', 'Select Seats', 'Selectionner les siÃƒÂ¨ges'),
(193, 'time', 'Time', 'Temps'),
(194, 'offer_code', 'Offer Code', 'Code de l\'offre'),
(195, 'price', 'Price', 'Prix'),
(196, 'discount', 'Discount', 'Remise'),
(197, 'request_facilities', 'Request Facilities', 'RequÃƒÂªtes de facilitÃƒÂ©s'),
(198, 'pickup_location', 'Pickup Location', 'Localisation de depart'),
(199, 'drop_location', 'Drop Location', 'Destination'),
(200, 'amount', 'Amount', 'Montant'),
(201, 'invalid_passenger_id', 'Invalid Passenger ID', 'ID du passager invalide'),
(202, 'invalid_input', 'Invalid Input', 'EntrÃƒÂ©e invalide'),
(203, 'booking_date', 'Booking Date', 'Date de reservation'),
(204, 'cancelation_fees', 'Cancelation Fees', 'Frais d\'annulation'),
(205, 'causes', 'Causes', 'Causes'),
(206, 'comment', 'Comment', 'Commentaires'),
(207, 'refund', 'Refund', 'Remboursement'),
(208, 'refund_by', 'Refund by', 'RemboursÃƒÂ© par'),
(209, 'feedback', 'Feedback', 'Feedback'),
(210, 'rating', 'Rating', 'Notes'),
(211, 'blood_group', 'Blood Group', 'Groupe sanguin'),
(212, 'religion', 'Religion', 'Religion'),
(219, 'details', 'Details', 'Details'),
(220, 'type_name', 'Type Name', 'Nom du type'),
(221, 'view_details', 'View Details', 'Visualiser les dÃƒÂ©tails'),
(222, 'document_pic', 'Document Picture', 'Image du document'),
(223, 'fitness_list', 'Fitness List', 'Liste fitness'),
(226, 'fitness_name', 'Fitness Name', 'Nom fitness'),
(227, 'fitness_description', 'Description', 'Description fitness'),
(228, 'successfully_updated', 'Your Data Successfully Updated', 'Mise ÃƒÂ  jour reussi'),
(229, 'fitness_period', 'Fitness Period List', 'PÃƒÂ©riode fitness'),
(230, 'fitness_id', 'Fitness Name', 'ID fitness'),
(231, 'vehicle_id', 'Vehicles No', 'ID vehicule'),
(234, 'start_milage', 'Start Milage', 'CommenÃƒÂ§er le kilometrage'),
(235, 'end_milage', 'End Milage', 'Fin du KM'),
(236, 'agent', 'Agent', 'Agent'),
(237, 'agent_first_name', 'First Name', 'Nom Agent'),
(238, 'agent_second_name', 'LastName', 'Autre Nom de l\'agent'),
(239, 'agent_company_name', 'Company Name', 'Non SociÃƒÂ©tÃƒÂ© d\'agent '),
(240, 'agent_document_id', 'Document ID', 'ID Document agent'),
(241, 'agent_pic_document', 'Document File', 'Doc photo agent'),
(242, 'agent_phone', 'Phone', 'TÃƒÂ©lÃƒÂ©phone agent'),
(243, 'agent_mobile', 'Mobile No', 'Mobile Agent'),
(244, 'agent_email', 'Email', 'Email Agent'),
(245, 'agent_address_line_1', 'Address Line 1', 'Adresse d\'agent 1'),
(246, 'agent_address_line_2', 'Address Line 2', 'Adresse d\'agent 2'),
(247, 'agent_address_city', 'City', 'Adresse ville d\'agent'),
(248, 'agent_address_zip_code', 'ZIP', 'Code zip agent'),
(249, 'agent_country', 'Country', 'Pays d\'agent'),
(252, 'sl', 'SL', 'sl'),
(253, 'route_id', 'Route Name', 'ID de ligne'),
(254, 'vehicle_type_id', 'Vehicle Type', 'ID type de vÃƒÂ©hicule'),
(255, 'group_price_per_person', 'Group Price Per Person', 'Groupe de prix par personne'),
(256, 'group_size', 'Group Members', 'Taille du groupe'),
(257, 'successfully_saved', 'Your Data Successfully Saved', 'SauvegardÃƒÂ© avec succÃƒÂ¨s'),
(258, 'account', 'Account', 'Compte'),
(259, 'account_name', 'Account Name', 'Nom du compte'),
(260, 'account_type', 'Account Type', 'Type de compte'),
(261, 'account_transaction', 'Account Transaction', 'Transaction du compte'),
(262, 'account_id', 'Account Name', 'ID du compte'),
(263, 'transaction_description', 'Transaction Details', 'Description de la transaction'),
(265, 'pass_book_id', 'Passenger ID', 'ID pass de reservation'),
(267, 'payment_id', 'Payment ID', 'ID de paiement '),
(268, 'create_by_id', 'Created By', 'CrÃƒÂ©er l\'ID par'),
(269, 'offer', 'Offer', 'Offres'),
(270, 'offer_name', 'Offer Name', 'Nom de l\'offre'),
(271, 'offer_start_date', 'Offer Start Date', 'Date de debut de l\'offre'),
(272, 'offer_end_date', 'Offer Last Date', 'Datae de fin de l\'offre'),
(274, 'offer_discount', 'Discount', 'Remise de l\'offre '),
(275, 'offer_terms', 'Offer Terms', 'Termes de l\'offre'),
(276, 'offer_route_id', 'Route Name', 'ID offre de voyage'),
(277, 'offer_number', 'Offer Number', 'NÃ‚Â° de l\'offre'),
(280, 'seat_number', 'Seat No', 'NÃ‚Â° du siÃƒÂ¨ge '),
(281, 'available_seat', 'Available Seat', 'SiÃƒÂ¨ge disponible'),
(282, 'owner_name', 'Owner Name', 'Nom de l\'auteur'),
(283, 'agent_picture', 'Picture', 'Photo Agent'),
(284, 'account_add', 'Add Account', 'Ajouter un compte'),
(285, 'add_agent', 'Add Agent', 'Ajouter agent'),
(286, 'hr', 'Human Resource', 'Ressource Humaine'),
(287, 'create_hr', 'Add Employee', 'CrÃƒÂ©er l\'heure'),
(288, 'serial', 'Sl', 'Serial'),
(289, 'position', 'Position', 'Position'),
(290, 'phone_no', 'Phone No', 'NÃ‚Â° de tÃƒÂ©lÃƒÂ©phone'),
(291, 'email_no', 'Email', 'NÃ‚Â° Email'),
(292, 'picture', 'Picture', 'Photo'),
(293, 'first_name', 'First Name', 'Nom'),
(294, 'second_name', 'Last Name', 'DeuxiÃƒÂ¨me nom'),
(295, 'document_id', 'Documet Id', 'ID document'),
(298, 'country', 'Country', 'Pays'),
(299, 'city', 'City', 'Ville '),
(300, 'zip', 'Zip ', 'Zip '),
(393, 'add_passenger', 'Add Passenger', 'Ajouter un passager'),
(394, 'search_tiket', 'Search Ticket', 'Rechercher le ticket'),
(395, 'slogan', 'Slogan', 'Slogan'),
(396, 'website', 'BUS 365 THEME', 'Site web'),
(397, 'submit', 'Submit', 'Envoyer'),
(398, 'customer_service', 'Customer Service', 'Service client'),
(399, 'submit_successfully', 'Submit Successfully!', 'Envoi reussi'),
(400, 'add_to_website', 'Add to Website', 'Ajouter au site'),
(401, 'our_customers_say', 'Our Customers Say', 'Ce que disent nos clients'),
(402, 'website_status', 'Website Status', 'Status site web'),
(403, 'title', 'Title', 'Titre'),
(405, 'total_fleet', 'Total Fleet', 'Total flotte vÃƒÂ©hicules'),
(406, 'total_passenger', 'Total Passenger', 'Total passagers'),
(407, 'todays_trip', 'Today\'s Trip', 'Voyage d\'aujourd\'hui'),
(408, 'seats_available', 'Seats Available', 'SiÃƒÂ¨ges disponibles'),
(409, 'no_trip_avaiable', 'No trip avaiable', 'Aucun voyage disponible'),
(410, 'booking', 'Booking', 'Reservations'),
(411, 'something_went_worng', 'Something went worng!', 'Quelque chose a mal fonctionnÃƒÂ©'),
(412, 'paypal_email', 'Paypal Email', 'Email Paypal'),
(413, 'currency', 'Currency', 'DÃƒÂ©vise'),
(414, 'reports', 'Reports', 'Rapports'),
(415, 'search', 'Search', 'Rechercher'),
(417, 'go', 'Go', 'Lancer'),
(418, 'all', 'All', 'Tout'),
(419, 'filter', 'Filter', 'Filter'),
(420, 'last_year_progress', 'Last Year Progress', 'ProgrÃƒÂ¨s l\'an dernier'),
(421, 'download_document', 'Download Document', 'TÃƒÂ©lÃƒÂ©charger le document'),
(422, 'mobile', 'Mobile No.', 'Mobile '),
(424, 'account_list', 'Account List', 'Liste de comptes'),
(425, 'add_income', 'Add Income', 'Ajouter une entrÃƒÂ©e'),
(426, 'add_expense', 'Add Expense', 'Ajouter une dÃƒÂ©pense'),
(427, 'agent_list', 'Agent List', 'Liste d\'agent'),
(428, 'add_fitness', 'Add Fitness', 'Ajouter fitness'),
(429, 'fitness', 'Fitness', 'Fitness'),
(430, 'add_fitness_period', 'Add Fitness Period', 'Ajouter PÃƒÂ©riode fitness'),
(431, 'employee_type', 'Employee Type', 'Type d\'employÃƒÂ©'),
(432, 'employee_list', 'Employee List', 'Liste d\'employÃƒÂ©'),
(433, 'add_offer', 'Add Offer', 'Ajouter une offre'),
(434, 'offer_list', 'Offer List', 'Liste d\'offre'),
(435, 'add_price', 'Add Price', 'Ajouter un prix'),
(436, 'price_list', 'Price List', 'Liste de prix'),
(437, 'layout', 'Layout', 'AperÃƒÂ§u'),
(438, 'last_seat_availabe', 'Last Seat Available', 'Dernier siÃƒÂ¨ge disponible'),
(439, 'paypal_transaction', 'Paypal Transaction', 'Transaction paypal'),
(440, 'enable', 'Enable', 'Activer'),
(441, 'disable', 'Disable', 'Desactiver'),
(442, 'payment_gateway', 'Payment Gateway', 'Passerelle de paiement'),
(443, 'payment_type', 'Payment Type', 'Type de paiement'),
(444, 'payment_status', 'Payment Status', 'Status de paiement'),
(445, 'downtime', 'Down Time', 'Temps hors service'),
(446, 'select_bus', 'Select Bus', 'Selectionner le bus'),
(447, 'user_info', 'Passenger Information', 'Informations d\'utilisateur'),
(448, 'personal_info', 'Personal Information', 'Informations personnelles'),
(449, 'booking_info', 'Booking Information', 'Info de reservation'),
(450, 'update_your_profile', 'Edit your Profile', 'Mettre ÃƒÂ  jour votre profil'),
(451, 'email_configue', 'Email Configuration', 'Reglage Email'),
(452, 'protocol', 'Protocol', 'Protocol'),
(453, 'smtp_host', 'SMTP Host', 'host smtp'),
(454, 'smtp_port', 'SMTP Port', 'port smtp'),
(455, 'smtp_pass', 'SMTP Password', 'pass smtp'),
(456, 'mailtype', 'Mail Type', 'Type de mail'),
(457, 'smtp_user', 'SMTP User', 'utilisateur smtp'),
(458, 'html', 'Html', 'HTML'),
(459, 'text', 'Text', 'Texte '),
(460, 'email_send_to_passenger', ' Email Sent Sucessfully', 'Mail envoyÃƒÂ© au passager'),
(461, 'bank', 'Bank Information', 'Banque'),
(462, 'instruction', 'Instruction', 'Instruction'),
(463, 'account_details', 'Account Details', 'Details du compte'),
(464, 'bank_logo', 'Bank Logo', 'Logo banque'),
(465, 'bank_name', 'Bank Name', 'Nom de banque'),
(466, 'bank_trans', 'Bank', 'Transation banque'),
(467, 'transaction_successfully_send', 'Your Information successfully Send', 'Transaction envoyÃƒÂ© avec succÃƒÂ¨s'),
(468, 'confirmation', 'Confirmation', 'Confirmation'),
(469, 'account_no', 'Account No', 'NÃ‚Â° du compte'),
(470, 'transaction_no', 'Transaction No', 'NÃ‚Â° de la transaction'),
(471, 'paypal', 'Paypal', 'Paypal'),
(472, 'cash', 'Cash', 'Cash'),
(473, 'paypal_checkout', 'Paypal Checkout', 'Checkout Paypal'),
(474, 'confirm_banking', 'Confirm Banking', 'Confirmation bancaire'),
(475, 'payment_information', 'Payment Information', 'Informaition de paiement '),
(476, 'email_gritting', 'Congratulation Mr.', 'Email personalisÃƒÂ©'),
(477, 'email_ticket_idinfo', 'Your Purchase Ticket No-', 'ID info email'),
(478, 'ticket_confirmation', 'Unpaid Bank Booking List', 'Confirmation ticket'),
(479, 'deny', 'Deny', 'Rejeter'),
(480, 'confirm', 'CONFIRM', 'Confirmer'),
(481, 'note', 'Note', 'Note'),
(482, 'accournt_no', 'Account Number', 'NÃ‚Â° Compte'),
(483, 'payer_name', 'Payer Name', 'Nom du payeur'),
(484, 'accournt_non', 'Account Number', 'NÃ‚Â° Compte'),
(485, 'confirm_booking', 'Confirm Booking', 'Confirmer la rÃƒÂ©servation'),
(486, 'account_num', 'Account Number', 'NumÃƒÂ©ro du compte'),
(487, 'invalid_logo', 'Invalid Logo, Please upload gif|jpg|png|jpeg|ico type image', 'Logo invalide'),
(488, 'invalid_favicon', 'Invalid Favicon, Please upload gif|jpg|png|jpeg|ico type image', 'Favicon invalide'),
(489, 'print_ticket', 'Print Ticket', 'Imprimmer le ticket'),
(490, 'cancel_ticket', 'Passanger Ticket', 'Annuler le ticket'),
(491, 'email_not_send', 'Email Not Send', 'Email non envoyÃƒÂ©'),
(492, 'timezone', 'Time Zone', 'Fuseau horaire'),
(493, 'menu_permission_form', 'Menu Permission Form', 'Position du formulaire de menu'),
(494, 'permission_setup', 'Permission setup', 'Reglage de permission'),
(495, 'menu_permission_list', 'Menu Permission List', 'Liste de permission menu'),
(496, 'add_fleet_type', 'Add Fleet Type', 'Ajouter type de flotte'),
(497, 'fleet_type_list', 'Fleet Type List', 'LIste type de vÃƒÂ©hicule'),
(498, 'add_facilities', 'Add Facilities', 'Ajouter les facilitÃƒÂ©s'),
(499, 'facilities_list', 'Facilities List', 'Liste de facilitÃƒÂ©s'),
(500, 'add_registration', 'Add Vehicle', 'Ajouter une souscription'),
(501, 'registration_list', 'Vehicle List', 'Liste d\'enregistrement'),
(502, 'refund_list', 'Refund List', 'Liste de remboursement'),
(503, 'add_refund', 'Add Refund', 'Ajouter un remboursement'),
(504, 'booking_list', 'Booking List', 'Liste de reservation'),
(505, 'add_booking', 'Add Booking', 'Ajouter une rÃƒÂ©servation'),
(506, 'passenger_list', 'Passenger List', 'Liste des passagers'),
(507, 'assign_list', 'Assignment List', 'Liste d\'assignation'),
(508, 'close_list', 'Close List', 'Liste fermÃƒÂ©'),
(509, 'add_assign', 'Assign Vehicle To Trip', 'Ajouter une assignation'),
(510, 'route_list', 'Route List', 'Liste de ligne'),
(511, 'add_route', 'Add Route', 'Ajouter une ligne'),
(512, 'location_list', 'Destination List', 'Liste de localisation'),
(513, 'add_location', 'Add Destination', 'Ajouter localisation'),
(514, 'add_role', 'Add Role', 'Ajouter un role'),
(515, 'add_bank', 'Add Bank', 'Ajouter une banque'),
(516, 'bank_list', 'Bank List', 'Liste de banque'),
(517, 'role_name', 'Role Name', 'Nom du role'),
(518, 'role_description', 'Role Description', 'Description du role'),
(519, 'role_list', 'Role List', 'Liste de role'),
(520, 'user_access_role', 'User Access Role', 'Role d\'utilisateur'),
(521, 'role', 'Role', 'Role'),
(522, 'role_permission', 'Role Permission', 'Permission du role'),
(523, 'web_setting', 'Web Setting', 'Reglages web'),
(524, 'ticket_offer', 'Ticket Offer', 'Offre de tickets'),
(525, 'shedules', 'Shedules', 'Horaires'),
(526, 'add_shedule', 'Add Shedule', 'Ajouter un planning'),
(527, 'shedule_list', 'Shedule LIst', 'Liste d\'horaires'),
(528, 'shedule_time', 'Shedule Time', 'Temps de planning'),
(529, 'travel_slogan', 'On the placess you\'ll go', 'Slogan du voyage'),
(530, 'travel_sub_slogan', 'It is not down in any map; true place naver are.', 'Sous slogan du voyage'),
(531, 'search_tour', 'Search Tours', 'Rechercher un voyage'),
(532, 'find_dream', 'Find your dream tour today!', 'Rechercher reve'),
(533, 'find_now', 'Find now!', 'Rechercher maintenant'),
(534, 'start', 'Start', 'Demarrer '),
(535, 'end', 'End', 'Fin'),
(536, 'paypal_payment_paynow', 'PAYPAL PAY NOW', 'Paiement paypal Payer maintenant'),
(537, 'passenger_name', 'Passenger Name', 'Nom du passager'),
(538, 'facilities', 'Facilities', 'FacilitÃƒÂ©s'),
(539, 'seat_name', 'Seat Name', 'Nom du siÃƒÂ¨ge'),
(540, 'adult', 'Adult', 'Adulte'),
(541, 'child', 'Child', 'Enfant'),
(542, 'special', 'Special', 'Special'),
(543, 'grand_total', 'Grand Total', 'Grand Total'),
(544, 'book_for_one_hour', 'Book For One Hour', 'Reserver pour une heure'),
(545, 'unpaid_cash_booking_list', 'Unpaid Cash Booking List', 'Liste des rÃƒÂ©servations non payÃƒÂ©s'),
(546, 'bank_transaction', 'Bank Transaction', 'Transaction de banque'),
(547, 'payment_term_andcondition', 'Payment Terms & Conditions', 'Terms & conditions de paiement'),
(548, 'add_terms', 'Add Terms', 'Ajouter les termes'),
(549, 'terms_list', 'Terms & Condition', 'Liste de termes'),
(550, 'how_to_pay', 'How to Pay', 'Comment Payer'),
(551, 'terms_and_condition', 'Terms And Conditions', 'Termes et conditions'),
(552, 'nid', 'National ID', 'NÃ‚Â° ID'),
(553, 'add_trip', 'Create Trip', 'Ajouter un voyage'),
(554, 'trips', 'Trips', 'Voyages'),
(555, 'trip_list', 'Trip LIst', 'Liste de voyage'),
(556, 'trip_title', 'Trip Title', 'Titre du voyage'),
(557, 'types', 'Types', 'Types'),
(558, 'assigns', 'Assign', 'Assignation'),
(559, 'see_all', 'See All', 'Voir tout'),
(560, 'no_o_ticket', 'NO of Tickts', 'NÃ‚Â° du ticket'),
(561, 'seats', 'Seat(s)', 'SiÃƒÂ¨ges'),
(562, 'prices', 'Price(s)', 'Prix'),
(563, 'group_price', 'Group Price', 'Groupe de prix'),
(564, 'total', 'Total', 'Total'),
(565, 'passenger_details', 'Passenger Details', 'Details du passager'),
(566, 'journey_details', 'Journey Details', 'Details du voyage'),
(567, 'term_n_condition', 'Term & Condition', 'Termes et conditions'),
(568, 'enter_login_info', 'Enter Your Login Info', 'Entrer les infos de connexion'),
(569, 'select_bank_name', 'Select Bank Name', 'Selectionner le nom de la banque'),
(570, 'enter_transaction_id', 'Enter Transaction Id', 'Entrer ID de la transaction'),
(571, 'booked_seat', 'Booked Seat', 'SiÃƒÂ¨ge reservÃƒÂ©'),
(572, 'selected_seat', 'Selected Seat', 'SiÃƒÂ¨ges selectionnÃƒÂ©s'),
(573, 'operator', 'Operator', 'Operateur'),
(574, 'fare', 'Fare', 'Flotte '),
(575, 'arrival', 'Arrival', 'ArrivÃƒÂ©e'),
(576, 'departure', 'Departure', 'DÃƒÂ©part'),
(577, 'duration', 'Duration', 'DurÃƒÂ©e'),
(578, 'no_of_ticket', 'No Of tickets', 'NÃ‚Â° du ticket'),
(579, 'special_fare', 'Special Price', 'Tarif special'),
(580, 'child_fare', 'Children Fare', 'Flotte pour enfant'),
(581, 'adult_fare', 'Adult Fare', 'Tarif Adulte'),
(582, 'ticket_information', 'Ticket Information', 'Information du ticket'),
(583, 'brand_name', 'Brand Name', 'Nom de la marque'),
(584, 'children_seat', 'Children Seat', 'SiÃƒÂ¨ges pour enfant'),
(585, 'special_seat', 'Special Seat', 'SiÃƒÂ¨ge spÃƒÂ©cial'),
(586, 'menu_item_list', 'Menu Item List', 'Liste d\'ÃƒÂ©lÃƒÂ©ment du menu'),
(587, 'parent_menu', 'Parent Menu', 'Menu parent'),
(588, 'page_url', 'Page Url', 'URL de la page'),
(589, 'menu_title', 'Menu title', 'Titre du menu'),
(590, 'ins_menu_for_application', 'Insert Menu for the application', 'Menu instruction pour application'),
(591, 'yearly_progressbar', 'Yearly Progress Bar', 'Bar annuelle de progesssion'),
(592, 'child_price', 'Child Price', 'Prix pour enfant'),
(593, 'adult_price', 'Adult Price', 'Prix adulte'),
(594, 'special_price', 'Special Price', 'Prix spÃƒÂ©cial'),
(595, 'how_to_use', 'HOW TO USE', 'Comment utiliser'),
(596, 'bank_commission', 'Bank Commission', 'Commission de la banque'),
(597, 'bank_charge', 'Bank Charge', 'Facturation de banque'),
(598, 'type', 'Type', 'Type'),
(599, 'amount_paid', 'Amount Paid', 'Montant payÃƒÂ©'),
(600, 'txn_id', 'TXN ID', 'ID tax'),
(601, 'item_number', 'Item Number', 'NumÃƒÂ©ro de l\'ÃƒÂ©lÃƒÂ©ment'),
(602, 'paument_success_message', 'Your Payment Successfully Paid', 'Message de paiement avec succÃƒÂ¨s'),
(603, 'unpaid', 'Unpaid', 'Non payÃƒÂ©'),
(604, 'paid', 'Paid', 'PayÃƒÂ©'),
(605, 'trip_name', 'Trip Name', 'Nom du voyage'),
(606, 'account_number', 'Account Number', 'NumÃƒÂ©ro de compte'),
(607, 'owner_phone', 'Owner Phone No', 'NumÃƒÂ©ro de l\'auteur'),
(608, 'passenger_email', 'Passenger Email', 'Email du passager'),
(609, 'child_no', 'Child', 'NÃ‚Â° de l\'enfant'),
(610, 'close_trip', 'Close Trip', 'Fermer le voyage'),
(611, 'agent_commission', 'Agent Commission', 'Commission agent'),
(612, 'credit', 'Credit', 'CrÃƒÂ©dit'),
(613, 'debit', 'Debit', 'DÃƒÂ©biter'),
(614, 'balance', 'Balance', 'Solde'),
(615, 'agent_log', 'Agent Log', 'Blog agent'),
(616, 'total_ticket', 'Total Ticket', 'Ticket total'),
(617, 'total_amount', 'Total Amount', 'Montant total'),
(618, 'total_commission', 'Total Commission', 'Commission total'),
(619, 'select_agent_name', 'Select Agent Name', 'Selectionner le nom de l\'agent'),
(620, 'commission_amount', 'Commission Amout', 'Montant commission'),
(621, 'total_price', 'Total Price', 'Prix total'),
(622, 'commission_rate', 'Commission Rate', 'Taux de commission'),
(623, 'ticket_sales', 'Ticket Sale', 'Ventes de tickets'),
(624, 'vehicle', 'Vehicle', 'Vehicule'),
(625, 'ticket_sales_report_for', 'Ticket Sales Report For', 'Rapport de vente de tickets pour'),
(626, 'agent_report', 'Agent Report', 'Rapport agent'),
(627, 'agent_ledger', 'Agent Ledger', 'Registre d\'agent'),
(628, 'booking_details', 'Journey Details', 'Details de reservation'),
(630, 'websites', 'Go to Frontend', 'Sites web'),
(631, 'backup_and_download', 'Backup && Download', 'Sauvegarde et tÃƒÂ©lÃƒÂ©chargement'),
(632, 'distance_kmmile', '1 Km/Mile', 'Distance kilometrique'),
(633, 'children', 'Children', 'Enfants'),
(634, 'login_info', 'Login Information', 'Login Information'),
(635, 'please_configure_your_mail', 'Please configure your mail.', 'Please configure your mail.'),
(636, 'error', 'Error', 'Erreur'),
(637, 'settings_not_found', 'No Setting Here', 'Aucun paramÃƒÂ¨tre ici'),
(638, 'location_not_found', 'Location Not Found', ' emplacement non trouvÃƒÂ©'),
(639, 'fleets_not_found', 'Fleets Not Found', 'flotte non trouvÃƒÂ©e'),
(640, 'image_not_found', 'Image Not Found', 'image non trouvÃƒÂ©e'),
(641, 'no_trip_available', 'No Trip Available', 'Aucun voyage disponible'),
(642, 'required_field', 'Fields Are Required ', 'Les champs sont obligatoires'),
(643, 'successfully_login', 'Successfully Loged In', 'connectÃƒÂ© avec succÃƒÂ¨s'),
(644, 'no_data_found', 'No Data Found', 'Aucune donnÃƒÂ©e disponible'),
(645, 'registrantion', 'Registration', 'enregistrement'),
(646, 'forgot_password', 'Forgot Password', 'mot de passe oubliÃƒÂ©'),
(647, 'register', 'Register', ' registre'),
(648, 'location_details', 'Location Details', 'DÃƒÂ©tails de l\'emplacement'),
(649, 'journey_date', 'Journey Date', ' Date de voyage'),
(650, 'select_start_point', 'Select Start Point', 'SÃƒÂ©lectionnez le point de dÃƒÂ©part'),
(651, 'select_end_point', 'Select End Point', ' SÃƒÂ©lectionnez le point final'),
(652, 'select_fleet_type', 'Select Fleet Type', ' SÃƒÂ©lectionnez le type de flotte'),
(653, 'total_seats', 'Total Seats', 'Nombre total de places'),
(654, 'pickup_and_drop', 'Pickup and Drop', 'Pickup and Drop'),
(655, 'select_pickup_location', 'Select Pickup Location', 'SÃƒÂ©lectionnez l\'emplacement de ramassage'),
(656, 'select_drop_location', 'Select Drop Location', 'SÃƒÂ©lectionnez un lieu de dÃƒÂ©pÃƒÂ´t'),
(657, 'tap_to_select_seat', 'Tap To Select Seat', ' Appuyez sur pour sÃƒÂ©lectionner un siÃƒÂ¨ge'),
(658, 'seat_layout', 'Seat Layout', 'Disposition du siÃƒÂ¨ge'),
(659, 'continue', 'Continue', 'continuer'),
(660, 'full_name', 'Full Name', 'Nom complet'),
(661, 'email_address', 'Email Address', ' Adresse ÃƒÂ©lectronique'),
(662, 'journery_details', 'Journey Details', 'DÃƒÂ©tails du voyage'),
(663, 'select_your_payment_method', 'Select Your Payment Method', 'SÃƒÂ©lectionnez le mode de paiement'),
(664, 'bank_transfer', 'Bank Transfer', 'Virement bancaire'),
(665, 'cash_payment', 'Cash Payment', 'Paiement en espÃƒÂ¨ces'),
(666, 'select_your_bank_first', 'Select Bank Name First', 'SÃƒÂ©lectionnez le nom de la banque en premier'),
(667, 'transaction_id', 'Transaction Id', 'Identifiant de transaction'),
(668, 'select_journey_date', 'Select Journey Date', 'SÃƒÂ©lectionnez la date du voyage'),
(669, 'seat_details', 'Seat Details ', 'DÃƒÂ©tails du siÃƒÂ¨ge'),
(670, 'seat_n', 'Seat Number', 'NumÃƒÂ©ro de siÃƒÂ¨ge'),
(671, 'last_name', 'Last Name', 'Nom de famille'),
(672, 'confirm_password', 'Confirm Password', 'Confirmez le mot de passe'),
(673, 'no_facilities_available', 'No facilities Available', 'Aucun ÃƒÂ©quipement disponible'),
(674, 'must_put_email_pass', 'Must Put Email and Password', ' Doit mettre l\'email et le mot de passe'),
(675, 'havn_nt_acc', 'Have n\'t Account', 'Je n\'ai pas de compte'),
(676, 'email_and_password_d_match', 'Email And Password doesn\'t Match', ' Email ou mot de passe ne correspond pas'),
(677, 'must_put_email', 'Must Put Your Email', 'Doit mettre un email'),
(678, 'select_pickup_and_drop_location', 'Select Pickup and Drop Location', ' SÃƒÂ©lectionnez le lieu de ramassage et de dÃƒÂ©pose'),
(679, 'select_your_seat_properly', 'Select Your', 'Choisissez votre siÃƒÂ¨ge correctement'),
(680, 'check_term_and_condition', 'Check Terms and Condition', 'VÃƒÂ©rifier les termes et conditions'),
(681, 'check_your_mail', 'Please Check Your Mail', 'VÃƒÂ©rifier votre courrier'),
(682, 'plz_check_your_seat', 'Please Check Your Seat', 'S\'il vous plaÃƒÂ®t vÃƒÂ©rifier votre siÃƒÂ¨ge'),
(683, 'no_rout_available', 'No rout Available', 'Pas de dÃƒÂ©route disponible'),
(684, 'your_booking_complete', 'Your Booking Successfully Completed', 'Votre rÃƒÂ©servation effectuÃƒÂ©e avec succÃƒÂ¨s'),
(685, 'bank_booking_message', 'Check Bank Name,Transaction ID', 'SÃƒÂ©lectionnez le nom de la banque, l\'identifiant de la transaction'),
(686, 'seat_properly', 'Seat Properly', 'Bien assis'),
(687, 'must_put_atlest_seat_num', 'You Must put Atleast 1 seat on adult/child/Special', 'Vous devez mettre au moins 1 siÃƒÂ¨ge sur adulte / enfant / spÃƒÂ©cial'),
(688, 'paypal_payment', 'Paypal Payment', 'Paiement PayPal'),
(689, 'bank_information', 'Bank Information', ' Information bancaire'),
(690, 'change_select_end_point', '& Change select end point', '& Modifier le point d\'arrivÃƒÂ©e sÃƒÂ©lectionnÃƒÂ©'),
(691, 'must_put_your_mail', 'You must put your email', 'Vous devez mettre votre email'),
(692, 'invalid_email_address', 'Invalid Email Address', 'Adresse e-mail invalide'),
(693, 'plz_check_your_mail_to_reset_passw', 'Please Check Your email to reset Password', 'Please Check Your email to reset Password'),
(694, 'edit_profile', 'EDIT PROFILE', 'EDITER LE PROFIL'),
(695, 'select_profile_image', 'Select Profile Image', 'Enregistrer l\'image de profil'),
(696, 'save_profile', 'Save Profile', 'Enregistrer le profil'),
(697, 'view_profile', 'View Profile', 'Voir le profil'),
(698, 'developed_by_bdtask', 'Developed By BDTASK', ' DÃƒÂ©veloppÃƒÂ© par BDTASK'),
(699, 'use_new_password_to_update_password', 'Use New Password to Update Password', 'Utiliser un nouveau mot de passe pour mettre ÃƒÂ  jour le mot de passe'),
(700, 'pass_username_cant_be_empty', 'Password, First Name, Last Name can\'t empty. Use New password to update password , otherwise type old password', 'Le mot de passe, le prÃƒÂ©nom et le nom de famille ne peuvent pas ÃƒÂªtre vides. Utilisez Nouveau mot de passe pour mettre ÃƒÂ  jour le mot de passe, sinon tapez ancien mot de passe'),
(701, 'no', 'NO', 'NON'),
(702, 'login_again', 'Data Save Successfully. Please Login Again', 'Sauvegarde des donnÃƒÂ©es avec succÃƒÂ¨s. Veuillez vous reconnecter'),
(703, 'payal_information', 'Paypal Payment Information', NULL),
(704, 'payu_payment_info', 'Payu Payment Information', NULL),
(705, 'merchantkey', 'Merchant Key', NULL),
(706, 'salt', 'SALT', NULL),
(707, 'secure_payment', 'Secure Payment', ''),
(708, 'test_payment', 'Test Payment', ''),
(709, 'payu_url', 'Payu Url', NULL),
(710, 'payu_payment_type', 'Payu Payment Type', NULL),
(711, 'rest_api_settings', 'Rest Api Settings', NULL),
(712, 'add_secret_key', 'Add Secret Key', NULL),
(713, 'secret_key_list', 'Secret Key List', ''),
(714, 'secret_key', 'Secret Key', ''),
(715, 'created_by', 'Created By', NULL),
(716, 'created_date', 'Created Date', NULL),
(717, 'key_already_exist', 'Key Already exist', NULL),
(730, 'buy_now', 'Buy Now', NULL),
(814, 'good_job', 'GOOD JOB!', NULL),
(815, 'manage_themes', 'Manage Themes', NULL),
(816, 'purchase_key', 'Purchase Key', NULL),
(817, 'theme_name', 'Theme Name', 'Nom du thème'),
(818, 'upload', 'Upload', NULL),
(819, 'upload_theme', 'Upload Theme', NULL),
(820, 'no_theme_available', 'No Theme Available', NULL),
(821, 'bus365', 'BUS 365', NULL),
(822, 'website2', 'BUS 365 Theme 2', NULL),
(823, 'theme', 'Theme', 'Thème'),
(824, 'addon', 'Addon', NULL),
(825, 'tracking_list', 'Tracking List', NULL),
(826, 'progress', 'Trip Progress (%)', NULL),
(827, 'reached_points', 'Current Position', NULL),
(828, 'arrival_time', 'Arrival Time', 'Arrival Time'),
(829, 'tracking_route_id', 'Route', NULL),
(830, 'tracking_date', 'Tracking Date', ''),
(831, 'tracking_fleet_id', 'Fleet ', ''),
(832, 'delete_tracking', 'Delete Tracking', NULL),
(833, 'edit_tracking', 'Edit Tracking', NULL),
(834, 'tracking', 'Tracking', ''),
(835, 'add_tracking', 'Add Tracking', NULL),
(852, 'luggage', 'Luggage', NULL),
(853, 'luggage_info', 'Luggage Information', NULL),
(854, 'add_luggage', 'Add Luggage', NULL),
(855, 'luggage_list', 'List Luggage', NULL),
(856, 'unpaid_cash_luggage_list', 'Unpaid Cash Luggage List', NULL),
(857, 'luggage_confirmation', 'Unpaid Bank Luggage List', NULL),
(858, 'term_andcondition', 'Terms and Condition', 'Termes et conditions'),
(860, 'total_weight', 'Total Weight', 'Poids total'),
(861, 'total_weight_mean', 'After Carrying passenger, how much load the fleet can carry.', 'l\'entrée Après avoir transporté un passager, combien de charge la flotte peut transporter.  Community Verified icon'),
(862, 'seat_number_textarea', 'Use comma to separate the input', 'Utilisez une virgule pour séparer'),
(863, 'luggage_service', 'Luggage / Parcel Service', NULL),
(864, 'add_luggage_price', 'Add Luggage Price', NULL),
(865, 'price_luggage_list', 'Luggage Price List', NULL),
(866, 'luggage_price', 'Luggage Price', NULL),
(867, 'max_weight', 'Maximum Weight', NULL),
(868, 'min_weight', 'Minimum Weight', NULL),
(869, 'max_weight_limit', 'Maximum Weight Limit', NULL),
(870, 'urgency', 'Urgent Service', NULL),
(871, 'urgency_price', 'Urgency Price', NULL),
(872, 'urgency_price_details', 'This price will be added with regular price.', NULL),
(873, 'update_price', 'Update Price', NULL),
(874, 'total_weight_available', 'Total Weight Available', NULL),
(875, 'times', 'Start & End Time', NULL),
(876, 'weight', 'Weight', NULL),
(877, 'urgent', 'Urgent Service', NULL),
(878, 'luggage_report', 'Luggage Report', NULL),
(879, 'tax', 'Tax', NULL),
(880, 'tax_list', 'Tax List', NULL),
(881, 'tax_settings', 'Tax Settings', NULL),
(882, 'number_of_tax', 'Number Of Tax', NULL),
(883, 'income_tax', 'Income Tax', NULL),
(884, 'manage_income_tax', 'Manage Income Tax', NULL),
(885, 'tax_reports', 'Tax Report', NULL),
(886, 'invoice_wise_tax_report', 'Invoice Wise Income Tax', NULL),
(887, 'setup_tax', 'Setup Tax', NULL),
(888, 'start_amount', 'Start Amount', NULL),
(889, 'end_amount', 'End Amount', NULL),
(890, 'tax_rate', 'Tax Rate', NULL),
(891, 'add_more', 'Add More', NULL),
(892, 'rate', 'Rate', NULL),
(893, 'invoice_no', 'Invoice Number', NULL),
(894, 'print', 'Print', NULL),
(895, 'tax_report', 'Tax Report', NULL),
(896, 'service_id', 'Service ID', NULL),
(897, 'default_value', 'Default Value', NULL),
(898, 'setup', 'Setup', NULL),
(899, 'package_list', 'Package List', NULL),
(900, 'add_package', 'Add Packages', NULL),
(901, 'update_package', 'Update Package', NULL),
(902, 'package_name', 'Package Name', NULL),
(903, 'packages', 'Packages', 'Packages'),
(904, 'package_form', 'Create Package', NULL),
(905, 'weight_limit', 'Weight Limit', NULL),
(906, 'package_price', 'Package Price', NULL),
(907, 'receiver', 'Receiver ', NULL),
(908, 'add_receiver', 'Add Receiver', NULL),
(909, 'sender_email', 'Sender Email', NULL),
(910, 'add_sender', 'Add Sender', NULL),
(911, 'package', 'Package', NULL),
(912, 'total_tax', 'Total Tax', NULL),
(913, 'without_tax', 'Without Tax Price', NULL),
(914, 'sender', 'Sender', NULL),
(915, 'pos_invoice', 'POS INVOICE', 'Receipt An Invoice'),
(916, 'sold_luggage_ticket', 'Sold Luggage Ticket', NULL),
(917, 'tax_type', 'Tax Type', NULL),
(918, 'total_payable', 'Total Payable Amount', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `luggage_booking`
--

DROP TABLE IF EXISTS `luggage_booking`;
CREATE TABLE IF NOT EXISTS `luggage_booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_no` varchar(20) NOT NULL,
  `trip_id_no` varchar(20) NOT NULL,
  `trip_id` int(11) NOT NULL,
  `luggage_passenger_id_no` varchar(20) NOT NULL,
  `trip_route_id` int(11) NOT NULL,
  `pickup_trip_location` varchar(50) DEFAULT NULL,
  `drop_trip_location` varchar(50) DEFAULT NULL,
  `price` float NOT NULL,
  `discount` float DEFAULT NULL,
  `total_weight` float(11,2) DEFAULT NULL,
  `package_id` int(11) NOT NULL,
  `offer_code` varchar(255) DEFAULT NULL,
  `luggage_refund_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `user_info` text DEFAULT NULL,
  `ftypes` int(11) NOT NULL,
  `urgent_status` varchar(10) DEFAULT NULL,
  `urgent_price` float(11,2) DEFAULT NULL,
  `amount` float(11,2) NOT NULL,
  `passenger_email` varchar(250) DEFAULT NULL,
  `sender_id_no` varchar(30) DEFAULT NULL,
  `receiver_id_no` varchar(30) DEFAULT NULL,
  `booking_type` varchar(100) DEFAULT NULL,
  `payment_status` varchar(50) DEFAULT NULL,
  `booked_by` int(11) NOT NULL DEFAULT 0,
  `create_date` timestamp NULL DEFAULT NULL,
  `update_date` timestamp NULL DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `delete_status` tinyint(1) NOT NULL DEFAULT 0,
  `total_tax` float(11,2) DEFAULT NULL,
  `taxids` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `luggage_booking_downtime`
--

DROP TABLE IF EXISTS `luggage_booking_downtime`;
CREATE TABLE IF NOT EXISTS `luggage_booking_downtime` (
  `id` int(11) NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `downtime` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `luggage_price_details`
--

DROP TABLE IF EXISTS `luggage_price_details`;
CREATE TABLE IF NOT EXISTS `luggage_price_details` (
  `luggage_price_details_id` int(11) NOT NULL AUTO_INCREMENT,
  `luggage_price_master_id` int(11) NOT NULL,
  `min_weight` float(11,2) NOT NULL,
  `max_weight` float(11,2) NOT NULL,
  `price` float(11,2) NOT NULL,
  PRIMARY KEY (`luggage_price_details_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `luggage_price_master`
--

DROP TABLE IF EXISTS `luggage_price_master`;
CREATE TABLE IF NOT EXISTS `luggage_price_master` (
  `luggage_price_master_id` int(11) NOT NULL AUTO_INCREMENT,
  `package_name` varchar(250) DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `luggage_referal`
--

DROP TABLE IF EXISTS `luggage_referal`;
CREATE TABLE IF NOT EXISTS `luggage_referal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `luggage_passenger_id_no` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `luggage_refund`
--

DROP TABLE IF EXISTS `luggage_refund`;
CREATE TABLE IF NOT EXISTS `luggage_refund` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `luggage_booking_id_no` varchar(20) DEFAULT NULL,
  `luggage_passenger_id_no` varchar(20) DEFAULT NULL,
  `cancelation_fees` float DEFAULT NULL,
  `causes` text DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `refund_by_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `datetime` datetime NOT NULL,
  `sender_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=unseen, 1=seen, 2=delete',
  `receiver_status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=unseen, 1=seen, 2=delete',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `directory` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `name`, `description`, `image`, `directory`, `status`) VALUES
(1, 'Human Resource', 'Human Resource information module', 'application/modules/human_resource/assets/images/thumbnail.jpg', 'hr', 1),
(2, 'offer', 'Price information', 'application/modules/offer/assets/images/thumbnail.jpg', 'offer', 1),
(3, 'tracking', 'Fleet Tracking', 'application/modules/tracking/assets/images/thumbnail.jpg', 'tracking', 1);

-- --------------------------------------------------------

--
-- Table structure for table `module_permission`
--

DROP TABLE IF EXISTS `module_permission`;
CREATE TABLE IF NOT EXISTS `module_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_module_id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `create` tinyint(1) DEFAULT NULL,
  `read` tinyint(1) DEFAULT NULL,
  `update` tinyint(1) DEFAULT NULL,
  `delete` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `module_purchase_key`
--

DROP TABLE IF EXISTS `module_purchase_key`;
CREATE TABLE IF NOT EXISTS `module_purchase_key` (
  `module_purchase_key_id` int(11) NOT NULL AUTO_INCREMENT,
  `module_identity` varchar(150) NOT NULL,
  `purchase_key` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_date` timestamp NULL DEFAULT current_timestamp(),
  `status` tinyint(1) DEFAULT 0,
  `update_date` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`module_purchase_key_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ofr_offer`
--

DROP TABLE IF EXISTS `ofr_offer`;
CREATE TABLE IF NOT EXISTS `ofr_offer` (
  `offer_id` int(11) NOT NULL AUTO_INCREMENT,
  `offer_name` varchar(100) DEFAULT NULL,
  `offer_start_date` date DEFAULT NULL,
  `offer_end_date` date DEFAULT NULL,
  `offer_code` varchar(50) DEFAULT NULL,
  `offer_discount` float DEFAULT NULL,
  `offer_terms` varchar(30) DEFAULT NULL,
  `offer_route_id` varchar(50) DEFAULT NULL,
  `offer_number` int(15) DEFAULT NULL,
  PRIMARY KEY (`offer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

DROP TABLE IF EXISTS `package`;
CREATE TABLE IF NOT EXISTS `package` (
  `package_id` int(11) NOT NULL AUTO_INCREMENT,
  `package_name` varchar(250) DEFAULT NULL,
  `fleet_type_id` int(11) NOT NULL,
  `trip_route_id` int(11) NOT NULL,
  `max_weight_carry` float(11,2) DEFAULT NULL,
  `urgency_status` int(11) NOT NULL DEFAULT 0,
  `urgent_price_add` float(11,2) NOT NULL,
  `min_weight` float(11,2) NOT NULL,
  `max_weight` float(11,2) NOT NULL,
  `package_price` float(11,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL,
  `delete_status` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`package_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payment_informations`
--

DROP TABLE IF EXISTS `payment_informations`;
CREATE TABLE IF NOT EXISTS `payment_informations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `how_to_pay` text NOT NULL,
  `terms_and_condition` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_tax_setup`
--

DROP TABLE IF EXISTS `payroll_tax_setup`;
CREATE TABLE IF NOT EXISTS `payroll_tax_setup` (
  `tax_setup_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `start_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `end_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `rate` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` varchar(30) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`tax_setup_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pri_price`
--

DROP TABLE IF EXISTS `pri_price`;
CREATE TABLE IF NOT EXISTS `pri_price` (
  `price_id` int(11) NOT NULL AUTO_INCREMENT,
  `route_id` varchar(50) DEFAULT NULL,
  `vehicle_type_id` varchar(50) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `children_price` float NOT NULL,
  `special_price` float NOT NULL,
  `group_price_per_person` float DEFAULT 0,
  `group_size` int(15) DEFAULT 0,
  PRIMARY KEY (`price_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sec_menu_item`
--

DROP TABLE IF EXISTS `sec_menu_item`;
CREATE TABLE IF NOT EXISTS `sec_menu_item` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_title` varchar(200) DEFAULT NULL,
  `page_url` varchar(250) DEFAULT NULL,
  `module` varchar(200) DEFAULT NULL,
  `parent_menu` int(11) DEFAULT NULL,
  `is_report` tinyint(1) DEFAULT NULL,
  `createby` int(11) NOT NULL,
  `createdate` datetime NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sec_menu_item`
--

INSERT INTO `sec_menu_item` (`menu_id`, `menu_title`, `page_url`, `module`, `parent_menu`, `is_report`, `createby`, `createdate`) VALUES
(69, 'account_list', 'account_form', 'account', NULL, 0, 2, '2018-07-16 00:00:00'),
(70, 'Enquiry', 'enquiry/view', 'enquiry', 0, 0, 2, '2018-07-16 00:00:00'),
(71, 'setting', 'enquiry/setting', 'enquiry', NULL, 0, 2, '2018-07-16 00:00:00'),
(72, 'agent_list', 'agent/agent_form', 'agent', NULL, 0, 2, '2018-07-16 00:00:00'),
(73, 'fitness_list', 'fitness/fit_form', 'fitness', NULL, 0, 2, '2018-07-16 00:00:00'),
(74, 'fitness_period', 'fitness/fit_period_form', 'fitness', NULL, 0, 2, '2018-07-16 00:00:00'),
(75, 'fleet_type', '', 'fleet', NULL, 0, 2, '2018-07-16 00:00:00'),
(76, 'add_fleet_type', 'fleet/type/form', 'fleet', 75, 0, 2, '2018-07-16 00:00:00'),
(77, 'fleet_type_list', 'fleet/type/list', 'fleet', 75, 0, 2, '2018-07-16 00:00:00'),
(78, 'fleet_facilities', '', 'fleet', NULL, 0, 2, '2018-07-16 00:00:00'),
(79, 'add_facilities', 'fleet/facilities/form', 'fleet', 78, 0, 2, '2018-07-16 00:00:00'),
(80, 'facilities_list', 'fleet/facilities/list', 'fleet', 78, 0, 2, '2018-07-16 00:00:00'),
(81, 'account_transaction', 'transaction_form', 'account', 0, 0, 2, '2018-07-16 00:00:00'),
(82, 'bank', '', 'account', 0, 0, 2, '2018-07-16 00:00:00'),
(83, 'bank_list', 'account/bank/list', 'account', 82, 0, 2, '2018-07-16 00:00:00'),
(84, 'add_bank', 'account/bank/form', 'account', 82, 0, 2, '2018-07-16 00:00:00'),
(85, 'offer_list', 'offer/offer_form', 'offer', 0, 0, 2, '2018-07-17 00:00:00'),
(86, 'price_list', 'price/price_form', 'price', 0, 0, 2, '2018-07-17 00:00:00'),
(87, 'booking', 'reports/booking/list', 'reports', 130, 0, 2, '2018-07-17 00:00:00'),
(88, 'assign', 'reports/assign/list', 'reports', 130, 0, 2, '2018-07-17 00:00:00'),
(89, 'passenger', '', 'ticket', 0, 0, 2, '2018-07-17 00:00:00'),
(90, 'add_passenger', 'ticket/passenger/form', 'ticket', 89, 0, 2, '2018-07-17 00:00:00'),
(91, 'passenger_list', 'ticket/passenger/list', 'ticket', 89, 0, 2, '2018-07-17 00:00:00'),
(92, 'booking_info', '', 'ticket', 0, 0, 2, '2018-07-17 00:00:00'),
(93, 'add_booking', 'ticket/booking/form', 'ticket', 92, 0, 2, '2018-07-17 00:00:00'),
(94, 'booking_list', 'ticket/booking/list', 'ticket', 92, 0, 2, '2018-07-17 00:00:00'),
(95, 'location', '', 'trip', 0, 0, 2, '2018-07-17 00:00:00'),
(96, 'add_location', 'trip/location/form', 'trip', 95, 0, 2, '2018-07-17 00:00:00'),
(97, 'location_list', 'trip/location/list', 'trip', 95, 0, 2, '2018-07-17 00:00:00'),
(98, 'route', '', 'trip', 0, 0, 2, '2018-07-17 00:00:00'),
(99, 'add_route', 'trip/route/add', 'trip', 98, 0, 2, '2018-07-17 00:00:00'),
(100, 'route_list', 'trip/route/list', 'trip', 98, 0, 2, '2018-07-17 00:00:00'),
(101, 'websites', '', 'website', NULL, 0, 2, '2018-07-18 00:00:00'),
(102, 'web_setting', '', 'website', 0, 0, 2, '2018-07-18 00:00:00'),
(103, 'email_configue', '', 'website', 0, 0, 2, '2018-07-18 00:00:00'),
(104, 'ticket_offer', '', 'website', 0, 0, 2, '2018-07-18 00:00:00'),
(105, 'payment_term_andcondition', '', 'ticket', 0, 0, 2, '2018-07-30 00:00:00'),
(108, 'unpaid_cash_booking_list', 'booking/unpaid_cashbooking', 'ticket', 0, 0, 2, '2018-07-30 00:00:00'),
(109, 'employee_type', 'type_view', 'human_resource', 135, 0, 2, '2018-07-30 00:00:00'),
(110, 'employee_list', 'viewhr', 'human_resource', 135, 0, 2, '2018-07-30 00:00:00'),
(111, 'fleet_registration', 'registration/form', 'fleet', 0, 0, 2, '2018-08-14 00:00:00'),
(112, 'add_registration', 'registration/form', 'fleet', 111, 0, 2, '2018-08-14 00:00:00'),
(113, 'registration_list', 'registration/list', 'fleet', 111, 0, 2, '2018-08-14 00:00:00'),
(114, 'ticket_confirmation', '', 'ticket', 0, 0, 2, '2018-08-14 00:00:00'),
(115, 'refund', '', 'ticket', 0, 0, 2, '2018-08-14 00:00:00'),
(116, 'add_refund', 'refund/form', 'ticket', 115, 0, 2, '2018-08-14 00:00:00'),
(117, 'refund_list', 'refund/list', 'ticket', 115, 0, 2, '2018-08-14 00:00:00'),
(118, 'shedules', '', 'trip', 0, 0, 2, '2018-08-14 00:00:00'),
(119, 'add_shedule', 'shedule/shedule_form', 'trip', 118, 0, 2, '2018-08-14 00:00:00'),
(120, 'shedule_list', 'shedule/list', 'trip', 118, 0, 2, '2018-08-14 00:00:00'),
(121, 'trips', '', 'trip', 0, 0, 2, '2018-08-14 00:00:00'),
(122, 'add_trip', 'trip/form', 'trip', 121, 0, 2, '2018-08-14 00:00:00'),
(123, 'trip_list', 'trip/list', 'trip', 121, 0, 2, '2018-08-14 00:00:00'),
(124, 'assigns', '', 'trip', 0, 0, 2, '2018-08-14 00:00:00'),
(125, 'add_assign', 'assign/form', 'trip', 124, 0, 2, '2018-08-14 00:00:00'),
(126, 'assign_list', 'assign/list', 'trip', 124, 0, 2, '2018-08-14 00:00:00'),
(127, 'close', '', 'trip', 0, 0, 2, '2018-08-14 00:00:00'),
(128, 'close_list', 'close/list', 'trip', 127, 0, 2, '2018-08-14 00:00:00'),
(129, 'account', '', 'account', 0, 0, 2, '2018-08-14 00:00:00'),
(130, 'reports', '', 'reports', 0, 0, 2, '2018-09-11 00:00:00'),
(131, 'agent_log', 'agent/agent_details', 'reports', 130, 0, 2, '2018-09-11 00:00:00'),
(132, 'New  Route', 'trip/route/add', 'trip', 98, 0, 1, '2021-02-28 00:00:00'),
(133, 'module', '', 'addon', 0, 0, 1, '2021-03-07 00:00:00'),
(134, 'Module List', 'addon/module', 'module', 133, 0, 1, '2021-03-07 00:00:00'),
(135, 'human_resource', '', 'human_resource', 0, 0, 1, '2021-03-07 00:00:00'),
(138, 'tracking_list', 'tracking/tracking_controller/tracking_list', 'tracking', 0, 0, 1, '2021-03-09 00:00:00'),
(140, 'module', '', 'addon', NULL, 0, 1, '2021-03-10 00:00:00'),
(141, 'luggage', 'luggage', 'luggage', NULL, 0, 1, '2021-04-07 00:00:00'),
(143, 'add_luggage', 'luggage/luggage/form', 'luggage', 145, 0, 1, '2021-04-07 00:00:00'),
(144, 'luggage_list', 'luggage/luggage/index', 'luggage', 145, 0, 1, '2021-04-07 00:00:00'),
(145, 'luggage_info', 'luggage/luggage/index', 'luggage', 141, 0, 1, '2021-04-07 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sec_role_permission`
--

DROP TABLE IF EXISTS `sec_role_permission`;
CREATE TABLE IF NOT EXISTS `sec_role_permission` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `can_access` tinyint(1) NOT NULL,
  `can_create` tinyint(1) NOT NULL,
  `can_edit` tinyint(1) NOT NULL,
  `can_delete` tinyint(1) NOT NULL,
  `createby` int(11) NOT NULL,
  `createdate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1704 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sec_role_permission`
--

INSERT INTO `sec_role_permission` (`id`, `role_id`, `menu_id`, `can_access`, `can_create`, `can_edit`, `can_delete`, `createby`, `createdate`) VALUES
(1360, 1, 69, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1361, 1, 81, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1362, 1, 82, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1363, 1, 83, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1364, 1, 84, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1365, 1, 129, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1366, 1, 133, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1367, 1, 72, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1368, 1, 70, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1369, 1, 71, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1370, 1, 73, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1371, 1, 74, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1372, 1, 75, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1373, 1, 76, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1374, 1, 77, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1375, 1, 78, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1376, 1, 79, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1377, 1, 80, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1378, 1, 111, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1379, 1, 112, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1380, 1, 113, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1381, 1, 109, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1382, 1, 110, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1383, 1, 135, 0, 0, 0, 0, 1, '2021-03-09 05:48:41'),
(1384, 1, 134, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1385, 1, 85, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1386, 1, 86, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1387, 1, 87, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1388, 1, 88, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1389, 1, 130, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1390, 1, 131, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1391, 1, 89, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1392, 1, 90, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1393, 1, 91, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1394, 1, 92, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1395, 1, 93, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1396, 1, 94, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1397, 1, 105, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1398, 1, 108, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1399, 1, 114, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1400, 1, 115, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1401, 1, 116, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1402, 1, 117, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1403, 1, 136, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1404, 1, 137, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1405, 1, 95, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1406, 1, 96, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1407, 1, 97, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1408, 1, 98, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1409, 1, 99, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1410, 1, 100, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1411, 1, 118, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1412, 1, 119, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1413, 1, 120, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1414, 1, 121, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1415, 1, 122, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1416, 1, 123, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1417, 1, 124, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1418, 1, 125, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1419, 1, 126, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1420, 1, 127, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1421, 1, 128, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1422, 1, 132, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1423, 1, 101, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1424, 1, 102, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1425, 1, 103, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1426, 1, 104, 1, 1, 1, 1, 1, '2021-03-09 05:48:41'),
(1427, 1, 138, 1, 1, 1, 1, 1, '2021-03-09 11:02:41'),
(1633, 2, 69, 1, 0, 0, 0, 1, '2021-04-07 03:41:01'),
(1634, 2, 81, 1, 1, 1, 0, 1, '2021-04-07 03:41:01'),
(1635, 2, 82, 1, 1, 1, 0, 1, '2021-04-07 03:41:01'),
(1636, 2, 83, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1637, 2, 84, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1638, 2, 129, 1, 0, 0, 0, 1, '2021-04-07 03:41:01'),
(1639, 2, 133, 0, 0, 0, 0, 1, '2021-04-07 03:41:01'),
(1640, 2, 140, 0, 0, 0, 0, 1, '2021-04-07 03:41:01'),
(1641, 2, 72, 1, 0, 0, 0, 1, '2021-04-07 03:41:01'),
(1642, 2, 70, 1, 1, 1, 0, 1, '2021-04-07 03:41:01'),
(1643, 2, 71, 0, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1644, 2, 73, 1, 0, 0, 0, 1, '2021-04-07 03:41:01'),
(1645, 2, 74, 1, 0, 0, 0, 1, '2021-04-07 03:41:01'),
(1646, 2, 75, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1647, 2, 76, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1648, 2, 77, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1649, 2, 78, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1650, 2, 79, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1651, 2, 80, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1652, 2, 111, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1653, 2, 112, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1654, 2, 113, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1655, 2, 109, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1656, 2, 110, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1657, 2, 135, 0, 0, 0, 0, 1, '2021-04-07 03:41:01'),
(1658, 2, 141, 1, 1, 1, 0, 1, '2021-04-07 03:41:01'),
(1659, 2, 143, 1, 1, 1, 0, 1, '2021-04-07 03:41:01'),
(1660, 2, 144, 1, 1, 1, 0, 1, '2021-04-07 03:41:01'),
(1661, 2, 145, 1, 1, 1, 0, 1, '2021-04-07 03:41:01'),
(1662, 2, 134, 0, 0, 0, 0, 1, '2021-04-07 03:41:01'),
(1663, 2, 85, 1, 0, 0, 0, 1, '2021-04-07 03:41:01'),
(1664, 2, 86, 1, 1, 1, 0, 1, '2021-04-07 03:41:01'),
(1665, 2, 87, 1, 0, 0, 0, 1, '2021-04-07 03:41:01'),
(1666, 2, 88, 1, 0, 0, 0, 1, '2021-04-07 03:41:01'),
(1667, 2, 130, 1, 1, 1, 1, 1, '2021-04-07 03:41:01'),
(1668, 2, 131, 1, 0, 1, 0, 1, '2021-04-07 03:41:01'),
(1669, 2, 89, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1670, 2, 90, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1671, 2, 91, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1672, 2, 92, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1673, 2, 93, 1, 1, 1, 1, 1, '2021-04-07 03:41:01'),
(1674, 2, 94, 1, 1, 1, 1, 1, '2021-04-07 03:41:01'),
(1675, 2, 105, 1, 1, 1, 0, 1, '2021-04-07 03:41:01'),
(1676, 2, 108, 1, 1, 1, 0, 1, '2021-04-07 03:41:01'),
(1677, 2, 114, 1, 1, 1, 0, 1, '2021-04-07 03:41:01'),
(1678, 2, 115, 1, 1, 1, 0, 1, '2021-04-07 03:41:01'),
(1679, 2, 116, 1, 1, 1, 0, 1, '2021-04-07 03:41:01'),
(1680, 2, 117, 1, 1, 1, 0, 1, '2021-04-07 03:41:01'),
(1681, 2, 138, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1682, 2, 95, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1683, 2, 96, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1684, 2, 97, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1685, 2, 98, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1686, 2, 99, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1687, 2, 100, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1688, 2, 118, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1689, 2, 119, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1690, 2, 120, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1691, 2, 121, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1692, 2, 122, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1693, 2, 123, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1694, 2, 124, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1695, 2, 125, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1696, 2, 126, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1697, 2, 127, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1698, 2, 128, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1699, 2, 132, 0, 0, 0, 0, 1, '2021-04-07 03:41:01'),
(1700, 2, 101, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1701, 2, 102, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1702, 2, 103, 1, 1, 0, 0, 1, '2021-04-07 03:41:01'),
(1703, 2, 104, 1, 1, 0, 0, 1, '2021-04-07 03:41:01');

-- --------------------------------------------------------

--
-- Table structure for table `sec_role_tbl`
--

DROP TABLE IF EXISTS `sec_role_tbl`;
CREATE TABLE IF NOT EXISTS `sec_role_tbl` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` text NOT NULL,
  `role_description` text NOT NULL,
  `create_by` int(11) DEFAULT NULL,
  `date_time` datetime DEFAULT NULL,
  `role_status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sec_role_tbl`
--

INSERT INTO `sec_role_tbl` (`role_id`, `role_name`, `role_description`, `create_by`, `date_time`, `role_status`) VALUES
(1, 'Test Role', 'This is test role', 2, '2018-07-16 02:49:29', 1),
(2, 'Agent Role', 'sjdf', 2, '2018-08-18 11:48:57', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sec_user_access_tbl`
--

DROP TABLE IF EXISTS `sec_user_access_tbl`;
CREATE TABLE IF NOT EXISTS `sec_user_access_tbl` (
  `role_acc_id` int(11) NOT NULL AUTO_INCREMENT,
  `fk_role_id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  PRIMARY KEY (`role_acc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sec_user_access_tbl`
--

INSERT INTO `sec_user_access_tbl` (`role_acc_id`, `fk_role_id`, `fk_user_id`) VALUES
(1, 1, 3),
(2, 1, 1),
(3, 2, 4),
(4, 2, 5),
(5, 2, 8),
(6, 2, 9),
(10, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `language` varchar(100) DEFAULT NULL,
  `site_align` varchar(50) DEFAULT NULL,
  `footer_text` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `title`, `address`, `email`, `phone`, `logo`, `favicon`, `language`, `site_align`, `footer_text`) VALUES
(1, 'Fleet Ticketing System', '98 Green Road, Farmgate, Dhaka-1215.', 'cta.pri.inn@gmail.com', '0178456822', 'assets/img/icons/7675ce24ab90216d8cc0c0dd8a8ec8d6.png', '', 'english', 'LTR', '©2018 bdtask');

-- --------------------------------------------------------

--
-- Table structure for table `shedule`
--

DROP TABLE IF EXISTS `shedule`;
CREATE TABLE IF NOT EXISTS `shedule` (
  `shedule_id` int(11) NOT NULL AUTO_INCREMENT,
  `start` varchar(20) NOT NULL,
  `end` varchar(20) NOT NULL,
  `duration` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`shedule_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `synchronizer_setting`
--

DROP TABLE IF EXISTS `synchronizer_setting`;
CREATE TABLE IF NOT EXISTS `synchronizer_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hostname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `port` varchar(10) NOT NULL,
  `debug` varchar(10) NOT NULL,
  `project_root` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tax_collection`
--

DROP TABLE IF EXISTS `tax_collection`;
CREATE TABLE IF NOT EXISTS `tax_collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `customer_id` varchar(30) NOT NULL,
  `relation_id` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tax_settings`
--

DROP TABLE IF EXISTS `tax_settings`;
CREATE TABLE IF NOT EXISTS `tax_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `default_value` float NOT NULL,
  `tax_name` varchar(250) NOT NULL,
  `nt` int(11) NOT NULL,
  `reg_no` varchar(100) NOT NULL,
  `is_show` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

DROP TABLE IF EXISTS `themes`;
CREATE TABLE IF NOT EXISTS `themes` (
  `themes_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `thumb` text NOT NULL,
  `directory` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `download_details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`themes_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`themes_id`, `name`, `description`, `thumb`, `directory`, `status`, `download_details`, `created_at`, `updated_at`) VALUES
(1, 'theme1', 'asdf', 'application/modules/website/assests/images/bus365.png', 'theme1', 0, NULL, '2021-04-03 09:47:22', '2021-04-03 09:47:22'),
(2, 'theme2', 'asdf752475', 'application/modules/website/assests/images/bus365.png', 'theme2', 0, NULL, '2021-04-03 09:50:14', '2021-04-03 09:50:14'),
(18, 'Bus365', 'Bus365 New theme', '', 'bus365', 1, 'Downloaded from API at 2021-03-24 17:34:34 and Download URL is https://store.bdtask.com/alpha2/downloads/1d286e2c4c30f7f08ce9c5d0ebb0f7cea9ff968f.zip', '2021-04-03 09:50:14', '2021-04-03 09:50:14');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_notification`
--

DROP TABLE IF EXISTS `ticket_notification`;
CREATE TABLE IF NOT EXISTS `ticket_notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `b_idno` varchar(30) NOT NULL,
  `passenger_id` varchar(30) NOT NULL,
  `no_tkts` int(11) NOT NULL,
  `amount` float NOT NULL,
  `route_id` varchar(30) NOT NULL,
  `trip_id` varchar(20) NOT NULL,
  `booking_time` datetime NOT NULL,
  `is_seen` int(11) NOT NULL DEFAULT 0,
  `admin_seen` int(11) NOT NULL DEFAULT 0,
  `booked_by` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=239 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tkt_booking`
--

DROP TABLE IF EXISTS `tkt_booking`;
CREATE TABLE IF NOT EXISTS `tkt_booking` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_no` varchar(20) DEFAULT NULL,
  `trip_id_no` varchar(20) DEFAULT NULL,
  `tkt_passenger_id_no` varchar(20) DEFAULT NULL,
  `trip_route_id` int(11) DEFAULT NULL,
  `pickup_trip_location` varchar(50) DEFAULT NULL,
  `drop_trip_location` varchar(50) DEFAULT NULL,
  `request_facilities` text DEFAULT NULL,
  `price` float DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `amount` float(11,2) NOT NULL,
  `adult` int(11) NOT NULL DEFAULT 0,
  `child` int(11) NOT NULL DEFAULT 0,
  `special` int(11) NOT NULL DEFAULT 0,
  `total_seat` int(11) DEFAULT NULL,
  `seat_numbers` varchar(255) DEFAULT NULL,
  `offer_code` varchar(255) DEFAULT NULL,
  `tkt_refund_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `booking_type` varchar(20) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT NULL,
  `booked_by` int(11) NOT NULL DEFAULT 0,
  `booking_delete_status` tinyint(1) NOT NULL DEFAULT 0,
  `total_tax` float(11,2) DEFAULT NULL,
  `taxids` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_no` (`id_no`)
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tkt_feedback`
--

DROP TABLE IF EXISTS `tkt_feedback`;
CREATE TABLE IF NOT EXISTS `tkt_feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tkt_booking_id_no` varchar(20) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `rating` tinyint(1) DEFAULT 1,
  `add_to_website` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tkt_passenger`
--

DROP TABLE IF EXISTS `tkt_passenger`;
CREATE TABLE IF NOT EXISTS `tkt_passenger` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_no` varchar(20) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `nid` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `password_reset_token` varchar(20) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `address_line_1` varchar(255) DEFAULT NULL,
  `address_line_2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `country` varchar(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tkt_referal`
--

DROP TABLE IF EXISTS `tkt_referal`;
CREATE TABLE IF NOT EXISTS `tkt_referal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tkt_passenger_id_no` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tkt_refund`
--

DROP TABLE IF EXISTS `tkt_refund`;
CREATE TABLE IF NOT EXISTS `tkt_refund` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tkt_booking_id_no` varchar(20) DEFAULT NULL,
  `tkt_passenger_id_no` varchar(20) DEFAULT NULL,
  `cancelation_fees` float DEFAULT NULL,
  `causes` text DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `refund_by_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tkt_refund_tkt_booking` (`tkt_booking_id_no`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tracking`
--

DROP TABLE IF EXISTS `tracking`;
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

-- --------------------------------------------------------

--
-- Table structure for table `trip`
--

DROP TABLE IF EXISTS `trip`;
CREATE TABLE IF NOT EXISTS `trip` (
  `trip_id` int(11) NOT NULL AUTO_INCREMENT,
  `trip_title` varchar(200) NOT NULL,
  `type` int(11) NOT NULL,
  `route` int(11) NOT NULL,
  `shedule_id` int(11) NOT NULL,
  `weekend` varchar(50) DEFAULT '0',
  `status` int(11) NOT NULL,
  PRIMARY KEY (`trip_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `trip_assign`
--

DROP TABLE IF EXISTS `trip_assign`;
CREATE TABLE IF NOT EXISTS `trip_assign` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_no` varchar(20) DEFAULT NULL,
  `fleet_registration_id` int(11) DEFAULT NULL,
  `trip` varchar(30) NOT NULL,
  `assign_time` datetime NOT NULL,
  `driver_id` int(11) DEFAULT NULL,
  `assistant_1` varchar(30) DEFAULT NULL,
  `assistant_2` varchar(30) DEFAULT NULL,
  `assistant_3` varchar(30) DEFAULT NULL,
  `sold_ticket` float NOT NULL DEFAULT 0,
  `total_income` float DEFAULT 0,
  `total_expense` float DEFAULT 0,
  `total_fuel` float DEFAULT 0,
  `trip_comment` text DEFAULT NULL,
  `closed_by_id` int(11) DEFAULT 0,
  `date` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `trip_location`
--

DROP TABLE IF EXISTS `trip_location`;
CREATE TABLE IF NOT EXISTS `trip_location` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `google_map` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `trip_route`
--

DROP TABLE IF EXISTS `trip_route`;
CREATE TABLE IF NOT EXISTS `trip_route` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `start_point` varchar(255) DEFAULT NULL,
  `end_point` varchar(255) DEFAULT NULL,
  `stoppage_points` varchar(355) DEFAULT NULL COMMENT 'Location ids',
  `distance` varchar(30) DEFAULT NULL,
  `approximate_time` varchar(100) DEFAULT NULL,
  `children_seat` int(11) NOT NULL DEFAULT 0,
  `special_seat` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `about` text DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
  `password_reset_token` varchar(20) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_logout` datetime DEFAULT NULL,
  `ip_address` varchar(14) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `is_admin` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `about`, `email`, `password`, `password_reset_token`, `image`, `last_login`, `last_logout`, `ip_address`, `status`, `is_admin`) VALUES
(1, 'BUS DEMO', '5 ADMIN', NULL, 'master@admin.com', 'e10adc3949ba59abbe56e057f20f883e', '', NULL, '2021-04-21 23:10:34', '2021-04-19 00:17:08', '127.0.0.1', 1, 1),
(2, 'Admin', 'Agent', 'asdfadsfasdf', 'admin@agent.com', '4297f44b13955235245b2497399d7a93', '', './assets/img/user/34ba949d9debfcb19beb9c09171570f0.jpg', '2021-04-13 10:44:44', '2021-04-13 10:44:50', '127.0.0.1', 1, 0),
(3, 'SH', 'R', NULL, 'admin@user.com', '4297f44b13955235245b2497399d7a93', '', NULL, '2021-04-13 10:44:34', '2021-04-13 10:44:38', '127.0.0.1', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ws_booking_history`
--

DROP TABLE IF EXISTS `ws_booking_history`;
CREATE TABLE IF NOT EXISTS `ws_booking_history` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_no` varchar(20) DEFAULT NULL,
  `trip_id_no` varchar(20) DEFAULT NULL,
  `tkt_passenger_id_no` varchar(20) DEFAULT NULL,
  `trip_route_id` int(11) DEFAULT NULL,
  `pickup_trip_location` varchar(50) DEFAULT NULL,
  `drop_trip_location` varchar(50) DEFAULT NULL,
  `request_facilities` text DEFAULT NULL,
  `price` float DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `adult` int(11) NOT NULL,
  `child` int(11) NOT NULL,
  `special` int(11) NOT NULL,
  `total_seat` int(11) DEFAULT NULL,
  `seat_numbers` varchar(255) DEFAULT NULL,
  `offer_code` varchar(255) DEFAULT NULL,
  `tkt_refund_id` int(11) DEFAULT NULL,
  `agent_id` int(11) DEFAULT NULL,
  `booking_date` datetime DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_no` (`id_no`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ws_offer`
--

DROP TABLE IF EXISTS `ws_offer`;
CREATE TABLE IF NOT EXISTS `ws_offer` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `position` tinyint(4) DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ws_payments`
--

DROP TABLE IF EXISTS `ws_payments`;
CREATE TABLE IF NOT EXISTS `ws_payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `txn_id` varchar(255) NOT NULL,
  `payment_gross` float(10,2) NOT NULL,
  `currency_code` varchar(5) NOT NULL,
  `payer_email` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ws_setting`
--

DROP TABLE IF EXISTS `ws_setting`;
CREATE TABLE IF NOT EXISTS `ws_setting` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `slogan` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `timezone` varchar(200) DEFAULT NULL,
  `about` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `payment_type` varchar(30) DEFAULT NULL,
  `paypal_email` varchar(100) DEFAULT NULL,
  `bank_commission` float NOT NULL DEFAULT 0,
  `currency` varchar(50) DEFAULT NULL,
  `google_map` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ws_setting`
--

INSERT INTO `ws_setting` (`id`, `title`, `slogan`, `address`, `email`, `phone`, `favicon`, `logo`, `status`, `timezone`, `about`, `description`, `payment_type`, `paypal_email`, `bank_commission`, `currency`, `google_map`) VALUES
(1, 'Bus 365', 'Bus 365', '123, demo street, demo-city, 0000', 'business@test.com', '0123456789', 'application/modules/bus365/assets/images/icons/99284ecb2dda1f0ab75a718bc9ea16de.jpg', 'application/modules/website/assets/images/icons/fa8bb02569d51cbfcb2f14f06ae3f260.jpg', 1, 'Asia/Dhaka', 'BUS TICKET', '<p>YOU CAN BUY YOUR BUS TICKET FROM HERE. JUST SEARCH YOUR TICKET AND BOOK YOUR SEAT.</p>', 'disable', 'business@test.com', 3, '৳', 'GOOGLE MAP\r\n');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
