<?php
include 'header.php';
require_once 'config.php';

// Fetch DJ Timetable Data
$timetable_sql = "SELECT t.day_of_week, t.time_slot, u.username AS dj_name 
                  FROM timetable t 
                  LEFT JOIN users u ON t.dj_id = u.id 
                  ORDER BY FIELD(t.day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), t.time_slot ASC";
$timetable_result = $mysqli->query($timetable_sql);
$schedule = [];
while($row = $timetable_result->fetch_assoc()) {
    $schedule[$row['day_of_week']][$row['time_slot']] = $row['dj_name'];
}

// Fetch Upcoming Events Data
$events_sql = "SELECT e.event_name, e.description, e.event_date, u.username AS host_name 
               FROM events e 
               JOIN users u ON e.hosted_by = u.id 
               WHERE e.event_date >= NOW() 
               ORDER BY e.event_date ASC 
               LIMIT 5";
$events_result = $mysqli->query($events_sql);

$days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
$time_slots = ['08:00 - 10:00', '10:00 - 12:00', '12:00 - 14:00', '14:00 - 16:00', '16:00 - 18:00', '18:00 - 20:00', '20:00 - 22:00'];
?>

<main class="container mx-auto px-4 py-8">
    <h1 class="pixel-font text-4xl font-bold text-gray-800 dark:text-white mb-6 text-center">Vortex Timetables</h1>

    <!-- DJ Timetable Section -->
    <div class="bg-white/75 dark:bg-gray-800/75 p-6 rounded-lg shadow-lg backdrop-blur-sm mb-8">
        <h2 class="pixel-font text-3xl font-bold text-gray-800 dark:text-white mb-4">Weekly DJ Schedule</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse border border-gray-300 dark:border-gray-600">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700">
                        <th class="border border-gray-300 dark:border-gray-600 p-2">Time</th>
                        <?php foreach ($days as $day): ?>
                            <th class="border border-gray-300 dark:border-gray-600 p-2"><?php echo $day; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($time_slots as $slot): ?>
                        <tr class="text-center">
                            <td class="border border-gray-300 dark:border-gray-600 p-2 font-semibold"><?php echo $slot; ?></td>
                            <?php foreach ($days as $day): ?>
                                <td class="border border-gray-300 dark:border-gray-600 p-2">
                                    <?php echo htmlspecialchars($schedule[$day][$slot] ?? 'AutoDJ'); ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Upcoming Events Section -->
    <div class="bg-white/75 dark:bg-gray-800/75 p-6 rounded-lg shadow-lg backdrop-blur-sm">
        <h2 class="pixel-font text-3xl font-bold text-gray-800 dark:text-white mb-4">Upcoming Events</h2>
        <div class="space-y-4">
            <?php if ($events_result && $events_result->num_rows > 0): ?>
                <?php while($event = $events_result->fetch_assoc()): ?>
                    <div class="bg-gray-100 dark:bg-gray-700/80 p-4 rounded-lg">
                        <h3 class="font-bold text-xl text-blue-600 dark:text-blue-400"><?php echo htmlspecialchars($event['event_name']); ?></h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                            Hosted by: <?php echo htmlspecialchars($event['host_name']); ?> on <?php echo date("l, jS F Y \a\\t g:i A", strtotime($event['event_date'])); ?>
                        </p>
                        <p class="text-gray-700 dark:text-gray-300"><?php echo htmlspecialchars($event['description']); ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-gray-600 dark:text-gray-400">No upcoming events scheduled. Check back soon!</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php
include 'footer.php';
?>
