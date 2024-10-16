-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 16, 2024 at 09:44 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `comprehensive`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `enroll_student`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `enroll_student` (IN `student_id` INT, IN `course_id` INT)   BEGIN
        DECLARE current_capacity INT;
        DECLARE max_capacity INT;

        SELECT COUNT(*) INTO current_capacity 
        FROM Enrollments 
        WHERE course_id = course_id;

        SELECT credits INTO max_capacity 
        FROM Courses 
        WHERE course_id = course_id;

        IF current_capacity < max_capacity THEN
            INSERT INTO Enrollments (student_id, course_id) VALUES (student_id, course_id);
        ELSE
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Course capacity exceeded';
        END IF;
    END$$

--
-- Functions
--
DROP FUNCTION IF EXISTS `calculate_age`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `calculate_age` (`dob` DATE) RETURNS INT DETERMINISTIC BEGIN
        DECLARE age INT;
        SET age = YEAR(CURDATE()) - YEAR(dob) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(dob, '%m%d'));
        RETURN age;
    END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `course_id` int NOT NULL AUTO_INCREMENT,
  `course_name` varchar(100) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `credits` int NOT NULL,
  `department` varchar(100) NOT NULL,
  PRIMARY KEY (`course_id`),
  UNIQUE KEY `course_code` (`course_code`),
  KEY `idx_course_code` (`course_code`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_code`, `credits`, `department`) VALUES
(1, 'Introduction to Computer Science', 'CS101', 4, 'Computer Science'),
(2, 'Business Management', 'BUS201', 3, 'Business'),
(3, 'Electrical Circuits', 'EE101', 4, 'Electrical Engineering'),
(4, 'Mechanics', 'ME102', 4, 'Mechanical Engineering'),
(5, 'Quantum Physics', 'PHY301', 4, 'Physics');

-- --------------------------------------------------------

--
-- Table structure for table `course_assignments`
--

DROP TABLE IF EXISTS `course_assignments`;
CREATE TABLE IF NOT EXISTS `course_assignments` (
  `assignment_id` int NOT NULL AUTO_INCREMENT,
  `instructor_id` int NOT NULL,
  `course_id` int NOT NULL,
  `semester` varchar(10) NOT NULL,
  `year` year NOT NULL,
  PRIMARY KEY (`assignment_id`),
  KEY `instructor_id` (`instructor_id`),
  KEY `course_id` (`course_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `course_assignments`
--

INSERT INTO `course_assignments` (`assignment_id`, `instructor_id`, `course_id`, `semester`, `year`) VALUES
(1, 1, 1, 'Fall', '2023'),
(2, 2, 2, 'Spring', '2023'),
(3, 3, 3, 'Fall', '2023'),
(4, 4, 4, 'Spring', '2023'),
(5, 5, 5, 'Fall', '2023');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

DROP TABLE IF EXISTS `enrollments`;
CREATE TABLE IF NOT EXISTS `enrollments` (
  `enrollment_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `course_id` int NOT NULL,
  `grade` char(2) DEFAULT NULL,
  PRIMARY KEY (`enrollment_id`),
  KEY `student_id` (`student_id`),
  KEY `course_id` (`course_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`enrollment_id`, `student_id`, `course_id`, `grade`) VALUES
(1, 1, 1, 'A'),
(2, 1, 5, 'B+'),
(3, 2, 2, 'A-'),
(4, 2, 4, 'B'),
(5, 3, 3, 'B+'),
(6, 3, 5, 'A'),
(7, 4, 1, 'B-'),
(8, 4, 3, 'A'),
(9, 5, 1, 'A'),
(10, 5, 4, 'B+'),
(11, 6, 2, 'A-'),
(12, 6, 5, 'B+'),
(13, 7, 5, 'A'),
(14, 7, 1, 'B'),
(15, 8, 3, 'A-'),
(16, 8, 4, 'B+'),
(17, 9, 2, 'A'),
(18, 9, 5, 'B'),
(19, 10, 1, 'B+'),
(20, 10, 2, 'A-');

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

DROP TABLE IF EXISTS `instructors`;
CREATE TABLE IF NOT EXISTS `instructors` (
  `instructor_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `hire_date` date NOT NULL,
  `department` varchar(100) NOT NULL,
  PRIMARY KEY (`instructor_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`instructor_id`, `first_name`, `last_name`, `email`, `hire_date`, `department`) VALUES
(1, 'Ahmed', 'Mahmoud', 'ahmed.mahmoud@example.com', '2015-09-01', 'Computer Science'),
(2, 'Layla', 'Khaled', 'layla.khaled@example.com', '2012-08-15', 'Business'),
(3, 'Zaid', 'Farah', 'zaid.farah@example.com', '2018-01-10', 'Electrical Engineering'),
(4, 'Nour', 'Abdullah', 'nour.abdullah@example.com', '2016-04-22', 'Mechanical Engineering'),
(5, 'Hiba', 'Tariq', 'hiba.tariq@example.com', '2017-03-05', 'Physics');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `student_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` char(1) NOT NULL,
  `major` varchar(100) DEFAULT NULL,
  `enrollment_year` year NOT NULL,
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `unique_email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `first_name`, `last_name`, `email`, `date_of_birth`, `gender`, `major`, `enrollment_year`) VALUES
(1, 'Omar', 'Ahmed', 'omar.ahmed@example.com', '2000-05-15', 'M', 'Computer Science', '2020'),
(2, 'Fatima', 'Hassan', 'fatima.hassan@example.com', '2001-08-22', 'F', 'Business', '2021'),
(3, 'Ali', 'Saleh', 'ali.saleh@example.com', '1999-11-10', 'M', 'Electrical Engineering', '2019'),
(4, 'Sara', 'Yousef', 'sara.yousef@example.com', '2000-03-30', 'F', 'Mechanical Engineering', '2020'),
(5, 'Khaled', 'Omar', 'khaled.omar@example.com', '2002-01-20', 'M', 'Computer Science', '2022'),
(6, 'Mariam', 'Nasser', 'mariam.nasser@example.com', '1998-07-05', 'F', 'Mathematics', '2018'),
(7, 'Hassan', 'Ibrahim', 'hassan.ibrahim@example.com', '2000-12-12', 'M', 'Physics', '2020'),
(8, 'Amira', 'Saad', 'amira.saad@example.com', '1999-02-17', 'F', 'Psychology', '2019'),
(9, 'Youssef', 'Ali', 'youssef.ali@example.com', '2001-09-09', 'M', 'Business', '2021'),
(10, 'Noor', 'Salem', 'noor.salem@example.com', '2000-04-24', 'F', 'Biology', '2020');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
