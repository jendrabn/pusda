## Development Setup

```
git clone https://github.com/jendrabn/pusda-situbondo.git
cd pusda-situbondo
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm install
npm run build
php artisan serve
```
