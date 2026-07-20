-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 19, 2026 at 05:16 PM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `adnan-tech.com`
--

-- --------------------------------------------------------

--
-- Table structure for table `addons`
--

CREATE TABLE `addons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `installations` int(11) NOT NULL DEFAULT '0',
  `projects` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-active_theme', 's:7:\"default\";', 2099804788),
('laravel-cache-menu_Main menu', 'O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:3:{i:0;O:8:\"stdClass\":9:{s:2:\"id\";i:1;s:7:\"menu_id\";i:1;s:5:\"title\";s:4:\"Home\";s:3:\"url\";s:21:\"http://localhost:8000\";s:9:\"parent_id\";N;s:5:\"order\";i:1;s:10:\"created_at\";s:19:\"2026-07-19 07:06:29\";s:10:\"updated_at\";s:19:\"2026-07-19 07:06:29\";s:8:\"children\";a:0:{}}i:1;O:8:\"stdClass\":9:{s:2:\"id\";i:2;s:7:\"menu_id\";i:1;s:5:\"title\";s:5:\"About\";s:3:\"url\";s:27:\"http://localhost:8000/about\";s:9:\"parent_id\";N;s:5:\"order\";i:2;s:10:\"created_at\";s:19:\"2026-07-19 07:06:29\";s:10:\"updated_at\";s:19:\"2026-07-19 07:06:29\";s:8:\"children\";a:0:{}}i:2;O:8:\"stdClass\":9:{s:2:\"id\";i:3;s:7:\"menu_id\";i:1;s:5:\"title\";s:10:\"Contact us\";s:3:\"url\";s:29:\"http://localhost:8000/contact\";s:9:\"parent_id\";N;s:5:\"order\";i:3;s:10:\"created_at\";s:19:\"2026-07-19 07:06:29\";s:10:\"updated_at\";s:19:\"2026-07-19 07:06:29\";s:8:\"children\";a:0:{}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 2099805647),
('laravel-cache-page_doctor-appointment-booking-laravel', 'N;', 2099820555),
('laravel-cache-page_project-management-system', 'N;', 2099832520),
('laravel-cache-page_project-management-system-laravel', 'N;', 2099817646),
('laravel-cache-page_realtime-blog', 'N;', 2099832445),
('laravel-cache-page_test', 'N;', 2099805349),
('laravel-cache-post_doctor-appointment-booking-laravel', 'N;', 2099820555),
('laravel-cache-post_project-management-system', 'N;', 2099832520),
('laravel-cache-post_project-management-system-laravel', 'N;', 2099817646),
('laravel-cache-post_realtime-blog', 'N;', 2099832445),
('laravel-cache-post_test', 'N;', 2099805349),
('laravel-cache-posts_1', 'O:42:\"Illuminate\\Pagination\\LengthAwarePaginator\":12:{s:8:\"\0*\0items\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:10:\"\0*\0perPage\";i:15;s:14:\"\0*\0currentPage\";i:1;s:7:\"\0*\0path\";s:21:\"http://localhost:8000\";s:8:\"\0*\0query\";a:0:{}s:11:\"\0*\0fragment\";N;s:11:\"\0*\0pageName\";s:4:\"page\";s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:10:\"onEachSide\";i:3;s:10:\"\0*\0options\";a:2:{s:4:\"path\";s:21:\"http://localhost:8000\";s:8:\"pageName\";s:4:\"page\";}s:8:\"\0*\0total\";i:0;s:11:\"\0*\0lastPage\";i:1;}', 2099805647),
('laravel-cache-product_project-management-system-laravel', 'O:18:\"App\\Models\\Product\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"products\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:15:{s:2:\"id\";i:1;s:7:\"user_id\";i:1;s:5:\"title\";s:35:\"Project Management System - Laravel\";s:4:\"slug\";s:33:\"project-management-system-laravel\";s:3:\"sku\";s:11:\"PROD-000001\";s:5:\"price\";d:99;s:7:\"excerpt\";s:136:\"Internal tool for companies and individuals to manage their projects, tasks, timesheet, clients, finances, communication all in 1 place.\";s:7:\"content\";s:15:\"<div><br></div>\";s:10:\"categories\";s:37:\"[\"laravel\", \"nodejs\", \"php\", \"react\"]\";s:4:\"tags\";s:66:\"[\"laravel\", \"php\", \"nodejs\", \"react\", \"project management system\"]\";s:8:\"image_id\";i:18;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-19 07:20:21\";s:10:\"updated_at\";s:19:\"2026-07-19 09:50:15\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:15:{s:2:\"id\";i:1;s:7:\"user_id\";i:1;s:5:\"title\";s:35:\"Project Management System - Laravel\";s:4:\"slug\";s:33:\"project-management-system-laravel\";s:3:\"sku\";s:11:\"PROD-000001\";s:5:\"price\";d:99;s:7:\"excerpt\";s:136:\"Internal tool for companies and individuals to manage their projects, tasks, timesheet, clients, finances, communication all in 1 place.\";s:7:\"content\";s:15:\"<div><br></div>\";s:10:\"categories\";s:37:\"[\"laravel\", \"nodejs\", \"php\", \"react\"]\";s:4:\"tags\";s:66:\"[\"laravel\", \"php\", \"nodejs\", \"react\", \"project management system\"]\";s:8:\"image_id\";i:18;s:9:\"is_active\";i:1;s:10:\"created_at\";s:19:\"2026-07-19 07:20:21\";s:10:\"updated_at\";s:19:\"2026-07-19 09:50:15\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:3:{s:10:\"categories\";s:5:\"array\";s:4:\"tags\";s:5:\"array\";s:10:\"deleted_at\";s:8:\"datetime\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:8:\"sections\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:6:{i:0;O:25:\"App\\Models\\ProductSection\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:16:\"product_sections\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:23;s:10:\"product_id\";i:1;s:5:\"title\";s:4:\"Demo\";s:11:\"description\";s:363:\"Manage your projects and tasks, and let your clients see the progress from your website. See how system works, how you can give clients access to their dashboard, how they can respond to the queries etc.<br><br>You can create:<br><ol><li>Team Members</li><li>Clients</li></ol>You can assign tasks to team members and your clients will be able to see the progress.\";s:4:\"type\";s:15:\"text_with_video\";s:3:\"url\";s:41:\"https://www.youtube.com/embed/ZBvgHKQsjtY\";s:10:\"created_at\";s:19:\"2026-07-19 09:50:15\";s:10:\"updated_at\";s:19:\"2026-07-19 09:50:15\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:23;s:10:\"product_id\";i:1;s:5:\"title\";s:4:\"Demo\";s:11:\"description\";s:363:\"Manage your projects and tasks, and let your clients see the progress from your website. See how system works, how you can give clients access to their dashboard, how they can respond to the queries etc.<br><br>You can create:<br><ol><li>Team Members</li><li>Clients</li></ol>You can assign tasks to team members and your clients will be able to see the progress.\";s:4:\"type\";s:15:\"text_with_video\";s:3:\"url\";s:41:\"https://www.youtube.com/embed/ZBvgHKQsjtY\";s:10:\"created_at\";s:19:\"2026-07-19 09:50:15\";s:10:\"updated_at\";s:19:\"2026-07-19 09:50:15\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:10:\"product_id\";i:1;s:5:\"title\";i:2;s:11:\"description\";i:3;s:4:\"type\";i:4;s:3:\"url\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:25:\"App\\Models\\ProductSection\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:16:\"product_sections\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:24;s:10:\"product_id\";i:1;s:5:\"title\";s:12:\"Private Chat\";s:11:\"description\";s:447:\"Sometimes you need to share sensitive information like cPanel credentials, that you do not want to share with other team members. You can do that by simply having a private chat with that member.<br /><br /><ol><li>Team members can have a chat between them.</li><li>Only admins can have a chat with clients.</li></ol>Users you recently had a chat will appear at the top. Chat is realtime, so you won\'t have to refresh the page to see new messages.\";s:4:\"type\";s:15:\"text_with_video\";s:3:\"url\";s:41:\"https://www.youtube.com/embed/ugBR-raVhwY\";s:10:\"created_at\";s:19:\"2026-07-19 09:50:15\";s:10:\"updated_at\";s:19:\"2026-07-19 09:50:15\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:24;s:10:\"product_id\";i:1;s:5:\"title\";s:12:\"Private Chat\";s:11:\"description\";s:447:\"Sometimes you need to share sensitive information like cPanel credentials, that you do not want to share with other team members. You can do that by simply having a private chat with that member.<br /><br /><ol><li>Team members can have a chat between them.</li><li>Only admins can have a chat with clients.</li></ol>Users you recently had a chat will appear at the top. Chat is realtime, so you won\'t have to refresh the page to see new messages.\";s:4:\"type\";s:15:\"text_with_video\";s:3:\"url\";s:41:\"https://www.youtube.com/embed/ugBR-raVhwY\";s:10:\"created_at\";s:19:\"2026-07-19 09:50:15\";s:10:\"updated_at\";s:19:\"2026-07-19 09:50:15\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:10:\"product_id\";i:1;s:5:\"title\";i:2;s:11:\"description\";i:3;s:4:\"type\";i:4;s:3:\"url\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:25:\"App\\Models\\ProductSection\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:16:\"product_sections\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:25;s:10:\"product_id\";i:1;s:5:\"title\";s:8:\"Invoices\";s:11:\"description\";s:436:\"Let your clients pay you directly from your own website via invoices.<br /><br />Just follow the steps:<br /><br /><ol><li>You create an invoice and link it with your client account.</li><li>Client can login and see all the pending invoices.</li><li>Client can pay via Stripe.</li><li>For recurring payments, client\'s payment method is saved securely so they can make another payment without entering their card details again.</li></ol>\";s:4:\"type\";s:15:\"text_with_video\";s:3:\"url\";s:41:\"https://www.youtube.com/embed/vdioleU1OTc\";s:10:\"created_at\";s:19:\"2026-07-19 09:50:15\";s:10:\"updated_at\";s:19:\"2026-07-19 09:50:15\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:25;s:10:\"product_id\";i:1;s:5:\"title\";s:8:\"Invoices\";s:11:\"description\";s:436:\"Let your clients pay you directly from your own website via invoices.<br /><br />Just follow the steps:<br /><br /><ol><li>You create an invoice and link it with your client account.</li><li>Client can login and see all the pending invoices.</li><li>Client can pay via Stripe.</li><li>For recurring payments, client\'s payment method is saved securely so they can make another payment without entering their card details again.</li></ol>\";s:4:\"type\";s:15:\"text_with_video\";s:3:\"url\";s:41:\"https://www.youtube.com/embed/vdioleU1OTc\";s:10:\"created_at\";s:19:\"2026-07-19 09:50:15\";s:10:\"updated_at\";s:19:\"2026-07-19 09:50:15\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:10:\"product_id\";i:1;s:5:\"title\";i:2;s:11:\"description\";i:3;s:4:\"type\";i:4;s:3:\"url\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:25:\"App\\Models\\ProductSection\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:16:\"product_sections\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:26;s:10:\"product_id\";i:1;s:5:\"title\";s:8:\"Projects\";s:11:\"description\";s:190:\"You can create projects and assign the client to it. Once client login, he will be able to see all his projects and their updates. You can write complete description of the project under it.\";s:4:\"type\";s:15:\"text_with_image\";s:3:\"url\";s:53:\"http://localhost:8000/storage/files/6a5c989680334.png\";s:10:\"created_at\";s:19:\"2026-07-19 09:50:15\";s:10:\"updated_at\";s:19:\"2026-07-19 09:50:15\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:26;s:10:\"product_id\";i:1;s:5:\"title\";s:8:\"Projects\";s:11:\"description\";s:190:\"You can create projects and assign the client to it. Once client login, he will be able to see all his projects and their updates. You can write complete description of the project under it.\";s:4:\"type\";s:15:\"text_with_image\";s:3:\"url\";s:53:\"http://localhost:8000/storage/files/6a5c989680334.png\";s:10:\"created_at\";s:19:\"2026-07-19 09:50:15\";s:10:\"updated_at\";s:19:\"2026-07-19 09:50:15\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:10:\"product_id\";i:1;s:5:\"title\";i:2;s:11:\"description\";i:3;s:4:\"type\";i:4;s:3:\"url\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:25:\"App\\Models\\ProductSection\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:16:\"product_sections\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:27;s:10:\"product_id\";i:1;s:5:\"title\";s:5:\"Tasks\";s:11:\"description\";s:450:\"In each project, you can create multiple tasks. Whenever client ask for a new feature or a change, create a task so you won\'t have to remember. This will also help you not miss anything from client.<br /><br />Each task has a flow <i>todo -> progress -> done</i>.<br /><br />You can assign multiple team members to a task (including yourself) so they can collaborate on 1 place. Client and admin will also be able to see what\'s going on in this task.\";s:4:\"type\";s:15:\"text_with_image\";s:3:\"url\";s:53:\"http://localhost:8000/storage/files/6a5c9d1567c82.png\";s:10:\"created_at\";s:19:\"2026-07-19 09:50:15\";s:10:\"updated_at\";s:19:\"2026-07-19 09:50:15\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:27;s:10:\"product_id\";i:1;s:5:\"title\";s:5:\"Tasks\";s:11:\"description\";s:450:\"In each project, you can create multiple tasks. Whenever client ask for a new feature or a change, create a task so you won\'t have to remember. This will also help you not miss anything from client.<br /><br />Each task has a flow <i>todo -> progress -> done</i>.<br /><br />You can assign multiple team members to a task (including yourself) so they can collaborate on 1 place. Client and admin will also be able to see what\'s going on in this task.\";s:4:\"type\";s:15:\"text_with_image\";s:3:\"url\";s:53:\"http://localhost:8000/storage/files/6a5c9d1567c82.png\";s:10:\"created_at\";s:19:\"2026-07-19 09:50:15\";s:10:\"updated_at\";s:19:\"2026-07-19 09:50:15\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:10:\"product_id\";i:1;s:5:\"title\";i:2;s:11:\"description\";i:3;s:4:\"type\";i:4;s:3:\"url\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:5;O:25:\"App\\Models\\ProductSection\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:16:\"product_sections\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:28;s:10:\"product_id\";i:1;s:5:\"title\";s:22:\"Chat With Your Clients\";s:11:\"description\";s:297:\"You can discuss everything related to that task on each task\'s page. So all the communication related to that task stays under it, organized.<br /><br />You can send messages, attach documents, images, videos, you can send voice notes. You can mention a user to gain his attention to your message.\";s:4:\"type\";s:15:\"text_with_image\";s:3:\"url\";s:53:\"http://localhost:8000/storage/files/6a5c9d15758dc.png\";s:10:\"created_at\";s:19:\"2026-07-19 09:50:15\";s:10:\"updated_at\";s:19:\"2026-07-19 09:50:15\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:28;s:10:\"product_id\";i:1;s:5:\"title\";s:22:\"Chat With Your Clients\";s:11:\"description\";s:297:\"You can discuss everything related to that task on each task\'s page. So all the communication related to that task stays under it, organized.<br /><br />You can send messages, attach documents, images, videos, you can send voice notes. You can mention a user to gain his attention to your message.\";s:4:\"type\";s:15:\"text_with_image\";s:3:\"url\";s:53:\"http://localhost:8000/storage/files/6a5c9d15758dc.png\";s:10:\"created_at\";s:19:\"2026-07-19 09:50:15\";s:10:\"updated_at\";s:19:\"2026-07-19 09:50:15\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:10:\"product_id\";i:1;s:5:\"title\";i:2;s:11:\"description\";i:3;s:4:\"type\";i:4;s:3:\"url\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:11:{i:0;s:7:\"user_id\";i:1;s:5:\"title\";i:2;s:4:\"slug\";i:3;s:3:\"sku\";i:4;s:5:\"price\";i:5;s:7:\"excerpt\";i:6;s:7:\"content\";i:7;s:10:\"categories\";i:8;s:4:\"tags\";i:9;s:8:\"image_id\";i:10;s:9:\"is_active\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}', 2099814618),
('laravel-cache-product_test', 'N;', 2099805349),
('laravel-cache-title', 's:10:\"Adnan Tech\";', 2099819685);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'laravel', '2026-07-19 02:18:22', '2026-07-19 02:18:22'),
(2, 'php', '2026-07-19 02:18:25', '2026-07-19 02:18:25'),
(3, 'react', '2026-07-19 02:18:33', '2026-07-19 02:18:33'),
(4, 'nodejs', '2026-07-19 02:18:38', '2026-07-19 02:18:38');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` enum('public','private') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'public',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `name`, `file_path`, `alt`, `caption`, `description`, `type`, `created_at`, `updated_at`) VALUES
(33, 'add-task.png', 'files/2026/6a5ca6a77c676.png', NULL, NULL, NULL, 'public', '2026-07-19 05:27:51', '2026-07-19 05:27:51'),
(34, 'banner.png', 'files/2026/6a5ca6a7854d3.png', NULL, NULL, NULL, 'public', '2026-07-19 05:27:51', '2026-07-19 05:27:51'),
(35, 'dashboard.png', 'files/2026/6a5ca6a786338.png', NULL, NULL, NULL, 'public', '2026-07-19 05:27:51', '2026-07-19 05:27:51'),
(36, 'file-manager.png', 'files/2026/6a5ca6a7870d5.png', NULL, NULL, NULL, 'public', '2026-07-19 05:27:51', '2026-07-19 05:27:51'),
(37, 'financial-ledger.png', 'files/2026/6a5ca6a787c19.png', NULL, NULL, NULL, 'public', '2026-07-19 05:27:51', '2026-07-19 05:27:51'),
(38, 'invoice-detail.png', 'files/2026/6a5ca6a788530.png', NULL, NULL, NULL, 'public', '2026-07-19 05:27:51', '2026-07-19 05:27:51'),
(39, 'invoices.png', 'files/2026/6a5ca6a789ed1.png', NULL, NULL, NULL, 'public', '2026-07-19 05:27:51', '2026-07-19 05:27:51'),
(40, 'project-detail.png', 'files/2026/6a5ca6a78ae34.png', NULL, NULL, NULL, 'public', '2026-07-19 05:27:51', '2026-07-19 05:27:51'),
(41, 'screenshots.png', 'files/2026/6a5ca6a78b980.png', NULL, NULL, NULL, 'public', '2026-07-19 05:27:51', '2026-07-19 05:27:51'),
(42, 'search-everything.png', 'files/2026/6a5ca6a78c6cd.png', NULL, NULL, NULL, 'public', '2026-07-19 05:27:51', '2026-07-19 05:27:51'),
(43, 'send-message.png', 'files/2026/6a5ca6a78d260.png', NULL, NULL, NULL, 'public', '2026-07-19 05:27:51', '2026-07-19 05:27:51'),
(44, 'send-reminder.png', 'files/2026/6a5ca6a78dadb.png', NULL, NULL, NULL, 'public', '2026-07-19 05:27:51', '2026-07-19 05:27:51'),
(45, 'time-tracking-screen.png', 'files/2026/6a5ca6a78e886.png', NULL, NULL, NULL, 'public', '2026-07-19 05:27:51', '2026-07-19 05:27:51'),
(46, 'timer-sessions.png', 'files/2026/6a5ca6a78efd2.png', NULL, NULL, NULL, 'public', '2026-07-19 05:27:51', '2026-07-19 05:27:51'),
(47, 'total-hours.png', 'files/2026/6a5ca6a78fa80.png', NULL, NULL, NULL, 'public', '2026-07-19 05:27:51', '2026-07-19 05:27:51'),
(48, 'typing.png', 'files/2026/6a5ca6a7902cf.png', NULL, NULL, NULL, 'public', '2026-07-19 05:27:51', '2026-07-19 05:27:51'),
(49, 'banner.png', 'files/2026/6a5cacd95eecb.png', NULL, NULL, NULL, 'public', '2026-07-19 05:54:17', '2026-07-19 05:54:17'),
(50, 'Chat-activity.png', 'files/2026/6a5cacd967707.png', NULL, NULL, NULL, 'public', '2026-07-19 05:54:17', '2026-07-19 05:54:17'),
(51, 'Contacts-list.png', 'files/2026/6a5cacd967fdf.png', NULL, NULL, NULL, 'public', '2026-07-19 05:54:17', '2026-07-19 05:54:17'),
(52, 'create-group.png', 'files/2026/6a5cacd9688d3.png', NULL, NULL, NULL, 'public', '2026-07-19 05:54:17', '2026-07-19 05:54:17'),
(53, 'Group-message.png', 'files/2026/6a5cacd969051.png', NULL, NULL, NULL, 'public', '2026-07-19 05:54:17', '2026-07-19 05:54:17'),
(54, 'Groups-list.png', 'files/2026/6a5cacd9698e6.png', NULL, NULL, NULL, 'public', '2026-07-19 05:54:17', '2026-07-19 05:54:17'),
(55, 'My-profile.png', 'files/2026/6a5cacd96a33b.png', NULL, NULL, NULL, 'public', '2026-07-19 05:54:17', '2026-07-19 05:54:17'),
(56, 'Permissions.png', 'files/2026/6a5cacd96aec9.png', NULL, NULL, NULL, 'public', '2026-07-19 05:54:17', '2026-07-19 05:54:17'),
(57, 'Profile-updated.png', 'files/2026/6a5cacd96b690.png', NULL, NULL, NULL, 'public', '2026-07-19 05:54:17', '2026-07-19 05:54:17'),
(58, 'Register.png', 'files/2026/6a5cacd96bde7.png', NULL, NULL, NULL, 'public', '2026-07-19 05:54:17', '2026-07-19 05:54:17'),
(59, 'Select-contacts-to-add-in-list.png', 'files/2026/6a5cacd96cac3.png', NULL, NULL, NULL, 'public', '2026-07-19 05:54:17', '2026-07-19 05:54:17'),
(60, 'Share-status-or-story.png', 'files/2026/6a5cacd96d2ad.png', NULL, NULL, NULL, 'public', '2026-07-19 05:54:17', '2026-07-19 05:54:17'),
(61, 'Welcome.png', 'files/2026/6a5cacd96ddb3.png', NULL, NULL, NULL, 'public', '2026-07-19 05:54:17', '2026-07-19 05:54:17'),
(62, 'banner.jpg', 'files/2026/6a5cacee4df57.jpg', NULL, NULL, NULL, 'public', '2026-07-19 05:54:38', '2026-07-19 05:54:38'),
(63, 'appointment.png', 'files/2026/6a5cacf861003.png', NULL, NULL, NULL, 'public', '2026-07-19 05:54:48', '2026-07-19 05:54:48'),
(64, 'banner.png', 'files/2026/6a5cacf866623.png', NULL, NULL, NULL, 'public', '2026-07-19 05:54:48', '2026-07-19 05:54:48'),
(65, 'banner.png', 'files/2026/6a5cad01e2e0c.png', NULL, NULL, NULL, 'public', '2026-07-19 05:54:57', '2026-07-19 05:54:57'),
(66, 'banner.png', 'files/2026/6a5caf08a7035.png', NULL, NULL, NULL, 'public', '2026-07-19 06:03:36', '2026-07-19 06:03:36'),
(67, 'banner.png', 'files/2026/6a5caf1661766.png', NULL, NULL, NULL, 'public', '2026-07-19 06:03:50', '2026-07-19 06:03:50'),
(68, 'banner.jpg', 'files/2026/6a5caf211d109.jpg', NULL, NULL, NULL, 'public', '2026-07-19 06:04:01', '2026-07-19 06:04:01'),
(69, 'banner.jpg', 'files/2026/6a5caf33be774.jpg', NULL, NULL, NULL, 'public', '2026-07-19 06:04:19', '2026-07-19 06:04:19'),
(70, 'banner.png', 'files/2026/6a5caf6dbb618.png', NULL, NULL, NULL, 'public', '2026-07-19 06:05:17', '2026-07-19 06:05:17'),
(71, 'Application-status-change.png', 'files/2026/6a5caf78d73c8.png', NULL, NULL, NULL, 'public', '2026-07-19 06:05:28', '2026-07-19 06:05:28'),
(72, 'banner.png', 'files/2026/6a5caf78e015e.png', NULL, NULL, NULL, 'public', '2026-07-19 06:05:28', '2026-07-19 06:05:28'),
(73, 'Job-detail.png', 'files/2026/6a5caf78e0e20.png', NULL, NULL, NULL, 'public', '2026-07-19 06:05:28', '2026-07-19 06:05:28'),
(74, 'Job-listing.png', 'files/2026/6a5caf78e1a27.png', NULL, NULL, NULL, 'public', '2026-07-19 06:05:28', '2026-07-19 06:05:28'),
(75, 'Post-job.png', 'files/2026/6a5caf78e25f0.png', NULL, NULL, NULL, 'public', '2026-07-19 06:05:28', '2026-07-19 06:05:28'),
(76, 'Recruiter-uploaded-jobs.png', 'files/2026/6a5caf78e30c4.png', NULL, NULL, NULL, 'public', '2026-07-19 06:05:28', '2026-07-19 06:05:28'),
(77, 'banner.jpg', 'files/2026/6a5caf85bbe51.jpg', NULL, NULL, NULL, 'public', '2026-07-19 06:05:41', '2026-07-19 06:05:41'),
(78, 'banner.jpg', 'files/2026/6a5cafbe93260.jpg', NULL, NULL, NULL, 'public', '2026-07-19 06:06:38', '2026-07-19 06:06:38'),
(79, 'banner.jpg', 'files/2026/6a5cafcc26c6e.jpg', NULL, NULL, NULL, 'public', '2026-07-19 06:06:52', '2026-07-19 06:06:52'),
(80, 'banner.jpg', 'files/2026/6a5cafd918900.jpg', NULL, NULL, NULL, 'public', '2026-07-19 06:07:05', '2026-07-19 06:07:05'),
(81, 'add-task.png', 'files/2026/6a5cafe6651e7.png', NULL, NULL, NULL, 'public', '2026-07-19 06:07:18', '2026-07-19 06:07:18'),
(82, 'banner.png', 'files/2026/6a5cafe66d86e.png', NULL, NULL, NULL, 'public', '2026-07-19 06:07:18', '2026-07-19 06:07:18'),
(83, 'dashboard.png', 'files/2026/6a5cafe66eaf1.png', NULL, NULL, NULL, 'public', '2026-07-19 06:07:18', '2026-07-19 06:07:18'),
(84, 'file-manager.png', 'files/2026/6a5cafe66fb64.png', NULL, NULL, NULL, 'public', '2026-07-19 06:07:18', '2026-07-19 06:07:18'),
(85, 'financial-ledger.png', 'files/2026/6a5cafe670429.png', NULL, NULL, NULL, 'public', '2026-07-19 06:07:18', '2026-07-19 06:07:18'),
(86, 'invoice-detail.png', 'files/2026/6a5cafe6711bd.png', NULL, NULL, NULL, 'public', '2026-07-19 06:07:18', '2026-07-19 06:07:18'),
(87, 'invoices.png', 'files/2026/6a5cafe672e4b.png', NULL, NULL, NULL, 'public', '2026-07-19 06:07:18', '2026-07-19 06:07:18'),
(89, 'project-detail.png', 'files/2026/6a5cafe6744ab.png', NULL, NULL, NULL, 'public', '2026-07-19 06:07:18', '2026-07-19 06:07:18'),
(90, 'screenshots.png', 'files/2026/6a5cafe674d9e.png', NULL, NULL, NULL, 'public', '2026-07-19 06:07:18', '2026-07-19 06:07:18'),
(91, 'search-everything.png', 'files/2026/6a5cafe675dfa.png', NULL, NULL, NULL, 'public', '2026-07-19 06:07:18', '2026-07-19 06:07:18'),
(92, 'send-message.png', 'files/2026/6a5cafe676c4a.png', NULL, NULL, NULL, 'public', '2026-07-19 06:07:18', '2026-07-19 06:07:18'),
(93, 'send-reminder.png', 'files/2026/6a5cafe6779b3.png', NULL, NULL, NULL, 'public', '2026-07-19 06:07:18', '2026-07-19 06:07:18'),
(94, 'time-tracking-screen.png', 'files/2026/6a5cafe678a90.png', NULL, NULL, NULL, 'public', '2026-07-19 06:07:18', '2026-07-19 06:07:18'),
(95, 'timer-sessions.png', 'files/2026/6a5cafe679314.png', NULL, NULL, NULL, 'public', '2026-07-19 06:07:18', '2026-07-19 06:07:18'),
(96, 'total-hours.png', 'files/2026/6a5cafe679a7b.png', NULL, NULL, NULL, 'public', '2026-07-19 06:07:18', '2026-07-19 06:07:18'),
(97, 'typing.png', 'files/2026/6a5cafe67a1bf.png', NULL, NULL, NULL, 'public', '2026-07-19 06:07:18', '2026-07-19 06:07:18'),
(98, 'banner.jpg', 'files/2026/6a5caffc26edf.jpg', NULL, NULL, NULL, 'public', '2026-07-19 06:07:40', '2026-07-19 06:07:40'),
(99, 'banner.jpg', 'files/2026/6a5cb04f78377.jpg', NULL, NULL, NULL, 'public', '2026-07-19 06:09:03', '2026-07-19 06:09:03'),
(100, 'banner.png', 'files/2026/6a5cb092e4c74.png', NULL, NULL, NULL, 'public', '2026-07-19 06:10:10', '2026-07-19 06:10:10'),
(101, 'banner.jpg', 'files/2026/6a5cb09e08622.jpg', NULL, NULL, NULL, 'public', '2026-07-19 06:10:22', '2026-07-19 06:10:22'),
(102, 'banner.png', 'files/2026/6a5cb0ad1751a.png', NULL, NULL, NULL, 'public', '2026-07-19 06:10:37', '2026-07-19 06:10:37'),
(103, 'banner.jpg', 'files/2026/6a5cb0b8742c2.jpg', NULL, NULL, NULL, 'public', '2026-07-19 06:10:48', '2026-07-19 06:10:48'),
(104, 'edit-video.png', 'files/2026/6a5cb0b87ca00.png', NULL, NULL, NULL, 'public', '2026-07-19 06:10:48', '2026-07-19 06:10:48'),
(105, 'history.png', 'files/2026/6a5cb0b87d77e.png', NULL, NULL, NULL, 'public', '2026-07-19 06:10:48', '2026-07-19 06:10:48'),
(106, 'home.png', 'files/2026/6a5cb0b87e08b.png', NULL, NULL, NULL, 'public', '2026-07-19 06:10:48', '2026-07-19 06:10:48'),
(107, 'login.png', 'files/2026/6a5cb0b87ea7b.png', NULL, NULL, NULL, 'public', '2026-07-19 06:10:48', '2026-07-19 06:10:48'),
(108, 'logout.png', 'files/2026/6a5cb0b87f3a8.png', NULL, NULL, NULL, 'public', '2026-07-19 06:10:48', '2026-07-19 06:10:48'),
(109, 'my-channel.png', 'files/2026/6a5cb0b87fc90.png', NULL, NULL, NULL, 'public', '2026-07-19 06:10:48', '2026-07-19 06:10:48'),
(110, 'my-videos.png', 'files/2026/6a5cb0b880d78.png', NULL, NULL, NULL, 'public', '2026-07-19 06:10:48', '2026-07-19 06:10:48'),
(111, 'notifications.png', 'files/2026/6a5cb0b881777.png', NULL, NULL, NULL, 'public', '2026-07-19 06:10:48', '2026-07-19 06:10:48'),
(112, 'playlists.png', 'files/2026/6a5cb0b882052.png', NULL, NULL, NULL, 'public', '2026-07-19 06:10:48', '2026-07-19 06:10:48'),
(113, 'register.png', 'files/2026/6a5cb0b882fab.png', NULL, NULL, NULL, 'public', '2026-07-19 06:10:48', '2026-07-19 06:10:48'),
(114, 'search.png', 'files/2026/6a5cb0b8837b0.png', NULL, NULL, NULL, 'public', '2026-07-19 06:10:48', '2026-07-19 06:10:48'),
(115, 'settings.png', 'files/2026/6a5cb0b884204.png', NULL, NULL, NULL, 'public', '2026-07-19 06:10:48', '2026-07-19 06:10:48'),
(116, 'subscribed-channels.png', 'files/2026/6a5cb0b884972.png', NULL, NULL, NULL, 'public', '2026-07-19 06:10:48', '2026-07-19 06:10:48'),
(117, 'video-detail.png', 'files/2026/6a5cb0b884f70.png', NULL, NULL, NULL, 'public', '2026-07-19 06:10:48', '2026-07-19 06:10:48');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Main menu', '2026-07-19 02:06:29', '2026-07-19 02:06:29');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `title`, `url`, `parent_id`, `order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Home', 'http://localhost:8000', NULL, 1, '2026-07-19 02:06:29', '2026-07-19 02:06:29'),
(2, 1, 'About', 'http://localhost:8000/about', NULL, 2, '2026-07-19 02:06:29', '2026-07-19 02:06:29'),
(3, 1, 'Contact us', 'http://localhost:8000/contact', NULL, 3, '2026-07-19 02:06:29', '2026-07-19 02:06:29');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci,
  `sender_id` bigint(20) UNSIGNED DEFAULT NULL,
  `receiver_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_attachments`
