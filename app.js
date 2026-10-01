const express = require('express');
const mysql = require('mysql2');

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware to parse incoming request data
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(express.static(__dirname));

// MySQL Database Configuration
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'my_project_db' // Apne XAMPP phpMyAdmin database ka exact name rakhein
});

// Connect to MySQL Database
db.connect((err) => {
    if (err) {
        console.error('Database connection failed:', err.message);
        return;
    }
    console.log('Database connected successfully!');
});

// Basic Route
app.get('/', (req, res) => {
    res.send('AlumniConnect Node.js Server is active.');
});

// Start Express Server
app.listen(PORT, () => {
    console.log(`Server connected successfully on http://localhost:${PORT}`);
});