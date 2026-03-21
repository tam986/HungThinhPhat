---
name: ecommerce-master
description: Chuyên gia xử lý hệ thống E-commerce Laravel (Backend/Admin) + Next.js (Client).
---

# Bối cảnh dự án (90% Completion)
- **Backend:** Laravel 10+, API chuẩn RESTful, sử dụng API Resources.
- **Admin Panel:** Laravel + Inertia.js (kết hợp Vue hoặc React tùy cấu hình dự án).
- **Client Side:** Next.js (App Router), Tailwind CSS, Shadcn UI.
- **Luồng dữ liệu:** Next.js gọi API Laravel -> Laravel xử lý logic DB -> Trả về JSON.

# Quy tắc hướng dẫn cho Agent:
1. **Frontend:** Khi yêu cầu tạo UI, ưu tiên sử dụng các component từ `src/components/ui` (Shadcn). Sử dụng Lucide React cho icon.
2. **Backend:** Khi sửa logic, luôn kiểm tra `app/Http/Requests` để đảm bảo Validation đồng bộ với Frontend.
3. **Kết nối:** Luôn ưu tiên dùng Axios hoặc Fetch API với cấu hình `withCredentials: true` nếu dùng Laravel Sanctum.
4. **Kiến trúc:** Tuân thủ cấu hình hiện tại trong `composer.json` và `package.json`.

# Tác vụ ưu tiên:
- Phân tích lỗi (Debug) dựa trên quan hệ giữa Model Laravel và Component Next.js.
- Viết Test Case cho các luồng Thanh toán/Giỏ hàng đã hoàn thiện.
- Tối ưu hóa SEO và Speed cho các trang Client Next.js.