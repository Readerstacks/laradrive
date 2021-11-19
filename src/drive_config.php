<?php 

return
    [
        "modules_dir"=>base_path("app/Modules"),

     
                        
];

// -- phpMyAdmin SQL Dump
// -- version 5.0.1
// -- https://www.phpmyadmin.net/
// --
// -- Host: localhost
// -- Generation Time: Nov 18, 2021 at 10:18 AM
// -- Server version: 8.0.19
// -- PHP Version: 7.3.8

// SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
// SET AUTOCOMMIT = 0;
// START TRANSACTION;
// SET time_zone = "+00:00";

// --
// -- Database: `ajira_dev`
// --

// -- --------------------------------------------------------

// --
// -- Table structure for table `file_manager`
// --

// CREATE TABLE `file_manager` (
//   `id` int NOT NULL,
//   `user_id` int NOT NULL,
//   `parent_id` int NOT NULL,
//   `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
//   `meta_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
//   `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
//   `is_file` tinyint(1) NOT NULL DEFAULT '0',
//   `storage_size` bigint NOT NULL,
//   `path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
//   `virtual_path` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
//   `version` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
//   `copy_of` int NOT NULL,
//   `shared_type` tinyint(1) NOT NULL DEFAULT '0',
//   `deleted_at` datetime DEFAULT NULL,
//   `updated_at` datetime NOT NULL,
//   `created_at` datetime NOT NULL
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

// -- --------------------------------------------------------

// --
// -- Table structure for table `file_manager_permissions`
// --

// CREATE TABLE `file_manager_permissions` (
//   `id` int NOT NULL,
//   `user_id` int NOT NULL,
//   `file_manager_id` int NOT NULL,
//   `permission` int NOT NULL COMMENT '1=>read,2=>read_write',
//   `shareable_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
//   `updated_at` datetime NOT NULL,
//   `created_at` datetime NOT NULL
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

// -- --------------------------------------------------------

// --
// -- Table structure for table `file_manager_shares`
// --

// CREATE TABLE `file_manager_shares` (
//   `id` int NOT NULL,
//   `is_master` tinyint(1) NOT NULL DEFAULT '0',
//   `parent_id` int NOT NULL DEFAULT '0',
//   `user_id` int NOT NULL,
//   `shared_user_id` int NOT NULL,
//   `file_manager_id` int NOT NULL,
//   `emails` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
//   `sharable_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
//   `permission` int NOT NULL,
//   `share_type` tinyint(1) NOT NULL,
//   `updated_at` datetime NOT NULL,
//   `created_at` datetime NOT NULL
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

// -- --------------------------------------------------------

// --
// -- Table structure for table `file_manager_users`
// --

// CREATE TABLE `file_manager_users` (
//   `id` int NOT NULL,
//   `user_id` int NOT NULL,
//   `email` varchar(255) NOT NULL,
//   `storage` float(10,2) NOT NULL,
//   `storage_real` bigint NOT NULL DEFAULT '0',
//   `storage_unit` varchar(255) NOT NULL DEFAULT 'KB',
//   `client_key` varchar(255) NOT NULL,
//   `client_secret` varchar(255) NOT NULL,
//   `updated_at` datetime NOT NULL,
//   `created_at` datetime NOT NULL,
//   `storage_used` float(10,2) NOT NULL
// ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

// --
// -- Indexes for dumped tables
// --

// --
// -- Indexes for table `file_manager`
// --
// ALTER TABLE `file_manager`
//   ADD PRIMARY KEY (`id`);

// --
// -- Indexes for table `file_manager_permissions`
// --
// ALTER TABLE `file_manager_permissions`
//   ADD PRIMARY KEY (`id`);

// --
// -- Indexes for table `file_manager_shares`
// --
// ALTER TABLE `file_manager_shares`
//   ADD PRIMARY KEY (`id`);

// --
// -- Indexes for table `file_manager_users`
// --
// ALTER TABLE `file_manager_users`
//   ADD PRIMARY KEY (`id`);

// --
// -- AUTO_INCREMENT for dumped tables
// --

// --
// -- AUTO_INCREMENT for table `file_manager`
// --
// ALTER TABLE `file_manager`
//   MODIFY `id` int NOT NULL AUTO_INCREMENT;

// --
// -- AUTO_INCREMENT for table `file_manager_permissions`
// --
// ALTER TABLE `file_manager_permissions`
//   MODIFY `id` int NOT NULL AUTO_INCREMENT;

// --
// -- AUTO_INCREMENT for table `file_manager_shares`
// --
// ALTER TABLE `file_manager_shares`
//   MODIFY `id` int NOT NULL AUTO_INCREMENT;

// --
// -- AUTO_INCREMENT for table `file_manager_users`
// --
// ALTER TABLE `file_manager_users`
//   MODIFY `id` int NOT NULL AUTO_INCREMENT;
// COMMIT;
