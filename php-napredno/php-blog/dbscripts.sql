CREATE DATABASE IF NOT EXISTS blogdb;

USE blogdb;

CREATE TABLE IF NOT EXISTS korisnici (
  id AUTO_INCREMENT INT UNSIGNED PRIMARY KEY,
  korisnickoIme VARCHAR(255) UNIQUE NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL
  lozinka VARCHAR(255) UNIQUE NOT NULL
  createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
)

CREATE TABLE IF NOT EXISTS clanci (
  id AUTO_INCREMENT INT UNSIGNED,
  korisnikId INT UNSIGNED NOT NULL,
  naslov VARCHAR(255) NOT NULL,
  tijelo TEXT NOT NULL,
  createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (korisnikId) REFERENCES korisnici(id) ON DELETE CASCADE
)

CREATE TABLE IF NOT EXISTS komentari (
  id AUTO_INCREMENT INT UNSIGNED,
  korisnikId INT UNSIGNED NOT NULL,
  clanakId INT UNSIGNED NOT NULL,
  tekst TEXT NOT NULL,
  createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  FOREIGN KEY (korisnikId) REFERENCES korisnici(id) ON DELETE CASCADE,
  FOREIGN KEY (clanakId) REFERENCES clanci(id) ON DELETE CASCADE
)

INSERT INTO korisnici (korisnickoIme, email, lozinka) VALUES
('bluka1', 'bluka1@example.com', 'lozinka123'),
('ana_k', 'ana@example.com', 'tajna456'),
('marko_dev', 'marko@example.com', 'sifra789');

INSERT INTO clanci (naslov, tijelo, korisnikId) VALUES
('Moj prvi PHP projekt', 'Napravio sam jednostavnu PHP aplikaciju koristeći MVC strukturu.', 1),
('Putovanje u Pariz', 'Pariz je bio predivan, uživala sam u kulturi i hrani.', 2),
('Laravel tips & tricks', 'Ovo su trikovi koje koristim u svakodnevnom radu s Laravelom.', 3),
('Kako učiti backend', 'Savjeti za backend razvoj uključuju praksu, tutorijale i male projekte.', 1);

INSERT INTO komentari (tekst, korisnikId, clanakId) VALUES
('I ja volim PHP! Super post.', 2, 1),
('Pariz je stvarno čaroban!', 3, 2),
('Odlični Laravel savjeti, hvala!', 1, 3),
('Baš mi je ovo trebalo, super članak!', 2, 4),
('Imaš li više ovakvih postova?', 1, 2);

SELECT * FROM korisnici;
SELECT * FROM komentari;
SELECT * FROM clanci;