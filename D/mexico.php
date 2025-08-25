<?php

$allowedReferers = array(
"footfy.net",
"shohantv24.blogspot.com",
"livestreamlive24.blogspot.com",
"footfy.site",
"footfy.space",
"wxyz"

);

$referer = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) : '';

if (in_array($referer, $allowedReferers)) {
  // this refferer script created by Footfy Live

} else {

    header("Location: http://footfy.net/");
    exit();
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="no-referrer">
    <title>Play</title>
    <script disable-devtool-auto src='https://cdn.jsdelivr.net/npm/disable-devtool'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/shaka-player/4.7.1/shaka-player.ui.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/shaka-player/4.7.1/controls.min.css" crossorigin="anonymous">
    <style>
        body { background-color: #000; margin: 0; }
        .watermark {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 100px;
            opacity: 0.7;
            pointer-events: none;
        }
        img { position:relative; right:130; bottom:10; margin:auto auto; max-width:20%; max-height:20%; object-fit:contain; pointer-events:none; }
        .shaka-spinner-container { display:none; }
        .uc { pointer-events:none; }
        .shaka-current-time, .shaka-time-container { display: none; } /* Hide time display */
    </style>
</head>
<body>
    <div data-shaka-player-container style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
        <video autoplay data-shaka-player id="video" poster="https://footfy.net/wp-content/uploads/2025/04/Footfy-Live-Loading.webp" style="width:100%; height:100%"></video>
    </div>
    <script>


    </script>
</body>