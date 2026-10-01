const express = require('express');
const mysql = require('mysql2');
const bcrypt = require('bcrypt');
const session = require('express-session');
const path = require('path');

const app = express();

// Body Parser & Static Files Setup
app.use(express.urlencoded({ extended: true }));
app.use(express.json());
app.use(express.static(path.join(__dirname, 'public')));

// View Engine Setup (EJS)
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

// Express Session Configuration
app.use(session({
    secret: 'sukkur_iba_alumni_secret_key',
    resave: false,
    saveUninitialized: false
}));

// MySQL Database Connection
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'my_project_db'
});

db.connect((err) => {
    if (err) {
        console.error('Database connection failed:', err.message);
    } else {
        console.log('Connected to my_project_db successfully.');
    }
});

// Middleware: Protected Route Check
const isAuthenticated = (req, res, next) => {
    if (req.session.user) {
        return next();
    }
    res.redirect('/login');
};

// ================= APP ROUTES ================= //

// 1. Home Page Route
app.get('/', (req, res) => {
    res.render('index');
});

// 2. Register Routes
app.get('/register', (req, res) => {
    res.render('register', { error: null });
});

app.post('/register', async (req, res) => {
    const { full_name, email, batch, department, organization, password } = req.body;

    try {
        db.query('SELECT * FROM users WHERE email = ?', [email], async (err, results) => {
            if (err) {
                console.error(err);
                return res.render('register', { error: 'Database query error.' });
            }

            if (results.length > 0) {
                return res.render('register', { error: 'An account with this email already exists.' });
            }

            const hashedPassword = await bcrypt.hash(password, 10);

            const sql = 'INSERT INTO users (full_name, email, batch, department, organization, password) VALUES (?, ?, ?, ?, ?, ?)';
            db.query(
                sql,
                [full_name, email, batch || null, department || null, organization || null, hashedPassword],
                (err, result) => {
                    if (err) {
                        console.error(err);
                        return res.render('register', { error: 'Failed to create account. Please try again.' });
                    }
                    res.redirect('/login');
                }
            );
        });
    } catch (error) {
        res.render('register', { error: 'Server error. Please try again.' });
    }
});

// 3. Login Routes
app.get('/login', (req, res) => {
    res.render('login', { error: null });
});

app.post('/login', (req, res) => {
    const { email, password } = req.body;

    db.query('SELECT * FROM users WHERE email = ?', [email], async (err, results) => {
        if (err) {
            console.error(err);
            return res.render('login', { error: 'Database error. Please try again.' });
        }

        if (results.length === 0) {
            return res.render('login', { error: 'No account found with this email.' });
        }

        const user = results[0];

        // Hashed Password Check
        const isMatch = await bcrypt.compare(password, user.password);

        if (!isMatch) {
            // Updated error message to English
            return res.render('login', { error: 'Incorrect password.' });
        }

        // Active Session Save
        req.session.user = {
            id: user.id,
            full_name: user.full_name,
            email: user.email,
            batch: user.batch,
            department: user.department,
            organization: user.organization
        };

        res.redirect('/profile');
    });
});

// 4. Profile View Route
app.get('/profile', isAuthenticated, (req, res) => {
    res.render('profile', { user: req.session.user });
});

// 5. Edit Profile GET & POST Routes
app.get('/profile/edit', isAuthenticated, (req, res) => {
    res.render('edit-profile', { user: req.session.user, error: null });
});

app.post('/profile/edit', isAuthenticated, (req, res) => {
    const { full_name, batch, department, organization } = req.body;
    const userId = req.session.user.id;

    if (!full_name || full_name.trim() === '') {
        return res.render('edit-profile', { 
            user: req.session.user, 
            error: 'Full Name is required.' 
        });
    }

    const sql = 'UPDATE users SET full_name = ?, batch = ?, department = ?, organization = ? WHERE id = ?';
    db.query(sql, [full_name, batch || null, department || null, organization || null, userId], (err, result) => {
        if (err) {
            console.error('Error updating profile:', err);
            return res.render('edit-profile', { 
                user: req.session.user, 
                error: 'Could not update profile. Please try again.' 
            });
        }

        // Session variables update
        req.session.user.full_name = full_name;
        req.session.user.batch = batch;
        req.session.user.department = department;
        req.session.user.organization = organization;

        res.redirect('/profile');
    });
});

// 6. Alumni Directory Route
app.get('/alumni', isAuthenticated, (req, res) => {
    const searchQuery = req.query.search;
    let sql = 'SELECT id, full_name, email, batch, department, organization FROM users';
    let queryParams = [];

    if (searchQuery) {
        sql += ' WHERE full_name LIKE ? OR email LIKE ? OR department LIKE ? OR organization LIKE ?';
        const term = `%${searchQuery}%`;
        queryParams = [term, term, term, term];
    }

    db.query(sql, queryParams, (err, results) => {
        if (err) {
            console.error(err);
            return res.render('alumni', { alumniList: [] });
        }
        res.render('alumni', { alumniList: results });
    });
});

// 7. Logout Route
app.get('/logout', (req, res) => {
    req.session.destroy(() => {
        res.redirect('/login');
    });
});

// Server Listen
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server running on http://localhost:${PORT}`);
});