
CREATE DATABASE voting_system;


USE voting_system;


CREATE TABLE admins (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL
);


CREATE TABLE candidates (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    status VARCHAR(255) NOT NULL,
    date_registered TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    candidate_id VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL
);


CREATE TABLE students (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(20) NOT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE votes (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(20) NOT NULL,
    vote_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    candidate_id INT(11) NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (candidate_id) REFERENCES candidates(id)
);
