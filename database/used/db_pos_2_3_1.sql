-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2016 at 08:05 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_pos_2.3.1`
--

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

CREATE TABLE IF NOT EXISTS `keys` (
  `id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_app_config`
--

CREATE TABLE IF NOT EXISTS `ospos_app_config` (
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_app_config`
--

INSERT INTO `ospos_app_config` (`key`, `value`) VALUES
('address', '123 Nowhere street'),
('company', 'Open Source Point of Sale'),
('default_tax_rate', '8'),
('email', 'admin@pappastech.com'),
('fax', ''),
('phone', '555-555-5555'),
('recv_invoice_format', '$CO'),
('return_policy', 'Test'),
('sales_invoice_format', '$CO'),
('tax_included', '0'),
('timezone', 'America/New_York'),
('website', '');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_curl_log`
--

CREATE TABLE IF NOT EXISTS `ospos_curl_log` (
  `curl_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `data` text NOT NULL,
  `curl_status` tinyint(4) NOT NULL,
  `curl_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `curl_type` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_curl_log`
--

INSERT INTO `ospos_curl_log` (`curl_id`, `receiver_id`, `data`, `curl_status`, `curl_timestamp`, `curl_type`, `status`) VALUES
(78, 3, '{"path":"insertPayment","customer_id":"33","person_data":{"first_name":"curl","last_name":"customer","email":"curl@gmail.com","phone_number":"923009894706","address_1":"address1","address_2":"address2","city":"lhr","state":"pu","zip":"12345","country":"pak","comments":"ccc"},"customer_data":{"account_number":"10005","taxable":1}}', 0, '2016-04-24 02:49:35', 1, 1),
(79, 3, '{"path":"insertPayment","customer_id":"33","person_data":{"first_name":"curl","last_name":"customer","email":"curl@gmail.com","phone_number":"923009894706","address_1":"address1","address_2":"address2","city":"lhr","state":"pu","zip":"12345","country":"pak","comments":"ccc"},"customer_data":{"account_number":"10005","taxable":1}}', 1, '2016-04-24 11:51:38', 1, 1),
(80, 3, '{"path":"insertPayment","customer_id":"27","person_data":{"first_name":"zaheer","last_name":"ahmad","email":"","phone_number":"","address_1":"","address_2":"","city":"","state":"","zip":"","country":"","comments":""},"customer_data":{"account_number":null,"taxable":1}}', 1, '2016-04-24 11:55:06', 1, 1),
(81, 3, '{"path":"insertPayment","customer_id":"27","person_data":{"first_name":"zaheer","last_name":"ahmad","email":"","phone_number":"","address_1":"","address_2":"","city":"","state":"","zip":"","country":"","comments":""},"customer_data":{"account_number":null,"taxable":1}}', 1, '2016-04-24 11:58:08', 1, 1),
(82, 3, '["6"]', 1, '2016-04-24 15:07:57', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_customers`
--

CREATE TABLE IF NOT EXISTS `ospos_customers` (
  `person_id` int(10) NOT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `taxable` int(1) NOT NULL DEFAULT '1',
  `deleted` int(1) NOT NULL DEFAULT '0',
  `balance` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_customers`
--

INSERT INTO `ospos_customers` (`person_id`, `account_number`, `taxable`, `deleted`, `balance`) VALUES
(2, NULL, 1, 0, 242),
(4, NULL, 1, 0, 100),
(5, NULL, 1, 0, 4010),
(27, NULL, 1, 0, 0),
(28, '1000', 1, 0, 0),
(30, NULL, 0, 1, 0),
(31, NULL, 0, 0, 0),
(32, NULL, 0, 0, 0),
(33, '10005', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_employees`
--

CREATE TABLE IF NOT EXISTS `ospos_employees` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `person_id` int(10) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_employees`
--

INSERT INTO `ospos_employees` (`username`, `password`, `person_id`, `deleted`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_giftcards`
--

CREATE TABLE IF NOT EXISTS `ospos_giftcards` (
  `record_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `giftcard_id` int(11) NOT NULL,
  `giftcard_number` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `person_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_global_config`
--

CREATE TABLE IF NOT EXISTS `ospos_global_config` (
  `global_id` int(11) NOT NULL,
  `callout` tinyint(4) NOT NULL,
  `url` text NOT NULL,
  `error_email` varchar(255) NOT NULL,
  `is_secure` tinyint(4) NOT NULL,
  `authorization_token` text NOT NULL,
  `authorization_username` varchar(255) NOT NULL,
  `authorization_password` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_global_config`
--

INSERT INTO `ospos_global_config` (`global_id`, `callout`, `url`, `error_email`, `is_secure`, `authorization_token`, `authorization_username`, `authorization_password`, `status`) VALUES
(3, 1, 'http://localhost/test/curl_receiver.php', 'link2mohsin22@gmail.com', 1, '3432424dsfaf', 'admin', 'admin', 1),
(4, 1, 'http://localhost/salman/pos_2.3/index.php/curl_receiver', 'link2mohsin22@gmail.com', 1, '3432424dsfaf', 'admin', 'admin', 0),
(5, 0, 'localhost/test/sha3/src/usage.php', 'link2mohsin22@gmail.com', 0, '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_grants`
--

CREATE TABLE IF NOT EXISTS `ospos_grants` (
  `permission_id` varchar(255) NOT NULL,
  `person_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_grants`
--

INSERT INTO `ospos_grants` (`permission_id`, `person_id`) VALUES
('config', 1),
('customers', 1),
('employees', 1),
('giftcards', 1),
('items', 1),
('items_stock', 1),
('item_kits', 1),
('logs', 1),
('receivings', 1),
('reports', 1),
('reports_categories', 1),
('reports_customers', 1),
('reports_discounts', 1),
('reports_employees', 1),
('reports_inventory', 1),
('reports_items', 1),
('reports_payments', 1),
('reports_receivings', 1),
('reports_sales', 1),
('reports_suppliers', 1),
('reports_taxes', 1),
('sales', 1),
('suppliers', 1),
('web_hooks', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_inventory`
--

CREATE TABLE IF NOT EXISTS `ospos_inventory` (
  `trans_id` int(11) NOT NULL,
  `trans_items` int(11) NOT NULL DEFAULT '0',
  `trans_user` int(11) NOT NULL DEFAULT '0',
  `trans_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `trans_comment` text NOT NULL,
  `trans_location` int(11) NOT NULL,
  `trans_inventory` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_inventory`
--

INSERT INTO `ospos_inventory` (`trans_id`, `trans_items`, `trans_user`, `trans_date`, `trans_comment`, `trans_location`, `trans_inventory`) VALUES
(1, 1, 1, '2016-03-19 09:02:09', 'Manual Edit of Quantity', 1, 8),
(2, 1, 1, '2016-03-19 09:13:09', 'RECV 1', 1, 1),
(3, 1, 1, '2016-03-19 09:22:33', 'POS 1', 1, -1),
(4, 1, 1, '2016-03-19 09:24:20', 'POS 2', 1, -1),
(5, 1, 1, '2016-03-19 20:00:43', 'POS 3', 1, -1),
(6, 1, 1, '2016-03-19 20:15:54', 'POS 4', 1, -1),
(7, 1, 1, '2016-03-19 20:20:23', 'POS 5', 1, -1),
(8, 1, 1, '2016-03-19 22:56:13', 'Deleting sale 1', 0, 1),
(9, 1, 1, '2016-03-19 22:56:21', 'Deleting sale 2', 0, 1),
(10, 1, 1, '2016-03-19 22:56:42', 'Deleting sale 3', 0, 1),
(11, 1, 1, '2016-03-19 22:56:54', 'Deleting sale 4', 0, 1),
(12, 1, 1, '2016-03-19 22:57:03', 'Deleting sale 5', 0, 1),
(13, 1, 1, '2016-03-19 22:57:47', 'POS 6', 1, -1),
(14, 2, 1, '2016-03-19 23:08:50', 'Manual Edit of Quantity', 1, 10),
(15, 2, 1, '2016-03-19 23:09:40', 'POS 7', 1, -1),
(16, 1, 1, '2016-03-19 23:09:40', 'POS 7', 1, -1),
(17, 2, 1, '2016-03-19 23:12:22', 'POS 8', 1, -1),
(18, 2, 1, '2016-03-20 07:02:29', 'POS 9', 1, -1),
(19, 2, 1, '2016-03-20 11:15:36', 'POS 10', 1, -1),
(20, 2, 1, '2016-03-21 10:35:23', 'POS 11', 1, -1),
(21, 2, 1, '2016-03-21 12:08:40', 'POS 12', 1, -1),
(22, 2, 1, '2016-03-21 12:28:18', 'POS 13', 1, -1),
(23, 2, 1, '2016-03-21 12:37:47', 'POS 14', 1, -1),
(24, 1, 1, '2016-03-21 12:38:33', 'POS 15', 1, -1),
(25, 1, 1, '2016-03-21 12:40:18', 'POS 16', 1, -1),
(26, 2, 1, '2016-03-22 07:38:24', 'POS 17', 1, -1),
(27, 2, 1, '2016-03-22 07:42:22', 'POS 18', 1, -1),
(28, 2, 1, '2016-03-23 05:01:21', 'Deleting sale 18', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_items`
--

CREATE TABLE IF NOT EXISTS `ospos_items` (
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `item_number` varchar(255) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `cost_price` decimal(15,2) NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `reorder_level` decimal(15,2) NOT NULL DEFAULT '0.00',
  `receiving_quantity` int(11) NOT NULL DEFAULT '1',
  `item_id` int(10) NOT NULL,
  `allow_alt_description` tinyint(1) NOT NULL,
  `is_serialized` tinyint(1) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `custom1` varchar(25) NOT NULL,
  `custom2` varchar(25) NOT NULL,
  `custom3` varchar(25) NOT NULL,
  `custom4` varchar(25) NOT NULL,
  `custom5` varchar(25) NOT NULL,
  `custom6` varchar(25) NOT NULL,
  `custom7` varchar(25) NOT NULL,
  `custom8` varchar(25) NOT NULL,
  `custom9` varchar(25) NOT NULL,
  `custom10` varchar(25) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_items`
--

INSERT INTO `ospos_items` (`name`, `category`, `supplier_id`, `item_number`, `description`, `cost_price`, `unit_price`, `reorder_level`, `receiving_quantity`, `item_id`, `allow_alt_description`, `is_serialized`, `deleted`, `custom1`, `custom2`, `custom3`, `custom4`, `custom5`, `custom6`, `custom7`, `custom8`, `custom9`, `custom10`) VALUES
('iphone6', 'Mobile', 3, NULL, '', '500.00', '450.00', '6.00', 0, 1, 0, 0, 0, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'),
('iphone5', 'Mobile', 3, NULL, '', '200.00', '150.00', '3.00', 0, 2, 0, 0, 0, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_items_taxes`
--

CREATE TABLE IF NOT EXISTS `ospos_items_taxes` (
  `item_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `percent` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_item_kits`
--

CREATE TABLE IF NOT EXISTS `ospos_item_kits` (
  `item_kit_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_item_kits`
--

INSERT INTO `ospos_item_kits` (`item_kit_id`, `name`, `description`) VALUES
(1, 'Mobiles', '');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_item_kit_items`
--

CREATE TABLE IF NOT EXISTS `ospos_item_kit_items` (
  `item_kit_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_item_quantities`
--

CREATE TABLE IF NOT EXISTS `ospos_item_quantities` (
  `item_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_item_quantities`
--

INSERT INTO `ospos_item_quantities` (`item_id`, `location_id`, `quantity`) VALUES
(1, 1, 0),
(2, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_modules`
--

CREATE TABLE IF NOT EXISTS `ospos_modules` (
  `name_lang_key` varchar(255) NOT NULL,
  `desc_lang_key` varchar(255) NOT NULL,
  `sort` int(10) NOT NULL,
  `module_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_modules`
--

INSERT INTO `ospos_modules` (`name_lang_key`, `desc_lang_key`, `sort`, `module_id`) VALUES
('module_config', 'module_config_desc', 100, 'config'),
('module_customers', 'module_customers_desc', 10, 'customers'),
('module_employees', 'module_employees_desc', 80, 'employees'),
('module_giftcards', 'module_giftcards_desc', 90, 'giftcards'),
('module_items', 'module_items_desc', 20, 'items'),
('module_item_kits', 'module_item_kits_desc', 30, 'item_kits'),
('module_logs', 'module_logs_desc', 110, 'logs'),
('module_receivings', 'module_receivings_desc', 60, 'receivings'),
('module_reports', 'module_reports_desc', 50, 'reports'),
('module_sales', 'module_sales_desc', 70, 'sales'),
('module_suppliers', 'module_suppliers_desc', 40, 'suppliers'),
('module_web_hooks', 'module_web_hooks_desc', 120, 'web_hooks');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_module_web_hooks`
--

CREATE TABLE IF NOT EXISTS `ospos_module_web_hooks` (
  `module_hook_id` int(11) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `callout_event` varchar(255) NOT NULL,
  `module_web_hooks_url` varchar(255) NOT NULL,
  `module_is_secure` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_module_web_hooks`
--

INSERT INTO `ospos_module_web_hooks` (`module_hook_id`, `module_name`, `callout_event`, `module_web_hooks_url`, `module_is_secure`, `status`) VALUES
(1, 'sales', 'create', 'localhost/abc', 0, 1),
(2, 'config', 'create', 'localhost/abced', 0, 1),
(3, 'employees', 'create', 'localhost/abc', 1, 0),
(4, 'web_hooks', 'create', 'localhost/abc', 0, 0),
(5, 'config', 'create', 'localhost/abc', 0, 1),
(6, 'config', 'create', 'localhost/abc', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_people`
--

CREATE TABLE IF NOT EXISTS `ospos_people` (
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `comments` text NOT NULL,
  `person_id` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_people`
--

INSERT INTO `ospos_people` (`first_name`, `last_name`, `phone_number`, `email`, `address_1`, `address_2`, `city`, `state`, `zip`, `country`, `comments`, `person_id`) VALUES
('John', 'Doe', '555-555-5555', 'admin@pappastech.com', 'Address 1', '', '', '', '', '', '', 1),
('Mr', 'Customer1', '', '', '', '', '', '', '', '', '', 2),
('iOS', 'Supplier', '', '', '', '', '', '', '', '', '', 3),
('Miss', 'Customer2', '', '', '', '', '', '', '', '', '', 4),
('test', 'customer', '', '', '', '', '', '', '', '', '', 5),
('zaheer', 'ahmad', '', '', '', '', '', '', '', '', '', 27),
('Fawad', 'Aslam', '923009894706', 'fawad@gmail.com', 'address1', 'address2', 'lhr', 'pu', '12345', 'pak', 'Comments', 28),
('Mohsin', 'last_name', 'phone_number', 'email', 'address_1', 'address_2', 'city', 'state', 'zip', 'country', 'comments', 30),
('Mohsin', 'last_name', 'phone_number', 'email', 'address_1', 'address_2', 'city', 'state', 'zip', 'country', 'comments', 31),
('first_name', 'last_name', 'phone_number', 'email', 'address_1', 'address_2', 'city', 'state', 'zip', 'country', 'comments', 32),
('curl', 'customer', '923009894706', 'curl@gmail.com', 'address1', 'address2', 'lhr', 'pu', '12345', 'pak', 'ccc', 33);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_permissions`
--

CREATE TABLE IF NOT EXISTS `ospos_permissions` (
  `permission_id` varchar(255) NOT NULL,
  `module_id` varchar(255) NOT NULL,
  `location_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_permissions`
--

INSERT INTO `ospos_permissions` (`permission_id`, `module_id`, `location_id`) VALUES
('config', 'config', NULL),
('customers', 'customers', NULL),
('employees', 'employees', NULL),
('giftcards', 'giftcards', NULL),
('items', 'items', NULL),
('items_stock', 'items', 1),
('item_kits', 'item_kits', NULL),
('logs', 'logs', NULL),
('receivings', 'receivings', NULL),
('reports', 'reports', NULL),
('reports_categories', 'reports', NULL),
('reports_customers', 'reports', NULL),
('reports_discounts', 'reports', NULL),
('reports_employees', 'reports', NULL),
('reports_inventory', 'reports', NULL),
('reports_items', 'reports', NULL),
('reports_payments', 'reports', NULL),
('reports_receivings', 'reports', NULL),
('reports_sales', 'reports', NULL),
('reports_suppliers', 'reports', NULL),
('reports_taxes', 'reports', NULL),
('sales', 'sales', NULL),
('suppliers', 'suppliers', NULL),
('web_hooks', 'web_hooks', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_receivings`
--

CREATE TABLE IF NOT EXISTS `ospos_receivings` (
  `receiving_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `supplier_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `receiving_id` int(10) NOT NULL,
  `payment_type` varchar(20) DEFAULT NULL,
  `invoice_number` varchar(32) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_receivings`
--

INSERT INTO `ospos_receivings` (`receiving_time`, `supplier_id`, `employee_id`, `comment`, `receiving_id`, `payment_type`, `invoice_number`) VALUES
('2016-03-19 18:13:09', NULL, 1, '', 1, 'Check', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_receivings_items`
--

CREATE TABLE IF NOT EXISTS `ospos_receivings_items` (
  `receiving_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(30) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL,
  `quantity_purchased` decimal(15,2) NOT NULL DEFAULT '0.00',
  `item_cost_price` decimal(15,2) NOT NULL,
  `item_unit_price` decimal(15,2) NOT NULL,
  `discount_percent` decimal(15,2) NOT NULL DEFAULT '0.00',
  `item_location` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_receivings_items`
--

INSERT INTO `ospos_receivings_items` (`receiving_id`, `item_id`, `description`, `serialnumber`, `line`, `quantity_purchased`, `item_cost_price`, `item_unit_price`, `discount_percent`, `item_location`) VALUES
(1, 1, '', '', 1, '1.00', '500.00', '500.00', '0.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales`
--

CREATE TABLE IF NOT EXISTS `ospos_sales` (
  `sale_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `invoice_number` varchar(32) DEFAULT NULL,
  `sale_id` int(10) NOT NULL,
  `payment_type` varchar(512) DEFAULT NULL,
  `sales_balance` double NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_sales`
--

INSERT INTO `ospos_sales` (`sale_time`, `customer_id`, `employee_id`, `comment`, `invoice_number`, `sale_id`, `payment_type`, `sales_balance`) VALUES
('2016-03-19 19:00:00', NULL, 1, '0', NULL, 6, 'Cash: $50.00<br />Sales Credit: $400.00<br />', 461),
('2016-03-19 19:00:00', NULL, 1, '0', NULL, 7, 'Check: $50.00<br />Cash: $250.00<br />Sales Credit: $400.00<br />', 446),
('2016-03-19 19:00:00', NULL, 1, '0', NULL, 8, 'Cash: $147.00<br />', 10),
('2016-03-19 19:00:00', 2, 1, 'sales credit payment update', NULL, 9, 'Cash: $50.00<br />Check: $50.00<br />Sales Credit: $50.00<br />', 30),
('2016-03-20 11:15:36', NULL, 1, 'k', NULL, 10, 'Cash: $250.00<br />', 0),
('2016-03-21 10:35:23', 2, 1, '0', NULL, 11, 'Cash: $50.00<br />Check: $50.00<br />Sales Credit: $50.00<br />', 162),
('2016-03-21 12:08:39', 2, 1, '0', NULL, 12, 'Cash: $50.00<br />Check: $50.00<br />Sales Credit: $50.00<br />', 0),
('2016-03-21 12:28:18', 2, 1, '0', NULL, 13, 'Sales Credit: $50.00<br />Cash: $50.00<br />Check: $50.00<br />', 50),
('2016-03-21 12:37:47', 4, 1, '0', NULL, 14, 'Cash: $50.00<br />Check: $50.00<br />Sales Credit: $50.00<br />', 50),
('2016-03-21 12:38:33', 4, 1, '0', NULL, 15, 'Check: $550.00<br />', 0),
('2016-03-21 12:40:18', 4, 1, '0', NULL, 16, 'Cash: $350.00<br />Sales Credit: $100.00<br />', 50),
('2016-03-21 19:00:00', 5, 1, 'testing', '2009', 17, 'Cash: $150.00<br />', 4010);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_items`
--

CREATE TABLE IF NOT EXISTS `ospos_sales_items` (
  `sale_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(30) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `quantity_purchased` decimal(15,2) NOT NULL DEFAULT '0.00',
  `item_cost_price` decimal(15,2) NOT NULL,
  `item_unit_price` decimal(15,2) NOT NULL,
  `discount_percent` decimal(15,2) NOT NULL DEFAULT '0.00',
  `item_location` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_sales_items`
--

INSERT INTO `ospos_sales_items` (`sale_id`, `item_id`, `description`, `serialnumber`, `line`, `quantity_purchased`, `item_cost_price`, `item_unit_price`, `discount_percent`, `item_location`) VALUES
(6, 1, '', '', 1, '1.00', '500.00', '450.00', '0.00', 1),
(7, 1, '', '', 2, '1.00', '500.00', '450.00', '0.00', 1),
(7, 2, '', '', 1, '1.00', '200.00', '150.00', '0.00', 1),
(8, 2, '', '', 1, '1.00', '200.00', '150.00', '2.00', 1),
(9, 2, '', '', 1, '1.00', '200.00', '150.00', '0.00', 1),
(10, 2, '', '', 1, '1.00', '200.00', '150.00', '0.00', 1),
(11, 2, '', '', 1, '1.00', '200.00', '150.00', '0.00', 1),
(12, 2, '', '', 1, '1.00', '200.00', '150.00', '0.00', 1),
(13, 2, '', '', 1, '1.00', '200.00', '150.00', '0.00', 1),
(14, 2, '', '', 1, '1.00', '200.00', '150.00', '0.00', 1),
(15, 1, '', '', 1, '1.00', '500.00', '450.00', '0.00', 1),
(16, 1, '', '', 1, '1.00', '500.00', '450.00', '0.00', 1),
(17, 2, '', '', 1, '1.00', '200.00', '150.00', '0.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_items_taxes`
--

CREATE TABLE IF NOT EXISTS `ospos_sales_items_taxes` (
  `sale_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `percent` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_payments`
--

CREATE TABLE IF NOT EXISTS `ospos_sales_payments` (
  `sale_id` int(10) NOT NULL,
  `payment_type` varchar(40) NOT NULL,
  `payment_amount` decimal(15,2) NOT NULL,
  `is_received` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_sales_payments`
--

INSERT INTO `ospos_sales_payments` (`sale_id`, `payment_type`, `payment_amount`, `is_received`) VALUES
(6, 'Cash', '880.00', NULL),
(6, 'Received Payment', '37.00', NULL),
(6, 'Sales Credit', '400.00', NULL),
(7, 'Cash', '250.00', NULL),
(7, 'Check', '50.00', NULL),
(7, 'Received Payment', '746.00', NULL),
(7, 'Sales Credit', '400.00', NULL),
(8, 'Cash', '147.00', NULL),
(8, 'Received Payment', '10.00', 1),
(9, 'Cash', '50.00', NULL),
(9, 'Check', '50.00', NULL),
(9, 'Received Payment', '2580.00', NULL),
(9, 'Sales Credit', '2500.00', NULL),
(10, 'Cash', '250.00', NULL),
(11, 'Cash', '50.00', 1),
(11, 'Check', '50.00', 1),
(11, 'Received Payment', '212.00', 1),
(11, 'Sales Credit', '50.00', 0),
(12, 'Cash', '50.00', 1),
(12, 'Check', '50.00', 1),
(12, 'Received Payment', '-3.00', 1),
(12, 'Sales Credit', '50.00', 0),
(13, 'Cash', '50.00', 1),
(13, 'Check', '50.00', 1),
(13, 'Received Payment', '100.00', 1),
(13, 'Sales Credit', '50.00', 0),
(14, 'Cash', '50.00', 1),
(14, 'Check', '50.00', 1),
(14, 'Received Payment', '100.00', 1),
(14, 'Sales Credit', '50.00', 0),
(15, 'Check', '550.00', 1),
(16, 'Cash', '350.00', 1),
(16, 'Received Payment', '150.00', 1),
(16, 'Sales Credit', '100.00', 0),
(17, 'Cash', '150.00', 1),
(17, 'Received Payment', '4010.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_suspended`
--

CREATE TABLE IF NOT EXISTS `ospos_sales_suspended` (
  `sale_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `customer_id` int(10) DEFAULT NULL,
  `employee_id` int(10) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `invoice_number` varchar(32) DEFAULT NULL,
  `sale_id` int(10) NOT NULL,
  `payment_type` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_suspended_items`
--

CREATE TABLE IF NOT EXISTS `ospos_sales_suspended_items` (
  `sale_id` int(10) NOT NULL DEFAULT '0',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `description` varchar(30) DEFAULT NULL,
  `serialnumber` varchar(30) DEFAULT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `quantity_purchased` decimal(15,2) NOT NULL DEFAULT '0.00',
  `item_cost_price` decimal(15,2) NOT NULL,
  `item_unit_price` decimal(15,2) NOT NULL,
  `discount_percent` decimal(15,2) NOT NULL DEFAULT '0.00',
  `item_location` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_suspended_items_taxes`
--

CREATE TABLE IF NOT EXISTS `ospos_sales_suspended_items_taxes` (
  `sale_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `line` int(3) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `percent` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sales_suspended_payments`
--

CREATE TABLE IF NOT EXISTS `ospos_sales_suspended_payments` (
  `sale_id` int(10) NOT NULL,
  `payment_type` varchar(40) NOT NULL,
  `payment_amount` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ospos_sessions`
--

CREATE TABLE IF NOT EXISTS `ospos_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_sessions`
--

INSERT INTO `ospos_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('019687f001810cb0574d1d79272afd8f', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459002790, ''),
('01f69db385fc29454cd7dd6511cc0fe3', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056448, ''),
('05b658d85fb2bb987c61dc21dc76d2d6', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056276, ''),
('062e166c430d04e8d0a992a1133c2afc', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459006920, ''),
('0843c75bfcfcedee9cf18fd2e5fa541e', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056448, ''),
('096cda9190aeaf8745d44cea4ab75248', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056276, ''),
('09e796680e949968a36b58c24c8044ce', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056448, ''),
('0afab649038ae16cad13a70d90449f44', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056448, ''),
('0cab7c5145b800af2cea0ce8cb72c7aa', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056276, ''),
('0e7d741695260d472cb9b2a4bf5ec303', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056273, ''),
('1082a1f49a0ce740cacb76deaf84fb9c', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056276, ''),
('13b62257633f504ae073857c5e3978ec', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056276, ''),
('14498de9dbd3099f80475062f3dcebe6', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056271, 'a:13:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";s:8:"cartRecv";a:0:{}s:9:"recv_mode";s:7:"receive";s:8:"supplier";i:-1;s:19:"recv_invoice_number";s:1:"0";s:4:"cart";a:0:{}s:9:"sale_mode";s:4:"sale";s:13:"sale_location";s:1:"1";s:8:"customer";i:-1;s:8:"payments";a:0:{}s:20:"sales_invoice_number";s:1:"1";s:13:"item_location";s:1:"1";}'),
('16a6b0a0edba059a6b06eedc82d08489', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459008371, 'a:6:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";s:8:"cartRecv";a:0:{}s:9:"recv_mode";s:7:"receive";s:8:"supplier";i:-1;s:19:"recv_invoice_number";s:1:"0";}'),
('1a81362ce122235d5fdd2fa634cef59a', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459006920, ''),
('1b1a845da6dbc31bbab1640e7499eb83', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459005174, ''),
('1ba64d66920412b0613ac3d4ca048ed3', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1458741359, ''),
('1ef01555ca98a67fbff48a6f83428837', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459008327, ''),
('1fc9aeacbbc33faae20abc10942c8eaf', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459005174, ''),
('22802663e3aa23fb5b01749a846d38c9', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459005174, ''),
('26e6e6247203e1855b5a16c3293b0529', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459006920, ''),
('270630bd475643650a42f03ed665f4ec', '::1', '0', 1459892453, ''),
('2db8a1ab723aa1db4b910ad758b44808', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1461442357, ''),
('2eb21ebbd69f4293050c33143178c760', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459005174, ''),
('2ee26562adb24f2bee2af30f9926f88b', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1458738482, 'a:8:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";s:4:"cart";a:0:{}s:9:"sale_mode";s:4:"sale";s:13:"sale_location";s:1:"1";s:8:"customer";i:-1;s:8:"payments";a:0:{}s:20:"sales_invoice_number";s:1:"2";}'),
('32f0d899cd0dbca0faa88e818c64d3ae', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459008372, ''),
('331e212cb2f01a8797d745e88a75a960', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1461478830, 'a:2:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";}'),
('365262ef3e10a11531a2a31f853223c6', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459008372, ''),
('36e273eb67daf5507b4160b71856a2c3', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056273, ''),
('37c273384500aa1f2da17cfe185bebaa', '::1', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.110 Safari/537.36', 1459891431, ''),
('3ab80c4916e3c5d2094a138cc42397f8', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1458412261, 'a:2:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";}'),
('3e7455bed5a9f587bcebca206537a962', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459006920, ''),
('3e9f0780b625f611eb4e56183c51b2e1', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459005175, ''),
('474c429d2b2c5c832af0fe13a5bf2759', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056275, ''),
('4a03885843ec84bf1264b4fa09d7e76f', '::1', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.112 Safari/537.36', 1461267993, 'a:2:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";}'),
('4dbf5c4bfeddc03e676964d8db91d2ed', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459008327, ''),
('4fac7448d343b52e0490b6ca46782e63', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056272, ''),
('5465079823515d57818e846391b41e22', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056276, ''),
('56832e9b87d691a70f1e6b320e15b348', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056276, ''),
('57ffcdbf2db93a473819f2c1e740139a', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459005174, 'a:6:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";s:8:"cartRecv";a:0:{}s:9:"recv_mode";s:7:"receive";s:8:"supplier";i:-1;s:19:"recv_invoice_number";s:1:"0";}'),
('596a3cde2b80c92e9d4a1989dda0eec6', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459005175, ''),
('64ea80c0d05c0c074bd396140adae2c1', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459006920, ''),
('6728487d36bd6d20191c9420ac823f63', '::1', '0', 1459892328, ''),
('68fe201c459c9a3260cfae014f6be205', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1459889028, 'a:8:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";s:4:"cart";a:0:{}s:9:"sale_mode";s:4:"sale";s:13:"sale_location";s:1:"1";s:8:"customer";i:-1;s:8:"payments";a:0:{}s:20:"sales_invoice_number";s:1:"1";}'),
('6a6ada61d608f039e3c9404e23f7a2d2', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459005174, ''),
('6e1bf5a76aa2c15610faedb1e31629eb', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1461181093, 'a:11:{s:9:"person_id";s:1:"1";s:8:"cartRecv";a:0:{}s:9:"recv_mode";s:7:"receive";s:8:"supplier";i:-1;s:19:"recv_invoice_number";s:1:"0";s:4:"cart";a:0:{}s:9:"sale_mode";s:4:"sale";s:13:"sale_location";s:1:"1";s:8:"customer";i:-1;s:8:"payments";a:0:{}s:20:"sales_invoice_number";s:1:"1";}'),
('70a0d46d3f0e85b9a523c80adff36c24', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056448, ''),
('7345d38bd78320ef28755b30ca96fc56', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1461441226, ''),
('7364a4ba35b87536bff7556a86f3171a', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459005174, ''),
('7a4a7e9b111a7b99f99f07a8ba072738', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459008327, ''),
('7af67218f4b2d2b677deaea7256cc03f', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1458741359, 'a:11:{s:9:"person_id";s:1:"1";s:4:"cart";a:0:{}s:9:"sale_mode";s:4:"sale";s:13:"sale_location";s:1:"1";s:8:"customer";i:-1;s:8:"payments";a:0:{}s:20:"sales_invoice_number";s:1:"2";s:8:"cartRecv";a:0:{}s:9:"recv_mode";s:7:"receive";s:8:"supplier";i:-1;s:19:"recv_invoice_number";s:1:"0";}'),
('8dca87dd9d49d77996efe06305a55e92', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056275, ''),
('8ef99355e09555cc9bbf04345024143c', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459008327, ''),
('936a7f1277cd0a56791108119204722e', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459006920, ''),
('93952c5d4b725a86d28ab55c73cebbcc', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1458411206, 'a:11:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";s:13:"item_location";s:1:"1";s:9:"recv_mode";s:7:"receive";s:17:"recv_stock_source";s:1:"1";s:13:"sale_location";s:1:"1";s:4:"cart";a:1:{i:1;a:14:{s:7:"item_id";s:1:"1";s:13:"item_location";s:1:"1";s:10:"stock_name";s:5:"stock";s:4:"line";i:1;s:4:"name";s:7:"iphone6";s:11:"item_number";N;s:11:"description";s:0:"";s:12:"serialnumber";s:0:"";s:21:"allow_alt_description";s:1:"0";s:13:"is_serialized";s:1:"0";s:8:"quantity";i:11;s:8:"discount";i:0;s:8:"in_stock";s:1:"8";s:5:"price";s:6:"450.00";}}s:9:"sale_mode";s:4:"sale";s:8:"customer";i:-1;s:8:"payments";a:0:{}s:20:"sales_invoice_number";s:1:"0";}'),
('94b54fdf090f51e72f3affa11967a8f9', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1461270798, 'a:2:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";}'),
('94ce228cf49ab0855dcaf952372facf4', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056276, ''),
('95b79c8da2488a14cdee46660c2946a8', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056276, ''),
('95d3e2b0968f80327b66403dff566337', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459005174, ''),
('9662c4b07a1fe0fe2e974c2144e60552', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1461520449, 'a:6:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";s:8:"cartRecv";a:0:{}s:9:"recv_mode";s:7:"receive";s:8:"supplier";i:-1;s:19:"recv_invoice_number";s:1:"0";}'),
('9663511b0909e93d805a94c369f27125', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459006920, ''),
('9fb8158836fdadd48482e03296042d47', '::1', '0', 1459892234, ''),
('9fbc68d1d87195c1a9e1250d762fb16e', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459006920, ''),
('a10f194ed0a444b850e5994c448b2ca2', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459008372, ''),
('a1e03248a0895717fa1022aa56700b6b', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056275, ''),
('a4fac705fdb1ef741cc26852f8975423', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056272, ''),
('a851b1ce11a1836f8d2680eaedd7f5dd', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459006920, ''),
('a9359018bbe45e50639c9180ecdecd85', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056276, ''),
('ac3922a35735c607807284c37b65902c', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459006920, ''),
('ad094ec670b3dfa82a4572e7f72700c4', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459002789, 'a:12:{s:9:"person_id";s:1:"1";s:4:"cart";a:0:{}s:9:"sale_mode";s:4:"sale";s:13:"sale_location";s:1:"1";s:8:"customer";i:-1;s:8:"payments";a:0:{}s:20:"sales_invoice_number";s:1:"1";s:8:"cartRecv";a:0:{}s:9:"recv_mode";s:7:"receive";s:8:"supplier";i:-1;s:19:"recv_invoice_number";s:1:"0";s:13:"item_location";s:1:"1";}'),
('ae64221b1ccd7baef8839d218151ad83', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056276, ''),
('b36dcc6386b4c3bdd9c8a39080a6496c', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459005174, ''),
('b4138229cec7bb47bc2a91197b21f3d7', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056272, ''),
('b5c3cb433c51af06aadac20ae132e012', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056276, ''),
('ba21f66b79c654610e3a06adc957adce', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1458380174, ''),
('bbf9a5393cfe1df6ca6688db1d88c402', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056448, ''),
('bc182d29409409ab07357a165d57805e', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1458411886, 'a:2:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";}'),
('bed8bb71897a546ae9e15f3218d7f001', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459006920, 'a:6:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";s:8:"cartRecv";a:0:{}s:9:"recv_mode";s:7:"receive";s:8:"supplier";i:-1;s:19:"recv_invoice_number";s:1:"0";}'),
('c0fb028eff8e1f8c54b9de4b0d248902', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056276, ''),
('c248900e4eab86bef873910b4173cb7e', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459002789, ''),
('c5d518dce0fbf38ffd94717183bcd538', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459008372, ''),
('c89c1311fecd81b5170d358748d03f76', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1458411867, 'a:8:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";s:13:"sale_location";s:1:"1";s:4:"cart";a:0:{}s:9:"sale_mode";s:4:"sale";s:8:"customer";i:-1;s:8:"payments";a:0:{}s:20:"sales_invoice_number";s:1:"0";}'),
('cadcf7883e32b02d1fbc21b9a10eff0e', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459006920, ''),
('cd97213886529050838085cdf2e8b13a', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459005175, ''),
('ce2d8eca9e521dc72c43106e6e9627cd', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459006920, ''),
('d243545bc7b9d4cc0081b8bebbdea09a', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459006920, ''),
('d315fc5f883a9af95a01340f1d31c282', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056276, ''),
('d3b1c9f75bce8b9c0a74f79fd30c509c', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459006920, ''),
('d4b95566afc94f84bfe0c9ec5befd1b6', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459005174, ''),
('d7963fa732662aa504f8c7d18ad0f42d', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1458412835, 'a:1:{s:9:"person_id";s:1:"1";}'),
('d844d8611191f15c366f2207d443d09e', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1458406594, 'a:6:{s:9:"person_id";s:1:"1";s:8:"cartRecv";a:0:{}s:9:"recv_mode";s:7:"receive";s:8:"supplier";i:-1;s:19:"recv_invoice_number";s:1:"0";s:13:"item_location";s:1:"1";}'),
('dc67393aa1eb2c0385dcff77bc9c85c4', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1461428157, ''),
('dedea33ef39ae165744f3ed8b7867da9', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459009323, 'a:6:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";s:8:"cartRecv";a:0:{}s:9:"recv_mode";s:7:"receive";s:8:"supplier";i:-1;s:19:"recv_invoice_number";s:1:"0";}'),
('df5fc95fc9ce6bd5beaf888868b4eb7a', '::1', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.110 Safari/537.36', 1461497169, ''),
('e1c4508e4f0c4368a705cc577fb6968d', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056276, ''),
('e2f0c104d1f50027fad294a00cdb2199', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459005174, ''),
('e61698b7da7fc8a602e425e7c8474772', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459005174, ''),
('e803bf94436b200a657a92e7e381ac63', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459005175, ''),
('e936be6d9257fb25bea37c98424b8ad5', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459008327, ''),
('e9d385d7ec257e4528cdb9e31d4cf68b', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459008372, ''),
('eab9da201fb4a8db048a815f96e97306', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459006920, ''),
('ee39d81bfcd984032f66d001749601c7', '::1', '0', 1459892353, ''),
('ef21c61704abbbb5633b63d9f449e3ac', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459008327, 'a:5:{s:9:"person_id";s:1:"1";s:8:"cartRecv";a:0:{}s:9:"recv_mode";s:7:"receive";s:8:"supplier";i:-1;s:19:"recv_invoice_number";s:1:"0";}'),
('f5025ddfdc35ad2b2e7bb9339173c3e6', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459005174, ''),
('f524fccce978ded02637743daa5d82f2', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056276, ''),
('f6449d607ef5540186c6679768158aed', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1458413823, 'a:3:{s:9:"user_data";s:0:"";s:9:"person_id";s:1:"1";s:8:"payments";a:0:{}}'),
('fa6c131f26fcf270a56d9bdf543c6aaf', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1458380341, ''),
('ff27e71baf800736142431b7589e348c', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056272, ''),
('ffce29a4982f0360f8829d54408ed19a', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:45.0) Gecko/20100101 Firefox/45.0', 1460056447, 'a:5:{s:9:"person_id";s:1:"1";s:8:"cartRecv";a:0:{}s:9:"recv_mode";s:7:"receive";s:8:"supplier";i:-1;s:19:"recv_invoice_number";s:1:"0";}'),
('fff4beead6a24a8c6ce3ee6b637c7060', '::1', 'Mozilla/5.0 (Windows NT 6.1; rv:44.0) Gecko/20100101 Firefox/44.0', 1459006920, '');

-- --------------------------------------------------------

--
-- Table structure for table `ospos_stock_locations`
--

CREATE TABLE IF NOT EXISTS `ospos_stock_locations` (
  `location_id` int(11) NOT NULL,
  `location_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_stock_locations`
--

INSERT INTO `ospos_stock_locations` (`location_id`, `location_name`, `deleted`) VALUES
(1, 'stock', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_suppliers`
--

CREATE TABLE IF NOT EXISTS `ospos_suppliers` (
  `person_id` int(10) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ospos_suppliers`
--

INSERT INTO `ospos_suppliers` (`person_id`, `company_name`, `account_number`, `deleted`) VALUES
(3, 'Apple', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_tbl_keys`
--

CREATE TABLE IF NOT EXISTS `ospos_tbl_keys` (
  `key_id` int(11) NOT NULL,
  `hash_code` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_tbl_keys`
--

INSERT INTO `ospos_tbl_keys` (`key_id`, `hash_code`, `status`) VALUES
(1, '123456789', 1),
(2, '412a7a42f94505932a4c75e852880225', 0),
(3, '511e3207e560cbc1bcc0acdd0f2f985f', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ospos_tbl_logs`
--

CREATE TABLE IF NOT EXISTS `ospos_tbl_logs` (
  `log_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `action_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `employee_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ospos_tbl_logs`
--

INSERT INTO `ospos_tbl_logs` (`log_id`, `module_id`, `module_name`, `action_time`, `employee_id`, `comment`, `status`) VALUES
(4, 18, 'Customers', '2016-03-26 15:46:04', 1, '', 1),
(5, 18, 'Sales', '2016-03-23 04:35:38', 1, '', 1),
(6, 6, 'Sales', '2016-04-05 11:29:47', 1, '', 1),
(7, 6, 'Sales', '2016-04-05 11:38:19', 1, '', 1),
(8, 7, 'Sales', '2016-04-06 09:03:04', 1, '', 1),
(9, 17, 'Sales', '2016-04-19 06:14:15', 1, '', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ospos_app_config`
--
ALTER TABLE `ospos_app_config`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `ospos_curl_log`
--
ALTER TABLE `ospos_curl_log`
  ADD PRIMARY KEY (`curl_id`);

--
-- Indexes for table `ospos_customers`
--
ALTER TABLE `ospos_customers`
  ADD UNIQUE KEY `account_number` (`account_number`), ADD KEY `person_id` (`person_id`);

--
-- Indexes for table `ospos_employees`
--
ALTER TABLE `ospos_employees`
  ADD UNIQUE KEY `username` (`username`), ADD KEY `person_id` (`person_id`);

--
-- Indexes for table `ospos_giftcards`
--
ALTER TABLE `ospos_giftcards`
  ADD PRIMARY KEY (`giftcard_id`), ADD UNIQUE KEY `giftcard_number` (`giftcard_number`), ADD KEY `ospos_giftcards_ibfk_1` (`person_id`);

--
-- Indexes for table `ospos_global_config`
--
ALTER TABLE `ospos_global_config`
  ADD PRIMARY KEY (`global_id`);

--
-- Indexes for table `ospos_grants`
--
ALTER TABLE `ospos_grants`
  ADD PRIMARY KEY (`permission_id`,`person_id`), ADD KEY `ospos_grants_ibfk_2` (`person_id`);

--
-- Indexes for table `ospos_inventory`
--
ALTER TABLE `ospos_inventory`
  ADD PRIMARY KEY (`trans_id`), ADD KEY `trans_items` (`trans_items`), ADD KEY `trans_user` (`trans_user`), ADD KEY `trans_location` (`trans_location`);

--
-- Indexes for table `ospos_items`
--
ALTER TABLE `ospos_items`
  ADD PRIMARY KEY (`item_id`), ADD UNIQUE KEY `item_number` (`item_number`), ADD KEY `ospos_items_ibfk_1` (`supplier_id`);

--
-- Indexes for table `ospos_items_taxes`
--
ALTER TABLE `ospos_items_taxes`
  ADD PRIMARY KEY (`item_id`,`name`,`percent`);

--
-- Indexes for table `ospos_item_kits`
--
ALTER TABLE `ospos_item_kits`
  ADD PRIMARY KEY (`item_kit_id`);

--
-- Indexes for table `ospos_item_kit_items`
--
ALTER TABLE `ospos_item_kit_items`
  ADD PRIMARY KEY (`item_kit_id`,`item_id`,`quantity`), ADD KEY `ospos_item_kit_items_ibfk_2` (`item_id`);

--
-- Indexes for table `ospos_item_quantities`
--
ALTER TABLE `ospos_item_quantities`
  ADD PRIMARY KEY (`item_id`,`location_id`), ADD KEY `item_id` (`item_id`), ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `ospos_modules`
--
ALTER TABLE `ospos_modules`
  ADD PRIMARY KEY (`module_id`), ADD UNIQUE KEY `desc_lang_key` (`desc_lang_key`), ADD UNIQUE KEY `name_lang_key` (`name_lang_key`);

--
-- Indexes for table `ospos_module_web_hooks`
--
ALTER TABLE `ospos_module_web_hooks`
  ADD PRIMARY KEY (`module_hook_id`);

--
-- Indexes for table `ospos_people`
--
ALTER TABLE `ospos_people`
  ADD PRIMARY KEY (`person_id`);

--
-- Indexes for table `ospos_permissions`
--
ALTER TABLE `ospos_permissions`
  ADD PRIMARY KEY (`permission_id`), ADD KEY `module_id` (`module_id`), ADD KEY `ospos_permissions_ibfk_2` (`location_id`);

--
-- Indexes for table `ospos_receivings`
--
ALTER TABLE `ospos_receivings`
  ADD PRIMARY KEY (`receiving_id`), ADD UNIQUE KEY `invoice_number` (`invoice_number`), ADD KEY `supplier_id` (`supplier_id`), ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `ospos_receivings_items`
--
ALTER TABLE `ospos_receivings_items`
  ADD PRIMARY KEY (`receiving_id`,`item_id`,`line`), ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `ospos_sales`
--
ALTER TABLE `ospos_sales`
  ADD PRIMARY KEY (`sale_id`), ADD UNIQUE KEY `invoice_number` (`invoice_number`), ADD KEY `customer_id` (`customer_id`), ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `ospos_sales_items`
--
ALTER TABLE `ospos_sales_items`
  ADD PRIMARY KEY (`sale_id`,`item_id`,`line`), ADD KEY `sale_id` (`sale_id`), ADD KEY `item_id` (`item_id`), ADD KEY `item_location` (`item_location`);

--
-- Indexes for table `ospos_sales_items_taxes`
--
ALTER TABLE `ospos_sales_items_taxes`
  ADD PRIMARY KEY (`sale_id`,`item_id`,`line`,`name`,`percent`), ADD KEY `sale_id` (`sale_id`), ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `ospos_sales_payments`
--
ALTER TABLE `ospos_sales_payments`
  ADD PRIMARY KEY (`sale_id`,`payment_type`), ADD KEY `sale_id` (`sale_id`);

--
-- Indexes for table `ospos_sales_suspended`
--
ALTER TABLE `ospos_sales_suspended`
  ADD PRIMARY KEY (`sale_id`), ADD UNIQUE KEY `invoice_number` (`invoice_number`), ADD KEY `customer_id` (`customer_id`), ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `ospos_sales_suspended_items`
--
ALTER TABLE `ospos_sales_suspended_items`
  ADD PRIMARY KEY (`sale_id`,`item_id`,`line`), ADD KEY `sale_id` (`sale_id`), ADD KEY `item_id` (`item_id`), ADD KEY `ospos_sales_suspended_items_ibfk_3` (`item_location`);

--
-- Indexes for table `ospos_sales_suspended_items_taxes`
--
ALTER TABLE `ospos_sales_suspended_items_taxes`
  ADD PRIMARY KEY (`sale_id`,`item_id`,`line`,`name`,`percent`), ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `ospos_sales_suspended_payments`
--
ALTER TABLE `ospos_sales_suspended_payments`
  ADD PRIMARY KEY (`sale_id`,`payment_type`);

--
-- Indexes for table `ospos_sessions`
--
ALTER TABLE `ospos_sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `ospos_stock_locations`
--
ALTER TABLE `ospos_stock_locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `ospos_suppliers`
--
ALTER TABLE `ospos_suppliers`
  ADD UNIQUE KEY `account_number` (`account_number`), ADD KEY `person_id` (`person_id`);

--
-- Indexes for table `ospos_tbl_keys`
--
ALTER TABLE `ospos_tbl_keys`
  ADD PRIMARY KEY (`key_id`);

--
-- Indexes for table `ospos_tbl_logs`
--
ALTER TABLE `ospos_tbl_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `keys`
--
ALTER TABLE `keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ospos_curl_log`
--
ALTER TABLE `ospos_curl_log`
  MODIFY `curl_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=83;
--
-- AUTO_INCREMENT for table `ospos_giftcards`
--
ALTER TABLE `ospos_giftcards`
  MODIFY `giftcard_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ospos_global_config`
--
ALTER TABLE `ospos_global_config`
  MODIFY `global_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ospos_inventory`
--
ALTER TABLE `ospos_inventory`
  MODIFY `trans_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `ospos_items`
--
ALTER TABLE `ospos_items`
  MODIFY `item_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `ospos_item_kits`
--
ALTER TABLE `ospos_item_kits`
  MODIFY `item_kit_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ospos_module_web_hooks`
--
ALTER TABLE `ospos_module_web_hooks`
  MODIFY `module_hook_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `ospos_people`
--
ALTER TABLE `ospos_people`
  MODIFY `person_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `ospos_receivings`
--
ALTER TABLE `ospos_receivings`
  MODIFY `receiving_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ospos_sales`
--
ALTER TABLE `ospos_sales`
  MODIFY `sale_id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `ospos_sales_suspended`
--
ALTER TABLE `ospos_sales_suspended`
  MODIFY `sale_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ospos_stock_locations`
--
ALTER TABLE `ospos_stock_locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `ospos_tbl_keys`
--
ALTER TABLE `ospos_tbl_keys`
  MODIFY `key_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `ospos_tbl_logs`
--
ALTER TABLE `ospos_tbl_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `ospos_customers`
--
ALTER TABLE `ospos_customers`
ADD CONSTRAINT `ospos_customers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `ospos_people` (`person_id`);

--
-- Constraints for table `ospos_employees`
--
ALTER TABLE `ospos_employees`
ADD CONSTRAINT `ospos_employees_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `ospos_people` (`person_id`);

--
-- Constraints for table `ospos_giftcards`
--
ALTER TABLE `ospos_giftcards`
ADD CONSTRAINT `ospos_giftcards_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `ospos_people` (`person_id`);

--
-- Constraints for table `ospos_grants`
--
ALTER TABLE `ospos_grants`
ADD CONSTRAINT `ospos_grants_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `ospos_permissions` (`permission_id`),
ADD CONSTRAINT `ospos_grants_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `ospos_employees` (`person_id`);

--
-- Constraints for table `ospos_inventory`
--
ALTER TABLE `ospos_inventory`
ADD CONSTRAINT `ospos_inventory_ibfk_1` FOREIGN KEY (`trans_items`) REFERENCES `ospos_items` (`item_id`),
ADD CONSTRAINT `ospos_inventory_ibfk_2` FOREIGN KEY (`trans_user`) REFERENCES `ospos_employees` (`person_id`);

--
-- Constraints for table `ospos_items`
--
ALTER TABLE `ospos_items`
ADD CONSTRAINT `ospos_items_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `ospos_suppliers` (`person_id`);

--
-- Constraints for table `ospos_items_taxes`
--
ALTER TABLE `ospos_items_taxes`
ADD CONSTRAINT `ospos_items_taxes_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `ospos_items` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `ospos_item_kit_items`
--
ALTER TABLE `ospos_item_kit_items`
ADD CONSTRAINT `ospos_item_kit_items_ibfk_1` FOREIGN KEY (`item_kit_id`) REFERENCES `ospos_item_kits` (`item_kit_id`) ON DELETE CASCADE,
ADD CONSTRAINT `ospos_item_kit_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `ospos_items` (`item_id`) ON DELETE CASCADE;

--
-- Constraints for table `ospos_item_quantities`
--
ALTER TABLE `ospos_item_quantities`
ADD CONSTRAINT `ospos_item_quantities_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `ospos_items` (`item_id`),
ADD CONSTRAINT `ospos_item_quantities_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `ospos_stock_locations` (`location_id`);

--
-- Constraints for table `ospos_permissions`
--
ALTER TABLE `ospos_permissions`
ADD CONSTRAINT `ospos_permissions_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `ospos_modules` (`module_id`) ON DELETE CASCADE,
ADD CONSTRAINT `ospos_permissions_ibfk_2` FOREIGN KEY (`location_id`) REFERENCES `ospos_stock_locations` (`location_id`) ON DELETE CASCADE;

--
-- Constraints for table `ospos_receivings`
--
ALTER TABLE `ospos_receivings`
ADD CONSTRAINT `ospos_receivings_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `ospos_employees` (`person_id`),
ADD CONSTRAINT `ospos_receivings_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `ospos_suppliers` (`person_id`);

--
-- Constraints for table `ospos_receivings_items`
--
ALTER TABLE `ospos_receivings_items`
ADD CONSTRAINT `ospos_receivings_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `ospos_items` (`item_id`),
ADD CONSTRAINT `ospos_receivings_items_ibfk_2` FOREIGN KEY (`receiving_id`) REFERENCES `ospos_receivings` (`receiving_id`);

--
-- Constraints for table `ospos_sales`
--
ALTER TABLE `ospos_sales`
ADD CONSTRAINT `ospos_sales_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `ospos_employees` (`person_id`),
ADD CONSTRAINT `ospos_sales_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `ospos_customers` (`person_id`);

--
-- Constraints for table `ospos_sales_items`
--
ALTER TABLE `ospos_sales_items`
ADD CONSTRAINT `ospos_sales_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `ospos_items` (`item_id`),
ADD CONSTRAINT `ospos_sales_items_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `ospos_sales` (`sale_id`),
ADD CONSTRAINT `ospos_sales_items_ibfk_3` FOREIGN KEY (`item_location`) REFERENCES `ospos_stock_locations` (`location_id`);

--
-- Constraints for table `ospos_sales_items_taxes`
--
ALTER TABLE `ospos_sales_items_taxes`
ADD CONSTRAINT `ospos_sales_items_taxes_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `ospos_sales_items` (`sale_id`),
ADD CONSTRAINT `ospos_sales_items_taxes_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `ospos_items` (`item_id`);

--
-- Constraints for table `ospos_sales_payments`
--
ALTER TABLE `ospos_sales_payments`
ADD CONSTRAINT `ospos_sales_payments_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `ospos_sales` (`sale_id`);

--
-- Constraints for table `ospos_sales_suspended`
--
ALTER TABLE `ospos_sales_suspended`
ADD CONSTRAINT `ospos_sales_suspended_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `ospos_employees` (`person_id`),
ADD CONSTRAINT `ospos_sales_suspended_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `ospos_customers` (`person_id`);

--
-- Constraints for table `ospos_sales_suspended_items`
--
ALTER TABLE `ospos_sales_suspended_items`
ADD CONSTRAINT `ospos_sales_suspended_items_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `ospos_items` (`item_id`),
ADD CONSTRAINT `ospos_sales_suspended_items_ibfk_2` FOREIGN KEY (`sale_id`) REFERENCES `ospos_sales_suspended` (`sale_id`),
ADD CONSTRAINT `ospos_sales_suspended_items_ibfk_3` FOREIGN KEY (`item_location`) REFERENCES `ospos_stock_locations` (`location_id`);

--
-- Constraints for table `ospos_sales_suspended_items_taxes`
--
ALTER TABLE `ospos_sales_suspended_items_taxes`
ADD CONSTRAINT `ospos_sales_suspended_items_taxes_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `ospos_sales_suspended_items` (`sale_id`),
ADD CONSTRAINT `ospos_sales_suspended_items_taxes_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `ospos_items` (`item_id`);

--
-- Constraints for table `ospos_sales_suspended_payments`
--
ALTER TABLE `ospos_sales_suspended_payments`
ADD CONSTRAINT `ospos_sales_suspended_payments_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `ospos_sales_suspended` (`sale_id`);

--
-- Constraints for table `ospos_suppliers`
--
ALTER TABLE `ospos_suppliers`
ADD CONSTRAINT `ospos_suppliers_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `ospos_people` (`person_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
