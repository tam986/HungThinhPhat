const fs = require('fs');
const path = require('path');

const charMap = {
    // Specifically mapping the [Consonant]\uFFFD?[Vowel] instances back to normal words
    "Kh\uFFFD?ăng": "Không",
    "Kh\uFFFD?ng": "Không",
    "s\uFFFD?ch": "sách",
    "Nh\uFFFD?n": "Nhân",
    "b\uFFFD?nh": "bánh",
    "B\uFFFD?nh": "Bình",
    "Kh\uFFFD?ch": "Khách",
    "B\uFFFD?i": "Bài",
    "b\uFFFD?i": "bài",
    "h\uFFFD?nh": "hình",
    "H\uFFFD?nh": "Hành",
    "x\uFFFD?c": "xác",
    "X\uFFFD?c": "Xác",
    "nh\uFFFD?n": "nhận",
    "T\uFFFD?m": "Tìm",
    "t\uFFFD?m": "tìm",
    "t\uFFFD?n": "tiền",
    "T\uFFFD?n": "Tên", // Usually Tên sản phẩm
    "Th\uFFFD?m": "Thêm",
    "v\uFFFD?o": "vào",
    "ph\uFFFD?n": "phần",
    "Ph\uFFFD?n": "Phân",
    "Th\uFFFD?nh": "Thành",
    "th\uFFFD?nh": "thành",
    "n\uFFFD?o": "nào",
    "h\uFFFD?a": "hóa",
    "t\uFFFD?nh": "tính",
    "T\uFFFD?nh": "Tính",
    "ch\uFFFD?nh": "chỉnh",
    "Ch\uFFFD?nh": "Chỉnh",
    "\uFFFD?Đang": "Đang",
    "\uFFFD?Đã": "Đã",
    "\uFFFD?t": "ít", 
    "Đ\uFFFD?t": "Đợt",
    "\uFFFD?ăng": "đăng",
    "Bi\uFFFD?n": "Biến",
    "r\uFFFD?c": "rác",
    "R\uFFFD?c": "Rác",
    "Chuy\uFFFD?n": "Chuyển",
    "chuy\uFFFD?n": "chuyển",
    "th\uFFFD?i": "thái",
    "t\uFFFD?c": "tức",
    "n\uFFFD?y": "này",
    "X\uFFFD?a": "Xóa",
    "c\uFFFD?c": "các",
    "C\uFFFD?c": "Các",
    "b\uFFFD?n": "bạn",
    "tr\uFFFD?i": "trải",
    "Phi\uFFFD?n": "Phiên",
    "s\uFFFD?u": "sưu",
    "t\uFFFD?ch": "tích",
    "ti\uFFFD?u": "tiêu",
    "c\uFFFD?i": "cải",
    "Ng\uFFFD?y": "Ngày",
    "ng\uFFFD?y": "ngày",
    "t\uFFFD?i": "tại",
    "vi\uFFFD?n": "viên",
    "gi\uFFFD?p": "giúp",
    "Kh\uFFFD?c": "Khác",
    "k\uFFFD?ch": "kịch",
    
    // Also including the 'Đ?' format which might be left over in the 8 files
    "KhĐăng": "Không",
    "KhĐ?ăng": "Không",
    "KhĐ?ng": "Không",
    "sĐ?ch": "sách",
    "NhĐ?n": "Nhân",
    "bĐ?nh": "bánh",
    "BĐ?nh": "Bình",
    "KhĐ?ch": "Khách",
    "BĐ?i": "Bài",
    "bĐ?i": "bài",
    "hĐ?nh": "hình",
    "HĐ?nh": "Hành",
    "HĐnh": "Hành",
    "xĐ?c": "xác",
    "XĐ?c": "Xác",
    "nhĐ?n": "nhận",
    "TĐ?m": "Tìm",
    "tĐ?m": "tìm",
    "tĐ?n": "tiền",
    "TĐ?n": "Tên", 
    "ThĐ?m": "Thêm",
    "ThĐm": "Thêm",
    "vĐ?o": "vào",
    "phĐ?n": "phần",
    "PhĐ?n": "Phân",
    "ThĐ?nh": "Thành",
    "thĐ?nh": "thành",
    "nĐ?o": "nào",
    "hĐ?a": "hóa",
    "tĐ?nh": "tính",
    "TĐ?nh": "Tính",
    "chĐ?nh": "chỉnh",
    "ChĐ?nh": "Chỉnh",
    "ĐĐang": "Đang",
    "ĐĐã": "Đã",
    "Đăng xuĐ?t": "Đăng xuất",
    "Đăng xuất": "Đăng xuất",
    "BiĐ?n": "Biến",
    "rĐ?c": "rác",
    "ChuyĐ?n": "Chuyển",
    "chuyĐ?n": "chuyển",
    "thĐ?i": "thái",
    "tĐ?c": "tức",
    "nĐ?y": "này",
    "XĐ?a": "Xóa",
    "cĐ?c": "các",
    "bĐ?n": "bạn",
    "trĐ?i": "trải",
    "PhiĐ?n": "Phiên",
    "sĐ?u": "sưu",
    "tĐ?ch": "tích",
    "tiĐ?u": "tiêu",
    "cĐ?i": "cải",
    "NgĐ?y": "Ngày",
    "ngĐ?y": "ngày",
    "tĐ?i": "tại",
    "viĐ?n": "viên",
    "giĐ?p": "giúp",
    "KhĐ?c": "Khác",
    "kĐ?ch": "kịch",
    
    // Some context fixes to ensure no literal "?" is stuck matching
    "h? th?ng" : "hệ thống",
    "H? th?ng" : "Hệ thống",
    "t?n kho"  : "tồn kho",
    "t?i ?n"   : "tải lên",
    "?ăng"     : "đăng",
};

let fixedFiles = 0;
function processFile(filePath) {
    if (!filePath.endsWith('.tsx') && !filePath.endsWith('.ts')) return;
    try {
        let content = fs.readFileSync(filePath, 'utf8');
        let original = content;
        
        for (const [bad, good] of Object.entries(charMap)) {
            content = content.split(bad).join(good);
        }
        
        // Final broad sweep for \uFFFD? and \uFFFD replacing it with '?' just in case TS syntax broke
        // Wait, \uFFFD? inside TS syntax? No, it only affects strings.
        
        if (content !== original) {
            fs.writeFileSync(filePath, content, 'utf8');
            fixedFiles++;
            console.log('Final mapping applied to:', filePath);
        }
    } catch (e) {}
}

function walk(dir) {
    fs.readdirSync(dir).forEach(f => {
        let p = path.join(dir, f);
        if (fs.statSync(p).isDirectory()) walk(p);
        else processFile(p);
    });
}

walk(path.join(__dirname, 'resources', 'js'));
console.log('Total final map fixing:', fixedFiles);
