# 🚀 Nanang Aditya — Portfolio

A professional fullstack portfolio application built with **Laravel 11** + **React** via **Inertia.js**.
Features a public portfolio site and a protected Admin CMS panel.

## 🧱 Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 11 + PHP 8.3 |
| Frontend | React 18 + Inertia.js (SSR) |
| Styling | TailwindCSS + Inter font |
| Build | Vite |
| Cache/Queue | Redis |
| Database | MySQL 8 |
| Storage | MinIO (S3-compatible) |
| Container | Docker + Nginx |

---

## ⚡ Quick Start — Laravel Herd (Local Dev)

### Prerequisites
- [Laravel Herd](https://herd.laravel.com/) installed
- MySQL (via Herd or TablePlus)
- Redis (via `brew install redis && brew services start redis`)

### Setup

```bash
# 1. Clone / enter directory
cd /Users/nanang212/Documents/PRJ-PRIBADI/portfolio

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install --legacy-peer-deps

# 4. Copy and configure environment
cp .env.example .env
# Edit .env — set DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 5. Generate app key
php artisan key:generate

# 6. Create MySQL database
mysql -u root -e "CREATE DATABASE IF NOT EXISTS portfolio;"

# 7. Run migrations + seed data
php artisan migrate --seed

# 8. Link storage
php artisan storage:link

# 9. Start Vite dev server
npm run dev

# In another terminal — start Laravel (Herd serves automatically at portfolio.test)
# OR manually:
php artisan serve
```

Visit: `http://localhost:8000` or `http://portfolio.test` (Herd)

**Admin Panel:** `http://localhost:8000/admin`
- Email: `admin@portfolio.dev`
- Password: `password`

### Queue Worker (for contact emails)
```bash
php artisan queue:work redis
```

---

## 🐳 Docker

### First-time Setup

```bash
# 1. Copy env
cp .env.example .env
# Edit APP_KEY, DB_PASSWORD etc.

# 2. Generate key (if needed)
php artisan key:generate

# 3. Build and start all services
docker-compose up -d --build

# 4. Run migrations + seed
docker-compose exec app php artisan migrate --seed

# 5. Link storage
docker-compose exec app php artisan storage:link

# 6. Create MinIO bucket (via MinIO console)
# Open: http://localhost:9001
# Login: minioadmin / minioadmin
# Create bucket: "portfolio" (set access policy: public)
```

Visit: `http://localhost:8080`

### Useful Docker Commands

```bash
# View logs
docker-compose logs -f app

# Run artisan commands
docker-compose exec app php artisan <command>

# Restart services
docker-compose restart

# Stop all
docker-compose down

# Stop + remove volumes
docker-compose down -v
```

---

## 🛠 Development

```bash
# Start dev server with HMR
npm run dev

# Build for production
npm run build

# Run tests
php artisan test

# Clear all caches
php artisan optimize:clear
```

---

## 📁 Project Structure

```
app/
  Http/Controllers/
    Portfolio/       ← Public portfolio pages
    Admin/           ← CMS controllers
  Repositories/      ← Database access layer
  Services/          ← Business logic
  Jobs/              ← Queued jobs
resources/js/
  Pages/
    Portfolio/       ← 6 public pages (Home, About, Experience, Projects, Skills, Contact)
    Admin/           ← CMS pages (Dashboard, Projects, Messages...)
  Layouts/
    PortfolioLayout.jsx
    AdminLayout.jsx
  i18n/
    en.json          ← English translations
    id.json          ← Indonesian translations
docker/
  app/Dockerfile
  nginx/default.conf
```

---

## 🌐 Routes

| URL | Description |
|-----|-------------|
| `/` | Portfolio Home (Hero) |
| `/about` | About Me |
| `/experience` | Work Experience |
| `/projects` | Projects |
| `/skills` | Tech Stack |
| `/contact` | Contact Form |
| `/admin` | Admin Dashboard (requires login) |
| `/admin/projects` | Projects CRUD |
| `/admin/experiences` | Experience CRUD |
| `/admin/skills` | Skills CRUD |
| `/admin/about` | About Me Edit |
| `/admin/messages` | Contact Messages |

---

## ✨ Features

- 🌙 **Dark / Light mode** — persisted in localStorage
- 🌐 **Multi-language** — Indonesian & English toggle
- 📱 **Responsive** — Mobile-first design
- ⚡ **Admin CMS** — Full CRUD for all content
- 🔒 **Auth** — Laravel Breeze (session-based)
- 📨 **Contact form** — Stored in DB + queued email
- 🐳 **Docker** — One-command deployment
- 🗄️ **MinIO** — S3-compatible file storage
- 🔄 **Redis** — Cache, sessions, and queue
