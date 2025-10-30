-- ================================================
-- DATABASE: uts_web
-- Warehouse Management System
-- ================================================

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS uts_web;
USE uts_web;

-- ================================================
-- Drop existing tables if they exist
-- ================================================

DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS users;

-- ================================================
-- Table: users
-- ================================================

CREATE TABLE users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('warehouse_admin') DEFAULT 'warehouse_admin',
  is_active TINYINT(1) DEFAULT 0,
  activation_token VARCHAR(255) NULL,
  reset_token VARCHAR(255) NULL,
  reset_token_expiry DATETIME NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ================================================
-- Table: products
-- ================================================

CREATE TABLE products (
  id INT(11) NOT NULL AUTO_INCREMENT,
  product_code VARCHAR(50) NOT NULL UNIQUE,
  product_name VARCHAR(100) NOT NULL,
  description TEXT,
  stock INT DEFAULT 0,
  price DECIMAL(15,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  user_id INT(11) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ================================================
-- Sample Data: Users
-- ================================================

-- Password untuk semua user: password123
-- (Hash di bawah adalah bcrypt hash dari 'password123')

INSERT INTO users (name, email, password, role, is_active, activation_token, reset_token, reset_token_expiry, created_at) VALUES
('Admin Gudang Utama', 'admin@warehouse.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warehouse_admin', 1, NULL, NULL, NULL, '2025-10-25 08:00:00'),
('Budi Santoso', 'budi@warehouse.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warehouse_admin', 1, NULL, NULL, NULL, '2025-10-26 09:30:00'),
('Siti Nurhaliza', 'siti@warehouse.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'warehouse_admin', 1, NULL, NULL, NULL, '2025-10-27 10:15:00');

-- ================================================
-- Sample Data: Products
-- ================================================

-- Products for Admin Gudang Utama (user_id = 1)
INSERT INTO products (product_code, product_name, description, stock, price, user_id, created_at) VALUES
('LPT001', 'Laptop Dell Inspiron 15', 'Laptop untuk keperluan kantor dengan processor Intel Core i5, RAM 8GB, SSD 256GB', 15, 7500000.00, 1, '2025-10-25 10:00:00'),
('MNT001', 'Monitor Samsung 24 inch', 'Monitor LED 24 inch Full HD dengan panel IPS', 25, 1850000.00, 1, '2025-10-25 10:15:00'),
('KBD001', 'Keyboard Logitech K380', 'Keyboard wireless multi-device', 50, 450000.00, 1, '2025-10-25 10:30:00'),
('MSE001', 'Mouse Logitech M170', 'Mouse wireless dengan receiver USB', 60, 150000.00, 1, '2025-10-25 10:45:00'),
('PRN001', 'Printer HP LaserJet Pro', 'Printer monochrome untuk volume tinggi', 8, 3200000.00, 1, '2025-10-25 11:00:00');

-- Products for Budi Santoso (user_id = 2)
INSERT INTO products (product_code, product_name, description, stock, price, user_id, created_at) VALUES
('CHR001', 'Kursi Kantor Ergonomis', 'Kursi kantor dengan sandaran punggung adjustable', 20, 1250000.00, 2, '2025-10-26 11:00:00'),
('DSK001', 'Meja Kerja Minimalis', 'Meja kerja 120x60cm dengan laci', 12, 980000.00, 2, '2025-10-26 11:15:00'),
('LMP001', 'Lampu Meja LED', 'Lampu meja dengan brightness control', 35, 185000.00, 2, '2025-10-26 11:30:00');

-- Products for Siti Nurhaliza (user_id = 3)
INSERT INTO products (product_code, product_name, description, stock, price, user_id, created_at) VALUES
('SHR001', 'Shredder Kertas', 'Mesin penghancur kertas untuk keamanan dokumen', 5, 1750000.00, 3, '2025-10-27 12:00:00'),
('STC001', 'Stapler Heavy Duty', 'Stapler besar untuk dokumen tebal', 40, 125000.00, 3, '2025-10-27 12:15:00'),
('FLD001', 'File Organizer', 'Rak dokumen 5 tingkat', 18, 275000.00, 3, '2025-10-27 12:30:00');

-- ================================================
-- NOTES
-- ================================================

-- Default password untuk semua user adalah: password123
-- 
-- Untuk testing:
-- 1. Login dengan email: admin@warehouse.com, password: password123
-- 2. Login dengan email: budi@warehouse.com, password: password123
-- 3. Login dengan email: siti@warehouse.com, password: password123
--
-- Setiap user dapat melihat dan mengelola produk mereka sendiri
-- Produk dengan stok < 10 akan ditandai sebagai stok rendah (low stock)
--
-- ================================================
-- End of database.sql
-- ================================================

