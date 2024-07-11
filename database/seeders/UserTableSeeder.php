<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name'      => 'Root',
            'email'     => 'root@kfe.com',
            'password'  => Hash::make('12345678'),
            'type_id'   => 1,
            'is_active' => 1
        ]);
    }
}
