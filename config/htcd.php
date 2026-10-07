<?php

return [
    'admin_path' => env('ADMIN_PATH', 'admin'),
    'default_admin_email' => env('ADMIN_EMAIL', 'admin@example.com'),
    'default_admin_password' => env('ADMIN_PASSWORD', '123456'),

    'list_table_columns' => [
        'author' => true,
        'status' => true,
        'date' => true,
    ],

    'admin_new_links' => [
        ['label' => 'admin.menu.news', 'route' => 'admin.news.create'],
        ['label' => 'admin.menu.pages', 'route' => 'admin.pages.create'],
        ['label' => 'admin.menu.announcements', 'route' => 'admin.announcements.create'],
        ['label' => 'admin.menu.events', 'route' => 'admin.events.create'],
        ['label' => 'admin.menu.programs', 'route' => 'admin.programs.create'],
        ['label' => 'admin.menu.documents', 'route' => 'admin.documents.create'],
        ['label' => 'admin.menu.library', 'route' => 'admin.library-items.create'],
        ['label' => 'admin.menu.galleries', 'route' => 'admin.galleries.create'],
        ['label' => 'admin.menu.media', 'route' => 'admin.media.index'],
    ],
];
