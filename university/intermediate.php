<?php
include 'conn.php';

// 5. List all courses along with the number of students enrolled
$sql_courses_enrollment = "
    SELECT c.course_name, COUNT(e.student_id) AS number_of_students
    FROM Courses c
    LEFT JOIN Enrollments e ON c.course_id = e.course_id
    GROUP BY c.course_id
";
$result_courses_enrollment = $pdo->query($sql_courses_enrollment);

echo "<h2>All Courses and Number of Students Enrolled:</h2>";
if ($result_courses_enrollment->rowCount() > 0) {
    while ($row = $result_courses_enrollment->fetch(PDO::FETCH_ASSOC)) {
        echo "Course: " . $row['course_name'] . " - Students Enrolled: " . $row['number_of_students'] . "<br>";
    }
} else {
    echo "No courses found.<br>";
}

// 6. Find the students who were enrolled in a course with a grade of 'A'
$sql_students_with_a = "
    SELECT s.first_name, s.last_name
    FROM Students s
    JOIN Enrollments e ON s.student_id = e.student_id
    WHERE e.grade = 'A'
";
$result_students_with_a = $pdo->query($sql_students_with_a);

echo "<h2>Students with Grade 'A':</h2>";
if ($result_students_with_a->rowCount() > 0) {
    while ($row = $result_students_with_a->fetch(PDO::FETCH_ASSOC)) {
        echo $row['first_name'] . " " . $row['last_name'] . "<br>";
    }
} else {
    echo "No students found with grade 'A'.<br>";
}

// 7. Retrieve the courses and the instructors assigned for a specific semester
$semester = 'Fall'; // Change this to the desired semester
$sql_courses_instructors = "
    SELECT c.course_name, i.first_name, i.last_name
    FROM Courses c
    JOIN Course_Assignments ca ON c.course_id = ca.course_id
    JOIN Instructors i ON ca.instructor_id = i.instructor_id
    WHERE ca.semester = :semester
";
$stmt = $pdo->prepare($sql_courses_instructors);
$stmt->execute(['semester' => $semester]);

echo "<h2>Courses and Instructors Assigned for $semester:</h2>";
if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Course: " . $row['course_name'] . " - Instructor: " . $row['first_name'] . " " . $row['last_name'] . "<br>";
    }
} else {
    echo "No courses found for the specified semester.<br>";
}

// 8. Find the average grade for a particular course
$course_id = 1; // Change this to the course ID you want to check
$sql_average_grade = "
    SELECT AVG(CASE 
        WHEN grade = 'A' THEN 4.0
        WHEN grade = 'A-' THEN 3.7
        WHEN grade = 'B+' THEN 3.3
        WHEN grade = 'B' THEN 3.0
        WHEN grade = 'B-' THEN 2.7
        WHEN grade = 'C+' THEN 2.3
        WHEN grade = 'C' THEN 2.0
        WHEN grade = 'C-' THEN 1.7
        WHEN grade = 'D+' THEN 1.3
        WHEN grade = 'D' THEN 1.0
        WHEN grade = 'F' THEN 0.0
    END) AS average_grade
    FROM Enrollments
    WHERE course_id = :course_id
";
$stmt = $pdo->prepare($sql_average_grade);
$stmt->execute(['course_id' => $course_id]);
$row_avg_grade = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<h2>Average Grade for Course ID $course_id: " . round($row_avg_grade['average_grade'], 2) . "</h2>";
?>
