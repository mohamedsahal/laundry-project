<?php

namespace Database\Seeders;

use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $units = [
            [
                'name' => 'Milligram',
                'short_form' => 'mg',
                'description' => 'Smallest metric weight unit',
                'is_active' => 1,
                'created_by' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Gram',
                'short_form' => 'g',
                'description' => 'Metric unit of weight',
                'is_active' => 1,
                'created_by' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Kilogram',
                'short_form' => 'kg',
                'description' => 'Common unit for heavier weights',
                'is_active' => 1,
                'created_by' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Tonne',
                'short_form' => 't',
                'description' => 'Metric ton (1000 kilograms)',
                'is_active' => 1,
                'created_by' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Ounce',
                'short_form' => 'oz',
                'description' => 'Imperial unit of weight',
                'is_active' => 1,
                'created_by' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Pound',
                'short_form' => 'lb',
                'description' => 'Imperial unit of weight, 16 ounces',
                'is_active' => 1,
                'created_by' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
        Unit::insert($units);
    }
}
