const fs = require('fs');
const path = require('path');

const dict = {
    "Thống kĐ": "Thống kê",
    "Thống k?": "Thống kê",
    "Th?ng k?": "Thống kê",
    "Đơn hĐng": "Đơn hàng",
    "Đơn h?ng": "Đơn hàng",
    "Danh s?ch": "Danh sách",
    "Danh sĐch": "Danh sách",
    "Danh s?ch": "Danh sách",
    "NhĐ cung cấp": "Nhà cung cấp",
    "Nh? cung c?p": "Nhà cung cấp",
    "NhĐn bĐnh": "Nhân bánh",
    "Nh?n b?nh": "Nhân bánh",
    "KhĐch hĐng": "Khách hàng",
    "Kh?ch h?ng": "Khách hàng",
    "Khch hng": "Khách hàng",
    "Khách hng": "Khách hàng",
    "BĐi viết": "Bài viết",
    "B?i vi?t": "Bài viết",
    "Bi vi?t": "Bài viết",
    "BĐnh luận": "Bình luận",
    "B?nh lu?n": "Bình luận",
    "Bnh lu?n": "Bình luận",
    "MĐ giảm giĐ": "Mã giảm giá",
    "M? gi?m gi?": "Mã giảm giá",
    "M gi?m gi": "Mã giảm giá",
    "Cấu hĐnh": "Cấu hình",
    "C?u h?nh": "Cấu hình",
    "hon thnh": "hoàn thành",
    "ho?n th?nh": "hoàn thành",
    "Hon thnh": "Hoàn thành",
    "Ho?n th?nh": "Hoàn thành",
    "ch? xc nh?n": "chờ xác nhận",
    "chờ xc nh?n": "chờ xác nhận",
    "Ch? xc nh?n": "Chờ xác nhận",
    "Đ? xc nh?n": "Đã xác nhận",
    "đ? xc nh?n": "đã xác nhận",
    "? xc nh?n": "Đã xác nhận",
    "ang giao": "Đang giao",
    "? h?y": "Đã hủy",
    "Đ? h?y": "Đã hủy",
    "đ? h?y": "đã hủy",
    "? thanh ton": "Đã thanh toán",
    "Th?m": "Thêm",
    "Th?m": "Thêm",
    "m?i": "mới",
    "m?i": "mới",
    "quảng c?o": "quảng cáo",
    "qu?ng c?o": "quảng cáo",
    "Tr?ng th?i": "Trạng thái",
    "Tr?ng th?i": "Trạng thái",
    "S?n ph?m": "Sản phẩm",
    "S?n ph?m": "Sản phẩm",
    "T?n": "Tên",
    "Tn": "Tên",
    "Kh?i l??ng": "Khối lượng",
    "Kh?i l??ng": "Khối lượng",
    "H?nh ??ng": "Hành động",
    "H?nh ??ng": "Hành động",
    "Hnh ??ng": "Hành động",
    "C?p nh?t": "Cập nhật",
    "C?p nh?t": "Cập nhật",
    "X?a": "Xóa",
    "?ng xu?t": "Đăng xuất",
    "Đ?ng xu?t": "Đăng xuất",
    "Đng xu?t": "Đăng xuất",
    "ăng xuất": "Đăng xuất",
    "Qu?n l?": "Quản lý",
    "Qu?n l?": "Quản lý",
    "t?m ki?m": "tìm kiếm",
    "t?m ki?m": "tìm kiếm",
    "T?m ki?m": "Tìm kiếm",
    "T?m ki?m": "Tìm kiếm",
    "T?m theo": "Tìm theo",
    "T?m theo": "Tìm theo",
    "Chi ti?t": "Chi tiết",
    "Chi ti?t": "Chi tiết",
    "\uFFFD": "?",
    "Kh?ch hang": "Khách hàng",
    "D?i v?i": "Đối với",
    "th?ng tin": "thông tin",
    "L?u": "Lưu",
    "tr? l?i": "trở lại"
};

let fixedFiles = 0;

function processFile(filePath) {
    if (!filePath.endsWith('.tsx') && !filePath.endsWith('.ts')) return;
    try {
        let content = fs.readFileSync(filePath, 'utf8');
        let original = content;
        
        for (const [bad, good] of Object.entries(dict)) {
            // Replace globally
            content = content.split(bad).join(good);
        }
        
        if (content !== original) {
            fs.writeFileSync(filePath, content, 'utf8');
            fixedFiles++;
            console.log('Fixed dictionary terms in:', filePath);
        }
    } catch (e) {
    }
}

function walk(dir) {
    fs.readdirSync(dir).forEach(f => {
        let p = path.join(dir, f);
        if (fs.statSync(p).isDirectory()) walk(p);
        else processFile(p);
    });
}

walk(path.join(__dirname, 'resources', 'js'));
console.log('Total fixed dictionary:', fixedFiles);
