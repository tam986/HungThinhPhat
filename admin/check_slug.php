<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Bienthe;

$slugSearch = 'banh-pia-sau-rieng-chay-dau-xanh-350-39';
$found = Bienthe::where('slug', $slugSearch)->first();

if ($found) {
    echo "Found variant: " . $found->id . " - " . $found->full_name . "\n";
} else {
    echo "NO variant found for slug: " . $slugSearch . "\n";
    
    // Check similar slugs
    $baseSlug = 'banh-pia-sau-rieng-chay-dau-xanh-350';
    $similar = Bienthe::where('slug', 'like', $baseSlug . '%')->get(['id', 'slug', 'full_name']);
    echo "Similar slugs:\n";
    foreach ($similar as $s) {
        echo "- ID: {$s->id} | Slug: {$s->slug} | Name: {$s->full_name}\n";
    }
}
