<?php
// register.php - Handles user registration
require_once 'config.php';

$username = $email = $password = '';
$username_err = $email_err = $password_err = '';
$message = '';

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $param_username);
            $param_username = trim($_POST["username"]);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                $message = "<div class='bg-red-500 text-white p-3 rounded-lg mb-4'>Oops! Something went wrong. Please try again later.</div>";
            }
            $stmt->close();
        }
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } else {
        $email = trim($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format.";
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($email_err) && empty($password_err)) {
        // FIX: Insert into users table without specifying rank_id, so it uses the default value of 1.
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("sss", $param_username, $param_email, $param_password);

            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); 

            if ($stmt->execute()) {
                header("location: login.php?registered=true");
            } else {
                $message = "<div class='bg-red-500 text-white p-3 rounded-lg mb-4'>Something went wrong. Please try again later.</div>";
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
            <h1 class="pixel-font text-3xl font-bold text-gray-800 dark:text-white mb-6 text-center">Register</h1>
            <p class="text-center text-gray-600 dark:text-gray-300 mb-6">Create your account to join the community.</p>
            
            <?php echo $message; ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo $username; ?>" class="w-full px-3 py-2 border <?php echo (!empty($username_err)) ? 'border-red-500' : 'border-gray-300'; ?> rounded-lg dark:bg-gray-700 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span class="text-red-500 text-xs italic"><?php echo $username_err; ?></span>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo $email; ?>" class="w-full px-3 py-2 border <?php echo (!empty($email_err)) ? 'border-red-500' : 'border-gray-300'; ?> rounded-lg dark:bg-gray-700 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span class="text-red-500 text-xs italic"><?php echo $email_err; ?></span>
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-3 py-2 border <?php echo (!empty($password_err)) ? 'border-red-500' : 'border-gray-300'; ?> rounded-lg dark:bg-gray-700 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span class="text-red-500 text-xs italic"><?php echo $password_err; ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">Register</button>
                </div>
                <p class="text-center mt-4 text-gray-600 dark:text-gray-400">
                    Already have an account? <a href="login.php" class="text-blue-500 hover:underline">Login here</a>.
                </p>
            </form>
        </div>
    </div>
</main>

<?php
include 'footer.php';
?>
