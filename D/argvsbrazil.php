
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="no-referrer">
    <title>Footfy Live</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/shaka-player/4.7.12/controls.min.css" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/shaka-player/4.7.12/shaka-player.ui.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://api.shihabtv.xyz/drm/takerestream.css">
</head>
<body>
    <div data-shaka-player-container style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
        <video autoplay muted playsinline data-shaka-player id="video" poster="https://footfy.net/wp-content/uploads/2025/03/Loading-Poster.gif" style="width: 100%; height: 100%;"></video>
    </div>

    <script>
        const mpdUrl = 'https%3A%2F%2Ffsly.stream.peacocktv.com%2FContent%2FCMAF_OL1-CTR-4s-v2%2FLive%2Fchannel%28kvea%29%2Fmaster.mpd';
        const kid = 'ce7ab3022e753307997f58afe001bac4';
        const key = '72d631a66e635c60829a0fe7705516c1';

        let player;

        function initApp() {
            shaka.polyfill.installAll();

            shaka.Player.probeSupport().then(function() {
                const video = document.getElementById('video');
                player = new shaka.Player(video);

                window.player = player;

                const drmConfig = {
                    drm: {
                        clearKeys: {
                            [kid]: key
                        }
                    }
                };
                player.configure(drmConfig);

                player.load(mpdUrl).then(function() {
                    console.log('https://t.me/shihab_57!');
                    video.play().catch(error => console.error('Autoplay failed:', error));
                }).catch(onPlayerError);

                initializeUI(video);
            }).catch(onPlayerError);
        }

        function initializeUI(video) {
            const container = document.querySelector('[data-shaka-player-container]');
            const ui = new shaka.ui.Overlay(player, container, video);
            
            const uiConfig = {
                controlPanelElements: [
                    'play_pause',
                    'mute',                
                    'quality',
                  	'fullscreen',
                    'overflow_menu',
                  	'picture_in_picture'
                    
                ],
                overflowMenuButtons: [
                    'captions',
                    'playback_rate'
                ],
                seekBarColors: {
                    base: 'rgba(255, 255, 255, 0.3)',
                    buffered: 'rgba(255, 255, 255, 0.5)',
                    played: 'rgba(255, 0, 0, 0.8)'
                }
            };
            ui.configure(uiConfig);

            // Auto-select highest quality
            player.addEventListener('trackschanged', () => {
                const tracks = player.getVariantTracks();
                if (tracks.length > 0) {
                    player.selectVariantTrack(tracks[tracks.length - 1], true);
                }
            });

            ui.getControls().setEnabled(true);
        }

        function onPlayerError(event) {
            console.error('Player error', event);
        }

        document.addEventListener('DOMContentLoaded', function () {
            initApp();
            addDynamicLogo();
        });
    </script>
</body>
</html>
