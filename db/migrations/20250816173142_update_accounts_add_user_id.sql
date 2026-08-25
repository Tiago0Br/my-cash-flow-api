-- Migration: update_accounts_add_user_id
-- Created at: 2025-08-16 17:31:42

ALTER TABLE public.accounts ADD COLUMN user_id INT;
ALTER TABLE public.accounts ADD CONSTRAINT fk_accounts_user FOREIGN KEY (user_id) REFERENCES public.users (id);