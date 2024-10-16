<?php
include 'conn.php';

// Step 1: Generate a Report for Students
$reportSQL = "
    SELECT 
        s.first_name AS student_first_name,
        s.last_name AS student_last_name,
        s.email AS student_email,
        s.major AS student_major,
        c.course_name AS course_name,
        i.first_name AS instructor_first_name,
        i.last_name AS instructor_last_name,
        e.grade AS grade,
        c.credits AS credits
    FROM Students s
    JOIN Enrollments e ON s.student_id = e.student_id
    JOIN Courses c ON e.course_id = c.course_id
    JOIN Course_Assignments ca ON c.course_id = ca.course_id
    JOIN Instructors i ON ca.instructor_id = i.instructor_id
    ORDER BY s.student_id;
";

echo "<h2>Student Enrollment Report:</h2>";
try {
    $reportResult = $pdo->query($reportSQL);

    echo "<table border='1'>
            <tr>
                <th>Student First Name</th>
                <th>Student Last Name</th>
                <th>Student Email</th>
                <th>Student Major</th>
                <th>Course Name</th>
                <th>Instructor First Name</th>
                <th>Instructor Last Name</th>
                <th>Grade</th>
                <th>Credits</th>
            </tr>";

    $totalCredits = [];

    while ($row = $reportResult->fetch(PDO::FETCH_ASSOC)) {
        // Accumulate total credits per student
        if (!isset($totalCredits[$row['student_email']])) {
            $totalCredits[$row['student_email']] = 0;
        }
        $totalCredits[$row['student_email']] += $row['credits'];

        echo "<tr>
                <td>{$row['student_first_name']}</td>
                <td>{$row['student_last_name']}</td>
                <td>{$row['student_email']}</td>
                <td>{$row['student_major']}</td>
                <td>{$row['course_name']}</td>
                <td>{$row['instructor_first_name']}</td>
                <td>{$row['instructor_last_name']}</td>
                <td>{$row['grade']}</td>
                <td>{$row['credits']}</td>
              </tr>";
    }
    echo "</table>";

    // Display total credits per student
    echo "<h2>Total Credits per Student:</h2>";
    echo "<table border='1'>
            <tr>
                <th>Student Email</th>
                <th>Total Credits</th>
            </tr>";
    foreach ($totalCredits as $email => $credits) {
        echo "<tr>
                <td>$email</td>
                <td>$credits</td>
              </tr>";
    }
    echo "</table>";

} catch (PDOException $e) {
    echo "Error generating report: " . $e->getMessage() . "<br>";
}
?>
