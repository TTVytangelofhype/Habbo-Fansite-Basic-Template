<?php
// admin/manage_djs.php

session_start();
if (!isset($_SESSION['is_staff']) || $_SESSION['is_staff'] !== true) {
    die('Access Denied');
}

include '../header.php';
?>

<div class="container mx-auto px-4 py-8">
    <div class="bg-white/75 dark:bg-gray-900/75 p-6 rounded-lg shadow-lg backdrop-blur-sm">
        <div class="flex items-center mb-6 border-b-2 border-gray-300 dark:border-gray-700 pb-3">
             <a href="radio_admin.php" class="text-blue-500 hover:text-blue-700 mr-4"><i class="fas fa-arrow-left fa-lg"></i></a>
            <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-100 pixel-font">Manage DJs</h1>
        </div>

        <div class="mb-6 text-right">
            <button class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-lg shadow-lg">
                <i class="fas fa-plus"></i> Add New DJ
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- DJ Card -->
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg shadow-md text-center">
                <img src="https://www.habbo.com/habbo-imaging/avatarimage?user=DJ-Pixel&direction=2&head_direction=3" alt="DJ Pixel" class="w-24 h-24 mx-auto border-4 border-white dark:border-gray-700 rounded-full shadow-lg">
                <h3 class="text-xl font-bold mt-3">DJ Pixel</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Head DJ</p>
                <div class="mt-3">
                    <button class="text-blue-500 hover:text-blue-700 mr-2"><i class="fas fa-pencil-alt"></i> Edit</button>
                    <button class="text-red-500 hover:text-red-700"><i class="fas fa-user-minus"></i> Remove</button>
                </div>
            </div>
             <!-- DJ Card -->
            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg shadow-md text-center">
                <img src="https://www.habbo.com/habbo-imaging/avatarimage?user=DJ-Sparkle&direction=4&head_direction=3" alt="DJ Sparkle" class="w-24 h-24 mx-auto border-4 border-white dark:border-gray-700 rounded-full shadow-lg">
                <h3 class="text-xl font-bold mt-3">DJ Sparkle</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">DJ</p>
                 <div class="mt-3">
                    <button class="text-blue-500 hover:text-blue-700 mr-2"><i class="fas fa-pencil-alt"></i> Edit</button>
                    <button class="text-red-500 hover:text-red-700"><i class="fas fa-user-minus"></i> Remove</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include '../footer.php';
?>
