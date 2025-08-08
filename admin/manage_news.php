<?php
// manage_news.php - Part of the admin panel

// Ensure this script is not accessed directly
if (!isset($mysqli)) {
    exit('Invalid access');
}

// --- Enable error reporting for debugging ---
ini_set('display_errors', 1);
error_reporting(E_ALL);

$message = '';
$edit_mode = false;
$edit_news = ['id' => '', 'title' => '', 'content' => '', 'image_url' => ''];

// --- Handle News Deletion ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_news'])) {
    $news_id = $_POST['news_id'];
    $stmt = $mysqli->prepare("DELETE FROM news WHERE id = ?");
    $stmt->bind_param("i", $news_id);
    if ($stmt->execute()) {
        $message = "<div class='bg-green-500 text-white p-3 rounded-lg mb-4'>News article deleted.</div>";
    } else {
        $message = "<div class='bg-red-500 text-white p-3 rounded-lg mb-4'>Error deleting article.</div>";
    }
    $stmt->close();
}

// --- Handle News Submission (Add/Edit) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['add_news']) || isset($_POST['update_news']))) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $image_url = trim($_POST['image_url']);
    $author_id = $_SESSION['id'];

    if (isset($_POST['update_news'])) { // --- Update Existing News ---
        $news_id = $_POST['news_id'];
        $sql = "UPDATE news SET title = ?, content = ?, image_url = ? WHERE id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sssi", $title, $content, $image_url, $news_id);
    } else { // --- Add New News ---
        $sql = "INSERT INTO news (title, content, author_id, image_url) VALUES (?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssis", $title, $content, $author_id, $image_url);
    }

    if ($stmt->execute()) {
        $message = "<div class='bg-green-500 text-white p-3 rounded-lg mb-4'>News article saved successfully.</div>";
    } else {
        $message = "<div class='bg-red-500 text-white p-3 rounded-lg mb-4'>Error saving article.</div>";
    }
    $stmt->close();
}

// --- Handle Edit Request ---
if (isset($_GET['edit_news'])) {
    $edit_mode = true;
    $news_id = $_GET['edit_news'];
    $stmt = $mysqli->prepare("SELECT id, title, content, image_url FROM news WHERE id = ?");
    $stmt->bind_param("i", $news_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_news = $result->fetch_assoc();
    $stmt->close();
}

// Fetch all news articles
$news_result = $mysqli->query("SELECT n.id, n.title, u.username as author_name, n.created_at FROM news n JOIN users u ON n.author_id = u.id ORDER BY n.created_at DESC");
?>

<h2 class="pixel-font text-2xl font-bold text-gray-800 dark:text-white mb-4"><?php echo $edit_mode ? 'Edit' : 'Add'; ?> News Article</h2>
<?php echo $message; ?>

<!-- Add/Edit News Form -->
<form action="admin.php?page=news" method="post" class="mb-8">
    <input type="hidden" name="news_id" value="<?php echo htmlspecialchars($edit_news['id']); ?>">
    <div class="mb-4">
        <label for="title" class="block font-bold mb-1">Title:</label>
        <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($edit_news['title']); ?>" class="w-full p-2 border rounded dark:bg-gray-700" required>
    </div>
    <div class="mb-4">
        <label for="content" class="block font-bold mb-1">Content:</label>
        <textarea name="content" id="content" rows="6" class="w-full p-2 border rounded dark:bg-gray-700" required><?php echo htmlspecialchars($edit_news['content']); ?></textarea>
    </div>
    <div class="mb-4">
        <label for="image_url" class="block font-bold mb-1">Image URL:</label>
        <input type="text" name="image_url" id="image_url" value="<?php echo htmlspecialchars($edit_news['image_url']); ?>" class="w-full p-2 border rounded dark:bg-gray-700">
    </div>
    <div>
        <?php if ($edit_mode): ?>
            <button type="submit" name="update_news" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Update Article</button>
            <a href="admin.php?page=news" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel Edit</a>
        <?php else: ?>
            <button type="submit" name="add_news" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Article</button>
        <?php endif; ?>
    </div>
</form>

<hr class="my-8 dark:border-gray-600">

<!-- Existing News List -->
<h2 class="pixel-font text-2xl font-bold text-gray-800 dark:text-white mb-4">Existing Articles</h2>
<div class="overflow-x-auto">
    <table class="min-w-full bg-white dark:bg-gray-800 border">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Title</th>
                <th class="py-2 px-4 border-b">Author</th>
                <th class="py-2 px-4 border-b">Date</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($news_result && $news_result->num_rows > 0): ?>
                <?php while ($news_item = $news_result->fetch_assoc()): ?>
                    <tr>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($news_item['title']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($news_item['author_name']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo date("d M Y", strtotime($news_item['created_at'])); ?></td>
                        <td class="py-2 px-4 border-b">
                            <a href="admin.php?page=news&edit_news=<?php echo $news_item['id']; ?>" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                            <form action="admin.php?page=news" method="post" class="inline-block" onsubmit="return confirm('Delete this article?');">
                                <input type="hidden" name="news_id" value="<?php echo $news_item['id']; ?>">
                                <button type="submit" name="delete_news" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4" class="text-center py-4">No news articles found. Add one using the form above.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
