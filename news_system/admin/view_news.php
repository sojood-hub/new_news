<?php
require_once 'config.php';
redirectIfNotLoggedIn();

$stmt = $pdo->prepare("
    SELECT news.*, categories.name as category_name 
    FROM news 
    JOIN categories ON news.category_id = categories.id
    WHERE news.deleted = 0
    ORDER BY news.id DESC
");
$stmt->execute();
$news = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>عرض الأخبار</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 جميع الأخبار</h1>
        </div>
        
        <div class="navbar">
            <a href="dashboard.php">🏠 الرئيسية</a>
            <a href="add_news.php">➕ إضافة خبر جديد</a>
        </div>
        
        <div class="content">
            <?php if(count($news) == 0): ?>
                <div class="alert alert-info">لا توجد أخبار</div>
            <?php else: ?>
                 <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>العنوان</th>
                            <th>الفئة</th>
                            <th>الصورة</th>
                            <th>تاريخ الإضافة</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($news as $item): ?>
                        <tr>
                            <td><?php echo $item['id']; ?></td>
                            <td><?php echo htmlspecialchars($item['title']); ?></td>
                            <td><?php echo htmlspecialchars($item['category_name']); ?></td>
                            <td>
                                <?php if($item['image']): ?>
                                    <img src="assets/uploads/<?php echo htmlspecialchars($item['image']); ?>" width="50" height="50" style="object-fit:cover;">
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td><?php echo date('Y-m-d', strtotime($item['created_at'])); ?></td>
                            <td class="actions">
                                <a href="edit_news.php?id=<?php echo $item['id']; ?>" style="color:#3498db;">✏️ تعديل</a>
                                <a href="delete_news.php?id=<?php echo $item['id']; ?>" onclick="return confirm('هل أنت متأكد من حذف هذا الخبر؟')" style="color:#e74c3c;">🗑️ حذف</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>