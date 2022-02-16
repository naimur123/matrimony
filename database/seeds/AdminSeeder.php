<?php

use App\Admin;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Developer', 'email' => 'admin@admin.com', 'password' => bcrypt('Admin@123!'), 'remember_token' => Str::random(60), 'user_type' => 'super_admin', 'created_at' => Carbon::now(), 'updated_at' =>Carbon::now()],
            ['name' => 'Shahjalal', 'email' => 'shajushahjalal@gmail.com', 'password' => bcrypt('12345678'), 'remember_token' => Str::random(60), 'user_type' => 'super_admin', 'created_at' => Carbon::now(), 'updated_at' =>Carbon::now()]
        ];
        Admin::insert($data);
    }
}
