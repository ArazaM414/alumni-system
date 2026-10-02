# Alumni Management System - Web Engineering Lab

An interactive, full-stack Alumni Management Web Application built with **Node.js**, **Express.js**, **EJS**, and **MySQL**. This platform enables alumni to connect, register accounts, manage professional profiles, upload documents, and explore the alumni directory.

---

## Features

- **User Authentication & Security**
  - Secure registration and login flow.
  - Password encryption using `bcrypt` hashing.
  - Session-based authentication with protected routes via custom middleware.

- **Profile Management**
  - View and edit profile details (Name, Email, Batch, Department, Organization, etc.).
  - Avatar image upload support (`public/uploads/`).
  - Resume / Document upload support (`public/uploads/documents/`).
  - File upload restrictions (Maximum size: **2 MB** per file).

- **Alumni Directory & Search**
  - Search alumni records by Name, Email, Department, or Organization.
  - Prepared SQL queries to prevent SQL Injection vulnerabilities.

---

## Tech Stack & Dependencies

- **Backend Framework:** Node.js, Express.js
- **Database:** MySQL / MariaDB (managed via XAMPP / phpMyAdmin)
- **Templating Engine:** EJS (Embedded JavaScript)
- **Authentication & Security:** `bcrypt`, `express-session`
- **File Upload Handling:** `multer`

---

## Prerequisites

Ensure you have the following installed on your local machine:

1. **Node.js** (v14+ recommended)
2. **XAMPP** (MySQL service must be running)
3. **Git** (optional, for version control)

---

## Directory Structure

```text
.
├── app.js                  # Main server entry point
├── database.sql            # Database schema & initial data
├── package.json            # Project dependencies & scripts
├── public/
│   ├── css/                # Stylesheets
│   └── uploads/            # Profile pictures
│       └── documents/      # Uploaded resumes / documents
├── views/                  # EJS template views
│   ├── alumni.ejs
│   ├── login.ejs
│   ├── profile.ejs
│   ├── edit-profile.ejs
│   └── register.ejs
└── README.md               # Project documentation