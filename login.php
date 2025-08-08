<?php
// login.php - Handles user login and session creation
require_once 'config.php';

$username = $password = '';
$username_err = $password_err = $login_err = '';

// Display a message if redirected from registration
if (isset($_GET['registered']) && $_GET['registered'] == 'true') {
    $login_err = "<div class='bg-green-500 text-white p-3 rounded-lg mb-4'>Registration successful! Please log in.</div>";
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }
    
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    if (empty($username_err) && empty($password_err)) {
        // FIX: Ensure rank_id is selected from the users table
        $sql = "SELECT id, username, password, rank_id FROM users WHERE username = ?";
        
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_username);
            $param_username = $username;
            
            if ($stmt->execute()) {
                $stmt->store_result();
                
                if ($stmt->num_rows == 1) {
                    // FIX: Bind the rank_id result to a variable
                    $stmt->bind_result($id, $username, $hashed_password, $rank_id);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            // FIX: Store the fetched rank_id in the session
                            $_SESSION["rank_id"] = $rank_id;                            
                            
                            header("location: index.php");
                        } else {
                            $login_err = "<div class='bg-red-500 text-white p-3 rounded-lg mb-4'>Invalid username or password.</div>";
                        }
                    }
                } else {
                    $login_err = "<div class='bg-red-500 text-white p-3 rounded-lg mb-4'>Invalid username or password.</div>";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
}
include 'header.php';
?>

<main class="container mx-auto px-4 py-8 flex justify-center">
    <div class="w-full max-w-md">
        <div class="bg-white/75 dark:bg-gray-800/75 p-8 rounded-lg shadow-lg backdrop-blur-sm">
            <h1 class="pixel-font text-3xl font-bold text-gray-800 dark:text-white mb-6 text-center">Login</h1>
            
            <?php echo $login_err; ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo $username; ?>" class="w-full px-3 py-2 border <?php echo (!empty($username_err)) ? 'border-red-500' : 'border-gray-300'; ?> rounded-lg dark:bg-gray-700 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span class="text-red-500 text-xs italic"><?php echo $username_err; ?></span>
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-3 py-2 border <?php echo (!empty($password_err)) ? 'border-red-500' : 'border-gray-300'; ?> rounded-lg dark:bg-gray-700 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span class="text-red-500 text-xs italic"><?php echo $password_err; ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">Login</button>
                </div>
                 <p class="text-center mt-4 text-gray-600 dark:text-gray-400">
                    Don't have an account? <a href="register.php" class="text-blue-500 hover:underline">Register here</a>.
                </p>
            </form>
        </div>
    </div>
</main>

<?php
include 'footer.php';
?>
