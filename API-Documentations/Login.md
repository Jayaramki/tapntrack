# Login API Documentation

## Base URL - Dev
```
https://devapi.tapntrack.in/
```
## Authentication
All endpoints require a valid License key. Include the license key in the `X-LICENSE-KEY` header as follows:
```
X-LICENSE-KEY: YOUR_LICENSE_KEY
```
**Failure Response**
```
{
    "error": "License key is required"
}
```

## Endpoints
#### 1. Login API
**URL:** `/api/login`\
**Method:** POST\
**Request Payload:**
```
{
    "username":"admin1"
    "password":"123456"
}
```
**Success Response:**
```
{
    "status": true,
    "message": "User logged in successfully!",
    "token": "<Bearer>"
}
```
**Failure Response**
```
{
    "status": false,
    "message": "Invalid credentials!"
}
```
