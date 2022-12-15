CREATE DATABASE IF NOT EXISTS senderismo;
SET NAMES UTF8;
USE senderismo;

DROP TABLE IF EXISTS usuarios;
CREATE TABLE IF NOT EXISTS usuarios(
    nombre          varchar(100) not null,
    email           varchar(255) not null,
    password        varchar(255) not null,
    CONSTRAINT pk_usuarios PRIMARY KEY (email)
    )ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS rutas;
CREATE TABLE IF NOT EXISTS rutas(
    id              int(11) auto_increment not null,
    titulo          varchar(55) not null,
    descripcion     blob not null,
    desnivel        int(6) unsigned not null,
    distancia       double not null,
    notas           blob not null,
    dificultad      smallint(5) unsigned not null,
    CONSTRAINT pk_rutas PRIMARY KEY(id)
    )ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS rutas_comentarios;
CREATE TABLE IF NOT EXISTS rutas_comentarios(
    id              smallint(6) auto_increment not null,
    id_ruta         int(11) not null,
    nombre          varchar(50) not null,
    texto           blob not null,
    fecha           date not null,
    CONSTRAINT pk_rutas_comentarios PRIMARY KEY(id),
    CONSTRAINT fk_comentario_ruta FOREIGN KEY(id_ruta) REFERENCES rutas(id)
    )ENGINE=InnoDb DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

