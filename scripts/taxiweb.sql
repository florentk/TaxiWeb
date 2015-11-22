-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Dim 22 Novembre 2015 à 01:27
-- Version du serveur: 5.5.46-0ubuntu0.14.04.2
-- Version de PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `taxiweb`
--
CREATE DATABASE IF NOT EXISTS `taxiweb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `taxiweb`;

-- --------------------------------------------------------

--
-- Structure de la table `tw_address`
--

DROP TABLE IF EXISTS `tw_address`;
CREATE TABLE IF NOT EXISTS `tw_address` (
  `address_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `way` varchar(50) DEFAULT NULL,
  `num` smallint(6) DEFAULT NULL,
  `other` varchar(100) DEFAULT NULL,
  `city` varchar(20) DEFAULT 'Lille',
  `zip` varchar(10) DEFAULT NULL,
  `latitude` varchar(20) DEFAULT NULL,
  `longitude` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `tw_address`
--

INSERT INTO `tw_address` (`address_id`, `name`, `way`, `num`, `other`, `city`, `zip`, `latitude`, `longitude`) VALUES
(1, 'LILLE.BIKE', 'avenue du président hoover', 20, 'appartement 26', 'Lille', '59800', '50.627993', '3.0777502'),
(2, 'Biovino', 'Place Sébastopol', 3, NULL, 'Lille', '59000', NULL, NULL),
(3, 'Mr Durand', 'rue nationnal', 259, NULL, 'Lille', '59000', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tw_bicycle`
--

DROP TABLE IF EXISTS `tw_bicycle`;
CREATE TABLE IF NOT EXISTS `tw_bicycle` (
  `bicycle_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `num` int(11) NOT NULL,
  `pilot` varchar(20) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '0',
  `fleet_id` bigint(20) NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `access_code` char(64) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `back_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`bicycle_id`),
  KEY `fleet_id` (`fleet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `tw_bicycle`
--

INSERT INTO `tw_bicycle` (`bicycle_id`, `num`, `pilot`, `state`, `fleet_id`, `latitude`, `longitude`, `access_code`, `start_time`, `back_time`) VALUES
(1, 1, 'florent', 1, 1, 50.6335574, 3.0808253, 'dd73d68d81aba5389d516ee31698af1d', '2015-11-12 08:00:00', '2015-11-11 13:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `tw_bicycle_states`
--

DROP TABLE IF EXISTS `tw_bicycle_states`;
CREATE TABLE IF NOT EXISTS `tw_bicycle_states` (
  `id` tinyint(4) NOT NULL,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `tw_bicycle_states`
--

INSERT INTO `tw_bicycle_states` (`id`, `name`) VALUES
(0, 'garage'),
(1, 'free'),
(2, 'busy'),
(3, 'sos');

-- --------------------------------------------------------

--
-- Structure de la table `tw_customers`
--

DROP TABLE IF EXISTS `tw_customers`;
CREATE TABLE IF NOT EXISTS `tw_customers` (
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `firm_name` varchar(20) DEFAULT NULL,
  `firm_num` varchar(20) DEFAULT NULL,
  `service` varchar(20) DEFAULT NULL,
  `address_id` bigint(20) DEFAULT NULL,
  `customer_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tel1` varchar(15) DEFAULT NULL,
  `tel2` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `tw_customers`
--

INSERT INTO `tw_customers` (`first_name`, `last_name`, `firm_name`, `firm_num`, `service`, `address_id`, `customer_id`, `tel1`, `tel2`, `email`) VALUES
('Biovino', NULL, NULL, NULL, NULL, 2, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `tw_fleets`
--

DROP TABLE IF EXISTS `tw_fleets`;
CREATE TABLE IF NOT EXISTS `tw_fleets` (
  `fleet_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `password` char(64) NOT NULL,
  `address_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`fleet_id`),
  KEY `address_id` (`address_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `tw_fleets`
--

INSERT INTO `tw_fleets` (`fleet_id`, `name`, `password`, `address_id`) VALUES
(1, 'LILLE.BIKE', '01b0fd027f8764f9c069506b8de8bf2e', 1);

-- --------------------------------------------------------

--
-- Structure de la table `tw_journey`
--

DROP TABLE IF EXISTS `tw_journey`;
CREATE TABLE IF NOT EXISTS `tw_journey` (
  `journey_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `bicycle_id` bigint(20) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `start_address_id` bigint(20) NOT NULL,
  `destination_address_id` bigint(20) DEFAULT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_time` timestamp NULL DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`journey_id`),
  KEY `customer_id` (`customer_id`,`start_address_id`,`destination_address_id`),
  KEY `start_address_id` (`start_address_id`),
  KEY `destination_address_id` (`destination_address_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `tw_journey`
--

INSERT INTO `tw_journey` (`journey_id`, `bicycle_id`, `customer_id`, `start_address_id`, `destination_address_id`, `start_time`, `end_time`, `state`) VALUES
(1, 1, 1, 2, 3, '2015-11-12 09:30:00', '2015-11-12 10:00:00', 0),
(2, 1, 1, 2, 1, '2015-11-19 19:36:40', '2015-11-19 20:00:00', 2);

-- --------------------------------------------------------

--
-- Structure de la table `tw_journey_states`
--

DROP TABLE IF EXISTS `tw_journey_states`;
CREATE TABLE IF NOT EXISTS `tw_journey_states` (
  `id` tinyint(4) NOT NULL,
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `tw_journey_states`
--

INSERT INTO `tw_journey_states` (`id`, `name`) VALUES
(0, 'pending'),
(1, 'request bicycle'),
(2, 'in progress'),
(3, 'ended');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `tw_manager_bicycle_states_view`
--
DROP VIEW IF EXISTS `tw_manager_bicycle_states_view`;
CREATE TABLE IF NOT EXISTS `tw_manager_bicycle_states_view` (
`bicycle_id` bigint(20)
,`num` int(11)
,`pilot` varchar(20)
,`state` varchar(20)
,`latitude` double
,`longitude` double
,`start_time` timestamp
,`back_time` timestamp
);
-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `tw_manager_current_journey_view`
--
DROP VIEW IF EXISTS `tw_manager_current_journey_view`;
CREATE TABLE IF NOT EXISTS `tw_manager_current_journey_view` (
`pilot` varchar(20)
,`client` varchar(20)
,`start` varchar(79)
,`destination` varchar(79)
,`start_time` timestamp
,`end_time` timestamp
,`state` varchar(20)
);
-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `tw_pilot_view`
--
DROP VIEW IF EXISTS `tw_pilot_view`;
CREATE TABLE IF NOT EXISTS `tw_pilot_view` (
`bicycle_id` bigint(20)
,`journey_id` bigint(20)
,`client` varchar(20)
,`start` varchar(79)
,`destination` varchar(79)
,`start_time` timestamp
,`end_time` timestamp
,`state` tinyint(4)
);
-- --------------------------------------------------------

--
-- Structure de la vue `tw_manager_bicycle_states_view`
--
DROP TABLE IF EXISTS `tw_manager_bicycle_states_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tw_manager_bicycle_states_view` AS select `b`.`bicycle_id` AS `bicycle_id`,`b`.`num` AS `num`,`b`.`pilot` AS `pilot`,`b_state`.`name` AS `state`,`b`.`latitude` AS `latitude`,`b`.`longitude` AS `longitude`,`b`.`start_time` AS `start_time`,`b`.`back_time` AS `back_time` from ((`tw_bicycle` `b` join `tw_fleets` `f` on((`f`.`fleet_id` = `b`.`fleet_id`))) join `tw_bicycle_states` `b_state` on((`b`.`state` = `b_state`.`id`)));

-- --------------------------------------------------------

--
-- Structure de la vue `tw_manager_current_journey_view`
--
DROP TABLE IF EXISTS `tw_manager_current_journey_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tw_manager_current_journey_view` AS select `b`.`pilot` AS `pilot`,`c`.`first_name` AS `client`,concat(`s`.`num`,' ',`s`.`way`,', ',`s`.`city`) AS `start`,concat(`d`.`num`,' ',`d`.`way`,', ',`d`.`city`) AS `destination`,`j`.`start_time` AS `start_time`,`j`.`end_time` AS `end_time`,`j_state`.`name` AS `state` from (((((`tw_journey` `j` join `tw_customers` `c` on((`j`.`customer_id` = `c`.`customer_id`))) join `tw_address` `s` on((`j`.`start_address_id` = `s`.`address_id`))) join `tw_address` `d` on((`j`.`destination_address_id` = `d`.`address_id`))) join `tw_bicycle` `b` on((`j`.`bicycle_id` = `b`.`bicycle_id`))) join `tw_journey_states` `j_state` on((`j`.`state` = `j_state`.`id`))) where (`j`.`state` <> 3);

-- --------------------------------------------------------

--
-- Structure de la vue `tw_pilot_view`
--
DROP TABLE IF EXISTS `tw_pilot_view`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `tw_pilot_view` AS select `j`.`bicycle_id` AS `bicycle_id`,`j`.`journey_id` AS `journey_id`,`c`.`first_name` AS `client`,concat(ifnull(`s`.`num`,''),' ',ifnull(`s`.`way`,''),', ',ifnull(`s`.`city`,'')) AS `start`,concat(ifnull(`d`.`num`,''),' ',ifnull(`d`.`way`,''),', ',ifnull(`d`.`city`,'')) AS `destination`,`j`.`start_time` AS `start_time`,`j`.`end_time` AS `end_time`,`j`.`state` AS `state` from (((`tw_journey` `j` join `tw_customers` `c` on((`j`.`customer_id` = `c`.`customer_id`))) join `tw_address` `s` on((`j`.`start_address_id` = `s`.`address_id`))) join `tw_address` `d` on((`j`.`destination_address_id` = `d`.`address_id`))) where (`j`.`state` <> 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
