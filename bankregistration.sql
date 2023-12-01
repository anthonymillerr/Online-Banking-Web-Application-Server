-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2023 at 08:41 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bankregistration`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank_users`
--

CREATE TABLE `bank_users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstName` varchar(20) NOT NULL DEFAULT 'john',
  `lastName` varchar(20) NOT NULL DEFAULT 'doe',
  `username` varchar(50) NOT NULL,
  `password1` varchar(255) NOT NULL,
  `password2` varchar(255) NOT NULL,
  `phonenumber` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `state` varchar(50) NOT NULL,
  `securityquestion` varchar(255) NOT NULL,
  `securityresponse` varchar(255) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `debitcard` bigint(20) NOT NULL,
  `Pin` int(6) DEFAULT NULL,
  `debitcard_balance` decimal(10,2) DEFAULT 0.00,
  `debitcard_expire` varchar(5) DEFAULT '00/00',
  `debitcard_cvv` varchar(3) DEFAULT '000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bank_users`
--

INSERT INTO `bank_users` (`id`, `email`, `firstName`, `lastName`, `username`, `password1`, `password2`, `phonenumber`, `address`, `zipcode`, `state`, `securityquestion`, `securityresponse`, `user_id`, `debitcard`, `Pin`, `debitcard_balance`, `debitcard_expire`, `debitcard_cvv`) VALUES
(51, 'brandonarv2021@gmail.com', 'First', 'User', 'FirstUser1', 'NewUser1', 'NewUser1', '456 666 6666', 'random', '89999', 'ca', 'What is your favorite food?', 'cheese', 870468037291, 6179798979339905, 222222, 343.00, '4/27', '018'),
(52, 'brandonarv2021@gmail.com', 'Second', 'User', 'SecondUser2', 'NewUser1', 'NewUser1', '(408)-456-3345', 'random address', '95777', 'CA', 'What is your favorite food?', 'nah', 358983121250, 4352379954447043, 111111, 0.00, '2/27', '908'),
(55, 'quyen1@gmail.com', 'quyen', 'nguyen', 'QuyenNg12', 'Quyen1234567*', 'Quyen1234567*', '(123)-456-7890', '123njnbj', '12345', 'CA', 'What was your first car?', 'abc', 745839816018, 9321148497379849, 123456, 0.00, '1/27', '293'),
(57, 'brandonarv2021@gmail.com', 'Brandon', 'RIvera', 'FifthUser5', 'NewUser1', 'NewUser1', '(444)-444-4444', 'random street', '98555', 'CA', 'What is your favorite food?', 'mcdonalds', 149666443199, 7871640310024859, 222222, 500.00, '8/27', '226');

-- --------------------------------------------------------

--
-- Table structure for table `checking_accounts`
--

CREATE TABLE `checking_accounts` (
  `account_id` int(11) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `checking_accounts`
--

INSERT INTO `checking_accounts` (`account_id`, `user_id`, `balance`) VALUES
(56, 358983121250, 1000.00),
(64, 870468037291, 1500.00),
(65, 149666443199, 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `contact_users`
--

CREATE TABLE `contact_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `inquiry` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contact_users`
--

INSERT INTO `contact_users` (`id`, `name`, `phone`, `email`, `message`, `inquiry`) VALUES
(13, 'Anthony', '45443343434', 'anthony.j.miller@sjsu.edu', 'sdaadsffads', ' asdfsdaf'),
(14, 'Brandon', '(408)-333-3333', 'brandon.riveravengas@sjsu.edu', 'random subject', ' random inquiry'),
(15, 'Brandon', '(405)-555-5555', 'brandon.riveravenegas@sjsu.edu', 'random subject', ' random inquiry'),
(16, 'test', '(408)-333-3333', 'brandonarv2021@gmail.com', 'bank not transferring', ' random inquiry');

-- --------------------------------------------------------

--
-- Table structure for table `employee_table`
--

CREATE TABLE `employee_table` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employee_table`
--

INSERT INTO `employee_table` (`id`, `employee_id`, `password`) VALUES
(1, 'Admin1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `savings_accounts`
--

CREATE TABLE `savings_accounts` (
  `account_id` int(11) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `savings_accounts`
--

INSERT INTO `savings_accounts` (`account_id`, `user_id`, `balance`) VALUES
(8, 870468037291, 1000.00),
(9, 358983121250, 1000.00),
(10, 149666443199, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `transaction_type` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `transaction_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `transaction_id` bigint(20) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `account_type` varchar(265) DEFAULT NULL,
  `account_number` int(11) NOT NULL,
  `account_type2` varchar(265) CHARACTER SET latin1 COLLATE latin1_swedish_nopad_ci DEFAULT NULL,
  `account_number2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `transaction_type`, `amount`, `status`, `transaction_date`, `transaction_id`, `details`, `account_type`, `account_number`, `account_type2`, `account_number2`) VALUES
(79, 149666443199, 'Deposit', 1200.00, 'Approved', '2023-12-01 07:29:57', 126176973, 'Check Deposit For $1200', 'checking', 65, NULL, 0),
(80, 149666443199, 'Transfer', 500.00, 'Approved', '2023-12-01 07:36:35', 186215895, 'Transfer: FROM User ID: 149666443199 and Account ID: 65 TO User ID: 870468037291 and Account ID: 64', 'checking_accounts', 65, 'checking_accounts', 64),
(81, 149666443199, 'Withdraw', 500.00, 'Completed', '2023-12-01 07:40:33', 404889720, 'Withdraw For $500', NULL, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `verify`
--

CREATE TABLE `verify` (
  `id` int(11) NOT NULL,
  `code` int(11) NOT NULL,
  `expires` int(11) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_users`
--
ALTER TABLE `bank_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `accountnumber` (`user_id`);

--
-- Indexes for table `checking_accounts`
--
ALTER TABLE `checking_accounts`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `contact_users`
--
ALTER TABLE `contact_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `employee_table`
--
ALTER TABLE `employee_table`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`);

--
-- Indexes for table `savings_accounts`
--
ALTER TABLE `savings_accounts`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `verify`
--
ALTER TABLE `verify`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `expires` (`expires`),
  ADD KEY `email` (`email`),
  ADD KEY `id_2` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_users`
--
ALTER TABLE `bank_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `checking_accounts`
--
ALTER TABLE `checking_accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `contact_users`
--
ALTER TABLE `contact_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `employee_table`
--
ALTER TABLE `employee_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `savings_accounts`
--
ALTER TABLE `savings_accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `verify`
--
ALTER TABLE `verify`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checking_accounts`
--
ALTER TABLE `checking_accounts`
  ADD CONSTRAINT `checking_accounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `bank_users` (`user_id`);

--
-- Constraints for table `savings_accounts`
--
ALTER TABLE `savings_accounts`
  ADD CONSTRAINT `savings_accounts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `bank_users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
