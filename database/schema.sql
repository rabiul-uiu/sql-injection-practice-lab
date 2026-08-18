CREATE DATABASE IF NOT EXISTS sql_injection_practice;
USE sql_injection_practice;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    balance DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS bank_accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    account_name VARCHAR(150) NOT NULL,
    account_number VARCHAR(50) NOT NULL UNIQUE,
    balance DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO users (username, password, full_name, email, balance) VALUES
('admin', 'admin123', 'System Admin', 'admin@example.com', 15000.00),
('alice', 'alice123', 'Alice Johnson', 'alice@example.com', 8500.50),
('bob', 'bob123', 'Bob Smith', 'bob@example.com', 4200.75)
ON DUPLICATE KEY UPDATE
    password = VALUES(password),
    full_name = VALUES(full_name),
    email = VALUES(email),
    balance = VALUES(balance);

INSERT INTO bank_accounts (user_id, account_name, account_number, balance)
SELECT id, 'Primary Savings', CONCAT('SA-', LPAD(id, 6, '0')), balance
FROM users
ON DUPLICATE KEY UPDATE
    account_name = VALUES(account_name),
    account_number = VALUES(account_number),
    balance = VALUES(balance);
