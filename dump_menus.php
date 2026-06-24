<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$menus = App\Models\Menu::orderBy('id')->get();
$code = "<?php\n\nnamespace Database\Seeders;\n\nuse App\Models\Menu;\nuse Illuminate\Database\Seeder;\n\nclass MenuSeeder extends Seeder\n{\n    public function run(): void\n    {\n        // Truncate table first to avoid duplicates if run multiple times\n        Menu::truncate();\n\n        \$menus = [\n";

foreach ($menus as $m) {
    $code .= "            [\n";
    $code .= "                'id' => {$m->id},\n";
    $code .= "                'name' => '{$m->name}',\n";
    $code .= "                'type' => " . ($m->type ? "'{$m->type}'" : "null") . ",\n";
    $code .= "                'content' => " . ($m->content ? "'" . addslashes($m->content) . "'" : "null") . ",\n";
    $code .= "                'url' => '{$m->url}',\n";
    $code .= "                'icon' => " . ($m->icon ? "'{$m->icon}'" : "null") . ",\n";
    $code .= "                'permission_name' => " . ($m->permission_name ? "'{$m->permission_name}'" : "null") . ",\n";
    $code .= "                'parent_id' => " . ($m->parent_id ? $m->parent_id : "null") . ",\n";
    $code .= "                'order' => {$m->order},\n";
    $code .= "            ],\n";
}
$code .= "        ];\n\n        foreach (\$menus as \$menu) {\n            Menu::create(\$menu);\n        }\n    }\n}\n";

file_put_contents(__DIR__ . '/database/seeders/MenuSeeder.php', $code);
echo "MenuSeeder.php generated successfully!";
