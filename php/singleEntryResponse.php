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
    http_response_code(500);
    return;
}
date_default_timezone_set('America/New_York'); // Set the desired timezone
$year = date("Y");
$month = date("m");
$day = date("d");

// Initialize cURL session
$curl = curl_init();

// get Hebrew Year from API
curl_setopt($curl, CURLOPT_URL, "https://www.hebcal.com/converter?cfg=json&gy=$year&gm=$month&gd=$day&g2h=1&strict=1");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HEADER, 0);
$response = curl_exec($curl);

// Check for errors in cURL execution
if (curl_errno($curl)) {
    echo 'Error:' . curl_error($curl);
} else {

    $HebrewDateFromAPI = json_decode($response, true);

    // Use the data as needed
    // For example, print the Hebrew date
    $CurrentHebrewYear = $HebrewDateFromAPI['hy'];
    echo $CurrentHebrewYear;
}

// Close cURL session
curl_close($curl);


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $json = file_get_contents("php://input");  //using this instead of the traditional SuperVariable POST bc we are dealing with JSON
    $data = json_decode($json, true);


    $errors = [];

    // Validate each field
    $patterns = [
        'first' => '/^[a-zA-Z ]+$/',
        'last' => '/^[a-zA-Z ]+$/',
        'hebrewName' => '/[a-zA-Z. ]{1,100}$/',
        'notes' => ' /^([a-zA-Z.\'\- ]{1,100}|)$/',
        'relatedTo' => '/^([a-zA-Z.\'\- ]{1,100}|)$/',
        'source' => '/^[a-zA-Z.\'\-]{1,100}$/',
        'hebrewYear' => '^\d{4}$',
        'hebrewMonth' => '^(Nissan|Iyar|Sivan|Tamuz|Av|Elul|Tishrei|Cheshvan|Kisleiv|Tevet|Shevat|Adar|AdarII)$',
        'hebrewDay' => '/^(0[1-9]|[1-2][0-9]|3[0-1])$/'
    ];

    foreach ($patterns as $field => $type) {
        if (!isset($data[$field]) || gettype($data[$field]) !== $type ) {
            $errors[$field] = "Field $field must be of type $type";
        }
    }
    if(!empty($CurrentHebrewYear)){
        if ($data['hebrewYear'] <= $CurrentHebrewYear){
            $errors['hebrewYearPastCurrentYear'] = "The Hebrew year must be before $CurrentHebrewYear which is the current Hebrew Year";
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
//        "combo-hebrewDay": "22", "combo-date": "" }




