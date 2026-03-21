<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Bienthe;
use Illuminate\Support\Str;

$variants = Bienthe::all();
$count = 0;

foreach ($variants as $v) {
    $newSlug = Str::slug($v->full_name);
    if ($v->slug !== $newSlug) {
        $v->slug = $newSlug;
        $v->save();
        $count++;
    }
}

echo "Successfully updated $count slugs in the database.\n";
