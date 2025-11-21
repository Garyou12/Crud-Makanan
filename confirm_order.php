<?php
include 'config.php';

if (!is_logged() || !is_admin()) {
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id'];

$conn->query("UPDATE orders SET status='dikonfirmasi' WHERE id=$id");

header("Location: admin.php");
exit;
