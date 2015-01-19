-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 25, 2014 at 04:02 PM
-- Server version: 5.5.40
-- PHP Version: 5.3.10-1ubuntu3.15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bejelentkezes`
--

-- --------------------------------------------------------

--
-- Table structure for table `cimkek`
--

CREATE TABLE IF NOT EXISTS `cimkek` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nev` varchar(127) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `cimkek`
--

INSERT INTO `cimkek` (`id`, `nev`) VALUES
(1, 'kutya'),
(2, 'macska');

-- --------------------------------------------------------

--
-- Table structure for table `felhasznalok`
--

CREATE TABLE IF NOT EXISTS `felhasznalok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `felhasznaloi_nev` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `jelszo` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `teljes_nev` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `utolso_bejelentkezes` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `felhasznalok`
--

INSERT INTO `felhasznalok` (`id`, `felhasznaloi_nev`, `jelszo`, `teljes_nev`, `utolso_bejelentkezes`) VALUES
(4, 'bela', 'e99a18c428cb38d5f260853678922e03', 'Kiss Béla', '2014-05-27 17:41:11'),
(5, 'geza', 'e99a18c428cb38d5f260853678922e03', 'Nagy Géza', '2014-05-27 17:41:11'),
(6, 'sanyi', 'e99a18c428cb38d5f260853678922e03', NULL, '2014-05-27 17:41:11');

-- --------------------------------------------------------

--
-- Table structure for table `hozzaszolasok`
--

CREATE TABLE IF NOT EXISTS `hozzaszolasok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tartalom` text COLLATE utf8_unicode_ci NOT NULL,
  `szerzo_id` int(11) NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `poszt_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `hozzaszolasok`
--

