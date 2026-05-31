<?php
require_once 'config.php';
redirectIfNotLoggedIn();

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
$stmt->execute([$id]);
$news = $stmt->fetch();

if (!$news) die("خبر غير موجود");

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $details = $_POST['details'];
    
    $imageName = $news['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], 'assets/uploads/' . $imageName);
    }
    
    $stmt = $pdo->prepare("UPDATE news SET title=?, category_id=?, details=?, image=? WHERE id=?");
    $stmt->execute([$title, $category_id, $details, $imageName, $id]);
    header("Location: view_news.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit News</title>
</head>
<body>
    <h2>تعديل خبر</h2>
    <form method="POST" enctype="multipart/form-data">
        عنوان الخبر: <input type="text" name="title" value="<?php echo htmlspecialchars($news['title']); ?>" required><br><br>
        الفئة:
        <select name="category_id">
            <?php foreach($categories as $cat): ?>
                <option value="<?php echo $cat['id']; ?>" <?php echo $cat['id']==$news['category_id']?'selected':''; ?>><?php echo $cat['name']; ?></option>
            <?php endforeach; ?>
        </select><br><br>
        تفاصيل الخبر:<br>
        <textarea name="details" rows="5" cols="40"><?php echo htmlspecialchars($news['details']); ?></textarea><br><br>
        الصورة الحالية: 
        <?php if($news['image']): ?>
            <img src="assets/uploads/<?php echo $news['image']; ?>" width="100"><br>
        <?php endif; ?>
        تغيير الصورة: <input type="file" name="image"><br><br>
        <button type="submit">تحديث</button>
    </form>
</body>
</html>