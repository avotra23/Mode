<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrateur Assiat',
            'email' => 'admin@assiat.com',
            'password' => Hash::make('Password123!'), // Changez ce mot de passe après connexion
            'role' => 'admin', // Assurez-vous que votre migration User accepte le champ 'role'
        ]);

        $this->command->info('Utilisateur Administrateur créé avec succès !');
        $this->command->info('Email: admin@assiat.com');
        $this->command->info('Pass: Password123!');
    }
}