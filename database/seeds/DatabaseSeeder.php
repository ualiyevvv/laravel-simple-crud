<?php

use \App\Model\Post;
use \App\Model\User;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(\App\Model\User::class,4)->create();
        factory(\App\Model\Post::class,15)->create();

    }
}
