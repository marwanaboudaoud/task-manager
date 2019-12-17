<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment('local')) {
            $this->call(UserTableSeeder::class);
            $this->call(MeetingListTableSeeder::class);
            $this->call(CategoryTableSeeder::class);
            $this->call(TaskTableSeeder::class);
            $this->call(NoteTableSeeder::class);
            $this->call(MeetingListMemberTableSeeder::class);
        }
    }
}
