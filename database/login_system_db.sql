-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2024 at 06:23 PM
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
  `availability` varchar(20) NOT NULL,
  `image_path` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `isbn`, `pub_year`, `genre`, `availability`, `image_path`) VALUES
(17, 'Harry Potter and the Sorcerer\'s Stone', 'J.K. Rowling', '978-0590353427', 1997, 'Fantasy', 'Not Available', 0x75706c6f6164732f686172727920706f7474657220312e6a7067),
(18, 'To Kill a Mockingbird', 'Harper Lee', '978-0061120084', 1960, 'Fiction, Classic', 'Not Available', 0x75706c6f6164732f3132303070782d546f5f4b696c6c5f615f4d6f636b696e67626972645f2866697273745f65646974696f6e5f636f766572292e6a7067),
(19, 'The Great Gatsby', 'F. Scott Fitzgerald', '978-0743273565', 1925, 'Fiction, Classic', 'Not Available', 0x75706c6f6164732f5468655f47726561745f4761747362795f436f7665725f313932355f5265746f75636865642e6a7067),
(20, '1984', 'George Orwell', '978-0451524935', 1949, 'Fiction, Dystopian', 'Not Available', 0x75706c6f6164732f313938342e6a7067),
(21, 'The Catcher in the Rye', 'J.D. Salinger', '978-0316769488', 1978, 'Fiction, Coming-of-Age', 'Not Available', 0x75706c6f6164732f636174636865722d696e2d7468652d7279652d636f7665722d696d6167652d36383278313032342e6a706567),
(22, 'The Lord of the Rings', 'J.R.R. Tolkien', '978-0544003415', 1954, 'Fantasy', 'Not Available', 0x75706c6f6164732f7468652d6c6f72642d6f662d7468652d72696e67732d626f6f6b2d636f7665722e6a7067),
(23, 'Pride and Prejudice', 'Jane Austen', '978-0141439518', 1813, 'Fiction, Classic, Romance', 'Not Available', 0x75706c6f6164732f70726964652d616e642d7072656a75646963652d37312e6a7067),
(24, 'The Hobbit', 'J.R.R. Tolkien', '978-0547928227', 1937, 'Fantasy', 'Not Available', 0x75706c6f6164732f74686520686f626269742e6a7067),
(25, 'The Hunger Games', 'Suzanne Collins', '978-0439023481', 2008, 'Young Adult, Dystopian', 'Not Available', 0x75706c6f6164732f7468652068756e6765722067616d65732e6a7067),
(26, 'The Da Vinci Code', 'Dan Brown', '978-0307474278', 2003, 'Mystery, Thriller', 'Not Available', 0x75706c6f6164732f7468652d64612d76696e63692d636f64652e6a7067),
(28, 'The Alchemist', 'Paulo Coelho', '978-0062315007', 1988, 'Fiction, Inspirational', 'Not Available', 0x75706c6f6164732f74686520616c6368656d6973742e6a7067),
(29, 'The Girl with the Dragon Tattoo', 'Stieg Larsson', '978-396509843', 2005, 'Mystery, Thriller', 'Not Available', 0x75706c6f6164732f647261676f6e20746174746f6f2e6a7067),
(33, 'A Game of Thrones', 'George R.R. Martin', '978-895152732', 1996, 'Fantasy', 'Not Available', 0x75706c6f6164732f474f544d5449322e6a7067),
(34, 'The Chronicles of Narnia', 'C.S. Lewis', '978-566884303', 1950, 'Fantasy, Children\'s', 'Not Available', 0x75706c6f6164732f6e61726e69612e6a7067),
(35, 'Noli Me Tangere', 'Jose Rizal', '978-533703972', 1887, 'Fiction, Classic', 'Not Available', 0x75706c6f6164732f6e6f6c69206d652074616e676572652e6a7067),
(36, 'El Filibusterismo', 'Jose Rizal', '978-985906966', 1891, 'Fiction, Classic', 'Not Available', 0x75706c6f6164732f656c2066696c692e6a7067),
(37, 'ABNKKBSNPLAko?! (Mga Kwentong Chalk ni Bob Ong)', 'Bob Ong', '978-287710978', 2001, 'Humor, Memoir', 'Not Available', 0x75706c6f6164732f41424e4b4b42534e504c416b6f212e6a7067),
(38, 'Alamat ng Gubat', 'Bob Ong', '978-770787012', 2003, 'Fiction, Satire', 'Available', 0x75706c6f6164732f416c616d61745f6e675f47756261742e6a7067),
(39, 'Naruto Volume 1: Uzumaki Naruto', 'Masashi Kishimoto', '978-865252755', 2003, 'Shonen, Action, Adventure', 'Not Available', 0x75706c6f6164732f6e617275746f2d766f6c2d312e6a7067),
(40, 'One Piece Volume 1: Romance Dawn', 'Eiichiro Oda', '978-750763248', 2003, 'Shonen, Action, Adventure', 'Not Available', 0x75706c6f6164732f6f702d726f6d616e63652d6461776e2e6a7067),
(41, 'Attack on Titan Volume 1: The Fall of Shiganshina', 'Hajime Isayama', '978-781830480', 2012, 'Shonen, Dark Fantasy, Action', 'Not Available', 0x75706c6f6164732f5368696e67656b695f6e6f5f4b796f6a696e5f6d616e67615f766f6c756d655f312e6a7067),
(42, 'Death Note Volume 1: Boredom', 'Tsugumi Ohba', '978-327638769', 2005, 'Shonen, Psychological Thriller, Mystery', 'Not Available', 0x75706c6f6164732f64656174686e6f74652e6a7067),
(43, 'Fullmetal Alchemist Volume 1: The Land of Sand', 'Hiromu Arakawa', '978-692597068', 2005, 'Shonen, Adventure, Fantasy', 'Not Available', 0x75706c6f6164732f666d612e6a7067),
(44, 'Dragon Ball Volume 1', 'Akira Toriyama', '978-977272956', 2003, 'Shonen, Action, Adventure', 'Not Available', 0x75706c6f6164732f647261676f6e2d62616c6c2d766f6c2d312d736a2d65646974696f6e2e6a7067),
(45, 'My Hero Academia Volume 1: Izuku Midoriya: Origin', 'Kohei Horikoshi', '978-424553775', 2015, 'Shonen, Superhero, Action', 'Not Available', 0x75706c6f6164732f6d68612076312e6a7067),
(46, 'Demon Slayer: Kimetsu no Yaiba Volume 1: Cruelty', 'Koyoharu Gotouge', '978-653106549', 2018, 'Shonen, Action, Dark Fantasy', 'Not Available', 0x75706c6f6164732f64656d6f6e2d736c617965722d6b696d657473752d6e6f2d79616962612d766f6c2d312e6a7067),
(48, 'Haikyu!! Volume 1: Hinata and Kageyama', 'Haruichi Furudate', '978-4088806948', 2012, 'Shonen, Sports, Volleyball', 'Not Available', 0x75706c6f6164732f6861696b79752e6a7067),
(49, 'Black Clover Volume 1: The Boy\'s Vow', 'Yūki Tabata', '978-574544535', 2015, 'Shonen, Fantasy, Magic', 'Not Available', 0x75706c6f6164732f626c61636b636c6f7665722e6a7067);

