# ChatApplication

A lightweight group chat application built with **PHP, Slim Framework, and a database-backed REST API**, with a browser-based interface for interacting with users, groups, and messages.

## Overview

ChatApplication demonstrates backend API development, database integration, and frontend-to-backend communication. Users can be created, groups can be managed, and messages can be sent and retrieved through REST endpoints.

## Features

- **User Management:** Create and retrieve users.
- **Group Management:** Create groups and retrieve available groups.
- **Group Membership:** Join a group through an API endpoint.
- **Messaging:** Send messages to a group and retrieve message history.
- **Browser UI:** Interact with users, groups, and messages through a simple web interface.
- **Persistent Storage:** Store and retrieve application data from the configured database.

## Tech Stack

- **Backend:** PHP 8.1, Slim Framework
- **Dependency Management:** Composer
- **API:** RESTful HTTP endpoints with JSON request and response bodies
- **Frontend:** HTML, CSS, JavaScript
- **Database:** See the database configuration in the project source
- **Development Environment:** IntelliJ IDEA

## Project Structure

```text
ChatApplication/
├── public/
│   ├── index.php       # API routes and request handling
│   └── chat.html       # Browser-based chat interface
├── src/                # Application classes and database connection
├── database/           # Database-related files
├── composer.json       # PHP dependencies
├── composer.lock       # Locked dependency versions
├── .gitignore
└── readme.md
```

## Getting Started

### Prerequisites

- PHP 8.1 or a compatible version
- Composer dependencies
- The database configured for the application
- Git (optional, for cloning the repository)

### 1. Clone the repository

```bash
git clone https://github.com/SKhan2108/ChatApplication/tree/feature/chat-app
cd ChatApplication
```

Alternatively, open the existing project directory in IntelliJ IDEA.

### 2. Install dependencies

If the project includes `composer.phar`:

```bash
php composer.phar install
```

If Composer is installed globally:

```bash
composer install
```

### 3. Configure the database

Review the database connection settings in `src/` and the database files in `database/`.

Configure the required database connection and initialize the schema before starting the application.

> Database setup instructions should be updated to reflect the actual database engine and schema used by this project.

### 4. Start the application

From the project root, run:

```bash
php -S localhost:8000 -t public
```

Keep the terminal running while testing the application.

### 5. Open the browser interface

Navigate to:

http://localhost:8000/chat.html

The interface allows you to load users and groups, create users and groups, and send and view group messages.

## API Endpoints

Base URL: `http://localhost:8000`

| Method | Endpoint | Description |
|---|---|---|
| POST | `/users` | Create a user |
| GET | `/users` | Retrieve users |
| GET | `/users/{id}` | Retrieve a user by ID |
| POST | `/groups` | Create a group |
| GET | `/groups` | Retrieve groups |
| POST | `/groups/{id}/join` | Join a group |
| GET | `/groups/{id}/messages` | Retrieve group messages |
| POST | `/groups/{id}/messages` | Send a group message |
| GET | `/groups/{id}/members` | Retrieve group members |

### Example: Retrieve users

```bash
curl http://localhost:8000/users
```

### Example: Send a message

```bash
curl -X POST http://localhost:8000/groups/1/messages \
  -H "Content-Type: application/json" \
  -d '{"user_id":1,"content":"Hello from ChatApplication!"}'
```

### Example: Retrieve group messages

```bash
curl http://localhost:8000/groups/1/messages
```

## Testing

The implemented endpoints have been manually tested using PowerShell HTTP requests and the browser interface.

Recommended next steps include adding automated API tests, input validation tests, and negative test cases.

## Future Enhancements

- User authentication and authorization
- Group membership validation
- Automated API and integration tests
- Improved request validation and error handling
- Real-time messaging using WebSockets or another push-based mechanism
- Deployment and environment-specific configuration

## Project Purpose

This project demonstrates practical experience with REST API development, PHP application structure, database-backed operations, and browser-based API integration.

---

**Note:** This is a learning and portfolio project. Review the security, validation, and deployment configuration before using it in a production environment.