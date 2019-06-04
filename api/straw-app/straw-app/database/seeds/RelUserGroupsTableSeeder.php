<?php

use Illuminate\Database\Seeder;

class RelUserGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        // create 10 users using the user factory
        factory(App\RelUserGroup::class, 50)->create();
    }
}
