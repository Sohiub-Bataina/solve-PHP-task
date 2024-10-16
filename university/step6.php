<?php
include 'conn.php';

// Step 1: Create an Index on course_code
$createIndexSQL = "
    CREATE INDEX idx_course_code ON Courses(course_code);
";

try {
    $pdo->exec($createIndexSQL);
    echo "Index on course_code created successfully.<br>";
} catch (PDOException $e) {
    echo "Error creating index: " . $e->getMessage() . "<br>";
}

// Step 2: Optimize a Query Using EXPLAIN to Fetch Students Enrolled in a Course
$course_id = 1; // Replace with the actual course ID

$explainSQL = "
    EXPLAIN SELECT s.student_id, s.first_name, s.last_name
    FROM Students s
    JOIN Enrollments e ON s.student_id = e.student_id
    WHERE e.course_id = :course_id;
";

try {
    $stmt = $pdo->prepare($explainSQL);
    $stmt->execute(['course_id' => $course_id]);
    $explainResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>EXPLAIN Result for Fetching Students Enrolled in Course ID $course_id:</h2>";
    echo "<table border='1'>
            <tr>
                <th>id</th>
                <th>select_type</th>
                <th>table</th>
                <th>type</th>
                <th>possible_keys</th>
                <th>key</th>
                <th>key_len</th>
                <th>ref</th>
                <th>rows</th>
                <th>Extra</th>
            </tr>";

    foreach ($explainResult as $row) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['select_type']}</td>
                <td>{$row['table']}</td>
                <td>{$row['type']}</td>
                <td>{$row['possible_keys']}</td>
                <td>{$row['key']}</td>
                <td>{$row['key_len']}</td>
                <td>{$row['ref']}</td>
                <td>{$row['rows']}</td>
                <td>{$row['Extra']}</td>
              </tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    echo "Error explaining query: " . $e->getMessage() . "<br>";
}
?>
