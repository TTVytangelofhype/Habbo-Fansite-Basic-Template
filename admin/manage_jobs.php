<?php
// manage_jobs.php - Part of the admin panel

// Ensure this script is not accessed directly
if (!defined('ROOT_PATH')) {
    exit('Invalid access');
}

// Security check: This page is only for Rank 11+
if ($_SESSION['rank_id'] < 11) {
    echo "<p class='text-red-500'>You do not have permission to manage job applications.</p>";
    return;
}

$message = '';

// --- Handle Application Status Update ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $application_id = $_POST['application_id'];
    $new_status = $_POST['status'];
    
    $stmt = $mysqli->prepare("UPDATE job_applications SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $application_id);
    if ($stmt->execute()) {
        $message = "<div class='bg-green-500 text-white p-3 rounded-lg mb-4'>Application status updated.</div>";
    } else {
        $message = "<div class='bg-red-500 text-white p-3 rounded-lg mb-4'>Error updating status.</div>";
    }
    $stmt->close();
}

// Fetch all job applications
$apps_result = $mysqli->query("SELECT ja.id, ja.job_title, ja.real_name, ja.age, ja.experience, ja.status, ja.submitted_at, u.username 
                               FROM job_applications ja 
                               JOIN users u ON ja.user_id = u.id 
                               ORDER BY ja.submitted_at DESC");
// Add error checking for the database query
if (!$apps_result) {
    echo "<div class='bg-red-500 text-white p-3 rounded-lg mb-4'>Database Error: " . $mysqli->error . "</div>";
}
?>

<h2 class="pixel-font text-2xl font-bold text-gray-800 dark:text-white mb-4">Manage Job Applications</h2>
<?php echo $message; ?>

<div class="overflow-x-auto">
    <table class="min-w-full bg-white dark:bg-gray-800 border">
        <thead class="bg-gray-200 dark:bg-gray-700">
            <tr>
                <th class="py-2 px-4 border-b">Applicant</th>
                <th class="py-2 px-4 border-b">Position</th>
                <th class="py-2 px-4 border-b">Details</th>
                <th class="py-2 px-4 border-b">Experience</th>
                <th class="py-2 px-4 border-b">Status</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($apps_result && $apps_result->num_rows > 0): ?>
                <?php while ($app = $apps_result->fetch_assoc()): ?>
                    <tr class="text-center">
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($app['username']); ?></td>
                        <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($app['job_title']); ?></td>
                        <td class="py-2 px-4 border-b text-left">
                            <strong>Name:</strong> <?php echo htmlspecialchars($app['real_name']); ?><br>
                            <strong>Age:</strong> <?php echo htmlspecialchars($app['age']); ?>
                        </td>
                        <td class="py-2 px-4 border-b text-left max-w-sm"><?php echo nl2br(htmlspecialchars($app['experience'])); ?></td>
                        <td class="py-2 px-4 border-b">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                <?php 
                                    if ($app['status'] == 'accepted') echo 'bg-green-100 text-green-800';
                                    elseif ($app['status'] == 'rejected') echo 'bg-red-100 text-red-800';
                                    else echo 'bg-yellow-100 text-yellow-800';
                                ?>">
                                <?php echo ucfirst($app['status']); ?>
                            </span>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <form action="admin.php?page=jobs" method="post">
                                <input type="hidden" name="application_id" value="<?php echo $app['id']; ?>">
                                <select name="status" class="p-1 rounded dark:bg-gray-600 w-full mb-1">
                                    <option value="pending" <?php if ($app['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                                    <option value="accepted" <?php if ($app['status'] == 'accepted') echo 'selected'; ?>>Accept</option>
                                    <option value="rejected" <?php if ($app['status'] == 'rejected') echo 'selected'; ?>>Reject</option>
                                </select>
                                <button type="submit" name="update_status" class="w-full bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center py-4">No job applications have been submitted.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
