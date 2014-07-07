<?php

class RoleUserSeeder extends Seeder {
    public function run()
    {
        DB::table('role_user')->delete();

        RoleUser::create(['user_id' => 1, 'role_id' => 1]);

    }
}