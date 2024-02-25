-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2024 at 09:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login_system_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `isbn` varchar(100) NOT NULL,
  `pub_year` int(11) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `image_path` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `isbn`, `pub_year`, `genre`, `image_path`) VALUES
(17, 'Harry Potter and the Sorcerer\'s Stone', 'J.K. Rowling', '978-0590353427', 1997, 'Fantasy', 0x75706c6f6164732f48617272795f506f747465725f616e645f7468655f5068696c6f736f7068657227735f53746f6e655f426f6f6b5f436f7665722e6a7067),
(18, 'To Kill a Mockingbird', 'Harper Lee', '978-0061120084', 1960, 'Fiction, Classic', 0x75706c6f6164732f3132303070782d546f5f4b696c6c5f615f4d6f636b696e67626972645f2866697273745f65646974696f6e5f636f766572292e6a7067),
(19, 'The Great Gatsby', 'F. Scott Fitzgerald', '978-0743273565', 1925, 'Fiction, Classic', 0x75706c6f6164732f5468655f47726561745f4761747362795f436f7665725f313932355f5265746f75636865642e6a7067),
(20, '1984', 'George Orwell', '978-0451524935', 1949, 'Fiction, Dystopian', 0x75706c6f6164732f313938342e6a7067),
(21, 'The Catcher in the Rye', 'J.D. Salinger', '978-0316769488', 1978, 'Fiction, Coming-of-Age', 0x75706c6f6164732f636174636865722d696e2d7468652d7279652d636f7665722d696d6167652d36383278313032342e6a706567),
(22, 'The Lord of the Rings', 'J.R.R. Tolkien', '978-0544003415', 1954, 'Fantasy', 0x75706c6f6164732f7468652d6c6f72642d6f662d7468652d72696e67732d626f6f6b2d636f7665722e6a7067),
(23, 'Pride and Prejudice', 'Jane Austen', '978-0141439518', 1813, 'Fiction, Classic, Romance', 0x75706c6f6164732f70726964652d616e642d7072656a75646963652d37312e6a7067),
(24, 'The Hobbit', 'J.R.R. Tolkien', '978-0547928227', 1937, 'Fantasy', 0x75706c6f6164732f74686520686f626269742e6a7067),
(25, 'The Hunger Games', 'Suzanne Collins', '978-0439023481', 2008, 'Young Adult, Dystopian', 0x75706c6f6164732f7468652068756e6765722067616d65732e6a7067),
(26, 'The Da Vinci Code', 'Dan Brown', '978-0307474278', 2003, 'Mystery, Thriller', 0x75706c6f6164732f7468652d64612d76696e63692d636f64652e6a7067),
(27, 'Gone with the Wind', 'Margaret Mitchell', '978-1451635621', 1936, 'Historical Fiction, Romance', 0x75706c6f6164732f676f6e652d776974682d7468652d77696e642d393738313435313633353632315f6c672e6a7067),
(28, 'The Alchemist', 'Paulo Coelho', '978-0062315007', 1988, 'Fiction, Inspirational', 0x75706c6f6164732f74686520616c6368656d6973742e6a7067),
(29, 'The Girl with the Dragon Tattoo', 'Stieg Larsson', '978-396509843', 2005, 'Mystery, Thriller', 0x75706c6f6164732f647261676f6e20746174746f6f2e6a7067),
(30, 'The Fault in Our Stars', 'John Green', '978-330023295', 2012, 'Young Adult, Romance', 0x75706c6f6164732f5468655f4661756c745f696e5f4f75725f53746172732e6a7067),
(31, 'The Secret', 'Rhonda Byrne', '978-495770694', 2006, 'Self-help, Inspirational', 0x75706c6f6164732f7468652d7365637265742d393738313538323730313730375f68722e6a7067),
(32, 'The Road', 'Cormac McCarthy', '978-123454484', 2006, 'Fiction, Dystopian', 0x75706c6f6164732f7468652d726f61642d32362e6a7067),
(33, 'A Game of Thrones', 'George R.R. Martin', '978-895152732', 1996, 'Fantasy', 0x75706c6f6164732f474f544d5449322e6a7067),
(34, 'The Chronicles of Narnia', 'C.S. Lewis', '978-566884303', 1950, 'Fantasy, Children\'s', 0x75706c6f6164732f6e61726e69612e6a7067);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `img_id` int(11) NOT NULL,
  `file` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`img_id`, `file`) VALUES
(1, 'The_Great_Gatsby_Cover_1925_Retouched.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `user_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `user_type`) VALUES
(14, 'admin', '$2y$10$hx7IQKH9AedGbB9t7NASMeAEEdwUM3auxfpFUm5w5l1epjKmH5pqa', '2024-02-19 00:01:30', 'admin'),
(16, 'user1', '$2y$10$QHiglfN5XyPw1CWcqG3DseIp4Zb8Jewll0.LzM.3JozIk7aB3j3cS', '2024-02-19 11:12:02', 'user'),
(17, 'qwerty', '$2y$10$C3Eh2UN9PZrmWjBXLaJ7QeSI70jNL03xeIUaiAb40TAx6VseOtGZ6', '2024-02-19 13:11:25', 'user'),
(18, 'arjecdizon', '$2y$10$howSqmIwj7TidaNn29YTzuNtWn8raWZRLz9LcvinTy91..9.6eQiO', '2024-02-22 23:36:23', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`img_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
