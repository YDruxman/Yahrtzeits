<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$servername = "localhost";
$username = "DannyC";
$password = "qwerty";
$dbname = "Yortzeit";

$conn = @mysqli_connect($servername, $username, $password, $dbname);
if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $json = file_get_contents("php://input");  //using this instead of the traditional SuperVariable POST bc we are dealing with JSON
    $data = json_decode($json, true);
    // Handle the received JSON data as needed (e.g., save it to a database)



//    { "prefix": "Daniel", "first": "Daniel", "last": "Daniel", "hebrewName": "Daniel", "notes": "Daniel",
//        "relatedTo": "Daniel", "source": "Daniel", "hebrew-dateOption": "on", "english-dateOption": "on",
//        "combo-dateOption": "on", "hebrew-hebrewDay": "22", "hebrew-hebrewYear": "", "english-date": "",
//        TODO No Name for sunset? "": "false",
//        "combo-hebrewDay": "22", "combo-date": "" }

    $prefix = $data['prefix'];
    $firstName = $data['first'];
    $lastName = $data['last'];
    $hebrewName = $data['hebrewName'];
    $notes = $data['notes'];
    $relatedTo = $data['relatedTo'];
    $source = $data['source'];
    $hebrewYear = $data['hebrewYear'];
    $hebrewMonth = $data['hebrewMonth'];
    $hebrewDay = $data['hebrewDay'];

    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, "INSERT INTO `Memorial Registry` (Prefix, FirstName, LastName, HebrewName, Notes, RelatedTo, Source, HebrewYear, HebrewMonth, HebrewDay) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssssssisi", $prefix, $firstName, $lastName, $hebrewName, $notes, $relatedTo, $source, $hebrewYear, $hebrewMonth, $hebrewDay);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    
    // In this example, we'll just return the received data as a JSON response.
    header("Content-Type: application/json"); //Shows that this is 'returning' ie that its response to the frontend will be in JSON
    echo json_encode($data);
} else {
    header("HTTP/1.0 405 Method Not Allowed");
    echo "Method Not Allowed";
}


?>