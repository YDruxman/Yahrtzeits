<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
$servername = "localhost";
$username = "DannyC";
$password = "qwerty";
$dbname = "AuthorizedUsers";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
    $hebrewYear = $data['hebrewYear']; //This needs to be adjusted so that only the right hebrew year gets checked from the diff combo options
    $hebrewDay = $data['hebrewDay'];//This needs to be adjusted so that only the right hebrew day gets checked from the diff combo options
    $englishDate = $data['englishDate'];  //This needs to be adjusted so that only the right hebrew day gets checked from the diff combo options
    $afterSunset = $data['afterSunset'];

    $stmt = $conn->prepare("INSERT INTO `Memorial Registry` (prefix, firstName, lastName, hebrewName, note, relatedTo, source, hebrewYear, hebrewDate, englishDate, afterSunset) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss",$prefix , $firstName, $lastName, $hebrewName, $notes, $relatedTo, $source, $hebrewYear, $hebrewDay, $englishDate, $afterSunset);

    $stmt->execute();
    $stmt->close();

    // In this example, we'll just return the received data as a JSON response.
    header("Content-Type: application/json"); //Shows that this is 'returning' ie that its response to the frontend will be in JSON
    echo json_encode($data);
} else {
    header("HTTP/1.0 405 Method Not Allowed");
    echo "Method Not Allowed";
}


?>