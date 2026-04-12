# Chat Backend API (PHP - Slim)

This project is a simple chat backend built using PHP and Slim Framework.  
It provides APIs to manage users, chat groups, group memberships, and messages.

---

## 🚀 Tech Stack

- PHP 8+
- Slim Framework
- SQLite (or PDO-supported DB)
- REST API

---

## 📂 Project Setup

### 1. Clone the repository
git clone https://github.com/SKhan2108/ChatApplication.git
cd chat-backend

### 2. Install dependencies
composer install

### 3. Run the application
php -S localhost:8080 -t public

Server will start at:
http://localhost:8080

---

## 🗄️ Database Setup

Run the following SQL to create tables:

CREATE TABLE IF NOT EXISTS users (
id INTEGER PRIMARY KEY AUTOINCREMENT,
username TEXT UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS chat_groups (
id INTEGER PRIMARY KEY AUTOINCREMENT,
name TEXT UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS group_members (
user_id INTEGER,
group_id INTEGER,
PRIMARY KEY (user_id, group_id)
);

CREATE TABLE IF NOT EXISTS messages (
id INTEGER PRIMARY KEY AUTOINCREMENT,
user_id INTEGER,
group_id INTEGER,
content TEXT NOT NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

---

## 📌 API Endpoints

### 👤 Users

POST /users  
GET /users  
GET /users/{id}

---

### 👥 Groups

POST /groups  
GET /groups  
GET /groups/{id}

---

### 👥 Group Members

POST /groups/{group_id}/join  
GET /groups/{group_id}/members

---

### 💬 Messages

POST /groups/{group_id}/messages  
GET /groups/{group_id}/messages

---

## 🧪 Testing

You can test APIs using Postman or cURL.

Example:
curl -X GET http://localhost:8080/users

---

## ⚠️ Notes

- Ensure database connection is properly configured
- All responses are returned in JSON format
- Error handling is implemented for missing inputs

---

## 👩‍💻 Author

Khan Shama Khanum Akbar
Senior Software Engineer

> Coding assessment submission for bunq 🚀

