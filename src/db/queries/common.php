<?php

$CREATE_QUERY = "CREATE TABLE IF NOT EXISTS 
                users (
                    user_id  INTEGER PRIMARY KEY,
                    username TEXT TEXT NOT NULL
                );
                CREATE TABLE IF NOT EXISTS  
                messages (
                    message_id INTEGER PRIMARY KEY,
                    message_text TEXT NOT NULL,
                    created_at DATETIME,
                    sender_id INTEGER NOT NULL,
                    recipient_id INTEGER NOT NULL,
                    FOREIGN KEY (recipient_id)
                        REFERENCES users (user_id),
                    FOREIGN KEY (sender_id)
                        REFERENCES users (user_id)
                ); 
                
                INSERT INTO users(username) SELECT 'Harvey Specter'
                WHERE NOT EXISTS(SELECT 1 FROM users WHERE username = 'Harvey Specter');
                INSERT INTO users(username) SELECT 'Louis Litt'
                WHERE NOT EXISTS(SELECT 1 FROM users WHERE username = 'Louis Litt');";

?>