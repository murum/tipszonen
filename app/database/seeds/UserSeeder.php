<?php


class UserSeeder extends Seeder{
    public function run()
    {
        DB::table('role_user')->delete();
        DB::table('users')->delete();

        User::create([
            'username' => 'admin',
            'email' => 'christoffer@rydberg.me',
            'password' => Hash::make('tester'),
            'register_ip' => '192.168.1.1',
        ]);

        RoleUser::create([
            'user_id' => User::first()->id,
            'role_id' => Role::first()->id
        ]);
    }
}