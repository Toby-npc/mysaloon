CREATE DATABASE sistem_pengurusan;
USE sistem_pengurusan;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_peranan VARCHAR(20) NOT NULL UNIQUE
);

INSERT INTO roles (nama_peranan) VALUES ('Admin'), ('Staff'), ('Guest');
)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama penuh VARCHAR(100) NOT NULL,
    emel VARCHAR(100) NOT NULL UNIQUE,
    kata_laluan VARCHAR(255) NOT NULL, 
    role_id INT,
    tarikh_daftar TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

