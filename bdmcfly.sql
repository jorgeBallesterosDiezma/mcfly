CREATE DATABASE mcfly;
-- Indicamos la base de datos que hemos creado.
use mcfly;
CREATE TABLE  usuarios(
 usuario varchar(15) not null,
 pass varchar(30) not null,
 CONSTRAINT PK_usuario PRIMARY KEY (usuario)
);
-- Creamos la tabla notas
CREATE TABLE notas (
  id int(10) NOT NULL,
   titulo varchar(32) NOT NULL,
   cuerpo varchar(200) not null,
   usuario varchar(15) NOT NULL,
    CONSTRAINT PK_notas PRIMARY KEY (id),
    CONSTRAINT FK_notas FOREIGN KEY (usuario)
    REFERENCES usuarios(usuario)
);
ALTER TABLE notas
  MODIFY id int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

CREATE TABLE  notasfavoritas(
	idNotas int (10)NOT NULL,
	usuario varchar(15) NOT NULL,
	favorita varchar(1) NOT NULL,
	CONSTRAINT PK_notasfavo PRIMARY KEY (idNotas,usuario),
	CONSTRAINT FK_notas1 FOREIGN KEY (usuario)
	REFERENCES usuarios(usuario),
	CONSTRAINT FK_notas2 FOREIGN KEY (idNotas)
	REFERENCES notas(id)
);
INSERT INTO usuarios (usuario, pass) VALUES
('jorge', '1234'),
('angel', '1234');
  INSERT INTO notas (titulo, cuerpo,usuario) VALUES
('Nota jorge','Es una nota de Jorge','jorge' ),
('Nota favorita de jorge','Es la  nota favorita de Jorge','jorge'),
('Nota Angel', 'Es una nota de Angel','angel'),
('Nota favorita de Angel', 'Es la nota favorita de Angel','angel');
INSERT INTO notasfavoritas (idNotas,usuario, favorita) VALUES
(1,'jorge',1),
(3,'jorge',1),
(1,'angel',1);