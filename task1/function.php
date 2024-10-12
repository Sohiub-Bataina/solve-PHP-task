<?php
// 1
function is_prime($number) {
    if ($number <= 1) {
        return false;
    }
    for ($i = 2; $i <= sqrt($number); $i++) {
        if ($number % $i == 0) {
            return false;
        }
    }
    return true;
}

$number = 3;
if (is_prime($number)) {
    echo "$number is a prime number<br>";
} else {
    echo "$number is not a prime number<br>";
}

echo "<br>";

// 2
function reverse_string($str) {
    return strrev($str);
}

$string = "remove";
echo "Original string: $string<br>";
echo "Reversed string: " . reverse_string($string) . "<br>";

echo "<br>";

// 3
function swap_variables(&$x, &$y) {
    $temp = $x;
    $x = $y;
    $y = $temp;
}

$x = 12;
$y = 10;
swap_variables($x, $y);
echo "After swap: x = $x, y = $y<br>";

echo "<br>";

// 4
function is_armstrong($number) {
    $sum = 0;
    $temp = $number;
    while ($temp != 0) {
        $digit = $temp % 10;
        $sum += $digit * $digit * $digit;
        $temp = (int)($temp / 10);
    }
    return $sum == $number;
}

$armstrong_number = 407;
if (is_armstrong($armstrong_number)) {
    echo "$armstrong_number is an Armstrong number<br>";
} else {
    echo "$armstrong_number is not an Armstrong number<br>";
}

echo "<br>";

// 5
function is_palindrome($str) {
    $str = preg_replace("/[^A-Za-z0-9]/", '', strtolower($str)); 
    return $str == strrev($str);
}

$palindrome_string = "Eva, can I see bees in a cave?";
if (is_palindrome($palindrome_string)) {
    echo "Yes, it is a palindrome<br>";
} else {
    echo "No, it is not a palindrome<br>";
}

echo "<br>";

// 6
function remove_duplicates($array) {
    return array_unique($array);
}

$array1 = array(2, 4, 7, 4, 8, 4);
$array_no_duplicates = remove_duplicates($array1);

echo "Array after removing duplicates:<br>";
print_r($array_no_duplicates);

?>
