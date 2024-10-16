<?php
include 'conn.php';

// Step 1: Create a Function to Calculate Age
$ageFunctionSQL = "
    CREATE FUNCTION calculate_age(dob DATE) 
    RETURNS INT DETERMINISTIC
    BEGIN
        DECLARE age INT;
        SET age = YEAR(CURDATE()) - YEAR(dob) - (DATE_FORMAT(CURDATE(), '%m%d') < DATE_FORMAT(dob, '%m%d'));
        RETURN age;
    END;
";

try {
    $pdo->exec($ageFunctionSQL);
    echo "Function calculate_age created successfully.<br>";
} catch (PDOException $e) {
    echo "Error creating function: " . $e->getMessage() . "<br>";
}

// Step 2: Create a Stored Procedure to Enroll a Student
$storedProcedureSQL = "
    CREATE PROCEDURE enroll_student(IN student_id INT, IN course_id INT)
    BEGIN
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
    END;
";

try {
    $pdo->exec($storedProcedureSQL);
    echo "Stored procedure enroll_student created successfully.<br>";
} catch (PDOException $e) {
    echo "Error creating stored procedure: " . $e->getMessage() . "<br>";
}

// Step 3: Show Average Grades by Department
$sql_average_grades = "
    SELECT 
        i.department,
        AVG(CASE 
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
    FROM Enrollments e
    JOIN Courses c ON e.course_id = c.course_id
    JOIN Instructors i ON c.department = i.department
    GROUP BY i.department;
";

$result_average_grades = $pdo->query($sql_average_grades);

echo "<h2>Average Grades by Department:</h2>";
if ($result_average_grades->rowCount() > 0) {
    while ($row = $result_average_grades->fetch(PDO::FETCH_ASSOC)) {
        echo "Department: " . $row['department'] . " - Average Grade: " . round($row['average_grade'], 2) . "<br>";
    }
} else {
    echo "No average grades found.<br>";
}
?>
