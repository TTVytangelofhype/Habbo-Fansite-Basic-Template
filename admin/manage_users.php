<?php
// manage_users.php - Part of the admin panel

// Ensure this script is not accessed directly and that the mysqli connection exists
if (!isset($mysqli)) {
    exit('Invalid access');
}

// --- Enable error reporting for debugging ---
ini_set('display_errors', 1);
error_reporting(E_ALL);

$message = '';
$current_admin_rank = $_SESSION['rank_id'] ?? 0;

// --- Handle User Deletion ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_user'])) {
    $user_id_to_delete = $_POST['user_id'];
    if ($user_id_to_delete != $_SESSION['id']) {
        $stmt = $mysqli->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id_to_delete);
        if ($stmt->execute()) {
            $message = "<div class='bg-green-500 text-white p-3 rounded-lg mb-4'>User deleted successfully.</div>";
        } else {
            $message = "<div class='bg-red-500 text-white p-3 rounded-lg mb-4'>Error deleting user.</div>";
        }
        $stmt->close();
    } else {
        $message = "<div class='bg-yellow-500 text-black p-3 rounded-lg mb-4'>You cannot delete your own account.</div>";
    }
}

// --- Handle Rank Update ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_rank'])) {
    $user_id_to_update = $_POST['user_id'];
    $new_rank_id = $_POST['rank_id'];

    if ($new_rank_id > $current_admin_rank) {
         $message = "<div class='bg-red-500 text-white p-3 rounded-lg mb-4'>You cannot promote a user to a rank higher than your own.</div>";
    } else {
        $stmt = $mysqli->prepare("UPDATE users SET rank_id = ? WHERE id = ?");
        $stmt->bind_param("ii", $new_rank_id, $user_id_to_update);
        if ($stmt->execute()) {
            $message = "<div class='bg-green-500 text-white p-3 rounded-lg mb-4'>User rank updated successfully.</div>";
        } else {
            $message = "<div class='bg-red-500 text-white p-3 rounded-lg mb-4'>Error updating rank.</div>";
        }
        $stmt->close();
    }
}


// --- FIX: Added error checking for the database query ---
$users_result = $mysqli->query("SELECT u.id, u.username, u.email, u.created_at, r.name as rank_name, u.rank_id FROM users u LEFT JOIN ranks r ON u.rank_id = r.id ORDER BY u.id");
if (!$users_result) {
    echo "<div class='bg-red-500 text-white p-3 rounded-lg mb-4'>Database Error: " . $mysqli->error . "</div>";
}

$ranks_result = $mysqli->query("SELECT id, name FROM ranks ORDER BY id");
$ranks = $ranks_result->fetch_all(MYSQLI_ASSOC);
?>

<h2 class="pixel-font text-2xl font-bold text-gray-800 dark:text-white mb-4">Manage Users</h2>
<?php echo $message; ?>

<div class="overflow-x-auto">
    <table class="min-w-full bg-white dark:bg-gray-800 border">
        <thead class="bg-gray-200 dark:bg-gray-700">
            <tr>
                <th class="py-2 px-4 border-b">Username</th>
                <th class="py-2 px-4 border-b">Email</th>
                <th class="py-2 px-4 border-b">Rank</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($users_result && $users_result->num_rows > 0): ?>
                <?php while ($user = $users_result->fetch_assoc()): ?>
                    <tr class="text-center">
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($user['username']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($user['email']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($user['rank_name'] ?? 'Unknown Rank'); ?></td>
                        <td class="py-2 px-4 border-b">
                            <form action="admin.php?page=users" method="post" class="inline-block">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <select name="rank_id" class="p-1 rounded dark:bg-gray-600">
                                    <?php foreach ($ranks as $rank): ?>
                                        <?php if ($rank['id'] <= $current_admin_rank): ?>
                                            <option value="<?php echo $rank['id']; ?>" <?php if ($rank['id'] == $user['rank_id']) echo 'selected'; ?>>
                                                <?php echo htmlspecialchars($rank['name']); ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" name="update_rank" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Save</button>
                            </form>
                            <?php if ($user['id'] != $_SESSION['id']): ?>
                            <form action="admin.php?page=users" method="post" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <button type="submit" name="delete_user" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center py-4">No users found in the database.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
