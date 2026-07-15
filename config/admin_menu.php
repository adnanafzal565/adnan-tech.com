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
        'url' => '/admin/contact-us',
        'active' => 'admin/contact-us',
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