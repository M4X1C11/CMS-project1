# Laravel CMS

A content management system built with Laravel featuring role-based authentication, 
post/page management, categories, tags, comments, and SEO-friendly URLs.

## Tech Stack
Laravel · PHP · MySQL · TailwindCSS · TinyMCE

## Features
- Admin/Editor role system
- Post and page management with WYSIWYG editor
- Categories, tags, and comments
- SEO-friendly slugs

## Installation
git clone https://github.com/M4X1C11/CMS-project1.git
cd CMS-project1
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
