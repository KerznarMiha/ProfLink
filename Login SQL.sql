CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);


INSERT INTO users (username, email, password)
VALUES ('test', 'test@example.com', SHA2('test', 256));


SELECT user_id, username
FROM users
WHERE username = 'test'
  AND password = SHA2('test', 256);
