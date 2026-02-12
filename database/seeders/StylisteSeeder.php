<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StylisteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'Kenza Styliste',
            'email' => 'kenza@atelier.com',
            'password' => bcrypt('password123'),
            'role' => 'styliste', // Assure-toi d'avoir la colonne 'role' dans ta table users
        ]);
        \App\Models\User::create([
            'name' => 'Monsieur Create',
            'email' => 'crete@dev.com',
            'password' => bcrypt('password123'),
            'role' => 'client', // Assure-toi d'avoir la colonne 'role' dans ta table users
        ]);
}
}
