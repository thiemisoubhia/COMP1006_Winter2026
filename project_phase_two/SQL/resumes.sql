/*new resume table*/
CREATE TABLE resumes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    position VARCHAR(150) NOT NULL,
    skills TEXT NOT NULL,
    email VARCHAR(150) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    bio TEXT NOT NULL,
    user_id INT NOT NULL,
    picture VARCHAR(255) NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);