<?php include 'config.php'; if(!is_logged()||!is_admin()) header('Location:index.php');
$id=(int)$_GET['id'];
$conn->query("DELETE FROM products WHERE id=$id");
header('Location: admin.php'); exit;