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

];
