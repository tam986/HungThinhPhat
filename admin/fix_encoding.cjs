const fs = require('fs');
const path = require('path');
const iconv = require('iconv-lite');

let fixedFiles = 0;

function processFile(filePath) {
    if (!filePath.endsWith('.tsx') && !filePath.endsWith('.ts')) return;
    try {
        const buf = fs.readFileSync(filePath);
        const corruptedStr = iconv.decode(buf, 'utf8');
        
        // Only process files that obviously have mangled UTF-8 in them
        if (corruptedStr.match(/[ÄáºÆÃ]/)) {
            const originalBytes = iconv.encode(corruptedStr, 'cp1258');
            const restoredStr = iconv.decode(originalBytes, 'utf8');
            
            if (corruptedStr !== restoredStr) {
                fs.writeFileSync(filePath, restoredStr, 'utf8');
                console.log('Fixed:', filePath);
                fixedFiles++;
            }
        }
    } catch (e) {
        // Ignored
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
console.log('Total fixed using cp1258:', fixedFiles);
