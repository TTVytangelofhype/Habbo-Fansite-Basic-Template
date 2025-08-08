<?php
// admin/edit_user.php - Form to create or edit a user.

session_start();
if (!isset($_SESSION['is_staff']) || $_SESSION['is_staff'] !== true) {
    die('Access Denied');
}

include '../header.php';

// --- Placeholder Data ---
// In a real application, if an ID is provided in the URL, you would fetch
// that user's data from the database here.
$user_id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$user_data = null;
$page_title = 'Create New User';

if ($user_id) {
    $page_title = 'Edit User';
    // Example: $user_data = $pdo->prepare("SELECT * FROM staff WHERE id = ?")->execute([$user_id])->fetch();
    // For now, we'll simulate finding a user.
    if ($user_id == 2) {
        $user_data = ['id' => 2, 'username' => 'PixelMaster', 'email' => 'pixel@retrovortex.com', 'rank' => 'Moderator'];
    }
}
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white/75 dark:bg-gray-900/75 p-6 rounded-lg shadow-lg backdrop-blur-sm">
        <div class="flex items-center mb-6 border-b-2 border-gray-300 dark:border-gray-700 pb-3">
            <a href="manage_users.php" class="text-blue-500 hover:text-blue-700 mr-4"><i class="fas fa-arrow-left fa-lg"></i></a>
            <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-100 pixel-font"><?php echo $page_title; ?></h1>
        </div>

        <form action="#" method="post">
            <!-- Hidden field for user ID when editing -->
            <?php if ($user_id): ?>
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
            <?php endif; ?>

            <div class="mb-4">
                <label for="username" class="block text-gray-700 dark:text-gray-200 font-bold mb-2">Username</label>
                <input type="text" name="username" id="username" class="w-full px-3 py-2 rounded-lg bg-gray-200 dark:bg-gray-800 border" value="<?php echo htmlspecialchars($user_data['username'] ?? ''); ?>" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 dark:text-gray-200 font-bold mb-2">Email Address</label>
                <input type="email" name="email" id="email" class="w-full px-3 py-2 rounded-lg bg-gray-200 dark:bg-gray-800 border" value="<?php echo htmlspecialchars($user_data['email'] ?? ''); ?>" required>
            </div>

            <div class="mb-4">
                <label for="rank" class="block text-gray-700 dark:text-gray-200 font-bold mb-2">Rank</label>
                <select name="rank" id="rank" class="w-full px-3 py-2 rounded-lg bg-gray-200 dark:bg-gray-800 border">
                    <option value="Staff" <?php echo (($user_data['rank'] ?? '') == 'Staff') ? 'selected' : ''; ?>>Staff</option>
                    <option value="Moderator" <?php echo (($user_data['rank'] ?? '') == 'Moderator') ? 'selected' : ''; ?>>Moderator</option>
                    <option value="Administrator" <?php echo (($user_data['rank'] ?? '') == 'Administrator') ? 'selected' : ''; ?>>Administrator</option>
                </select>
            </div>
            
            <div class="mb-6 border-t border-gray-300 dark:border-gray-700 pt-6 mt-6">
                 <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                    <?php echo $user_id ? 'Leave password fields blank to keep the current password.' : 'Set a password for the new user.'; ?>
                </p>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 dark:text-gray-200 font-bold mb-2">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-3 py-2 rounded-lg bg-gray-200 dark:bg-gray-800 border">
                </div>
                 <div>
                    <label for="password_confirm" class="block text-gray-700 dark:text-gray-200 font-bold mb-2">Confirm Password</label>
                    <input type="password" name="password_confirm" id="password_confirm" class="w-full px-3 py-2 rounded-lg bg-gray-200 dark:bg-gray-800 border">
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg shadow-lg">
                    <i class="fas fa-save"></i> Save User
                </button>
            </div>
        </form>
    </div>
</div>

<?php
include '../footer.php';
?>
