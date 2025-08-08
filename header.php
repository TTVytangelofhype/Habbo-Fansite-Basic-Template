<?php
// header.php - The header file for the site.
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en" class="<?php if(isset($_COOKIE['color-theme']) && $_COOKIE['color-theme'] === 'dark') { echo 'dark'; } ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fansite Name Goes Here- Your Habbo Retro Fansite</title>
    
    <!-- Favicon links -->
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/icon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <meta name="theme-color" content="#ffffff">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    
    <script>
        // Prevents Flash of Unstyled Content for Dark Mode
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="bg-habbo font-sans text-gray-800 dark:text-gray-200 transition-colors duration-300">
    <header class="bg-white/75 dark:bg-gray-800/75 shadow-md backdrop-blur-sm sticky top-0 z-50">
        <nav x-data="{ open: false }" class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <a href="index.php" class="text-2xl font-bold text-blue-600 dark:text-blue-400 pixel-font">Fansite Name Goes Here</a>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-2">
                    <a href="index.php" class="text-gray-600 hover:text-blue-500 dark:text-gray-300 dark:hover:text-white px-3 py-2 rounded-md font-semibold">Home</a>
                    <a href="news.php" class="text-gray-600 hover:text-blue-500 dark:text-gray-300 dark:hover:text-white px-3 py-2 rounded-md font-semibold">News</a>
                    
                    <!-- Community Dropdown -->
                    <div @click.away="open = false" class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex flex-row items-center w-full px-3 py-2 rounded-md font-semibold text-left text-gray-600 hover:text-blue-500 dark:text-gray-300 dark:hover:text-white focus:outline-none">
                            <span>Community</span>
                            <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 w-full mt-2 origin-top-right rounded-md shadow-lg z-50 md:w-48">
                            <div class="px-2 py-2 bg-white rounded-md shadow dark:bg-gray-800">
                                <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none" href="jobs.php">Jobs</a>
                                <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none" href="timetable.php">Timetable</a>
                                <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none" href="team.php">Meet The Team</a>
                                <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none" href="leaderboard.php">Leaderboard</a>
                                 <a class="block px-4 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white dark:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none" href="contact.php">Contact Us</a>
                            </div>
                        </div>
                    </div>

                    <a href="rares.php" class="text-gray-600 hover:text-blue-500 dark:text-gray-300 dark:hover:text-white px-3 py-2 rounded-md font-semibold">Rare Guides</a>
                    
                    <!-- Dynamic Links based on Numerical Rank ID -->
                    <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                        <a href="profile.php" class="text-gray-600 hover:text-blue-500 dark:text-gray-300 dark:hover:text-white px-3 py-2 rounded-md font-semibold">Profile</a>
                        <?php if (isset($_SESSION['rank_id']) && $_SESSION['rank_id'] >= 4): ?>
                            <a href="admin.php" target="_blank" rel="noopener noreferrer" class="text-gray-600 hover:text-blue-500 dark:text-gray-300 dark:hover:text-white px-3 py-2 rounded-md font-semibold">Admin Panel</a>
                        <?php endif; ?>
                        <span class="text-gray-700 dark:text-gray-200 px-3 py-2 font-semibold">Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</span>
                        <a href="logout.php" class="text-gray-600 hover:text-blue-500 dark:text-gray-300 dark:hover:text-white px-3 py-2 rounded-md font-semibold">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="text-gray-600 hover:text-blue-500 dark:text-gray-300 dark:hover:text-white px-3 py-2 rounded-md font-semibold">Login</a>
                        <a href="register.php" class="text-gray-600 hover:text-blue-500 dark:text-gray-300 dark:hover:text-white px-3 py-2 rounded-md font-semibold">Register</a>
                    <?php endif; ?>

                    <button id="theme-toggle" type="button" class="ml-2 text-gray-500 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg text-sm p-2.5">
                        <svg id="theme-toggle-dark-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                        <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.121-3.536a1 1 0 011.414 0l.707.707a1 1 0 01-1.414 1.414l-.707-.707a1 1 0 010-1.414zM4.95 6.364a1 1 0 00-1.414 1.414l.707.707a1 1 0 001.414-1.414l-.707-.707zm12.728 0l.707-.707a1 1 0 00-1.414-1.414l-.707.707a1 1 0 101.414 1.414zM10 18a1 1 0 01-1-1v-1a1 1 0 112 0v1a1 1 0 01-1 1z"></path></svg>
                    </button>
                </div>
                
                <!-- Mobile Menu Button -->
                <button @click="open = !open" class="md:hidden flex items-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div :class="{'block': open, 'hidden': !open}" class="hidden md:hidden mt-3" id="mobile-menu">
                <a href="index.php" class="block py-2 px-4 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 rounded">Home</a>
                <a href="news.php" class="block py-2 px-4 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 rounded">News</a>
                <a href="jobs.php" class="block py-2 px-4 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 rounded">Jobs</a>
                <a href="timetable.php" class="block py-2 px-4 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 rounded">Timetable</a>
                <a href="meetheteam.php" class="block py-2 px-4 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 rounded">Meet The Team</a>
                <a href="leaderboard.php" class="block py-2 px-4 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 rounded">Leaderboard</a>
                <a href="contactus.php" class="block py-2 px-4 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 rounded">Contact Us</a>
                <a href="rares.php" class="block py-2 px-4 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 rounded">Rare Guides</a>
                
                <!-- Dynamic Mobile Links -->
                <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                    <a href="profile.php" class="block py-2 px-4 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 rounded">Profile</a>
                    <?php if (isset($_SESSION['rank_id']) && $_SESSION['rank_id'] >= 4): ?>
                        <a href="admin.php" target="_blank" rel="noopener noreferrer" class="block py-2 px-4 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 rounded">Admin Panel</a>
                    <?php endif; ?>
                    <a href="logout.php" class="block py-2 px-4 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 rounded">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="block py-2 px-4 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 rounded">Login</a>
                    <a href="register.php" class="block py-2 px-4 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 rounded">Register</a>
                <?php endif; ?>
                
                <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                <button id="theme-toggle-mobile" type="button" class="w-full flex justify-center items-center py-2.5 text-gray-500 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg text-sm">
                    <svg id="theme-toggle-dark-icon-mobile" class="w-5 h-5 hidden mr-2"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg id="theme-toggle-light-icon-mobile" class="w-5 h-5 hidden mr-2"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.121-3.536a1 1 0 011.414 0l.707.707a1 1 0 01-1.414 1.414l-.707-.707a1 1 0 010-1.414zM4.95 6.364a1 1 0 00-1.414 1.414l.707.707a1 1 0 001.414-1.414l-.707-.707zm12.728 0l.707-.707a1 1 0 00-1.414-1.414l-.707.707a1 1 0 101.414 1.414zM10 18a1 1 0 01-1-1v-1a1 1 0 112 0v1a1 1 0 01-1 1z"></path></svg>
                    <span>Toggle Theme</span>
                </button>
            </div>
        </nav>
        <!-- AlpineJS for dropdown functionality -->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    </header>
