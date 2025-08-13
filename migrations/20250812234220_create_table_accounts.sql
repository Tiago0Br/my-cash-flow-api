-- Migration: create_table_accounts
-- Created at: 2025-08-12 23:42:20

CREATE TABLE public.accounts(
    id SERIAL PRIMARY KEY,
    name VARCHAR(80) NOT NULL,
    type VARCHAR(80) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT NOW(),
    updated_at TIMESTAMP
);
