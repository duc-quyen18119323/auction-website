<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Lại Mật Khẩu</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 28px;
        }
        .email-body {
            padding: 40px 30px;
            color: #333;
        }
        .email-body h2 {
            color: #667eea;
            margin-top: 0;
        }
        .email-body p {
            line-height: 1.6;
            margin: 15px 0;
        }
        .reset-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 40px;
            text-decoration: none;
            border-radius: 50px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        .reset-button:hover {
            opacity: 0.9;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .alternative-link {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            word-break: break-all;
            font-size: 12px;
            color: #666;
            margin: 20px 0;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="icon">🔐</div>
            <h1>Đặt Lại Mật Khẩu</h1>
        </div>
        
        <div class="email-body">
            <h2>Xin chào!</h2>
            
            <p>Bạn nhận được email này vì chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.</p>
            
            <div class="button-container">
                <a href="{{ url('/reset-password/' . $token . '?email=' . urlencode($email)) }}" class="reset-button">
                    Đặt Lại Mật Khẩu
                </a>
            </div>
            
            <p>Link đặt lại mật khẩu này sẽ hết hạn sau <strong>24 giờ</strong>.</p>
            
            <div class="warning">
                <strong>⚠️ Lưu ý:</strong> Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này. Tài khoản của bạn vẫn an toàn.
            </div>
            
            <p>Nếu bạn gặp vấn đề khi nhấp vào nút "Đặt Lại Mật Khẩu", hãy sao chép và dán URL bên dưới vào trình duyệt web của bạn:</p>
            
            <div class="alternative-link">
                {{ url('/reset-password/' . $token . '?email=' . urlencode($email)) }}
            </div>
            
            <p>Trân trọng,<br><strong>Đội ngũ Auction Website</strong></p>
        </div>
        
        <div class="email-footer">
            <p>© {{ date('Y') }} Auction Website. Tất cả quyền được bảo lưu.</p>
            <p>Email này được gửi tự động, vui lòng không trả lời.</p>
        </div>
    </div>
</body>
</html>
