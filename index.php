<?php
// index.php - The main landing page for the fansite.
include 'header.php';
?>

<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Content -->
        <main class="lg:col-span-8">
            <div class="bg-white/75 dark:bg-gray-900/75 p-6 rounded-lg shadow-lg backdrop-blur-sm">
                <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-100 mb-4 pixel-font">Welcome to Fansite name goes here goes here!</h1>
                <p class="text-gray-700 dark:text-gray-300 mb-6">Your one-stop destination for all things Habbo retro. Dive back into the world of pixels and nostalgia. Join our community, get the latest news, and relive the golden age of Habbo!</p>
                
                <div class="h-64 bg-gray-300 rounded-lg mb-6 flex items-center justify-center bg-cover bg-center" style="background-image: url('https://placehold.co/800x300/667eea/ffffff?text=Habbo+Hotel+View');"></div>

                <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-4 border-b-2 border-gray-300 dark:border-gray-700 pb-2 pixel-font">Latest News</h2>
                
                <div class="bg-gray-100 dark:bg-gray-800/80 p-4 rounded-lg shadow-md mb-4 transition-transform transform hover:scale-105">
                    <h3 class="text-2xl font-bold text-blue-600 dark:text-blue-400 pixel-font"><a href="news.php" class="hover:underline">The Grand Re-opening!</a></h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Posted by <strong>Admin</strong> on June 27, 2025</p>
                    <p class="text-gray-700 dark:text-gray-300">We are thrilled to announce that radio links goes here is now officially open! We've been working hard behind the scenes to create a space for all retro lovers. Explore the site and join our Discord to say hi!</p>
                </div>

                <div class="bg-gray-100 dark:bg-gray-800/80 p-4 rounded-lg shadow-md mb-4 transition-transform transform hover:scale-105">
                    <h3 class="text-2xl font-bold text-blue-600 dark:text-blue-400 pixel-font"><a href="news.php" class="hover:underline">New Rares Coming Soon!</a></h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Posted by <strong>PixelMaster</strong> on June 26, 2025</p>
                    <p class="text-gray-700 dark:text-gray-300">Get your credits ready! We've got a new line of retro rares dropping next month. More details will be revealed next week.</p>
                </div>
            </div>
        </main>

        <!-- Sidebar -->
        <aside class="lg:col-span-4">
            <div class="bg-white/75 dark:bg-gray-900/75 p-6 rounded-lg shadow-lg backdrop-blur-sm sticky top-24">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4 border-b-2 border-gray-300 dark:border-gray-700 pb-2 pixel-font">Join our Discord</h2>
                <div class="mb-6">
                    <iframe id="discord-widget" src="https://discord.com/widget?id=YOUR DISCORD WIDGET ID GOES HERE&theme=dark" width="100%" height="300" allowtransparency="true" frameborder="0" sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>
                </div>

                <?php include 'radio_player.php'; ?>
                
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 my-4 border-b-2 border-gray-300 dark:border-gray-700 pb-2 pixel-font">Top Vortexians</h2>
                <!-- Top Users List -->
                <ul class="space-y-3">
                    <li class="flex items-center p-2 bg-gray-100 dark:bg-gray-800 rounded-md shadow-sm">
                        <img src="https://vortexhotel.co.uk/habbo-imaging/avatarimage?user=Admin&direction=2&head_direction=3&gesture=sml&action=wav" alt="Admin" class="w-12 h-12 mr-3 border-2 border-blue-400 rounded-full">
                        <div>
                            <p class="font-bold text-gray-800 dark:text-gray-200">Admin</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Site Founder</p>
                        </div>
                    </li>
                    <li class="flex items-center p-2 bg-gray-100 dark:bg-gray-800 rounded-md shadow-sm">
                        <img src="https://vortexhotel.co.uk/habbo-imaging/avatarimage?user=PixelMaster&direction=4&head_direction=3&gesture=sml&action=" alt="PixelMaster" class="w-12 h-12 mr-3 border-2 border-blue-400 rounded-full">
                         <div>
                            <p class="font-bold text-gray-800 dark:text-gray-200">PixelMaster</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Top Poster</p>
                        </div>
                    </li>
                     <li class="flex items-center p-2 bg-gray-100 dark:bg-gray-800 rounded-md shadow-sm">
                        <img src="https://vortexhotel.co.uk/habbo-imaging/avatarimage?user=FurniFanatic&direction=3&head_direction=2&gesture=sml&action=" alt="FurniFanatic" class="w-12 h-12 mr-3 border-2 border-blue-400 rounded-full">
                         <div>
                            <p class="font-bold text-gray-800 dark:text-gray-200">FurniFanatic</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Rare Collector</p>
                        </div>
                    </li>
                </ul>
            </div>
        </aside>
    </div>
</div>

<?php
include 'footer.php';
?>
