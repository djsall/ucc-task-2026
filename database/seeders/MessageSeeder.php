<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Message::factory(2)->forRandomUser()->create();
        Message::factory(2)->forRandomUser()->unanswered()->requiresHuman()->create();
    }
}
