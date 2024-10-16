<?php
include 'conn.php';

// Step 1: Inner Join to Fetch Students and the Courses They Are Enrolled In
$innerJoinSQL = "
    SELECT s.student_id, s.first_name, s.last_name, c.course_name
    FROM Students s
    INNER JOIN Enrollments e ON s.student_id = e.student_id
    INNER JOIN Courses c ON e.course_id = c.course_id;
";

echo "<h2>Students and the Courses They Are Enrolled In:</h2>";
try {
    $innerJoinResult = $pdo->query($innerJoinSQL);

    echo "<table border='1'>
            <tr>
                <th>Student ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Course Name</th>
            </tr>";

    while ($row = $innerJoinResult->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['student_id']}</td>
                <td>{$row['first_name']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['course_name']}</td>
              </tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    echo "Error fetching students and courses: " . $e->getMessage() . "<br>";
}

// Step 2: Left Join to Show Instructors and Courses They Teach
$leftJoinSQL = "
    SELECT i.instructor_id, i.first_name, i.last_name, c.course_name
    FROM Instructors i
    LEFT JOIN Course_Assignments ca ON i.instructor_id = ca.instructor_id
    LEFT JOIN Courses c ON ca.course_id = c.course_id;
";

echo "<h2>Instructors and the Courses They Teach:</h2>";
try {
    $leftJoinResult = $pdo->query($leftJoinSQL);

    echo "<table border='1'>
            <tr>
                <th>Instructor ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Course Name</th>
            </tr>";

    while ($row = $leftJoinResult->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['instructor_id']}</td>
                <td>{$row['first_name']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['course_name']}</td>
              </tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    echo "Error fetching instructors and courses: " . $e->getMessage() . "<br>";
}

// Step 3: Union to List All Students and Instructors
$unionSQL = "
    SELECT first_name, last_name, email, 'Student' AS role FROM Students
    UNION ALL
    SELECT first_name, last_name, email, 'Instructor' AS role FROM Instructors;
";

echo "<h2>List of All Students and Instructors:</h2>";
try {
    $unionResult = $pdo->query($unionSQL);

    echo "<table border='1'>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
            </tr>";

    while ($row = $unionResult->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['first_name']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['role']}</td>
              </tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    echo "Error fetching students and instructors: " . $e->getMessage() . "<br>";
}
?>
