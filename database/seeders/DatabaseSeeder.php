<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin
        \App\Models\User::create([
            'name' => 'Admin Amikom',
            'email' => 'admin@amikom.ac.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // 2. Kategori
        $kategori1 = \App\Models\Category::create([
            'name' => 'Seminar',
            'slug' => 'seminar',
        ]);

        $kategori2 = \App\Models\Category::create([
            'name' => 'Workshop',
            'slug' => 'workshop',
        ]);

        $kategori3 = \App\Models\Category::create([
            'name' => 'Entertainment',
            'slug' => 'entertainment',
        ]);

        // 3. Event 
        \App\Models\Event::create([
            'category_id' => $kategori1->id,
            'title' => 'UI/UX Masterclass',
            'description' => 'Belajar desain UI/UX dari expert.',
            'date' => '2026-06-01 09:00:00',
            'location' => 'Amikom Hall A',
            'price' => 75000,
            'stock' => 100,
        ]);

        \App\Models\Event::create([
            'category_id' => $kategori1->id,
            'title' => 'AI Conference 2026',
            'description' => 'Membahas perkembangan AI terbaru.',
            'date' => '2026-06-05 10:00:00',
            'location' => 'Auditorium',
            'price' => 100000,
            'stock' => 80,
        ]);

        \App\Models\Event::create([
            'category_id' => $kategori2->id,
            'title' => 'Laravel Bootcamp',
            'description' => 'Belajar Laravel dari dasar.',
            'date' => '2026-06-10 08:00:00',
            'location' => 'Lab Komputer 1',
            'price' => 50000,
            'stock' => 50,
        ]);

        \App\Models\Event::create([
            'category_id' => $kategori2->id,
            'title' => 'Web Development Workshop',
            'description' => 'Belajar membuat website modern.',
            'date' => '2026-06-12 09:00:00',
            'location' => 'Lab Komputer 2',
            'price' => 60000,
            'stock' => 60,
        ]);

        \App\Models\Event::create([
            'category_id' => $kategori3->id,
            'title' => 'E-Sport Tournament',
            'description' => 'Turnamen game antar mahasiswa.',
            'date' => '2026-06-15 13:00:00',
            'location' => 'Sport Center',
            'price' => 30000,
            'stock' => 200,
        ]);

        \App\Models\Event::create([
            'category_id' => $kategori3->id,
            'title' => 'Music Festival',
            'description' => 'Festival musik terbesar tahun ini.',
            'date' => '2026-06-20 18:00:00',
            'location' => 'Lapangan Utama',
            'price' => 120000,
            'stock' => 300,
        ]);
    }
}