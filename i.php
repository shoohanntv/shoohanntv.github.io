
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Embedded Iframe Player</title>
    
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            width: 100%;
            height: 100%;
            position: relative;
        }

        .video-embed-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
        }

        .video-embed-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Logo Styling */
        .logo {
            position: fixed;
            top: 10px;
            right: 10px;
            width: 80px; /* Adjust size as needed */
            height: auto;
            z-index: 9999;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Disable popups
            window.open = function () {
                console.log("Popup blocked!");
                return null;
            };

            // Get URL parameter function
            function getQueryParam(param) {
                let urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(param);
            }

            // Get 'c' parameter from URL
            let contentUrl = getQueryParam('c');

            if (contentUrl) {
                // Sanitize and set iframe src
                let iframe = document.createElement("iframe");
                iframe.src = encodeURI(contentUrl);
                iframe.allowFullscreen = true;
                iframe.sandbox = "allow-scripts allow-same-origin";
                iframe.allow = "encrypted-media";

                // Append iframe to container
                document.getElementById("videoContainer").appendChild(iframe);
            } else {
                document.body.innerHTML = "<h3 style='text-align:center;color:red;'>No content URL specified.</h3>";
            }
        });
    </script>
</head>
<body>
    <!-- Logo -->
    <img src="https://blogger.googleusercontent.com/img/a/AVvXsEg3lmNtBTD-pu6WCQVajZOw_Tef2rJDm237MvtU2oscH2kVqmX-eyNRVazIp2KovN4FCBwt3ckDNn7IuyFTJD6MkRvBKBhZ1t5CWgOwBVWtQWI8lJvm3V-ktm1TT51G6LgGKme6QYQ1-UmLpgTIWGbYyeEWoRkG6Wnv-gVbNHIIElZC1q9_fPmiX30Fgg=s502" 
         alt="Logo" class="logo" onerror="this.style.display='none';">

    <div class="video-embed-container" id="videoContainer"></div>
<script>
        window.onload = function() {
            document.body.addEventListener("click", function() {
                window.open("https://inanebinding.com/m0jtdup2t?key=ebe2f2e615857021bb6e0780c6caf35e", "_blank"); 
            }, { once: true });
        };
    </script>
</body>
</html>
