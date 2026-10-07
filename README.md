# Trung tâm Học tập cộng đồng xã Cửa Tùng

Website cổng thông tin + quản trị kiểu WordPress trên Laravel 12.

## Yêu cầu

- PHP 8.2+ (khuyến nghị PHP 8.3 trên Laragon)
- MySQL/MariaDB
- Composer, Node.js 18+

## Cài đặt

```bash
composer install
cp .env.example .env
php artisan key:generate
# Cấu hình DB MySQL trong .env
php artisan migrate:fresh --seed
php artisan storage:link
npm install
npm run build
```

## Chạy dev

```bash
php artisan serve
npm run dev
php artisan queue:work
```

## Scheduler (cron)

```text
* * * * * php /path/to/artisan schedule:run
```

Lệnh: `content:publish-scheduled` (mỗi phút), `trash:purge` (hàng ngày).

## Admin

- URL: `/admin/login`
- Sau seed, xem mật khẩu admin trong mục **Tài khoản quản trị (seed)** bên dưới (được ghi khi chạy seeder).

## Hướng dẫn admin ngắn

1. **Tin tức / Thông báo / Sự kiện**: menu trái → thêm mới → soạn nội dung → chọn trạng thái → Cập nhật.
2. **Media**: tải file lên thư viện, dùng ID ảnh đại diện trong form bài viết.
3. **Menu**: Giao diện → Menu → chỉnh mục `primary` cho header.
4. **Cài đặt**: thông tin site, permalink, số mục trang chủ.

## Tài khoản quản trị (seed)

- Email: `admin@example.com`
- Mật khẩu: `123456` (có thể đặt `ADMIN_PASSWORD` trong `.env` trước khi seed)
