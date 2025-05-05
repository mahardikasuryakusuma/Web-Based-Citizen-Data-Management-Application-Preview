<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengurusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name'     => 'Pengurus RW',
            'email'    => "mahardikasurya15@gmail.com",
            'password' => bcrypt('11111111'),
            'role' => 'pengurusrw'
        ]);
    }
}
