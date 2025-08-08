<?php 
// jobs.php - Job listings and application form

// --- FIX: Enable error reporting and include config at the very top ---
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'config.php'; // For DB connection and session start

$message = '';

// --- FIX: Handle form submission before any HTML is output ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_application'])) {
    // --- FIX: Added a more robust check to validate the user's session ID ---
    if (
        !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || 
        !isset($_SESSION['id']) || !is_numeric($_SESSION['id']) || $_SESSION['id'] <= 0
    ) {
        $message = "<div class='bg-red-500 text-white p-3 rounded-lg mb-4'>Your session appears to be invalid. Please log out and log back in before applying.</div>";
    } else {
        $user_id = $_SESSION['id'];
        $job_title = trim($_POST['job_title']);
        $real_name = trim($_POST['real_name']);
        $age = filter_var($_POST['age'], FILTER_SANITIZE_NUMBER_INT);
        $experience = trim($_POST['experience']);

        if (!empty($job_title) && !empty($real_name) && !empty($age) && !empty($experience)) {
            $sql = "INSERT INTO job_applications (user_id, job_title, real_name, age, experience) VALUES (?, ?, ?, ?, ?)";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("issis", $user_id, $job_title, $real_name, $age, $experience);
                if ($stmt->execute()) {
                    $message = "<div class='bg-green-500 text-white p-3 rounded-lg mb-4'>Your application has been submitted successfully! We will review it shortly.</div>";
                } else {
                    // Provide a more detailed error message for debugging
                    $message = "<div class='bg-red-500 text-white p-3 rounded-lg mb-4'>Error: Could not submit your application. Please try again. (" . $stmt->error . ")</div>";
                }
                $stmt->close();
            } else {
                 $message = "<div class='bg-red-500 text-white p-3 rounded-lg mb-4'>Error: Could not prepare the application query. " . $mysqli->error . "</div>";
            }
        } else {
            $message = "<div class='bg-yellow-500 text-black p-3 rounded-lg mb-4'>Please fill out all fields of the application.</div>";
        }
    }
}

// Now that processing is done, include the header to start the HTML page
include 'header.php'; 
?>

<main class="container mx-auto px-4 py-8">
    <div class="bg-white/75 dark:bg-gray-800/75 p-6 rounded-lg shadow-lg backdrop-blur-sm">
        <h1 class="pixel-font text-4xl font-bold text-gray-800 dark:text-white mb-6 text-center">Join The Team!</h1>
        
        <?php echo $message; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Job Descriptions -->
            <div class="space-y-6">
                <h2 class="pixel-font text-3xl font-bold text-gray-800 dark:text-white mb-4">Open Positions</h2>
                <div class="bg-gray-100 dark:bg-gray-700/80 p-4 rounded-lg">
                    <h3 class="pixel-font text-2xl font-bold text-blue-600 dark:text-blue-400">Radio DJ</h3>
                    <p class="text-gray-700 dark:text-gray-300 mt-2">Are you passionate about music and love to entertain? We're looking for enthusiastic DJs to host shows on Vortex Radio. Apply now and share your sound with our community!</p>
                </div>
                <div class="bg-gray-100 dark:bg-gray-700/80 p-4 rounded-lg">
                    <h3 class="pixel-font text-2xl font-bold text-blue-600 dark:text-blue-400">Event Host</h3>
                    <p class="text-gray-700 dark:text-gray-300 mt-2">Bring your creativity to life by hosting fun and engaging events for the Vortex community. If you're organized and love interacting with people, this role is for you!</p>
                </div>
            </div>

            <!-- Application Form -->
            <div>
                <h2 class="pixel-font text-3xl font-bold text-gray-800 dark:text-white mb-4">Application Form</h2>
                <form action="jobs.php" method="post">
                    <div class="mb-4">
                        <label for="job_title" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Position Applying For:</label>
                        <select name="job_title" id="job_title" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600" required>
                            <option value="">-- Select a Position --</option>
                            <option value="Radio DJ">Radio DJ</option>
                            <option value="Event Host">Event Host</option>
                            <option value="Builder">Builder</option>
                            <option value="Reporter">Reporter</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="real_name" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Real Name:</label>
                        <input type="text" name="real_name" id="real_name" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600" required>
                    </div>
                    <div class="mb-4">
                        <label for="age" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Age:</label>
                        <input type="number" name="age" id="age" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600" required>
                    </div>
                    <div class="mb-4">
                        <label for="experience" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Why should we hire you? (Experience, Skills, etc.)</label>
                        <textarea name="experience" id="experience" rows="5" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600" required></textarea>
                    </div>
                    <div>
                        <button type="submit" name="submit_application" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">Submit Application</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
