<?php
include '../connect.php';

// sql to create products table
$sql = "CREATE TABLE products(
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
  )";

if ($conn->query($sql) === TRUE) {
  echo "Table products created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error . "<br>";
}

$conn->close();
?>

