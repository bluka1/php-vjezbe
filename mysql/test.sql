DROP DATABASE IF EXISTS zaposlenici;
CREATE DATABASE zaposlenici;
USE zaposlenici;

CREATE TABLE IF NOT EXISTS pozicije (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  naziv VARCHAR(255) NOT NULL
);

-- INSERT INTO imeTablice (kolona1, kolona2...) 
-- VALUES (vrijednostKolone1, vrijednostKolone2,...);

INSERT INTO pozicije (naziv)
VALUES ('Junior Dev');

INSERT INTO pozicije (naziv)
VALUES ('Mid Dev');

INSERT INTO pozicije (naziv)
VALUES ('Senior Dev');

SELECT * FROM pozicije;


CREATE TABLE IF NOT EXISTS place (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  iznos INT UNSIGNED NOT NULL
);

INSERT INTO place (iznos)
VALUES (1000);

INSERT INTO place (iznos)
VALUES (1500);

INSERT INTO place (iznos)
VALUES (2000);

SELECT * FROM place;

CREATE TABLE IF NOT EXISTS zaposlenici (
  id INT UNSIGNED AUTO_INCREMENT,
  ime VARCHAR(255) NOT NULL,
  prezime VARCHAR(255) NOT NULL,
  pozicijaId INT UNSIGNED NOT NULL,
  placaId INT UNSIGNED NOT NULL,
  datumDolaska DATE NOT NULL,
  spol CHAR(1),
  godine TINYINT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (pozicijaId) REFERENCES pozicije(id) ON DELETE CASCADE,
  FOREIGN KEY (placaId) REFERENCES place(id) ON DELETE CASCADE
);

INSERT INTO zaposlenici (ime, prezime, pozicijaId, placaId, datumDolaska, spol, godine) VALUES
('Ivan', 'Ivić', 1, 1, '2020-01-15', 'M', 30),
('Ana', 'Anić', 2, 2, '2019-03-10', 'Ž', 28),
('Marko', 'Marić', 3, 3, '2018-07-22', 'M', 35),
('Ivana', 'Ilić', 2, 2, '2021-06-05', 'Ž', 26);

INSERT INTO zaposlenici (ime, prezime, pozicijaId, placaId, datumDolaska, spol, godine) VALUES
('Marko', 'Markić', 1, 1, '2020-01-15', 'M', 30),
('Mara', 'Marić', 2, 2, '2019-03-10', 'Ž', 28),
('Natko', 'Natkić', 3, 3, '2018-07-22', 'M', 35),
('Ivo', 'Mirić', 2, 2, '2021-06-05', 'Ž', 26),
('Marin', 'Mazić', 1, 1, '2020-01-15', 'M', 30),
('Matko', 'Zorić', 1, 2, '2019-03-10', 'M', 28),
('Marin', 'Marinić', 1, 3, '2018-07-22', 'M', 35),
('Marin', 'Mrmić', 3, 1, '2020-01-15', 'M', 30),
('Maja', 'Majić', 3, 2, '2019-03-10', 'Ž', 28),
('Majda', 'Majdić', 3, 3, '2018-07-22', 'Ž', 35);

SELECT * FROM zaposlenici;

CREATE TABLE IF NOT EXISTS odjeli (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  naziv VARCHAR(255) NOT NULL
);

INSERT INTO odjeli (naziv) VALUES
('Backend'),
('Frontend'),
('DevOps');

SELECT * FROM odjeli;

CREATE TABLE IF NOT EXISTS osobljeOdjela (
  id INT UNSIGNED AUTO_INCREMENT,
  zaposlenikId INT UNSIGNED NOT NULL,
  odjelId INT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (zaposlenikId) REFERENCES zaposlenici(id) ON DELETE CASCADE,
  FOREIGN KEY (odjelId) REFERENCES odjeli(id) ON DELETE CASCADE
);

INSERT INTO osobljeOdjela(zaposlenikId, odjelId) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(3, 3),
(4, 1),
(5, 2),
(6, 3),
(7, 1),
(7, 3),
(8, 2),
(8, 3),
(9, 1),
(10, 2),
(11, 2),
(11, 3),
(12, 1),
(12, 2),
(12, 3),
(13, 1),
(13, 3),
(14, 2);

