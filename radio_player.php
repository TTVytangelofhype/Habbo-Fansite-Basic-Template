<?php
// radio_player.php - Reusable radio player component
?>
<!-- Custom Radio Player Section -->
<h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 my-4 border-b-2 border-gray-300 dark:border-gray-700 pb-2 pixel-font">Vortex Radio</h2>
<div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg shadow-inner">
    <!-- Main Player Controls -->
    <div class="flex items-center space-x-4">
        <button id="play-pause-btn" class="p-3 bg-blue-500 hover:bg-blue-600 text-white rounded-full focus:outline-none h-14 w-14 flex items-center justify-center flex-shrink-0">
            <i id="play-pause-icon" class="fa-solid fa-play text-xl"></i>
        </button>
        <div class="flex-grow overflow-hidden">
            <div class="font-bold text-sm text-blue-500 dark:text-blue-400">NOW PLAYING</div>
            <div id="song-title" class="font-semibold text-gray-700 dark:text-gray-200 truncate" title="Loading...">Loading...</div>
            <div id="song-artist" class="text-sm text-gray-500 dark:text-gray-400 truncate" title="Vortex FM">Vortex FM</div>
        </div>
        <div class="flex items-center space-x-2">
            <i class="fa-solid fa-volume-down text-gray-500 dark:text-gray-400"></i>
            <input id="volume-slider" type="range" min="0" max="1" step="0.01" value="0.75" class="w-24 custom-slider">
        </div>
    </div>
    <!-- Song History and Next Up -->
    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 text-xs space-y-2">
        <div class="flex items-center">
            <span class="font-bold text-gray-500 dark:text-gray-400 w-16">Last:</span>
            <span id="last-played" class="text-gray-600 dark:text-gray-300 truncate">...</span>
        </div>
        <div class="flex items-center">
            <span class="font-bold text-gray-500 dark:text-gray-400 w-16">Next:</span>
            <span id="next-up" class="text-gray-600 dark:text-gray-300 truncate">...</span>
        </div>
    </div>
</div>
