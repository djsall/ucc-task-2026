<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Api User',
            'email' => 'user@example.com',
        ]);

        User::factory()->helpdesk()->create([
            'name' => 'Helpdesk User',
            'email' => 'helpdesk@example.com',
        ]);
    }
}
