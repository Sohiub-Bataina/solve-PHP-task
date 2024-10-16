-- Select the database
USE comprehensive;

-- Create the `courses` table
CREATE TABLE IF NOT EXISTS `courses` (
  `course_id` int NOT NULL AUTO_INCREMENT,
  `course_name` varchar(100) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `credits` int NOT NULL,
  `department` varchar(100) NOT NULL,
  PRIMARY KEY (`course_id`),
  UNIQUE KEY `course_code` (`course_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert data into the `courses` table
INSERT INTO `courses` (`course_name`, `course_code`, `credits`, `department`) VALUES
('Introduction to Computer Science', 'CS101', 4, 'Computer Science'),
('Business Management', 'BUS201', 3, 'Business'),
('Electrical Circuits', 'EE101', 4, 'Electrical Engineering'),
('Mechanics', 'ME102', 4, 'Mechanical Engineering'),
('Quantum Physics', 'PHY301', 4, 'Physics');

-- Create the `course_assignments` table
CREATE TABLE IF NOT EXISTS `course_assignments` (
  `assignment_id` int NOT NULL AUTO_INCREMENT,
  `instructor_id` int NOT NULL,
  `course_id` int NOT NULL,
  `semester` varchar(10) NOT NULL,
  `year` year NOT NULL,
  PRIMARY KEY (`assignment_id`),
  KEY `instructor_id` (`instructor_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert data into the `course_assignments` table
INSERT INTO `course_assignments` (`instructor_id`, `course_id`, `semester`, `year`) VALUES
(1, 1, 'Fall', 2023),
(2, 2, 'Spring', 2023),
(3, 3, 'Fall', 2023),
(4, 4, 'Spring', 2023),
(5, 5, 'Fall', 2023);

-- Create the `enrollments` table
CREATE TABLE IF NOT EXISTS `enrollments` (
  `enrollment_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `course_id` int NOT NULL,
  `grade` char(2) DEFAULT NULL,
  PRIMARY KEY (`enrollment_id`),
  KEY `student_id` (`student_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert data into the `enrollments` table
INSERT INTO `enrollments` (`student_id`, `course_id`, `grade`) VALUES
(1, 1, 'A'),
(1, 5, 'B+'),
(2, 2, 'A-'),
(2, 4, 'B'),
(3, 3, 'B+'),
(3, 5, 'A'),
(4, 1, 'B-'),
(4, 3, 'A'),
(5, 1, 'A'),
(5, 4, 'B+'),
(6, 2, 'A-'),
(6, 5, 'B+'),
(7, 5, 'A'),
(7, 1, 'B'),
(8, 3, 'A-'),
(8, 4, 'B+'),
(9, 2, 'A'),
(9, 5, 'B'),
(10, 1, 'B+'),
(10, 2, 'A-');

-- Create the `instructors` table
CREATE TABLE IF NOT EXISTS `instructors` (
  `instructor_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `hire_date` date NOT NULL,
  `department` varchar(100) NOT NULL,
  PRIMARY KEY (`instructor_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert data into the `instructors` table
INSERT INTO `instructors` (`first_name`, `last_name`, `email`, `hire_date`, `department`) VALUES
('Ahmed', 'Mahmoud', 'ahmed.mahmoud@example.com', '2015-09-01', 'Computer Science'),
('Layla', 'Khaled', 'layla.khaled@example.com', '2012-08-15', 'Business'),
('Zaid', 'Farah', 'zaid.farah@example.com', '2018-01-10', 'Electrical Engineering'),
('Nour', 'Abdullah', 'nour.abdullah@example.com', '2016-04-22', 'Mechanical Engineering'),
('Hiba', 'Tariq', 'hiba.tariq@example.com', '2017-03-05', 'Physics');

-- Create the `students` table
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
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert data into the `students` table
INSERT INTO `students` (`first_name`, `last_name`, `email`, `date_of_birth`, `gender`, `major`, `enrollment_year`) VALUES
('Omar', 'Ahmed', 'omar.ahmed@example.com', '2000-05-15', 'M', 'Computer Science', 2020),
('Fatima', 'Hassan', 'fatima.hassan@example.com', '2001-08-22', 'F', 'Business', 2021),
('Ali', 'Saleh', 'ali.saleh@example.com', '1999-11-10', 'M', 'Electrical Engineering', 2019),
('Sara', 'Yousef', 'sara.yousef@example.com', '2000-03-30', 'F', 'Mechanical Engineering', 2020),
('Khaled', 'Omar', 'khaled.omar@example.com', '2002-01-20', 'M', 'Computer Science', 2022),
('Mariam', 'Nasser', 'mariam.nasser@example.com', '1998-07-05', 'F', 'Mathematics', 2018),
('Hassan', 'Ibrahim', 'hassan.ibrahim@example.com', '2000-12-12', 'M', 'Physics', 2020),
('Amira', 'Saad', 'amira.saad@example.com', '1999-02-17', 'F', 'Psychology', 2019),
('Youssef', 'Ali', 'youssef.ali@example.com', '2001-09-09', 'M', 'Business', 2021),
('Noor', 'Salem', 'noor.salem@example.com', '2000-04-24', 'F', 'Biology', 2020);
