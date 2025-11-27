<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'username' => 'admin',
            'name' => 'Administrator Sistem',
            'email' => 'admin@pupuksubsidi.id',
            'password' => Hash::make('admin123'),
            'phone' => '+62 812-3456-7890',
            'address' => 'Jl. Sitoluama, Laguboti, Toba Samosir',
        ]);
    }
}
