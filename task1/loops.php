<?php
// 1
echo "1. Numbers from 1 to 10 with dashes:<br>";
for($i = 1; $i <= 10; $i++) {
    if($i < 10) {
        echo $i . "-";
    } else {
        echo $i;
    }
}
echo "<br><br>";

// 2
echo "2. Total sum from 0 to 30:<br>";
$total = 0;
for($i = 0; $i <= 30; $i++) {
    $total += $i;
}
echo "Total: " . $total;
echo "<br><br>";

// 3
echo "3. Letter pattern:<br>";
for ($i = 1; $i <= 5; $i++) {
    for ($j = 5; $j > $i; $j--) {
        echo "A";
    }
    for ($k = 1; $k <= $i; $k++) {
        echo chr(64 + $i);
    }
    echo"<br>";
}
echo "<br>";
// 4
echo "4. Numeric pattern:<br>";
for ($i = 1; $i <= 5; $i++) {
    for ($j = 5; $j > $i; $j--) {
        echo "1";
    }
    for ($k = 1; $k <= $i; $k++) {
        echo $i;
    }
    echo"<br>";
}
  echo"<br>";

// 5
echo "5. Diagonal pattern:<br>";
for($i = 0; $i < 5; $i++) {
    for($j = 0; $j < 5; $j++) {
        if($i==4){
            echo "&nbsp;";
        }
        if($i == $j) {
            echo $i + 1;
        } else {
            echo "0";
        }
    }
    echo "<br>";
}
echo "<br>";

// 6
echo "6. Factorial of 5:<br>";
$number = 5;
$factorial = 1;
for($i = 1; $i <= $number; $i++) {
    $factorial *= $i;
}
echo "Factorial of $number is: " . $factorial;
echo "<br><br>";

// 7
echo "7. Multiplication table:<br>";
echo "<table border='1' cellpadding='3px' cellspacing='0px'>";
for($i = 1; $i <= 6; $i++) {
    echo "<tr>";
    for($j = 1; $j <= 5; $j++) {
        echo "<td>$i * $j = " . ($i * $j) . "</td>";
    }
    echo "</tr>";
}
echo"</table>";
?>
