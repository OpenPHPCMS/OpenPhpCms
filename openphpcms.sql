--
-- Table structure for table `OPC_Images`
--
DROP TABLE IF EXISTS `OPC_Images`;
CREATE TABLE IF NOT EXISTS `OPC_Images` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `file_name` varchar(256) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(32) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Table structure for table `OPC_Menu`
--
DROP TABLE IF EXISTS `OPC_Menu`;
CREATE TABLE `OPC_Menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `link` varchar(256) NOT NULL,
  `parent` int(11) DEFAULT '0',
  `order_number` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;
--
-- Data for table `OPC_Menu`
--
INSERT INTO `OPC_Menu` (`id`, `name`, `link`, `parent`, `order_number`) VALUES
(1, 'Home', 'home', 0, 1),
(2, 'Contact', 'contact', 0, 2),
(3, 'about', 'about', 0, 3),
(4, 'about sub', 'about sub', 3, 1),
(5, 'contact sub', 'contact sub', 2, 1);

-- --------------------------------------------------------
--
-- Table structure for table `OPC_Pages`
--
DROP TABLE IF EXISTS `OPC_Pages`;
CREATE TABLE `OPC_Pages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `title` varchar(128) NOT NULL,
  `type` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------
--
-- Table structure for table `OPC_Page_components`
--
DROP TABLE IF EXISTS `OPC_Page_components`;
CREATE TABLE `OPC_Page_components` (
  `page_id` int(10) NOT NULL,
  `component_name` varchar(64) NOT NULL,
  `page_location` varchar(32) NOT NULL,
  PRIMARY KEY (`page_id`,`component_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- --------------------------------------------------------
--
-- Table structure for table `OPC_Page_content`
--
DROP TABLE IF EXISTS `OPC_Page_content`;
CREATE TABLE `OPC_Page_content` (
  `page_id` int(10) NOT NULL,
  `name` varchar(32) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`page_id`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- --------------------------------------------------------
--
-- Table structure for table `OPC_Sessions`
--
DROP TABLE IF EXISTS `OPC_Sessions`;
CREATE TABLE `OPC_Sessions` (
  `ID` varchar(32) NOT NULL,
  `last_accessed` int(10) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
-- --------------------------------------------------------
--
-- Table structure for table `OPC_Settings`
--
DROP TABLE IF EXISTS `OPC_Settings`;
CREATE TABLE `OPC_Settings` (
  `appid` varchar(64) NOT NULL,
  `setting_name` varchar(64) NOT NULL,
  `setting_value` text NOT NULL,
  PRIMARY KEY (`setting_name`,`appid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Ddata for table `OPC_Settings`
--
INSERT INTO `OPC_Settings` (`appid`, `setting_name`, `setting_value`) VALUES
('core', 'base_url', 'http://dailybuild.openphpcms.org/'),
('core', 'slogan', ''),
('core', 'title', 'Open PHP CMS'),
('core', 'description', ''),
('core', 'title_format', '[title]-[page]'),
('core', 'admin_email', ''),
('core', 'language', 'EN');

-- --------------------------------------------------------
--
-- Table structure for table `OPC_Users`
--
DROP TABLE IF EXISTS `OPC_Users`;
CREATE TABLE `OPC_Users` (
  `username` varchar(32) NOT NULL,
  `password` varchar(136) NOT NULL,
  `level` int(10) NOT NULL DEFAULT '0',
  `name` varchar(128) NOT NULL,
  `surname` varchar(128) NOT NULL,
  `email` varchar(256) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Data for table `OPC_Users`
--
INSERT INTO `OPC_Users` (`username`, `password`, `level`, `name`, `surname`, `email`, `create_date`) VALUES
('Admin', '88a019a91e3c0d60c6eec6578fc6490bba2688576276b89f79e9e30f6a6508000c2a99a8db147aa578d16bf9c2e029ee72b36c5face905b7187a25836f7c309af3c0127f', 30, 'Admin', 'Php', 'Admin@openphpcms.org', '2013-04-22 18:47:11'),
('User', 'cb86e3199e65d1cfef1da4393939b6820ce78f7dc809222c324f4ffe34d826cd8c67362b71bd11ef593e7a2baa8f01e57ead75df8b265062e4cc22ce8e00403a1b7db3b4', 10, 'user', 'Php', 'user@openphpcms.org', '2013-04-22 22:40:09'),
('Dev', 'cdf09597911d0596b7bfe46315594e878adaa3dd82f5a82150ab275eb9c88f420ebf7625bf6d62086a592b41a53b42e6ea458095f86df6982ec003481d2561afe7e9fd17', 20, 'dev', 'Php', 'dev@openphpcms.org', '2013-04-22 22:40:09'),
('Owner', '48ef2add47ae11b789592ec2f84b30a0f750efade48efddd4ee13583e49a51a56699386cd589b03f8b82aef04f349c9792e2e538b07f69f0d', 40, 'Owner', 'Php', 'owner@openphpcms.org', '2013-06-23 11:55:27');
