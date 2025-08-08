<?php include 'header.php'; ?>

<main class="container mx-auto px-4 py-8 flex justify-center">
    <div class="w-full max-w-lg">
        <div class="bg-white/75 dark:bg-gray-800/75 p-8 rounded-lg shadow-lg backdrop-blur-sm">
            <h1 class="pixel-font text-3xl font-bold text-gray-800 dark:text-white mb-6 text-center">Contact Us</h1>
            <p class="text-center text-gray-600 dark:text-gray-300 mb-6">Have a question or feedback? Send us a message!</p>
            
            <form action="#" method="post">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Your Name</label>
                    <input type="text" name="name" id="name" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Your Email</label>
                    <input type="email" name="email" id="email" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-6">
                    <label for="message" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Message</label>
                    <textarea name="message" id="message" rows="5" class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div class="flex items-center justify-center">
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">Send Message</button>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>