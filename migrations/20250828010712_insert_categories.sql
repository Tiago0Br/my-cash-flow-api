-- Migration: insert_categories
-- Created at: 2025-08-28 01:07:12

INSERT INTO categories (title, type) VALUES
('Alimentação', 'expense'),
('Transporte', 'income'),
('Moradia', 'income'),
('Educação', 'income'),
('Lazer', 'income'),
('Vestuário', 'income'),
('Outros', 'income'),
('Salário', 'expense'),
('Investimentos', 'expense'),
('Freelance', 'expense'),
('Outros', 'expense');