INSERT INTO `hozzaszolasok` (`id`, `tartalom`, `szerzo_id`, `datum`, `poszt_id`) VALUES
(10, 'Suspendisse tincidunt at ligula gravida posuere. Duis at venenatis nibh. In hac habitasse platea dictumst.', 6, '2014-05-27 17:55:04', 13),
(11, 'Pellentesque placerat sapien sapien! Aliquam gravida molestie justo, imperdiet ullamcorper est ullamcorper id. Fusce vel pellentesque mi, euismod suscipit mauris.', 4, '2014-05-27 17:55:30', 13),
(12, 'Donec sit amet leo vel tortor suscipit egestas.', 5, '2014-05-27 17:55:49', 13),
(13, 'Fusce volutpat nunc a quam posuere ultrices. Maecenas sit amet nisl accumsan, aliquam eros nec, aliquam nulla. Praesent euismod mollis ipsum sed dignissim. Nullam aliquam eros eget turpis congue, ac blandit mauris ullamcorper. Nam dapibus molestie diam et condimentum. Duis volutpat hendrerit felis quis congue. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 5, '2014-05-27 17:56:06', 13),
(14, 'fdssdf', 4, '2014-09-30 12:42:46', 13),
(15, 'dasdasdasd', 5, '2014-09-30 14:54:24', 13),
(16, 'sdfsdfsdf', 5, '2014-09-30 14:55:24', 14);

-- --------------------------------------------------------

--
-- Table structure for table `posztCimkek`
--

CREATE TABLE IF NOT EXISTS `posztCimkek` (
  `poszt_id` int(11) NOT NULL,
  `cimke_id` int(11) NOT NULL,
  PRIMARY KEY (`poszt_id`,`cimke_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `posztCimkek`
--

INSERT INTO `posztCimkek` (`poszt_id`, `cimke_id`) VALUES
(11, 1),
(12, 2),
(13, 1),
(13, 2);

-- --------------------------------------------------------

--
-- Table structure for table `posztok`
--

CREATE TABLE IF NOT EXISTS `posztok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cim` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tartalom` text COLLATE utf8_unicode_ci NOT NULL,
  `szerzo_id` int(11) NOT NULL,
  `hsz_lehet` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `posztok`
--

INSERT INTO `posztok` (`id`, `cim`, `datum`, `tartalom`, `szerzo_id`, `hsz_lehet`) VALUES
(11, 'Lorem ipsum dolor', '2014-05-27 17:43:35', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus posuere auctor mi, a tincidunt eros convallis id. Nam ac est vitae justo blandit semper id non nisl. In malesuada augue mi, et feugiat neque eleifend id. Suspendisse vitae erat ultrices, semper dui quis, varius lacus. Mauris molestie, metus eget vestibulum tempor, orci enim lobortis lorem, eu consectetur sapien eros ac turpis. Etiam bibendum dolor dui, sit amet aliquam mauris volutpat at. Ut quis justo euismod nisi porta suscipit. Phasellus sit amet placerat lorem.\r\n\r\nVivamus lacinia varius felis quis convallis. Donec eget malesuada erat. Fusce aliquet mattis semper. Aliquam erat volutpat. Nam eget arcu dui. Quisque auctor massa a libero dapibus, eu iaculis lorem tempus. Pellentesque sit amet mi sed nibh placerat scelerisque. Curabitur volutpat faucibus accumsan.\r\n\r\nFusce ac eleifend felis. Cras placerat sollicitudin enim, laoreet venenatis eros fermentum porttitor. Praesent commodo enim at est convallis aliquam. Suspendisse venenatis ut diam a vehicula. Aliquam tortor est, elementum id scelerisque in, interdum et nisl. Etiam faucibus purus in molestie fringilla. Quisque a faucibus eros. Praesent vulputate vehicula sapien, in venenatis velit.', 5, 1),
(12, 'Nulla id lobortis orci', '2014-05-27 17:51:37', 'Sed egestas vitae elit ac adipiscing. Aenean sagittis bibendum aliquam. In pretium consectetur diam. Cras lacinia nisi id nisi molestie sagittis. Nunc vel velit non ipsum hendrerit tristique eget ut ante. Quisque rutrum, massa at feugiat tempor, ligula dolor posuere sapien, vel pretium nulla nulla quis metus. Aliquam quis tortor vehicula, vestibulum metus nec, sollicitudin urna. Suspendisse vestibulum velit id malesuada gravida. Sed scelerisque neque nec metus venenatis, sit amet facilisis ipsum bibendum. Nunc mauris enim, tempus nec suscipit eu, consequat non justo. Nulla auctor tortor bibendum, placerat sem at, cursus ligula. Vestibulum tempor pretium leo, eget malesuada libero semper sed. Sed tincidunt libero et lectus adipiscing vehicula. Etiam cursus lectus pretium molestie egestas. Curabitur sodales libero ac interdum euismod. In non quam ante.\r\n\r\nAenean sem neque, pellentesque vitae vestibulum non, hendrerit ut lectus. Morbi ut pulvinar dolor. Donec suscipit placerat ipsum ac porttitor. In quis turpis rhoncus, tristique turpis nec, scelerisque justo. Praesent consequat nisl quam, eget fermentum tellus laoreet vel. In auctor justo nec bibendum porttitor. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Duis commodo sodales enim at bibendum. Curabitur tristique lectus in lectus malesuada malesuada. Vivamus ullamcorper ligula eu eros molestie pretium eget id nibh.\r\n\r\nMaecenas ac metus condimentum, dignissim lacus in, pharetra felis. Cras sed suscipit nisl. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Proin et est pellentesque, rhoncus nisi nec, lobortis risus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Duis porta laoreet tellus, sed lacinia justo aliquet in. Nunc aliquam erat vel quam commodo faucibus. Nullam blandit justo in sem scelerisque, non ultrices sapien mattis. Aenean aliquam tellus vitae interdum sagittis. Suspendisse congue dui id fermentum lacinia. Praesent at sapien id diam viverra scelerisque. Nam mi elit, tristique vel velit nec, rhoncus consequat velit. Nulla vehicula nunc dolor, sed rhoncus ante placerat ac. Nam eget nibh dui. In ut tristique est.\r\n\r\nUt ut elementum libero. Nullam justo odio, varius eget ultricies a, ornare sed ante. Aenean egestas vulputate pretium. Proin mattis dictum velit, sit amet condimentum dolor dignissim eget. Cras dapibus congue gravida. In at condimentum dolor, vitae vulputate massa. Vestibulum rhoncus dui fringilla, viverra erat in, vehicula eros. Pellentesque accumsan nisi non varius semper. Proin in est placerat, commodo risus et, consectetur eros. Donec vel mauris et odio pharetra egestas quis eget risus. Mauris tellus ante, sollicitudin viverra auctor ut, volutpat vel quam. Donec sed lorem ut tellus pulvinar dignissim pellentesque ut odio. Nunc nunc nisi, mollis vitae dolor quis, sagittis dapibus velit.\r\n\r\nNam ut turpis ac turpis adipiscing convallis vel in urna. Nulla eu semper felis, ac auctor odio. Curabitur ornare nisl eu turpis volutpat, id dictum turpis adipiscing. Aenean vitae quam sed lorem lacinia faucibus id vel arcu. Vestibulum non nisl felis. Fusce sit amet mauris varius, accumsan risus sit amet, sagittis lorem. Maecenas nec dapibus purus. Donec mattis ultrices augue sed eleifend. Suspendisse vel adipiscing massa. Nulla tempus molestie elit, vitae ultricies elit commodo sed. Curabitur porttitor aliquam velit, vitae condimentum nisl pellentesque nec.', 4, 0),
(13, 'Scelerisque tempus', '2014-05-27 17:53:54', 'Proin neque felis, rhoncus suscipit nisl vel, fermentum blandit magna. Fusce eu sollicitudin diam. Nullam vitae gravida arcu, eget ultricies erat. In rhoncus ullamcorper felis viverra molestie. Suspendisse sollicitudin elit at pharetra laoreet. Donec aliquet dignissim odio, sed porta enim fringilla non. Quisque condimentum leo at arcu rutrum, vitae tincidunt eros malesuada. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Phasellus lobortis lorem posuere nisl dictum scelerisque. Vivamus blandit urna nec sem semper fringilla. Praesent id laoreet est, vitae faucibus ligula. Praesent vitae malesuada enim. Aliquam vestibulum blandit velit et placerat. Praesent lacinia, turpis in sollicitudin vulputate, sem dolor rutrum lorem, gravida elementum augue lacus ut purus. Aliquam scelerisque lorem eleifend, mollis purus et, congue est.\r\n\r\nCurabitur ut vestibulum magna, quis tempor diam. Maecenas venenatis, eros sed rutrum dapibus, sem odio laoreet est, in sodales nunc justo at purus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non turpis risus. Etiam tempor in lacus a ultrices. Sed malesuada tortor erat. Donec et metus sed felis consequat porta. Integer laoreet suscipit elit nec sodales. Sed ultricies urna sed eleifend aliquet. Donec tincidunt leo sed nibh imperdiet, non consectetur dui rutrum. Proin volutpat purus at massa.', 5, 1),
(14, 'Próba poszt', '2014-09-30 14:55:11', 'asdasdasda', 5, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
