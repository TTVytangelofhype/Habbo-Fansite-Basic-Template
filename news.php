<?php include 'header.php'; ?>

<main class="container mx-auto px-4 py-8">

    <!-- Page Title -->
    <h1 class="pixel-font text-4xl font-bold text-gray-800 dark:text-white mb-6 text-center">Latest News & Articles</h1>
    
    <!-- Articles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

        <?php 
        // Example loop for generating news articles.
        // In a real application, this data would come from a database.
        for ($i = 0; $i < 8; $i++): 
            $articles = [
                ['title' => 'ST New Furni Found!', 'author' => 'Tyler', 'views' => '17k', 'replies' => '4'],
                ['title' => 'Pride Competition Winners', 'author' => 'Shortbread', 'views' => '25k', 'replies' => '8'],
                ['title' => 'Wobble Squabble Returns', 'author' => 'Keegan', 'views' => '12k', 'replies' => '2'],
                ['title' => 'Summer Fashion Show', 'author' => 'Rainbow', 'views' => '31k', 'replies' => '15'],
                ['title' => 'Rare Duck Car', 'author' => 'Shortbread', 'views' => '8k', 'replies' => '1'],
                ['title' => 'Donnie\'s Bathroom Suite', 'author' => 'Tyler', 'views' => '22k', 'replies' => '20'],
                ['title' => 'Underwater House Bundle', 'author' => 'Keegan', 'views' => '18k', 'replies' => '9'],
                // FIX: Removed "HabboQuests" from the article title
                ['title' => 'Our 10th Birthday!', 'author' => 'Rainbow', 'views' => '57k', 'replies' => '121'],
            ];
            $article = $articles[$i];
        ?>
        <!-- Article Card -->
        <div class="bg-white/75 dark:bg-gray-800/75 rounded-lg shadow-lg overflow-hidden transform hover:-translate-y-1 transition-transform duration-300 backdrop-blur-sm">
            <img src="https://placehold.co/400x200/0d121c/ffffff?text=Article+Image" alt="Article Image" class="w-full h-32 object-cover">
            <div class="p-4">
                <h3 class="font-bold text-lg mb-2 text-gray-800 dark:text-white"><?php echo htmlspecialchars($article['title']); ?></h3>
                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-3">
                    <i class="fas fa-user mr-2"></i>
                    <span><?php echo htmlspecialchars($article['author']); ?></span>
                </div>
                <div class="flex justify-between text-sm text-gray-500 dark:text-gray-400">
                    <span title="Views"><i class="fas fa-eye mr-1"></i><?php echo htmlspecialchars($article['views']); ?></span>
                    <span title="Replies"><i class="fas fa-comment-dots mr-1"></i><?php echo htmlspecialchars($article['replies']); ?></span>
                </div>
                <a href="#" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded-full hover:bg-blue-600 text-sm font-semibold">Read More</a>
            </div>
        </div>
        <?php endfor; ?>

    </div>

</main>

<?php include 'footer.php'; ?>
