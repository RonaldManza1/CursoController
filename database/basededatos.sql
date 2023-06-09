CREATE DATABASE senati;
USE senati;

CREATE TABLE cursos
(
   idcurso			INT AUTO_INCREMENT PRIMARY KEY,
   nombrecurso		VARCHAR(50)		NOT NULL,
   especialidad 	VARCHAR(70)		NOT NULL,
   complejidad		CHAR(1)			NOT NULL DEFAULT 'B',
   fechainicio		DATE 				NOT NULL,
   precio			DECIMAL(7,2)	NOT NULL,
   fechacreacion	DATETIME 		NOT NULL DEFAULT NOW(),
   fechaupdate		DATETIME 		NULL,
   estado			CHAR(1) 			NOT NULL DEFAULT '1'
)ENGINE = INNODB;



INSERT	INTO cursos (nombrecurso,especialidad,complejidad,fechainicio,precio) VALUES
   ('Java', 'ETI', 'M', '2023-05-10', 180),
   ('Desarrollo Web', 'ETI', 'B', '2023-04-20', 190),
   ('Excel financiero', 'Administración', 'A', '2023-05-14', 250),
   ('ERP SAP', 'Administración', 'A', '2023-05-11', 400),
   ('Inventor', 'Mecánica', 'M', '2023-04-29', 380);

SELECT * FROM cursos;

-- STORE PROCEDURE
-- Un procedimiento almacenado es un PROGRAMA que se ejecuta desde el  
-- motor de BD, y que permite recibir valores de entreda, realizar 
-- diferentes tipos de cálculos y entregar una salida .


DELIMITER $$
CREATE PROCEDURE spu_cursos_listar()
BEGIN
   SELECT	idcurso,
		nombrecurso,
		especialidad,
		complejidad,
		fechainicio,
		precio
	   FROM cursos
	   WHERE estado = '1'
	   ORDER BY idcurso DESC;	
END $$

	

-- PROCEDIMIENTO PARA REGISTRAR UN CURSO
DELIMITER $$
CREATE PROCEDURE spu_curso_registrar
(
	IN _nombrecurso	VARCHAR(50),
	IN _especialidad	VARBINARY(70),
	IN _complejidad	CHAR(1),
	IN _fechainicio	DATE,
	IN _precio			DECIMAL(7,2)
)
BEGIN   
	INSERT INTO cursos (nombrecurso, especialidad, complejidad, fechainicio, precio) VALUES
		(_nombrecurso, _especialidad, _complejidad, _fechainicio, _precio);
END $$

CALL spu_curso_registrar('Python para todos', 'ETI', 'B', '2023-05-10', 120);
CALL spu_curso_registrar('C# para la web', 'ETI', 'B', '2023-05-11', 320);
CALL spu_cursos_listar();

-- Procedimiento para eliminación lógica
DELIMITER $$
CREATE PROCEDURE spu_cursos_eliminar(IN _idcurso INT)
BEGIN
	UPDATE cursos
		SET estado = '0'
		WHERE idcurso = _idcurso;
END $$

CALL spu_cursos_eliminar(4);
SELECT * FROM cursos;

-- lunes 10 de abril

DELIMITER $$
CREATE PROCEDURE spu_cursos_recuperar_id(IN _idcurso INT)
BEGIN
	SELECT * FROM cursos WHERE idcurso = _idcurso;
END $$

CALL spu_cursos_recuperar_id(3);


DELIMITER $$
CREATE PROCEDURE spu_cursos_actualizar
(
	IN _idcurso		INT,
	IN _nombrecurso		VARCHAR(50),
	IN _especialidad	VARCHAR(70),
	IN _complejidad		CHAR(1),
	IN _fechainicio		DATE,
	IN _precio		DECIMAL(7,2)
)
BEGIN
	UPDATE cursos SET
		nombrecurso = _nombrecurso,
		especialidad = _especialidad,
		complejidad = _complejidad,
		fechainicio = _fechainicio,
		precio = _precio
	WHERE idcurso = _idcurso;
END $$

SELECT * FROM cursos WHERE idcurso = 3;
CALL spu_cursos_actualizar(3, 'Excel para Gestión', 'ETI', 'B', '2023-06-20', 400)

CREATE TABLE usuarios
(
	idusuario	INT AUTO_INCREMENT PRIMARY KEY,
	nombreusuario	VARCHAR(30)	NOT NULL,
	claveacceso	VARCHAR(90)	NOT NULL,
	apellidos	VARCHAR(30)	NOT NULL,
	nombres 	VARCHAR(30)	NOT NULL,
	nivelacceso	CHAR(1)		NOT NULL DEFAULT "A",
	estado		CHAR(1) 	NOT NULL DEFAULT'1',
	fecharegistro	DATETIME	NOT NULL DEFAULT NOW(),
	fechaupdate	DATETIME 	NULL,
	CONSTRAINT uk_nombreusuario_usa UNIQUE (nombreusuario)

)ENGINE = INNODB;

INSERT INTO usuarios (nombreusuario, claveacceso, apellidos, nombres) VALUES
('Ronald', '123456', 'Manza Martinez', 'Ronald'),
('Joel', '123456', 'Rojas Marcos', 'Jose Joel');

 SELECT *FROM usuarios;
 
 -- actualizando por la clave encriptada
 -- defecto: SENATI
 UPDATE usuarios SET
	claveacceso = '$2y$10$wuKLOUolq1eFegy8KUoB2Ogmph4JdJp8DHPSDndnF/4rE4venqgWi'
	WHERE idusuario = 1;
 
 UPDATE usuarios SET 
	claveacceso = '$2y$10$0CuglAsOtI9uVIMnQhHU8.VP0/fiEN9gUUxtCcQNutLYgRKta3Jx2'
	WHERE IDUSUARIO = 2;
SELECT *FROM usuarios;