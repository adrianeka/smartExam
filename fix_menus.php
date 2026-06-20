<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$menus = App\Models\Menu::where('type', '!=', 'category')->whereNull('permission_name')->get();
foreach($menus as $m) {
    $v = 'view_menu_' . $m->id;
    Spatie\Permission\Models\Permission::firstOrCreate(['name' => $v]);
    Spatie\Permission\Models\Permission::firstOrCreate(['name' => 'edit_menu_' . $m->id]);
    $m->update(['permission_name' => $v]);
    echo "Fixed: {$m->name}\n";
}
