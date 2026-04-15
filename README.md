# Simple RESTful PHP API

Native PHP OOP implementation of RESTful API with full CRUD operations.

## Database Setup

```sql
CREATE DATABASE mydb;
USE mydb;

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
);
```

**Database Credentials (config/Database.php):**
- Host: localhost
- Database: `mydb`
- User: `root`
- Password: `P@ssword`

## File Structure
```
├── config/Database.php          # PDO Singleton connection
├── models/Kategori.php          # OOP Model (CRUD methods)
├── controllers/KategoriController.php # REST Controller
├── index.php                    # API Router
├── .htaccess                    # Clean URLs
├── TODO.md                      # Progress tracker
└── README.md                    # This file
```

## API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/kategori` | List all categories |
| `GET` | `/kategori/{id}` | Get category by ID |
| `POST` | `/kategori` | Create new category |
| `PUT` | `/kategori/{id}` | Update category |
| `DELETE` | `/kategori/{id}` | Delete category |

## Run Server

```bash
# Development server
php -S localhost:8000

# Or with Apache (needs mod_rewrite)
# Put in Apache htdocs and access http://localhost/simple-rest-api/
```

## Test Endpoints (curl examples)

```bash
# 1. GET all categories
curl -X GET http://localhost:8000/kategori

# 2. POST create category
curl -X POST http://localhost:8000/kategori \
  -H "Content-Type: application/json" \
  -d '{"nama_kategori": "Elektronik"}'

# 3. GET by ID (assume ID=1)
curl -X GET http://localhost:8000/kategori/1

# 4. PUT update (ID=1)
curl -X PUT http://localhost:8000/kategori/1 \
  -H "Content-Type: application/json" \
  -d '{"nama_kategori": "Gadget"}'

# 5. DELETE (ID=1)
curl -X DELETE http://localhost:8000/kategori/1
```

## Response Format
```json
{
  "status": "success",
  "data": [...] // or "message": "..."
}
```

## Features
✅ **Native PHP OOP** (no frameworks)  
✅ **Full CRUD operations**  
✅ **JSON API responses**  
✅ **Error handling** (404, 405, 400, 500)  
✅ **CORS enabled**  
✅ **Input validation**  
✅ **PDO prepared statements** (SQL injection safe)  
✅ **Clean URLs** (.htaccess)


