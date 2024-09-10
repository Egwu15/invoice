<?php

namespace Database\Seeders;

use App\Models\DiscountType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DiscountType::factory()->create([
            'type_name' => 'Percentage',
            'description' => 'Discount is a percentage of the total amount',
        ]);

        DiscountType::factory()->create([
            'type_name' => 'Fixed',
            'description' => 'Discount is a fixed amount',
        ]);
    }
}
