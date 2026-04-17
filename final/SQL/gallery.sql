CREATE TABLE gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    picture VARCHAR(255) NULL,
    title VARCHAR(255) NULL,
    FOREIGN KEY (user_id) REFERENCES final_users(id)
);