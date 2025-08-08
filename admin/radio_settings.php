<?php
// admin/radio_settings.php

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
            <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-100 pixel-font">Radio Settings</h1>
        </div>

        <form action="#" method="post">
            <div class="mb-4">
                <label for="stream-url" class="block text-gray-700 dark:text-gray-200 font-bold mb-2">Radio Stream URL</label>
                <input type="url" name="stream_url" id="stream-url" class="w-full px-3 py-2 rounded-lg bg-gray-200 dark:bg-gray-800 border" value="https://coderadio-admin-v2.freecodecamp.org/listen/coderadio/radio.mp3">
            </div>
             <div class="mb-6">
                <label for="api-url" class="block text-gray-700 dark:text-gray-200 font-bold mb-2">AzuraCast API URL</label>
                <input type="url" name="api_url" id="api-url" class="w-full px-3 py-2 rounded-lg bg-gray-200 dark:bg-gray-800 border" value="https://demo.azuracast.com/api/nowplaying_static/azuratest_radio.json">
            </div>
            <div class="text-right">
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-lg shadow-lg">
                    <i class="fas fa-save"></i> Save Settings
                </button>
            </div>
        </form>
    </div>
</div>

<?php
include '../footer.php';
?>
