# Alumni Registration - Web Engineering Lab

## Requirements

- Node.js
- XAMPP (Apache is optional; MySQL must be running)
- MySQL / MariaDB

## Installation

1. Extract the project.
2. Open a terminal in the project folder.
3. Run:
   npm install
4. Start MySQL in XAMPP.
5. Import `database.sql` into phpMyAdmin, or run it in MySQL.
6. Run:
   node app.js
7. Open:
   http://localhost:3000

## Uploads

The application creates:

- public/uploads/ for profile images
- public/uploads/documents/ for resumes

Maximum file size: 2 MB per file.
