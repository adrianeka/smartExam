<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

foreach (App\Models\Menu::all() as $m) {
    echo $m->id . " - " . $m->name . " - TYPE: " . $m->type . " - PARENT: " . $m->parent_id . "\n";
}
