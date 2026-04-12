CREATE TABLE IF NOT EXISTS users (
                                     id INTEGER PRIMARY KEY AUTOINCREMENT,
                                     username TEXT UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS chat_groups (
                                           id INTEGER PRIMARY KEY AUTOINCREMENT,
                                           name TEXT UNIQUE NOT NULL
);

CREATE TABLE IF NOT EXISTS group_members (
                                             user_id INTEGER,
                                             group_id INTEGER,
                                             PRIMARY KEY (user_id, group_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (group_id) REFERENCES chat_groups(id)
    );

CREATE TABLE IF NOT EXISTS messages (
                                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                                        user_id INTEGER,
                                        group_id INTEGER,
                                        content TEXT NOT NULL,
                                        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                                        FOREIGN KEY (user_id) REFERENCES users(id),
                                        FOREIGN KEY (group_id) REFERENCES chat_groups(id)
);
