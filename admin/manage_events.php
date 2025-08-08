<?php
// manage_events.php - Part of the admin panel

// Ensure this script is not accessed directly
if (!isset($mysqli)) {
    exit('Invalid access');
}

$message = '';

// --- Handle Event Deletion ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_event'])) {
    $event_id = $_POST['event_id'];
    $stmt = $mysqli->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $stmt->close();
    $message = "<div class='bg-green-500 text-white p-3 rounded-lg mb-4'>Event deleted.</div>";
}

// --- Handle Event Submission ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_event'])) {
    $event_name = trim($_POST['event_name']);
    $description = trim($_POST['description']);
    $event_date = trim($_POST['event_date']);
    $hosted_by = $_SESSION['id']; // Or a dropdown of event hosts

    $sql = "INSERT INTO events (event_name, description, hosted_by, event_date) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssis", $event_name, $description, $hosted_by, $event_date);
    if ($stmt->execute()) {
        $message = "<div class='bg-green-500 text-white p-3 rounded-lg mb-4'>Event created successfully.</div>";
    } else {
        $message = "<div class='bg-red-500 text-white p-3 rounded-lg mb-4'>Error creating event.</div>";
    }
    $stmt->close();
}

// Fetch existing events
$events_result = $mysqli->query("SELECT e.id, e.event_name, e.event_date, u.username as host_name FROM events e JOIN users u ON e.hosted_by = u.id ORDER BY e.event_date DESC");
?>

<h2 class="pixel-font text-2xl font-bold text-gray-800 dark:text-white mb-4">Add Event</h2>
<?php echo $message; ?>

<form action="admin.php?page=events" method="post" class="mb-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
            <label for="event_name" class="block font-bold mb-1">Event Name:</label>
            <input type="text" name="event_name" id="event_name" class="w-full p-2 border rounded dark:bg-gray-700" required>
        </div>
        <div>
            <label for="event_date" class="block font-bold mb-1">Event Date & Time:</label>
            <input type="datetime-local" name="event_date" id="event_date" class="w-full p-2 border rounded dark:bg-gray-700" required>
        </div>
    </div>
    <div class="mb-4">
        <label for="description" class="block font-bold mb-1">Description:</label>
        <textarea name="description" id="description" rows="4" class="w-full p-2 border rounded dark:bg-gray-700" required></textarea>
    </div>
    <div>
        <button type="submit" name="add_event" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create Event</button>
    </div>
</form>

<hr class="my-8 dark:border-gray-600">

<h2 class="pixel-font text-2xl font-bold text-gray-800 dark:text-white mb-4">Manage Existing Events</h2>
<div class="overflow-x-auto">
    <table class="min-w-full bg-white dark:bg-gray-800 border">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Name</th>
                <th class="py-2 px-4 border-b">Host</th>
                <th class="py-2 px-4 border-b">Date</th>
                <th class="py-2 px-4 border-b">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($event = $events_result->fetch_assoc()): ?>
                <tr>
                    <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($event['event_name']); ?></td>
                    <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($event['host_name']); ?></td>
                    <td class="py-2 px-4 border-b"><?php echo date("d M Y, g:ia", strtotime($event['event_date'])); ?></td>
                    <td class="py-2 px-4 border-b">
                        <form action="admin.php?page=events" method="post" onsubmit="return confirm('Delete this event?');">
                            <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                            <button type="submit" name="delete_event" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
