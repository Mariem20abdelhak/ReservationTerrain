# 🏟️ ReservationTerrain

A web application for managing and booking sports fields (terrains), built with **Symfony 5.4** and **PHP**. The platform allows users to browse available fields and make reservations, while administrators can manage listings, users, and bookings.

---

## 🚀 Tech Stack

| Layer | Technology |
|---|---|
| Backend Framework | Symfony 5.4 |
| Language | PHP ≥ 7.2.5 |
| Database | PostgreSQL 15 |
| ORM | Doctrine ORM |
| Templating | Twig |
| Image Processing | Liip Imagine Bundle |
| Authentication | Symfony Security + SymfonyCasts |
| Containerization | Docker / Docker Compose |
| Testing | PHPUnit |
| Translations | Symfony Translation |

---

## 📁 Project Structure

```
ReservationTerrain/
├── src/                  # PHP source code (controllers, entities, forms, etc.)
├── templates/            # Twig HTML templates
├── config/               # Symfony configuration files
├── public/               # Publicly accessible assets
├── translations/         # i18n translation files
├── tests/                # PHPUnit test suites
├── migrations/           # Doctrine database migrations
├── bin/                  # Symfony console binary
├── .env                  # Environment variables (development)
├── .env.production       # Environment variables (production)
├── docker-compose.yml    # Docker services definition
└── Dockerfile            # Docker image configuration
```

---

## ⚙️ Prerequisites

Before getting started, make sure you have the following installed:

- **PHP** ≥ 7.2.5 with extensions: `ctype`, `iconv`
- **Composer**
- **Docker** & **Docker Compose** (recommended for database setup)
- **Symfony CLI** (optional but recommended)

---

## 🛠️ Installation

### 1. Clone the repository

```bash
git clone https://github.com/Mariem20abdelhak/ReservationTerrain.git
cd ReservationTerrain
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Configure environment variables

Copy the `.env` file and update the database credentials:

```bash
cp .env .env.local
```

Edit `.env.local` and set your database connection:

```env
DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=15&charset=utf8"
```

### 4. Start the database with Docker

```bash
docker-compose up -d
```

This will spin up a **PostgreSQL 15** container with the default credentials defined in your `.env` file.

### 5. Run database migrations

```bash
php bin/console doctrine:migrations:migrate
```

### 6. (Optional) Load fixtures

```bash
php bin/console doctrine:fixtures:load
```

### 7. Start the development server

```bash
symfony server:start
```

Or using PHP's built-in server:

```bash
php -S localhost:8000 -t public/
```

The application will be available at **http://localhost:8000**.

---

## 🐳 Docker Setup

The project includes a full Docker Compose configuration. To run the database service:

```bash
docker-compose up -d database
```

To bring everything down:

```bash
docker-compose down
```

---

## 🧪 Running Tests

```bash
php bin/phpunit
```

Or using Symfony's test runner:

```bash
symfony php bin/phpunit
```

---

## 🔑 Key Features

- **Field Listings** — Browse and search available sports terrains
- **Reservations** — Book a field for a specific date and time slot
- **User Authentication** — Register, log in, verify email, and reset passwords
- **Admin Panel** — Manage fields, users, and reservations
- **Image Handling** — Upload and process field images with Liip Imagine
- **Translations** — Multilingual support via Symfony Translation
- **Email Notifications** — Mailer integration for booking confirmations

---

## 🌐 Deployment

The project includes configuration for deploying to **Fly.io** (`fly.toml`) and supports **Heroku-style** deployments via `Procfile`.

### Deploy to Fly.io

```bash
fly deploy
```

Make sure to set your production environment variables on the Fly.io dashboard or via:

```bash
fly secrets set DATABASE_URL="your_production_db_url"
```

---

## 📦 Notable Dependencies

| Package | Purpose |
|---|---|
| `doctrine/orm` | Database ORM |
| `liip/imagine-bundle` | Image resizing & processing |
| `ramsey/uuid-doctrine` | UUID primary keys |
| `stof/doctrine-extensions-bundle` | Sluggable, Timestampable, etc. |
| `symfonycasts/reset-password-bundle` | Secure password reset flow |
| `symfonycasts/verify-email-bundle` | Email verification |
| `symfony/security-bundle` | Authentication & authorization |
| `symfony/mailer` | Transactional emails |
| `symfony/form` | Form handling & validation |

---

## 👤 Author

**Mariem Abdelhak**  
GitHub: [@Mariem20abdelhak](https://github.com/Mariem20abdelhak)

---

## 📄 License

This project is proprietary. All rights reserved.
