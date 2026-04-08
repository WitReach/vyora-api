# Vyora API - Premium E-commerce Core

Vyora is a high-performance, SKU-centric e-commerce backend built with **Laravel 12**. Designed for scalability and speed, it provides a comprehensive suite of API endpoints and an admin dashboard to power modern retail experiences.

## 🚀 Key Features

### 📦 Advanced Product Management
- **SKU-Level Control**: Manage inventory with precision using a robust SKU system.
- **Dynamic Attributes**: Full support for product variants including colors, sizes, and custom attributes.
- **Product Collections**: Organize products into curated collections and multi-level categories.

### 🖼️ Media & SEO
- **Color-Synced Galleries**: Automatically group and display product images based on selected color variants.
- **SEO Optimized**: Custom metadata controls for every product, category, and page.
- **Image Processing**: On-the-fly image optimization and resizing using Intervention Image.

### 💳 Payments & Security
- **Payment Integration**: Native Support for **Razorpay** for seamless checkout experiences.
- **API Authentication**: Secure access via **Laravel Sanctum**.
- **Admin Workspace**: A premium, high-fidelity administrative dashboard for managing operations.

### 🛠️ Extensible Architecture
- **API-First**: Built to power headless frontends (Vue, React, Next.js).
- **Clean Code**: Follows Laravel best practices and modern PHP 8.2 standards.

---

## 🛠️ Technology Stack

- **Framework**: [Laravel 12](https://laravel.com)
- **Language**: PHP 8.2+
- **Database**: MySQL / PostgreSQL
- **Payments**: Razorpay
- **Image handling**: Intervention Image
- **Auth**: Laravel Sanctum

---

## ⚙️ Installation & Setup

To get started with Vyora API, follow these steps:

1. **Clone the repository:**
   ```bash
   git clone https://github.com/WitReach/vyora-api.git
   cd vyora-api
   ```

2. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Note: Update your database and Razorpay credentials in the `.env` file.*

4. **Run Migrations & Seeders:**
   ```bash
   php artisan migrate --seed
   ```

5. **Start the Development Server:**
   ```bash
   php artisan serve
   ```

---

## 🤝 Contributing

As an open-source project, we welcome contributions! 
1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is open-sourced software licensed under the **MIT license**.

---
Built with ❤️ by [Wit Reach](https://witreach.com) and [Dope Style](https://dopestyle.in)
