<?php
// footer.php - The footer file for the site.

// Ensure config is loaded if it hasn't been already.
if (!isset($mysqli)) {
    // Use a relative path that works from any file depth
    require_once __DIR__ . '/config.php';
}

// Set default fallback URLs
$radio_stream_url = 'https://radio links goes here.co.uk/listen/vortex_radio_/radio.mp3'; 
$radio_api_url = 'https://radio links goes here.co.uk/api/nowplaying_static/radio link with json goes here.json'; 

// Fetch the latest radio settings from the database
if ($settings_result = $mysqli->query("SELECT setting_key, setting_value FROM settings WHERE setting_key IN ('radio_stream_url', 'radio_api_url')")) {
    $settings = [];
    while ($row = $settings_result->fetch_assoc()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    // If database values exist, they will override the default ones.
    $radio_stream_url = $settings['radio_stream_url'] ?? $radio_stream_url;
    $radio_api_url = $settings['radio_api_url'] ?? $radio_api_url;
}
?>
    <footer class="bg-gray-800/80 text-white mt-12 py-6 backdrop-blur-sm">
        <div class="container mx-auto px-4 text-center">
            <p class="pixel-font">&copy; <?php echo date("Y"); ?> Fansite Name goes Here. All rights reserved.</p>
            <p class="text-sm mt-2 text-gray-300">Habbo is a registered trademark of Sulake Corporation Oy. This is a fan site and is not affiliated with Sulake.</p>
        </div>
    </footer>

    <!-- JavaScript for Mobile Menu, Dark Mode & Radio Player -->
    <script>
        // --- Mobile menu and Dark mode toggle logic ---
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
        // ... (rest of the dark mode logic)


        // --- Custom Radio Player Logic with Dynamic URLs ---
        document.addEventListener('DOMContentLoaded', (event) => {
            const radio = document.getElementById('radio-stream');
            const playPauseBtn = document.getElementById('play-pause-btn');
            const playPauseIcon = document.getElementById('play-pause-icon');
            const volumeSlider = document.getElementById('volume-slider');
            const songTitleEl = document.getElementById('song-title');
            const songArtistEl = document.getElementById('song-artist');
            const lastPlayedEl = document.getElementById('last-played');
            const nextUpEl = document.getElementById('next-up');

            if (!radio || !playPauseBtn) return;

            const azuraCastApiUrl = '<?php echo $radio_api_url; ?>';
            let currentStreamer = ''; 

            const fetchSongData = async () => {
                try {
                    const response = await fetch(azuraCastApiUrl);
                    if (!response.ok) throw new Error('Network response was not ok');
                    const data = await response.json();
                    
                    const nowPlayingSong = data.now_playing?.song;
                    songTitleEl.textContent = nowPlayingSong?.title || 'Unknown Title';

                    const newStreamer = data.live?.streamer_name || '';

                    if (newStreamer !== currentStreamer) {
                        currentStreamer = newStreamer; 
                        if (newStreamer && !radio.paused) {
                            radio.load(); 
                            radio.play().catch(e => console.error("Error playing after DJ change:", e));
                        }
                    }

                    if (data.live && data.live.is_live) {
                        songArtistEl.textContent = `DJ: ${data.live.streamer_name}`;
                    } else {
                        songArtistEl.textContent = nowPlayingSong?.artist || 'AutoDJ';
                    }

                    const lastPlayedSong = data.song_history?.[0]?.song?.text;
                    lastPlayedEl.textContent = lastPlayedSong || '...';

                    const nextSong = data.playing_next?.song?.text;
                    nextUpEl.textContent = nextSong || 'AutoDJ';

                } catch (error) {
                    console.error("Error fetching song data:", error);
                    songTitleEl.textContent = 'Song Info Unavailable';
                    songArtistEl.textContent = 'Please check the connection.';
                }
            };
            
            fetchSongData();
            setInterval(fetchSongData, 15000);

            // --- Player Control Logic ---
            if (volumeSlider) {
                 radio.volume = volumeSlider.value;
                 volumeSlider.addEventListener('input', (e) => {
                    radio.volume = e.target.value;
                });
            }

            playPauseBtn.addEventListener('click', () => {
                if (radio.paused) {
                    radio.play().catch(error => console.error("Audio playback failed:", error));
                } else {
                    radio.pause();
                }
            });

            radio.addEventListener('playing', () => {
                if(playPauseIcon) {
                    playPauseIcon.classList.remove('fa-play');
                    playPauseIcon.classList.add('fa-pause');
                }
            });

            radio.addEventListener('pause', () => {
                if(playPauseIcon) {
                    playPauseIcon.classList.remove('fa-pause');
                    playPauseIcon.classList.add('fa-play');
                }
            });
        });
    </script>
    
    <audio id="radio-stream" preload="none">
        <source src="<?php echo htmlspecialchars($radio_stream_url); ?>" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>

<?php
// The database connection is now closed here, at the very end of the page.
if (isset($mysqli) && $mysqli->ping()) {
    $mysqli->close();
}
?>
</body>
</html>
