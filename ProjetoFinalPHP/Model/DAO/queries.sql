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

DROP TABLE trigger_table;

CREATE TABLE trigger_table(
	id INT NOT NULL AUTO_INCREMENT,
	operacao VARCHAR(20) NOT NULL,
	tabela VARCHAR(20) NOT NULL,
	datahora DATETIME NOT NULL,
	PRIMARY KEY (id)
);

DELIMITER $$

CREATE TRIGGER insert_trigger_paciente
	AFTER INSERT ON paciente
		FOR EACH ROW 
		BEGIN
			INSERT INTO trigger_table(operacao, tabela, datahora)
			VALUES('Insert', 'Paciente', NOW());
		END;
		
CREATE TRIGGER insert_trigger_medico
	AFTER INSERT ON medico
		FOR EACH ROW 
		BEGIN
			INSERT INTO trigger_table(operacao, tabela, datahora)
			VALUES('Insert', 'Medico', NOW());
		END;

CREATE TRIGGER update_trigger_paciente
	AFTER UPDATE ON paciente
		FOR EACH ROW 
		BEGIN
			INSERT INTO trigger_table(operacao, tabela, datahora)
			VALUES('Update', 'Paciente', NOW());
		END;

CREATE TRIGGER update_trigger_medico
	AFTER UPDATE ON medico
		FOR EACH ROW 
		BEGIN
			INSERT INTO trigger_table(operacao, tabela, datahora)
			VALUES('Update', 'Medico', NOW());
		END;


CREATE TRIGGER delete_trigger_paciente
	AFTER DELETE ON paciente
		FOR EACH ROW 
		BEGIN
			INSERT INTO trigger_table(operacao, tabela, datahora)
			VALUES('Delete', 'Paciente', NOW());
		END;

CREATE TRIGGER delete_trigger_medico
	AFTER DELETE ON medico
		FOR EACH ROW 
		BEGIN
			INSERT INTO trigger_table(operacao, tabela, datahora)
			VALUES('Delete', 'Medico', NOW());
		END;


DELIMITER ;