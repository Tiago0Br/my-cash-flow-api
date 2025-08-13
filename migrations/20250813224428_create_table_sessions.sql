-- Migration: create_table_sessions
-- Created at: 2025-08-13 22:44:28

CREATE TABLE public.sessions(
    id uuid PRIMARY KEY,
    token varchar(255) NOT NULL,
    user_id int NOT NULL,
    expires_at timestamp NOT NULL,
    FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE
);
