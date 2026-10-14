<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if(User::count() == 0){
            User::create([
                'name'   => 'Admin',
                'email'  => 'admin@admin.com',
                'password'   => Hash::make('123456'),
                 'user_type' => 1,
            ]);
            /* seeder call */
            $this->call([
                MasterControlSeeder::class,
                CountryControlSeeder::class,
                UnitSeeder::class,
                ServiceSeeder::class,
            ]);
        }
        $this->call(PermissionSeeder::class);
    }
}
