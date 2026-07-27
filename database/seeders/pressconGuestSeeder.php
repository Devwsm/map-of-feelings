<?php

namespace Database\Seeders;

use App\Models\pressconGuest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class pressconGuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $guests = [
            [
                'name' => 'Ancha',
                'category' => 'Crew',
                'group' => 'WSM Crew',
                'requires_name' => false,
            ],
            [
                'name' => 'Tim Media 01',
                'category' => 'Media',
                'group' => 'Media Invitation',
                'requires_name' => true,
            ],
            [
                'name' => 'Cinta',
                'category' => 'DJ/Musician Colleague',
                'group' => 'Cinta Laura',
                'max_pax' => 3, // 1 tamu boleh bawa sampai 3 pax
                'requires_name' => false,
            ],
        ];

        foreach ($guests as $guest) {
            pressconGuest::create([
                'slug' => pressconGuest::generateSlug($guest['name'], $guest['category']),
                'name' => $guest['name'],
                'category' => $guest['category'],
                'group' => $guest['group'],
                'max_pax' => $guest['max_pax'] ?? 1,
                'requires_name' => $guest['requires_name'],
            ]);
        }
    }
}