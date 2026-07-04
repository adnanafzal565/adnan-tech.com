<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Laravel Boilerplate

A production-ready Laravel boilerplate to help you kickstart your next web application. It comes with a powerful admin panel and essential features required by most content management systems and business applications.

## Features

- User authentication
- Admin dashboard
- User management
- Blog posts
- Dynamic pages
- File manager
- Multiple frontend themes
- Dynamic menus
- Chat between admin and users
- Contact Us
- Website settings
- Responsive design

## Admin Panel

The admin dashboard allows you to manage your entire website from a single place.

### Dashboard
- Website overview
- Statistics and quick access to modules

### Users
- Add, edit, block, restore, and permanently delete users
- Manage user profiles

### Blog Posts
- Create, edit, publish, restore, and permanently delete blog posts

### Dynamic Pages
- Create and manage pages such as:
  - About Us
  - Privacy Policy
  - Terms & Conditions
  - Any custom page

### File Manager
- Upload files and images
- Organize uploaded files
- Reuse uploaded media across the application

### Themes
- Support for multiple frontend themes
- Easily switch between themes

### Menus
- Create dynamic menus
- Reorder menu items
- Build custom navigation

### Chat
- Built-in messaging system between administrators and users

### Contact Us
- View and manage messages submitted through the Contact Us form

### Settings
Manage application settings including:

- Website name
- Website logo
- Other general settings

## Requirements

- PHP 8.2+
- Laravel
- MySQL
- Composer

## Installation

```bash
git clone <repository-url>

cd <project-folder>

composer update

php artisan key:generate
```

Update your database credentials in `.env`.

Run migrations:

```bash
php artisan migrate
```

Run seeder:

```bash
php artisan db:seed
```

Create storage link:

```bash
php artisan storage:link
```

Start the development server:

```bash
php artisan serve
```

## Screenshots

### Dashboard

![Dashboard](screenshots/dashboard.png)

### Users

![Users](screenshots/edit-user.png)

### Posts

![Posts](screenshots/edit-post.png)

### Pages

![Pages](screenshots/edit-page.png)

### Chat

![Chat](screenshots/chat.png)

### Files Manager

![Files Manager](screenshots/files-manager.png)

### Menus

![Menus](screenshots/menus.png)

### Contact Us

![Contact Us](screenshots/contact-us-messages.png)

### Settings

![Settings](screenshots/settings.png)

### Theme 1

![Theme 1](screenshots/theme-1-home.png)

### Theme 2

![Theme 2](screenshots/theme-2-home.png)

### Theme 3

![Theme 3](screenshots/theme-3-home.png)

## Customization

Need additional features?

I provide Laravel development and customization services. If you need custom modules, API integrations, UI improvements, new themes, or any other functionality, feel free to contact me.

## Contributing

Pull requests and suggestions are welcome.

## License

This project is licensed under the MIT License.