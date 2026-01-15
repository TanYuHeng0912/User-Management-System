# User Management System

A full-stack user management system built with Laravel 11 (backend) and React with Vite (frontend).

## Tech Stack

### Backend
- Laravel 11
- PHP 8.2+
- MySQL
- Laravel Sanctum (API Authentication)
- Pest (Testing Framework)

### Frontend
- React 19
- Vite
- Tailwind CSS
- React Router DOM
- Axios
- React Hook Form

## Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js 18+ and npm
- MySQL 5.7+ or MariaDB 10.3+
- Git

## Backend Setup

### 1. Navigate to Backend Directory

```bash
cd backend
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Edit the `.env` file and configure your database connection:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=user_management
DB_USERNAME=your_username
DB_PASSWORD=your_password

APP_URL=http://localhost:8000
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Run Database Migrations

```bash
php artisan migrate
```

This will create the following tables:
- `users` (with fields: firstname, lastname, email, phone, password, status)
- `personal_access_tokens` (for Sanctum authentication)
- Other Laravel default tables

### 6. Seed Database

To populate the database with test data (admin account + 10 test users):

```bash
php artisan db:seed
```

Or to run only the UserSeeder:

```bash
php artisan db:seed --class=UserSeeder
```

This will create:
- **Admin account:**
  - Email: `admin@example.com`
  - Password: `password123`
  - Name: Admin User
  - Status: Active

- **10 test users:**
  - All test users have password: `password`
  - Mix of active and inactive statuses
  - Various names and email addresses

### 7. Start the Development Server

```bash
php artisan serve
```

The API will be available at `http://localhost:8000`

### 8. Run Tests

To run the Pest test suite:

```bash
php artisan test
```

Or use Pest directly:

```bash
./vendor/bin/pest
```

## Frontend Setup

### 1. Navigate to Frontend Directory

```bash
cd frontend
```

### 2. Install Dependencies

```bash
npm install
```

### 3. Configure API Endpoint

The frontend is configured to connect to `http://localhost:8000/api` by default. If your backend runs on a different URL, update the `baseURL` in `frontend/src/api/axios.js`:

```javascript
const api = axios.create({
  baseURL: 'http://localhost:8000/api', // Update this if needed
  // ...
});
```

### 4. Start the Development Server

```bash
npm run dev
```

The frontend will be available at `http://localhost:5173` (or another port if 5173 is busy)

## API Endpoints

### Authentication

- `POST /api/login` - Login user
  - Body: `{ "email": "user@example.com", "password": "password" }`
  - Returns: `{ "access_token": "...", "token_type": "Bearer", "user": {...} }`

- `POST /api/logout` - Logout user (requires authentication)
  - Headers: `Authorization: Bearer {token}`

### Users (All require authentication)

- `GET /api/users` - List users with pagination and search
  - Query params: `?page=1&per_page=15&search=keyword`
  - Returns paginated user list

- `POST /api/users` - Create new user
  - Body: `{ "firstname": "...", "lastname": "...", "email": "...", "phone": "...", "password": "...", "status": "active|inactive" }`

- `GET /api/users/{id}` - Get user by ID

- `PUT /api/users/{id}` - Update user
  - Body: Same as create (all fields optional)

- `DELETE /api/users/{id}` - Delete user


## Testing

### Backend Tests

The backend includes comprehensive Pest tests covering:

- Authentication (login, logout)
- User CRUD operations
- Search functionality
- Pagination
- Validation
- Authorization

Run tests with:

```bash
cd backend
php artisan test
```

## Default Accounts

After running the seeder, you will have the following accounts:

### Admin Account
- **Email:** `admin@example.com`
- **Password:** `password123`
- **Name:** Admin User
- **Status:** Active

### Test Users (10 users)
All test users can login with:
- **Password:** `password`

The seeder creates users with various names, emails, and statuses for testing purposes.

## Seeding Database

To seed the database with test data:

```bash
php artisan db:seed
```

This will create:
1. One admin account (admin@example.com)
2. Ten test user accounts

To reset and reseed the database:

```bash
php artisan migrate:fresh --seed
```

**Warning:** This will drop all tables and recreate them, then run all seeders.

This is a project for job interview
