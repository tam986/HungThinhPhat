<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực OTP - Hưng Thịnh</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 20px 0;
            background-color: #f8f9fa;
        }

        .header img {
            height: 150px;
            max-width: 100%;
        }

        .content {
            padding: 30px;
            text-align: left;
        }

        .otp-code {
            text-align: center;
            margin: 30px 0;
            font-size: 28px;
            font-weight: bold;
            color: #d9534f;
        }

        .footer {
            text-align: center;
            padding: 20px;
            background-color: #f8f9fa;
            font-size: 14px;
            color: #666;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            margin: 10px 0;
        }

        @media only screen and (max-width: 600px) {
            .container {
                width: 100%;
                margin: 10px;
            }

            .header img {
                height: 120px;
            }

            .otp-code {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('logo/HungThinh.png') }}" alt="Logo Hưng Thịnh">
        </div>
        <div class="content">
            <p>Xin chào Quý Khách,</p>
            <p>Bạn vừa yêu cầu xác minh tài khoản. Vui lòng sử dụng mã xác thực sau để hoàn tất quá trình:</p>
            <div class="otp-code">{{ $code }}</div>
            <p>Mã xác thực sẽ hết hạn sau 5 phút. Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này.</p>
            <p>Trân trọng,<br><strong>Đội ngũ Hưng Thịnh</strong></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Hưng Thịnh Special Food. Mọi quyền được bảo lưu.</p>
        </div>
    </div>
</body>

</html>
