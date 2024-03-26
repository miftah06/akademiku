-- Create the 'users' table
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(191) NOT NULL UNIQUE,
    email VARCHAR(191) NOT NULL UNIQUE,
    password VARCHAR(191) NOT NULL,
    profile_picture TEXT,
    is_admin INT DEFAULT 0
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create the 'courses' table
CREATE TABLE IF NOT EXISTS courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(191) NOT NULL,
    description TEXT,
    thumbnail TEXT,
    video_url TEXT,
    instructor_id INT,
    FOREIGN KEY (instructor_id) REFERENCES users(id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create the 'payments' table
CREATE TABLE IF NOT EXISTS payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    course_id INT,
    transaction_id VARCHAR(191) NOT NULL UNIQUE,
    payment_status INT DEFAULT 0, -- 0: Pending, 1: Completed, 2: Failed
    payment_date DATETIME,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (course_id) REFERENCES courses(id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
