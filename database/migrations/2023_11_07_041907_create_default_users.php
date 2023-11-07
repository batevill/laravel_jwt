<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('admins')->insert([
            'name' => 'Default Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        DB::table('managers')->insert([
            'name' => 'Default Manager',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('123456'),
        ]);

        DB::table('users')->insert([
            'name' => 'Default User',
            'email' => 'employee@gmail.com',
            'password' => Hash::make('123456'),
        ]);
    }

};
