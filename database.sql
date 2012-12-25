-- phpMyAdmin SQL Dump
-- version 3.4.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 25, 2012 at 02:28 PM
-- Server version: 5.1.66
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `redat675_nexus`
--

-- --------------------------------------------------------

--
-- Table structure for table `batteries`
--

CREATE TABLE IF NOT EXISTS `batteries` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `PubID` varchar(40) NOT NULL,
  `Username` varchar(32) NOT NULL,
  `Name` varchar(32) NOT NULL,
  `Password` varchar(128) NOT NULL,
  `Salt` int(4) NOT NULL,
  `SessionID` varchar(40) NOT NULL,
  `Following` varchar(999) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `batteries`
--

INSERT INTO `batteries` (`ID`, `PubID`, `Username`, `Name`, `Password`, `Salt`, `SessionID`, `Following`) VALUES
(31, 'c46eaec6391155d99abaf3e0d21a8e139d19160c', 'quiksilvrgreen@gmail.com', 'Allen Clark', '893f8df3226cdb5052ed9fcef3bb1f0ed691c03d', 7967, '', ',0e0be57ac9ccbba8452c9706589f2191cc98236e,128dc623ffef1801a4183ea3a4a4eea495126160,f0079e5c5e2eb3d985382e6cf3142384bfd6de2f,3d4e5338b79b4c159644dc7e26c9cce3b025fcd0,b7136dd46715cf5a95e1bddb778488eded895126,c64e96a44967359a81b765dc363695c2c8df714a'),
(32, '0e0be57ac9ccbba8452c9706589f2191cc98236e', 'james@lily.com', 'James and Lilly', '57531c8d9cd1f61529a78ce294251b6e33ce8e93', 2997, '', ''),
(33, '3d4e5338b79b4c159644dc7e26c9cce3b025fcd0', 'akanatuna@gmail.com', 'Max Akana', '25fdb4ab6c296ceb3e7f22ea927dabc0ce054342', 5247, '', 'f0079e5c5e2eb3d985382e6cf3142384bfd6de2f,c46eaec6391155d99abaf3e0d21a8e139d19160c,c64e96a44967359a81b765dc363695c2c8df714a'),
(34, '128dc623ffef1801a4183ea3a4a4eea495126160', 'a.nicholasclark@gmail.com', 'James Peng', '1ed61e6a3b1b44141b8a39c415445e319b41fac9', 8322, '', ''),
(36, 'df4c7246f08c93a2286f6df05633bae9079803f0', 'xander.luiz@gmail.com', '', '', 6496, '', ''),
(38, 'f0079e5c5e2eb3d985382e6cf3142384bfd6de2f', 'test1@test.com', 'nickname', '9dbc2aec6add9144f024f96959885cc4d9e6f878', 4725, '', ''),
(41, 'c64e96a44967359a81b765dc363695c2c8df714a', 'monsterkiller@raspberry.com', 'Jason Bourne', '3bb597b5ec7cfad62854e31c26229abe05a2af87', 5966, '', ',c46eaec6391155d99abaf3e0d21a8e139d19160c,f0079e5c5e2eb3d985382e6cf3142384bfd6de2f,128dc623ffef1801a4183ea3a4a4eea495126160'),
(42, 'b7136dd46715cf5a95e1bddb778488eded895126', 'rohinthomas@hotmail.com', 'rohin', 'e4c203a723d6dccabbea2cadcecebeaebb663054', 2269, '', ',c46eaec6391155d99abaf3e0d21a8e139d19160c,3d4e5338b79b4c159644dc7e26c9cce3b025fcd0,c64e96a44967359a81b765dc363695c2c8df714a'),
(43, '9030cba860274abc84e779b454abd483f6d63a75', 'rasterfonts@free.com', 'Jack n Jill', '6b00f849bf4c7340d5e40d03733059f18e31a27c', 8046, '', ',c46eaec6391155d99abaf3e0d21a8e139d19160c,c64e96a44967359a81b765dc363695c2c8df714a,b7136dd46715cf5a95e1bddb778488eded895126');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Title` varchar(50) NOT NULL,
  `Content` varchar(360) NOT NULL,
  `Owner` varchar(40) NOT NULL,
  `OwnerName` varchar(32) NOT NULL,
  `Time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`ID`, `Title`, `Content`, `Owner`, `OwnerName`, `Time`) VALUES
