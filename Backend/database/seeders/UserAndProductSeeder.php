<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;

class UserAndProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           // Criar 10 usuários
           User::factory(10)->create();

           // Criar 5 produtos
           Product::factory(5)->create();
    }
}
