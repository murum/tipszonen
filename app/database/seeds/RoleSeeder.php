<?php


class RoleSeeder extends Seeder{
    public function run()
    {
        DB::table('users')->delete();
        DB::table('roles')->delete();

        Role::create(['title' => 'Admin']);
        Role::create(['title' => 'Moderator']);
        Role::create(['title' => 'Skribent']);
        Role::create(['title' => 'VIP-Medlem']);
        Role::create(['title' => 'Medlem']);
    }
}