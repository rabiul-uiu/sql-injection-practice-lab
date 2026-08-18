USE sql_injection_practice;

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
