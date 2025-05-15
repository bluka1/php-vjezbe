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

ALTER TABLE filovi
ADD CONSTRAINT PK_filmovi PRIMARY KEY (imdbId);

ALTER TABLE posudbe
ADD CONSTRAINT PK_posudbe PRIMARY KEY (posudbaId);

ALTER TABLE cjenik_posudbe
ADD CONSTRAINT PK_cjenik_posudbe PRIMARY KEY (cjenikId);

-- U tablicama 'filmovi' i 'posudba' dodajte strane ključeve i ograničenje na update postaviti CASCADE.