# Customer API Documentation

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
### 1. Add Customer

**URL:** `/api/customer`\
**Method:** POST\
**Request Payload:**
```
{
    "franchise_id":1,
    "name":"Customer Name",
    "phone_number":"9876543210",
    "email_id":"customer1@tapntrack.in",
    "address":"Chennai",
    "profession":"Tailor"
}
```
**Success Response:**
```
{
    "status": true,
    "message": "Customer created successfully!",
    "customer": {
        "franchise_id": 1,
        "name": "Customer 222",
        "phone_number": "9876543210",
        "email_id": customer1@tapntrack.in,
        "profession": Tailor,
        "is_active": 1,
        "updated_at": "2024-07-06T11:37:14.000000Z",
        "created_at": "2024-07-06T11:37:14.000000Z",
        "id": 4
    }
}
```
**Failure Response**
```
{
    "message": "The name field is required.",
    "errors": {
        "name": [
            "The name field is required."
        ]
    }
}
```

### 2. Get Customer details

**URL:** `api/customer/{id}`\
**Method:** GET\
**Success Response:**
```
{
    "status": true,
    "message": "Customer fetched successfully!",
    "customer": {
        "id": 2,
        "franchise_id": 1,
        "name": "Customer Tailor",
        "phone_number": "9876543210",
        "email_id": null,
        "address": "Chennai",
        "profession": "Tailor",
        "is_active": 1,
        "is_deleted": "2024-06-27 03:06:37",
        "created_at": "2024-06-27T02:47:44.000000Z",
        "updated_at": "2024-06-27T03:06:37.000000Z"
    }
}
```
**Failure Response**
```
{
    "message": "Unauthenticated."
}
```

### 3. Update customer details

**URL:** `/api/customer/{id}`\
**Method:** PUT\
**Request Payload:**
```
{
    "name":"Customer Tailor 4",
    "phone_number":"9876543210",
    "email_address":"customer2@gmail.com",
    "address":"Chennai",
    "profession":"Tailor",
    "is_active": true
}
```
**Success Response:**
```
{
    "status": true,
    "message": "Customer updated successfully!",
    "customer": {
        "id": 4,
        "franchise_id": 1,
        "name": "Customer Tailor 4",
        "phone_number": "9876543210",
        "email_id": null,
        "address": "Chennai",
        "profession": "Tailor",
        "is_active": true,
        "is_deleted": "2024-07-06 11:38:37",
        "created_at": "2024-07-06T11:37:14.000000Z",
        "updated_at": "2024-07-06T11:44:35.000000Z"
    }
}
```
**Failure Response**
```
{
    "message": "Unauthenticated."
}
```

### 4. Get All Customers List

**URL:** `/api/customers`\
**Method:** GET\
**Success Response:**
```
{
    "status": true,
    "message": "Customers fetched successfully!",
    "customers": [
        {
            "id": 3,
            "franchise_id": 1,
            "name": "Customer 22",
            "phone_number": "9876543210",
            "email_id": null,
            "address": null,
            "profession": null,
            "is_active": 0,
            "is_deleted": null,
            "created_at": "2024-06-27T03:09:51.000000Z",
            "updated_at": "2024-06-27T03:09:51.000000Z"
        }
    ]
}
```
**Failure Response**
```
{
    "status": false,
    "message": "User not found!"
}
```

### 5. Delete Customer

**URL:** `/api/customer/{id}`\
**Method:** DELETE\
**Success Response:**
```
{
    "status": true,
    "message": "Customer deleted successfully!"
}
```
**Failure Responses**
```
{
    "status": false,
    "message": "Customer not found!"
}
```