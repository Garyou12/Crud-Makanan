<?php
session_start();


$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = ''; // isi sesuai XAMPP/WAMP
$DB_NAME = 'food_order_db';


$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
die('Database connection error: ' . $conn->connect_error);
}


function is_logged() {
return isset($_SESSION['user_id']);
}


function is_admin() {
return isset($_SESSION['role']) && $_SESSION['role']==='admin';
}