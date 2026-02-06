CREATE TABLE subscribers (
  id INT AUTO_INCREMENT primary key,
  first_name varchar(100),
  last_name varchar(100),
  email varchar(150),
  subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
