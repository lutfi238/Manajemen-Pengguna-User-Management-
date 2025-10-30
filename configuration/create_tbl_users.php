<?php
include '../connect.php';

// sql to create table
$sql = "CREATE TABLE users(
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
  )";
  

if ($conn->query($sql) === TRUE) {
  echo "Table users created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error . "<br>";
}

$conn->close();
?>