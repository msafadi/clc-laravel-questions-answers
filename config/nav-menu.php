<?php

use App\Models\Role;
use App\Models\Tag;

return [
    [
        'title' => 'Dashboard',
        'route' => 'dashboard',
        'icon' => 'fas fa-tachometer-alt',
    ],
    [
        'title' => 'Tags',
        'route' => 'tags.index',
        'icon' => 'fas fa-tags',
        'ability' => ['view-any', Tag::class],
    ],
    [
        'title' => 'Roles',
        'route' => 'roles.index',
        'icon' => 'fas fa-user-shield',
        'ability' => ['view-any', Role::class],
    ],
];
