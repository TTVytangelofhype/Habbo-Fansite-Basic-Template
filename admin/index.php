<?php
// admin/index.php - Main dashboard for the staff portal.

// Initialize the session
session_start();

// Check if the user is logged in as staff, if not then redirect to login page
if (!isset($_SESSION['is_staff']) || $_SESSION['is_staff'] !== true) {
    header('Location: login.php');
    exit;
}

// We need to adjust the path to include the main site's header.
// Also add a logout button to the header for staff members.
ob_start();
include '../header.php';
$header_content = ob_get_clean();
$header_content = str_replace(
    '<a href="#" class="bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600 transition-transform transform hover:scale-105 shadow-lg">Join Discord</a>',
    '<a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded-full hover:bg-red-600 transition-transform transform hover:scale-105 shadow-lg">Logout</a>',
    $header_content
);
echo $header_content;

?>

<div class="container mx-auto px-4 py-8">
    <div class="bg-white/75 dark:bg-gray-900/75 p-6 rounded-lg shadow-lg backdrop-blur-sm">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-100 mb-6 border-b-2 border-gray-300 dark:border-gray-700 pb-3 pixel-font">Staff Portal</h1>
        
        <p class="text-lg text-gray-700 dark:text-gray-300 mb-8">
            Welcome, <strong class="text-blue-600 dark:text-blue-400"><?php echo htmlspecialchars($_SESSION['username']); ?></strong>. Your rank is: <strong class="text-green-500"><?php echo htmlspecialchars($_SESSION['rank']); ?></strong>.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Radio Admin Panel -->
            <a href="radio_admin.php" class="bg-cyan-500 hover:bg-cyan-600 text-white p-6 rounded-lg shadow-lg text-center transition-transform transform hover:-translate-y-1">
                <i class="fas fa-broadcast-tower fa-3x mb-3"></i>
                <h2 class="text-2xl font-bold pixel-font">Radio Admin</h2>
                <p>Manage DJs, timetable, and settings.</p>
            </a>

            <!-- Manage Users -->
            <a href="manage_users.php" class="bg-green-500 hover:bg-green-600 text-white p-6 rounded-lg shadow-lg text-center transition-transform transform hover:-translate-y-1">
                <i class="fas fa-users-cog fa-3x mb-3"></i>
                <h2 class="text-2xl font-bold pixel-font">Manage Users</h2>
                <p>Create, edit, or ban user accounts.</p>
            </a>

            <!-- Manage Events -->
            <a href="manage_events.php" class="bg-purple-500 hover:bg-purple-600 text-white p-6 rounded-lg shadow-lg text-center transition-transform transform hover:-translate-y-1">
                <i class="fas fa-calendar-alt fa-3x mb-3"></i>
                <h2 class="text-2xl font-bold pixel-font">Manage Events</h2>
                <p>Schedule new site events and activities.</p>
            </a>

            <!-- Forums Management -->
            <a href="../forums.php" class="bg-red-500 hover:bg-red-600 text-white p-6 rounded-lg shadow-lg text-center transition-transform transform hover:-translate-y-1">
                <i class="fas fa-comments fa-3x mb-3"></i>
                <h2 class="text-2xl font-bold pixel-font">Forums</h2>
                <p>Moderate and manage the community forums.</p>
            </a>
        </div>
    </div>
</div>

<?php
// Adjust the path for the footer as well.
include '../footer.php';
?>
