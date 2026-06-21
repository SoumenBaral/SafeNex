<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Flood',              'slug' => 'flood',              'icon' => '🌊', 'color' => '#1E90FF'],
            ['name' => 'Fire',               'slug' => 'fire',               'icon' => '🔥', 'color' => '#FF4500'],
            ['name' => 'Cyclone',            'slug' => 'cyclone',            'icon' => '🌀', 'color' => '#8B008B'],
            ['name' => 'Earthquake',         'slug' => 'earthquake',         'icon' => '🏚️', 'color' => '#8B4513'],
            ['name' => 'Road Accident',      'slug' => 'road-accident',      'icon' => '🚗', 'color' => '#FF6347'],
            ['name' => 'Building Collapse',  'slug' => 'building-collapse',  'icon' => '🏗️', 'color' => '#A0522D'],
            ['name' => 'Landslide',          'slug' => 'landslide',          'icon' => '⛰️', 'color' => '#6B8E23'],
            ['name' => 'River Erosion',      'slug' => 'river-erosion',      'icon' => '🏞️', 'color' => '#4682B4'],
            ['name' => 'Lightning',          'slug' => 'lightning',          'icon' => '⚡', 'color' => '#FFD700'],
            ['name' => 'Other',              'slug' => 'other',              'icon' => '⚠️', 'color' => '#808080'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
