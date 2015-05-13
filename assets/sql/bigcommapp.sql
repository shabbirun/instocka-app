-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 01-09-2014 a las 22:37:05
-- Versión del servidor: 5.5.24-log
-- Versión de PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `bigcommapp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cronjob`
--

CREATE TABLE IF NOT EXISTS `cronjob` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_product_id` int(11) NOT NULL,
  `flag` char(1) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `user_login_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_login_id` (`user_login_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Volcado de datos para la tabla `customer`
--

INSERT INTO `customer` (`id`, `first_name`, `last_name`, `email`, `user_login_id`, `created_at`) VALUES
(21, 'miglio', 'esaud', 'mig1098@hotmail.com', 29, '2014-08-19 00:00:00'),
(22, 'contact', 'contact', 'contact@apolomultimedia.com', 29, '2014-11-25 00:00:00'),
(23, 'jimmy', 'sales', 'sales1@apolomultimedia.com', 29, '2014-11-19 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `custom_mail`
--

CREATE TABLE IF NOT EXISTS `custom_mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_custom_mail` varchar(50) NOT NULL,
  `from_email` varchar(100) NOT NULL,
  `from_name` varchar(100) NOT NULL,
  `subject` varchar(300) NOT NULL,
  `body` longtext NOT NULL,
  `header_image` text NOT NULL,
  `header_bg` varchar(10) NOT NULL,
  `footer` text NOT NULL,
  `footer_bg` varchar(10) NOT NULL,
  `user_login_id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_login_id` (`user_login_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Volcado de datos para la tabla `custom_mail`
--

INSERT INTO `custom_mail` (`id`, `name_custom_mail`, `from_email`, `from_name`, `subject`, `body`, `header_image`, `header_bg`, `footer`, `footer_bg`, `user_login_id`, `date`) VALUES
(28, 'custom_mail', 'programmer1@apolomultimedia.com', 'test', '', '', '', '', '', '', 29, '2014-08-26 17:10:49'),
(29, 'custom_mail', 'programmer1@apolomultimedia.com', 'test', '', '', '', '', '', '', 30, '2014-08-26 17:52:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mailchimp`
--

CREATE TABLE IF NOT EXISTS `mailchimp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_custom_mail` varchar(100) NOT NULL,
  `list_name` varchar(100) NOT NULL,
  `list_id` varchar(100) NOT NULL,
  `list_web_id` int(11) NOT NULL,
  `campaign_name` varchar(200) NOT NULL,
  `user_login_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_login_id` (`user_login_id`),
  KEY `user_login_id_2` (`user_login_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Volcado de datos para la tabla `mailchimp`
--

INSERT INTO `mailchimp` (`id`, `name_custom_mail`, `list_name`, `list_id`, `list_web_id`, `campaign_name`, `user_login_id`, `date`) VALUES
(28, 'mailchimp', '', '', 0, '', 29, '2014-08-26 17:10:49'),
(29, 'mailchimp', '', '', 0, '', 30, '2014-08-26 17:52:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `option_mail`
--

CREATE TABLE IF NOT EXISTS `option_mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `option_check` char(1) NOT NULL,
  `user_login_id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_login_id` (`user_login_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Volcado de datos para la tabla `option_mail`
--

INSERT INTO `option_mail` (`id`, `name`, `option_check`, `user_login_id`, `date`) VALUES
(55, 'custom_mail', 'y', 29, '2014-08-26 17:10:49'),
(56, 'mailchimp', 'n', 29, '2014-08-26 17:10:49'),
(57, 'custom_mail', 'y', 30, '2014-08-26 17:52:47'),
(58, 'mailchimp', 'n', 30, '2014-08-26 17:52:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `product_title` varchar(200) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sent` varchar(1) NOT NULL DEFAULT 'n',
  `user_login_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_login_id` (`user_login_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`id`, `customer_id`, `product_title`, `product_id`, `sent`, `user_login_id`, `created_at`, `updated_at`) VALUES
(29, 21, '[Sample] Chanel, the cheetah', 75, 'n', 29, '2014-08-30 00:00:00', '0000-00-00 00:00:00'),
(30, 22, '[Sample] Coco Lee, gladiator bag', 72, 'n', 29, '2014-08-20 00:00:00', '0000-00-00 00:00:00'),
(31, 21, '[Sample] Coco Lee, gladiator bag', 72, 'n', 29, '2014-08-08 00:00:00', '0000-00-00 00:00:00'),
(32, 23, '[Sample] Coco Lee, gladiator bag', 72, 'n', 29, '2014-08-27 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `test_data`
--

CREATE TABLE IF NOT EXISTS `test_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `test_data`
--

INSERT INTO `test_data` (`id`, `data`, `date`) VALUES
(7, 'get: post:', '2014-08-25 20:37:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_login`
--

CREATE TABLE IF NOT EXISTS `user_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_token_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `password` varchar(300) NOT NULL,
  `store` varchar(200) NOT NULL,
  `store_url` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `BIGCOMM_API_TOKEN` varchar(100) NOT NULL,
  `BIGCOMM_PATH` text NOT NULL,
  `BIGCOMM_USERNAME` varchar(200) NOT NULL,
  `name_login` varchar(100) DEFAULT NULL COMMENT 'login out bigcommerce',
  `password_login` varchar(100) DEFAULT NULL COMMENT 'login out bigcommerce',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Volcado de datos para la tabla `user_login`
--

INSERT INTO `user_login` (`id`, `user_token_id`, `name`, `password`, `store`, `store_url`, `email`, `BIGCOMM_API_TOKEN`, `BIGCOMM_PATH`, `BIGCOMM_USERNAME`, `name_login`, `password_login`) VALUES
(29, 35, 'programmer1@apolomultimedia.com', 'g9fhhw1xcq3kgixy177o53q1q1b8hr', 'test', 'apolotest.mybigcommerce.com', 'programmer1@apolomultimedia.com', '', '', '', 'apolo3000', 'apolo3000'),
(30, 36, 'programmer1@apolomultimedia.com', 'deob04yez92rbtopd770245znwnvm9e', 'test', 'apolo2.mybigcommerce.com', 'programmer1@apolomultimedia.com', '', '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_token`
--

CREATE TABLE IF NOT EXISTS `user_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access_token` varchar(200) NOT NULL,
  `scope` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_username` varchar(200) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `context` varchar(200) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Volcado de datos para la tabla `user_token`
--

INSERT INTO `user_token` (`id`, `access_token`, `scope`, `user_id`, `user_username`, `user_email`, `context`, `date`) VALUES
(35, 'g9fhhw1xcq3kgixy177o53q1q1b8hr', 'store_v2_products_read_only store_v2_information_read_only users_basic_information', 217150, 'programmer1@apolomultimedia.com', 'programmer1@apolomultimedia.com', 'stores/g1wmq', '2014-08-26 17:10:48'),
(36, 'deob04yez92rbtopd770245znwnvm9e', 'store_v2_products_read_only store_v2_information_read_only users_basic_information', 217150, 'programmer1@apolomultimedia.com', 'programmer1@apolomultimedia.com', 'stores/qq6db7r', '2014-08-26 17:52:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `webhook`
--

CREATE TABLE IF NOT EXISTS `webhook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `webhook_id` int(11) NOT NULL,
  `user_login_id` int(11) NOT NULL,
  `scope` varchar(200) NOT NULL,
  `destination` text NOT NULL,
  `is_active` varchar(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_login_id` (`user_login_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `webhook`
--

INSERT INTO `webhook` (`id`, `webhook_id`, `user_login_id`, `scope`, `destination`, `is_active`) VALUES
(5, 1895, 29, 'store/product/updated', 'https://apolomultimedia.us/bigcomm_app/cronjob-webhook-29', '1'),
(6, 1897, 30, 'store/product/updated', 'https://apolomultimedia.us/bigcomm_app/cronjob-webhook-30', '1');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `fk_customer` FOREIGN KEY (`user_login_id`) REFERENCES `user_login` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `custom_mail`
--
ALTER TABLE `custom_mail`
  ADD CONSTRAINT `fk_custom_mail` FOREIGN KEY (`user_login_id`) REFERENCES `user_login` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `mailchimp`
--
ALTER TABLE `mailchimp`
  ADD CONSTRAINT `fk_mailchimp` FOREIGN KEY (`user_login_id`) REFERENCES `user_login` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `option_mail`
--
ALTER TABLE `option_mail`
  ADD CONSTRAINT `fk_option_mail` FOREIGN KEY (`user_login_id`) REFERENCES `user_login` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`user_login_id`) REFERENCES `user_login` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `webhook`
--
ALTER TABLE `webhook`
  ADD CONSTRAINT `fk_webhook` FOREIGN KEY (`user_login_id`) REFERENCES `user_login` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