(8, 'Jimmy Hoffa', 'He''s Alive!', 'c46eaec6391155d99abaf3e0d21a8e139d19160c', 'Allen Clark', '0000-00-00 00:00:00'),
(14, 'Banana', 'BananaFone', 'c46eaec6391155d99abaf3e0d21a8e139d19160c', 'Allen Clark', '2012-12-24 20:46:38'),
(15, 'Rampana!', '', '3d4e5338b79b4c159644dc7e26c9cce3b025fcd0', 'Max Akana', '2012-12-24 21:02:48'),
(16, 'End of the world?', 'Well, I honestly thought the ''End of the World'' would be a bit more eventful. Nothing even happened....except a buncha people protested. :P', 'c46eaec6391155d99abaf3e0d21a8e139d19160c', 'Allen Clark', '2012-12-24 21:51:37'),
(17, 'End of the world!', 'Well, I honestly thought the ''End of the World'' would be a bit more eventful. Nothing even happened....except a buncha people protested. :!', 'c46eaec6391155d99abaf3e0d21a8e139d19160c', 'Allen Clark', '2012-12-24 21:53:42'),
(18, 'This is the latest post!', 'Wow, it''s actually displaying correctly across all three columns ;O\r\n\r\nI''m surprised!', 'c46eaec6391155d99abaf3e0d21a8e139d19160c', 'Allen Clark', '2012-12-24 22:39:16'),
(19, 'Post from another planet!', 'This post was discovered on Mars by the most dangerous rover on the planet: Grover.', '128dc623ffef1801a4183ea3a4a4eea495126160', 'James Peng', '2012-12-24 22:42:07'),
(20, 'Post Title', 'This should be displaying my inserted name. Oh, and look, it has no title. So sad...', 'c46eaec6391155d99abaf3e0d21a8e139d19160c', 'Allen Clark', '2012-12-25 07:08:45'),
(21, 'Second Try!', 'This should be displaying my inserted name. Oh, and look, it has no title. So sad...', 'c46eaec6391155d99abaf3e0d21a8e139d19160c', 'Allen Clark', '2012-12-25 07:09:51'),
(22, 'qwewqe', 'Hehe, that sounds funny :)', '3d4e5338b79b4c159644dc7e26c9cce3b025fcd0', 'Max Akana', '2012-12-25 07:19:36'),
(23, 'Cha-ching!', 'Made some cash today! Who wants to go out and eat!!?!', 'c46eaec6391155d99abaf3e0d21a8e139d19160c', 'Allen Clark', '2012-12-25 07:27:16'),
(24, 'OMG', 'Oh My God!', 'c46eaec6391155d99abaf3e0d21a8e139d19160c', 'Allen Clark', '2012-12-25 08:13:37'),
(25, 'New Post!', 'hehe!', 'c46eaec6391155d99abaf3e0d21a8e139d19160c', 'Allen Clark', '2012-12-25 08:17:38'),
(26, 'Lets try something a bit longer', 'Like a lorem ipsum! Lorem ipsum dolor perfume eau d toilette. The first time that a protected page is requested, the user will not have entered his or her login details yet. The script detects this and prompts the user for a username and password with a login form instead of displaying the requested page.', 'c46eaec6391155d99abaf3e0d21a8e139d19160c', 'Allen Clark', '2012-12-25 08:18:38'),
(27, 'Third post', 'This one switched the quotes around :o', '3d4e5338b79b4c159644dc7e26c9cce3b025fcd0', 'Max Akana', '2012-12-25 08:27:28'),
(28, 'This is the Title', 'This is something!!', 'f0079e5c5e2eb3d985382e6cf3142384bfd6de2f', 'nickname', '2012-12-25 08:51:41'),
(29, 'My Identity', 'Does anyone know it? I checked all over my house...can''t find it anywhere. Any help would be greatly appreciated. No joke.', 'c64e96a44967359a81b765dc363695c2c8df714a', 'Jason Bourne', '2012-12-25 11:49:52'),
(30, 'Wah!', 'First post on the server. I guess that gives me the right to shout FIRST!!! :D haha', 'c46eaec6391155d99abaf3e0d21a8e139d19160c', 'Allen Clark', '2012-12-25 12:18:27'),
(31, 'Firefox', 'We want to say hello world :D', 'c46eaec6391155d99abaf3e0d21a8e139d19160c', 'Allen Clark', '2012-12-25 13:40:09'),
(32, 'Yay!', 'I posted something :P', '9030cba860274abc84e779b454abd483f6d63a75', 'Jack n Jill', '2012-12-25 14:18:44');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
