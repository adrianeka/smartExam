<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
        ]);

        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'status' => 'active',
            'role' => 'admin',
            'password' => bcrypt('12345678'),
            'status' => 'active',
        ])->assignRole('admin');
        $teacher = User::factory()->create([
            'name' => 'Test Teacher',
            'email' => 'teacher@example.com',
            'password' => bcrypt('12345678'),
            'status' => 'active',
            'user_code' => 'CX001',
            'phone' => '100 001 111',
            'first_login_at' => now()->subDays(10),
            'last_login_at' => now()->subDays(1),
            'last_course_login_at' => now()->subDays(2),
        ]);
        $teacher->assignRole('teacher');

        $student = User::factory()->create([
            'name' => 'Test Student',
            'email' => 'tesst123@example.com',
            'password' => bcrypt('12345678'),
            'status' => 'active',
            'user_code' => 'CX002',
            'phone' => '100 001 112',
            'first_login_at' => now()->subDays(5),
            'last_login_at' => now()->subHours(5),
            'last_course_login_at' => now()->subHours(6),
        ]);
        $student->assignRole('student');

        // Create some default courses for testing
        $course1 = \App\Models\Course::create([
            'code' => 'ENGLISH',
            'name' => 'English',
            'description' => 'Ujian Bahasa Inggris',
            'language' => 'English',
            'category' => null,
            'is_registered_allowed' => false,
            'is_unregistered_allowed' => true,
            'last_accessed_at' => \Carbon\Carbon::parse('2022-04-28 16:00:00'),
            'created_at' => \Carbon\Carbon::parse('2022-04-28 16:00:00')
        ]);

        $course2 = \App\Models\Course::create([
            'code' => 'INDONESIA',
            'name' => 'Indonesia',
            'description' => 'Bahasa Indonesia',
            'language' => 'Bahasa Indonesia',
            'category' => null,
            'is_registered_allowed' => true,
            'is_unregistered_allowed' => false,
            'last_accessed_at' => \Carbon\Carbon::parse('2022-04-28 16:00:00'),
            'created_at' => \Carbon\Carbon::parse('2022-04-28 16:00:00')
        ]);

        $course3 = \App\Models\Course::create([
            'code' => 'AIPROGRAMMING',
            'name' => 'AI Programming',
            'description' => 'AI Programming',
            'language' => 'English',
            'category' => 'Programming',
            'is_registered_allowed' => false,
            'is_unregistered_allowed' => true,
            'last_accessed_at' => \Carbon\Carbon::parse('2022-04-28 16:00:00'),
            'created_at' => \Carbon\Carbon::parse('2022-04-28 16:00:00')
        ]);

        $teacher2 = User::factory()->create(['name' => 'John Doe X'])->assignRole('teacher');
        $teacher3 = User::factory()->create(['name' => 'John Doe Y'])->assignRole('teacher');
        $teacher4 = User::factory()->create(['name' => 'John Doe Z'])->assignRole('teacher');

        // Attach courses with pivot stats
        $teacher->courses()->attach([
            $course1->id => ['time_spent_seconds' => 33, 'total_posts' => 0],
            $course2->id => ['time_spent_seconds' => 213, 'total_posts' => 0],
            $course3->id => ['time_spent_seconds' => 120, 'total_posts' => 0]
        ]);
        
        $teacher2->courses()->attach([$course1->id, $course3->id]);
        $teacher3->courses()->attach([$course1->id]);
        $teacher4->courses()->attach([$course1->id]);

        $student->courses()->attach([
            $course3->id => ['time_spent_seconds' => 33, 'total_posts' => 0],
            $course1->id => ['time_spent_seconds' => 213, 'total_posts' => 0],
            $course2->id => ['time_spent_seconds' => 33, 'total_posts' => 0],
        ]);
    }
}
