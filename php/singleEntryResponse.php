<?php
session_start();


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    // Handle the received JSON data as needed (e.g., save it to a database)
    // In this example, we'll just return the received data as a JSON response.
    header("Content-Type: application/json");
    echo json_encode($data);
} else {
    header("HTTP/1.0 405 Method Not Allowed");
    echo "Method Not Allowed";
}


?>