<?php
// admin.php - Main hub for all administrative tasks
define('ROOT_PATH', __DIR__ . '/');
require_once ROOT_PATH . 'config.php';

// Security Check
if (!isset($_SESSION['loggedin']) || !isset($_SESSION['rank_id']) || $_SESSION['rank_id'] < 4) {
    header('Location: login.php');
    exit;
}
$page = $_GET['page'] ?? 'users';
include ROOT_PATH . 'header.php';
?>
<main class="container mx-auto px-4 py-8">
    <h1 class="pixel-font text-4xl font-bold text-gray-800 dark:text-white mb-6">Admin Panel</h1>
    <div class="mb-6">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="-mb-px flex flex-wrap space-x-8" aria-label="Tabs">
                <a href="admin.php?page=users" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm <?php echo ($page === 'users') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?>">Manage Users</a>
                <a href="admin.php?page=news" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm <?php echo ($page === 'news') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?>">Manage News</a>
                <?php if ($_SESSION['rank_id'] >= 11): // --- FIX: Only show Jobs tab to rank 11+ --- ?>
                <a href="admin.php?page=jobs" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm <?php echo ($page === 'jobs') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?>">Manage Jobs</a>
                <?php endif; ?>
                <a href="admin.php?page=events" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm <?php echo ($page === 'events') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?>">Manage Events</a>
                <a href="admin.php?page=timetable" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm <?php echo ($page === 'timetable') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?>">Manage DJ Timetable</a>
                <a href="admin.php?page=rares" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm <?php echo ($page === 'rares') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?>">Manage Rares</a>
                <a href="admin.php?page=radio" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm <?php echo ($page === 'radio') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'; ?>">Manage Radio</a>
            </nav>
        </div>
    </div>
    <div class="bg-white/75 dark:bg-gray-800/75 p-6 rounded-lg shadow-lg backdrop-blur-sm">
        <?php
        $include_file = ROOT_PATH . 'admin/manage_' . $page . '.php';
        if (file_exists($include_file)) {
            // --- FIX: Security check for jobs page ---
            if ($page === 'jobs' && $_SESSION['rank_id'] < 11) {
                echo "<p class='text-red-500'>You do not have permission to view this page.</p>";
            } else {
                include $include_file;
            }
        } else {
            include ROOT_PATH . 'admin/manage_users.php';
        }
        ?>
    </div>
</main>
<?php include ROOT_PATH . 'footer.php'; ?>
