# PHP Assessment API Documentation

## Base URL
```
http://localhost:8000/api
```

## Authentication
All protected endpoints require a Bearer token in the Authorization header:
```
Authorization: Bearer {your_token_here}
```

## Response Format
All API responses follow this consistent format:
```json
{
  "success": boolean,
  "message": "string",
  "data": object|array,
  "errors": object (only on validation failures)
}
```

## Rate Limiting
- **Login attempts**: 5 per minute per IP address
- **Registration**: 3 per minute per IP address
- **General API calls**: 60 per minute per authenticated user

## Endpoints

### Authentication

#### Register User
**POST** `/api/auth/register`

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "Password123!",
  "password_confirmation": "Password123!",
  "phone": "+1234567890",
  "bio": "Software Developer"
}
```

**Validation Rules:**
- `name`: required, string, max 255 characters
- `email`: required, valid email, unique, max 255 characters
- `password`: required, min 8 characters, must contain uppercase, lowercase, and numbers
- `password_confirmation`: required, must match password
- `phone`: optional, string, max 20 characters
- `bio`: optional, string, max 1000 characters

**Success Response (201):**
```json
{
  "success": true,
  "message": "User registered successfully",
  "data": {
    "user": {
      "id": 3,
      "name": "John Doe",
      "email": "john@example.com",
      "phone": "+1234567890",
      "bio": "Software Developer",
      "avatar": null,
      "role": "user",
      "created_at": "2025-07-11T15:30:00.000000Z",
      "updated_at": "2025-07-11T15:30:00.000000Z"
    },
    "token": "3|abc123def456...",
    "token_type": "Bearer"
  }
}
```

#### Login
**POST** `/api/auth/login`

**Request Body:**
```json
{
  "email": "admin@example.com",
  "password": "Admin123!"
}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Login successful",
  "data": {
    "user": {
      "id": 1,
      "name": "Admin User",
      "email": "admin@example.com",
      "phone": "+1234567890",
      "bio": "System Administrator",
      "avatar": null,
      "role": "admin",
      "created_at": "2025-07-11T15:31:30.000000Z",
      "updated_at": "2025-07-11T15:31:30.000000Z"
    },
    "token": "1|xyz789abc123...",
    "token_type": "Bearer"
  }
}
```

**Error Response (401):**
```json
{
  "success": false,
  "message": "Invalid credentials"
}
```

#### Logout
**POST** `/api/auth/logout`

**Headers:** `Authorization: Bearer {token}`

**Success Response (200):**
```json
{
  "success": true,
  "message": "Logout successful"
}
```

#### Get Current User Profile
**GET** `/api/auth/profile`

**Headers:** `Authorization: Bearer {token}`

**Success Response (200):**
```json
{
  "success": true,
  "data": {
    "user": {
      "id": 1,
      "name": "Admin User",
      "email": "admin@example.com",
      "phone": "+1234567890",
      "bio": "System Administrator",
      "avatar": null,
      "role": "admin",
      "created_at": "2025-07-11T15:31:30.000000Z",
      "updated_at": "2025-07-11T15:31:30.000000Z"
    }
  }
}
```

#### Refresh Token
**POST** `/api/auth/refresh`

**Headers:** `Authorization: Bearer {token}`

**Success Response (200):**
```json
{
  "success": true,
  "message": "Token refreshed successfully",
  "data": {
    "user": { /* user object */ },
    "token": "1|new_token_here...",
    "token_type": "Bearer"
  }
}
```

### User Management

#### List All Users (Admin Only)
**GET** `/api/users`

**Headers:** `Authorization: Bearer {admin_token}`

**Query Parameters:**
- `page`: Page number for pagination (optional)

**Success Response (200):**
```json
{
  "success": true,
  "data": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "name": "Admin User",
        "email": "admin@example.com",
        "phone": "+1234567890",
        "bio": "System Administrator",
        "avatar": null,
        "role": "admin",
        "created_at": "2025-07-11T15:31:30.000000Z"
      },
      {
        "id": 2,
        "name": "John Doe",
        "email": "user@example.com",
        "phone": "+0987654321",
        "bio": "Regular user for testing",
        "avatar": null,
        "role": "user",
        "created_at": "2025-07-11T15:31:30.000000Z"
      }
    ],
    "per_page": 10,
    "total": 2
  }
}
```

#### Get Specific User
**GET** `/api/users/{id}`

**Headers:** `Authorization: Bearer {token}`

**Note:** Users can only view their own profile unless they are admin.

**Success Response (200):**
```json
{
  "success": true,
  "data": {
    "user": {
      "id": 2,
      "name": "John Doe",
      "email": "user@example.com",
      "phone": "+0987654321",
      "bio": "Regular user for testing",
      "avatar": null,
      "role": "user",
      "created_at": "2025-07-11T15:31:30.000000Z",
      "updated_at": "2025-07-11T15:31:30.000000Z"
    }
  }
}
```

#### Update Current User Profile
**PUT** `/api/profile`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
  "name": "Updated Name",
  "email": "updated@example.com",
  "phone": "+1111111111",
  "bio": "Updated bio information",
  "password": "NewPassword123!",
  "password_confirmation": "NewPassword123!"
}
```

