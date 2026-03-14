<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment('Stay hungry, stay foolish.');
})->purpose('Display an inspiring quote');


// Schedule::command('calendar:rolling')->dailyAt('00:05');
Schedule::command('calendar:rolling')->everyMinute();

