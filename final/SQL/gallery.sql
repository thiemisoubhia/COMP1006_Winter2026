/*new resume table*/
CREATE TABLE resumes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    picture VARCHAR(255) NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);