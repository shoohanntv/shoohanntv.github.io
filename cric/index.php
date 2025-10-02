<?php
header('Content-Type: text/html');

// Read M3U playlist
$m3uFile = 'https://crichd-playlist-byxfireflix.pages.dev/ALL.m3u'; // Path to your .m3u file
$lines = file($m3uFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$output = '';

$current = [];

// Parse the M3U file
foreach ($lines as $line) {
    if (strpos($line, '#EXTINF') === 0) {
        preg_match('/tvg-logo="(.*?)"/', $line, $logoMatch);
        $name = explode(',', $line)[1] ?? 'Unnamed';
        $current = [
            'name' => trim($name),
            'logo' => $logoMatch[1] ?? '',
            'url' => ''
        ];
    } elseif (preg_match('/^http/', $line)) {
        $current['url'] = trim($line);

        // Extract stream ID from URL
        preg_match('/([^\/]+\.m3u8)/', $current['url'], $idMatch);
        $streamId = $idMatch[1] ?? '';

        // Generate channel card HTML
        $output .= '<div class="col-6 col-md-3">';
        $output .= '<div class="channel-card" onclick="window.location.href=\'player.php?id=' . urlencode($streamId) . '\'">';
        $output .= '<img src="' . htmlspecialchars($current['logo']) . '" onerror="this.src=\'https://via.placeholder.com/150x130?text=No+Logo\';" alt="Channel Logo">';
        $output .= '<div class="channel-name">' . htmlspecialchars($current['name']) . '</div>';
        $output .= '</div></div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Footfy Live - Sports TV</title>
  <link rel="shortcut icon" href="https://footfy.net/wp-content/uploads/2024/09/Footfy-Logo-Final.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #121212;
      color: white;
    }

    body.light-mode {
      background-color: #f0f0f0;
      color: black;
    }

    .logo {
      text-align: center;
      padding: 20px;
    }

    .channel-card {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid red;
      border-radius: 10px;
      padding: 10px;
      transition: transform 0.2s ease-in-out;
      cursor: pointer;
    }

    .channel-card:hover {
      transform: scale(1.03);
    }

    .channel-card img {
      width: 100%;
      height: 130px;
      object-fit: contain;
      border-radius: 10px;
      background: white;
    }

    .channel-name {
      text-align: center;
      margin-top: 10px;
      font-size: 14px;
      font-weight: bold;
    }

    .toggle-btn {
      margin: 10px auto;
      display: block;
    }
  </style>
</head>
<body>
  <div class="logo text-center mb-4 border-bottom pb-3" style="border-color: #ff3c3c;">
    <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgn47Htl8rZkop10CXrSjkn7Y9zA07Zdh1athN4qyFMx7VQtvqTcaxYT6cEjUKytO-hOvJT3nbKuIJZsUAgbouV4CRSahlPAXnyFmolO3mhdZwXR0W0WlkXYXQIJn-X8pe0lUoVCUbA14neQbccB4yTO2zutHj1jSjt33Z7BylqbBQSU7e_vw2w1AK5pbvf/s600/logo.png"
      alt="Footfy Live Logo" height="80" class="mb-2">
    <h3 style="font-weight: bold; color: #ff3c3c;">CricHD <span style="color: white;">| by</span> Footfy Live</h3>
  </div>

  <div class="container">
    <input id="searchInput" type="text" class="form-control mb-3" placeholder="Search Channels...">
    <button class="btn btn-danger toggle-btn" id="toggleMode">Switch to Light Mode</button>
    <div id="channelList" class="row g-3">
      <?php echo $output; ?>
    </div>
  </div>

  <footer class="text-center mt-4 py-3 bg-danger text-white">
    &copy; 2025 Footfy Live. All rights reserved.
  </footer>

  <script>
    // Light/Dark mode toggle
    const toggleBtn = document.getElementById('toggleMode');
    toggleBtn.addEventListener('click', () => {
      document.body.classList.toggle('light-mode');
      toggleBtn.textContent = document.body.classList.contains('light-mode') 
        ? 'Switch to Dark Mode' 
        : 'Switch to Light Mode';
    });

    // Channel search
    document.getElementById('searchInput').addEventListener('input', function () {
      const searchValue = this.value.toLowerCase();
      document.querySelectorAll('.channel-card').forEach(card => {
        const name = card.querySelector('.channel-name').textContent.toLowerCase();
        card.parentElement.style.display = name.includes(searchValue) ? 'block' : 'none';
      });
    });

    // Telegram Promotion Overlay
    const telegramOverlay = document.createElement('div');
    telegramOverlay.style.position = 'fixed';
    telegramOverlay.style.bottom = '14px';
    telegramOverlay.style.right = '13px';
    telegramOverlay.style.zIndex = '9999';
    telegramOverlay.style.background = '#0088cc';
    telegramOverlay.style.padding = '8px 11px';
    telegramOverlay.style.borderRadius = '26px';
    telegramOverlay.style.display = 'flex';
    telegramOverlay.style.alignItems = 'center';
    telegramOverlay.style.boxShadow = '0 4px 8px rgba(0,0,0,0.3)';
    telegramOverlay.style.transition = 'all 0.3s ease';

    telegramOverlay.innerHTML = `
      <a href="https://t.me/+rfdcEXE1FHY4YTZl" target="_blank" style="display: flex; align-items: center; text-decoration: none; color: white;">
        <img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Telegram_logo.svg" alt="Telegram" style="width: 20px; height: 20px; margin-right: 8px;">
        <span style="font-weight: bold;">Join us on Telegram</span>
      </a>
    `;

    document.body.appendChild(telegramOverlay);
  </script>
</body>
</html>