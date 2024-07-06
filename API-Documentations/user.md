# User API Documentation

## Base URL - Dev
```
https://devapi.tapntrack.in/
```
## Authentication
All endpoints require a valid License key and API token. Include the License key in the `X-LICENSE-KEY` header and the API token in the Authorization header as follows:
```
Authorization: Bearer YOUR_API_TOKEN
X-LICENSE-KEY: YOUR_LICENSE_KEY
```
## Endpoints
### 1. Add User

**URL:** `/api/user/add`\
**Method:** POST\
**Request Payload:**
```
{
    "user_type": 3,
    "username":"agent2",
    "password":"123456",
    "password_confirmation":"123456",
    "first_name":"Agent",
    "last_name":"2",
    "email":"agent2@fel.com",
    "phone":"9876543210",
    "address":"Chennai",
    "is_active": true
}
```
**Success Response:**
```
{
    "status": true,
    "message": "User created successfully!",
    "user": {
        "user_type": 3,
        "franchise_id": 1,
        "username": "agent2",
        "first_name": "Agent",
        "last_name": "2",
        "email": "agent2@fel.com",
        "phone": "9876543210",
        "address": "Chennai",
        "is_active": true,
        "updated_at": "2024-06-17T03:13:01.000000Z",
        "created_at": "2024-06-17T03:13:01.000000Z",
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

### 2. Get LoggedIn User Profile

**URL:** `api/user/get`\
**Method:** GET\
**Success Response:**
```
{
    "status": true,
    "message": "User profile fetched successfully!",
    "user": {
        "id": 1,
        "user_type": 1,
        "franchise_id": 0,
        "username": "admin1",
        "first_name": "Admin",
        "last_name": "1",
        "email": "admin1@fel.com",
        "email_verified_at": null,
        "phone": "9876543210",
        "address": "Chennai",
        "is_active": 1,
        "is_deleted": null,
        "created_at": "2024-06-15T10:45:13.000000Z",
        "updated_at": "2024-06-15T10:45:13.000000Z"
    }
}
```
**Failure Response**
```
{
    "message": "Unauthenticated."
}
```

### 3. Get User By ID

**URL:** `/api/user/get/{id}`\
**Method:** GET\
**Success Response:**
```
{
    "status": true,
    "message": "User fetched successfully!",
    "user": {
        "id": 1,
        "user_type": 1,
        "franchise_id": 0,
        "username": "admin1",
        "first_name": "Admin",
        "last_name": "1",
        "email": "admin1@fel.com",
        "email_verified_at": null,
        "phone": "9876543210",
        "address": "Chennai",
        "is_active": 1,
        "is_deleted": null,
        "created_at": "2024-06-15T10:45:13.000000Z",
        "updated_at": "2024-06-15T10:45:13.000000Z"
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

### 4. Update LoggedIn user profile

**URL:** `/api/user/update`\
**Method:** POST\
**Request Payload:**
```
{
    "first_name": "Administrator",
    "last_name": "One",
    "phone": "9876543210",
    "email": "administrator01@fel.com",
    "address": "Chennai",
    "is_active": false
}
```
**Success Response:**
```
{
    "status": true,
    "message": "User profile updated successfully!",
    "user": {
        "id": 1,
        "user_type": 1,
        "franchise_id": 0,
        "username": "admin1",
        "first_name": "Administrator",
        "last_name": "One",
        "email": "admin1@fel.com",
        "email_verified_at": null,
        "phone": "9876543210",
        "address": "Chennai",
        "is_active": false,
        "is_deleted": null,
        "created_at": "2024-06-15T10:45:13.000000Z",
        "updated_at": "2024-06-16T15:08:27.000000Z"
    }
}
```
**Failure Response**
```
{
    "message": "Unauthenticated."
}
```

### 5. Update User By ID

**URL:** `/api/user/update/{id}`\
**Method:** POST\
**Request Payload:**
```
{
    "first_name": "Administrator",
    "last_name": "One",
    "phone": "9876543210",
    "email": "administrator01@fel.com",
    "address": "Chennai",
    "is_active": false
}
```
**Success Response:**
```
{
    "status": true,
    "message": "User profile updated successfully!",
    "user": {
        "id": 1,
        "user_type": 1,
        "franchise_id": 0,
        "username": "admin1",
        "first_name": "Administrator",
        "last_name": "One",
        "email": "admin1@fel.com",
        "email_verified_at": null,
        "phone": "9876543210",
        "address": "Chennai",
        "is_active": false,
        "is_deleted": null,
        "created_at": "2024-06-15T10:45:13.000000Z",
        "updated_at": "2024-06-16T15:08:27.000000Z"
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

### 6. Change Password for loggedIn User

**URL:** `/api/user/change-password`\
**Method:** POST\
**Request Payload:**
```
{
        "old_password": "123456",
        "new_password": "1234567"
}
```
**Success Response:**
```
{
    "status": true,
    "message": "User password updated successfully!"
}
```
**Failure Responses**
```
{
    "status": false,
    "message": "Invalid old password!"
}
```
```
{
    "message": "The old password field is required.",
    "errors": {
        "old_password": [
            "The old password field is required."
        ]
    }
}
```

### 7. Admin Changing Password for other users

**URL:** `/api/user/update-password/{id}`\
**Method:** POST\
**Request Payload:**
```
{
    "password": "1234567"
}
```
**Success Response:**
```
{
    "status": true,
    "message": "User password updated successfully!"
}
```
**Failure Responses**
```
{
    "status": false,
    "message": "User not found!"
}
```
```
{
    "message": "The password field is required.",
    "errors": {
        "password": [
            "The password field is required."
        ]
    }
}
```

### 8. Admin Changing Username for other users

**URL:** `/api/user/update-username/{id}`\
**Method:** POST\
**Request Payload:**
```
{
    "username": "agent1"
}
```
**Success Response:**
```
{
    "status": true,
    "message": "Username has been updated successfully!"
}
```
**Failure Responses**
```
{
    "status": false,
    "message": "User not found!"
}
```
```
{
    "message": "The username has already been taken.",
    "errors": {
        "username": [
            "The username has already been taken."
        ]
    }
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

### 9. Get All Users
This API will be used for Admin user to get list of all users under his profile

**URL:** `api/user/get-all`\
**Method:** GET\
**Success Response:**
```
{
    "status": true,
    "message": "Users fetched successfully!",
    "users": [
        {
            "id": 2,
            "user_type": 3,
            "franchise_id": 1,
            "username": "agent1",
            "first_name": "Agent",
            "last_name": "1",
            "email": "agent1@fel.com",
            "email_verified_at": null,
            "phone": "9876543210",
            "address": "Chennai",
            "is_active": 1,
            "is_deleted": null,
            "created_at": "2024-06-16T17:29:48.000000Z",
            "updated_at": "2024-06-16T17:51:41.000000Z"
        },
        {
            "id": 3,
            "user_type": 3,
            "franchise_id": 1,
            "username": "agent2",
            "first_name": "Agent",
            "last_name": "2",
            "email": "agent2@fel.com",
            "email_verified_at": null,
            "phone": "9876543210",
            "address": "Chennai",
            "is_active": 1,
            "is_deleted": null,
            "created_at": "2024-06-17T03:13:01.000000Z",
            "updated_at": "2024-06-17T03:13:01.000000Z"
        }
    ]
}

### 10. Delete User
This API will be used for Admin user to get list of all users under his profile

**URL:** `api/user/delete`\
**Method:** POST\
**Request Payload:**
```
{
    "user_id": 2
}
```

**Success Response:**
```
{
    "status": true,
    "message": "User deleted successfully!"
}
```
**Failure Response**
```
{
    "status": false,
    "message": "User not found!"
}
```
