# Omogućavanje HTTPS-a
## Instalacija SSL certifikata (Let's Encrypt)
Preporučeno - snap instalacija:
```bash
# uklonite staru verziju ako postoji
sudo apt remove certbot

# instalirajte snap ako nije instaliran
sudo apt install snapd
sudo snap install core
sudo snap refresh core

# instalirajte Certbot
sudo snap install --classic certbot

# napravite link
sudo ln -s /snap/bin/certbot /usr/bin/certbot
```
Alternativno - apt instalacija:
```bash
sudo apt update
sudo apt install certbot python3-certbot-nginx  # Nginx
# ili
sudo apt install certbot python3-certbot-apache # Apache
```

## Dobivanje SSL certifikata
Za Nginx:
`sudo certbot --nginx`
<!-- Apache: `sudo certbot --apache` -->
Tijekom procesa:
- unesite email adresu za obavijesti
- prihvatite uvjete korištenja (Y)
- odaberite hoćete li dijeliti email s EFF (Y/N)
- odaberite redirekciju na HTTPS za svoju domenu

## Provjera automatskog obnavljanja
```bash
# provjera timer-a
sudo systemctl status snap.certbot.renew.timer

# ručno testiranje obnavljanja (dry run)
sudo certbot renew --dry-run
```
## Testiranje HTTPS-a
```bash
# provjera SSL konfiguracije
curl -I https://vasa-domena.com
# online SSL test - https://www.ssllabs.com/ssltest/
```
## Provjera redirekcije
`curl -I http://vasa-domena.com` -> trebao bi vratiti 301/302 redirect na HTTPS

## Dodatne sigurnosne postavke (opcionalno)
Nginx - dodatni security headers
```bash
# dodajte u server blok
add_header X-Frame-Options "SAMEORIGIN" always;
add_header X-XSS-Protection "1; mode=block" always;
add_header X-Content-Type-Options "nosniff" always;
add_header Strict-Transport-Security "max-age=63072000; includeSubDomains; preload" always;
```