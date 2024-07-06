# User API Documentation

## Base URL - Dev
```
https://devapi.tapntrack.in/
```
## Authentication
All endpoints require a valid License key. Include the License key in the `X-LICENSE-KEY` header as follows:
```
X-LICENSE-KEY: YOUR_LICENSE_KEY
```
## Endpoints
### 1. Add Admin User API ***(Only for internal purpose)***

**URL:** `/api/user/add-admin-user`\
**Method:** POST\
**Request Payload:**
```
{
    "username":"admin3",
    "password":"123456",
    "password_confirmation":"123456",
    "first_name":"Admin",
    "last_name":"3",
    "email":"admin3@fel.com",
    "phone":"9876543210",
    "address":"Chennai",
    "is_active": true
}
```
**Success Response:**
```
{
    "status": true,
    "message": "Admin created successfully!",
    "user": {
        "user_type": "1",
        "franchise_id": 0,
        "username": "admin3",
        "first_name": "Admin",
        "last_name": "3",
        "email": "admin3@fel.com",
        "phone": "9876543210",
        "address": "Chennai",
        "is_active": true,
        "updated_at": "2024-06-16T07:55:25.000000Z",
        "created_at": "2024-06-16T07:55:25.000000Z",
        "id": 3
    }
}
```
**Failure Response**
```
{
    "message": "The username field is required.",
    "errors": {
        "username": [
            "The username field is required."
        ]
    }
}
```

### 2. Update Admin User API ***(Only for internal purpose)***

**URL:** `/api/user/update-admin/{id}`\
**Method:** POST\
**Request Payload:**
```
{
    "username":"admin3",
    "password":"123456",
    "first_name":"Admin",
    "last_name":"3",
    "email":"admin3@fel.com",
    "phone":"9876543210",
    "address":"Chennai",
    "is_active": true
}
```
**Success Response:**
```
{
    "status": true,
    "message": "Admin updated successfully!",
    "user": {
        "user_type": "1",
        "franchise_id": 0,
        "username": "admin3",
        "first_name": "Admin",
        "last_name": "3",
        "email": "admin3@fel.com",
        "phone": "9876543210",
        "address": "Chennai",
        "is_active": true,
        "updated_at": "2024-06-16T07:55:25.000000Z",
        "created_at": "2024-06-16T07:55:25.000000Z",
        "id": 3
    }
}
```
**Failure Response**
```
{
    "status": false,
    "message": "User not found!"
}
```
```
{
    "message": "The username field is required.",
    "errors": {
        "username": [
            "The username field is required."
        ]
    }
}
```
