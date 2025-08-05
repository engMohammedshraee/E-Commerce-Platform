# 🛒 Laravel E-Commerce with Inertia, Vue, Tailwind & Stripe

A modern and full-featured **E-Commerce web application** built using the Laravel ecosystem with **Inertia.js**, **Vue 3**, **Tailwind CSS**, and integrated **Stripe payment** gateway. Includes full authentication system, product browsing, cart, checkout, and admin management.

---

## 🚀 Features

- 🧾 Product listing, filtering & search  
- 🛍️ Product detail pages with dynamic stock updates  
- 🛒 Shopping cart with quantity management  
- 💳 Secure Stripe payment integration (Test mode)  
- 📦 Order placement and tracking  
- 🧑‍💼 Admin panel for managing products & orders  
- 🔐 Full authentication (registration, login, logout)  
- ⚙️ Built with Laravel, Vue 3, TailwindCSS, Inertia.js  
- 📱 Mobile responsive design  
- 🌐 Localization-ready (optional)  

---

## 🧰 Tech Stack

- **Backend**: Laravel 10  
- **Frontend**: Vue 3 + Inertia.js  
- **Styling**: Tailwind CSS  
- **Payment**: Stripe API (test environment)  
- **Database**: MySQL  
- **Auth**: Laravel Breeze (Inertia preset)  

---

## ⚙️ Installation

```bash
# Clone the repository
git clone https://github.com/your-username/ecommerce-app.git
cd ecommerce-app

# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
php artisan key:generate

# Set up database
php artisan migrate --seed

# Build frontend assets
npm run build

# Start the server
php artisan serve
