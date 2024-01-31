<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "127.0.0.1";
$username = "root";
$password = '';
$dbname = "Yortzeit";
$port = 3306;

try{
    $conn = @mysqli_connect($servername, $username, $password, $dbname, $port);
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }
}
catch (Error $error){
    header("HTTP/1.0 405"); //TODO Set response to !ok?
    echo "Issue Connecting to the DataBase";
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $json = file_get_contents("php://input");  //using this instead of the traditional SuperVariable POST bc we are dealing with JSON
    $data = json_decode($json, true);
    // Handle the received JSON data as needed (e.g., save it to a database)



    $errors = [];

    // Validate each field
    $fields_to_check = [
        'prefix' => 'string',
        'first' => 'string',
        'last' => 'string',
        'hebrewName' => 'string',
        'notes' => 'string',
        'relatedTo' => 'string',
        'source' => 'string',
        'hebrewYear' => 'numeric',
        'hebrewMonth' => 'numeric',
        'hebrewDay' => 'numeric'
    ];

    foreach ($fields_to_check as $field => $type) {
        if (!isset($data[$field]) || gettype($data[$field]) !== $type) {
            $errors[$field] = "Field $field must be of type $type";
        }
    }

    if (empty($errors)) {
        // Extract values
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

        // Prepare and bind
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, "INSERT INTO `Memorial Registry` (Prefix, FirstName, LastName, HebrewName, Notes, RelatedTo, Source, HebrewYear, HebrewMonth, HebrewDay) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssssssisi", $prefix, $firstName, $lastName, $hebrewName, $notes, $relatedTo, $source, $hebrewYear, $hebrewMonth, $hebrewDay);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($conn);

        // Return JSON response
        header("Content-Type: application/json");
        echo json_encode($data);
    } else {
        // Return errors in JSON format
        header("Content-Type: application/json");
        echo json_encode(['errors' => $errors]);
    }
} else {
    header("HTTP/1.0 405 Method Not Allowed");
    echo "Method Not Allowed";
}


//    { "prefix": "Daniel", "first": "Daniel", "last": "Daniel", "hebrewName": "Daniel", "notes": "Daniel",
//        "relatedTo": "Daniel", "source": "Daniel", "hebrew-dateOption": "on", "english-dateOption": "on",
//        "combo-dateOption": "on", "hebrew-hebrewDay": "22", "hebrew-hebrewYear": "", "english-date": "",
//        TODO No Name for sunset? "": "false",
//        "combo-hebrewDay": "22", "combo-date": "" }




