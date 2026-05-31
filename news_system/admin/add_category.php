<?php
require_once 'config.php';
redirectIfNotLoggedIn();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->execute([$name]);
    header("Location: view_categories.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Category</title>
</head>
<body>
    <h2>إضافة فئة</h2>
    <form method="POST">
        اسم الفئة: <input type="text" name="name" required><br><br>
        <button type="submit">حفظ</button>
    </form>
    <a href="dashboard.php">الرجوع للرئيسية</a>
</body>
</html>