-- ----------------------------------------------------
-- USERS TABLE: Stores user accounts (login info & roles)
-- ----------------------------------------------------
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,      -- store hashed passwords
    role INT NOT NULL DEFAULT 0           -- 1 = admin, 0 = user
);

-- Example Insert admin user (password should be hashed, here just plain text for example)
INSERT INTO users (username, password, role) VALUES ('admin', 'adminpassword', 1);
INSERT INTO users (username, password, role) VALUES ('user1', 'userpassword', 0);


-- ----------------------------------------------------
-- STUDENTS TABLE: Stores student details
-- ----------------------------------------------------
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,           -- student full name
    email VARCHAR(255) DEFAULT NULL,      -- student email, optional
    subject VARCHAR(255) NOT NULL,         -- subject or major
    course VARCHAR(255) DEFAULT NULL,      -- course name or code, optional
    status VARCHAR(10) NOT NULL            -- e.g. 'pass' or 'fail'
);

-- ----------------------------------------------------
-- ALTER TABLES (If you started without email or course columns)
-- ----------------------------------------------------
-- ALTER TABLE students ADD COLUMN email VARCHAR(255);
-- ALTER TABLE students ADD COLUMN course VARCHAR(255);

-- ----------------------------------------------------
-- SAMPLE DATA: Adding some students
-- ----------------------------------------------------
INSERT INTO students (name, email, subject, course, status) VALUES
('John Doe', 'john@example.com', 'Mathematics', 'Math 101', 'pass'),
('Jane Smith', 'jane@example.com', 'Science', 'Sci 101', 'fail'),
('Michael Brown', NULL, 'History', 'Hist 202', 'pass');

-- ----------------------------------------------------
-- Optional: Create indexes for faster lookups if needed
-- ----------------------------------------------------
CREATE INDEX idx_students_name ON students(name);
CREATE INDEX idx_students_subject ON students(subject);

