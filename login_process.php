<?php
include 'config.php';


if ($_SERVER['REQUEST_METHOD']==='POST') {
$username = $conn->real_escape_string($_POST['username']);
$password = $conn->real_escape_string($_POST['password']);


$q = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
$res = $conn->query($q);
if ($res && $res->num_rows==1) {
$row = $res->fetch_assoc();
$_SESSION['user_id'] = $row['id'];
$_SESSION['username'] = $row['username'];
$_SESSION['role'] = $row['role'];
$_SESSION['nama_user'] = $row['nama_user'];


if ($row['role']=='admin') header('Location: admin.php');
else header('Location: customer.php');
exit;
} else {
echo 'Login gagal. <a href="index.php">Kembali</a>';
}
}