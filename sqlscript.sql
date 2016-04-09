CREATE TABLE IF NOT EXISTS `allreceipts` (
  `receipt_id` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `notificationtype` varchar(255) NOT NULL,
  `orderid` varchar(255) NOT NULL,
  `productid` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `saledate` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `country` varchar(255) NOT NULL,
  PRIMARY KEY (`receipt_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `logdesc` varchar(255) NOT NULL,
  `logdate` datetime NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Product`
--

CREATE TABLE IF NOT EXISTS `Product` (
  `ProductId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `ItemNumber` varchar(255) NOT NULL,
  `URL` varchar(255) NOT NULL,
  `DateAdded` datetime NOT NULL,
  PRIMARY KEY (`ProductId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE IF NOT EXISTS `receipts` (
  `receipt_id` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `notificationtype` varchar(255) NOT NULL,
  `orderid` varchar(255) NOT NULL,
  `productid` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `saledate` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `country` varchar(255) NOT NULL,
  PRIMARY KEY (`receipt_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `receipts_del`
--

CREATE TABLE IF NOT EXISTS `receipts_del` (
  `receipt_id` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `notificationtype` varchar(255) NOT NULL,
  `orderid` varchar(255) NOT NULL,
  `productid` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `saledate` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `DateAdded` datetime NOT NULL,
  `country` varchar(255) NOT NULL,
  PRIMARY KEY (`receipt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Settings`
--

CREATE TABLE IF NOT EXISTS `Settings` (
  `SettingsId` int(11) NOT NULL AUTO_INCREMENT,
  `Value` longtext NOT NULL,
  `Name` varchar(255) NOT NULL,
  PRIMARY KEY (`SettingsId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


INSERT INTO `Settings` (`SettingsId`, `Value`, `Name`) VALUES
(1, 'HUTTRAFF', 'Secret'),
(2, 'admin', 'AdminUser'),
(3, 'discbuddy9o5', 'AdminPass'),
(4, '', 'CancelProditem'),
(5, '', 'Proditem'),
(6, 'DEV-4DE57A3ECB672F54A7204B983ED630604E7A', 'DevKey'),
(7, 'API-90BA00AB02E3B3E90700CF3DFE31F7A76F0A', 'ClerkKey');
