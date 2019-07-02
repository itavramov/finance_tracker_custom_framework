-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 02, 2019 at 01:17 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `financetracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `acc_id` int(11) NOT NULL,
  `acc_name` varchar(100) NOT NULL,
  `acc_type` varchar(45) NOT NULL,
  `balance` double NOT NULL DEFAULT '0',
  `currency` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`acc_id`, `acc_name`, `acc_type`, `balance`, `currency`, `user_id`) VALUES
(3, 'OneMoreTimeW', 'cash', 10000, 'bgn', 4),
(4, 'FirstAccountCheck2', 'bank', 300000, 'bgn', 4),
(6, 'NewTestingName1', 'bank', 60000, 'bgn', 4),
(7, 'NewAcc', 'common', -300000, 'bgn', 4),
(8, 'OneCoin', 'bank', 10000000, 'usd', 4);

-- --------------------------------------------------------

--
-- Table structure for table `budgets`
--

CREATE TABLE `budgets` (
  `budget_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `budget_name` varchar(100) NOT NULL,
  `budget_desc` varchar(45) NOT NULL,
  `current_amount` double NOT NULL,
  `init_amount` double NOT NULL,
  `category_id` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `budgets`
--

INSERT INTO `budgets` (`budget_id`, `user_id`, `budget_name`, `budget_desc`, `current_amount`, `init_amount`, `category_id`, `from_date`, `to_date`) VALUES
(1, 4, 'Test', 'Test1', 22222, 22222, 1, '1970-01-01', '1970-01-01'),
(2, 4, 'Test2', 'Test2222', 333333, 333333, 1, '1970-01-01', '1970-01-01'),
(3, 4, 'Test4', 'Test4', -55556, 44444, 1, '2019-02-01', '2019-02-28'),
(4, 4, 'First Budget', 'First Budget', 10000, 10000, 1, '2019-03-01', '2019-03-02'),
(5, 4, 'testing', 'testingtestingtesting', 20000000, 20000000, 2, '2019-03-12', '2019-04-05'),
(6, 4, 'testtttttt', 'testingtesting', 24124124, 24124124, 1, '2019-03-27', '2019-03-27'),
(7, 4, 'testing again', 'testing again testing again', 200000, 200000, 5, '2019-03-22', '2019-03-31');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(45) NOT NULL,
  `category_type` varchar(45) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `category_type`, `user_id`) VALUES
(1, 'Car', 'expense', 4),
(2, 'Testing', 'expense', 4),
(3, 'Salary', 'income', 4),
(4, 'Project', 'income', 4),
(5, 'Vacations', 'expense', 4),
(6, 'Food', 'expense', 4),
(7, 'Car2', 'expense', 4),
(8, 'Income', 'income', 4);

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE `records` (
  `record_id` int(11) NOT NULL,
  `record_name` varchar(100) NOT NULL,
  `record_desc` varchar(255) NOT NULL,
  `amount` double NOT NULL,
  `action_date` date NOT NULL,
  `category_id` int(11) NOT NULL,
  `acc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `records`
--

INSERT INTO `records` (`record_id`, `record_name`, `record_desc`, `amount`, `action_date`, `category_id`, `acc_id`) VALUES
(15, 'Income', 'Income', 100000, '2019-03-03', 8, 3),
(16, 'CheckRecord', 'record description', 2000000, '2019-03-04', 2, 6),
(17, 'check', 'check check 123', 20000, '2019-03-06', 6, 6),
(18, 'checkZaBobkata', 'checkZaBobkata vtori nomer', 200000, '2019-03-06', 4, 4),
(19, 'Check1', 'Checkfafasfasfa', 200000, '2019-02-15', 1, 7),
(20, 'Test4', 'teafsafasfasfasfa', 200000, '2019-03-10', 5, 7);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `sign_up_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `age`, `email`, `picture`, `password`, `sign_up_date`) VALUES
(1, 'Ivan', 'Avramov', 25, 'kambolyy@abv.bg', 'view/uploads/user_image/Ivan1551132063.jpg', '$2y$12$v5X1aXGF.PSoBA6g/Ca/k.0CxlMxMCstvdyWrGSrx.cKeOjQkIfg2', '2019-03-06 11:27:29'),
(2, 'Stoimen', 'Kolov', 23, 'itavramov@abv.bg', 'view/uploads/user_image/Stoimen1551132975.jpg', '$2y$12$YZCFk5sJjkcYWnqPpW9E0.dfJVCocGNaKXWgTKVVghTm76LhNtW3W', '2019-03-06 11:27:29'),
(3, 'test', 'test', 25, 'test@gmail.com', 'view/uploads/user_image/test1551171866.jpg', '$2y$12$JQAhUV3GUoYoJR6Bm7fc5uqUSQ2YFaykAhwZIULN5h3v6DJDKITyy', '2019-03-06 11:27:29'),
(4, 'Testtt', 'Testtt', 25, 'testtt@gmail.com', 'uploads/user_image/default.png', '$2y$12$eRCkP5eCUUIVPVTA1Dq4LurCOiLVIj4Jwa7KmgxqgCzaARPZDycPy', '2019-03-06 11:27:29'),
(5, 'Nqkoi', 'Stoikov', 34, 'stoikov@gmail.com', 'view/uploads/user_image/Nqkoi1551648341.jpg', '$2y$12$xrqg9BNz/iHGciMpKx3EmuBCOpmP5b03rAsW5/Nc3KAYncAmh.7Ia', '2019-03-06 11:27:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`acc_id`),
  ADD KEY `acc_user_fk_idx` (`user_id`);

--
-- Indexes for table `budgets`
--
ALTER TABLE `budgets`
  ADD PRIMARY KEY (`budget_id`),
  ADD KEY `user_budget_idx` (`user_id`),
  ADD KEY `category_budget_idx` (`category_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `record_acc_fk_idx` (`acc_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `acc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `budgets`
--
ALTER TABLE `budgets`
  MODIFY `budget_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `records`
--
ALTER TABLE `records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `acc_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `budgets`
--
ALTER TABLE `budgets`
  ADD CONSTRAINT `category_budget` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `user_budget` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `records`
--
ALTER TABLE `records`
  ADD CONSTRAINT `record_acc_fk` FOREIGN KEY (`acc_id`) REFERENCES `accounts` (`acc_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
