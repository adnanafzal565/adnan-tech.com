<?php

return [

    [
        'title' => 'Dashboard',
        'icon' => 'fa fa-chart-area',
        'url' => '/admin',
        'active' => 'admin',
        'permission' => 'admin.dashboard',
    ],

    [
        'title' => 'Apps',
        'icon' => 'fa fa-code',
        'url' => '/admin/apps',
        'active' => 'admin/apps',
        'permission' => 'admin.apps.index',
    ],

    [
        'title' => 'API Keys',
        'icon' => 'fa fa-key',
        'url' => '/admin/api_keys',
        'active' => 'admin/api_keys',
        'permission' => 'admin.api_keys.index',
    ],

    [
        'title' => 'Notifications',
        'icon' => 'fa fa-bell',
        'url' => '/admin/notifications',
        'active' => 'admin/notifications',
        'permission' => 'admin.notifications.index',
    ],

    [
        'title' => 'Cache Manager',
        'icon' => 'fas fa-bolt',
        'url' => '/admin/caches',
        'active' => 'admin/caches',
        'permission' => 'admin.caches.index',
    ],

    [
        'title' => 'Users',
        'icon' => 'fa fa-users',
        'url' => '/admin/users',
        'active' => 'admin/users',
        'permission' => 'admin.users.index',
    ],

    [
        'title' => 'Posts',
        'icon' => 'fa-solid fa-blog',
        'url' => '/admin/posts',
        'active' => 'admin/posts',
        'permission' => 'admin.posts.index',
    ],

    [
        'title' => 'Pages',
        'icon' => 'fa-regular fa-copy',
        'url' => '/admin/pages',
        'active' => 'admin/pages',
        'permission' => 'admin.pages.index',
    ],

    [
        'title' => 'Products',
        'icon' => 'fa-solid fa-cart-shopping',
        'url' => '/admin/products',
        'active' => 'admin/products',
        'permission' => 'admin.products.index',
    ],

    [
        'title' => 'File Manager',
        'icon' => 'fa-regular fa-file-lines',
        'url' => '/admin/files',
        'active' => 'admin/files',
        'permission' => 'admin.files.index',
    ],

    [
        'title' => 'Themes',
        'icon' => 'fa-solid fa-object-group',
        'url' => '/admin/themes',
        'active' => 'admin/themes',
        'permission' => 'admin.themes.index',
    ],

    [
        'title' => 'Menus',
        'icon' => 'fa-solid fa-bars',
        'url' => '/admin/menus',
        'active' => 'admin/menus',
        'permission' => 'admin.menus.index',
    ],

    [
        'title' => 'Messages',
        'icon' => 'fa fa-comments',
        'url' => '/admin/messages',
        'active' => 'admin/messages',
        'permission' => 'admin.messages.index',
        'badge' => 'message-notification-badge',
    ],

    [
        'title' => 'Contact us',
        'icon' => 'fa fa-comment',
        'url' => '/admin/contact_us',
        'active' => 'admin/contact_us',
        'permission' => 'admin.contact.index',
        'badge' => 'unread_contact_us',
    ],

    [
        'title' => 'Change Password',
        'icon' => 'fa fa-lock',
        'url' => '/admin/change_password',
        'active' => 'admin/change_password',
        'permission' => 'admin.change_password',
    ],

    [
        'title' => 'Settings',
        'icon' => 'fa fa-gear',
        'url' => '/admin/settings',
        'active' => 'admin/settings',
        'permission' => 'admin.settings.index',
    ],

];