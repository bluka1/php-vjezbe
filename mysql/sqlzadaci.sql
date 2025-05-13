-- SELECT id, name, age FROM clanovi;

CREATE DATABASE IF NOT EXISTS `videoteka`;

CREATE TABLE IF NOT EXISTS `clanovi` (
  `clanskiBroj` INT(10) UNSIGNED NOT NULL,
  `ime` VARCHAR(255) NOT NULL,
  `prezime` VARCHAR(255) NOT NULL,
  `datumUclanjenja` DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS `filmovi` (
  `imdbId` INT(10) UNSIGNED NOT NULL,
  `naziv` VARCHAR(255) NOT NULL,
  `godina` INT(4) UNSIGNED NOT NULL,
  `kolicinaDvd` TINYINT(3) UNSIGNED NOT NULL,
  `kolicinaBluRay` TINYINT(3) UNSIGNED NOT NULL,
  `zanrId` TINYINT(2) UNSIGNED NOT NULL
);

CREATE TABLE IF NOT EXISTS 'zanrovi' (
  'zanrId' TINYINT(2) UNSIGNED NOT NULL,
  'naziv' varchar(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS `cjenik_posudbe` (
  `cjenikId` TINYINT(2) UNSIGNED NOT NULL,
  `kategorija` VARCHAR(255) NOT NULL,
  `cijena` DOUBLE(3,2) NOT NULL
);

CREATE TABLE IF NOT EXISTS 'posudbe' (
  'posudbaId' INT(10) UNSIGNED NOT NULL,
  'filmId' INT(10) UNSIGNED NOT NULL,
  'clanskiBroj' INT(10) UNSIGNED NOT NULL,
  'datumPosudbe' DATE NOT NULL,
  'datumPovrata' DATE NOT NULL,
  'cjenikId' TINYINT(2) UNSIGNED NOT NULL
);


-- INSERT INTO `zanrovi`(zanrId, naziv)
-- VALUES(1, 'Komedija');

-- UPDATE `zanrovi` 
-- SET
--   `zanrId` = 7,
--   `naziv` = 'Drama'
-- WHERE
--   `zanrId` = 1;

-- DELETE FROM `clanovi`
-- WHERE `clanskiBroj` = 1;

-- U tablicu 'clanovi' umetnite tri nova člana po želji.
-- U tablicu 'zanr' umetnite tri nova žanra po želji.
-- U tablici 'clanovi' jednom članu promjenite datum učlanjenja na današnji datum.
-- U tablicama 'clanovi' i 'zanr' izbrišite zadnji zapis.

INSERT INTO `clanovi` (`clanskiBroj`, `ime`, `prezime`, `datumUclanjenja`)
VALUES
(1, 'Ivan', 'Ivić', '2023-09-12'),
(2, 'Ana', 'Horvat', '2022-11-03'),
(3, 'Marko', 'Kovač', '2024-01-20');

INSERT INTO 'zanrovi' ('zanrId', 'naziv')
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

CREATE USER IF NOT EXISTS korisnikbaze@localhost IDENTIFIED BY '1234567890';

GRANT ALL ON videoteka.* TO korisnikbaze@localhost;