<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fetch Videos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        label {
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }
        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            background-color: #f0f0f0;
            color: #333;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #0056b3;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #003f7f;
        }
        .result {
            margin-top: 20px;
        }
        .error {
            color: #e50914;
            font-weight: bold;
        }
        .video-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
            overflow-x: auto;
        }
        .video-table th, .video-table td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
            color: #333;
            word-wrap: break-word;
            word-break: break-word;
        }
        .video-table th {
            background-color: #0056b3;
            color: #fff;
        }
        .video-table td {
            display: flex;
            flex-direction: column;
        }
        .video-table a {
            color: #0056b3;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .video-table a:hover {
            color: #003f7f;
        }
        .button-container {
            display: flex;
            justify-content: flex-end;
            padding: 12px;
            background-color: #ffffff;
        }
        .button {
            background-color: #0056b3;
            color: #fff;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
            margin-left: 10px;
        }
        .button:hover {
            background-color: #003f7f;
        }
        @media (max-width: 600px) {
            .container {
                padding: 15px;
                margin: 20px auto;
            }
            h1 {
                font-size: 20px;
            }
            input[type="text"], input[type="submit"] {
                font-size: 14px;
                padding: 10px;
            }
            .button-container {
                flex-direction: column;
                align-items: center;
            }
            .button {
                margin: 10px 0;
            }
            .video-table th, .video-table td {
                font-size: 14px;
                padding: 8px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Fetch Videos</h1>
    <form method="get">
        <label for="url">URL:</label>
        <input type="text" id="url" name="url" required>
        <label for="license">License Key:</label>
        <input type="text" id="license" name="license" required>
        <input type="submit" value="Fetch Videos">
    </form>

    <div class="result">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['url']) && isset($_GET['license'])) {
            define('LICENSE_KEY', 'dbxjsk029jd');

            function validate_license($key) {
                return hash_equals(LICENSE_KEY, $key);
            }

            if (!validate_license($_GET['license'])) {
                echo '<p class="error">Invalid license</p>';
                exit;
            }

            $url = filter_var($_GET['url'], FILTER_SANITIZE_URL);

            if (filter_var($url, FILTER_VALIDATE_URL)) {
                if (strpos($url, 'xnxx.com') !== false) {
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); 
                    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
                    $content = curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);

                    if ($httpCode == 200 && $content !== false) {
                        $title = "";
                        if (preg_match("/<title>(.*?)<\/title>/is", $content, $matches)) {
                            $title = $matches[1];
                        }

                        $videoUrls = [];
                        if (preg_match_all("/html5player\.setVideoUrl(Low|High|HLS)\('([^']+)'\);/", $content, $matches)) {
                            $videoUrls = $matches;
                        }

                        if (count($videoUrls[2]) > 0) {
                            echo '<h2>Video Results</h2>';
                            for ($i = 0; $i < count($videoUrls[2]); $i++) {
                                $quality = strtolower($videoUrls[1][$i]);
                                $videoUrl = $videoUrls[2][$i];
                                echo '<table class="video-table">';
                                echo '<tr><th>Title</th></tr><tr><td>' . htmlspecialchars($title) . '</td></tr>';
                                echo '<tr><th>Quality</th></tr><tr><td>' . htmlspecialchars($quality) . '</td></tr>';
                                echo '<tr><th>URL</th></tr><tr><td><a href="' . htmlspecialchars($videoUrl) . '" target="_blank">' . htmlspecialchars($videoUrl) . '</a></td></tr>';
                                echo '</table>';
                                echo '<div class="button-container">';
                                echo '<button class="button copy-button" onclick="copyToClipboard(\'' . htmlspecialchars($videoUrl) . '\')"><i class="fas fa-copy"></i> Copy Link</button>';
                                echo '<button class="button download-button" onclick="downloadVideo(\'' . htmlspecialchars($videoUrl) . '\', \'' . htmlspecialchars($title) . '\', \'' . htmlspecialchars($quality) . '\')"><i class="fas fa-download"></i> Download</button>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p class="error">No MP4 or HLS videos found or error fetching video data.</p>';
                        }
                    } else {
                        echo '<p class="error">Error fetching content from URL</p>';
                    }
                } else {
                    echo '<p class="error">URL is not from xnxx.com</p>';
                }
            } else {
                echo '<p class="error">Invalid URL</p>';
            }
        }
        ?>
    </div>
</div>
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('Link copied to clipboard!');
        }, function(err) {
            alert('Failed to copy: ', err);
        });
    }

    function downloadVideo(url, title, quality) {
        fetch(url)
            .then(response => response.blob())
            .then(blob => {
                const downloadUrl = window.URL.createObjectURL(blob);
                const link = document.createElement('a');
                const sanitizedTitle = title.replace(/[<>:"\/\\|?*]+/g, ''); 
                const filename = `(@PowerSigma) ${sanitizedTitle} - ${quality}.mp4`;
                link.href = downloadUrl;
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                window.URL.revokeObjectURL(downloadUrl);
            })
            .catch(error => console.error('Error:', error));
    }
</script>
</body>
</html>
