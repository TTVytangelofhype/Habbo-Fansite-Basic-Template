<?php
// manage_rares.php - Part of the admin panel

// Ensure this script is not accessed directly
if (!isset($mysqli)) {
    exit('Invalid access');
}

$message = '';

// --- Handle Rare Deletion ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_rare'])) {
    $rare_id = $_POST['rare_id'];
    $stmt = $mysqli->prepare("DELETE FROM rares WHERE id = ?");
    $stmt->bind_param("i", $rare_id);
    $stmt->execute();
    $stmt->close();
    $message = "<div class='bg-green-500 text-white p-3 rounded-lg mb-4'>Rare deleted.</div>";
}

// --- Handle Rare Submission ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_rare'])) {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $image_url = trim($_POST['image_url']);
    $value_category = trim($_POST['value_category']);
    $release_date = trim($_POST['release_date']);
    $added_by = $_SESSION['id'];

    $sql = "INSERT INTO rares (name, description, image_url, value_category, release_date, added_by) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssssi", $name, $description, $image_url, $value_category, $release_date, $added_by);
    if ($stmt->execute()) {
        $message = "<div class='bg-green-500 text-white p-3 rounded-lg mb-4'>Rare added successfully.</div>";
    } else {
        $message = "<div class='bg-red-500 text-white p-3 rounded-lg mb-4'>Error adding rare.</div>";
    }
    $stmt->close();
}

// Fetch existing rares
$rares_result = $mysqli->query("SELECT r.id, r.name, r.value_category, u.username as added_by_name FROM rares r JOIN users u ON r.added_by = u.id ORDER BY r.id DESC");
?>

<h2 class="pixel-font text-2xl font-bold text-gray-800 dark:text-white mb-4">Add Rare Guide</h2>
<?php echo $message; ?>

<form action="admin.php?page=rares" method="post" class="mb-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
            <label for="name" class="block font-bold mb-1">Rare Name:</label>
            <input type="text" name="name" id="name" class="w-full p-2 border rounded dark:bg-gray-700" required>
        </div>
        <div>
            <label for="image_url" class="block font-bold mb-1">Image URL:</label>
            <input type="text" name="image_url" id="image_url" class="w-full p-2 border rounded dark:bg-gray-700" required>
        </div>
        <div>
            <label for="value_category" class="block font-bold mb-1">Value Category:</label>
            <input type="text" name="value_category" id="value_category" placeholder="e.g., Super Rare, LTD" class="w-full p-2 border rounded dark:bg-gray-700" required>
        </div>
        <div>
            <label for="release_date" class="block font-bold mb-1">Release Date:</label>
            <input type="date" name="release_date" id="release_date" class="w-full p-2 border rounded dark:bg-gray-700">
        </div>
    </div>
    <div class="mb-4">
        <label for="description" class="block font-bold mb-1">Description:</label>
        <textarea name="description" id="description" rows="4" class="w-full p-2 border rounded dark:bg-gray-700" required></textarea>
    </div>
    <div>
        <button type="submit" name="add_rare" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Rare</button>
    </div>
</form>

<hr class="my-8 dark:border-gray-600">

<h2 class="pixel-font text-2xl font-bold text-gray-800 dark:text-white mb-4">Manage Existing Rares</h2>
<div class="overflow-x-auto">
    <table class="min-w-full bg-white dark:bg-gray-800 border">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Name</th>
                <th class="py-2 px-4 border-b">Value</th>
                <th class="py-2 px-4 border-b">Added By</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($rare = $rares_result->fetch_assoc()): ?>
                <tr>
                    <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($rare['name']); ?></td>
                    <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($rare['value_category']); ?></td>
                    <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($rare['added_by_name']); ?></td>
                    <td class="py-2 px-4 border-b">
                        <form action="admin.php?page=rares" method="post" onsubmit="return confirm('Delete this rare?');">
                            <input type="hidden" name="rare_id" value="<?php echo $rare['id']; ?>">
                            <button type="submit" name="delete_rare" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
