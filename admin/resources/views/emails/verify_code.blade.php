<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận mã OTP</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        <h2 style="color: #007bff; text-align: center;">Chào bạn!</h2>
        <p>Bạn đã yêu cầu mã xác thực từ <strong>Hưng Thịnh Special Food</strong>.</p>
        <div style="background-color: #f8f9fa; padding: 15px; text-align: center; border-radius: 5px; margin: 20px 0;">
            <p style="font-size: 18px; margin-bottom: 10px;">Mã xác thực của bạn là:</p>
            <h1 style="font-size: 32px; color: #28a745; margin: 0; letter-spacing: 5px;">{{ $code }}</h1>
        </div>
        <p>Mã này sẽ hết hạn vào lúc: <strong>{{ \Carbon\Carbon::parse($expireTime)->format('H:i:s d/m/Y') }}</strong>.</p>
        <p>Nếu bạn không yêu cầu mã này, vui lòng bỏ qua email này.</p>
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #777; text-align: center;">Đây là email tự động, vui lòng không phản hồi.</p>
    </div>
</body>
</html>
