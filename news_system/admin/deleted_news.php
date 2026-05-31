<?php
require_once 'config.php';
redirectIfNotLoggedIn();

$stmt = $pdo->prepare("
    SELECT news.*, categories.name as category_name 
    FROM news 
    JOIN categories ON news.category_id = categories.id
    WHERE news.deleted = 1
");
$stmt->execute();
$news = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Deleted News</title>
</head>
<body>
    <h2>الأخبار المحذوفة</h2>
    <table border="1">
        <tr><th>Title</th><th>Category</th></tr>
        <?php foreach($news as $item): ?>
        <tr>
            <td><?php echo htmlspecialchars($item['title']); ?></td>
            <td><?php echo $item['category_name']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>