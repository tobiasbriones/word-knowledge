-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Apr 19, 2020 at 03:44 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.26
-- Manually modified

SET SQL_MODE = "no_auto_value_on_zero";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @old_character_set_client = @@character_set_client */;
/*!40101 SET @old_character_set_results = @@character_set_results */;
/*!40101 SET @old_collation_connection = @@collation_connection */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `users`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages`
(
    `id`       INT(10) UNSIGNED                     NOT NULL AUTO_INCREMENT,
    `sender`   INT(10) UNSIGNED                     NOT NULL,
    `receiver` INT(10) UNSIGNED                     NOT NULL,
    `message`  VARCHAR(500) COLLATE utf8_unicode_ci NOT NULL,
    `date`     DATE DEFAULT current_timestamp(),
    PRIMARY KEY (id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register`
(
    `user_id`     INT(10) UNSIGNED                     NOT NULL AUTO_INCREMENT,
    `user`        VARCHAR(50) COLLATE utf8_unicode_ci  NOT NULL,
    `password`    VARCHAR(72) COLLATE utf8_unicode_ci  NOT NULL,
    `information` VARCHAR(500) COLLATE utf8_unicode_ci NOT NULL,
    PRIMARY KEY (user_id)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- Add System User
--
INSERT INTO register(user, password, information)
VALUES ('Word Knowledge', '', 'Word Knowledge system');

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data`
(
    `user_id`      INT(10) UNSIGNED             NOT NULL,
    `new_messages` TEXT COLLATE utf8_unicode_ci NOT NULL,
    `score`        INT(10) UNSIGNED             NOT NULL,
    `sgc_points`   INT(10) UNSIGNED             NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wk_ud`
--

CREATE TABLE `wk_ud`
(
    `user_id`    INT(10) UNSIGNED             NOT NULL,
    `categories` TEXT COLLATE utf8_unicode_ci NOT NULL,
    `write_test` TEXT COLLATE utf8_unicode_ci NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
    ADD KEY `sender` (`sender`),
    ADD KEY `receiver` (`receiver`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
    ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `wk_ud`
--
ALTER TABLE `wk_ud`
    ADD KEY `user_id` (`user_id`);


--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
    ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `register` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver`) REFERENCES `register` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_data`
--
ALTER TABLE `user_data`
    ADD CONSTRAINT `user_data_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `register` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wk_ud`
--
ALTER TABLE `wk_ud`
    ADD CONSTRAINT `wk_ud_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `register` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;


/*!40101 SET CHARACTER_SET_CLIENT = @old_character_set_client */;
/*!40101 SET CHARACTER_SET_RESULTS = @old_character_set_results */;
/*!40101 SET COLLATION_CONNECTION = @old_collation_connection */;