-- --------------------------------------------------------

--
-- Table structure for table `borrowed_books`
--

CREATE TABLE `borrowed_books` (
  `borrow_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `borrow_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrowed_books`
--

INSERT INTO `borrowed_books` (`borrow_id`, `user_id`, `book_id`, `borrow_date`, `return_date`) VALUES
(8, 19, 17, '2024-03-04', '2024-03-23'),
(9, 19, 18, '2024-03-04', '2024-03-30'),
(10, 19, 19, '2024-03-04', '2024-03-30'),
(11, 19, 20, '2024-03-04', '2024-03-29'),
(12, 20, 21, '2024-03-04', '2024-05-16'),
(13, 19, 24, '2024-03-04', '2024-03-30'),
(14, 19, 26, '2024-03-04', '2024-03-23'),
(15, 21, 46, '2024-03-04', '2024-04-30'),
(16, 21, 43, '2024-03-04', '2024-04-18'),
(17, 19, 29, '2024-03-04', '2024-03-15'),
(18, 20, 45, '2024-03-05', '2024-03-31'),
(19, 21, 44, '2024-03-05', '2024-03-23'),
(20, 21, 44, '2024-03-05', '2024-03-30'),
(21, 21, 23, '2024-03-05', '2024-03-16'),
(22, 21, 22, '2024-03-05', '2024-03-30'),
(23, 20, 25, '2024-03-05', '2024-03-30'),
(24, 20, 28, '2024-03-05', '2024-03-30'),
(25, 22, 33, '2024-03-05', '2024-05-25'),
(26, 22, 34, '2024-03-05', '2024-03-30'),
(27, 22, 35, '2024-03-05', '2024-03-30'),
(28, 19, 18, '2024-03-05', '2024-03-23'),
(29, 19, 17, '2024-03-05', '2024-03-30'),
(30, 21, 19, '2024-03-05', '2024-03-23'),
(31, 21, 20, '2024-03-05', '2024-03-30'),
(32, 21, 46, '2024-03-05', '2027-03-31'),
(33, 19, 20, '2024-03-05', '2024-03-31'),
(34, 19, 21, '2024-03-05', '2024-03-31'),
(35, 19, 49, '2024-03-05', '2024-03-31'),
(36, 22, 17, '2024-03-05', '2024-03-31'),
(37, 22, 48, '2024-03-05', '2024-03-30'),
(38, 22, 43, '2024-03-05', '2024-04-27'),
(39, 23, 24, '2024-03-05', '2024-03-30'),
(40, 23, 26, '2024-03-05', '2024-03-30'),
(41, 23, 40, '2024-03-05', '2024-03-30'),
(42, 20, 29, '2024-03-05', '2024-03-30'),
(43, 20, 36, '2024-03-05', '2024-03-30'),
(44, 21, 42, '2024-03-05', '2024-03-23'),
(45, 21, 41, '2024-03-05', '2024-03-30'),
(46, 21, 37, '2024-03-05', '2024-03-28'),
(47, 22, 39, '2024-03-05', '2024-03-30');

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
-- Table structure for table `return_history`
--

CREATE TABLE `return_history` (
  `return_id` int(11) NOT NULL,
  `borrow_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `returned_date_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `return_history`
--

INSERT INTO `return_history` (`return_id`, `borrow_id`, `user_id`, `book_id`, `returned_date_time`, `status`) VALUES
(1, 15, 21, 46, '2024-03-05 09:52:28', 'returned'),
(2, 19, 21, 44, '2024-03-05 10:00:04', 'returned'),
(3, 16, 21, 43, '2024-03-05 10:05:41', 'returned'),
(4, 12, 20, 21, '2024-03-05 11:56:25', 'returned'),
(5, 11, 19, 20, '2024-03-05 12:00:45', 'returned'),
(6, 8, 19, 17, '2024-03-05 12:00:52', 'returned'),
(7, 9, 19, 18, '2024-03-05 12:01:00', 'returned'),
(8, 10, 19, 19, '2024-03-05 12:01:04', 'returned'),
(9, 13, 19, 24, '2024-03-05 12:01:06', 'returned'),
(10, 14, 19, 26, '2024-03-05 12:01:08', 'returned'),
(11, 17, 19, 29, '2024-03-05 12:01:10', 'returned'),
(12, 29, 19, 17, '2024-03-05 14:14:44', 'returned'),
(13, 31, 21, 20, '2024-03-05 16:33:26', 'returned');

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
(19, 'user01', '$2y$10$ZcIJAaijt7fsOM94WOQ7VO9iuOlngdHeeSmbdt7zPbiLIjlopukOS', '2024-02-29 17:32:35', 'user'),
(20, 'arjec', '$2y$10$UaJqQA3MwCIwPAVoET82iuT4L/bXTvpO20GqnlqjYodqh3LlQzc96', '2024-03-04 23:12:13', 'user'),
(21, 'alim', '$2y$10$hJTfIblmbU9nWO4wWhkiS.TW.oJtns.Y5M.imeF7BlSmDamIqsfgG', '2024-03-05 03:36:45', 'user'),
(22, 'luffy', '$2y$10$Lo71Gy6hdn5vmXgzhqzXo.v4vLfVS6PsKV/BVGA.MSlNmx1Jv2PV2', '2024-03-05 03:55:05', 'user'),
(23, 'johndoe69', '$2y$10$FWOVzitIKMYjAgTiN9kqZO.rdFLddWFPYRHNUxj8UvjGUxGl/JHha', '2024-03-06 00:43:33', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  ADD PRIMARY KEY (`borrow_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`img_id`);

--
-- Indexes for table `return_history`
--
ALTER TABLE `return_history`
  ADD PRIMARY KEY (`return_id`),
  ADD KEY `borrow_id` (`borrow_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

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
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  MODIFY `borrow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `return_history`
--
ALTER TABLE `return_history`
  MODIFY `return_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrowed_books`
--
ALTER TABLE `borrowed_books`
  ADD CONSTRAINT `borrowed_books_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `borrowed_books_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);

--
-- Constraints for table `return_history`
--
ALTER TABLE `return_history`
  ADD CONSTRAINT `return_history_ibfk_1` FOREIGN KEY (`borrow_id`) REFERENCES `borrowed_books` (`borrow_id`),
  ADD CONSTRAINT `return_history_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `return_history_ibfk_3` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
