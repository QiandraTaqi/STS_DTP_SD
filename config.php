<?php

$dbhost = "localhost";
$dbname = "db_laporan_fasilitas";
$dbuser = "root";
$dbpass = "";


try {
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


// $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// } else {
//     echo "Connected successfully";
// }

?>