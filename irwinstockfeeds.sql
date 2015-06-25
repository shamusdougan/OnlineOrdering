-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2015 at 04:28 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `irwinstockfeeds`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `summary` text COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', 1, 1433830404);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, NULL, NULL, NULL, 1433830403, 1433830403),
('useSettings', 2, 'Allow user to modify system settings', NULL, NULL, 1433830403, 1433830403);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'useSettings');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('isAuthor', 'O:25:"app\\rbac\\rules\\AuthorRule":3:{s:4:"name";s:8:"isAuthor";s:9:"createdAt";i:1433830403;s:9:"updatedAt";i:1433830403;}', 1433830403, 1433830403);

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `Company_Name` varchar(30) NOT NULL,
  `Trading_as` varchar(21) DEFAULT NULL,
  `Main_Phone` varchar(12) DEFAULT NULL,
  `TownSuburb` varchar(15) DEFAULT NULL,
  `Is_Customer` varchar(3) NOT NULL,
  `Is_Factory` varchar(2) NOT NULL,
  `Is_Supplier` varchar(2) NOT NULL,
  `Credit_Hold` varchar(3) NOT NULL,
  `Owner` varchar(13) NOT NULL,
  `Account_Number` varchar(6) NOT NULL,
  `Third_Party_Company` varchar(1) DEFAULT NULL,
  `ABN` varchar(14) DEFAULT NULL,
  `Account_Rating` varchar(13) NOT NULL,
  `Address_1` varchar(61) NOT NULL,
  `Address_1_Address_Type` varchar(1) DEFAULT NULL,
  `Address_1_CountryRegion` varchar(9) DEFAULT NULL,
  `Address_1_County` varchar(1) DEFAULT NULL,
  `Address_1_Fax` varchar(1) DEFAULT NULL,
  `Address_1_Freight_Terms` varchar(1) DEFAULT NULL,
  `Address_1_Latitude` varchar(1) DEFAULT NULL,
  `Address_1_Longitude` varchar(1) DEFAULT NULL,
  `Address_1_Name` varchar(1) DEFAULT NULL,
  `Address_1_Post_Office_Box` varchar(1) DEFAULT NULL,
  `Address_1_Postal_Code` int(4) DEFAULT NULL,
  `Address_1_Primary_Contact_Name` varchar(1) DEFAULT NULL,
  `Address_1_Shipping_Method` varchar(1) DEFAULT NULL,
  `Address_1_StateProvince` varchar(3) DEFAULT NULL,
  `Address_1_Street_1` varchar(30) DEFAULT NULL,
  `Address_1_Street_2` varchar(1) DEFAULT NULL,
  `Address_1_Street_3` varchar(7) DEFAULT NULL,
  `Address_1_Telephone_2` varchar(1) DEFAULT NULL,
  `Address_1_Telephone_3` varchar(1) DEFAULT NULL,
  `Address_1_UPS_Zone` varchar(1) DEFAULT NULL,
  `Address_1_UTC_Offset` varchar(1) DEFAULT NULL,
  `Address_2` varchar(60) DEFAULT NULL,
  `Address_2_Address_Type` varchar(14) NOT NULL,
  `Address_2_CountryRegion` varchar(9) DEFAULT NULL,
  `Address_2_County` varchar(1) DEFAULT NULL,
  `Address_2_Fax` varchar(1) DEFAULT NULL,
  `Address_2_Freight_Terms` varchar(13) NOT NULL,
  `Address_2_Latitude` varchar(1) DEFAULT NULL,
  `Address_2_Longitude` varchar(1) DEFAULT NULL,
  `Address_2_Name` varchar(1) DEFAULT NULL,
  `Address_2_Post_Office_Box` varchar(1) DEFAULT NULL,
  `Address_2_Postal_Code` int(4) DEFAULT NULL,
  `Address_2_Primary_Contact_Name` varchar(1) DEFAULT NULL,
  `Address_2_Shipping_Method` varchar(13) NOT NULL,
  `Address_2_StateProvince` varchar(3) DEFAULT NULL,
  `Address_2_Street_1` varchar(30) DEFAULT NULL,
  `Address_2_Street_2` varchar(6) DEFAULT NULL,
  `Address_2_Street_3` varchar(1) DEFAULT NULL,
  `Address_2_Telephone_1` varchar(1) DEFAULT NULL,
  `Address_2_Telephone_2` varchar(1) DEFAULT NULL,
  `Address_2_Telephone_3` varchar(1) DEFAULT NULL,
  `Address_2_TownSuburb` varchar(10) DEFAULT NULL,
  `Address_2_UPS_Zone` varchar(1) DEFAULT NULL,
  `Address_2_UTC_Offset` varchar(1) DEFAULT NULL,
  `Address_Phone` varchar(1) DEFAULT NULL,
  `Address1_IsBillTo` varchar(2) NOT NULL,
  `Address1_IsShipTo` varchar(2) NOT NULL,
  `Aging_30` varchar(1) DEFAULT NULL,
  `Aging_30_Base` varchar(1) DEFAULT NULL,
  `Aging_60` varchar(1) DEFAULT NULL,
  `Aging_60_Base` varchar(1) DEFAULT NULL,
  `Aging_90` varchar(1) DEFAULT NULL,
  `Aging_90_Base` varchar(1) DEFAULT NULL,
  `Annual_Revenue` varchar(1) DEFAULT NULL,
  `Annual_Revenue_Base` varchar(1) DEFAULT NULL,
  `Beef_Notes` varchar(1) DEFAULT NULL,
  `Billing_company_admin_fee` varchar(1) DEFAULT NULL,
  `Billing_company_admin_fee_Base` varchar(1) DEFAULT NULL,
  `Billing_contact` varchar(12) DEFAULT NULL,
  `Billing_type` varchar(8) DEFAULT NULL,
  `Business_Type` varchar(11) DEFAULT NULL,
  `Category` varchar(1) DEFAULT NULL,
  `Classification` varchar(13) NOT NULL,
  `Client_Status` varchar(7) DEFAULT NULL,
  `Copy_addess` varchar(2) DEFAULT NULL,
  `Copy_address` varchar(3) DEFAULT NULL,
  `Created_By` varchar(13) NOT NULL,
  `Created_By_Delegate` varchar(1) DEFAULT NULL,
  `Created_On` varchar(18) NOT NULL,
  `Credit_Limit` varchar(1) DEFAULT NULL,
  `Credit_Limit_Base` varchar(1) DEFAULT NULL,
  `Currency` varchar(17) NOT NULL,
  `Customer_Size` varchar(13) NOT NULL,
  `Dairy_No` int(4) DEFAULT NULL,
  `Dairy_Notes` varchar(1) DEFAULT NULL,
  `Delivery_Directions` varchar(265) DEFAULT NULL,
  `Description` varchar(1) DEFAULT NULL,
  `Do_not_allow_Bulk_Emails` varchar(5) NOT NULL,
  `Do_not_allow_Bulk_Mails` varchar(2) NOT NULL,
  `Do_not_allow_Emails` varchar(5) NOT NULL,
  `Do_not_allow_Faxes` varchar(5) NOT NULL,
  `Do_not_allow_Mails` varchar(5) NOT NULL,
  `Do_not_allow_Phone_Calls` varchar(5) NOT NULL,
  `Email` varchar(25) DEFAULT NULL,
  `Email_Address_2` varchar(1) DEFAULT NULL,
  `Email_Address_3` varchar(1) DEFAULT NULL,
  `Exchange_Rate` decimal(7,5) NOT NULL,
  `Farm_Mgr` varchar(20) DEFAULT NULL,
  `Farm_No` varchar(1) DEFAULT NULL,
  `Farm_Operation` varchar(11) DEFAULT NULL,
  `Fax` int(10) DEFAULT NULL,
  `Feed_Days_Remaining` int(3) DEFAULT NULL,
  `Feed_empty` date DEFAULT NULL,
  `Feed_QOH_Tonnes` decimal(5,2) DEFAULT NULL,
  `Feed_QOH_Update` date NOT NULL,
  `Feed_Rate_Kg_Day` decimal(4,2) NOT NULL,
  `FTP_Site` varchar(1) DEFAULT NULL,
  `Herd_Notes` varchar(1) DEFAULT NULL,
  `Herd_Size` int(3) NOT NULL,
  `Herd_Type` varchar(5) DEFAULT NULL,
  `Industry_Code` varchar(1) DEFAULT NULL,
  `Is_Internal` varchar(2) NOT NULL,
  `Is_Provider` varchar(2) DEFAULT NULL,
  `Last_Date_Included_in_Campaign` varchar(1) DEFAULT NULL,
  `Main_Competitor` varchar(8) DEFAULT NULL,
  `Main_Product` varchar(1) DEFAULT NULL,
  `Map_Reference` varchar(5) DEFAULT NULL,
  `Market_Capitalization` varchar(1) DEFAULT NULL,
  `Market_Capitalization_Base` varchar(1) DEFAULT NULL,
  `Mobile_Phone` varchar(12) DEFAULT NULL,
  `Modified_By` varchar(13) NOT NULL,
  `Modified_By_Delegate` varchar(12) DEFAULT NULL,
  `Modified_On` varchar(19) NOT NULL,
  `Nearest_Town` varchar(51) NOT NULL,
  `No_of_Employees` varchar(1) DEFAULT NULL,
  `Originating_Lead` varchar(1) DEFAULT NULL,
  `Other_Phone` varchar(1) DEFAULT NULL,
  `Ownership` varchar(1) DEFAULT NULL,
  `Parent_Company` varchar(1) DEFAULT NULL,
  `Parent_Region` varchar(14) DEFAULT NULL,
  `Payment_Terms` varchar(27) DEFAULT NULL,
  `Preferred_Day` varchar(1) DEFAULT NULL,
  `Preferred_FacilityEquipment` varchar(1) DEFAULT NULL,
  `Preferred_Method_of_Contact` varchar(3) NOT NULL,
  `Preferred_Service` varchar(1) DEFAULT NULL,
  `Preferred_Time` varchar(1) DEFAULT NULL,
  `Preferred_User` varchar(1) DEFAULT NULL,
  `Price_List` varchar(6) NOT NULL,
  `Primary_Contact` varchar(1) DEFAULT NULL,
  `Process` varchar(1) DEFAULT NULL,
  `Process_Stage` varchar(1) DEFAULT NULL,
  `Property_Name` varchar(12) DEFAULT NULL,
  `Record_Created_On` varchar(1) DEFAULT NULL,
  `Relationship_Type` varchar(1) DEFAULT NULL,
  `Send_Marketing_Materials` varchar(4) NOT NULL,
  `Shares_Outstanding` varchar(1) DEFAULT NULL,
  `Shipping_Method` varchar(13) NOT NULL,
  `SIC_Code` varchar(1) DEFAULT NULL,
  `Status` varchar(8) NOT NULL,
  `Status_Reason` varchar(8) NOT NULL,
  `Stock_Exchange` varchar(1) DEFAULT NULL,
  `Sub_Region` varchar(27) DEFAULT NULL,
  `Supplies_to` varchar(24) DEFAULT NULL,
  `Telephone_3` varchar(1) DEFAULT NULL,
  `Territory` varchar(1) DEFAULT NULL,
  `Territory_Code` varchar(13) NOT NULL,
  `Ticker_Symbol` varchar(1) DEFAULT NULL,
  `Website` varchar(1) DEFAULT NULL,
  `Yomi_Account_Name` varchar(1) DEFAULT NULL,
  `z_old_Industry` varchar(1) DEFAULT NULL,
  `z_old_Payment_Terms` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`Account_Number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`Company_Name`, `Trading_as`, `Main_Phone`, `TownSuburb`, `Is_Customer`, `Is_Factory`, `Is_Supplier`, `Credit_Hold`, `Owner`, `Account_Number`, `Third_Party_Company`, `ABN`, `Account_Rating`, `Address_1`, `Address_1_Address_Type`, `Address_1_CountryRegion`, `Address_1_County`, `Address_1_Fax`, `Address_1_Freight_Terms`, `Address_1_Latitude`, `Address_1_Longitude`, `Address_1_Name`, `Address_1_Post_Office_Box`, `Address_1_Postal_Code`, `Address_1_Primary_Contact_Name`, `Address_1_Shipping_Method`, `Address_1_StateProvince`, `Address_1_Street_1`, `Address_1_Street_2`, `Address_1_Street_3`, `Address_1_Telephone_2`, `Address_1_Telephone_3`, `Address_1_UPS_Zone`, `Address_1_UTC_Offset`, `Address_2`, `Address_2_Address_Type`, `Address_2_CountryRegion`, `Address_2_County`, `Address_2_Fax`, `Address_2_Freight_Terms`, `Address_2_Latitude`, `Address_2_Longitude`, `Address_2_Name`, `Address_2_Post_Office_Box`, `Address_2_Postal_Code`, `Address_2_Primary_Contact_Name`, `Address_2_Shipping_Method`, `Address_2_StateProvince`, `Address_2_Street_1`, `Address_2_Street_2`, `Address_2_Street_3`, `Address_2_Telephone_1`, `Address_2_Telephone_2`, `Address_2_Telephone_3`, `Address_2_TownSuburb`, `Address_2_UPS_Zone`, `Address_2_UTC_Offset`, `Address_Phone`, `Address1_IsBillTo`, `Address1_IsShipTo`, `Aging_30`, `Aging_30_Base`, `Aging_60`, `Aging_60_Base`, `Aging_90`, `Aging_90_Base`, `Annual_Revenue`, `Annual_Revenue_Base`, `Beef_Notes`, `Billing_company_admin_fee`, `Billing_company_admin_fee_Base`, `Billing_contact`, `Billing_type`, `Business_Type`, `Category`, `Classification`, `Client_Status`, `Copy_addess`, `Copy_address`, `Created_By`, `Created_By_Delegate`, `Created_On`, `Credit_Limit`, `Credit_Limit_Base`, `Currency`, `Customer_Size`, `Dairy_No`, `Dairy_Notes`, `Delivery_Directions`, `Description`, `Do_not_allow_Bulk_Emails`, `Do_not_allow_Bulk_Mails`, `Do_not_allow_Emails`, `Do_not_allow_Faxes`, `Do_not_allow_Mails`, `Do_not_allow_Phone_Calls`, `Email`, `Email_Address_2`, `Email_Address_3`, `Exchange_Rate`, `Farm_Mgr`, `Farm_No`, `Farm_Operation`, `Fax`, `Feed_Days_Remaining`, `Feed_empty`, `Feed_QOH_Tonnes`, `Feed_QOH_Update`, `Feed_Rate_Kg_Day`, `FTP_Site`, `Herd_Notes`, `Herd_Size`, `Herd_Type`, `Industry_Code`, `Is_Internal`, `Is_Provider`, `Last_Date_Included_in_Campaign`, `Main_Competitor`, `Main_Product`, `Map_Reference`, `Market_Capitalization`, `Market_Capitalization_Base`, `Mobile_Phone`, `Modified_By`, `Modified_By_Delegate`, `Modified_On`, `Nearest_Town`, `No_of_Employees`, `Originating_Lead`, `Other_Phone`, `Ownership`, `Parent_Company`, `Parent_Region`, `Payment_Terms`, `Preferred_Day`, `Preferred_FacilityEquipment`, `Preferred_Method_of_Contact`, `Preferred_Service`, `Preferred_Time`, `Preferred_User`, `Price_List`, `Primary_Contact`, `Process`, `Process_Stage`, `Property_Name`, `Record_Created_On`, `Relationship_Type`, `Send_Marketing_Materials`, `Shares_Outstanding`, `Shipping_Method`, `SIC_Code`, `Status`, `Status_Reason`, `Stock_Exchange`, `Sub_Region`, `Supplies_to`, `Telephone_3`, `Territory`, `Territory_Code`, `Ticker_Symbol`, `Website`, `Yomi_Account_Name`, `z_old_Industry`, `z_old_Payment_Terms`) VALUES
('A L Garland - DO NOT USE', 'Garland, Anne', '03 5157 6334', 'GLENALADALE', 'Yes', 'No', 'No', 'Yes', 'Peter Lowry', 'A10050', '', '16 130 265 597', 'Default Value', '1690 Fernbank-Glenaladale Road GLENALADALE VIC 3864 AUSTRALIA', '', 'AUSTRALIA', '', '', '', '', '', '', '', 3864, '', '', 'VIC', '1690 Fernbank-Glenaladale Road', '', '', '', '', '', '', '1690 Fernbank-Glenaladale Road Bairnsdale VIC 3875 Australia', 'Billing/Postal', 'Australia', '', '', 'Default Value', '', '', '', '', 3875, '', 'Default Value', 'VIC', '1690 Fernbank-Glenaladale Road', '', '', '', '', '', 'Bairnsdale', '', '', '', 'No', 'No', '', '', '', '', '', '', '', '', '', '', '', 'Anne Garland', 'Standard', 'Sole Trader', '', 'Default Value', 'Lost', '', '', 'Mark Fowler', '', '6/01/2012 6:31 PM', '', '', 'Australian Dollar', 'Default Value', 1360, '', 'From Stratford head towards Bairnsdale, turn left onto Dargo rd. Continue across the cross roads head down Fernbank Glenaladale road. Farm just over over small white bridge farm on right. (14.5km from highway)', '', 'Allow', 'No', 'Allow', 'Allow', 'Allow', 'Allow', 'anneg@wideband.net.au', '', '', '1.00000', '', '', 'Owned', NULL, NULL, NULL, NULL, '0000-00-00', '3.00', '', '', 150, 'Dairy', '', 'No', '', '', '', '', '83 G6', '', '', '0400 576 333', 'Molly Pinnuck', '', '28/02/2014 2:55 PM', 'East Gippsland > Outer East > GLENALADALE (265 KMs)', '', '', '', '', '', 'East Gippsland', '30 days from delivery', '', '', 'Any', '', '', '', 'Retail', '', '', '', '', '', '', 'Send', '', 'Default Value', '', 'Active', 'Active', '', 'East Gippsland > Outer East', 'Rose', '', '', 'Default Value', '', '', '', '', ''),
('J Lawless', 'Jim Lawless', '03 5166 1225', 'HAZELWOOD SOUTH', 'Yes', 'No', 'No', 'No', 'Shane Doherty', 'A10074', '', '58 501 073 488', 'Default Value', '125 Farrans Road HAZELWOOD SOUTH VIC 3840 AUSTRALIA', '', 'AUSTRALIA', '', '', '', '', '', '', '', 3840, '', '', 'VIC', '125 Farrans Road', '', '', '', '', '', '', 'VIC Australia', 'Billing/Postal', 'Australia', '', '', 'Default Value', '', '', '', '', NULL, '', 'Default Value', 'VIC', '', '', '', '', '', '', '', '', '', '', 'No', 'No', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Default Value', '', '', '', 'Mark Fowler', '', '6/01/2012 6:31 PM', '', '', 'Australian Dollar', 'Default Value', NULL, '', 'From Morwell head to Chruchill on tramway road, just before S bends turn left to Traralgon, once up hill take toad to right. Farrans road farm on left at bottom of hill.', '', 'Allow', 'No', 'Allow', 'Allow', 'Allow', 'Allow', '', '', '', '1.00000', '', '', '', NULL, 8, '0000-00-00', '7.00', '0000-00-00', '4.00', '', '', 200, 'Dairy', '', 'No', '', '', '', '', '', '', '', '', 'SYSTEM', 'Vicky Kardas', '19/07/2012 4:09 PM', 'East Gippsland > Traralgon > HAZELWOOD (161.9 KMs)', '', '', '', '', '', '', '', '', '', 'Any', '', '', '', 'Retail', '', '', '', '', '', '', 'Send', '', 'Default Value', '', 'Inactive', 'Inactive', '', '', 'Murray Goulburn - Maffra', '', '', 'Default Value', '', '', '', '', ''),
('A. Bezzina', '', '', 'WHITTLESEA', 'Yes', 'No', 'No', 'No', 'Peter Lowry', 'A10405', '', '', 'Default Value', 'WHITTLESEA VIC 3757 AUSTRALIA', '', 'AUSTRALIA', '', '', '', '', '', '', '', 3757, '', '', 'VIC', '', '', '', '', '', '', '', '', 'Billing/Postal', '', '', '', 'Default Value', '', '', '', '', NULL, '', 'Default Value', '', '', '', '', '', '', '', '', '', '', '', 'No', 'No', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Default Value', 'Current', 'No', 'No', 'Peter Lowry', '', '7/08/2012 1:30 PM', '', '', 'Australian Dollar', 'Default Value', NULL, '', 'HEAD OUT TO DONNYBROOK TAKE YAN YEAN ROAD, AT YAN YEAN ROUND ABOUT TURN LEFT TO WHITTLESEA, SECOND FARM ON RIGHT. AUGER TRUCK ONLY. ALFIE 0419 970 334', '', 'Allow', 'No', 'Allow', 'Allow', 'Allow', 'Allow', '', '', '', '1.00000', '', '', '', NULL, NULL, NULL, '0.00', '0000-00-00', '0.00', '', '', 0, '', '', 'No', 'No', '', '', '', '', '', '', '0419 970 334', 'CRM Admin', '', '15/04/2015 11:22 AM', 'Northern Victoria > WHITTLESEA (42.07 KMs)', '', '', '', '', '', '', '30 days from delivery', '', '', 'Any', '', '', '', 'Retail', '', '', '', '', '', '', 'Send', '', 'Default Value', '', 'Active', 'Active', '', 'Northern > Victoria', '', '', '', 'Default Value', '', '', '', '', ''),
('A & CJ Huts - Aristin Park (1)', 'Aristin Park - Farm 1', '0351472393', 'MAFFRA', 'Yes', 'No', 'No', 'No', 'Heath Killeen', 'A10498', '', '37006908335', 'Default Value', '147 Maffra Sale Rd MAFFRA VIC 3860 AUSTRALIA', '', 'AUSTRALIA', '', '', '', '', '', '', '', 3860, '', '', 'VIC', '147 Maffra Sale Rd', '', '', '', '', '', '', 'PO BOX 233 MAFFRA VIC 3860 AUSTRALIA', 'Billing/Postal', 'AUSTRALIA', '', '', 'Default Value', '', '', '', '', 3860, '', 'Default Value', 'VIC', 'PO BOX 233', 'MAFFRA', '', '', '', '', '', '', '', '', 'No', 'No', '', '', '', '', '', '', '', '', '', '', '', '', 'Standard', '', '', 'Default Value', 'Current', 'No', 'No', 'Molly Pinnuck', '', '4/02/2013 1:23 PM', '', '', 'Australian Dollar', 'Default Value', NULL, '', 'Travelling from Maffra to Sale - The driveway is on left just before channel crosses under road (Another dairy is on right of road on other side of channel) driveway is long, turn right at fork in driveway - dairy at the end past shedding. (ARISTIN PARK on gateway)', '', 'Allow', 'No', 'Allow', 'Allow', 'Allow', 'Allow', '', '', '', '1.00000', '', '', 'Owned', 351471842, 21, '0000-00-00', '16.00', '0000-00-00', '5.00', '', '', 150, 'Dairy', '', 'No', 'No', '', 'Barastoc', '', '', '', '', '0428311370', 'CRM Admin', '', '11/08/2014 7:22 AM', 'East Gippsland > Maffra > MAFFRA (223.52 KMs)', '', '', '', '', '', 'East Gippsland', '30 days from delivery', '', '', 'Any', '', '', '', 'Retail', '', '', '', 'Aristin Park', '', '', 'Send', '', 'Default Value', '', 'Active', 'Active', '', 'East Gippsland > Maffra', 'Murray Goulburn - Maffra', '', '', 'Default Value', '', '', '', '', ''),
('A & CJ Huts - Charondale (2)', 'A & C Huts Farm 2', '0351472393', 'MAFFRA', 'Yes', 'No', 'No', 'No', 'Heath Killeen', 'A10499', '', '37006908335', 'Default Value', '271 Maffra Sale Rd MAFFRA VIC 3860 AUSTRALIA', '', 'AUSTRALIA', '', '', '', '', '', '', '', 3860, '', '', 'VIC', '271 Maffra Sale Rd', '', '', '', '', '', '', 'PO BOX 233 MAFFRA VIC 3860 AUSTRALIA', 'Billing/Postal', 'AUSTRALIA', '', '', 'Default Value', '', '', '', '', 3860, '', 'Default Value', 'VIC', 'PO BOX 233', 'MAFFRA', '', '', '', '', '', '', '', '', 'No', 'No', '', '', '', '', '', '', '', '', '', '', '', '', 'Standard', '', '', 'Default Value', 'Current', 'No', 'No', 'Molly Pinnuck', '', '4/02/2013 1:27 PM', '', '', 'Australian Dollar', 'Default Value', NULL, '', 'Maffra/Sale Rd. 2-3km out of Maffra, dairy on left hand side just off road.(Farm is before Falls Ln)', '', 'Allow', 'No', 'Allow', 'Allow', 'Allow', 'Allow', '', '', '', '1.00000', '', '', 'Sharefarmer', 351471842, 250, '0000-00-00', '4.00', '0000-00-00', '4.00', '', '', 4, 'Dairy', '', 'No', 'No', '', 'Barastoc', '', '', '', '', '0428311370', 'CRM Admin', '', '12/08/2014 8:46 AM', 'East Gippsland > Maffra > MAFFRA (223.52 KMs)', '', '', '', '', '', 'East Gippsland', '30 days from delivery', '', '', 'Any', '', '', '', 'Retail', '', '', '', '', '', '', 'Send', '', 'Default Value', '', 'Active', 'Active', '', 'East Gippsland > Maffra', 'Murray Goulburn - Maffra', '', '', 'Default Value', '', '', '', '', ''),
('A J & AG Lamb- Lamb 2', 'Lamb, Andrew & Ally', '03 5148 6249', 'NAMBROK', 'Yes', 'No', 'No', 'No', 'Heath Killeen', 'A10554', '', '73 146 011 282', 'Default Value', '853 Nambrok Road NAMBROK VIC 3847 AUSTRALIA', '', 'AUSTRALIA', '', '', '', '', '', '', '', 3847, '', '', 'VIC', '853 Nambrok Road', '', '', '', '', '', '', '853 Nambrok Road NAMBROK VIC 3847 AUSTRALIA', 'Billing/Postal', 'AUSTRALIA', '', '', 'Default Value', '', '', '', '', 3847, '', 'Default Value', 'VIC', '853 Nambrok Road', '', '', '', '', '', 'NAMBROK', '', '', '', 'No', 'No', '', '', '', '', '', '', '', '', '', '', '', 'Andrew Lamb', 'Standard', 'Partnership', '', 'Default Value', 'Current', '', 'Yes', 'Mark Fowler', '', '6/01/2012 6:31 PM', '', '', 'Australian Dollar', 'Default Value', 122, '', '', '', 'Allow', 'No', 'Allow', 'Allow', 'Allow', 'Allow', 'andrewandally@bigpond.com', '', '', '1.00000', 'Andrew and Ally Lamb', '', 'Owned', NULL, 14, '0000-00-00', '12.00', '0000-00-00', '1.50', '', '', 555, 'Dairy', '', 'No', '', '', '', '', '98 F2', '', '', '0419 560 668', 'CRM Admin', '', '9/04/2015 4:39 PM', 'East Gippsland > Nambrok > NAMBROK (203.07 KMs)', '', '', '', '', '', 'East Gippsland', '30 days from delivery', '', '', 'Any', '', '', '', 'Retail', '', '', '', '', '', '', 'Send', '', 'Default Value', '', 'Active', 'Active', '', 'East Gippsland > Nambrok', 'Bega', '', '', 'Default Value', '', '', '', '', ''),
('A & W Cotchins', '', '9408 1359', '', 'Yes', 'No', 'No', 'No', 'Shane Doherty', 'A10793', '', '', 'Default Value', '50 Lehmanns Rd Wollert', '', '', '', '', '', '', '', '', '', NULL, '', '', '', '50 Lehmanns Rd', '', 'Wollert', '', '', '', '', '', 'Billing/Postal', '', '', '', 'Default Value', '', '', '', '', NULL, '', 'Default Value', '', '', '', '', '', '', '', '', '', '', '', 'No', 'No', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Default Value', 'Swinger', 'No', 'No', 'Shane Doherty', '', '27/02/2015 3:46 PM', '', '', 'Australian Dollar', 'Default Value', NULL, '', '50 Lehmanns Rd Wollert drive into yard inbetween two sheds. lid on top of one of the sheds will be open to auger into it.', '', 'Allow', 'No', 'Allow', 'Allow', 'Allow', 'Allow', '', '', '', '1.00000', '', '', '', NULL, 40, '0000-00-00', '4.00', '0000-00-00', '2.00', '', '', 50, '', '', 'No', 'No', '', '', '', '', '', '', '', 'CRM Admin', '', '2/03/2015 10:24 AM', 'Northern Victoria > WOLLERT (39.08 KMs)', '', '', '', '', '', '', 'New pending credit (7 days)', '', '', 'Any', '', '', '', 'Retail', '', '', '', '', '', '', 'Send', '', 'Default Value', '', 'Active', 'Active', '', 'Northern > Victoria', '', '', '', 'Default Value', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `customer_orders`
--

CREATE TABLE IF NOT EXISTS `customer_orders` (
  `Order_ID` varchar(8) NOT NULL,
  `Customer` varchar(30) DEFAULT NULL,
  `Name` varchar(51) DEFAULT NULL,
  `Mix_Type` varchar(1) DEFAULT NULL,
  `Qty_Tonnes` int(2) DEFAULT NULL,
  `Nearest_Town` varchar(45) DEFAULT NULL,
  `Date_Fulfilled` date DEFAULT NULL,
  `Date_Submitted` date DEFAULT NULL,
  `Status_Reason` varchar(8) DEFAULT NULL,
  `Anticipated_Sales` varchar(3) DEFAULT NULL,
  `Bill_To_Address` varchar(1) DEFAULT NULL,
  `Bill_to_Contact_Name` varchar(1) DEFAULT NULL,
  `Bill_To_Fax` varchar(1) DEFAULT NULL,
  `Bill_To_Phone` varchar(1) DEFAULT NULL,
  `Bill_to_Address_Name` varchar(1) DEFAULT NULL,
  `Bill_to_CountryRegion` varchar(1) DEFAULT NULL,
  `Bill_to_Postal_Code` varchar(1) DEFAULT NULL,
  `Bill_to_StateProvince` varchar(1) DEFAULT NULL,
  `Bill_to_Street_1` varchar(1) DEFAULT NULL,
  `Bill_to_Street_2` varchar(1) DEFAULT NULL,
  `Bill_to_Street_3` varchar(1) DEFAULT NULL,
  `Bill_to_TownSuburbCity` varchar(1) DEFAULT NULL,
  `Billing_company` varchar(30) DEFAULT NULL,
  `Billing_company_admin_fee` varchar(1) DEFAULT NULL,
  `Billing_company_admin_fee_Base` varchar(1) DEFAULT NULL,
  `Billing_company_purchase_order` varchar(1) DEFAULT NULL,
  `Billing_type` varchar(8) DEFAULT NULL,
  `cp` varchar(1) DEFAULT NULL,
  `Created_By` varchar(13) DEFAULT NULL,
  `Created_By_Delegate` varchar(1) DEFAULT NULL,
  `Created_On` varchar(19) DEFAULT NULL,
  `Currency` varchar(17) DEFAULT NULL,
  `Current_Cost_pT` varchar(1) DEFAULT NULL,
  `Current_Cost_pT_Base` varchar(1) DEFAULT NULL,
  `Custom_Mix` varchar(2) DEFAULT NULL,
  `Delivery_created` varchar(19) DEFAULT NULL,
  `Description` varchar(1) DEFAULT NULL,
  `Discount_` varchar(1) DEFAULT NULL,
  `Discount_pT` varchar(1) DEFAULT NULL,
  `Discount_pT_Base` varchar(1) DEFAULT NULL,
  `Discount_notation` varchar(1) DEFAULT NULL,
  `Discount_type` varchar(3) DEFAULT NULL,
  `Exchange_Rate` decimal(7,5) DEFAULT NULL,
  `Feed_Days_Remaining` int(2) DEFAULT NULL,
  `Feed_QOH_Tonnes` decimal(5,2) DEFAULT NULL,
  `Feed_Rate_Kg_Day` decimal(4,2) DEFAULT NULL,
  `Feed_Type` varchar(5) DEFAULT NULL,
  `Freight_Amount` varchar(1) DEFAULT NULL,
  `Freight_Amount_Base` varchar(1) DEFAULT NULL,
  `Freight_Terms` varchar(1) DEFAULT NULL,
  `Herd_Size` int(3) DEFAULT NULL,
  `Ingredient_Price_Base` varchar(1) DEFAULT NULL,
  `Ingredients_Percentage_Total` varchar(1) DEFAULT NULL,
  `IsMostRecentOrderByCustomer` varchar(2) DEFAULT NULL,
  `IsMostRecentOrderByCustomerAndProduct` varchar(2) DEFAULT NULL,
  `Last_Submitted_to_Back_Office` varchar(1) DEFAULT NULL,
  `List_Price_pT` varchar(1) DEFAULT NULL,
  `Load_Due` date DEFAULT NULL,
  `me` varchar(1) DEFAULT NULL,
  `Modified_By` varchar(17) DEFAULT NULL,
  `Modified_By_Delegate` varchar(1) DEFAULT NULL,
  `Modified_On` varchar(18) DEFAULT NULL,
  `Opportunity` varchar(1) DEFAULT NULL,
  `Order_Discount_` varchar(1) DEFAULT NULL,
  `Order_Discount_Amount` varchar(1) DEFAULT NULL,
  `Order_Discount_Amount_Base` varchar(1) DEFAULT NULL,
  `Order_instructions` varchar(92) DEFAULT NULL,
  `Order_notification` varchar(2) DEFAULT NULL,
  `Owner` varchar(13) DEFAULT NULL,
  `Payment_Terms` varchar(1) DEFAULT NULL,
  `PntFin` varchar(2) DEFAULT NULL,
  `PntOpps` varchar(2) DEFAULT NULL,
  `Price_pT` decimal(6,2) DEFAULT NULL,
  `Price_pT_Base` varchar(8) DEFAULT NULL,
  `Price_List` varchar(6) DEFAULT NULL,
  `Price_Production` varchar(8) DEFAULT NULL,
  `Price_Production_Base` varchar(10) DEFAULT NULL,
  `Price_production_pT` decimal(5,2) DEFAULT NULL,
  `Price_production_pT_Base` varchar(7) DEFAULT NULL,
  `Price_Sub_Total` varchar(8) DEFAULT NULL,
  `Price_Sub_Total_Base` varchar(10) DEFAULT NULL,
  `Price_Total` varchar(9) DEFAULT NULL,
  `Price_Total_Base` varchar(11) DEFAULT NULL,
  `Price_Total_pT` decimal(6,2) DEFAULT NULL,
  `Price_Total_pT_Base` varchar(8) DEFAULT NULL,
  `Price_Transport` decimal(6,2) DEFAULT NULL,
  `Price_Transport_Base` varchar(8) DEFAULT NULL,
  `Price_transport_pT` decimal(5,2) DEFAULT NULL,
  `Price_transport_pT_Base` varchar(7) DEFAULT NULL,
  `Prices_Locked` varchar(2) DEFAULT NULL,
  `Priority` varchar(13) DEFAULT NULL,
  `Process` varchar(1) DEFAULT NULL,
  `Process_Stage` varchar(1) DEFAULT NULL,
  `Product` varchar(1) DEFAULT NULL,
  `Product_Category` varchar(12) DEFAULT NULL,
  `Product_Name` varchar(13) DEFAULT NULL,
  `Quote` varchar(1) DEFAULT NULL,
  `Record_Created_On` varchar(1) DEFAULT NULL,
  `Requested_Delivery_by` date DEFAULT NULL,
  `Second_Customer` varchar(30) DEFAULT NULL,
  `Second_customer_Order_percent` varchar(1) DEFAULT NULL,
  `Ship_To` varchar(7) DEFAULT NULL,
  `Ship_To_Address` varchar(1) DEFAULT NULL,
  `Ship_To_Name` varchar(1) DEFAULT NULL,
  `Ship_to_Contact_Name` varchar(1) DEFAULT NULL,
  `Ship_to_CountryRegion` varchar(1) DEFAULT NULL,
  `Ship_to_Fax` varchar(1) DEFAULT NULL,
  `Ship_to_Freight_Terms` varchar(13) DEFAULT NULL,
  `Ship_to_Phone` varchar(1) DEFAULT NULL,
  `Ship_to_Postal_Code` varchar(1) DEFAULT NULL,
  `Ship_to_StateProvince` varchar(1) DEFAULT NULL,
  `Ship_to_Street_1` varchar(1) DEFAULT NULL,
  `Ship_to_Street_2` varchar(1) DEFAULT NULL,
  `Ship_to_Street_3` varchar(1) DEFAULT NULL,
  `Ship_to_TownSuburbCity` varchar(1) DEFAULT NULL,
  `Shipping_Method` varchar(1) DEFAULT NULL,
  `Source_Campaign` varchar(1) DEFAULT NULL,
  `Standard_Cost_pT` varchar(1) DEFAULT NULL,
  `Standard_Cost_pT_Base` varchar(1) DEFAULT NULL,
  `Status` varchar(9) DEFAULT NULL,
  `Storage_Unit` varchar(12) DEFAULT NULL,
  `Submitted_Status` varchar(1) DEFAULT NULL,
  `Submitted_Status_Description` varchar(1) DEFAULT NULL,
  `Total_Amount` decimal(4,2) DEFAULT NULL,
  `Total_Amount_Base` varchar(6) DEFAULT NULL,
  `Total_Detail_Amount` decimal(4,2) DEFAULT NULL,
  `Total_Detail_Amount_Base` varchar(6) DEFAULT NULL,
  `Total_Discount_Amount` decimal(4,2) DEFAULT NULL,
  `Total_Discount_Amount_Base` varchar(6) DEFAULT NULL,
  `Total_Line_Item_Discount_Amount` decimal(4,2) DEFAULT NULL,
  `Total_Line_Item_Discount_Amount_Base` varchar(6) DEFAULT NULL,
  `Total_PreFreight_Amount` decimal(4,2) DEFAULT NULL,
  `Total_PreFreight_Amount_Base` varchar(6) DEFAULT NULL,
  `Total_Tax` decimal(4,2) DEFAULT NULL,
  `Total_Tax_Base` varchar(6) DEFAULT NULL,
  `triggerSubmit` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`Order_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_orders`
--

INSERT INTO `customer_orders` (`Order_ID`, `Customer`, `Name`, `Mix_Type`, `Qty_Tonnes`, `Nearest_Town`, `Date_Fulfilled`, `Date_Submitted`, `Status_Reason`, `Anticipated_Sales`, `Bill_To_Address`, `Bill_to_Contact_Name`, `Bill_To_Fax`, `Bill_To_Phone`, `Bill_to_Address_Name`, `Bill_to_CountryRegion`, `Bill_to_Postal_Code`, `Bill_to_StateProvince`, `Bill_to_Street_1`, `Bill_to_Street_2`, `Bill_to_Street_3`, `Bill_to_TownSuburbCity`, `Billing_company`, `Billing_company_admin_fee`, `Billing_company_admin_fee_Base`, `Billing_company_purchase_order`, `Billing_type`, `cp`, `Created_By`, `Created_By_Delegate`, `Created_On`, `Currency`, `Current_Cost_pT`, `Current_Cost_pT_Base`, `Custom_Mix`, `Delivery_created`, `Description`, `Discount_`, `Discount_pT`, `Discount_pT_Base`, `Discount_notation`, `Discount_type`, `Exchange_Rate`, `Feed_Days_Remaining`, `Feed_QOH_Tonnes`, `Feed_Rate_Kg_Day`, `Feed_Type`, `Freight_Amount`, `Freight_Amount_Base`, `Freight_Terms`, `Herd_Size`, `Ingredient_Price_Base`, `Ingredients_Percentage_Total`, `IsMostRecentOrderByCustomer`, `IsMostRecentOrderByCustomerAndProduct`, `Last_Submitted_to_Back_Office`, `List_Price_pT`, `Load_Due`, `me`, `Modified_By`, `Modified_By_Delegate`, `Modified_On`, `Opportunity`, `Order_Discount_`, `Order_Discount_Amount`, `Order_Discount_Amount_Base`, `Order_instructions`, `Order_notification`, `Owner`, `Payment_Terms`, `PntFin`, `PntOpps`, `Price_pT`, `Price_pT_Base`, `Price_List`, `Price_Production`, `Price_Production_Base`, `Price_production_pT`, `Price_production_pT_Base`, `Price_Sub_Total`, `Price_Sub_Total_Base`, `Price_Total`, `Price_Total_Base`, `Price_Total_pT`, `Price_Total_pT_Base`, `Price_Transport`, `Price_Transport_Base`, `Price_transport_pT`, `Price_transport_pT_Base`, `Prices_Locked`, `Priority`, `Process`, `Process_Stage`, `Product`, `Product_Category`, `Product_Name`, `Quote`, `Record_Created_On`, `Requested_Delivery_by`, `Second_Customer`, `Second_customer_Order_percent`, `Ship_To`, `Ship_To_Address`, `Ship_To_Name`, `Ship_to_Contact_Name`, `Ship_to_CountryRegion`, `Ship_to_Fax`, `Ship_to_Freight_Terms`, `Ship_to_Phone`, `Ship_to_Postal_Code`, `Ship_to_StateProvince`, `Ship_to_Street_1`, `Ship_to_Street_2`, `Ship_to_Street_3`, `Ship_to_TownSuburbCity`, `Shipping_Method`, `Source_Campaign`, `Standard_Cost_pT`, `Standard_Cost_pT_Base`, `Status`, `Storage_Unit`, `Submitted_Status`, `Submitted_Status_Description`, `Total_Amount`, `Total_Amount_Base`, `Total_Detail_Amount`, `Total_Detail_Amount_Base`, `Total_Discount_Amount`, `Total_Discount_Amount_Base`, `Total_Line_Item_Discount_Amount`, `Total_Line_Item_Discount_Amount_Base`, `Total_PreFreight_Amount`, `Total_PreFreight_Amount_Base`, `Total_Tax`, `Total_Tax_Base`, `triggerSubmit`) VALUES
('ORD14058', 'A & CJ Huts - Aristin Park (1)', 'A & CJ Huts - Aristin Park (1) - 25T - Pellet', '', 25, 'East Gippsland > Maffra > MAFFRA (223.52 KMs)', '0000-00-00', '0000-00-00', 'Complete', 'Yes', '', '', '', '', '', '', '', '', '', '', '', '', 'A & CJ Huts - Aristin Park (1)', '', '', '', 'Standard', '', 'Heath Killeen', '', '8/02/2013 2:51 PM', 'Australian Dollar', '', '', 'No', '8/02/2013 3:15 PM', '', '', '', '', '', 'N/A', '1.00000', 17, '25.00', '4.00', '12/16', '', '', '', 360, '', '', 'No', 'No', '', '', '0000-00-00', '', 'Trevor Paul', '', '8/02/2013 8:05 PM', '', '', '', '', 'New Client 25T 16%CP Pellets $355/T HK', 'No', 'Heath Killeen', '', 'No', 'No', '342.73', '$?342.73', 'Retail', '0.00', '$?0.00', NULL, '', '8,568.25', '$?8,568.25', '8,868.25', '$?8,868.25', '354.73', '$?354.73', '300.00', '$?300.00', '12.00', '$?12.00', 'No', 'Default Value', '', '', '', 'Pellet', 'PremiumPellet', '', '', '0000-00-00', 'A & CJ Huts - Aristin Park (1)', '', 'Address', '', '', '', '', '', 'Default Value', '', '', '', '', '', '', '', '', '', '', '', 'Fulfilled', 'Silo @ Dairy', '', '', '0.00', '$?0.00', '0.00', '$?0.00', '0.00', '$?0.00', '0.00', '$?0.00', '0.00', '$?0.00', '0.00', '$?0.00', ''),
('ORD14781', 'A & CJ Huts - Aristin Park (1)', 'A & CJ Huts - Aristin Park (1) - 14T - Mix - Custom', '', 14, 'East Gippsland > Maffra > MAFFRA (223.52 KMs)', '0000-00-00', '0000-00-00', 'Complete', 'Yes', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Standard', '', 'Heath Killeen', '', '24/03/2013 6:39 PM', 'Australian Dollar', '', '', 'No', '25/03/2013 8:09 AM', '', '', '', '', '', 'N/A', '1.00000', 7, '14.00', '5.00', '', '', '', '', 370, '', '', 'No', 'No', '', '', '0000-00-00', '', 'Madeleine Pinnuck', '', '27/03/2013 8:08 AM', '', '', '', '', 'MUST make sure wheat crushed well. 14T Custom mix Blower $435/T HK', 'No', 'Heath Killeen', '', 'No', 'No', '347.22', '$?347.22', 'Retail', '840.00', '$?840.00', '60.00', '$?60.00', '4,861.08', '$?4,861.08', '6,093.08', '$?6,093.08', '435.22', '$?435.22', '392.00', '$?392.00', '28.00', '$?28.00', 'No', 'Default Value', '', '', '', 'Mix - Custom', 'Custom', '', '', '0000-00-00', '', '', 'Address', '', '', '', '', '', 'Default Value', '', '', '', '', '', '', '', '', '', '', '', 'Fulfilled', 'Silo @ Dairy', '', '', '0.00', '$?0.00', '0.00', '$?0.00', '0.00', '$?0.00', '0.00', '$?0.00', '0.00', '$?0.00', '0.00', '$?0.00', ''),
('ORD15872', 'A & CJ Huts - Aristin Park (1)', 'A & CJ Huts - Aristin Park (1) - 28T - Mix - Custom', '', 28, 'East Gippsland > Maffra > MAFFRA (223.52 KMs)', '0000-00-00', '0000-00-00', 'Complete', 'Yes', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Standard', '', 'Heath Killeen', '', '23/05/2013 10:07 AM', 'Australian Dollar', '', '', 'No', '23/05/2013 11:37 AM', '', '', '', '', '', 'N/A', '1.00000', 16, '28.00', '5.00', '', '', '', '', 350, '', '', 'No', 'No', '', '', '0000-00-00', '', 'Trevor Paul', '', '23/05/2013 6:59 PM', '', '', '', '', 'MUST MAKE SURE WHEAT & BARLEY IS CRUSHED WELL. 28T Custom mix - Blower preferred. $432/T HK', 'No', 'Heath Killeen', '', 'No', 'No', '349.09', '$?349.09', 'Retail', '1,960.00', '$?1,960.00', '70.00', '$?70.00', '9,774.52', '$?9,774.52', '12,518.52', '$?12,518.52', '447.09', '$?447.09', '784.00', '$?784.00', '28.00', '$?28.00', 'No', 'Default Value', '', '', '', 'Mix - Custom', 'Custom', '', '', '0000-00-00', '', '', 'Address', '', '', '', '', '', 'Default Value', '', '', '', '', '', '', '', '', '', '', '', 'Fulfilled', 'Silo @ Dairy', '', '', '0.00', '$?0.00', '0.00', '$?0.00', '0.00', '$?0.00', '0.00', '$?0.00', '0.00', '$?0.00', '0.00', '$?0.00', ''),
('ORD16855', 'A & CJ Huts - Aristin Park (1)', 'A & CJ Huts - Aristin Park (1) - 12T - Mix - Custom', '', 12, 'East Gippsland > Maffra > MAFFRA (223.52 KMs)', '0000-00-00', '0000-00-00', 'Complete', 'Yes', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Standard', '', 'Heath Killeen', '', '19/07/2013 10:48 AM', 'Australian Dollar', '', '', 'No', '22/07/2013 8:41 AM', '', '', '', '', '', 'N/A', '1.00000', 8, '12.00', '6.00', '', '', '', '', 230, '', '', 'No', 'No', '', '', '0000-00-00', '', 'Trevor Paul', '', '22/07/2013 6:43 PM', '', '', '', '', 'MUST MAKE SURE BARLEY IS CRUSHED WELL. 12T Custom mix - Blower preferred. $423/T HK', 'No', 'Heath Killeen', '', 'No', 'No', '335.41', '$?335.41', 'Retail', '720.00', '$?720.00', '60.00', '$?60.00', '4,024.92', '$?4,024.92', '5,080.92', '$?5,080.92', '423.41', '$?423.41', '336.00', '$?336.00', '28.00', '$?28.00', 'No', 'Default Value', '', '', '', 'Mix - Custom', 'Custom', '', '', '0000-00-00', '', '', 'Address', '', '', '', '', '', 'Default Value', '', '', '', '', '', '', '', '', '', '', '', 'Fulfilled', 'Silo @ Dairy', '', '', '0.00', '$?0.00', '0.00', '$?0.00', '0.00', '$?0.00', '0.00', '$?0.00', '0.00', '$?0.00', '0.00', '$?0.00', ''),
('ORD23934', 'A & CJ Huts - Aristin Park (1)', 'A & CJ Huts - Aristin Park (1) - 16T - Mix - Custom', '', 16, 'East Gippsland > Maffra > MAFFRA (223.52 KMs)', '0000-00-00', '0000-00-00', 'Complete', 'Yes', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'Standard', '', 'Heath Killeen', '', '4/08/2014 3:31 PM', 'Australian Dollar', '', '', 'No', '7/08/2014 10:39 AM', '', '', '', '', '', 'N/A', '1.00000', 21, '16.00', '5.00', '', '', '', '', 150, '', '', 'No', 'No', '', '', '0000-00-00', '', 'Trevor Paul', '', '11/08/2014 7:22 AM', '', '', '', '', 'MUST MAKE SURE BARLEY IS CRUSHED WELL. 16T ONLY - Custom mix - Blower preferred - $426/T HK.', 'No', 'Heath Killeen', '', 'No', 'No', '336.26', '$?336.26', 'Retail', '960.00', '$?960.00', '60.00', '$?60.00', '5,380.16', '$?5,380.16', '6,820.16', '$?6,820.16', '426.26', '$?426.26', '480.00', '$?480.00', '30.00', '$?30.00', 'No', 'Default Value', '', '', '', 'Mix - Custom', 'Custom', '', '', '0000-00-00', '', '', 'Address', '', '', '', '', '', 'Default Value', '', '', '', '', '', '', '', '', '', '', '', 'Fulfilled', 'Silo @ Dairy', '', '', '0.00', '$?0.00', '0.00', '$?0.00', '0.00', '$?0.00', '0.00', '$?0.00', '0.00', '$?0.00', '0.00', '$?0.00', '');

-- --------------------------------------------------------

--
-- Table structure for table `lookup`
--

CREATE TABLE IF NOT EXISTS `lookup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `code` int(11) NOT NULL,
  `type` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1433553028),
('m141022_115823_create_user_table', 1433553030),
('m141022_115912_create_rbac_tables', 1433553031),
('m150104_153617_create_article_table', 1433553031);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_activation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password_hash`, `status`, `auth_key`, `password_reset_token`, `account_activation_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'irwinadmin@dontcare.com', '$2y$13$PM9EgiPszjILfhuwA67INev/j6IhkRRLlKuILGoUF0e/tbv3vqzgO', 10, 'K9DSfWCgnqcohlUsKWERlLLljhrlz4jB', NULL, NULL, 1433825724, 1433830504);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
