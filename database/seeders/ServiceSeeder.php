<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::insert([
            ['name' => 'Corte de cabelo', 'duration' => 30],
            ['name' => 'Barba', 'duration' => 20],
            ['name' => 'Combo', 'duration' => 60],
        ]);
    }
}
