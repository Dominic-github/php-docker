<?php
//These are the defined authentication environment in the db service

// The MySQL service named in the docker-compose.yml.
$host = 'db';

// Database use name
$user = 'root';

//database user password
$pass = '123456';

// database name
$dbname = 'login';

$cookie_name = 'siteAuth';
$cookie_time = (3600 * 24 * 30); // 30 days
    


// check the MySQL connection status
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>