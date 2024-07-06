# Line Master API Documentation

## Base URL - Dev
```
https://devapi.tapntrack.in/
```
## Authentication
All endpoints require a valid License key and API token. Include the token in the Authorization header as follows:
```
Authorization: Bearer YOUR_API_TOKEN
X-LICENSE-KEY: YOUR_LICENSE_KEY
```
## Endpoints
#### 1. Add Line API

**URL:** `/api/line-master/add`\
**Method:** POST\
**Request Payload:**
```
{
    "franchise_id": "integer",
    "name": "string",
    "description": "double"
}
```
**Success Response:**
```
{
    "status": true,
    "message": "line created successfully!",
    "loan": {
      "id": "integer",
      "franchise_id": "integer",
      "franchise_id": "integer",
      "name": "string",
      "description": "double"
      "is_deleted": "boolean",
      "created_by": "integer",
      "updated_by": "integer",
      "created_at": "datetime",
      "updated_at": "datetime"
  }
}
```
**Failure Response**
```
{
    "message": "Validation error message"
}
```
