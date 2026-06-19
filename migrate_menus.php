<?php
use App\Models\Menu;

// Category: Pembelajaran
$pembelajaran = Menu::firstOrCreate(['name' => 'Pembelajaran'], ['type' => 'category', 'url' => '#', 'order' => 1]);
Menu::firstOrCreate(['name' => 'Mata Kuliah Saya'], ['type' => 'link', 'url' => 'learning.courses', 'icon' => 'fa-solid fa-book', 'parent_id' => $pembelajaran->id, 'order' => 1]);
Menu::firstOrCreate(['name' => 'Aktivitas Pembelajaran'], ['type' => 'link', 'url' => 'learning.activities', 'icon' => 'fa-regular fa-calendar', 'parent_id' => $pembelajaran->id, 'order' => 2]);
Menu::firstOrCreate(['name' => 'Evaluasi'], ['type' => 'link', 'url' => 'learning.evaluations', 'icon' => 'fa-solid fa-clipboard-check', 'parent_id' => $pembelajaran->id, 'order' => 3]);
Menu::firstOrCreate(['name' => 'Laporan', 'parent_id' => $pembelajaran->id], ['type' => 'link', 'url' => 'learning.reports', 'icon' => 'fa-solid fa-file-lines', 'order' => 4]);

// Category: Administrasi Platform
$admin = Menu::firstOrCreate(['name' => 'Administrasi Platform'], ['type' => 'category', 'url' => '#', 'order' => 2]);

// Dropdown: Manajemen Pengguna
$pengguna = Menu::firstOrCreate(['name' => 'Manajemen Pengguna'], ['type' => 'link', 'url' => '#', 'icon' => 'fa-solid fa-layer-group', 'parent_id' => $admin->id, 'order' => 1]);
Menu::firstOrCreate(['name' => 'Daftar Pengguna'], ['type' => 'link', 'url' => 'admin.users.index', 'parent_id' => $pengguna->id, 'order' => 1]);
Menu::firstOrCreate(['name' => 'Daftar Role'], ['type' => 'link', 'url' => 'admin.roles.index', 'parent_id' => $pengguna->id, 'order' => 2]);
Menu::firstOrCreate(['name' => 'Tambah Pengguna'], ['type' => 'link', 'url' => 'admin.user.create', 'parent_id' => $pengguna->id, 'order' => 3]);

// Dropdown: Manajemen Mata Kuliah
$matkul = Menu::firstOrCreate(['name' => 'Manajemen Mata Kuliah'], ['type' => 'link', 'url' => '#', 'icon' => 'fa-solid fa-folder-open', 'parent_id' => $admin->id, 'order' => 2]);
Menu::firstOrCreate(['name' => 'Daftar Mata Kuliah'], ['type' => 'link', 'url' => 'admin.courses.index', 'parent_id' => $matkul->id, 'order' => 1]);
Menu::firstOrCreate(['name' => 'Daftar Sesi'], ['type' => 'link', 'url' => 'admin.enroll.create', 'parent_id' => $matkul->id, 'order' => 2]);
Menu::firstOrCreate(['name' => 'Kategori Sesi'], ['type' => 'link', 'url' => 'admin.session-categories.index', 'parent_id' => $matkul->id, 'order' => 3]);

// Dropdown: Pengaturan Platform
$pengaturan = Menu::firstOrCreate(['name' => 'Pengaturan Platform'], ['type' => 'link', 'url' => '#', 'icon' => 'fa-solid fa-gear', 'parent_id' => $admin->id, 'order' => 3]);
Menu::firstOrCreate(['name' => 'Laporan Platform', 'parent_id' => $pengaturan->id], ['type' => 'link', 'url' => 'admin.reports.index', 'order' => 1]);
Menu::firstOrCreate(['name' => 'Manajemen Menu'], ['type' => 'link', 'url' => 'admin.menus.index', 'parent_id' => $pengaturan->id, 'order' => 2]);

echo "Migration complete!";
