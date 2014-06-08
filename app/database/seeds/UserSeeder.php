<?php


class UserSeeder extends Seeder{
    public function run()
    {
        DB::table('users')->delete();

        User::create([
            'username' => 'admin',
            'email' => 'christoffer@rydberg.me',
            'password' => 'tester',
            'register_ip' => '192.168.1.1',
        ]);
    }
}