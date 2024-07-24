# Loan API Documentation

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
#### 1. Add Loan API

**URL:** `/api/loan`\
**Method:** POST\
**Request Payload:**
```
{
    "cid": "integer",
    "loan_number": "string",
    "disbursed_amt": "double",
    "loan_type": "string",
    "line_id": "integer",
    "interest_amount": "double",
    "installment_amount": "integer",
    "disbursed_at": "date"
}
```
**Success Response:**
```
{
    "status": true,
    "message": "loan created successfully!",
    "loan": {
      "id": "integer",
      "franchise_id": "integer",
      "cid": "integer",
      "loan_number": "string",
      "disbursed_amt": "double",
      "loan_type": "string",
      "line_id": "integer",
      "interest_amt": "double",
      "installment_amt": "integer",
      "disbursed_at": "date",
      "completed_at": "date",
      "is_deleted": "boolean",
      "created_by": "integer",
      "updated_by": "integer",
      "created_at": "date",
      "updated_at": "date"
  }
}
```
**Failure Response**
```
{
    "message": "Validation error message"
}
```

### 2. Get Loan API

**URL:** `/api/loan/{id}`\
**Method:** GET\
**Success Response:**
```
{
    "status": true,  
    "loan": {
      "id": "integer",
      "franchise_id": "integer",
      "cid": "integer",
      "loan_number": "string",
      "disbursed_amt": "double",
      "loan_type": "string",
      "line_id": "integer",
      "interest_amt": "double",
      "installment_amt": "integer",
      "disbursed_at": "date",
      "completed_at": "date",
    "is_deleted": "boolean",
      "created_by": "integer",
      "updated_by": "integer",
      "created_at": "date",
      "updated_at": "date"
  }
}
```
**Failure Response**
```
{
    "message": "loan not found"
}
```

### 3. Update Loan API

**URL:** `/api/loan/{id}`\
**Method:** PUT\
**Request Payload:**
```
{
    "cid": "integer",
    "loan_number": "string",
    "disbursed_amt": "double",
    "loan_type": "string",
    "line_id": "integer",
    "interest_amount": "double",
    "installment_amount": "integer",
    "disbursed_at": "date"
}
```
**Success Response:**
```
{
    "status": true,
    "message": "loan updated successfully!",
    "loan": {
      "id": "integer",
      "franchise_id": "integer",
      "cid": "integer",
      "loan_number": "string",
      "disbursed_amt": "double",
      "loan_type": "string",
      "line_id": "integer",
      "interest_amt": "double",
      "installment_amt": "integer",
      "disbursed_at": "date",
      "completed_at": "date",
      "is_deleted": "boolean",
      "created_by": "integer",
      "updated_by": "integer",
      "created_at": "date",
      "updated_at": "date"
  }
}
```
**Failure Response**
```
{
    "message": "Validation error message"
}
```

### 4. Delete Loan API

**URL:** `/api/loan/{id}`\
**Method:** DELETE\
**Success Response:**
```
{
    "status": true,
    "message": "loan deleted successfully!"
}
```
**Failure Response**
```
{
    "message": "loan not found"
}
```


