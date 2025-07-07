CREATE DATABASE IF NOT EXISTS receptidb;

USE receptidb;

CREATE TABLE IF NOT EXISTS recepti (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  naziv VARCHAR(255) UNIQUE NOT NULL,
  sastojci VARCHAR(255) UNIQUE NOT NULL,
  postupak TEXT NOT NULL,
  createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO recepti (naziv, sastojci, postupak)
VALUES 
('Kajgana', 'jaja, sol, sir, maslac', 'Umutite jaje u zdjelici, naribajte sir, ugrijte maslac na tavi, dodajte sir, potom jaja i miješajte 2 minute.'),
('Zdravi popeċak', 'jaja, zobene pahuljice, maslac', 'Umutite jaje u zdjelici, dodajte izmljevene zobene i promiješajte. Smjestu ispecite na malo maslaca na tavi.');

SELECT * FROM recepti;