SELECT * FROM osobljeOdjela;

CREATE TABLE IF NOT EXISTS voditeljiOdjela (
  id INT UNSIGNED AUTO_INCREMENT,
  idOdjela INT UNSIGNED NOT NULL,
  idZaposlenika INT UNSIGNED NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (idOdjela) REFERENCES odjeli(id) ON DELETE CASCADE,
  FOREIGN KEY (idZaposlenika) REFERENCES zaposlenici(id) ON DELETE CASCADE
);

INSERT INTO voditeljiOdjela(idOdjela, idZaposlenika) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 5),
(3, 7),
(3, 8);

SELECT * FROM voditeljiOdjela;

-- Dohvatite sve zaposlenike i njihove plaće.
-- SELECT * FROM zaposlenici z
-- INNER JOIN place p ON z.placaId = p.id;

SELECT z.ime, z.prezime, p.iznos FROM zaposlenici z
INNER JOIN place p ON z.placaId = p.id;

-- Dohvatite sve voditelje odjela i izračunajte prosjek njihovih plaća.
SELECT * FROM voditeljiOdjela v
INNER JOIN zaposlenici z ON v.idZaposlenika = z.id
INNER JOIN place p ON z.placaId = p.id;

SELECT ROUND(AVG(p.iznos), 2) 'Prosjek' FROM voditeljiOdjela v
INNER JOIN zaposlenici z ON v.idZaposlenika = z.id
INNER JOIN place p ON z.placaId = p.id;

-- Kreirajte proceduru koja će računati prosjek plaća svih zaposlenika.
DELIMITER $$
CREATE PROCEDURE prosjekPlaca()
BEGIN
	SELECT ROUND(AVG(p.iznos), 2) 'Prosjek placa svih zaposlenika', COUNT(*) 'Ukupan broj zaposlenika' FROM zaposlenici z
	INNER JOIN place p ON z.placaId = p.id;
END$$
DELIMITER ;

CALL prosjekPlaca();


-- vjezbanje joinova i procedura

-- cilj - prikazati ime, prezime, poziciju i placu svakog zaposlenika
-- SELECT z.ime 'Ime', z.prezime 'Prezime', p.naziv 'Pozicija' FROM zaposlenici z
-- INNER JOIN pozicije p ON z.pozicijaId = p.id;

SELECT z.ime 'Ime', z.prezime 'Prezime', p.naziv 'Pozicija', pl.iznos 'Placa' FROM zaposlenici z
INNER JOIN pozicije p ON z.pozicijaId = p.id
INNER JOIN place pl ON z.placaId = pl.id;

-- DELIMITER $$
-- CREATE PROCEDURE prikaziSveZaposlenikePlacePozicije()
-- BEGIN
-- 	SELECT z.ime 'Ime', z.prezime 'Prezime', p.naziv 'Pozicija', pl.iznos 'Placa' FROM zaposlenici z
-- 	INNER JOIN pozicije p ON z.pozicijaId = p.id
-- 	INNER JOIN place pl ON z.placaId = pl.id;
-- END$$
-- DELIMITER ;

CALL prikaziSveZaposlenikePlacePozicije();

-- dodati podatke u tablice pozicije i place te kreirati LEFT i RIGHT JOINove
INSERT INTO pozicije(naziv) VALUES
('Arhitekt'),
('QA engineer'),
('Dizajner');

INSERT INTO place(iznos) VALUES
(2500),
(3000),
(3500);

SELECT * FROM pozicije;

-- left
SELECT z.ime, z.prezime, p.naziv FROM zaposlenici z
LEFT JOIN pozicije p ON z.pozicijaId = p.id;

-- right
SELECT z.ime, z.prezime, p.naziv FROM zaposlenici z
RIGHT JOIN pozicije p ON z.pozicijaId = p.id;

-- cross
SELECT * FROM zaposlenici
CROSS JOIN pozicije;

-- START TRANSACTION;
-- 	INSERT INTO pozicije(naziv)
-- 	VALUES ('CEO');
--     ROLLBACK;
-- 	INSERT INTO place(iznos)
-- 	VALUES ('4000');
-- COMMIT;