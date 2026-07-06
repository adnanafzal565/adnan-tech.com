<?php

namespace App\Helpers;

/**
 * 
 */
class Constants
{
    public const HOME = 'home';
    public const PROFILE = 'profile';
    public const LOGOUT = 'logout';
    public const LOGIN = 'login';
    public const REGISTER = 'register';
    public const PASSWORD_REQUEST = 'password.request';

    // Dashboard
    public const DASHBOARD = 'admin.dashboard';

    // Users
    public const USERS_INDEX = 'admin.users.index';
    public const USERS_CREATE = 'admin.users.create';
    public const USERS_EDIT = 'admin.users.edit';
    public const USERS_UPDATE = 'admin.users.update';
    public const USERS_DELETE = 'admin.users.destroy';
    public const USERS_BLOCK = 'admin.users.block';
    public const USERS_UNBLOCK = 'admin.users.unblock';
    public const USERS_TRASH = 'admin.users.trash';
    public const USERS_RESTORE = 'admin.users.restore';
    public const USERS_FORCE_DELETE = 'admin.users.force_delete';
    public const USERS_CHANGE_PASSWORD = 'admin.users.change_password';
    public const AUTHOR = 'author';

    // Posts
    public const POSTS_INDEX = 'admin.posts.index';
    public const POSTS_CREATE = 'admin.posts.create';
    public const POSTS_EDIT = 'admin.posts.edit';
    public const POSTS_UPDATE = 'admin.posts.update';
    public const POSTS_DELETE = 'admin.posts.destroy';
    public const POSTS_TRASH = 'admin.posts.trash';
    public const POSTS_RESTORE = 'admin.posts.restore';
    public const POSTS_FORCE_DELETE = 'admin.posts.force_delete';

    // Pages
    public const PAGES_INDEX = 'admin.pages.index';
    public const PAGES_SHOW = 'pages.show';
    public const PAGES_CREATE = 'admin.pages.create';
    public const PAGES_EDIT = 'admin.pages.edit';
    public const PAGES_UPDATE = 'admin.pages.update';
    public const PAGES_DELETE = 'admin.pages.destroy';

    // Files
    public const FILES_INDEX = 'admin.files.index';
    public const FILES_UPLOAD = 'admin.files.upload';
    public const FILES_DELETE = 'admin.files.destroy';

    // Themes
    public const THEMES_INDEX = 'admin.themes.index';
    public const THEMES_UPDATE = 'admin.themes.update';

    // Menus
    public const MENUS_INDEX = 'admin.menus.index';
    public const MENUS_CREATE = 'admin.menus.create';
    public const MENUS_ITEMS_CREATE = 'admin.menus.items.create';
    public const MENUS_ITEMS_FETCH = 'admin.menus.items.fetch';
    public const MENUS_ITEMS_UPDATE = 'admin.menus.items.update';
    public const MENUS_ITEMS_DELETE = 'admin.menus.items.destroy';
    public const MENUS_ITEMS_REORDER = 'admin.menus.items.reorder';

    // Messages
    public const MESSAGES_INDEX = 'admin.messages.index';
    public const MESSAGES_SEND = 'admin.messages.send';
    public const MESSAGES_FETCH = 'admin.messages.fetch';
    public const MESSAGES_CONTACTS = 'admin.messages.contacts';

    // Contact Us
    public const CONTACT_INDEX = 'admin.contact.index';
    public const CONTACT_DELETE = 'admin.contact.destroy';

    // Settings
    public const SETTINGS_INDEX = 'admin.settings.index';
    public const SETTINGS_UPDATE = 'admin.settings.update';

    // Categories & Tags
    public const CATEGORIES_CREATE = 'admin.categories.create';
    public const TAGS_CREATE = 'admin.tags.create';
}