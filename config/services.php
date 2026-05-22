<?php

return [

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'supabase' => [
        'url'         => env('https://jrgoxsxvccbcowqqrgxl.supabase.co'),
        'service_key' => env('eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImpyZ294c3h2Y2NiY293cXFyZ3hsIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzgxMTEyODIsImV4cCI6MjA5MzY4NzI4Mn0.4ZUI4YKsTSOZBGAbb25bQl1n4AX0U_f5GqW1JjoWw6s'),
    ],

];