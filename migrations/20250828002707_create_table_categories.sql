-- Migration: create_table_categories
-- Created at: 2025-08-28 00:27:07

CREATE TABLE categories(
    id SERIAL PRIMARY KEY,
    title VARCHAR(80) NOT NULL,
    type VARCHAR(20) NOT NULL CHECK (type IN ('income', 'expense'))
);
