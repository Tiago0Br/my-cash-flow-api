-- Migration: create_table_transactions
-- Created at: 2025-09-04 00:45:46

CREATE table public.transactions(
    id SERIAL PRIMARY KEY,
    title VARCHAR(80) NOT NULL,
    description TEXT,
    amount NUMERIC(15, 2) NOT NULL CHECK (amount >= 0),
    type VARCHAR(20) NOT NULL CHECK (type IN ('income', 'expense')),
    account_id INT NOT NULL,
    category_id INT NOT NULL,
    transaction_date TIMESTAMP NOT NULL DEFAULT NOW(),
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP,
    FOREIGN KEY(account_id) REFERENCES accounts(id) ON DELETE CASCADE,
    FOREIGN KEY(category_id) REFERENCES categories(id) ON DELETE CASCADE
);
