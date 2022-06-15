<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrator',
            'username' => 'admin',
            'status' => 'Aktif',
            'level' => 'admin',
            'password' => bcrypt('admin123'),
            'id_cabang' => 0,
        ]);
    }
}