<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site Under Development
    |--------------------------------------------------------------------------
    |
    | When enabled, guests will see a development notice on the homepage and
    | must log in before browsing the rest of the public website.
    |
    */

    'under_development' => (bool) env('SITE_UNDER_DEVELOPMENT', true),

    /*
    |--------------------------------------------------------------------------
    | Alumni Profile Invite
    |--------------------------------------------------------------------------
    |
    | Masa berlaku link formulir profil alumni (hari).
    |
    */

    'alumni_profile_invite_days' => (int) env('ALUMNI_PROFILE_INVITE_DAYS', 90),

    /*
    |--------------------------------------------------------------------------
    | Alumni Self Registration Account
    |--------------------------------------------------------------------------
    |
    | Password sementara untuk akun pengguna yang dibuat otomatis setelah
    | alumni mendaftar melalui formulir publik.
    |
    */

    'alumni_self_registration_temp_password' => env('ALUMNI_SELF_REGISTRATION_TEMP_PASSWORD', '12345678'),

    /*
    |--------------------------------------------------------------------------
    | Alumni Profile Photo Upload
    |--------------------------------------------------------------------------
    |
    | Ukuran maksimum (px, sisi terpanjang) dan kualitas JPEG saat upload foto.
    |
    */

    'alumni_profile_photo_max_dimension' => (int) env('ALUMNI_PROFILE_PHOTO_MAX_DIMENSION', 1000),

    'alumni_profile_photo_quality' => (int) env('ALUMNI_PROFILE_PHOTO_QUALITY', 82),

];
