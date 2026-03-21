const fs = require('fs');
const path = require('path');

const wordDict = {
    // Basic replacements
    "c?c": "các",
    "qu?ng": "quảng",
    "c?o": "cáo",
    "khuy?n": "khuyến",
    "tr?n": "trên",
    "Th?m": "Thêm",
    "hi?n": "hiện",
    "Hi?n": "Hiện",
    "S?p": "Sắp",
    "x?p": "xếp",
    "Kh?ng": "Không",
    "ti?u": "tiêu",
    "B?n": "Bạn",
    "ch?c": "chắc",
    "mu?n": "muốn",
    "x?a": "xóa",
    "n?y": "này",
    "Ch?a": "Chưa",
    "n?o": "nào",
    "B?m": "Bấm",
    "th?m": "thêm",
    "m?c": "mục",
    "s?n": "sản",
    "ph?m": "phẩm",
    "Ph?n": "Phân",
    "lo?i": "loại",
    "h?ng": "hàng",
    "h?a": "hóa",
    "s?p": "sắp",
    "Tr?ng": "Trạng",
    "th?i": "thái",
    "T?m": "Tìm",
    "M?i": "Mới",
    "nh?t": "nhất",
    "t?ng": "tổng",
    "d?n": "dẫn",
    "gi?m": "giảm",
    "T?n": "Tên",
    "t?c": "tức",
    "X?a": "Xóa",
    "t?m": "tìm",
    "th?y": "thấy",
    "b?nh": "bình",
    "lu?n": "luận",
    "d?i": "dưới",
    "ki?m": "kiểm",
    "duy?t": "duyệt",
    "ph?n": "phản",
    "h?i": "hồi",
    "kh?ch": "khách",
    "Kh?ch": "Khách",
    "Th?i": "Thời",
    "N?i": "Nội",
    "C?ng": "Cộng",
    "Duy?t": "Duyệt",
    "ch?i": "chối",
    "K?t": "Kết",
    "th?c": "thúc",
    "ch?y": "chạy",
    "Khuy?n": "Khuyến",
    "T?o": "Tạo",
    "chi?n": "chiến",
    "d?ch": "dịch",
    "h?t": "hết",
    "t?o": "tạo",
    "di?n": "diễn",
    "k?t": "kết",
    "th?ng": "thống",
    "h?n": "hạn",
    "ho?c": "hoặc",
    "Th?ng": "Thống",
    "t?i": "tải",
    "X?c": "Xác",
    "nh?n": "nhận",
    "Ch?o": "Chào",
    "m?ng": "mừng",
    "b?n": "bạn",
    "t?t": "tắt",
    "ho?t": "hoạt",
    "h?m": "hôm",
    "B?i": "Bài",
    "vi?t": "viết",
    "Tu?n": "Tuần",
    "Ng?y": "Ngày",
    "Nh?n": "Nhân",
    "tr?ng": "trống", // Could also be trạng but mostly trống if isolated
    "c?a": "của",
    "Bi?n": "Biến",
    "d?ng": "dạng", // Biến dạng or sử dụng -> "d?ng"
    "s?ch": "sách",
    "li?u": "liệu",
    "x?c": "xác",
    "ho?n": "hoàn",
    "th?nh": "thành",
    "h?y": "hủy",
    "Kh?i": "Khối",
    "t?nh": "tính",
    "v?n": "vận",
    "chuy?n": "chuyển",
    "Gi?m": "Giảm",
    "c?ng": "cộng",
    "v?ng": "vùng",
    "to?n": "toán",
    "V?n": "Vận",
    "ki?n": "kiện",
    "ng?y": "ngày",
    "l?m": "làm",
    "vi?c": "việc",
    "Xu?t": "Xuất",
    "T?t": "Tất",
    "ti?n": "tiền",
    "b?i": "bài",
    "n?i": "nội",
    "r?c": "rác",
    "c?p": "cấp",
    "kh?i": "khôi",
    "ph?c": "phục",
    "v?nh": "vĩnh",
    "vi?n": "viễn",
    "kh?ng": "không",
    "ch?n": "chọn",
    "Li?n": "Liên",
    "M?ng": "Mạng",
    "c?u": "cấu",
    "h?nh": "hình",
    "l?u": "lưu",
    "li?n": "liên",
    "tho?i": "thoại",
    "ph?ng": "phòng",
    "ng?n": "ngân",
    "kho?n": "khoản",
    "h?p": "hợp",
    "M?t": "Mật",
    "T?i": "Tài",
    "quy?n": "quyền",
    "Qu?n": "Quản",
    "Ch?nh": "Chỉnh",
    "s?a": "sửa",
    "Thi?t": "Thiết",
    "l?p": "lập",
    "H?y": "Hủy",
    "S?a": "Sửa",
    "l?i": "lại",
    "k?ch": "kịch",
    "K?ch": "Kịch",
    "bi?n": "biến"
};

// Words that have multiple meanings depending on context:
const contextDict = {
    // "t?n": ồn/tên/tồn. usually "tồn kho" or "tên".  "t?n kho" => "tồn kho"
    "t?n kho": "tồn kho",
    "Đ?ng xu?t": "Đăng xuất",
    "Tr?ng th?i": "Trạng thái",
    "h? th?ng": "hệ thống",
    "H? th?ng": "Hệ thống",
    "b? s?u t?p": "bộ sưu tập",
    "s? d?ng": "sử dụng"
};

let fixedFiles = 0;

function processFile(filePath) {
    if (!filePath.endsWith('.tsx') && !filePath.endsWith('.ts')) return;
    try {
        let content = fs.readFileSync(filePath, 'utf8');
        let original = content;
        
        // 1. Context replacements first
        for (const [bad, good] of Object.entries(contextDict)) {
            content = content.split(bad).join(good);
        }
        
        // 2. Word by word replacement
        // Only replace if matched with word boundaries (to avoid messing up regex or valid parts)
        for (const [bad, good] of Object.entries(wordDict)) {
            // Need to escape ?
            const escapedBad = bad.replace(/\?/g, '\\?');
            // Regex to match the word boundary but allows ? inside
            const regex = new RegExp(`(?<=\\b|\\s|")(${escapedBad})(?=\\b|\\s|"|'|<|>)`, 'g');
            content = content.replace(regex, good);
        }
        
        // Any remaining typical ? word (e.g. "?ng" inside "Đang")
        content = content.replace(/Đ\?ng/g, "Đăng");
        content = content.replace(/Đ\?ng/g, "Đang"); // Wait, "Đ?ng" -> Đăng or Đang or Đóng. If isolated:
        content = content.replace(/h\? t/g, "hệ t");
        content = content.replace(/v\? /g, "về ");
        content = content.replace(/t\?i/g, "tải");

        if (content !== original) {
            fs.writeFileSync(filePath, content, 'utf8');
            fixedFiles++;
            console.log('Fixed words in:', filePath);
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
console.log('Total fixed word dictionary:', fixedFiles);
