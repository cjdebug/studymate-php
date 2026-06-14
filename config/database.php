<?php

// Database connection 

//set database host // when deploying to Railway, using DB_HOST.
$host = getenv('DB_HOST') ?: getenv('MYSQLHOST') ?: 'localhost';
//set database port
$port = getenv('DB_PORT') ?: getenv('MYSQLPORT') ?: '3306';
$dbname = getenv('DB_NAME') ?: getenv('MYSQLDATABASE') ?: 'studymate';
$username = getenv('DB_USER') ?: getenv('MYSQLUSER') ?: 'root';
$password = getenv('DB_PASSWORD') ?: getenv('MYSQLPASSWORD') ?: '';

// Data Source Name
$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,       // Show database errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // Return data as associative arrays
    PDO::ATTR_EMULATE_PREPARES => false                // Use real prepared statements
];

try {
    //creates database connection
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}