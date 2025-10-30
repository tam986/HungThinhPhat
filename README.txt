# Laravel Web Project
Đây là dự án Hưng Thịnh Special Food
## Yêu cầu hệ thống
- PHP >= 8.1
- Composer
- Laravel >= 10.x
- MySQL hoặc MariaDB
- Node.js + npm (nếu có sử dụng frontend build như Vite hoặc Laravel Mix)

---

##Cài đặt

### 1. Cài đặt composer

composer install

### 2. Cài đặt frontend 

npm install && npm run dev

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=thanhtam1532@gmail.com
MAIL_PASSWORD=bhjzptzyxjnbfsgz
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=thanhtam1532@gmail.com
MAIL_FROM_NAME="Hưng Thịnh Special Food"

### 3. Generate key

php artisan key:generate

### 4. Migrate database

php artisan migrate


### 5. Tạo symbolic link cho storage

php artisan storage:link


### ✅ Flasher (Flash message đẹp)

Sử dụng thư viện Flasher để hiển thị thông báo:

composer require php-flasher/flasher-laravel
php artisan vendor:publish --tag=flasher-config

### ✅ Gửi Mail (`Illuminate\Support\Facades\Mail`)

Tạo Mailable:

php artisan make:mail OrderShipped


### ✅ Storage:link (`Illuminate\Support\Facades\Storage`)

Tạo liên kết:

php artisan storage:link







