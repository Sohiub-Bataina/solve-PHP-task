<?php
include 'conn.php';

$sql_students = "SELECT * FROM Students";
$result_students = $pdo->query($sql_students);

if ($result_students->rowCount() > 0) {
    echo "<h2>All Students:</h2>";
    while ($row = $result_students->fetch(PDO::FETCH_ASSOC)) {
        echo "ID: " . $row['student_id'] . " - Name: " . $row['first_name'] . " " . $row['last_name'] . "<br>";
    }
} else {
    echo "No students found.<br>";
}

$sql_courses_count = "SELECT COUNT(*) AS total_courses FROM Courses";
$result_courses_count = $pdo->query($sql_courses_count);
$row_count = $result_courses_count->fetch(PDO::FETCH_ASSOC);
echo "<h2>Total Courses Offered: " . $row_count['total_courses'] . "</h2>";

$course_id = 1;
$sql_students_in_course = "
    SELECT s.first_name, s.last_name
    FROM Students s
    JOIN Enrollments e ON s.student_id = e.student_id
    WHERE e.course_id = :course_id
";
$stmt = $pdo->prepare($sql_students_in_course);
$stmt->execute(['course_id' => $course_id]);

if ($stmt->rowCount() > 0) {
    echo "<h2>Students Enrolled in Course ID $course_id:</h2>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['first_name'] . " " . $row['last_name'] . "<br>";
    }
} else {
    echo "No students found in this course.<br>";
}

$department_name = 'Computer Science';
$sql_instructors_in_department = "
    SELECT email 
    FROM Instructors 
    WHERE department = :department
";
$stmt = $pdo->prepare($sql_instructors_in_department);
$stmt->execute(['department' => $department_name]);

if ($stmt->rowCount() > 0) {
    echo "<h2>Email Addresses of Instructors in $department_name:</h2>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['email'] . "<br>";
    }
} else {
    echo "No instructors found in this department.<br>";
}
?>
