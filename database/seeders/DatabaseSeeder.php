<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            OffersTemplateSeed::class
        ]);
        Admin::insert([
            'name' =>  'Ravi',
            'email' => 'abc1@gmail.com',
            'status' => 1,
            'phone_no' => '9876543210',
            'password' => '$2y$10$IJl3K7mIqGqNDZ9fOixzfOf/XMwqemWV/BF7uHyyCFyeEShlMvdZi',
        ]);
    }
}
