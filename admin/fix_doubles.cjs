const fs = require('fs');
const path = require('path');

const wordDict = {
    "Th??m": "Thêm",
    "s??ch": "sách",
    "c??o": "cáo",
    "Ti??u đ??": "Tiêu đề",
    "Ti??u": "Tiêu",
    "m??i": "mới",
    "Ngư??i d??ng": "Người dùng",
    "Ngư??i": "Người",
    "d??ng": "dùng",
    "n??y": "này",
    "v??o": "vào",
    "H??nh đ??ng": "Hành động",
    "h??nh đ??ng": "hành động",
    "H??nh": "Hình", // Usually Hình ảnh unless H??nh đ??ng
    "l??n": "lên",
    "Tr??ng th??i": "Trạng thái",
    "tr??ng th??i": "trạng thái",
    "th??i": "thái",
    "b??i vi??t": "bài viết",
    "B??i vi??t": "Bài viết",
    "b??i": "bài",
    "B??i": "Bài",
    "v??": "về",
    "k??ch": "kịch",
    "Kh??i l??ng": "Khối lượng",
    "kh??i l??ng": "khối lượng",
    "Kh??i": "Khối",
    "l??ng": "lượng",
    "H??nh ??nh": "Hình ảnh", // ??nh would be ảnh
    "h??nh ??nh": "hình ảnh",
    "h??nh": "hình",
    "V??": "Về",
    "h?? th??ng": "hệ thống",
    "H?? th??ng": "Hệ thống",
    "th??ng": "thống",
    "ti??u đ??": "tiêu đề",
    "ti??u": "tiêu",
    "Ch??n": "Chọn",
    "K??o": "Kéo",
    "X??a": "Xóa",
    "n??n": "nên", // usually nên
    "ph??n": "phần",
    "h??ng": "hàng", // usually Đơn hàng
    "Đ??n h??ng": "Đơn hàng",
    "T??n": "Tên",
    "B??nh": "Bình", // Bình luận
    "b??nh": "bình",
    "b??nh lu??n": "bình luận",
    "B??nh lu??n": "Bình luận",
    "M?? gi??m gi??": "Mã giảm giá",
    "M??": "Mã",
    "m??": "mã",
    "g??n": "gần",
    "gi??": "giá",
    "c??c": "các",
    "đi??u": "điều",
    "đ??i": "đổi",
    "kh??ch": "khách",
    "Kh??ch": "Khách",
    "Kh??ch h??ng": "Khách hàng",
    "VN??": "VNĐ",
    "Th??i": "Thời",
    "th??c": "thức",
    "K??ch": "Kích",
    "h??a": "hóa",
    "c??n": "còn",
    "CH??": "CHỜ",
    "Nh??n b??nh": "Nhân bánh",
    "nh??n b??nh": "nhân bánh",
    "nh??n": "nhận", // xác nhận
    "b??nh": "bánh",
    "S?? l??ng": "Số lượng",
    "S??": "Số",
    "D??u": "Dấu",
    "t??y": "tùy",
    "H??ng": "Hàng",
    "Ph??ng": "Phòng",
    "C??ng": "Cộng",
    "S??ng": "Sáng",
    "T??m ki??m": "Tìm kiếm",
    "t??m ki??m": "tìm kiếm",
    "T??m": "Tìm",
    "t??m": "tìm",
    "ch??nh": "chỉnh", // Tùy chỉnh, Chỉnh sửa
    "đ??y": "đây", // Dưới đây
    "Th??ng k??": "Thống kê",
    "Th??ng": "Thống",
    "r??c": "rác", // Thùng rác
    "x??a": "xóa",
    "d??n": "dẫn", // Đường dẫn
    "C??c": "Các",
    "kh??ng": "không",
    "Kh??ng": "Không",
    "k??m": "kiếm",
    "t??n": "tiền", // Tổng tiền
    "ch??": "chờ", // Chờ xác nhận
    "l??": "là", // Dưới đây là
    "bi??n": "biến", // Biến thể
    "Bi??n th??": "Biến thể",
    "B??": "Bỏ", // Hủy bỏ
    "t??c": "tác", // Đối tác
    "TH??": "THÊM",
    "R??": "Rác", // Thùng Rác
    "Nh?? cung c??p": "Nhà cung cấp",
    "Nh??": "Nhà",
    "Ng??y": "Ngày",
    "ng??y": "ngày",
    "phi??n": "phiên",
    "Gi??": "Giá",
    "ni??n": "niên",
    "b??n": "bạn",
    "L??t": "Lượt",
    "ti??n": "tiền",
    "Ng??i": "Người",
    "ng??i": "người",
    "L??": "Lưu", // Lưu thay đổi
    "l??u": "lưu",
    "L??u": "Lưu",
    "đ??": "đã",
    "h??": "hủy",
    "??": "ã", // Đã
    "c??": "có",
    "??ư": "Đư",
    "??ng": "Đảng",
    "??ang": "Đang",
    "??": "Đã",
    "??ể": "Để",
    "??ịnh": "Định",
    "??ơn": "Đơn",
    "??p": "Đáp",
    "??nh": "Ảnh",
    "??a": "Địa",
    "??c": "Được",
    "??i": "Đại",
    "??n": "Đến",
    "??t": "Đặt",
    "??u": "Đầu"
};

let fixedFiles = 0;

function processFile(filePath) {
    if (!filePath.endsWith('.tsx') && !filePath.endsWith('.ts')) return;
    try {
        let content = fs.readFileSync(filePath, 'utf8');
        let original = content;
        
        // Multi-word exact context replacements first
        for (const [bad, good] of Object.entries(wordDict)) {
            if (bad.includes(' ')) {
                content = content.split(bad).join(good);
            }
        }
        
        // Then word level replacements
        for (const [bad, good] of Object.entries(wordDict)) {
            if (!bad.includes(' ')) {
                const escapedBad = bad.replace(/\?/g, '\\?');
                const regex = new RegExp(`(?<=\\b|\\s|")(${escapedBad})(?=\\b|\\s|"|'|<|>)`, 'g');
                content = content.replace(regex, good);
            }
        }

        // Final literal replacements for ?? prefix missing the D
        content = content.replace(/\?\?ang/g, "Đang");
        content = content.replace(/\?\?ã/g, "Đã");
        content = content.replace(/\?\?ơn/g, "Đơn");
        content = content.replace(/\?\?ịnh/g, "Định");
        content = content.replace(/\?\?ể/g, "Để");
        content = content.replace(/\?\?ư/g, "Đư");
        
        if (content !== original) {
            fs.writeFileSync(filePath, content, 'utf8');
            fixedFiles++;
            console.log('Fixed ?? dict in:', filePath);
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
console.log('Total fixed ?? dict:', fixedFiles);
