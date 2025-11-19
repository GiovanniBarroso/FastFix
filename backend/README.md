### 2. Backend – Laravel
```bash
cd backend
cp .env
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve
```