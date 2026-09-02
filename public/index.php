<?php

// split video in 1 minute each

// for file in *.mp4; do
//     mkdir -p "${file%.*}"
//     ffmpeg -i "$file" \
//         -map 0 \
//         -c copy \
//         -f segment \
//         -segment_time 60 \
//         -reset_timestamps 1 \
//         "${file%.*}/part_%03d.mp4"
// done

// compress video

// ffmpeg -i "admin 2.mov" \
// -c:v libx264 -crf 20 -preset medium \
// -c:a aac -b:a 192k \
// "admin 2.mp4"

// add subtitle

// ffmpeg -i "input.mp4" \
// -vf "subtitles=subtitles.srt:force_style='FontName=Arial,FontSize=16,PrimaryColour=&H00FFFFFF,BackColour=&H80000000,BorderStyle=4,Outline=0,Shadow=0,Alignment=2,MarginV=10'" \
// -c:v libx264 -crf 18 -preset medium \
// -c:a copy \
// output.mp4

// subtitles.srt

// 1
// 00:00:00,000 --> 00:00:02,000
// Line 1

// 2
// 00:00:02,000 --> 00:00:06,000
// Line 2

// 3
// 00:00:06,000 --> 00:00:11,000
// Line 3

# grip <- to preview README.md files: http://localhost:6419

// ln -s "$(pwd)/app/Modules/EmailRenderer/assets/js" "public/modules/EmailRenderer/js"
// ln -s "$(pwd)/app/Modules/EmailRenderer/assets/img" "public/modules/EmailRenderer/img"

// * * * * * /path/to/php /home/USERNAME/public_html/artisan queue:work --stop-when-empty

// convert instagram post images to 3840x2160 adding white background
// mkdir -p output
// for f in *.jpg; do
//     ffmpeg -i "$f" \
//     -vf "scale=3840:2160:force_original_aspect_ratio=decrease,pad=3840:2160:(ow-iw)/2:(oh-ih)/2:white" \
//     -q:v 2 \
//     "output/$f"
// done

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
