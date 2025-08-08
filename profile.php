<?php
// profile.php - User profile and settings page
require_once 'config.php';

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$message = '';
$user_id = $_SESSION['id'];

// --- Handle Profile Update (Email) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $new_email = trim($_POST['email']);
    if (!empty($new_email) && filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $sql = "UPDATE users SET email = ? WHERE id = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("si", $new_email, $user_id);
            if ($stmt->execute()) {
                $message = "<div class='bg-green-500 text-white p-3 rounded-lg mb-4'>Email updated successfully!</div>";
            } else {
                $message = "<div class='bg-red-500 text-white p-3 rounded-lg mb-4'>Error updating email.</div>";
            }
            $stmt->close();
        }
    } else {
        $message = "<div class='bg-yellow-500 text-black p-3 rounded-lg mb-4'>Please enter a valid email address.</div>";
    }
}

// --- Handle Password Change ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['change_password'])) {
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (strlen($new_password) < 6) {
        $message = "<div class='bg-yellow-500 text-black p-3 rounded-lg mb-4'>Password must be at least 6 characters long.</div>";
    } elseif ($new_password !== $confirm_password) {
        $message = "<div class='bg-yellow-500 text-black p-3 rounded-lg mb-4'>Passwords do not match.</div>";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("si", $hashed_password, $user_id);
            if ($stmt->execute()) {
                $message = "<div class='bg-green-500 text-white p-3 rounded-lg mb-4'>Password changed successfully!</div>";
            } else {
                $message = "<div class='bg-red-500 text-white p-3 rounded-lg mb-4'>Error changing password.</div>";
            }
            $stmt->close();
        }
    }
}


// FIX: Fetch current user data, joining with the ranks table to get the rank name
$sql = "SELECT u.username, u.email, u.created_at, r.name AS rank_name 
        FROM users u 
        JOIN ranks r ON u.rank_id = r.id 
        WHERE u.id = ?";
if ($stmt = $mysqli->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($username, $email, $created_at, $rank_name);
    $stmt->fetch();
    $stmt->close();
}

include 'header.php';
?>

<main class="container mx-auto px-4 py-8">
    <h1 class="pixel-font text-4xl font-bold text-gray-800 dark:text-white mb-6">Your Profile</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Profile Information -->
        <div class="md:col-span-1 bg-white/75 dark:bg-gray-800/75 p-6 rounded-lg shadow-lg backdrop-blur-sm">
            <div class="text-center">
                <img src="https://vortexhotel.co.uk/habbo-imaging/avatarimage?user=<?php echo htmlspecialchars($username); ?>&direction=2&head_direction=3&gesture=sml&action=wav" alt="Your Avatar" class="w-32 h-32 mx-auto rounded-full border-4 border-blue-400 mb-4">
                <h2 class="pixel-font text-2xl font-bold text-gray-800 dark:text-white"><?php echo htmlspecialchars($username); ?></h2>
                <!-- FIX: Display the user's rank name -->
                <p class="text-lg text-blue-500 dark:text-blue-400 font-semibold"><?php echo htmlspecialchars($rank_name); ?></p>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Member since <?php echo date("M Y", strtotime($created_at)); ?></p>
            </div>
        </div>

        <!-- Edit Profile Forms -->
        <div class="md:col-span-2 space-y-8">
            <?php echo $message; // Display success or error messages ?>
            
            <!-- Update Email Form -->
            <div class="bg-white/75 dark:bg-gray-800/75 p-6 rounded-lg shadow-lg backdrop-blur-sm">
                <h3 class="pixel-font text-2xl font-bold text-gray-800 dark:text-white mb-4">Update Profile</h3>
                <form action="profile.php" method="post">
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Email Address:</label>
                        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <button type="submit" name="update_profile" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">Update Email</button>
                    </div>
                </form>
            </div>

            <!-- Change Password Form -->
            <div class="bg-white/75 dark:bg-gray-800/75 p-6 rounded-lg shadow-lg backdrop-blur-sm">
                <h3 class="pixel-font text-2xl font-bold text-gray-800 dark:text-white mb-4">Change Password</h3>
                <form action="profile.php" method="post">
                    <div class="mb-4">
                        <label for="new_password" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">New Password:</label>
                        <input type="password" name="new_password" id="new_password" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="confirm_password" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Confirm New Password:</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <button type="submit" name="change_password" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php
include 'footer.php';
?>
