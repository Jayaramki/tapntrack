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

**URL:** `/api/user`\
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
    "is_active": 1
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
        "is_active": 1,
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

**URL:** `api/user`\
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

**URL:** `/api/user/{id}`\
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

**URL:** `/api/user`\
**Method:** PUT\
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

**URL:** `/api/user/{id}`\
**Method:** PUT\
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

**URL:** `api/users`\
**Method:** GET\
**Request Parameters**
- `page_size` (integer, optional): The number of users per page. Default is 10. Range is 1 to 100.
- `page` (integer, optional): The page number to retrieve. Default is 1.
- `search` (string, optional): A general search term to filter users across multiple fields.
- `user_type` (integer, optional): Filter by user type.
- `username` (string, optional): Filter by exact username.
- `first_name` (string, optional): Filter by partial match on first name.
- `last_name` (string, optional): Filter by partial match on last name.
- `email` (string, optional): Filter by partial match on email.
- `phone` (string, optional): Filter by partial match on phone number.
- `address` (string, optional): Filter by partial match on address.
- `is_active` (integer, optional): Filter by active status (1 for active, 0 for inactive).

**Response**
- `status` (boolean): Indicates the success of the request.
- `message` (string): A message describing the result of the request.
- `users` (object): A paginated list of users matching the filters

**Success Response:**
```
{
    "status": true,
    "message": "Users fetched successfully!",
    "users": [
        {
            "status": true,
            "message": "Users fetched successfully!",
            "users": {
                "current_page": 1,
                "data": [
                    {
                        "id": 4,
                        "user_type": 2,
                        "franchise_id": 1,
                        "username": "operator1",
                        "first_name": "Ledger Operator",
                        "last_name": "1",
                        "email": "operator1@fel.com",
                        "email_verified_at": null,
                        "phone": "9876543210",
                        "address": "Chennai",
                        "is_active": 1,
                        "is_deleted": null,
                        "created_at": "2024-07-25T02:28:09.000000Z",
                        "updated_at": "2024-07-25T02:37:27.000000Z"
                    }
                ],
                "first_page_url": "http://127.0.0.1:8000/api/users?page=1",
                "from": 1,
                "last_page": 1,
                "last_page_url": "http://127.0.0.1:8000/api/users?page=1",
                "links": [
                    {
                        "url": null,
                        "label": "&laquo; Previous",
                        "active": false
                    },
                    {
                        "url": "http://127.0.0.1:8000/api/users?page=1",
                        "label": "1",
                        "active": true
                    },
                    {
                        "url": null,
                        "label": "Next &raquo;",
                        "active": false
                    }
                ],
                "next_page_url": null,
                "path": "http://127.0.0.1:8000/api/users",
                "per_page": 10,
                "prev_page_url": null,
                "to": 1,
                "total": 1
            }
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
