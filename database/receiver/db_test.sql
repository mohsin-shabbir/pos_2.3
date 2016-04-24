-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2016 at 08:08 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_curl_receiver`
--

CREATE TABLE IF NOT EXISTS `tbl_curl_receiver` (
  `id` int(11) NOT NULL,
  `data` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_curl_receiver`
--

INSERT INTO `tbl_curl_receiver` (`id`, `data`, `status`) VALUES
(2, '{"sale_id":"7","payment_type":"Received Payment","payment_amount":"1","is_received":1,"path":"insertPayment","updated_amount":746}', 1),
(3, '{"sale_id":"17","payment_type":"Received Payment","payment_amount":"10","is_received":1,"path":"insertPayment","updated_amount":4010}', 1),
(4, '{"path":"insertPayment","person_data":{"first_name":"curl","last_name":"customer","email":"curl@gmail.com","phone_number":"923009894706","address_1":"address1","address_2":"address2","city":"lhr","state":"pu","zip":"12345","country":"pak","comments":"ccc"', 1),
(5, '{"path":"insertPayment","person_data":{"first_name":"curl","last_name":"customer","email":"curl@gmail.com","phone_number":"923009894706","address_1":"address1","address_2":"address2","city":"lhr","state":"pu","zip":"12345","country":"pak","comments":"ccc"', 1),
(6, '{"path":"insertPayment","person_data":{"first_name":"curl","last_name":"customer","email":"curl@gmail.com","phone_number":"923009894706","address_1":"address1","address_2":"address2","city":"lhr","state":"pu","zip":"12345","country":"pak","comments":"ccc"', 1),
(7, '{"path":"insertPayment","customer_data":{"account_number":"10005","taxable":1},"customer_id":"33"}', 1),
(8, '{"path":"insertPayment","customer_id":"33","person_data":{"first_name":"curl","last_name":"customer","email":"curl@gmail.com","phone_number":"923009894706","address_1":"address111","address_2":"address2","city":"lhr","state":"pu","zip":"12345","country":"', 1),
(9, '{"path":"insertPayment","customer_id":"33","person_data":{"first_name":"curl","last_name":"customer","email":"curl@gmail.com","phone_number":"923009894706","address_1":"address1","address_2":"address2","city":"lhr","state":"pu","zip":"12345","country":"pa', 1),
(10, '{"path":"insertPayment","customer_id":"33","person_data":{"first_name":"curl","last_name":"customer","email":"curl@gmail.com","phone_number":"923009894706","address_1":"address1","address_2":"address2","city":"lhr","state":"pu","zip":"12345","country":"pa', 1),
(11, '{"path":"insertPayment","customer_id":"33","person_data":{"first_name":"curl","last_name":"customer","email":"curl@gmail.com","phone_number":"923009894706","address_1":"address1","address_2":"address2","city":"lhr","state":"pu","zip":"12345","country":"pa', 1),
(12, '{"path":"insertPayment","customer_id":"33","person_data":{"first_name":"curl","last_name":"customer","email":"curl@gmail.com","phone_number":"923009894706","address_1":"address1","address_2":"address2","city":"lhr","state":"pu","zip":"12345","country":"pa', 1),
(13, '{"path":"insertPayment","customer_id":"33","person_data":{"first_name":"curl","last_name":"customer","email":"curl@gmail.com","phone_number":"923009894706","address_1":"address1","address_2":"address2","city":"lhr","state":"pu","zip":"12345","country":"pa', 1),
(14, '{"path":"insertPayment","customer_id":"33","person_data":{"first_name":"curl","last_name":"customer","email":"curl@gmail.com","phone_number":"923009894706","address_1":"address1","address_2":"address2","city":"lhr","state":"pu","zip":"12345","country":"pa', 1),
(15, '{"path":"insertPayment","customer_id":"33","person_data":{"first_name":"curl","last_name":"customer","email":"curl@gmail.com","phone_number":"923009894706","address_1":"address1","address_2":"address2","city":"lhr","state":"pu","zip":"12345","country":"pa', 1),
(16, '{"path":"insertPayment","customer_id":"33","person_data":{"first_name":"curl","last_name":"customer","email":"curl@gmail.com","phone_number":"923009894706","address_1":"address1","address_2":"address2","city":"lhr","state":"pu","zip":"12345","country":"pa', 1),
(17, '{"path":"insertPayment","customer_id":"33","person_data":{"first_name":"curl","last_name":"customer","email":"curl@gmail.com","phone_number":"923009894706","address_1":"address1","address_2":"address2","city":"lhr","state":"pu","zip":"12345","country":"pa', 1),
(18, '{"path":"insertPayment","customer_id":"33","person_data":{"first_name":"curl","last_name":"customer","email":"curl@gmail.com","phone_number":"923009894706","address_1":"address1","address_2":"address2","city":"lhr","state":"pu","zip":"12345","country":"pa', 1),
(19, '{"path":"insertPayment","customer_id":"33","person_data":{"first_name":"curl","last_name":"customer","email":"curl@gmail.com","phone_number":"923009894706","address_1":"address1","address_2":"address2","city":"lhr","state":"pu","zip":"12345","country":"pa', 1),
(20, '{"path":"insertPayment","customer_id":"27","person_data":{"first_name":"zaheer","last_name":"ahmad","email":"","phone_number":"","address_1":"","address_2":"","city":"","state":"","zip":"","country":"","comments":""},"customer_data":{"account_number":null', 1),
(21, '{"path":"insertPayment","customer_id":"27","person_data":{"first_name":"zaheer","last_name":"ahmad","email":"","phone_number":"","address_1":"","address_2":"","city":"","state":"","zip":"","country":"","comments":""},"customer_data":{"account_number":null', 1),
(22, '["6"]', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_curl_receiver`
--
ALTER TABLE `tbl_curl_receiver`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_curl_receiver`
--
ALTER TABLE `tbl_curl_receiver`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
