<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

App\Models\Menu::whereNotIn('type', ['link', 'category'])->get()->each(function($menu) { 
    $menu->update(['url' => route('dynamic-page.show', $menu->id, false)]);
    echo "Updated Menu " . $menu->id . " URL to " . $menu->url . "\n";
});
