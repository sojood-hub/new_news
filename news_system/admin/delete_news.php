<?php
require_once 'config.php';
redirectIfNotLoggedIn();

$id = $_GET['id'];
$stmt = $pdo->prepare("UPDATE news SET deleted = 1 WHERE id = ?");
$stmt->execute([$id]);
header("Location: view_news.php");
exit();
?>