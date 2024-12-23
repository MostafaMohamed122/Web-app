-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2024 at 02:59 AM
-- Server version: 8.0.35
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Create the database
CREATE DATABASE IF NOT EXISTS `fcds`;
USE `fcds`;

-- --------------------------------------------------------

-- Table structure for table `customers`

CREATE TABLE `customers` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `national_id` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

-- Table structure for table `users`

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `profile_image_url` varchar(2083) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Indexes for dumped tables

-- Indexes for table `customers`
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

-- Indexes for table `users`
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

-- AUTO_INCREMENT for dumped tables

-- AUTO_INCREMENT for table `customers`
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table `users`
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

INSERT INTO `users` (`id`, `username`, `password`, `is_admin`, `profile_image_url`) VALUES
(37, 'mostafa', '$2y$10$lDRhDfGNhbSP0Zv1CKci/ergfIzDzmIDvagbdRWDrAgKmlDyYjxi6', 1, '/FCDS/uploads/mostafa.jpg'),
(38, 'abdmalek', '$2y$10$9ivfnN7wQNjKXJub7Pgjd.IfAhpfXtoCR.Z6SyJc5emG330nzWXsG', 1, '/FCDS/uploads/abdmalek.jpg'),
(39, 'islam', '$2y$10$xwhyrEY/wTt28nr2pzPG2ul7WcyOyq2qmwjqTkFqS1dzDpa95eicu', 1, '/FCDS/uploads/islam.jpg'),
(40, 'abdalla', '$2y$10$8s/M0Dl6QvWdXWsgy9KkiOHHHqfQfhJ63UvLHpHWlGQqdXVuYxvHu', 1, '/FCDS/uploads/abdalla.jpg'),
(41, 'khalaf', '$2y$10$HlwP7t8n4bAGnOiSWDA36u.s6HyXfaoi47bBrJEo6UwuALwPaZrPG', 1, '/FCDS/uploads/khalaf.jpg'),
(42, 'nayel', '$2y$10$2wo46gtSDY7k4CuXy2grZeJKI795Kd1L5Lv1EQASQQ8rBcDTu1TNa', 1, '/FCDS/uploads/nayel.jpg'),
(43, 'abdelwhab', '$2y$10$Bw/VulyMAxRaccoD5jKvS.EsmJwrE8EdmkD.0uU1mY9HuQGfK2eiK', 1, '/FCDS/uploads/abdelwhab.jpg');

INSERT INTO customers (name, email, phone_number, address, date_of_birth, national_id, created_at, updated_at)
VALUES
    ('Ahmed Fathy', 'ahmed.fathy@example.com', '01001234567', '123 Cairo Street, Cairo', '1985-05-15', '12345678901234', NOW(), NOW()),
    ('Mona Hassan', 'mona.hassan@example.com', '01009876543', '456 Alexandria Road, Alexandria', '1992-08-20', '23456789012345', NOW(), NOW()),
    ('Mohamed Ali', 'mohamed.ali@example.com', '01101234567', '789 Giza Square, Giza', '1988-02-10', '34567890123456', NOW(), NOW()),
    ('Sara Khaled', 'sara.khaled@example.com', '01011122334', '123 Mansoura Street, Mansoura', '1995-03-12', '45678901234567', NOW(), NOW()),
    ('Youssef Ahmed', 'youssef.ahmed@example.com', '01209987654', '321 Tanta Road, Tanta', '1987-04-05', '56789012345678', NOW(), NOW()),
    ('Fatma Nabil', 'fatma.nabil@example.com', '01098765432', '654 Aswan Street, Aswan', '1990-06-15', '67890123456789', NOW(), NOW()),
    ('Omar Kamal', 'omar.kamal@example.com', '01102345678', '987 Port Said Avenue, Port Said', '1983-11-30', '78901234567890', NOW(), NOW()),
    ('Layla Abdel', 'layla.abdel@example.com', '01201456789', '123 Luxor Road, Luxor', '1994-09-22', '89012345678901', NOW(), NOW()),
    ('Ali Hossam', 'ali.hossam@example.com', '01091234567', '456 Suez Street, Suez', '1991-01-17', '90123456789012', NOW(), NOW()),
    ('Nourhan Youssef', 'nourhan.youssef@example.com', '01108765432', '654 Minya Avenue, Minya', '1989-07-25', '12389012345678', NOW(), NOW()),
    ('Hassan Mohamed', 'hassan.mohamed@example.com', '01201345678', '321 Ismailia Road, Ismailia', '1980-10-10', '23490123456789', NOW(), NOW()),
    ('Nadia Soliman', 'nadia.soliman@example.com', '01007654321', '987 Sohag Street, Sohag', '1996-05-04', '34591234567890', NOW(), NOW()),
    ('Mostafa Sherif', 'mostafa.sherif@example.com', '01102987654', '654 Fayoum Avenue, Fayoum', '1984-12-18', '45602345678901', NOW(), NOW()),
    ('Mariam Magdy', 'mariam.magdy@example.com', '01203345678', '123 Damanhur Road, Damanhur', '1992-11-27', '56713456789012', NOW(), NOW()),
    ('Mohamed Tamer', 'mohamed.tamer@example.com', '01009871234', '321 Qena Street, Qena', '1993-03-14', '67824567890123', NOW(), NOW()),
    ('Maha Said', 'maha.said@example.com', '01102123456', '654 Kafr El Sheikh Road, Kafr El Sheikh', '1986-06-19', '78935678901234', NOW(), NOW()),
    ('Fayza Ahmed', 'fayza.ahmed@example.com', '01203456789', '987 Gharbia Street, Gharbia', '1990-01-05', '89046789012345', NOW(), NOW()),
    ('Tariq Hassan', 'tariq.hassan@example.com', '01001987654', '123 Damietta Road, Damietta', '1985-09-12', '90157890123456', NOW(), NOW()),
    ('Rania Gamal', 'rania.gamal@example.com', '01107345678', '456 Beheira Street, Beheira', '1994-04-03', '12368901234567', NOW(), NOW());

COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
