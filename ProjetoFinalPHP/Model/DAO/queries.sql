CREATE DATABASE bd_projeto;
USE bd_projeto;

DROP TABLE usuario;

CREATE TABLE usuario (
  usuario_id INT NOT NULL AUTO_INCREMENT,
  usuario VARCHAR(200) NOT NULL UNIQUE,
  senha VARCHAR(32) NOT NULL,
  nome VARCHAR(100) NOT NULL,
  data_cadastro DATETIME NOT NULL,
  tipo_usuario INT NOT NULL,
  PRIMARY KEY (`usuario_id`)
);

CREATE TABLE medico(
id INT NOT NULL AUTO_INCREMENT,
nome VARCHAR(100) NOT NULL,
crm VARCHAR(9) NOT NULL UNIQUE,
 leito INT NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE paciente(
id INT NOT NULL AUTO_INCREMENT,
nome VARCHAR(100) NOT NULL,
leito INT NOT NULL,
cpf VARCHAR(14) NOT NULL UNIQUE,
id_medico INT NOT NULL,
PRIMARY KEY (id),
FOREIGN KEY (id_medico) REFERENCES medico(id)
);

SELECT * FROM usuario;

SELECT * FROM medico;

SELECT * FROM paciente;

UPDATE usuario 
SET tipo_usuario = 2
WHERE usuario_id = 1;