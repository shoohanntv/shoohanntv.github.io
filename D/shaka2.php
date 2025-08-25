
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="description" content="LIVE">
  <meta name="author" content="GAME24X">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Game24x.xyz</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/shaka-player/4.7.6/shaka-player.ui.min.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/shaka-player/4.7.6/controls.min.css" crossorigin="anonymous">
  <link rel="stylesheet" href="dg.css">  
</head>
<body>
  <center>
    <video autoplay data-shaka-player id="video" style="width:100%; height:100%"></video>
  </center>

  <script>
    
const mpdUrl = 'https://ottb.live.cf.ww.aiv-cdn.net/lhr-nitro/live/clients/dash/enc/wf8usag51e/out/v1/bd3b0c314fff4bb1ab4693358f3cd2d3/cenc.mpd';
        const kid = 'ae26845bd33038a9c0774a0981007294';
        const key = '63ac662dde310cfb4cc6f9b43b34196d';

        let player;
        let ui;

        function initApp() {
            shaka.polyfill.installAll();

            shaka.Player.probeSupport().then(function() {
                const video = document.getElementById('video');
                player = new shaka.Player(video);

                // Attach the player to the window to make it easy to access in the console
                window.player = player;

                const drmConfig = {
                    drm: {
                        clearKeys: {
                            [kid]: key // Set Clear Key
                        }
                    }
                };
                player.configure(drmConfig);

                player.load(mpdUrl).then(function() {
                    console.log('The video has now been loaded!');
                }).catch(onPlayerError);

                initializeUI(video);
            }).catch(onPlayerError);
        }

        function initializeUI(video) {
            const container = document.querySelector('[data-shaka-player-container]');

            // Create UI elements with Shaka's default configuration
            ui = new shaka.ui.Overlay(player, container, video);
            ui.getControls(); // This loads the default controls

            // Set fullscreen button visibility if needed
            ui.getControls().setEnabled(true);
        }

        function onPlayerError(event) {
            console.error('Player error', event);
        }

        document.addEventListener('DOMContentLoaded', initApp);
  
  </script>
</body>
</html>