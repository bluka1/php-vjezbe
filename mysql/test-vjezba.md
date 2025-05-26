# vjezba za test

Knjižnica želi izraditi relacijsku bazu podataka radi vođenja evidencije o knjigama, autorima, žanrovima, korisnicima te posudbama knjiga.
Svaka knjiga ima jednog autora i pripada jednom žanru.
Knjige se mogu posuđivati korisnicima knjižnice, a jedna knjiga može biti više puta posuđena kroz vrijeme. 
Također, jedan korisnik može posuditi više različitih knjiga.

- Kreirajte Chenov reducirani dijagram baze podataka.
- Kreirajte relacijski ER dijagram (model baze).
- Normalizirajte bazu podataka (do 3NF).
- Implementirajte bazu u MySQL-u.
- Popunite tablice s nekoliko testnih podataka.
- Dohvatite sve aktivne posudbe s imenima korisnika i knjiga.
- Dohvatite broj trenutno posuđenih knjiga po korisniku.
- Dohvatite sve knjige koje nisu trenutno posuđene.
- Kreirajte pohranjenu proceduru koja vraća broj posudbi po žanru.
- Kreirajte pogled koji prikazuje cijelu povijest posudbi sa svim relevatnim podacima korisnika i knjiga.