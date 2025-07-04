# Koraci do MVC aplikacije

1. postaviti `index.php` file i prikazati osnovni layout
2. izdvojiti layout u zasebni file odnosno view koji će se `require`-ati kroz `index.php`
3. iz view-a odvojiti partialse u zasebne fileove radi lakše organizacije i čitljivosti
4. napraviti ostale view-ove koje aplikacija treba sadržavati
5. napraviti strukturu foldera i ažurirati putanje do view-ova
6. napraviti osnovni Router (za početak može kao asocijativni niz)
7. napraviti kontrolere koji će renderirati view-ove
8. napraviti Database klasu koja će biti povezana s bazom (poželjno da bude singleton)
9. iz kontrolera dohvatiti podatke iz baze te ih proslijediti view-u
10. ažurirati view da prikazuje podatke iz kontrolera
12. izdvojiti dohvaćanje podataka u klasu modela
13. prepraviti Router u OOP
13. prepraviti kontroler u OOP