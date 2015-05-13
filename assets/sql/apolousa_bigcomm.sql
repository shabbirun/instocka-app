-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 02-09-2014 a las 10:12:13
-- Versión del servidor: 5.5.36-cll
-- Versión de PHP: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `apolousa_bigcomm`
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
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_login_id` (`user_login_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Volcado de datos para la tabla `customer`
--

INSERT INTO `customer` (`id`, `first_name`, `last_name`, `email`, `user_login_id`, `created_at`, `updated_at`) VALUES
(27, 'programmer', 'programmer1', 'programmer1@apolomultimedia.com', 34, '2014-09-02 09:44:32', '0000-00-00 00:00:00'),
(28, 'miglio', 'esuad', 'mig1098@hotmail.com', 34, '2014-09-02 09:53:19', '2014-09-02 10:00:28');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Volcado de datos para la tabla `custom_mail`
--

INSERT INTO `custom_mail` (`id`, `name_custom_mail`, `from_email`, `from_name`, `subject`, `body`, `header_image`, `header_bg`, `footer`, `footer_bg`, `user_login_id`, `date`) VALUES
(33, 'custom_mail', 'programmer1@apolomultimedia.com', 'test', '', '', '', '', '', '', 34, '2014-09-01 23:23:52');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Volcado de datos para la tabla `mailchimp`
--

INSERT INTO `mailchimp` (`id`, `name_custom_mail`, `list_name`, `list_id`, `list_web_id`, `campaign_name`, `user_login_id`, `date`) VALUES
(33, 'mailchimp', '', '', 0, '', 34, '2014-09-01 23:23:52');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

--
-- Volcado de datos para la tabla `option_mail`
--

INSERT INTO `option_mail` (`id`, `name`, `option_check`, `user_login_id`, `date`) VALUES
(65, 'custom_mail', 'y', 34, '2014-09-01 23:23:52'),
(66, 'mailchimp', 'n', 34, '2014-09-01 23:23:52');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`id`, `customer_id`, `product_title`, `product_id`, `sent`, `user_login_id`, `created_at`, `updated_at`) VALUES
(36, 27, 'Side Contour Floor Kit (Dual Cabs)', 76, 'n', 34, '2014-09-02 09:44:32', '0000-00-00 00:00:00'),
(37, 28, 'Side Contour Floor Kit (Dual Cabs)', 76, 'n', 34, '2014-09-02 09:53:19', '2014-09-02 10:00:28');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Volcado de datos para la tabla `user_login`
--

INSERT INTO `user_login` (`id`, `user_token_id`, `name`, `password`, `store`, `store_url`, `email`, `BIGCOMM_API_TOKEN`, `BIGCOMM_PATH`, `BIGCOMM_USERNAME`, `name_login`, `password_login`) VALUES
(34, 40, 'programmer1@apolomultimedia.com', 'g3brig44hchx27pnrcfjirl3c0o1vkm', 'test', 'apolotest.mybigcommerce.com', 'programmer1@apolomultimedia.com', '', '', '', NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Volcado de datos para la tabla `user_token`
--

INSERT INTO `user_token` (`id`, `access_token`, `scope`, `user_id`, `user_username`, `user_email`, `context`, `date`) VALUES
(40, 'g3brig44hchx27pnrcfjirl3c0o1vkm', 'store_v2_products_read_only store_v2_information_read_only users_basic_information', 217150, 'programmer1@apolomultimedia.com', 'programmer1@apolomultimedia.com', 'stores/g1wmq', '2014-09-01 23:23:51');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Volcado de datos para la tabla `webhook`
--

INSERT INTO `webhook` (`id`, `webhook_id`, `user_login_id`, `scope`, `destination`, `is_active`) VALUES
(8, 2106, 34, 'store/product/updated', 'https://apolomultimedia.us/bigcomm_app/cronjob-webhook-34', '1');

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
