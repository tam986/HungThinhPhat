const fs = require('fs');
const path = require('path');

let fixedFiles = 0;

function processFile(filePath) {
    if (!filePath.endsWith('.tsx') && !filePath.endsWith('.ts')) return;
    try {
        let content = fs.readFileSync(filePath, 'utf8');
        let original = content;
        
        // 1. Ternary operator with spaces: ' Đ ' -> ' ? '
        content = content.replace(/ Đ /g, ' ? ');
        
        // 2. Optional chaining: 'objĐ.prop' -> 'obj?.prop'
        // Matches letter, number, ')', or ']' followed by 'Đ.'
        content = content.replace(/([a-zA-Z0-9)\]])Đ\./g, '$1?.');
        
        // 3. Optional property/parameter: 'nameĐ:' -> 'name?:'
        content = content.replace(/([a-zA-Z0-9)\]])Đ:/g, '$1?:');
        
        // 4. Nullish coalescing: 'ĐĐ' -> '??'
        content = content.replace(/ĐĐ/g, '??');
        
        // 5. Special cases like 'urlĐ=' -> 'url?='
        content = content.replace(/([a-zA-Z0-9)\]])Đ=/g, '$1?=');
        
        // 6. Clean up the artifact character before valid Đ
        content = content.replace(/\uFFFDĐ/g, 'Đ');
        
        if (content !== original) {
            fs.writeFileSync(filePath, content, 'utf8');
            console.log('Restored syntax in:', filePath);
            fixedFiles++;
        }
    } catch (e) {
        console.error(e);
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
console.log('Total fixed syntax:', fixedFiles);
