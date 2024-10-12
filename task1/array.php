<?php
// 1
$colors = array('white', 'green', 'red');
echo "<ul>";
foreach ($colors as $color) {
    echo "<li>$color</li>";
}
echo "</ul>";

echo "<br>";

// 2
$cities = array( 
    "Italy" => "Rome", "Luxembourg" => "Luxembourg", "Belgium" => "Brussels", 
    "Denmark" => "Copenhagen", "Finland" => "Helsinki", "France" => "Paris", 
    "Slovakia" => "Bratislava", "Slovenia" => "Ljubljana", "Germany" => "Berlin", 
    "Greece" => "Athens", "Ireland" => "Dublin", "Netherlands" => "Amsterdam", 
    "Portugal" => "Lisbon", "Spain" => "Madrid"
);

asort($cities);

foreach ($cities as $country => $capital) {
    echo "The capital of $country is $capital.<br>";
}

echo "<br>";

// 3
$color = array(4 => 'white', 6 => 'green', 11 => 'red');
echo "The first element of the array is: " . reset($color) . "<br>";

echo "<br>";

// 4
$array = array(1, 2, 3, 4, 5);
$position = 4;
$new_item = '$';

array_splice($array, $position - 1, 0, $new_item);

echo "The new array is: ";
foreach ($array as $item) {
    echo $item." ";
}
echo "<br><br>";
// 5
$fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");
ksort($fruits); 

echo "Sorted by key:<br>";
foreach ($fruits as $key => $value) {
    echo "$key = $value<br>";
}

echo "<br>";

// 6
$temperatures = array(78, 60, 62, 68, 71, 68, 73, 85, 66, 64, 76, 63, 75, 76, 73, 68, 62, 73, 72, 65, 74, 62, 62, 65, 64, 68, 73, 75, 79, 73);

$average_temp = array_sum($temperatures) / count($temperatures);
echo "Average Temperature is: " . round($average_temp, 1) . "<br>";

sort($temperatures); 
$lowest_temps = array_slice($temperatures, 0, 5); 
$highest_temps = array_slice($temperatures, -5); 

echo "List of five lowest temperatures: " . implode(", ", $lowest_temps) . "<br>";
echo "List of five highest temperatures: " . implode(", ", $highest_temps) . "<br>";

echo "<br>";

// 7
$array1 = array("color" => "red", 2, 4);
$array2 = array("a", "b", "color" => "green", "shape" => "trapezoid", 4);

$merged_array = array_merge($array1, $array2); 

echo "Merged array:<br>";
print_r($merged_array);

echo "<br><br>";

// 8
$colors = array("red", "blue", "white", "yellow");

$upper_colors = array_map('strtoupper', $colors); 

echo "Colors in uppercase:<br>";
print_r($upper_colors);


?>
