CREATE DATABASE IF NOT EXISTS optimy_db;
USE optimy_db;

CREATE TABLE IF NOT EXISTS test (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL
);

INSERT INTO test (name) VALUES
  ('optimy'),
  ('Social impact'),
  ('Sustainability'),
  ('Philanthropy');
