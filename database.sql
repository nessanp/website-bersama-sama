-- ============================================
-- Database: portfolio_website
-- Deskripsi: Database untuk website portfolio profesional
-- ============================================

-- Buat database jika belum ada
CREATE DATABASE IF NOT EXISTS portfolio_website;
USE portfolio_website;

-- ============================================
-- Tabel: admin
-- Deskripsi: Menyimpan data login admin
-- ============================================
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Tabel: projects
-- Deskripsi: Menyimpan data project portfolio
-- ============================================
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    deskripsi LONGTEXT NOT NULL,
    gambar VARCHAR(255),
    link VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Insert Data Dummy: Admin
-- Username: admin, Password: admin123
-- ============================================
INSERT INTO admin (username, password) VALUES 
('admin', '$2b$10$8cLNdFsv.WlMx2txtNGvn.jxUxpzFfbEke1Rul6NbrD1uEJbQhQSe');

-- Username: user, Password: user123  
INSERT INTO admin (username, password) VALUES 
('user', '$2b$10$6mve6YCSqT/6/Yrh/1/VleKQFcqOeh6Nb9PumZOvLe1hoEL4n/joG');

-- ============================================
-- Insert Data Dummy: Projects
-- ============================================
INSERT INTO projects (judul, deskripsi, gambar, link) VALUES 
(
    'E-Commerce Platform',
    'Platform e-commerce yang dibangun dengan Laravel dan MySQL. Fitur-fitur yang tersedia termasuk sistem pembayaran, manajemen inventory, dashboard penjualan real-time, dan integrasi dengan berbagai payment gateway. Dirancang untuk UKM dengan interface yang user-friendly dan performa tinggi.',
    'project1.jpg',
    'https://github.com/myusername/ecommerce-platform'
),
(
    'Social Media Web App',
    'Aplikasi media sosial web yang dibangun dengan React.js dan Node.js. User bisa membuat profile, share post, like, comment, dan follow user lain. Dilengkapi dengan real-time notification dan image upload feature menggunakan AWS S3.',
    'project2.jpg',
    'https://github.com/myusername/social-media-app'
),
(
    'Restaurant Management System',
    'Sistem manajemen restoran lengkap dengan fitur reservasi, menu management, order tracking, dan laporan keuangan. Dibangun menggunakan PHP Native, Bootstrap, dan MySQL. Cocok untuk restoran kecil hingga menengah.',
    'project3.jpg',
    'https://github.com/myusername/restaurant-system'
),
(
    'Mobile Weather App',
    'Aplikasi cuaca mobile yang dibangun dengan React Native dan menggunakan OpenWeather API. User dapat melihat cuaca real-time, forecast 7 hari ke depan, dan saved favorite locations. Sudah tersedia di iOS dan Android.',
    'project4.jpg',
    'https://github.com/myusername/weather-app'
),
(
    'Blog Platform CMS',
    'Platform blog dengan sistem CMS yang powerful. Admin bisa membuat, edit, delete article dengan dukungan rich text editor. Tersedia fitur kategori, tags, comment moderation, dan SEO optimization. Dibangun dengan WordPress custom theme.',
    'project5.jpg',
    'https://github.com/myusername/blog-cms'
),
(
    'Task Management Dashboard',
    'Dashboard task management untuk team collaboration. Fitur kanban board, task assignment, progress tracking, dan real-time collaboration. Dibangun dengan Vue.js, Node.js, dan Firebase untuk real-time database.',
    'project6.jpg',
    'https://github.com/myusername/task-dashboard'
);

-- ============================================
-- Verifikasi Data
-- ============================================
SELECT 'Admin Data:' as '';
SELECT * FROM admin;

SELECT 'Project Data:' as '';
SELECT * FROM projects;

-- ============================================
-- Catatan Penting
-- ============================================
-- Username: admin | Password: admin123
-- Username: user | Password: user123
-- ============================================
