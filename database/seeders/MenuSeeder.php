<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Menu Laporan Lanjutan (Hanya untuk Admin dan Teacher)
        $laporanMenu = Menu::create([
            'name' => 'Laporan Lanjutan',
            'url' => '#',
            'icon' => 'fa-solid fa-chart-line',
            'permission_name' => 'view reports', // asumsikan view reports ada, atau biarkan null agar admin saja
            'order' => 1,
        ]);

        Menu::create([
            'name' => 'Statistik Kelulusan',
            'url' => 'admin.reports.index',
            'icon' => 'fa-solid fa-chart-pie',
            'permission_name' => 'view reports',
            'parent_id' => $laporanMenu->id,
            'order' => 1,
        ]);
    }
}
