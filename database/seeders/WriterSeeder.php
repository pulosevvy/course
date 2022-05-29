<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WriterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $writerRole = Role::create(['name' => 'writer']);
        User::create([
            'name' => 'Writer',
            'email' => 'writer@writer.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'role_id' => $writerRole->id
        ]);
    }
}