--

CREATE TABLE `message_attachments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `path` text COLLATE utf8mb4_unicode_ci,
  `size` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_07_26_033315_create_personal_access_tokens_table', 1),
(5, '2025_07_26_033636_create_settings_table', 1),
(6, '2025_07_26_092809_create_messages_table', 1),
(7, '2025_07_26_092822_create_message_attachments_table', 1),
(8, '2025_07_26_093522_create_notifications_table', 1),
(9, '2025_07_26_222358_create_posts_table', 1),
(10, '2025_07_26_225506_create_categories_table', 1),
(11, '2025_07_26_232109_create_tags_table', 1),
(12, '2025_07_26_234026_create_files_table', 1),
(13, '2025_07_30_004551_create_menus_table', 1),
(14, '2025_07_30_004555_create_menu_items_table', 1),
(15, '2025_08_02_020658_create_pages_table', 1),
(16, '2025_08_03_231801_create_contact_us_table', 1),
(17, '2026_03_19_110258_create_addons_table', 1),
(18, '2026_07_01_211948_create_route_permissions_table', 1),
(19, '2026_07_04_003440_create_oauth_auth_codes_table', 1),
(20, '2026_07_04_003441_create_oauth_access_tokens_table', 1),
(21, '2026_07_04_003442_create_oauth_refresh_tokens_table', 1),
(22, '2026_07_04_003443_create_oauth_clients_table', 1),
(23, '2026_07_04_003444_create_oauth_device_codes_table', 1),
(24, '2026_07_17_025620_create_products_table', 1),
(25, '2026_07_19_080036_create_product_sections_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `table_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect_uris` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `grant_types` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_device_codes`
--

