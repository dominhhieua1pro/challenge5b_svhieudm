## Yêu cầu challenge:
Lập trình bằng framework Laravel, sử dụng DB MySQL để xây dựng
website quản lý thông tin sinh viên, tài liệu của 1 lớp học.

## Install:
- Clone this project (Clone project từ git về htdocs trong xampp)
- Run composer install or composer update (Tạo folder vender)
- Create .env file : cp .env.example .env (Tạo ra file .env để cấu hình Database)
- Generate app key : php artisan key:generate (Sinh key chạy Laravel)
- Migrate database: php artisan migrate (Tạo database)
- Seed database: php artisan db:seed (Tạo dữ liệu có sẵn)
- Run: php artisan storage:link (Tạo Storage ra thư mục pubic)
- Open up web server: php artisan serve (Chạy server)
- Browse app: localhost:8000 or http://127.0.0.1:8000
