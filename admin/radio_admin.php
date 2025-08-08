<?php
// admin/radio_admin.php - Main dashboard for the Radio Admin Panel.

session_start();
if (!isset($_SESSION['is_staff']) || $_SESSION['is_staff'] !== true) {
    header('Location: login.php');
    exit;
}

// We need to adjust the path to include the main site's header.
include '../header.php';
?>

<div class="container mx-auto px-4 py-8">
    <div class="bg-white/75 dark:bg-gray-900/75 p-6 rounded-lg shadow-lg backdrop-blur-sm">
        <div class="flex items-center mb-6 border-b-2 border-gray-300 dark:border-gray-700 pb-3">
            <a href="index.php" class="text-blue-500 hover:text-blue-700 mr-4"><i class="fas fa-arrow-left fa-lg"></i></a>
            <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-100 pixel-font">Radio Admin Panel</h1>
        </div>
        
        <p class="text-lg text-gray-700 dark:text-gray-300 mb-8">
            Manage all aspects of Vortex Radio from this dashboard.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Manage Timetable -->
            <a href="manage_timetable.php" class="bg-teal-500 hover:bg-teal-600 text-white p-6 rounded-lg shadow-lg text-center transition-transform transform hover:-translate-y-1">
                <i class="fas fa-calendar-week fa-3x mb-3"></i>
                <h2 class="text-2xl font-bold pixel-font">Timetable</h2>
                <p>Set up and edit the DJ schedule.</p>
            </a>

            <!-- Manage DJs -->
            <a href="manage_djs.php" class="bg-orange-500 hover:bg-orange-600 text-white p-6 rounded-lg shadow-lg text-center transition-transform transform hover:-translate-y-1">
                <i class="fas fa-headphones-alt fa-3x mb-3"></i>
                <h2 class="text-2xl font-bold pixel-font">Manage DJs</h2>
                <p>Add, edit, or remove radio DJs.</p>
            </a>

            <!-- Radio Settings -->
            <a href="radio_settings.php" class="bg-indigo-500 hover:bg-indigo-600 text-white p-6 rounded-lg shadow-lg text-center transition-transform transform hover:-translate-y-1">
                <i class="fas fa-cogs fa-3x mb-3"></i>
                <h2 class="text-2xl font-bold pixel-font">Settings</h2>
                <p>Update stream URL and API links.</p>
            </a>
        </div>
    </div>
</div>

<?php
// Adjust the path for the footer as well.
include '../footer.php';
?>
