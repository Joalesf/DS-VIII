CREATE DATABASE IF NOT EXISTS parcial2_rh
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE parcial2_rh;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(30) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    rol ENUM('aspirante', 'rh') NOT NULL DEFAULT 'aspirante',
    intentos_fallidos INT NOT NULL DEFAULT 0,
    bloqueado_hasta DATETIME NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS aspirantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL UNIQUE,
    cedula_pasaporte VARCHAR(30) NULL,
    nombre VARCHAR(80) NULL,
    apellido VARCHAR(80) NULL,
    estado_civil VARCHAR(30) NULL,
    genero VARCHAR(30) NULL,
    tipo_sangre VARCHAR(5) NULL,
    fecha_nacimiento DATE NULL,
    nacionalidad VARCHAR(80) NULL,
    telefono VARCHAR(30) NULL,
    residencia VARCHAR(180) NULL,
    correo VARCHAR(120) NULL,
    estado_solicitud ENUM('no revisado', 'considerado', 'no considerado') NOT NULL DEFAULT 'no revisado',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    actualizado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_aspirantes_usuarios
        FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id)
        ON DELETE CASCADE
);

-- Para crear un usuario de Recursos Humanos:
-- 1. Crear una cuenta normal desde la aplicacion.
-- 2. En phpMyAdmin ejecutar:
-- UPDATE usuarios SET rol = 'rh' WHERE usuario = 'nombre_del_usuario';
