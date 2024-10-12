<?php
// 1
$str = "orange coding academy";

// a. Convert to uppercase
echo strtoupper($str) . "<br>"; // ORANGE CODING ACADEMY

// b. Convert to lowercase
echo strtolower($str) . "<br>"; // orange coding academy

// c. Make first letter uppercase
echo ucfirst($str) . "<br>"; // Orange coding academy

// d. Make first letter of each word capitalized
echo ucwords($str) . "<br>"; // Orange Coding Academy

// 2
$num_str = "085119";
$formatted_time = substr($num_str, 0, 2) . ":" . substr($num_str, 2, 2) . ":" . substr($num_str, 4, 2);
echo $formatted_time . "<br>"; // 08:51:19

// 3
$sentence = "I am a full stack developer at orange coding academy";
$word = "Orange";
if (stripos($sentence, $word) !== false) {
    echo "Word Found!<br>";
} else {
    echo "Word Not Found!<br>";
}

// 4
$url = "www.orange.com/index.php";
echo basename($url) . "<br>"; // index.php

// 5
$email = "info@orange.com";
$username = strstr($email, '@', true);
echo $username . "<br>"; // info

// 6
echo substr($email, -3) . "<br>"; // com

// 7
function generatePassword($length) {
    $chars = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $password;
}
echo generatePassword(8) . "<br>"; 
// 8
$sentence = "That new trainee is so genius.";
$new_word = "Our";
$sentence = preg_replace('/\b\w+\b/', $new_word, $sentence, 1);
echo $sentence . "<br>"; // Our new trainee is so genius.
?>
