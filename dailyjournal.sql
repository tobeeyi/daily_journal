DROP TABLE IF EXISTS users;
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  foto VARCHAR(255) DEFAULT NULL
);

DROP TABLE IF EXISTS article;
CREATE TABLE article (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(200) NOT NULL,
  isi TEXT NOT NULL,
  tanggal DATETIME NOT NULL,
  gambar VARCHAR(255) DEFAULT NULL,
  username VARCHAR(50) NOT NULL
);

DROP TABLE IF EXISTS gallery;
CREATE TABLE gallery (
  id INT AUTO_INCREMENT PRIMARY KEY,
  deskripsi VARCHAR(255) NOT NULL,
  gambar VARCHAR(255) NOT NULL,
  tanggal DATETIME NOT NULL,
  username VARCHAR(50) NOT NULL
);

INSERT INTO users (username, password) VALUES
('april', '$2y$10$/Bpj35ivpl5vBGeX9TPn0.bxPUa6JJSvXx8jOqzC0Lwy.i.yYN4wG');

INSERT INTO article (judul, isi, tanggal, gambar, username) VALUES
('Selamat Datang', 'Ini adalah artikel DailyJournal. Kamu bisa edit, hapus, tambah, dan mencari artikel secara realtime.', NOW(), NULL, 'april');
