-- Base de datos para Laboratorio 9: SOAP + REST
-- Importar en phpMyAdmin o ejecutar con:
-- mysql -u root < veterinaria_patitas.sql

CREATE DATABASE IF NOT EXISTS veterinaria_patitas
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE veterinaria_patitas;

CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente VARCHAR(100) NOT NULL,
    telefono VARCHAR(30) NULL,
    producto_id INT NOT NULL,
    producto_nombre VARCHAR(120) NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10, 2) NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    estado VARCHAR(30) NOT NULL DEFAULT 'PROCESADO',
    fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
