CREATE DATABASE palaciorosa_DB CHARACTER SET latin1 COLLATE latin1_swedish_ci;

CREATE TABLE palaciorosa_DB.usuarios (
    id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR (30),
    email VARCHAR (50),
    passwd VARCHAR (60),
    edad TINYINT,
    sexo CHAR,
    direccion VARCHAR (50),
    fecha_creacion DATETIME NOT NULL,
    fecha_modificacion DATETIME NULL,
    PRIMARY KEY (id),
    UNIQUE (email)
)
CHARACTER SET latin1 COLLATE latin1_swedish_ci
ENGINE MyISAM;

INSERT INTO palaciorosa_DB.usuarios (nombre, email, passwd, edad, sexo, direccion, fecha_creacion) VALUES ("prueba", "prueba@hotmail.com", "prueba", "30", "M", "carrera 4", NOW());