

# 📦 Products CRUD - Laravel 11

## 📌 Project Description

A web application built using **Laravel 11** that provides a secure product management system with authentication, email verification, and password reset functionality. Only verified users can access and manage products.

---

## 🚀 Features

* 🔐 User Authentication (Register / Login / Logout)
* 📧 Email Verification via Gmail SMTP
* 🔑 Password Reset via Email
* 📦 Full CRUD Operations for Products:

  * Create Product
  * Read Products List
  * View Product Details
  * Update Product
  * Delete Product
* 🛡️ Route Protection using `auth` and `verified` middleware
* ⚙️ Form Validation for product data
* 🎨 Clean UI using Laravel Blade templates

---

## 🛠️ Tech Stack

* Laravel 11 (Backend Framework)
* MySQL (Database)
* Laravel Breeze (Authentication)
* SMTP Gmail (Email Service)
* Blade Templates (Frontend)

---

## 📂 Project Structure (MVC)

* **Models** → Product Model
* **Controllers** → ProductController
* **Views** → Blade templates for UI
* **Routes** → Web routes (no logic inside routes file)

---

## ⚙️ Installation & Setup

### 1. Clone the repository

```bash
git clone https://github.com/USERNAME/products-crud-laravel11.git
```

### 2. Go to project folder

```bash
cd products-crud-laravel11
```

### 3. Install dependencies

```bash
composer install
npm install
npm run dev
```

### 4. Setup environment file

```bash
cp .env.example .env
```

### 5. Generate application key

```bash
php artisan key:generate
```

### 6. Configure database in `.env`

```env
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 7. Run migrations

```bash
php artisan migrate
```

### 8. Start the server

```bash
php artisan serve
```

---

## 📧 Email Configuration (Gmail SMTP)

Add this in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="Products App"
```

---

## 🔒 Security Features

* Only authenticated users can access the system
* Email verification required before accessing products
* Protected routes using middleware

---

## 👩‍💻 Author

* **Hadeel Al-Hazwara**


---

## ⭐ Notes

This project follows **MVC architecture**, clean code practices, and proper route-controller separation as required in Laravel 11 development standards.
