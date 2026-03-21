<x-mail::message>
# Chào {{ $order->tennguoinhan }},

Cảm ơn bạn đã tin tưởng đặt hàng tại **Hưng Thịnh Food**. Đơn hàng của bạn đã được tiếp nhận và đang được xử lý.

### 📦 Thông tin đơn hàng: #{{ $order->id }}
- **Ngày đặt:** {{ $order->created_at->format('d/m/Y H:i') }}
- **Trạng thái:** {{ $order->trangthai }}
- **Phương thức thanh toán:** {{ $order->thanhToan->phuongthucthanhtoan == 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'Chuyển khoản ngân hàng' }}

### 🛒 Danh sách sản phẩm:
<x-mail::table>
| Sản phẩm | Số lượng | Đơn giá | Thành tiền |
| :--- | :---: | :---: | :---: |
@foreach($order->donhangchitiet as $item)
| {{ $item->bienthe->sanpham->tensp }} | {{ $item->soluong }} | {{ number_format($item->gia, 0, ',', '.') }}đ | {{ number_format($item->gia * $item->soluong, 0, ',', '.') }}đ |
@endforeach
| **Tổng cộng** | | | **{{ number_format($order->tongtien, 0, ',', '.') }}đ** |
| **Giảm giá** | | | **-{{ number_format($order->sotiengiam, 0, ',', '.') }}đ** |
| **Phí vận chuyển** | | | **{{ number_format($order->tienvc, 0, ',', '.') }}đ** |
| **TỔNG THANH TOÁN** | | | **{{ number_format($order->thanhtien, 0, ',', '.') }}đ** |
</x-mail::table>

---

### 🚚 Thông tin nhận hàng:
- **Người nhận:** {{ $order->tennguoinhan }}
- **Số điện thoại:** {{ $order->phone }}
- **Địa chỉ:** {{ $order->diachi }}

@if($order->thanhToan->phuongthucthanhtoan == 'chuyenkhoan_nganhang')
---
### 💳 Thông tin thanh toán:
*Quý khách đã chọn phương thức Chuyển khoản ngân hàng.*
@if($order->transfer_proof)
- **Ảnh bằng chứng chuyển khoản:** [Xem ảnh chứng từ]({{ asset('storage/' . $order->transfer_proof) }})
@endif
@endif

---

Nếu có bất kỳ thắc mắc nào, vui lòng liên hệ hotline: **0123 456 789**.

Trân trọng,<br>
**Đội ngũ Hưng Thịnh Food**
</x-mail::message>
