<?php 
// rares.php - Displays the rare value guides
include 'header.php'; 
require_once 'config.php';

// Fetch all rares from the database, ordered by release date
$sql = "SELECT name, description, image_url, value_category, release_date 
        FROM rares 
        ORDER BY release_date DESC";
$rares_result = $mysqli->query($sql);
?>

<main class="container mx-auto px-4 py-8">
    <div class="bg-white/75 dark:bg-gray-800/75 p-6 rounded-lg shadow-lg backdrop-blur-sm">
        <h1 class="pixel-font text-4xl font-bold text-gray-800 dark:text-white mb-6 text-center">Rare Value Guides</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php if ($rares_result && $rares_result->num_rows > 0): ?>
                <?php while($rare = $rares_result->fetch_assoc()): ?>
                    <div class="bg-gray-100 dark:bg-gray-700/80 p-4 rounded-lg text-center transform hover:-translate-y-1 transition-transform duration-300">
                        <img src="<?php echo htmlspecialchars($rare['image_url']); ?>" alt="<?php echo htmlspecialchars($rare['name']); ?>" class="w-20 h-20 mx-auto mb-4" onerror="this.onerror=null;this.src='https://placehold.co/80x80/374151/e5e7eb?text=Rare';">
                        <h3 class="pixel-font text-xl font-bold text-gray-800 dark:text-white"><?php echo htmlspecialchars($rare['name']); ?></h3>
                        <p class="font-semibold text-blue-500 dark:text-blue-400"><?php echo htmlspecialchars($rare['value_category']); ?></p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2"><?php echo htmlspecialchars($rare['description']); ?></p>
                        <?php if (!empty($rare['release_date'])): ?>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">Released: <?php echo date("M Y", strtotime($rare['release_date'])); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center col-span-full text-gray-600 dark:text-gray-400">No rare guides have been added yet. Check back soon!</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
