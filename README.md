# SQL Injection Practice Lab

This project is a deliberately vulnerable PHP/MySQL application created for educational SQL injection practice in a local lab environment.

## What this project includes
- Login page
- Registration page
- Dashboard with user profile and bank balance
- MySQL database and seed data
- SQL injection demo flow

## Local setup
1. Put this project inside your local PHP development environment, such as Laragon, XAMPP, WAMP, or any Apache + MySQL setup.
2. Start Apache and MySQL in your local server stack.
3. Make sure the MySQL user is configured as:
   - username: `root`
   - password: empty string
4. Open this URL in your browser:
   - `http://localhost/sql-injection/setup_database.php`
5. After setup, open:
   - `http://localhost/sql-injection/login.php`

## Quick local PHP run
If you want to run it without a full local server stack, from the project folder run:

```bash
php -S 127.0.0.1:8000
```

Then open:
- `http://127.0.0.1:8000/login.php`

## Default demo users
- username: `admin` / password: `admin123`
- username: `alice` / password: `alice123`
- username: `bob` / password: `bob123`

## Database name
- `sql_injection_practice`

## GitHub publishing
When you push to GitHub, remember to include a clear note in the repository description that this project is an intentionally vulnerable educational lab.

## About the author
This project was created by Rabiul Islam.

- GitHub: https://github.com/rabiul-uiu
- LinkedIn: https://linkedin.com/in/rabiul-islam-in

## Files created
- `index.php`
- `login.php`
- `register.php`
- `dashboard.php`
- `logout.php`
- `database/schema.sql`
- `database/seed.sql`
- `scripts/setup_database.php`
- `includes/config.php`
- `includes/db.php`
- `assets/styles.css`

