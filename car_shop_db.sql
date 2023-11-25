
CREATE DATABASE IF NOT EXISTS car_shop_db;


USE car_shop_db;


CREATE TABLE cars (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  type VARCHAR(100) NOT NULL,
  price DECIMAL(10, 2) NOT NULL,
  image VARCHAR(255) NOT NULL
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(100) NOT NULL,
  user_type VARCHAR(20) NOT NULL DEFAULT 'user'
);


CREATE TABLE cart (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  pid INT NOT NULL,
  name VARCHAR(100) NOT NULL,
  price DECIMAL(10, 2) NOT NULL,
  quantity INT NOT NULL,
  image VARCHAR(255) NOT NULL
);


CREATE TABLE wishlist (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  pid INT NOT NULL,
  name VARCHAR(100) NOT NULL,
  price DECIMAL(10, 2) NOT NULL,
  image VARCHAR(255) NOT NULL
);


CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
);

INSERT INTO cars (name, type, price, image) VALUES
('Toyota Camry', 'Sedan', 25000.00, 'camry.jpg'),
('Honda CR-V', 'SUV', 35000.00, 'crv.jpg'),
('Ford Focus', 'Hatchback', 18000.00, 'focus.jpg'),
('Chevrolet Camaro', 'Coupe', 40000.00, 'camaro.jpg'),
('Ford Raptor', 'Truck', 32000.00, 'fordraptor.jpg'),
('Porsche 911', 'Sports Car', 50000.00, 'porsche911.jpg');


CREATE TABLE message (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  number VARCHAR(12) NOT NULL,
  message VARCHAR(500) NOT NULL
);
