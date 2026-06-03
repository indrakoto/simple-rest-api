# Simple RESTful PHP API

Aplikasi RESTful API menggunakan Native PHP (OOP).
Merupakan aplikasi sederhana untuk pembelajaran bagi mahasiswa mata kuliah Teknologi Webservice di Universitas Bina Sarana Informatika.
Mahasiswa dapat mempelajari semua sumber kode ini untuk dapat memahami tentang metode REST seperti GET, POST, PUT, DELETE dan sebagainya.

## Database Setup

```sql
CREATE DATABASE news_db;
USE news_db;

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

-- dan seterusnya, dapat dilihat secara lengkap pada folder database/schema.sql
```

**Database Credentials (config/Database.php):**
- Host: localhost
- Database: `news_db`
- User: `root`
- Password: `P@ssword`

## File Structure
```
├── config/Database.php          # PDO Singleton connection
├── models/Kategori.php          # OOP Model (CRUD methods)
├── controllers/BeritaController.php # REST Controller
├── controllers/KategoriController.php # REST Controller
├── controllers/NotesController.php # REST Controller
├── index.php                    # API Router
├── .htaccess                    # Clean URLs
└── README.md                    # This file
```

## Contoh API Endpoints Kategori

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


