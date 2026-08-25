-- Migration: insert_categories
-- Created at: 2025-08-28 01:07:12

INSERT INTO categories (title, type) VALUES
('Alimentação', 'expense'),
('Transporte', 'expense'),
('Moradia', 'expense'),
('Educação', 'expense'),
('Lazer', 'expense'),
('Vestuário', 'expense'),
('Outros', 'expense'),
('Salário', 'income'),
('Investimentos', 'income'),
('Freelance', 'income'),
('Outros', 'income');