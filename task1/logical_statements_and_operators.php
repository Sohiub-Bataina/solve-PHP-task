<?php
// 1
function check_sum($firstInteger, $secondInteger) {
    $sum = $firstInteger + $secondInteger;
    return ($sum == 30) ? $sum : 'false';
}

echo "Sample Input: 10, 10 <br>";
echo "Sample Output: " . check_sum(10, 10) . "<br><br>";


// 2
function is_multiple_of_3($number) {
    return ($number > 0 && $number % 3 == 0) ? 'true' : 'false';
}

echo "Sample Input: 20 <br>";
echo "Sample Output: " . is_multiple_of_3(20) . "<br><br>";


// 3
function is_in_range($number) {
    return ($number >= 20 && $number <= 50) ? 'true' : 'false';
}

echo "Sample Input: 50 <br>";
echo "Sample Output: " . is_in_range(50) . "<br><br>";


// 4
function find_largest($num1, $num2, $num3) {
    return max($num1, $num2, $num3);
}

echo "Sample Input: [1, 5, 9] <br>";
echo "Sample Output: " . find_largest(1, 5, 9) . "<br><br>";


// 5
function calculate_electricity_bill($units) {
    $bill = 0;
    if ($units <= 50) {
        $bill = $units * 2.50;
    } elseif ($units <= 150) {
        $bill = (50 * 2.50) + (($units - 50) * 5.00);
    } elseif ($units <= 250) {
        $bill = (50 * 2.50) + (100 * 5.00) + (($units - 150) * 6.20);
    } else {
        $bill = (50 * 2.50) + (100 * 5.00) + (100 * 6.20) + (($units - 250) * 7.50);
    }
    return $bill;
}

echo "Sample Input: 275 Units <br>";
echo "Sample Output: " . calculate_electricity_bill(275) . " JOD<br><br>";


// 6
function calculator($num1, $num2, $operation) {
    switch($operation) {
        case 'add':
            return $num1 + $num2;
        case 'subtract':
            return $num1 - $num2;
        case 'multiply':
            return $num1 * $num2;
        case 'divide':
            return ($num2 != 0) ? $num1 / $num2 : 'Cannot divide by zero';
        default:
            return 'Invalid operation';
    }
}

echo "Calculator Sample Input: 10, 5, 'add' <br>";
echo "Sample Output: " . calculator(10, 5, 'add') . "<br><br>";


// 7
function can_vote($age) {
    return ($age >= 18) ? 'is eligible to vote' : 'is not eligible to vote';
}

echo "Sample Input: 15 <br>";
echo "Sample Output: " . can_vote(15) . "<br><br>";


// 8
function check_sign($number) {
    if ($number > 0) {
        return 'Positive';
    } elseif ($number < 0) {
        return 'Negative';
    } else {
        return 'Zero';
    }
}

echo "Sample Input: -60 <br>";
echo "Sample Output: " . check_sign(-60) . "<br><br>";


// 9
function calculate_grade($scores) {
    $average = array_sum($scores) / count($scores);
    
    if ($average >= 90) {
        return 'A';
    } elseif ($average >= 80) {
        return 'B';
    } elseif ($average >= 70) {
        return 'C';
    } elseif ($average >= 60) {
        return 'D';
    } else {
        return 'F';
    }
}

$scores = [60, 86, 95, 63, 55, 74, 79, 62, 50];
echo "Sample Input: [60,86,95,63,55,74,79,62,50] <br>";
echo "Sample Output: " . calculate_grade($scores)."<br>";

?>
