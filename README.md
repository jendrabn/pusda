## Deployment on VPS Ubuntu Server

1. Install Nginx

```
sudo apt update && sudo apt upgrade -y
sudo apt install nginx -y
sudo ufw allow 'Nginx Full'
```

2. Install PHP 8.3

```
sudo apt install -y software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt install php8.3 php8.3-fpm php8.3-{cli,curl,mbstring,xml,gd,imagick,mysql,sqlite3,zip}
```

3. Install Composer

```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php --install-dir=/usr/local/bin --filename=composer
```

4. Install Node JS

```
curl -fsSL https://deb.nodesource.com/setup_22.x | sudo -E bash -
sudo apt install nodejs -y
```

5. Install MySQL

```
sudo apt install mysql-server -y
sudo mysql
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '';
FLUSH PRIVILEGES;
EXIT;

mysql -u root -p
CREATE DATABASE laravel_pusda;
EXIT;
```

6. Sqlite

```
touch database/database.sqlite
chown www-data:www-data database/database.sqlite
chmod 664 database/database.sqlite
chown -R www-data:www-data database
chmod -R 775 database
```

5. Setup Laravel Project

```
 git clone https://github.com/jendrabn/pusda.git /var/www/pusda
 cd /var/www/pusda
 composer install
 npm install
 npm run build
 cp .env.example .env
 sudo chown -R www-data.www-data storage
 sudo chown -R www-data.www-data bootstrap/cache
 php artisan key:generate
 php artisan storage:link
 php artisan migrate --seed
```

6. Nginx Configuration

```
nano /etc/nginx/sites-available/pusda.conf
```

```
server {
    listen 80;
    listen [::]:80;
    server_name pusda.zenby.my.id;
    root /var/www/pusda/public;

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
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

```
sudo ln -s /etc/nginx/sites-available/pusda.conf /etc/nginx/sites-enabled/
nginx -t
systemctl restart nginx
```

7. Install SSL

```
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d pusda.zenby.my.id
```

## SEO (Front Pages)

### Fitur yang sudah aktif
- Meta SEO dinamis untuk halaman Front (title, description, canonical, robots, OG, Twitter Cards, JSON-LD).
- Robots.txt dinamis (blok non-prod, blok area sensitif di production).
- Sitemap XML dinamis dengan cache + generator harian.
- Force HTTPS canonical di production.

### Endpoint
- `GET /robots.txt`
- `GET /sitemap.xml`

### Command manual
```
php artisan sitemap:generate
```

### Catatan deployment
- Pastikan scheduler aktif agar sitemap ter-regenerate harian.
- Jika staging/dev, halaman otomatis `noindex,nofollow` via header `X-Robots-Tag`.
