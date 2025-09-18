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

## Dodatna konfiguracija Nginx-a
```bash
server {
    server_name vasa-domena.space;
    root /var/www/vas-projekt/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ ^/index\.php(/|$) {
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    listen 443 ssl http2; # managed by Certbot
    listen [::]:443 ssl http2 ipv6only=on; # managed by Certbot
    ssl_certificate /etc/letsencrypt/live/codetime.space/fullchain.pem; # managed by Certbot
    ssl_certificate_key /etc/letsencrypt/live/codetime.space/privkey.pem; # managed by Certbot
    include /etc/letsencrypt/options-ssl-nginx.conf; # managed by Certbot
    ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem; # managed by Certbot

}
server {
    if ($host = codetime.space) {
        return 301 https://vasa-domena.space$request_uri;
    } # managed by Certbot


    listen 80;
    listen [::]:80;
    server_name vasa-domena.space www.vasa-domena.space;
    return 404; # managed by Certbot
}
```

Provjera konfiguracije i restart servera - `sudo nginx -t && sudo systemctl reload nginx`