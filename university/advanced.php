<?php
include 'conn.php';

// 9. List students taking more than 3 courses in the current semester
$current_semester = 'Fall'; // Change to the current semester
$sql_students_over_3_courses = "
    SELECT s.first_name, s.last_name, COUNT(e.course_id) AS course_count
    FROM Students s
    JOIN Enrollments e ON s.student_id = e.student_id
    JOIN Course_Assignments ca ON e.course_id = ca.course_id
    WHERE ca.semester = :current_semester
    GROUP BY s.student_id
    HAVING COUNT(e.course_id) > 3
";
$stmt = $pdo->prepare($sql_students_over_3_courses);
$stmt->execute(['current_semester' => $current_semester]);

echo "<h2>Students Taking More Than 3 Courses in $current_semester:</h2>";
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['first_name'] . " " . $row['last_name'] . " - Courses: " . $row['course_count'] . "<br>";
    }
} else {
    echo "No students found taking more than 3 courses.<br>";
}

// 10. Generate a report of students with incomplete grades
$sql_incomplete_grades = "
    SELECT s.first_name, s.last_name, e.course_id
    FROM Students s
    JOIN Enrollments e ON s.student_id = e.student_id
    WHERE e.grade IS NULL OR e.grade = ''
";
$result_incomplete_grades = $pdo->query($sql_incomplete_grades);

echo "<h2>Students with Incomplete Grades:</h2>";
if ($result_incomplete_grades->rowCount() > 0) {
    while ($row = $result_incomplete_grades->fetch(PDO::FETCH_ASSOC)) {
        echo $row['first_name'] . " " . $row['last_name'] . " - Course ID: " . $row['course_id'] . "<br>";
    }
} else {
    echo "No students found with incomplete grades.<br>";
}

// 11. Show the student with the highest average grade across courses
$sql_highest_average_grade = "
    SELECT s.first_name, s.last_name, AVG(CASE 
        WHEN e.grade = 'A' THEN 4.0
        WHEN e.grade = 'A-' THEN 3.7
        WHEN e.grade = 'B+' THEN 3.3
        WHEN e.grade = 'B' THEN 3.0
        WHEN e.grade = 'B-' THEN 2.7
        WHEN e.grade = 'C+' THEN 2.3
        WHEN e.grade = 'C' THEN 2.0
        WHEN e.grade = 'C-' THEN 1.7
        WHEN e.grade = 'D+' THEN 1.3
        WHEN e.grade = 'D' THEN 1.0
        WHEN e.grade = 'F' THEN 0.0
    END) AS average_grade
    FROM Students s
    JOIN Enrollments e ON s.student_id = e.student_id
    GROUP BY s.student_id
    ORDER BY average_grade DESC
    LIMIT 1
";
$result_highest_average_grade = $pdo->query($sql_highest_average_grade);
$row_highest_average = $result_highest_average_grade->fetch(PDO::FETCH_ASSOC);

if ($row_highest_average) {
    echo "<h2>Student with the Highest Average Grade:</h2>";
    echo $row_highest_average['first_name'] . " " . $row_highest_average['last_name'] . " - Average Grade: " . round($row_highest_average['average_grade'], 2) . "<br>";
} else {
    echo "No students found.<br>";
}

// 12. Find the department with the most courses taught this year
$current_year = date('Y');
$sql_department_most_courses = "
    SELECT i.department, COUNT(c.course_id) AS course_count
    FROM Instructors i
    JOIN Course_Assignments ca ON i.instructor_id = ca.instructor_id
    JOIN Courses c ON ca.course_id = c.course_id
    WHERE ca.year = :current_year
    GROUP BY i.department
    ORDER BY course_count DESC
    LIMIT 1
";
$stmt = $pdo->prepare($sql_department_most_courses);
$stmt->execute(['current_year' => $current_year]);
$row_department_most_courses = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row_department_most_courses) {
    echo "<h2>Department with the Most Courses Taught This Year:</h2>";
    echo $row_department_most_courses['department'] . " - Courses: " . $row_department_most_courses['course_count'] . "<br>";
} else {
    echo "No courses found for this year.<br>";
}

// 13. List courses with no student enrollments
$sql_courses_no_enrollments = "
    SELECT c.course_name
    FROM Courses c
    LEFT JOIN Enrollments e ON c.course_id = e.course_id
    WHERE e.course_id IS NULL
";
$result_courses_no_enrollments = $pdo->query($sql_courses_no_enrollments);

echo "<h2>Courses with No Student Enrollments:</h2>";
if ($result_courses_no_enrollments->rowCount() > 0) {
    while ($row = $result_courses_no_enrollments->fetch(PDO::FETCH_ASSOC)) {
        echo $row['course_name'] . "<br>";
    }
} else {
    echo "All courses have student enrollments.<br>";
}
?>
