# Hướng Dẫn Cấu Hình Email cho Chức Năng Quên Mật Khẩu

## 1. Cấu hình file .env

Mở file `.env` và cập nhật các thông tin sau:

### Sử dụng Gmail (khuyến nghị cho development)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Lấy App Password từ Gmail:

1. Truy cập: https://myaccount.google.com/security
2. Bật "2-Step Verification" (Xác minh 2 bước)
3. Tìm "App passwords" (Mật khẩu ứng dụng)
4. Chọn "Mail" và "Windows Computer"
5. Copy mật khẩu 16 ký tự và dán vào `MAIL_PASSWORD`

### Sử dụng Mailtrap (khuyến nghị cho testing)

Mailtrap là dịch vụ email testing miễn phí, không gửi email thật:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@auction-website.com
MAIL_FROM_NAME="${APP_NAME}"
```

Đăng ký tài khoản miễn phí tại: https://mailtrap.io/

## 2. Kiểm tra cấu hình

Sau khi cấu hình xong, chạy lệnh:

```bash
php artisan config:clear
php artisan cache:clear
```

## 3. Test chức năng

1. Truy cập: http://127.0.0.1:8000/login
2. Click vào "Quên mật khẩu?"
3. Nhập email đã đăng ký
4. Kiểm tra email (hoặc Mailtrap inbox)
5. Click vào link trong email
6. Nhập mật khẩu mới
7. Đăng nhập với mật khẩu mới

## 4. Lưu ý bảo mật

- **KHÔNG BAO GIỜ** commit file `.env` lên Git
- Sử dụng App Password, không dùng mật khẩu Gmail chính
- Với production, nên sử dụng dịch vụ email chuyên nghiệp như:
  - Amazon SES
  - SendGrid
  - Mailgun
  - Postmark

## 5. Troubleshooting

### Lỗi "Connection could not be established"

- Kiểm tra lại MAIL_HOST, MAIL_PORT
- Đảm bảo firewall không chặn port 587
- Kiểm tra username/password

### Lỗi "Authentication failed"

- Kiểm tra lại MAIL_USERNAME và MAIL_PASSWORD
- Với Gmail, đảm bảo đã tạo App Password
- Với Gmail, đảm bảo đã bật "Less secure app access"

### Email không được gửi

- Chạy `php artisan queue:work` nếu sử dụng queue
- Kiểm tra log tại `storage/logs/laravel.log`
- Kiểm tra spam folder

## 6. Cấu trúc Database

Bảng `password_reset_tokens` đã được tạo với cấu trúc:

```sql
- email (string, indexed)
- token (string)
- created_at (timestamp)
```

Token sẽ tự động hết hạn sau 24 giờ.

## 7. Routes đã tạo

```php
GET  /forgot-password          -> Hiển thị form quên mật khẩu
POST /forgot-password          -> Gửi link reset password
GET  /reset-password/{token}   -> Hiển thị form đặt lại mật khẩu
POST /reset-password           -> Xử lý đặt lại mật khẩu
```

## 8. Security Features

- Token được hash và lưu trong database
- Token tự động expire sau 24 giờ
- Mỗi email chỉ có 1 token active (token cũ sẽ bị xóa khi tạo token mới)
- Token bị xóa sau khi sử dụng thành công
- Validation đầy đủ cho email và password
- Messages lỗi bằng tiếng Việt
