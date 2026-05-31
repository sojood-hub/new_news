<?php
require_once 'config.php';
redirectIfNotLoggedIn();

$stmt = $pdo->query("SELECT * FROM categories ORDER BY id DESC");
$categories = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Categories</title>
</head>
<body>
    <h2>جميع الفئات</h2>
    <table border ="1" cellpadding="10">
        <tr><th>ID</th><th>Name</th></tr>
        <?php foreach($categories as $cat): ?>
        <tr>
            <td><?php echo $cat['id']; ?></td>
            <td><?php echo htmlspecialchars($cat['name']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="dashboard.php">الرجوع</a>
</body>
</html>