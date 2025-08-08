<?php
// community.php - A page for community interaction, forums, and user spotlights.

include 'header.php';
?>

<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Content -->
        <main class="lg:col-span-8">
            <div class="bg-white bg-opacity-75 p-6 rounded-lg shadow-lg backdrop-blur-sm">
                <h1 class="text-4xl font-bold text-gray-800 mb-6 border-b-2 border-gray-300 pb-3 pixel-font">Community Hub</h1>
                
                <!-- Forum/Posts Section -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4 pixel-font">Recent Discussions</h2>
                    
                    <!-- Post Item -->
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md mb-4 flex items-start space-x-4">
                        <img src="https://www.habbo.com/habbo-imaging/avatarimage?user=PixelMaster&direction=4&head_direction=3&gesture=sml&action=" alt="PixelMaster" class="w-16 h-16 border-2 border-gray-300 rounded-full">
                        <div class="flex-1">
                            <h3 class="font-bold text-blue-600"><a href="#" class="hover:underline">What's the rarest furni you own?</a></h3>
                            <p class="text-sm text-gray-600">by <strong>PixelMaster</strong> - 2 hours ago</p>
                            <p class="text-gray-700 mt-2">Just curious what everyone's prized possession is. Mine is my original Throne. Show me what you've got!</p>
                        </div>
                        <div class="text-right">
                             <p class="font-bold text-lg">15</p>
                             <p class="text-sm text-gray-600">Replies</p>
                        </div>
                    </div>
                    
                    <!-- Post Item -->
                    <div class="bg-gray-100 p-4 rounded-lg shadow-md mb-4 flex items-start space-x-4">
                        <img src="https://www.habbo.com/habbo-imaging/avatarimage?user=FurniFanatic&direction=3&head_direction=2&gesture=sml&action=" alt="FurniFanatic" class="w-16 h-16 border-2 border-gray-300 rounded-full">
                        <div class="flex-1">
                            <h3 class="font-bold text-blue-600"><a href="#" class="hover:underline">Trading my Ice Cream Maker for a Holodice</a></h3>
                            <p class="text-sm text-gray-600">by <strong>FurniFanatic</strong> - 5 hours ago</p>
                            <p class="text-gray-700 mt-2">Looking for a straight swap. My ICM for your Holodice. Find me in the main trade room!</p>
                        </div>
                        <div class="text-right">
                             <p class="font-bold text-lg">4</p>
                             <p class="text-sm text-gray-600">Replies</p>
                        </div>
                    </div>

                     <button class="w-full bg-blue-500 text-white font-bold py-3 rounded-lg hover:bg-blue-600 transition-all pixel-font shadow-lg">Start a New Discussion</button>
                </div>
            </div>
        </main>

        <!-- Sidebar -->
        <aside class="lg:col-span-4">
            <div class="bg-white bg-opacity-75 p-6 rounded-lg shadow-lg backdrop-blur-sm sticky top-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b-2 border-gray-300 pb-2 pixel-font">User of the Week</h2>
                <!-- User of the week -->
                <div class="text-center p-4 bg-yellow-100 border-2 border-yellow-300 rounded-lg shadow-inner">
                    <img src="https://www.habbo.com/habbo-imaging/avatarimage?user=PixelMaster&direction=2&head_direction=3&gesture=sml&action=wav" alt="PixelMaster" class="w-24 h-24 mx-auto border-4 border-white rounded-full shadow-lg">
                    <h3 class="text-xl font-bold mt-3 text-yellow-800">PixelMaster</h3>
                    <p class="text-sm text-yellow-700">For being the most active and helpful member on our Discord this week!</p>
                </div>

                <h2 class="text-2xl font-bold text-gray-800 my-4 border-b-2 border-gray-300 pb-2 pixel-font">Top Vortexians</h2>
                <!-- Top Users List -->
                <ul class="space-y-3">
                    <li class="flex items-center p-2 bg-gray-100 rounded-md shadow-sm">
                        <img src="https://www.habbo.com/habbo-imaging/avatarimage?user=Admin&direction=2&head_direction=3" alt="Admin" class="w-12 h-12 mr-3 border-2 border-blue-400 rounded-full">
                        <div><p class="font-bold text-gray-800">Admin</p><p class="text-sm text-gray-600">Site Founder</p></div>
                    </li>
                    <li class="flex items-center p-2 bg-gray-100 rounded-md shadow-sm">
                        <img src="https://www.habbo.com/habbo-imaging/avatarimage?user=PixelMaster&direction=4&head_direction=3" alt="PixelMaster" class="w-12 h-12 mr-3 border-2 border-blue-400 rounded-full">
                         <div><p class="font-bold text-gray-800">PixelMaster</p><p class="text-sm text-gray-600">Top Poster</p></div>
                    </li>
                     <li class="flex items-center p-2 bg-gray-100 rounded-md shadow-sm">
                        <img src="https://www.habbo.com/habbo-imaging/avatarimage?user=FurniFanatic&direction=3&head_direction=2" alt="FurniFanatic" class="w-12 h-12 mr-3 border-2 border-blue-400 rounded-full">
                         <div><p class="font-bold text-gray-800">FurniFanatic</p><p class="text-sm text-gray-600">Rare Collector</p></div>
                    </li>
                </ul>
            </div>
        </aside>
    </div>
</div>

<?php
include 'footer.php';
?>
