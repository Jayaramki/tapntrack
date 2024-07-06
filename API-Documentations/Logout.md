# Logout API Documentation

## Base URL - Dev
```
https://devapi.tapntrack.in/
```
## Authentication
All endpoints require a valid License key and a valid API token. Include the license key in the `X-LICENSE-KEY` and include the token in the Authorization header as follows:
```
Authorization: Bearer YOUR_API_TOKEN
X-LICENSE-KEY: YOUR_LICENSE_KEY
```
**Failure Response**
```
{
    "error": "License key is required"
}
```

## Endpoints
#### 1. Logout API
**URL:** `/api/logout`\
**Method:** GET\
**Success Response:**
```
{
    "status": true,
    "message": "User logged out successfully!"
}
```
