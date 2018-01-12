<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Create database
$sql = "CREATE DATABASE eamonngaynor";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

$dbname = "eamonngaynor";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// sql to create table
$sql = "CREATE TABLE user (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
username VARCHAR(100) NOT NULL COLLATE 'latin1_general_cs',
email VARCHAR(100) NOT NULL,
logins INT(50),
lockout DATETIME,
hashedPassword VARCHAR (200)
)";

if ($conn->query($sql) === TRUE) {
    echo "<script type='text/javascript'>alert('Table successfully created')</script>";
	echo "<script language='javascript' type='text/javascript'> location.href='login.php' </script>";	
} else {
    echo "Error creating table: " . $conn->error;
}


$conn->close();
?>