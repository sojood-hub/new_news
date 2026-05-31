<?php
require_once 'config.php';
redirectIfNotLoggedIn();

// جلب كل الأخبار (غير المحذوفة)
$stmt = $pdo->prepare("
    SELECT news.*, categories.name as category_name, users.name as user_name 
    FROM news 
    JOIN categories ON news.category_id = categories.id
    JOIN users ON news.user_id = users.id
    WHERE news.deleted = 0 
    ORDER BY news.created_at DESC
");
$stmt->execute();
$newsList = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - نظام الأخبار</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📰 نظام إدارة الأخبار</h1>
            <p>مرحباً <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
        </div>
        
        <div class="navbar">
            <a href="add_category.php">➕ إضافة فئة</a>
            <a href="view_categories.php">📂 عرض الفئات</a>
            <a href="add_news.php">📰 إضافة خبر</a>
            <a href="view_news.php">📋 عرض جميع الأخبار</a>
            <a href="deleted_news.php">🗑️ الأخبار المحذوفة</a>
            <a href="logout.php" style="background:#e74c3c;">🚪 تسجيل خروج</a>
        </div>
        
        <div class="content">
            <h2>📰 آخر الأخبار</h2>
            
            <?php if(count($newsList) == 0): ?>
                <div class="alert alert-info">لا توجد أخبار حالياً. قم بإضافة خبر جديد!</div>
            <?php else: ?>
                <div class="news-grid">
                    <?php foreach($newsList as $news): ?>
                        <div class="news-card">
                            <?php if($news['image']): ?>
                                <img src="assets/uploads/<?php echo htmlspecialchars($news['image']); ?>" alt="<?php echo htmlspecialchars($news['title']); ?>">
                            <?php else: ?>
                                <img src="assets/uploads/no-image.jpg" alt="No Image">
                            <?php endif; ?>
                            <div class="news-card-content">
                                <h3><?php echo htmlspecialchars($news['title']); ?></h3>
                                <div class="category">📁 <?php echo htmlspecialchars($news['category_name']); ?></div>
                                <div class="details">
                                    <?php echo nl2br(htmlspecialchars(substr($news['details'], 0, 150))); ?>...
                                </div>
                                <div class="author">✍️ بواسطة: <?php echo htmlspecialchars($news['user_name']); ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>