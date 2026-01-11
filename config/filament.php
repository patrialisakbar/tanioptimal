<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Filament Configuration
    |--------------------------------------------------------------------------
    |
    | Below you will find all of the configuration options for Filament,
    | including the default theme, locale & locale fallbacks, and more.
    |
    */

    'default_filesystem_disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),

    'timezone' => env('APP_TIMEZONE', 'UTC'),

];
