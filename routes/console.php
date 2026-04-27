<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// OFF-PEAK: every 2 hours (10PM - 6AM) — light on server
Schedule::command('backup:run --only-db')->cron('0 22,0,2,4 * * *');

// PEAK HOURS: every 2 hours (6AM - 10PM) — catch business data
Schedule::command('backup:run --only-db')->cron('0 6,8,10,12,14,16,18,20 * * *');

// Monitor once a day at low traffic
Schedule::command('backup:monitor')->dailyAt('23:01');

// 12 backups/day × 7 days = 84
Schedule::command('backup:clean-keep --keep=84')->dailyAt('23:30');
