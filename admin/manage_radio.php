<?php
// manage_radio.php - Part of the admin panel

// Ensure this script is not accessed directly
if (!isset($mysqli)) {
    exit('Invalid access');
}

// --- Security check for editing radio settings (HeadDJ and up) ---
if ($_SESSION['rank_id'] < 6) {
    echo "<p class='text-red-500'>You do not have sufficient permissions to manage radio settings.</p>";
    return; // Stop rendering the rest of the page
}

$message = '';

// --- Handle Settings Update ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_radio_settings'])) {
    $stream_url = trim($_POST['stream_url']);
    $api_url = trim($_POST['api_url']);

    $stmt1 = $mysqli->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = 'radio_stream_url'");
    $stmt1->bind_param("s", $stream_url);
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $mysqli->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = 'radio_api_url'");
    $stmt2->bind_param("s", $api_url);
    $stmt2->execute();
    $stmt2->close();

    $message = "<div class='bg-green-500 text-white p-3 rounded-lg mb-4'>Radio settings updated successfully.</div>";
}

// Fetch current radio settings
$stream_url_result = $mysqli->query("SELECT setting_value FROM settings WHERE setting_key = 'radio_stream_url'");
$current_stream_url = $stream_url_result->fetch_assoc()['setting_value'] ?? '';

$api_url_result = $mysqli->query("SELECT setting_value FROM settings WHERE setting_key = 'radio_api_url'");
$current_api_url = $api_url_result->fetch_assoc()['setting_value'] ?? '';
?>

<h2 class="pixel-font text-2xl font-bold text-gray-800 dark:text-white mb-4">Manage Radio Settings</h2>
<?php echo $message; ?>

<form action="admin.php?page=radio" method="post">
    <div class="mb-4">
        <label for="stream_url" class="block font-bold mb-1">Radio Stream URL:</label>
        <input type="text" name="stream_url" id="stream_url" value="<?php echo htmlspecialchars($current_stream_url); ?>" class="w-full p-2 border rounded dark:bg-gray-700" required>
        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">This is the direct audio link for the player (e.g., .mp3, .aac).</p>
    </div>
    <div class="mb-4">
        <label for="api_url" class="block font-bold mb-1">AzuraCast API URL:</label>
        <input type="text" name="api_url" id="api_url" value="<?php echo htmlspecialchars($current_api_url); ?>" class="w-full p-2 border rounded dark:bg-gray-700" required>
        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">The 'Now Playing' static JSON URL from your radio provider.</p>
    </div>
    <div>
        <button type="submit" name="update_radio_settings" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save Settings</button>
    </div>
</form>
