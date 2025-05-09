# 📰 Laravel Blog Platform

A feature-rich **Laravel 11** blog platform built for content publishing and advertisement management, with robust support for email notifications, roles, scheduled tasks, and more.

---

## 🌟 Features Overview

### 🧑‍💻 User Roles

- **Admin**
  - Manage users by performing CRUD operation
  - Manage categories by performing CRUD operation
  - Manage own defined tags and authors tags
  - Manages advertisements by performing CRUD operation
  - Receives email alerts for advertisement expiry and deactivation.
  
- **Author**
  - Can create and manage their own articles.
  - Can define **tags** or used their own created **tags** while writing articles for better categorization.
  
### ✍️ Blog Management

- Authors can:
  - Add articles with title, image, content, and tags.
  - Automatically generate a summary (used in email previews).
- Articles are viewable in blog layout.

### 🏷️ Tagging System

- While creating an article, authors can define new tags.
- Tags are stored and reused across articles.
- Helps in content filtering and SEO optimization.

### 📢 Advertisement System

- Ads can be placed in specific **positions**:
  - `top_banner`, `footer_banner`, etc.
- Ads are linked with **placements** and have `start_date` and `end_date`.
- Default fallback image is shown if no ad matches current page or position.
- Admins receive expiry warnings via email:
  - 3 days before expiry
  - 2 days before expiry
  - 1 day before expiry
- Expired ads are **automatically deactivated** or **deactivated by admin ony**, and admin is notified.

### 📧 Email Notifications

- Change of email notification
- Blog post email (sent to subscribers).
- Expiring advert warning email (to admin).
- Advert deactivation email (to admin).

### 📸 Responsive Email Templates

- Email content adapts to mobile and desktop screens.
- Dynamic data (title, URLs, images) is injected into views.

---

## 📦 Technologies Used

- **Laravel 11**
- **Blade Templates**
- **MySQL**
- **Laravel Queues** (`database`)
- **Task Scheduling**
- **XAMPP for Localhost (Windows)**

---

## 🛠 Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/RichmanLoveday/personal_blog_project.git
cd laravel-blog-platform
```

### 2. Install Depend

- composer install
- npm install && npm run dev.

### 3. Envirionment configuration

- Update your database cresidentials.
- Mail settings for notifications.
- Queue connection set to database.

### 4. Run migration and seeders

- Run the migrations:
    ```bash
    php artisan migrate
    ```

- Seed the database:
    ```bash
    php artisan db:seed
    ```

### 5. Admin Credentials

After running the seeders, you can log in as an admin using the following default credentials:

- **Email:** `admin@test.com`
- **Password:** `admin1234`

Make sure to update the admin credentials after the first login for security purposes.


## 🧵 Queued Jobs (Email Notifications)

### 1. Create queued tables

- php artisan queue:table
- php artisan migrate

### 2. Start the queue worker

- php artisan queue:work


## ⏰ Scheduled Tasks

### In routes/console.php

### Scheduled Jobs for Advertisement Notifications

The following scheduled tasks are configured to handle advertisement notifications:

- **Send Advert Expiring Notification**  
    Sends email notifications to the admin about advertisements nearing expiry.  
    **Frequency:** Daily  

    ```php
    Schedule::job(new SendAdvertExpiringNotification)
            ->daily()
            ->everySixHours();
    ```

- **Send Advert Deactivation Notification**  
    Sends email notifications to the admin about advertisements that have been deactivated.  
    **Frequency:** Daily  

    ```php
    Schedule::job(new SendAdvertDeactivationNotification)
            ->daily()
            ->everySixHours();
    ```

- run php artisan schedule:work