CREATE TABLE `oauth_device_codes` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_code` char(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `user_approved_at` datetime DEFAULT NULL,
  `last_polled_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `user_id`, `title`, `slug`, `keywords`, `excerpt`, `content`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Home', '/', NULL, NULL, '', 1, '2026-07-19 02:06:29', '2026-07-19 02:06:29'),
(2, 1, 'About', 'about', NULL, NULL, '<section class=\"about-us\"><h1>About Us</h1><p>Welcome! I\'m a passionate web developer with over <strong>8 years of experience</strong> building modern, fast, and reliable web applications. Throughout my career, I\'ve worked on projects of all sizes, helping businesses and individuals turn their ideas into functional, scalable solutions.</p><p>In addition to developing this platform, I also work as a <strong>freelance web developer</strong>. Whether you need a business website, custom web application, API integration, bug fixes, performance optimization, or ongoing maintenance, I\'d be happy to help.</p><p>If you\'re using this project and need features tailored to your specific requirements, I also offer <strong>custom development and customization services</strong>. From small enhancements to completely new modules, I can customize the project to match your workflow and business needs.</p><p>Thank you for visiting, and I look forward to working with you!</p></section>', 1, '2026-07-19 02:06:29', '2026-07-19 02:06:29'),
(3, 1, 'Contact us', 'contact', NULL, NULL, '', 1, '2026-07-19 02:06:29', '2026-07-19 02:06:29');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, '1235yhgfTT(^@)$', '2347c3018a98fbdee9c357eca371ee2d2fe68d071361d46ebcf2ba0c342771f8', '[\"*\"]', NULL, NULL, '2026-07-19 02:16:15', '2026-07-19 02:16:15');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `categories` json DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `image_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` double DEFAULT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `categories` json DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `image_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_id`, `title`, `slug`, `sku`, `price`, `excerpt`, `content`, `categories`, `tags`, `image_id`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(86, 1, 'Realtime Blog - Node.js, MongoDB', 'realtime-blog', 'PROD-000086', 99, '', '<div><br></div>', '[\"nodejs\"]', '[\"nodejs\", \"mongodb\"]', 99, 1, '2026-07-19 06:23:46', '2026-07-19 09:47:17', NULL),
(87, 1, 'Video Streaming Web App - Node.js, MongoDB', 'video-streaming', 'PROD-000087', 99, '', '<div><br></div>', '[\"nodejs\"]', '[\"nodejs\", \"mongodb\"]', 103, 1, '2026-07-19 06:23:46', '2026-07-19 09:47:06', NULL),
(88, 1, 'Social Networking Site - Node.js, MongoDB', 'social-networking-site', 'PROD-000088', 99, '', '<div><br></div>', '[\"nodejs\"]', '[\"nodejs\", \"mongodb\"]', 101, 1, '2026-07-19 06:23:46', '2026-07-19 09:46:28', NULL),
(89, 1, 'Movie Ticket Booking System - PHP, MySQL, MVC', 'movie-ticket-booking-system', 'PROD-000089', 99, '', '<div><br></div>', '[\"php\"]', '[\"php\", \"mysql\", \"mvc\"]', 78, 1, '2026-07-19 06:23:46', '2026-07-19 09:46:15', NULL),
(90, 1, 'Questionnaire - Node.js, MongoDB', 'questionnaire', 'PROD-000090', 99, '', '<div><br></div>', '[\"nodejs\"]', '[\"nodejs\", \"mongodb\"]', 98, 1, '2026-07-19 06:23:46', '2026-07-19 09:46:03', NULL),
(91, 1, 'Customer Support Chat Widget - PHP, MySQL, Node.js', 'customer-support-chat-widget', 'PROD-000091', 99, '', NULL, '[\"nodejs\", \"php\", \"mysql\"]', '[\"nodejs\", \"php\", \"mysql\"]', 62, 1, '2026-07-19 06:23:46', '2026-07-19 06:23:46', NULL),
(92, 1, 'Image Sharing Web App in Node.js and MongoDB', 'image-sharing-nodejs-mongodb', 'PROD-000092', 99, '', '<div><br></div>', '[\"nodejs\"]', '[\"nodejs\", \"mongodb\"]', 69, 1, '2026-07-19 06:23:46', '2026-07-19 09:43:38', NULL),
(93, 1, 'File Transfer Web App in Node.js and MongoDB', 'file-transfer-nodejs-mongodb', 'PROD-000093', 99, '', '<div><br></div>', '[\"nodejs\"]', '[\"nodejs\", \"mongodb\"]', 67, 1, '2026-07-19 06:23:46', '2026-07-19 09:43:06', NULL),
(94, 1, 'Blog in Laravel with Android app', 'laravel-blog-with-android-app', 'PROD-000094', 99, '', '<div><br></div>', '[\"laravel\", \"php\"]', '[\"laravel\", \"blog\", \"android\", \"java\", \"php\", \"mysql\"]', 77, 1, '2026-07-19 06:23:46', '2026-07-19 09:42:39', NULL),
(95, 1, 'Financial Ledger in Node.js and MongoDB', 'financial-ledger-nodejs-mongodb', 'PROD-000095', 99, '', '<div><br></div>', '[\"nodejs\"]', '[\"finance\", \"nodejs\", \"vuejs\", \"mongodb\"]', 68, 1, '2026-07-19 06:23:46', '2026-07-19 09:42:23', NULL),
(96, 1, 'Picture Competition Website in MEVN stack', 'picture-competition-website-mevn', 'PROD-000096', 99, '', '<div><br></div>', '[\"nodejs\"]', '[\"mevn\", \"nodejs\", \"vuejs\", \"mongodb\"]', 80, 1, '2026-07-19 06:23:46', '2026-07-19 09:40:45', NULL),
(97, 1, 'Realtime chat app in MEVN stack - Single Page Application', 'realtime-chat-app-mevn-spa', 'PROD-000097', 99, '', '<div><br></div>', '[\"nodejs\"]', '[\"chat\", \"mevn\", \"nodejs\", \"vuejs\", \"mongodb\"]', 100, 1, '2026-07-19 06:23:46', '2026-07-19 09:40:26', NULL),
(98, 1, 'Ecommerce website in MEVN stack', 'ecommerce-mevn', 'PROD-000098', 99, '', '<div><br></div>', '[\"nodejs\"]', '[\"ecommerce\", \"mevn\", \"nodejs\", \"vuejs\", \"mongodb\"]', 65, 1, '2026-07-19 06:23:46', '2026-07-19 09:40:12', NULL),
(99, 1, 'Android Chat App - Kotlin, Node.js', 'android-chat-app-kotlin-nodejs', 'PROD-000099', 99, '', '<div><br></div>', '[\"nodejs\"]', '[\"android\", \"kotlin\", \"nodejs\", \"chat\"]', 61, 1, '2026-07-19 06:23:46', '2026-07-19 09:39:54', NULL),
(100, 1, 'Jobfinder - PHP MySQL MVC', 'jobfinder-php-mysql-mvc', 'PROD-000100', 99, '', '<div><br></div>', '[\"php\"]', '[\"php\", \"mysql\", \"mvc\"]', 72, 1, '2026-07-19 06:23:46', '2026-07-19 09:38:27', NULL),
(101, 1, 'Trustpilot Clone - Laravel', 'trustpilot-clone-laravel', 'PROD-000101', 99, '', '<div><br></div>', '[\"laravel\", \"php\"]', '[\"vue\", \"laravel\", \"php\", \"mysql\"]', 102, 1, '2026-07-19 06:23:46', '2026-07-19 09:38:18', NULL),
(102, 1, 'File Manager in React + Laravel', 'file-manager-react-laravel', 'PROD-000102', 99, '', '<div><br></div>', '[\"laravel\", \"php\"]', '[\"reactjs\", \"laravel\", \"php\", \"mysql\"]', 66, 1, '2026-07-19 06:23:46', '2026-07-19 09:36:02', NULL),
(103, 1, 'Multi-purpose platform in Node.js and MongoDB', 'multi-purpose-platform-nodejs-mongodb', 'PROD-000103', 99, '', '<div><br></div>', '[\"nodejs\"]', '[\"reactjs\", \"nodejs\", \"mongodb\"]', 79, 1, '2026-07-19 06:23:46', '2026-07-19 09:35:33', NULL),
(104, 1, 'Job Portal - React + Laravel', 'job-portal-react-laravel', 'PROD-000104', 99, '', '<div><br></div>', '[\"laravel\", \"php\"]', '[\"reactjs\", \"laravel\", \"php\", \"mysql\"]', 70, 1, '2026-07-19 06:23:46', '2026-07-19 09:34:59', NULL),
(105, 1, 'Doctor Appointment Booking System - Laravel', 'doctor-appointment-booking-laravel', 'PROD-000105', 99, '', '<div><br></div>', '[\"laravel\", \"php\"]', '[\"laravel\", \"php\", \"mysql\"]', 64, 1, '2026-07-19 06:23:46', '2026-07-19 06:26:57', NULL),
(106, 1, 'Project Management System - React, Laravel, Node.js, Java', 'project-management-system', 'PROD-000106', 99, 'Internal tool for companies and individuals to manage their projects, tasks, timesheet, clients, finances, communication all in 1 place.', NULL, '[\"project\", \"management\", \"tool\", \"laravel\", \"php\", \"react\", \"nodejs\"]', '[\"project\", \"management\", \"tool\", \"laravel\", \"php\", \"react\", \"nodejs\"]', 34, 1, '2026-07-19 06:23:46', '2026-07-19 06:23:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_sections`
--

CREATE TABLE `product_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `type` enum('text','text_with_image','text_with_video') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `url` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_sections`
--

INSERT INTO `product_sections` (`id`, `product_id`, `title`, `description`, `type`, `url`, `created_at`, `updated_at`) VALUES
(616, 91, 'Demo', 'Users will be able to chat with the admin and get instant replies. Admin will be able to view the navigation history of the user. For example, how many and which pages the user has visited, what was the last page the user has visited, etc.', 'text_with_video', 'https://www.youtube.com/embed/56_k1botx9M', '2026-07-19 06:23:46', '2026-07-19 06:23:46'),
(701, 106, 'Demo', 'Manage your projects and tasks, and let your clients see the progress from your website. See how system works, how you can give clients access to their dashboard, how they can respond to the queries etc.<br /><br />You can create:<br /><ol><li>Team Members</li><li>Clients</li></ol>You can assign tasks to team members and your clients will be able to see the progress.</ol>', 'text_with_video', 'https://www.youtube.com/embed/ZBvgHKQsjtY', '2026-07-19 06:23:46', '2026-07-19 06:23:46'),
(702, 106, 'Private Chat', 'Sometimes you need to share sensitive information like cPanel credentials, that you do not want to share with other team members. You can do that by simply having a private chat with that member.<br /><br /><ol><li>Team members can have a chat between them.</li><li>Only admins can have a chat with clients.</li></ol>Users you recently had a chat will appear at the top. Chat is realtime, so you won\'t have to refresh the page to see new messages.', 'text_with_video', 'https://www.youtube.com/embed/ugBR-raVhwY', '2026-07-19 06:23:46', '2026-07-19 06:23:46'),
(703, 106, 'Invoices', 'Let your clients pay you directly from your own website via invoices.<br /><br />Just follow the steps:<br /><br /><ol><li>You create an invoice and link it with your client account.</li><li>Client can login and see all the pending invoices.</li><li>Client can pay via Stripe.</li><li>For recurring payments, client\'s payment method is saved securely so they can make another payment without entering their card details again.</li></ol>', 'text_with_video', 'https://www.youtube.com/embed/vdioleU1OTc', '2026-07-19 06:23:46', '2026-07-19 06:23:46'),
(704, 106, 'Projects', 'You can create projects and assign the client to it. Once client login, he will be able to see all his projects and their updates. You can write complete description of the project under it.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5ca6a78ae34.png', '2026-07-19 06:23:46', '2026-07-19 06:23:46'),
(705, 106, 'Tasks', 'In each project, you can create multiple tasks. Whenever client ask for a new feature or a change, create a task so you won\'t have to remember. This will also help you not miss anything from client.<br /><br />Each task has a flow <i>todo -> progress -> done</i>.<br /><br />You can assign multiple team members to a task (including yourself) so they can collaborate on 1 place. Client and admin will also be able to see what\'s going on in this task.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5ca6a77c676.png', '2026-07-19 06:23:46', '2026-07-19 06:23:46'),
(706, 106, 'Chat With Your Clients', 'You can discuss everything related to that task on each task\'s page. So all the communication related to that task stays under it, organized.<br /><br />You can send messages, attach documents, images, videos, you can send voice notes. You can mention a user to gain his attention to your message.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5ca6a78d260.png', '2026-07-19 06:23:46', '2026-07-19 06:23:46'),
(707, 106, 'Documents', 'Whenever client sends a requirement document, you can attach it to your project so you can stick to the deliverables. You can add all associated documents, images, and videos of a project on it\'s page. So documents are not scattered, but are organized under each project. You can either view the files directly in the browser, or you can download them directly in your system.<br /><br />Only admin can delete the files, but they will be temporarily deleted. Only super admin can delete the files permanently.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5ca6a7870d5.png', '2026-07-19 06:23:46', '2026-07-19 06:23:46'),
(708, 106, 'Typing...', 'When one person is typing a message, others will know. This is helpful because now you will know that the other person is replying to your message.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5ca6a7902cf.png', '2026-07-19 06:23:46', '2026-07-19 06:23:46'),
(709, 106, 'Professional Dashboard', 'Each client has his own dashboard, from where he can see total number of projects he has with you. Total pending tasks, tasks you are currently working-on, and the tasks you have completed so far.<br /><br />As an admin, you can see:<ol><li>How many tasks you are getting per month.</li><li>How many projects you are getting each month.</li><li>Total number of users.</li><li>Latest tasks, you can click on them to simply open that task.</li><li>Same goes for latest projects and users.</li></ol><br />As they say, <i>Seeing your progress is a great way to boost it.</i>', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5ca6a786338.png', '2026-07-19 06:23:46', '2026-07-19 06:23:46'),
(710, 106, 'Invoices', 'Send invoices to your clients and they can pay directly on your website. You can filter invoices by their statuses, for example, <i>how many invoices are overdue?</i><br />As an admin, you can cancel any invoice and client won\'t be able to pay that one.<br /><br />You can invoice the client in his own currency, and you will be able to see:<br /><ol><li>Total Invoiced</li><li>Collected</li><li>Outstanding</li><li>Overdue</li></ol>for each currency.<br /><br />You can send friendly reminder to clients for overdue invoices.<br />Clients can see all the invoices issues to him from his dashboard.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5ca6a789ed1.png', '2026-07-19 06:23:46', '2026-07-19 06:23:46'),
(711, 106, 'Receive Payments', 'Clients do not have to go to third-party platforms to make you payment everytime. They can pay with their debit or credit card directly on your website and the amount will be reflected in your account.<br /><br />If you are running a business where you take payments from clients on each month, for example if you provide maintenance services, then your clients can simply visit your website and click their previously used payment method and it will automatically charge from it.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5ca6a788530.png', '2026-07-19 06:23:46', '2026-07-19 06:23:46'),
(712, 106, 'Send Reminder for Invoices', 'Sometimes clients forget to make the payment on time. You can send them a friendly reminder directly from the system.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5ca6a78dadb.png', '2026-07-19 06:23:46', '2026-07-19 06:23:46'),
(713, 106, 'Financial Ledger', 'Track your expenses and income from your website. This feature is available for admins only so they can debit or credit the amount they are spending or receiving.<br /><br />You can add transactions in multiple currencies. You can filter the transactions by:<br /><ol><li>Currency</li><li>Category (general, tax, payroll etc.)</li><li>Date</li></ol>You can delete the transaction anytime and the stats will automatically gets updated.<br /><br />You can add additional notes with each transaction, so you will know why this transaction was made.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5ca6a787c19.png', '2026-07-19 06:23:46', '2026-07-19 06:23:46'),
(714, 106, 'Time Tracking', 'A time tracking app that you can use to see how many hours or minutes it took to do a specific task. It will be an executable file. Here is how it works:<br /><br /><ol><li>Login on app</li><li>Select the Project</li><li>Select the Task</li><li>Start the timer when starts working</li><li>Stop the timer once done</li></ol>', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5ca6a78e886.png', '2026-07-19 06:23:46', '2026-07-19 06:23:46'),
(715, 106, 'Total Time Spent on a Task', 'You can see how many hours and minutes are spent on each task. This is helpful when you are billing the client on hourly basis. Your clients can also see the time you have worked on his tasks.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5ca6a78fa80.png', '2026-07-19 06:23:46', '2026-07-19 06:23:46'),
(716, 106, 'Timer Sessions', 'While working on something, you might be taking breaks. So you can:<br /><br /><ol><li>Stop the timer</li><li>Take the break</li><li>Start again when you are refreshed</li></ol>So you can work in sessions and see for how long have you worked in each session.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5ca6a78efd2.png', '2026-07-19 06:23:46', '2026-07-19 06:23:46'),
(717, 106, 'Screenshots', 'The timer app will automatically takes screenshots on random interval of time. You can see all screenshots from your task detail page.<br /><br /><ul><li>This is a great way to get focused on the work.</li><li>Because you will get a feeling that someone is watching you if you are doing the real work or doing something else.</li></ul>', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5ca6a78b980.png', '2026-07-19 06:23:46', '2026-07-19 06:23:46'),
(718, 106, 'Search Everything', 'Instead of having search on each page, we have 1 centralized search that can search everything. You can search:<br /><br /><ul><li>Projects</li><li>Tasks</li><li>Chat Messages</li></ul>All from 1 place.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5ca6a78c6cd.png', '2026-07-19 06:23:46', '2026-07-19 06:23:46'),
(719, 105, 'Demo', 'Our video demo shows how effortless managing appointments can be. Saves your time, optimize your schedule, and improve patient satisfaction all with one simple platform.', 'text_with_video', 'https://www.youtube.com/embed/0WiDSwW06dI', '2026-07-19 06:26:57', '2026-07-19 06:26:57'),
(720, 105, 'Streamline Doctor Appointments', 'Manage patient bookings effortlessly with a modern Laravel system. Keep schedules organized, reduce no-shows, and provide a seamless experience for both doctors and patients.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5cacf861003.png', '2026-07-19 06:26:57', '2026-07-19 06:26:57'),
(721, 105, 'Responsive Design', 'Looks great on desktop, tablet, and mobile out of the box.', 'text', '', '2026-07-19 06:26:57', '2026-07-19 06:26:57'),
(722, 105, 'Admin Dashboard', 'Manage patients, and appointments easily with a built-in dashboard.', 'text', '', '2026-07-19 06:26:57', '2026-07-19 06:26:57'),
(723, 105, 'Patient History & Records', 'Maintain complete and accurate medical records and appointment history for every patient.', 'text', '', '2026-07-19 06:26:57', '2026-07-19 06:26:57'),
(724, 105, 'Doctor Chat', 'Patients can securely chat with doctors for quick consultations and follow-ups.', 'text', '', '2026-07-19 06:26:57', '2026-07-19 06:26:57'),
(725, 104, 'Demo', 'Watch our quick demo to see how our innovative, easy-to-use job portal makes hiring and job searching effortless. From posting jobs and managing applications to finding the best candidates or opportunities, the platform quickly and efficiently streamlines the entire process. See how it saves time, improves matching, and helps both employers and job seekers truly succeed.', 'text_with_video', 'https://www.youtube.com/embed/-vQqTH1FhRk', '2026-07-19 09:34:59', '2026-07-19 09:34:59'),
(726, 104, 'How to setup', 'See how easy it is to set up your job portal script. Simply download the files, upload them to your server, configure the basic settings, and start running your platform instantly, hassle-free.', 'text_with_video', 'https://www.youtube.com/embed/fQD5g-HJI04', '2026-07-19 09:34:59', '2026-07-19 09:34:59'),
(727, 104, 'Make money from this platform', 'Turn your job portal into a revenue-generating platform with ease. Monetize by charging employers for featured listings, thus creating a profitable, self-sustaining system.', 'text_with_video', 'https://www.youtube.com/embed/GSX6DYcytyo', '2026-07-19 09:34:59', '2026-07-19 09:34:59'),
(728, 104, 'Email Integration', 'Configured with SMTP for reliable email delivery and notifications.', 'text', '', '2026-07-19 09:34:59', '2026-07-19 09:34:59'),
(729, 104, 'Chat Integration', 'Includes chat widget for real-time customer communication.', 'text', '', '2026-07-19 09:34:59', '2026-07-19 09:34:59'),
(730, 104, 'Deployment Compatibility', 'Can be easily deployed on shared hosting, VPS, or dedicated servers.', 'text', '', '2026-07-19 09:34:59', '2026-07-19 09:34:59'),
(731, 103, 'Demo', 'This API saves development and testing time by 70%. You will get many APIs ready to use that you might have to develop and test otherwise.', 'text_with_video', 'https://www.youtube.com/embed/G8TCHUeisiA', '2026-07-19 09:35:33', '2026-07-19 09:35:33'),
(732, 103, 'Pages', 'If you are running a business, you can create a page for your business and start posting about your products or services in that page. In order to create a page, you need to set it’s name, tell a little about the page, and provide a cover photo for the page.', 'text_with_video', 'https://www.youtube.com/embed/vkMhB_yPcCY', '2026-07-19 09:35:33', '2026-07-19 09:35:33'),
(733, 103, 'Groups', 'You can create groups to create a community of like-minded people. In order to create a group, you need to enter the name of group, a little description about the group and it’s cover photo. Only admin or group members can post in a group. Posts uploaded by admin will be immediately displayed on the groups newsfeed. However, the posts uploaded by group members will be held pending for approval from the admin.', 'text_with_video', 'https://www.youtube.com/embed/_wprWr0CE4Q', '2026-07-19 09:35:33', '2026-07-19 09:35:33'),
(734, 103, 'End-to-end Encrypted (E2EE) Chat', 'You can have realtime chat with your friends. Chats are end-to-end encrypted, that means that the messages are encrypted before sending to the server. Messages are decrypted only after receiving the response from the server. Your messages will remain secure in-transit.', 'text_with_video', 'https://www.youtube.com/embed/wA0Ob2JwOME', '2026-07-19 09:35:33', '2026-07-19 09:35:33'),
(735, 103, 'Job Portal', 'A platform that allows recruiter to post jobs and candidates can apply on that job. Recruiter can see all the applications he has received on a job and can change the status of applicant to shortlisted, interviewing, rejected or selected etc. Candidate can upload multiple CVs and choose the relevant CV while applying for the job. Recruiter can update or delete the job any time.', 'text_with_video', 'https://www.youtube.com/embed/4AU_m5cBkKE', '2026-07-19 09:35:33', '2026-07-19 09:35:33'),
(736, 103, 'Admin Panel', 'Manage users, jobs, posts, and freelance gigs all from one place. Admin can add a new user if he wants. An email with password set by admin will be sent to the new user. Admin can also update the user password as well.', 'text_with_video', 'https://www.youtube.com/embed/kSaIFnOdC2E', '2026-07-19 09:35:33', '2026-07-19 09:35:33'),
(737, 103, 'Freelance Platform', 'There are 2 entities in freelance platform: Buyer and Seller. Buyer will create a task, mention his budget and deadline. Sellers will start bidding on that task. Buyer will see all the bids from sellers. Buyer can accept the bid of any seller he seems fit for the job. On their order detail page, they can chat with each other. After the work is done, buyer can complete the order. Once it is completed, the amount that was offered in the bid will be deducted from buyer’s account. 5 percent will be deducted as a platform fee, and the remaining 95% of the amount will be added in the seller\'s account.', 'text_with_video', 'https://www.youtube.com/embed/703s4d-QNzE', '2026-07-19 09:35:33', '2026-07-19 09:35:33'),
(738, 103, 'Blogs', 'Admin can write blogs and they will be displayed on user side. User can post a comment. Other users or admin can reply to their comments. Admin can delete any comment he did not find suitable.', 'text_with_video', 'https://www.youtube.com/embed/j1TupIgwyw8', '2026-07-19 09:35:33', '2026-07-19 09:35:33'),
(739, 103, 'Page Builder', 'Created a page builder similar to WordPress that helps to write blog posts in an easy way.', 'text_with_video', 'https://www.youtube.com/embed/WvIjvly7T7o', '2026-07-19 09:35:33', '2026-07-19 09:35:33'),
(740, 102, 'For Companies', 'You can deploy this on your own subdomain and all your employees can use this to share files above themselves.', 'text_with_video', 'https://www.youtube.com/embed/8DdkzDIINGk', '2026-07-19 09:36:02', '2026-07-19 09:36:02'),
(741, 102, 'Collaboration', 'If 2 employees are working on the same file, then the other can see the changes of 1st in real-time. No need to refresh the page to see changes.', 'text_with_video', 'https://www.youtube.com/embed/NWabtlFYUAQ', '2026-07-19 09:36:02', '2026-07-19 09:36:02'),
(742, 102, 'Soft Delete', 'Deleted files goes to the trash can where they can be easily recovered or permanently destroyed. This prevents accidental deletion of important files.', 'text_with_video', 'https://www.youtube.com/embed/LVieNyKeJtI', '2026-07-19 09:36:02', '2026-07-19 09:36:02'),
(743, 102, 'Contacts', 'You can save a user in your contact and whenever you want to share file to that contact, you can easily search that user by name or email. This makes sure that you are sending the file to the current person.', 'text_with_video', 'https://www.youtube.com/embed/jqvUcFA3odQ', '2026-07-19 09:36:02', '2026-07-19 09:36:02'),
(744, 101, 'Trust but verify', 'Read what others are saying about a company before buying their product.', 'text_with_video', 'https://www.youtube.com/embed/UMYRliW5Lv4', '2026-07-19 09:38:18', '2026-07-19 09:38:18'),
(745, 101, 'Risk-score', 'View ratings of a company either it is good or bad.', 'text_with_video', 'https://www.youtube.com/embed/_aB2q-r_eHA', '2026-07-19 09:38:18', '2026-07-19 09:38:18'),
(746, 101, 'Widget', 'Allow companies to embed your widget in their website so they can show trust to their customers.', 'text_with_video', 'https://www.youtube.com/embed/Si-OTn-yfxk', '2026-07-19 09:38:18', '2026-07-19 09:38:18'),
(747, 101, 'Manage multiple devices', 'As a company, you can login from different devices but still can logout from any other device. This is useful when you no longer have access to that device.', 'text_with_video', 'https://www.youtube.com/embed/6I67MmSwuJg', '2026-07-19 09:38:18', '2026-07-19 09:38:18'),
(748, 101, 'Watch development process', 'No AI, no autocomplete features, just coding in it\'s real form.', 'text_with_video', 'https://www.youtube.com/embed/jp6zqwqOWEs', '2026-07-19 09:38:18', '2026-07-19 09:38:18'),
(749, 100, 'Demo', 'See how recruiters can post jobs and candidates can find them.', 'text_with_video', 'https://www.youtube.com/embed/cU7CkIWo8sU', '2026-07-19 09:38:27', '2026-07-19 09:38:27'),
(750, 100, 'Post a Job', 'Recruiter can post a job after creating their company account.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5caf78e25f0.png', '2026-07-19 09:38:27', '2026-07-19 09:38:27'),
(751, 100, 'My posted jobs', 'As a recruiter, you can see all your posted jobs and can edit or delete them.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5caf78e30c4.png', '2026-07-19 09:38:27', '2026-07-19 09:38:27'),
(752, 100, 'Job listing', 'Candidates can see a list of all jobs and they can filter out the jobs as per their skill set. They will automatically be notified when a new job is posted by any recruiter.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5caf78e1a27.png', '2026-07-19 09:38:27', '2026-07-19 09:38:27'),
(753, 100, 'Job detail', 'View job summary, number of vacancies, location, either it is on-site/remote/hybrid, salary range and the last date for to submit your application. Applicants list will only be displayed to recruiters. Candidates can turn-on notifications from a specific recruiter. So whenever that recruiter posts a new job, you will be notified.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5caf78e0e20.png', '2026-07-19 09:38:27', '2026-07-19 09:38:27'),
(754, 99, 'For Companies', 'If you do not want to use third-party services to chat about your internal company matters, you can deploy this in your own server. Your employees can install the mobile app on their devices and starts communicating. Data will remain on your company\'s server.', 'text_with_video', 'https://www.youtube.com/embed/VGcqgK-32Jw', '2026-07-19 09:39:54', '2026-07-19 09:39:54'),
(755, 99, 'For Private Chat', 'Use this app to chat personally with any person. Just deploy the backend on your server (we will do that for you). You and other person can install the app and you both can chat privately. Data will never leave your server.', 'text_with_video', 'https://www.youtube.com/embed/eyDpaKPBIHA', '2026-07-19 09:39:54', '2026-07-19 09:39:54'),
(756, 99, 'For Families', 'Deploy the app on your own server and your family members can install the app. Chats done there will remain private.', 'text_with_video', 'https://www.youtube.com/embed/EDae_BZuLo0', '2026-07-19 09:39:54', '2026-07-19 09:39:54'),
(757, 99, 'Status for 24 hours', 'Give temporary updates to your contacts about yourself. Stories uploaded will be removed automatically after 24 hours.', 'text_with_video', 'https://www.youtube.com/embed/Nd0joODJ9vQ', '2026-07-19 09:39:54', '2026-07-19 09:39:54'),
(758, 99, 'Know if message was delivered', 'With the help of tick mark, you will be able to see if your message is delivered to the recipient. This gives relaxation that the other person got the message you wanted to deliver.', 'text_with_video', 'https://www.youtube.com/embed/BaxAmGJTbnM', '2026-07-19 09:39:54', '2026-07-19 09:39:54'),
(759, 99, 'How you looked recently', 'Change your profile picture regularly to keep your contacts know how you look after joining the gym.', 'text_with_video', 'https://www.youtube.com/embed/IY1IfwUQ2Rg', '2026-07-19 09:39:54', '2026-07-19 09:39:54'),
(760, 99, 'End-to-end encrypted (E2EE) messages', 'With messages encrypted before sending to the server, no-one can read your chat even if your server got hacked or if your database was leaked.', 'text_with_video', 'https://www.youtube.com/embed/wfSR02tOiXo', '2026-07-19 09:39:54', '2026-07-19 09:39:54'),
(761, 99, 'Voice notes', 'Sometimes you are in a hurry, or when you want to explain something complex, it\'s good to just speak it out than typing it.', 'text_with_video', 'https://www.youtube.com/embed/fVhWyxjJyDs', '2026-07-19 09:39:54', '2026-07-19 09:39:54'),
(762, 99, 'Search audio notes', 'If you remember any of the word in the audio message, you can simply type it in search field and the app will show you only the audio messages that has the searched text in it.', 'text_with_video', 'https://www.youtube.com/embed/mOAEZTs5AlY', '2026-07-19 09:39:54', '2026-07-19 09:39:54'),
(763, 99, 'Search messages', 'Find lost messages by simply typing any word you remember from entire message.', 'text_with_video', 'https://www.youtube.com/embed/h_BpFkWZfvY', '2026-07-19 09:39:54', '2026-07-19 09:39:54'),
(764, 99, 'Image search', 'Instead of scrolling endlessly, you can search images inside chats by typing any text that appears in them. The app will find matching images instantly.', 'text_with_video', 'https://www.youtube.com/embed/aw-z7Dq7TuA', '2026-07-19 09:39:54', '2026-07-19 09:39:54'),
(765, 99, 'Scheduled messages', 'Hold the send button to schedule messages for a specific date and time. You can manage all scheduled messages from the menu.', 'text_with_video', 'https://www.youtube.com/embed/mJ9HmIIJzzQ', '2026-07-19 09:39:54', '2026-07-19 09:39:54'),
(766, 98, 'Demo', 'Launch your ecommerce store with a website that does not refresh. It just updates the components, creating a seamless user experience.', 'text_with_video', 'https://www.youtube.com/embed/YFO8b4XItc0', '2026-07-19 09:40:12', '2026-07-19 09:40:12'),
(767, 98, 'Advanced features', 'Getting email on new order prevents missing any order. You can set different shipping charges based on customers\'s country. Ask customers to leave a review so it will create trust for future customers.', 'text_with_video', 'https://www.youtube.com/embed/MXwob7US3zs', '2026-07-19 09:40:13', '2026-07-19 09:40:13'),
(768, 98, 'Save space and time', 'You can take high quality images from your camera. But with our loss-less image compression, you can make them take less space without losing the quality. If customer is taking too long to make a decision to buy a product, you can directly have a chat with him and remove his doubts.', 'text_with_video', 'https://www.youtube.com/embed/q7_117zID9E', '2026-07-19 09:40:13', '2026-07-19 09:40:13'),
(769, 98, 'Suitable for every country', 'No matter which country you are living in, you can run your store in your own preferred currency.', 'text_with_video', 'https://www.youtube.com/embed/kpHz-Svo9fI', '2026-07-19 09:40:13', '2026-07-19 09:40:13'),
(770, 97, 'Demo', 'Chat with your friends and family privately with end-to-end encryption.', 'text_with_video', 'https://www.youtube.com/embed/x4Maha4LVZg', '2026-07-19 09:40:26', '2026-07-19 09:40:26'),
(771, 97, 'Easy Deployment', 'With our guide, you can make your website live in 30 minutes.', 'text_with_video', 'https://www.youtube.com/embed/MBQ-Kxy0EIM', '2026-07-19 09:40:26', '2026-07-19 09:40:26'),
(772, 97, 'Put emotions in chat', 'Add emojis in your message to express your feelings. You can bookmark a message that is important.', 'text_with_video', 'https://www.youtube.com/embed/vJ9yIB5_oUM', '2026-07-19 09:40:26', '2026-07-19 09:40:26'),
(773, 97, 'Protect your chat', 'You can put a password on chat with specific user. So even if someone access your account, he won\'t be able to read the chat with that user.', 'text_with_video', 'https://www.youtube.com/embed/yzwx3baxJbk', '2026-07-19 09:40:26', '2026-07-19 09:40:26'),
(774, 96, 'Create Competitions', 'Registered users can create competitions between 2 users. You can enter name and upload 1 picture of each competitor. There is no limit in the number of competitions to create, you can create as many as you want.', 'text', '', '2026-07-19 09:40:45', '2026-07-19 09:40:45'),
(775, 96, 'Vote on Competition', 'You can vote on one of the competitors in a competition. Once a vote is cast, it cannot be removed. You can only vote for one competitor, not both.', 'text', '', '2026-07-19 09:40:45', '2026-07-19 09:40:45'),
(776, 96, 'Delete Competitions', 'Competitions can only be deleted by either one of the users who created the competition or by the admin.', 'text', '', '2026-07-19 09:40:45', '2026-07-19 09:40:45'),
(777, 96, 'Admin Panel', 'The admin panel allows administrators to delete any competition. The admin must provide a reason for deletion, and a notification will be sent to the user who created that competition.\r\n\r\nDefault admin credentials:\r\nemail: admin@gmail.com\r\npassword: admin', 'text', '', '2026-07-19 09:40:45', '2026-07-19 09:40:45'),
(778, 96, 'Adult Image Validation', 'Users can upload images while creating competitions, but the system automatically checks if the image contains adult content. If an adult image is detected, an error is shown and the image will not be uploaded. This helps maintain platform safety and quality.', 'text', '', '2026-07-19 09:40:45', '2026-07-19 09:40:45'),
(779, 96, 'Admin Panel Stats', 'The admin can view total users, total competitions, and total votes cast on the platform.', 'text', '', '2026-07-19 09:40:45', '2026-07-19 09:40:45'),
(780, 96, 'Free Customer Support', 'This is a free service provided for the pro version only. If you face any difficulty installing or configuring the project, support will help you. Any bugs or errors in the released version can also be fixed.', 'text', '', '2026-07-19 09:40:45', '2026-07-19 09:40:45'),
(781, 95, 'Demo', 'Track your daily expenses and income.', 'text_with_video', 'https://www.youtube.com/embed/Sm-PLd0S77Y', '2026-07-19 09:42:23', '2026-07-19 09:42:23'),
(782, 94, 'Demo', 'Launch your blog with only the features you actually need.', 'text_with_video', 'https://www.youtube.com/embed/FLS1KhGPK_o', '2026-07-19 09:42:39', '2026-07-19 09:42:39'),
(783, 94, 'Android App', 'A dedicated mobile app that helps you interact with your readers in a more personal manner.', 'text_with_video', 'https://www.youtube.com/embed/zin-Fbz0BIY', '2026-07-19 09:42:39', '2026-07-19 09:42:39'),
(784, 94, 'Google Adsense approved', 'The project is tested with Google Adsense and Google AdMob and it was approved by Google for monetization. You just have to link with your Google account and you will start receiving money once you reach the Google payment threshold.', 'text', '', '2026-07-19 09:42:39', '2026-07-19 09:42:39'),
(785, 94, 'User Side', '70 built-in blog posts.\r\nRandom quotations.\r\nTotal users display.\r\nCustom advertisement to generate revenue.\r\nShare posts on Twitter and Facebook.\r\nLimit access to some features for registered users only.\r\nRegistration with Email Verification.\r\nSecure Login.\r\nComment on Post.\r\nReply to the comment.\r\nRelated Posts.\r\nSubscribe to the newsletter.\r\nSocial Links.\r\nA section to sell items directly.\r\nAmazon affiliate links.\r\nRealtime Chat with admin (Firebase).\r\nManage Profile.\r\nChange Password.\r\nCustom Advertisement.', 'text', '', '2026-07-19 09:42:39', '2026-07-19 09:42:39'),
(786, 94, 'Admin Panel', 'Dashboard Statistics.\r\nAdd/Edit blog posts.\r\nAdd/Edit items that sell directly.\r\nManage Inbox.\r\nManage Comments.\r\nRealtime Chat with users (Firebase).', 'text', '', '2026-07-19 09:42:39', '2026-07-19 09:42:39'),
(787, 93, 'Demo', 'A web app that allows you to transfer files to your colleagues, friends, clients, etc.', 'text_with_video', 'https://www.youtube.com/embed/ptUBkjVG7dA', '2026-07-19 09:43:06', '2026-07-19 09:43:06'),
(788, 93, 'Upload files & Create folders', 'You can upload any type of file e.g. image, e-book, executable, iso etc. Uploaded files can be deleted at any time by the uploader.\r\n\r\nTo organize your files, you can create folders and sub-folders with unlimited nesting levels. For example, you can create a folder like “College data” and organize assignments, thesis, and projects inside it.', 'text_with_video', 'https://www.youtube.com/embed/cO6faZ7vJfE', '2026-07-19 09:43:06', '2026-07-19 09:43:06'),
(789, 93, 'Share privately', 'You can share files via email with users who already have an account. Shared files remain strictly private and cannot be accessed by anyone else, even via server directories.', 'text_with_video', 'https://www.youtube.com/embed/epvkU-JXjW8', '2026-07-19 09:43:06', '2026-07-19 09:43:06'),
(790, 93, 'Share publicly', 'Files can be shared via a public link that works without login. The link remains active until the owner deletes it. You can also search uploaded or shared files by name.', 'text_with_video', 'https://www.youtube.com/embed/94S0Or98LH8', '2026-07-19 09:43:06', '2026-07-19 09:43:06'),
(791, 93, 'Rename files & folders', 'Files are automatically named on upload, but you can rename them anytime.', 'text_with_video', 'https://www.youtube.com/embed/NFq7HztBa4A', '2026-07-19 09:43:06', '2026-07-19 09:43:06'),
(792, 93, 'Move files & folders', 'You can move files and folders while preserving sub-folder structure. Moving a file invalidates previously shared public links.', 'text_with_video', 'https://www.youtube.com/embed/l9tqsQDwYbo', '2026-07-19 09:43:06', '2026-07-19 09:43:06'),
(793, 93, 'Business Model', 'Monetize by offering limited free storage and charging users for additional GBs. For example, 1 GB free and $1 per extra GB.', 'text_with_video', 'https://www.youtube.com/embed/9rQmU9Vd-JE', '2026-07-19 09:43:06', '2026-07-19 09:43:06'),
(794, 93, 'Admin panel & Team collaboration', 'Admins can view all users and files. Teams can collaborate in real time, with instant file updates across members using Firebase.', 'text_with_video', 'https://www.youtube.com/embed/UgJO78DGSxU', '2026-07-19 09:43:06', '2026-07-19 09:43:06'),
(795, 93, 'Trash Can', 'Deleted files go to a recycle bin where they can be restored or permanently deleted. Restoring requires sufficient storage space.', 'text_with_video', 'https://www.youtube.com/embed/BOGofW6JWf8', '2026-07-19 09:43:06', '2026-07-19 09:43:06'),
(796, 93, 'Backup', 'Users can create a full backup of all their files with a single click.', 'text_with_video', 'https://www.youtube.com/embed/8v3PpteZOOc', '2026-07-19 09:43:06', '2026-07-19 09:43:06'),
(797, 93, 'Blogs', 'Admins can publish blog posts from the admin panel, and they will automatically appear on the user side.', 'text_with_video', 'https://www.youtube.com/embed/Ck715XO14xo', '2026-07-19 09:43:06', '2026-07-19 09:43:06'),
(798, 93, 'Save space', 'Images can be compressed to reduce size significantly without losing quality (e.g., 3.2 MB → 890 KB).', 'text_with_video', 'https://www.youtube.com/embed/tvFxM-vbvds', '2026-07-19 09:43:06', '2026-07-19 09:43:06'),
(799, 93, 'Pay-per-usage', 'Monetize storage by charging users for additional usage beyond free limits.', 'text_with_video', 'https://www.youtube.com/embed/NnWZwwHON4Q', '2026-07-19 09:43:06', '2026-07-19 09:43:06'),
(800, 93, 'Download counts', 'Publicly shared files can be downloaded without login, and owners can track download counts.', 'text', '', '2026-07-19 09:43:06', '2026-07-19 09:43:06'),
(801, 93, 'Security', 'Files are fully private and only accessible to the owner or shared users. Even direct directory access cannot expose files.', 'text', '', '2026-07-19 09:43:06', '2026-07-19 09:43:06'),
(802, 92, 'Demo', 'You can upload pictures with captions, like photos and comments. You can search photos by their captions.', 'text_with_video', 'https://www.youtube.com/embed/BkF7F2fbLWg', '2026-07-19 09:43:38', '2026-07-19 09:43:38'),
(803, 90, 'Demo', 'A web app that allows users to answer questions based on the best of their knowledge in a limited time. The user who answers the most questions correctly ranks 1st, followed by 2nd and 3rd.', 'text_with_video', 'https://www.youtube.com/embed/aQMWTGbNfMc', '2026-07-19 09:46:03', '2026-07-19 09:46:03'),
(804, 89, 'Demo', '', 'text_with_video', 'https://www.youtube.com/embed/a7GZLmQcOWg', '2026-07-19 09:46:15', '2026-07-19 09:46:15'),
(805, 89, 'Seasons', 'Users will be able to watch seasons on your website. You can add as many seasons and episodes as needed from the admin panel.', 'text_with_video', 'https://www.youtube.com/embed/Qp6Oe3GNaJ0', '2026-07-19 09:46:15', '2026-07-19 09:46:15'),
(806, 89, 'Coupon codes', 'Admin can add coupon codes for special occasions. Users can use them to get discounts on tickets. Payments can be made via Stripe or PayPal to purchase tickets in advance.', 'text_with_video', 'https://www.youtube.com/embed/lZNZmZUZAv4', '2026-07-19 09:46:15', '2026-07-19 09:46:15'),
(807, 89, 'How to setup', 'Easily set up the project on shared, VPS, or dedicated hosting in under 30 minutes.', 'text_with_video', 'https://www.youtube.com/embed/5Rh8KEnMQxM', '2026-07-19 09:46:15', '2026-07-19 09:46:15'),
(808, 88, 'Demo', 'All the functionality you need to launch a social network for your local community.', 'text_with_video', 'https://www.youtube.com/embed/Co5a3QbSonU', '2026-07-19 09:46:28', '2026-07-19 09:46:28'),
(809, 88, 'Authentication', 'Secure login with encrypted passwords.', 'text_with_video', 'https://www.youtube.com/embed/kwPWwczwi6c', '2026-07-19 09:46:28', '2026-07-19 09:46:28'),
(810, 88, 'Newsfeed', 'Users can create posts, share updates, and engage with content from others in a dynamic newsfeed.', 'text_with_video', 'https://www.youtube.com/embed/fXOWfZ2XSeA', '2026-07-19 09:46:28', '2026-07-19 09:46:28'),
(811, 88, 'Post interactions', 'Users can like, comment, reply to comments, and share posts on their timeline.', 'text_with_video', 'https://www.youtube.com/embed/YeXOY4vNfEQ', '2026-07-19 09:46:28', '2026-07-19 09:46:28'),
(812, 88, 'Communicate', 'Users can send friend requests, build connections, and chat in real time with secure messaging.', 'text_with_video', 'https://www.youtube.com/embed/_gusRwy9qmA', '2026-07-19 09:46:28', '2026-07-19 09:46:28'),
(813, 88, 'Business Pages', 'Users can create business pages and promote products or services through posts.', 'text_with_video', 'https://www.youtube.com/embed/FUgjd0t99Is', '2026-07-19 09:46:28', '2026-07-19 09:46:28'),
(814, 88, 'Community', 'Bring like-minded people together in one platform.', 'text_with_video', 'https://www.youtube.com/embed/eOaUXBpYpao', '2026-07-19 09:46:28', '2026-07-19 09:46:28'),
(815, 88, 'Profile visitors', 'View a list of users who have visited your profile.', 'text_with_video', 'https://www.youtube.com/embed/nS7K9xaYBpE', '2026-07-19 09:46:28', '2026-07-19 09:46:28'),
(816, 88, 'Platform safety & security', 'Features include end-to-end encryption, user banning, content moderation, adult image filtering, and post moderation tools.', 'text_with_video', 'https://www.youtube.com/embed/YHa4rlhjwrA', '2026-07-19 09:46:28', '2026-07-19 09:46:28'),
(817, 88, 'Temporary updates', 'Users can post stories that last 24 hours and are automatically deleted after expiry.', 'text_with_video', 'https://www.youtube.com/embed/hoLRcjom0fM', '2026-07-19 09:46:28', '2026-07-19 09:46:28'),
(818, 88, 'Audio notes & events', 'Support for audio posts, event creation, and embedding YouTube links in posts.', 'text_with_video', 'https://www.youtube.com/embed/DQHahy-ZX0A', '2026-07-19 09:46:28', '2026-07-19 09:46:28'),
(819, 88, 'Advanced features', 'Includes post boosting with ads, emoji comments, nearby people search, and group chat functionality.', 'text_with_video', 'https://www.youtube.com/embed/RMGfYwJQwDU', '2026-07-19 09:46:28', '2026-07-19 09:46:28'),
(820, 87, 'Register', 'Emails are verified during registration to prevent fake accounts.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5cacd96bde7.png', '2026-07-19 09:47:06', '2026-07-19 09:47:06'),
(821, 87, 'Login', 'Login by providing your email and password.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5cb0b87ea7b.png', '2026-07-19 09:47:06', '2026-07-19 09:47:06'),
(822, 87, 'Logout', 'Prevent accidental logout by asking for confirmation before signing out.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5cb0b87f3a8.png', '2026-07-19 09:47:06', '2026-07-19 09:47:06'),
(823, 87, 'Home', 'Greet your users with the latest videos uploaded on your platform.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5cb0b87e08b.png', '2026-07-19 09:47:06', '2026-07-19 09:47:06'),
(824, 87, 'Upload video', 'Become a content creator by uploading videos.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5cb0b87ca00.png', '2026-07-19 09:47:06', '2026-07-19 09:47:06'),
(825, 87, 'Video detail page', 'Watch videos in full screen with a smooth viewing experience.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5cb0b884f70.png', '2026-07-19 09:47:06', '2026-07-19 09:47:06'),
(826, 87, 'Manage your videos', 'Edit, delete, or deactivate your videos without permanently removing them.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5cb0b880d78.png', '2026-07-19 09:47:06', '2026-07-19 09:47:06'),
(827, 87, 'Manage your channel', 'Customize your channel with name, profile picture, cover photo, and social links.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5cb0b87fc90.png', '2026-07-19 09:47:06', '2026-07-19 09:47:06'),
(828, 87, 'Notifications', 'Get notified for every activity happening on your channel.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5cb0b881777.png', '2026-07-19 09:47:06', '2026-07-19 09:47:06'),
(829, 87, 'Playlists', 'Organize videos into playlists for better content grouping.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5cb0b882052.png', '2026-07-19 09:47:06', '2026-07-19 09:47:06'),
(830, 87, 'My subscriptions', 'View and manage all channels you have subscribed to.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5cb0b884972.png', '2026-07-19 09:47:06', '2026-07-19 09:47:06'),
(831, 87, 'Watch history', 'Rewatch previously viewed videos or clear your history anytime.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5cb0b87d77e.png', '2026-07-19 09:47:06', '2026-07-19 09:47:06'),
(832, 87, 'Search', 'Search for videos quickly and easily based on your interests.', 'text_with_image', 'http://localhost:8000/storage/files/2026/6a5cb0b8837b0.png', '2026-07-19 09:47:06', '2026-07-19 09:47:06'),
(833, 86, 'Admin Panel', 'Manage posts, files, and users from the admin panel.', 'text', '', '2026-07-19 09:47:17', '2026-07-19 09:47:17'),
(834, 86, '3 themes', 'Bootstrap, Clean Blog, Materialize CSS.', 'text', '', '2026-07-19 09:47:17', '2026-07-19 09:47:17'),
(835, 86, 'Realtime comments and replies', 'Comments and replies appear instantly without refreshing the page, keeping interactions real-time and seamless.', 'text', '', '2026-07-19 09:47:17', '2026-07-19 09:47:17'),
(836, 86, 'File Manager', 'Upload files once and reuse them across multiple blog posts.', 'text', '', '2026-07-19 09:47:17', '2026-07-19 09:47:17'),
(837, 86, 'Views counter', 'Track which posts get the most views to optimize future content strategy.', 'text', '', '2026-07-19 09:47:17', '2026-07-19 09:47:17');

-- --------------------------------------------------------

--
-- Table structure for table `route_permissions`
--

CREATE TABLE `route_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `route_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('PBrtoBCOFhf86X4QKJOxTuX5JfmZWG0NF046hg8M', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiOHJPTUQ5Z1RxTjZvaWxoU3UzY1dxVXNjTmdRTG5hb1VKZGY4ZUlhRyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wcm9qZWN0LW1hbmFnZW1lbnQtc3lzdGVtIjtzOjU6InJvdXRlIjtzOjEwOiJwYWdlcy5zaG93Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjIwOiJzZXNzaW9uX3RpbWV6b25lX2tleSI7czoxMjoiQXNpYS9LYXJhY2hpIjt9', 1784472521);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'title', 'Adnan Tech', '2026-07-19 02:06:29', '2026-07-19 06:14:41'),
(2, 'active_theme', 'default', '2026-07-19 02:06:29', '2026-07-19 02:06:29'),
(3, 'verify_email', '', '2026-07-19 06:14:30', '2026-07-19 06:14:30'),
(4, 'smtp_host', '', '2026-07-19 06:14:30', '2026-07-19 06:14:30'),
(5, 'smtp_port', '', '2026-07-19 06:14:30', '2026-07-19 06:14:30'),
(6, 'smtp_encryption', '', '2026-07-19 06:14:30', '2026-07-19 06:14:30'),
(7, 'smtp_username', '', '2026-07-19 06:14:30', '2026-07-19 06:14:30'),
(8, 'smtp_password', '', '2026-07-19 06:14:30', '2026-07-19 06:14:30'),
(9, 'smtp_from', '', '2026-07-19 06:14:30', '2026-07-19 06:14:30'),
(10, 'smtp_from_name', '', '2026-07-19 06:14:30', '2026-07-19 06:14:30');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'laravel', '2026-07-19 02:18:42', '2026-07-19 02:18:42'),
(2, 'php', '2026-07-19 02:18:43', '2026-07-19 02:18:43'),
(3, 'react', '2026-07-19 02:18:45', '2026-07-19 02:18:45'),
(4, 'nodejs', '2026-07-19 02:18:46', '2026-07-19 02:18:46'),
(5, 'project management system', '2026-07-19 02:18:51', '2026-07-19 02:18:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` longtext COLLATE utf8mb4_unicode_ci,
  `about` longtext COLLATE utf8mb4_unicode_ci,
  `verification_code` text COLLATE utf8mb4_unicode_ci,
  `type` enum('user','admin','super_admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `is_block` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `profile_image`, `about`, `verification_code`, `type`, `is_block`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin', 'admin@email.com', '2026-07-19 02:06:28', '$2y$12$e5H3UlVJFz2YYJ39m3q4pOSTBbb2XZV/vIXUcSkyZSVO16jv.v5YO', NULL, NULL, NULL, 'super_admin', 0, 'svqxEVsYy5gUfYCyDqZKcTOJNvTyOdwio13NyuMLptCbhuDLEDzfe43r6u7p', '2026-07-19 02:06:29', '2026-07-19 02:06:29', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addons_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_name_unique` (`name`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `message_attachments`
--
ALTER TABLE `message_attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_attachments_message_id_foreign` (`message_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_owner_type_owner_id_index` (`owner_type`,`owner_id`);

--
-- Indexes for table `oauth_device_codes`
--
ALTER TABLE `oauth_device_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `oauth_device_codes_user_code_unique` (`user_code`),
  ADD KEY `oauth_device_codes_user_id_index` (`user_id`),
  ADD KEY `oauth_device_codes_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`),
  ADD KEY `pages_user_id_foreign` (`user_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`),
  ADD KEY `posts_user_id_foreign` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_user_id_foreign` (`user_id`);

--
-- Indexes for table `product_sections`
--
ALTER TABLE `product_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_sections_product_id_foreign` (`product_id`);

--
-- Indexes for table `route_permissions`
--
ALTER TABLE `route_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `route_permissions_user_id_route_name_unique` (`user_id`,`route_name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addons`
--
ALTER TABLE `addons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message_attachments`
--
ALTER TABLE `message_attachments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `product_sections`
--
ALTER TABLE `product_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=838;

--
-- AUTO_INCREMENT for table `route_permissions`
--
ALTER TABLE `route_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addons`
--
ALTER TABLE `addons`
  ADD CONSTRAINT `addons_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD CONSTRAINT `menu_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `message_attachments`
--
ALTER TABLE `message_attachments`
  ADD CONSTRAINT `message_attachments_message_id_foreign` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `product_sections`
--
ALTER TABLE `product_sections`
  ADD CONSTRAINT `product_sections_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `route_permissions`
--
ALTER TABLE `route_permissions`
  ADD CONSTRAINT `route_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
