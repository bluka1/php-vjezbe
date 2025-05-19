SELECT id, name, age FROM clanovi;

CREATE DATABASE IF NOT EXISTS `videoteka`;

CREATE TABLE IF NOT EXISTS `clanovi` (
  `clanskiBroj` INT UNSIGNED NOT NULL,
  `ime` VARCHAR(255) NOT NULL,
  `prezime` VARCHAR(255) NOT NULL,
  `datumUclanjenja` DATE NOT NULL
  -- PRIMARY KEY (clanskiBroj)
);

CREATE TABLE IF NOT EXISTS `filmovi` (
  `imdbId` INT UNSIGNED NOT NULL,
  `naziv` VARCHAR(255) NOT NULL,
  `godina` INT UNSIGNED NOT NULL,
  `kolicinaDvd` TINYINT UNSIGNED NOT NULL,
  `kolicinaBluRay` TINYINT UNSIGNED NOT NULL,
  `zanrId` TINYINT UNSIGNED NOT NULL
);

CREATE TABLE IF NOT EXISTS `zanrovi` (
  `zanrId` TINYINT UNSIGNED NOT NULL,
  `naziv` varchar(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS `cjenik_posudbe` (
  `cjenikId` TINYINT UNSIGNED NOT NULL,
  `kategorija` VARCHAR(255) NOT NULL,
  `cijena` DOUBLE(3,2) NOT NULL
);

CREATE TABLE IF NOT EXISTS `posudbe` (
  `posudbaId` INT UNSIGNED NOT NULL,
  `filmId` INT UNSIGNED NOT NULL,
  `clanskiBroj` INT UNSIGNED NOT NULL,
  `datumPosudbe` DATE NOT NULL,
  `datumPovrata` DATE NOT NULL,
  `cjenikId` TINYINT UNSIGNED NOT NULL
);


INSERT INTO `zanrovi` (zanrId, naziv) VALUES (1, 'Komedija');

UPDATE `zanrovi` 
SET
	`zanrId` = 7,
	`naziv` = 'Drama'
WHERE
  `zanrId` = 1;
  
  
-- DELETE FROM `clanovi`
-- WHERE `clanskiBroj` = 1;

-- U tablicu `clanovi` umetnite tri nova člana po želji.
-- U tablicu `zanr` umetnite tri nova žanra po želji.
-- U tablici `clanovi` jednom članu promjenite datum učlanjenja na današnji datum.
-- U tablicama `clanovi` i `zanr` izbrišite zadnji zapis.

INSERT INTO `clanovi` (`clanskiBroj`, `ime`, `prezime`, `datumUclanjenja`)
VALUES
(1, 'Ivan', 'Ivić', '2023-09-12'),
(2, 'Ana', 'Horvat', '2022-11-03'),
(3, 'Marko', 'Kovač', '2024-01-20');

INSERT INTO `zanrovi` (`zanrId`, `naziv`)
VALUES
  (1, 'Komedija'),
  (2, 'Horor'),
  (3, 'Akcija');

UPDATE clanovi
SET datumUclanjenja = CURDATE()
WHERE clanskiBroj = 1;

-- MAX()

DELETE FROM clanovi
WHERE clanskiBroj = 3;

-- DELETE FROM clanovi WHERE clanskiBroj IN (SELECT clanskiBroj FROM clanovi
-- ORDER BY clanskiBroj DESC LIMIT 1);

DELETE FROM zanrovi
WHERE zanrId = 3;

-- Kreirajte novog korisnika baze podataka i dodjelite mu sva prava samo za bazu videoteka.

CREATE USER IF NOT EXISTS korisnikbaze@localhost IDENTIFIED BY 'Korisnikbaze1!';

GRANT ALL ON videoteka.* TO korisnikbaze@localhost;

REVOKE ALL ON videoteka.* FROM korisnikbaze@localhost;

INSERT INTO `clanovi` (`clanskiBroj`, `ime`, `prezime`, `datumUclanjenja`)
VALUES
(3, 'Ivan', 'Horvat', '2023-09-12'),
(4, 'Marko', 'Horvat', '2022-11-03'),
(5, 'Nikola', 'Mlakar', '2024-01-20');

-- Iz tablice 'clanovi' dohvatiti sve podatke.
-- Iz tablice 'clanovi' dohvatiti ime, prezime.
-- Iz tablice 'zanrovi' dohvatiti naziv te sortirati po nazivu silazno.
-- Iz tablice 'clanovi' dohvatiti ime, prezime zapisa koji imaju prezime Horvat.
-- Iz tablice 'clanovi' dohvatite prezime tako da se isti podaci ne ponavljaju.

SELECT * FROM clanovi;

SELECT ime, prezime FROM clanovi;

SELECT naziv FROM zanrovi
ORDER BY naziv DESC;

SELECT ime, prezime FROM clanovi WHERE prezime = 'Horvat';

SELECT DISTINCT prezime FROM clanovi;

-- Svim tablicama u bazi podataka 'videoteka' dodajte primarne ključeve.
ALTER TABLE clanovi
ADD CONSTRAINT PK_clanovi PRIMARY KEY (clanskiBroj);

ALTER TABLE zanrovi
ADD CONSTRAINT PK_zanrovi PRIMARY KEY (zanrId);

ALTER TABLE filmovi
ADD CONSTRAINT PK_filmovi PRIMARY KEY (imdbId);

ALTER TABLE posudbe
ADD CONSTRAINT PK_posudbe PRIMARY KEY (posudbaId);

ALTER TABLE cjenik_posudbe
ADD CONSTRAINT PK_cjenik_posudbe PRIMARY KEY (cjenikId);

-- U tablicama 'filmovi' i 'posudba' dodajte strane ključeve i ograničenje na update postaviti CASCADE.

ALTER TABLE filmovi
ADD KEY fk_zanrId (zanrId),
ADD CONSTRAINT fk_zanrId FOREIGN KEY (zanrId) REFERENCES zanrovi (zanrId) ON UPDATE CASCADE;

ALTER TABLE posudbe
ADD KEY fk_filmId (filmId),
ADD KEY fk_clanskiBroj (clanskiBroj),
ADD KEY fk_cjenikId (cjenikId),
ADD CONSTRAINT fk_filmId FOREIGN KEY (filmId) REFERENCES filmovi (imdbId) ON UPDATE CASCADE,
ADD CONSTRAINT fk_clanskiBroj FOREIGN KEY (clanskiBroj) REFERENCES clanovi (clanskiBroj) ON UPDATE CASCADE,
ADD CONSTRAINT fk_cjenikId FOREIGN KEY (cjenikId) REFERENCES cjenik_posudbe (cjenikId) ON UPDATE CASCADE;

INSERT INTO clanovi (clanskiBroj, ime, prezime, datumUclanjenja)
VALUES (6, 'Mario', 'Maric', '2024-01-01');

INSERT INTO clanovi (clanskiBroj, ime, prezime, datumUclanjenja)
VALUES (7, 'Ivo', 'Ivic', '2024-02-02');

INSERT INTO clanovi (clanskiBroj, ime, prezime, datumUclanjenja)
VALUES (8, 'Pero', 'Perić', '2024-03-03');

INSERT INTO clanovi (clanskiBroj, ime, prezime, datumUclanjenja)
VALUES (9, 'Josip', 'Josić', '2024-04-04');

INSERT INTO clanovi (clanskiBroj, ime, prezime, datumUclanjenja)
VALUES (10, 'Stipe', 'Stipić', '2024-05-05');

INSERT INTO cjenik_posudbe (cjenikId, kategorija, cijena)
VALUES (1, 'Akcija', '5.99');

INSERT INTO cjenik_posudbe (cjenikId, kategorija, cijena)
VALUES (2, 'Komedija', '7.99');
INSERT INTO cjenik_posudbe (cjenikId, kategorija, cijena)
VALUES (3, 'Horor', '3.99');
INSERT INTO cjenik_posudbe (cjenikId, kategorija, cijena)
VALUES (4, 'Drama', '9.99');

INSERT INTO filmovi (imdbId, naziv, godina, kolicinaDvd, kolicinaBluRay, zanrId)
VALUES (1, 'Policijska akademija', 2000, 10, 7, 1);

INSERT INTO filmovi (imdbId, naziv, godina, kolicinaDvd, kolicinaBluRay, zanrId)
VALUES (2, 'Forrest gump', 2010, 7, 5, 1);

INSERT INTO filmovi (imdbId, naziv, godina, kolicinaDvd, kolicinaBluRay, zanrId)
VALUES (3, 'Mamurluk', 2015, 5, 3, 1);

INSERT INTO filmovi (imdbId, naziv, godina, kolicinaDvd, kolicinaBluRay, zanrId)
VALUES (4, 'Resident evil', 1999, 3, 3, 2);

INSERT INTO filmovi (imdbId, naziv, godina, kolicinaDvd, kolicinaBluRay, zanrId)
VALUES (5, 'Saw', 2020, 2, 2, 2);

INSERT INTO filmovi (imdbId, naziv, godina, kolicinaDvd, kolicinaBluRay, zanrId)
VALUES (6, 'Slagalica strave', 2005, 3, 3, 2);

INSERT INTO filmovi (imdbId, naziv, godina, kolicinaDvd, kolicinaBluRay, zanrId)
VALUES (3, 'Mamurluk', 2015, 5, 3, 1);

INSERT INTO posudbe (posudbaId, filmId, clanskiBroj, datumPosudbe, datumPovrata, cjenikId)
VALUES (1, 1, 1, '2024-05-05', '2024-06-05', 2);

INSERT INTO posudbe (posudbaId, filmId, clanskiBroj, datumPosudbe, datumPovrata, cjenikId)
VALUES (2, 2, 2, '2024-06-07', '2024-07-07', 2);

INSERT INTO posudbe (posudbaId, filmId, clanskiBroj, datumPosudbe, datumPovrata, cjenikId)
VALUES (3, 4, 3, '2024-08-08', '2024-09-08', 3);

INSERT INTO posudbe (posudbaId, filmId, clanskiBroj, datumPosudbe, datumPovrata, cjenikId)
VALUES (4, 5, 4, '2024-09-09', '2024-10-09', 3);

-- Iz tablice 'cjenik_posudbe' izračunajte prosječnu cijenu svih kategorija filmova.
SELECT ROUND(AVG(cijena), 2) 'Prosjek cijena'
FROM cjenik_posudbe;

-- Iz tablice 'posudbe' izračunajte ukupan broj posudbi.
SELECT COUNT(*) 'Ukupan broj posudbi'
FROM posudbe;

-- Iz tablice 'clanovi' dohvatite 'ime' i 'prezime' te ih spojite u jedan atribut 'ime i prezime'.
SELECT CONCAT(ime, ' ', prezime) 'ime i prezime'
FROM clanovi;

-- Iz tablice 'posudbe' izračunajte razliku u danima između atributa 'datumPosudbe' i 'datumPovrata' te rezultat sortirajte silazno.
SELECT posudbaId, DATEDIFF(datumPovrata, datumPosudbe) razlika
FROM posudbe
ORDER BY razlika DESC;

-- Iz tablica 'posudbe' i 'cjenik_posudbe' dohvatite sljedeće podatke:
-- posudbaId
-- kategorija
-- Ukupni broj posudbi po kategoriji
-- Te iste podatke grupirajte po 'kategoriji'

SELECT c.kategorija, COUNT(p.posudbaId) 'Ukupno posudbi = '
FROM posudbe p
INNER JOIN cjenik_posudbe c ON p.cjenikId = c.cjenikId
GROUP BY c.kategorija; 


-- Iz tablica 'clanovi' i 'posudbe' dohvatite sljedeće podatke:
-- clanskiBroj
-- ime
-- posudbaId
-- cjenikId
-- Morate dohvatiti sve kupce neovisno da li su nešto naručili.

SELECT c.clanskiBroj, c.ime, p.posudbaId, cj.cijena
FROM clanovi c
LEFT JOIN posudbe p ON c.clanskiBroj = p.clanskiBroj
LEFT JOIN cjenik_posudbe cj ON p.cjenikId = cj.cjenikId;

-- Iz tablica 'clanovi' i 'posudbe' dohvatite sljedeće podatke:
-- posudbaId
-- clanskiBroj
-- Potrebno je dohvatiti sve clanove koji nemaju posudbi.

SELECT p.posudbaId, c.clanskiBroj
FROM clanovi c
RIGHT JOIN posudbe p ON c.clanskiBroj = p.clanskiBroj;