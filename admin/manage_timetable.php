<?php
// manage_timetable.php - Part of the admin panel

// Ensure this script is not accessed directly
if (!isset($mysqli)) {
    exit('Invalid access');
}

// --- Security check for editing timetable ---
$can_edit_timetable = ($_SESSION['rank_id'] >= 11);
$message = '';

// --- Handle Timetable Update ---
if ($can_edit_timetable && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_slot'])) {
    $day = $_POST['day'];
    $slot = $_POST['slot'];
    $dj_id = $_POST['dj_id'];

    // Use NULL for the 'unassign' option
    if ($dj_id === 'unassign') {
        $dj_id = NULL;
    }

    // Check if a record exists, then update or insert
    $check_stmt = $mysqli->prepare("SELECT id FROM timetable WHERE day_of_week = ? AND time_slot = ?");
    $check_stmt->bind_param("ss", $day, $slot);
    $check_stmt->execute();
    $check_stmt->store_result();
    
    if ($check_stmt->num_rows > 0) {
        $sql = "UPDATE timetable SET dj_id = ? WHERE day_of_week = ? AND time_slot = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("iss", $dj_id, $day, $slot);
    } else {
        $sql = "INSERT INTO timetable (dj_id, day_of_week, time_slot) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("iss", $dj_id, $day, $slot);
    }
    
    if ($stmt->execute()) {
        $message = "<div class='bg-green-500 text-white p-3 rounded-lg mb-4'>Timetable updated successfully.</div>";
    } else {
        $message = "<div class='bg-red-500 text-white p-3 rounded-lg mb-4'>Error updating timetable.</div>";
    }
    $stmt->close();
    $check_stmt->close();
}


// Fetch data for the form and table
$djs_result = $mysqli->query("SELECT id, username FROM users WHERE rank_id IN (5, 6)"); // Rank 5=RadioDJ, 6=HeadDJ
$djs = $djs_result->fetch_all(MYSQLI_ASSOC);

$timetable_result = $mysqli->query("SELECT t.day_of_week, t.time_slot, u.username AS dj_name FROM timetable t LEFT JOIN users u ON t.dj_id = u.id");
$schedule = [];
while($row = $timetable_result->fetch_assoc()) {
    $schedule[$row['day_of_week']][$row['time_slot']] = $row['dj_name'];
}

$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
$time_slots = ['08:00 - 10:00', '10:00 - 12:00', '12:00 - 14:00', '14:00 - 16:00', '16:00 - 18:00', '18:00 - 20:00', '20:00 - 22:00'];
?>

<h2 class="pixel-font text-2xl font-bold text-gray-800 dark:text-white mb-4">Manage DJ Timetable</h2>
<?php echo $message; ?>

<?php if ($can_edit_timetable): ?>
<div class="overflow-x-auto">
    <table class="min-w-full bg-white dark:bg-gray-800 border">
        <thead class="bg-gray-200 dark:bg-gray-700">
            <tr>
                <th class="py-2 px-4 border-b">Time</th>
                <?php foreach ($days as $day): ?>
                    <th class="py-2 px-4 border-b"><?php echo $day; ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($time_slots as $slot): ?>
                <tr class="text-center">
                    <td class="py-2 px-4 border-b font-semibold"><?php echo $slot; ?></td>
                    <?php foreach ($days as $day): ?>
                        <td class="py-2 px-4 border-b">
                            <form action="admin.php?page=timetable" method="post">
                                <input type="hidden" name="day" value="<?php echo $day; ?>">
                                <input type="hidden" name="slot" value="<?php echo $slot; ?>">
                                <select name="dj_id" class="p-1 rounded dark:bg-gray-600 w-full mb-1">
                                    <option value="unassign">-- Unassigned --</option>
                                    <?php foreach ($djs as $dj): ?>
                                        <option value="<?php echo $dj['id']; ?>" <?php if (isset($schedule[$day][$slot]) && $schedule[$day][$slot] == $dj['username']) echo 'selected'; ?>>
                                            <?php echo htmlspecialchars($dj['username']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" name="update_slot" class="w-full bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600">Save</button>
                            </form>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
    <p class="text-red-500">You do not have permission to edit the timetable.</p>
<?php endif; ?>
