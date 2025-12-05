-- Crea la base de datos en el caso de que no exista
CREATE DATABASE IF NOT EXISTS nicolas_bedia
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE nicolas_bedia;

CREATE TABLE IF NOT EXISTS logins (
  usuario VARCHAR(50) NOT NULL,
  passwd  VARCHAR(32) NOT NULL,
  PRIMARY KEY (usuario)
);

CREATE TABLE IF NOT EXISTS aplicaciones (
  nombre_aplicacion VARCHAR(50) NOT NULL,
  descripcion       VARCHAR(300) NOT NULL,
  PRIMARY KEY (nombre_aplicacion)
);
