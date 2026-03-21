# 📝 Tiến Độ Công Việc & Kế Hoạch Tiếp Theo (Cập nhật: 06/03/2026)

Tài liệu này lưu trữ lại những gì đã hoàn thành trong phiên làm việc vừa qua và các bước có thể triển khai tiếp trong ngày mai.

---

## ✅ Những Việc Đã Hoàn Thành (Hôm nay)

### 1. Cấu Trúc Tổng Thể & Layout Toàn Trang (Global Layout)
- **Floating Navbar (Header Trong Suốt):** Navbar được làm lại với hiệu ứng kính mờ (glassmorphism), trong suốt khi ở đỉnh trang và bo tròn đổ bóng khi cuộn xuống.
- **Global Footer:** Đã tách đoạn code Footer nháp từ `page.tsx` sang `components/layout/Footer.tsx` và gắn vào `layout.tsx`. Toàn bộ website nay đã có Footer đồng nhất.
- **Quy hoạch Max-Width:** Đồng bộ hóa tất cả các trang lớn (Home, Products, Blog) giới hạn chiều ngang lại ở mức `max-w-[1200px] mx-auto` để layout không bị phình to.
- **Xử lý lỗi Overlap:** Thêm `pt-24 md:pt-32` padding-top vào các trang phụ để nội dung không bị thanh Navbar lơ lửng che khuất. Xóa các đoạn mã Header rác gây nhiễu trong `app/blog/page.tsx`.

### 2. Thiết Kế Trang Chủ (Homepage Redesign)
- **Hero Section:** Bố cục mới gồm 1 cột danh mục dọc (trái) và Slider Banner rộng (phải).
- **Danh Mục Nổi Bật:** Layout Icon ở trên, chữ ở dưới dạng Carousel trượt ngang gọn gàng. Hủy bỏ kiểu dáng Nút dài cũ.
- **List Category Products:** Thay vì Tab ẩn hiện, chuyển sang hiển thị lần lượt các Block nằm dọc của từng Danh mục đi kèm danh sách sản phẩm mới nhất của danh mục đó (4 sản phẩm/hàng trên PC).

### 3. Redesign Product Card "Mekong Pastel Edition" (UI/UX Cao Cấp)
- **Bo tròn khủng cực đại:** Vỏ thẻ được setting `rounded-[40px]`, mượt mà với nền kem `#F9F8F4`.
- **Phối màu Pastel:** Text và Badge sử dụng màu Cam Đất Terracotta (`#D8A48F`), Sage Green (`#B2AC88`) và Vàng Nhạt Soft Gold (`#F1E5AC`) cho các sao đánh giá.
- **Hover Animations (Framer Motion):** Phóng to hình ảnh nhịp nhàng khi rê chuột vào mức tỷ lệ 1.05. 
- **Glassmorphism Toolbar:** Thanh công cụ gồm Icon Wishlist, Quick View, Cart được tráng gương dọc bên phải sẽ hiện ra khi hover.
- **Nút "Thêm vào giỏ" Trầm:** Được ẩn phía dưới sát mép hình và sẽ tự trượt nhẹ lên (slide-up) khi trỏ chuột vào card.

---

## 🎯 Gợi Ý Kế Hoạch Cho Ngày Mai (Next Steps)

1. **Trang Cart & Checkout (Giỏ hàng & Thanh toán):**
   - Đảm bảo logic tính toán tổng tiền khớp với sản phẩm.
   - Kiểm tra UI đồng nhất theo chuẩn Pastel & Max-Width cho trang Checkout. Khả năng cần thiết kế thêm một Card mini cho Checkout Item.

2. **Trang Chi Tiết Sản Phẩm (Product Detail):**
   - Áp dụng các màu sắc Pastel (Terracotta, Sage Green) đồng bộ với Product Card.
   - Thêm phần chọn Biến Thể, xem mô tả, Tab Đánh Giá.
   - Nút Thêm vào giỏ hàng/Mua ngay to rõ và có hiệu ứng UX tốt.

3. **Responsive Mobile Check:**
   - Kiểm tra thực tế trên Viewport Mobile cho các thay đổi Navbar bo tròn có bị tràn không. 
   - Đảm bảo Sidebar Menu của Navbar trên Mobile hoạt động đóng/mở mượt.

4. **Tối Ưu Data/Image Backend:**
   - Cung cấp Image thực tế cho API Category để thay vì dùng icon kính lúp, ta có thể cho hiện Ảnh Danh mục thu nhỏ ở phần "Danh Mục Nổi Bật".
   - Test lại các đường dẫn Placeholder Image cho hoàn chỉnh.

> *Bạn hãy mở file này ra xem lại vào đầu phiên làm việc tiếp theo nhé!*
