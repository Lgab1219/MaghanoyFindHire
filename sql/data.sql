CREATE TABLE accounts (
    accountID INT AUTO_INCREMENT PRIMARY KEY,
    fname VARCHAR(255),
    lname VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255),
    role VARCHAR(255)
);

CREATE TABLE job_posts (
    postID INT AUTO_INCREMENT PRIMARY KEY,
    post_title VARCHAR(255),
    post_desc VARCHAR(255),
    fname VARCHAR(255),
    lname VARCHAR(255),
    date_posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE applications (
    applicationID INT AUTO_INCREMENT PRIMARY KEY,
    postID INT,
    accountID INT,
    fname VARCHAR(255),
    lname VARCHAR(255),
    applicant_message VARCHAR(255),
    resumeFile VARCHAR(255)
);

CREATE TABLE accepted_applications (
    applicationID INT AUTO_INCREMENT PRIMARY KEY,
    postID INT,
    accountID INT,
    fname VARCHAR(255),
    lname VARCHAR(255)
);

CREATE TABLE rejected_applications (
    applicationID INT AUTO_INCREMENT PRIMARY KEY,
    postID INT,
    accountID INT,
    fname VARCHAR(255),
    lname VARCHAR(255)
);

CREATE TABLE hr_messages (
    messageID INT AUTO_INCREMENT PRIMARY KEY,
    accountID INT,
    message VARCHAR(255)
);

CREATE TABLE applicant_messages (
    messageID INT AUTO_INCREMENT PRIMARY KEY,
    accountID INT,
    message VARCHAR(255)
);