<?php
require_once 'config.php';
redirectIfNotLoggedIn();

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $details = $_POST['details'];
    $user_id = $_SESSION['user_id'];
    
    // رفع الصورة
    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], 'assets/uploads/' . $imageName);
    }
    
    $stmt = $pdo->prepare("INSERT INTO news (title, category_id, details, image, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$title, $category_id, $details, $imageName, $user_id]);
    header("Location: view_news.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add News</title>
</head>
<body>
    <h2>إضافة خبر</h2>
    <form method="POST" enctype="multipart/form-data">
        عنوان الخبر: <input type="text" name="title" required><br><br>
        الفئة: 
        <select name="category_id" required>
            <?php foreach($categories as $cat): ?>
                <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
            <?php endforeach; ?>
        </select><br><br>
        تفاصيل الخبر:<br>
        <textarea name="details" rows="5" cols="40" required></textarea><br><br>
        صورة الخبر: <input type="file" name="image"><br><br>
        <button type="submit">حفظ الخبر</button>
    </form>
</body>
</html>