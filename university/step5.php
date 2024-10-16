<?php
include 'conn.php';

// Step 1: Add Unique Constraint on Student Emails
$uniqueConstraintSQL = "
    ALTER TABLE Students 
    ADD CONSTRAINT unique_email UNIQUE (email);
";

try {
    $pdo->exec($uniqueConstraintSQL);
    echo "Unique constraint on student emails added successfully.<br>";
} catch (PDOException $e) {
    echo "Error adding unique constraint: " . $e->getMessage() . "<br>";
}

// Step 2: Transaction to Enroll a Student if Course Capacity Isn't Exceeded
$student_id = 1; // Replace with the actual student ID
$course_id = 1; // Replace with the actual course ID

try {
    // Start Transaction
    $pdo->beginTransaction();

    // Check Current and Max Capacities
    $checkCapacitySQL = "
        SELECT COUNT(*) AS current_capacity, credits AS max_capacity 
        FROM Enrollments e
        JOIN Courses c ON e.course_id = c.course_id
        WHERE c.course_id = :course_id
    ";
    $stmt = $pdo->prepare($checkCapacitySQL);
    $stmt->execute(['course_id' => $course_id]);
    $capacity = $stmt->fetch(PDO::FETCH_ASSOC);

    // Enroll if capacity allows
    if ($capacity['current_capacity'] < $capacity['max_capacity']) {
        $enrollSQL = "
            INSERT INTO Enrollments (student_id, course_id) VALUES (:student_id, :course_id)
        ";
        $enrollStmt = $pdo->prepare($enrollSQL);
        $enrollStmt->execute(['student_id' => $student_id, 'course_id' => $course_id]);
        $pdo->commit();
        echo "Student enrolled successfully.<br>";
    } else {
        throw new Exception('Course capacity exceeded. Enrollment failed.');
    }
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Transaction failed: " . $e->getMessage() . "<br>";
}
?>
