# PHP Assessment Application

A modern fullstack authentication system with user profile CRUD functionality, built with Laravel, Tailwind CSS, and Alpine.js.

## 🚀 Features

### Authentication Module
- ✅ Email/Password based login and registration
- ✅ Secure JWT token-based API authentication
- ✅ Session-based web authentication
- ✅ Password encryption using bcrypt
- ✅ Rate limiting and brute-force protection
- ✅ Post-login redirect to dashboard

### User Profile CRUD
- ✅ Complete user profile management
- ✅ Fields: name, email, phone, bio, avatar (image upload)
- ✅ API endpoints for Create, Read, Update, Delete operations
- ✅ Role-based access control (admin vs regular user)
- ✅ Avatar upload with file validation

### Security Features
- ✅ JWT token authentication for API
- ✅ CSRF protection for web forms
- ✅ Password strength validation
- ✅ Rate limiting (login: 5/min, registration: 3/min, API: 60/min)
- ✅ Input validation and sanitization
- ✅ Secure file upload handling

### Modern UI/UX
- ✅ Responsive design with Tailwind CSS
- ✅ Interactive components with Alpine.js
- ✅ Professional dashboard interface
- ✅ Admin user management panel
- ✅ Real-time form validation
- ✅ Smooth transitions and hover effects

## 🛠 Tech Stack

### Backend
- **Framework**: Laravel 10.x
- **Database**: MySQL 8.0
- **Authentication**: Laravel Sanctum (API tokens)
- **Password Hashing**: bcrypt
- **Rate Limiting**: Laravel built-in throttling

### Frontend
- **Templates**: Laravel Blade
- **CSS Framework**: Tailwind CSS (CDN)
- **JavaScript**: Alpine.js for interactivity
- **HTTP Client**: Axios for API calls

### Development Tools
- **Package Manager**: Composer (PHP), npm (Node.js)
- **Database Migrations**: Laravel Artisan
- **File Storage**: Laravel Storage with symbolic links

## 📋 Requirements

- PHP 8.1+
- MySQL 8.0+
- Composer
- Node.js (for frontend dependencies)

## 🚀 Installation & Setup

### 1. Clone the Repository
```bash
git clone <repository-url>
cd php-assessment
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies (if needed)
npm install
```

### 3. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Setup
```bash
# Create database
mysql -u root -p
CREATE DATABASE php_assessment;
CREATE USER 'laravel'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON php_assessment.* TO 'laravel'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Update .env file with database credentials
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=php_assessment
DB_USERNAME=laravel
DB_PASSWORD=password
```

### 5. Run Migrations & Seeders
```bash
# Run database migrations
php artisan migrate

# Seed demo users
php artisan db:seed
```

### 6. Storage Setup
```bash
# Create storage link for file uploads
php artisan storage:link
```

### 7. Start Development Server
```bash
# Start Laravel development server
php artisan serve --host=0.0.0.0 --port=8000
```

The application will be available at: http://localhost:8000

## 👥 Demo Accounts

### Admin User
- **Email**: admin@example.com
- **Password**: Admin123!
- **Features**: Full access to user management, dashboard statistics

### Regular User
- **Email**: user@example.com
- **Password**: User123!
- **Features**: Profile management, dashboard access

## 📚 API Documentation

### Base URL
```
http://localhost:8000/api
```

### Authentication Endpoints

#### Register User
```http
POST /api/auth/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "Password123!",
  "password_confirmation": "Password123!",
  "phone": "+1234567890",
  "bio": "Software Developer"
}
```

#### Login
```http
POST /api/auth/login
Content-Type: application/json

{
  "email": "admin@example.com",
  "password": "Admin123!"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "Admin User",
      "email": "admin@example.com",
      "role": "admin"
    },
    "token": "1|abc123...",
    "token_type": "Bearer"
  }
}
```

#### Logout
```http
POST /api/auth/logout
Authorization: Bearer {token}
```

#### Get Profile
```http
GET /api/auth/profile
Authorization: Bearer {token}
```

### User Management Endpoints

#### List Users (Admin Only)
```http
GET /api/users
Authorization: Bearer {token}
```

#### Get Specific User
```http
GET /api/users/{id}
Authorization: Bearer {token}
```

#### Update Profile
```http
PUT /api/profile
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Updated Name",
  "email": "updated@example.com",
  "phone": "+0987654321",
  "bio": "Updated bio"
}
```

#### Upload Avatar
```http
POST /api/profile/avatar
Authorization: Bearer {token}
Content-Type: multipart/form-data

avatar: [image file]
```

#### Delete User (Admin Only)
```http
DELETE /api/users/{id}
Authorization: Bearer {token}
```

### Utility Endpoints

#### Health Check
```http
GET /api/health
```

**Response:**
```json
{
  "success": true,
  "message": "API is running",
  "timestamp": "2025-07-11T15:37:29.362851Z",
  "version": "1.0.0"
}
```

## 🔒 Security Features

### Rate Limiting
- **Login attempts**: 5 per minute per IP
- **Registration**: 3 per minute per IP
- **API calls**: 60 per minute per user

### Password Requirements
- Minimum 8 characters
- Must contain uppercase letter
- Must contain lowercase letter
- Must contain at least one number

### File Upload Security
- Image files only (jpeg, png, jpg, gif)
- Maximum file size: 2MB
- Secure file naming and storage

## 🏗 Application Structure

```
php-assessment/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── AuthController.php
│   │   │   │   └── UserController.php
│   │   │   └── Web/
│   │   │       ├── AuthController.php
│   │   │       └── DashboardController.php
│   │   └── Middleware/
│   ├── Models/
│   │   └── User.php
│   └── Providers/
│       └── AuthServiceProvider.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── layouts/
│       ├── auth/
│       └── dashboard/
├── routes/
│   ├── api.php
│   └── web.php
└── public/
    └── storage/ (symlinked)
```

## 🧪 Testing

### Manual Testing
All core functionality has been tested:
- ✅ User registration and login
- ✅ Profile management (CRUD operations)
- ✅ Role-based access control
- ✅ API authentication and endpoints
- ✅ File upload functionality
- ✅ Security features and validation

### API Testing with cURL

#### Test Login
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@example.com","password":"Admin123!"}'
```

#### Test Protected Endpoint
```bash
curl -X GET http://localhost:8000/api/auth/profile \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

## 🚀 Deployment

### Production Considerations
1. **Environment Variables**: Update `.env` for production
2. **Database**: Configure production database credentials
3. **File Storage**: Consider cloud storage for avatars
4. **HTTPS**: Enable SSL/TLS in production
5. **Caching**: Enable Redis/Memcached for sessions
6. **Queue Workers**: Set up queue workers for background jobs

### Docker Deployment (Optional)
```dockerfile
# Dockerfile example
FROM php:8.1-fpm
# ... (Docker configuration)
```

## 📝 Development Notes

### Tools Used for Rapid Development
- **Laravel Artisan**: Code generation and scaffolding
- **Laravel Sanctum**: API authentication
- **Tailwind CSS**: Rapid UI development
- **Alpine.js**: Lightweight JavaScript framework

### Performance Optimizations
- Database indexing on email and role columns
- Eager loading for relationships
- Optimized queries with Laravel Eloquent
- File storage optimization

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

## 📞 Support

For questions or issues, please contact the development team or create an issue in the repository.

---

**Built with ❤️ using Laravel, Tailwind CSS, By Salman Javed.**