**Note:** All fields are optional. Password fields are only required if changing password.

**Success Response (200):**
```json
{
  "success": true,
  "message": "Profile updated successfully",
  "data": {
    "user": {
      "id": 2,
      "name": "Updated Name",
      "email": "updated@example.com",
      "phone": "+1111111111",
      "bio": "Updated bio information",
      "avatar": null,
      "role": "user",
      "created_at": "2025-07-11T15:31:30.000000Z",
      "updated_at": "2025-07-11T16:00:00.000000Z"
    }
  }
}
```

#### Update User by ID (Admin Only)
**PUT** `/api/users/{id}`

**Headers:** `Authorization: Bearer {admin_token}`

**Request Body:**
```json
{
  "name": "Updated Name",
  "email": "updated@example.com",
  "phone": "+1111111111",
  "bio": "Updated bio",
  "role": "admin",
  "password": "NewPassword123!",
  "password_confirmation": "NewPassword123!"
}
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "User updated successfully",
  "data": {
    "user": { /* updated user object */ }
  }
}
```

#### Delete User (Admin Only)
**DELETE** `/api/users/{id}`

**Headers:** `Authorization: Bearer {admin_token}`

**Note:** Admins cannot delete their own account.

**Success Response (200):**
```json
{
  "success": true,
  "message": "User deleted successfully"
}
```

#### Upload Avatar
**POST** `/api/profile/avatar`

**Headers:** 
- `Authorization: Bearer {token}`
- `Content-Type: multipart/form-data`

**Request Body:**
```
avatar: [image file]
```

**File Requirements:**
- File types: jpeg, png, jpg, gif
- Maximum size: 2MB

**Success Response (200):**
```json
{
  "success": true,
  "message": "Avatar uploaded successfully",
  "data": {
    "avatar_url": "/storage/avatars/1234567890_1.jpg",
    "user": { /* updated user object with new avatar */ }
  }
}
```

### Utility

#### Health Check
**GET** `/api/health`

**No authentication required**

**Success Response (200):**
```json
{
  "success": true,
  "message": "API is running",
  "timestamp": "2025-07-11T15:37:29.362851Z",
  "version": "1.0.0"
}
```

## Error Responses

### Validation Error (422)
```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "email": ["The email field is required."],
    "password": ["The password must be at least 8 characters."]
  }
}
```

### Unauthorized (401)
```json
{
  "success": false,
  "message": "Unauthenticated."
}
```

### Forbidden (403)
```json
{
  "success": false,
  "message": "Unauthorized. Admin access required."
}
```

### Not Found (404)
```json
{
  "success": false,
  "message": "User not found"
}
```

### Rate Limit Exceeded (429)
```json
{
  "success": false,
  "message": "Too many login attempts. Try again in 60 seconds."
}
```

### Server Error (500)
```json
{
  "success": false,
  "message": "Internal server error",
  "error": "Error details (only in debug mode)"
}
```

## Testing Examples

### Using cURL

#### Login and Get Token
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "admin@example.com",
    "password": "Admin123!"
  }'
```

#### Get User Profile
```bash
curl -X GET http://localhost:8000/api/auth/profile \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

#### Update Profile
```bash
curl -X PUT http://localhost:8000/api/profile \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Updated Name",
    "bio": "Updated bio"
  }'
```

#### Upload Avatar
```bash
curl -X POST http://localhost:8000/api/profile/avatar \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -F "avatar=@/path/to/image.jpg"
```

### Using JavaScript (Axios)

```javascript
// Login
const loginResponse = await axios.post('/api/auth/login', {
  email: 'admin@example.com',
  password: 'Admin123!'
});

const token = loginResponse.data.data.token;

// Set default authorization header
axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

// Get profile
const profile = await axios.get('/api/auth/profile');

// Update profile
const updatedProfile = await axios.put('/api/profile', {
  name: 'Updated Name',
  bio: 'Updated bio'
});
```

## Demo Credentials

### Admin User
- **Email**: admin@example.com
- **Password**: Admin123!
- **Permissions**: Full access to all endpoints

### Regular User
- **Email**: user@example.com
- **Password**: User123!
- **Permissions**: Profile management only

