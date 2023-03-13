<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\VehicleType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(1)->create();
        
        VehicleType::create([
            "name" => "Vehiculo Oficial",
            "amount" => 0.00
        ]);
        VehicleType::create([
            "name" => "Vehiculo Residente",
            "amount" => 0.05
        ]);
        VehicleType::create([
            "name" => "Vehiculo No Residente",
            "amount" => 0.50
        ]);
    }
}
