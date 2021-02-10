CREATE DATABASE palaciorosa_DB CHARACTER SET latin1 COLLATE latin1_swedish_ci;

CREATE TABLE palaciorosa_DB.usuarios (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR (30),
    email VARCHAR (50),
    passwd VARCHAR (60),
    fecha_nacimiento DATE,
    sexo CHAR,
    direccion VARCHAR (50),
    fecha_creacion DATETIME NOT NULL,
    fecha_modificacion DATETIME NULL,
    PRIMARY KEY (id),
    UNIQUE (username, email)
)
CHARACTER SET latin1 COLLATE latin1_swedish_ci
ENGINE MyISAM;

INSERT INTO palaciorosa_DB.usuarios (nombre, email, passwd, fecha_nacimiento, sexo, direccion, fecha_creacion) VALUES ("prueba", "prueba@hotmail.com", "prueba", "1990-01-09", "M", "carrera 4", NOW());
