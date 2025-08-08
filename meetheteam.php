<?php 
include 'header.php'; 
require_once 'config.php';

// Fetch all staff members (rank > 1)
$sql = "SELECT u.username, u.motto, r.name as rank_name 
        FROM users u 
        JOIN ranks r ON u.rank_id = r.id 
        WHERE u.rank_id > 1 
        ORDER BY u.rank_id DESC";
$team_result = $mysqli->query($sql);
?>

<main class="container mx-auto px-4 py-8">
    <div class="bg-white/75 dark:bg-gray-800/75 p-6 rounded-lg shadow-lg backdrop-blur-sm">
        <h1 class="pixel-font text-4xl font-bold text-gray-800 dark:text-white mb-6 text-center">Meet The Radio Fansite HERE</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if ($team_result && $team_result->num_rows > 0): ?>
                <?php while($member = $team_result->fetch_assoc()): ?>
                    <div class="bg-gray-100 dark:bg-gray-700/80 p-4 rounded-lg text-center">
                        <img src="https://vortexhotel.co.uk/habbo-imaging/avatarimage?user=<?php echo htmlspecialchars($member['username']); ?>&direction=2&head_direction=3&gesture=sml&action=wav" alt="<?php echo htmlspecialchars($member['username']); ?>'s Avatar" class="w-24 h-24 mx-auto rounded-full border-4 border-blue-400 mb-4">
                        <h3 class="pixel-font text-xl font-bold text-gray-800 dark:text-white"><?php echo htmlspecialchars($member['username']); ?></h3>
                        <p class="font-semibold text-blue-500 dark:text-blue-400"><?php echo htmlspecialchars($member['rank_name']); ?></p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 italic">"<?php echo htmlspecialchars($member['motto']); ?>"</p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center col-span-full">Our team is currently undercover. Check back soon!</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
