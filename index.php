<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
function checkNumber($number) {
    if ($number > 0) {
        return "The number is positive. <br>";
    } elseif ($number < 0) {
        return "The number is negative. <br>";
    } else {
        return "The number is zero. <br>";
    }
}

// Example usage
echo checkNumber(5) ;  // Output: The number is positive.
echo checkNumber(-3);  // Output: The number is negative.
echo checkNumber(0);   // Output: The number is zero.

function getDayName($dayNumber) {
    switch ($dayNumber) {
        case 1:
            return "Monday";
        case 2:
            return "Tuesday";
        case 3:
            return "Wednesday";
        case 4:
            return "Thursday";
        case 5:
            return "Friday";
        case 6:
            return "Saturday";
        case 7:
            return "Sunday";
        default:
            return "Invalid day number.";
    }
}

// Example usage
echo getDayName(3);  // Output: Wednesday
echo getDayName(8);  // Output: Invalid day number.
?>
</body>
</html>

