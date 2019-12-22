<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_user')->truncate();
        DB::table('users')->delete();
        DB::statement('ALTER TABLE spo_users AUTO_INCREMENT = 1');
        DB::table('roles')->delete();
        DB::statement('ALTER TABLE spo_roles AUTO_INCREMENT = 1');
        DB::table('roles')->insert([
            'title'  => 'admin',
            'desc'   => 'Администратор',
        ]);
        DB::table('roles')->insert([
            'title'  => 'candidate',
            'desc'   => 'Абитуриент',
        ]);
        DB::table('roles')->insert([
            'title'  => 'student',
            'desc'   => 'Студент',
        ]);
        DB::table('roles')->insert([
            'title'  => 'teacher',
            'desc'   => 'Преподаватель',
        ]);
        DB::table('roles')->insert([
            'title'  => 'principal',
            'desc'   => 'Директор',
        ]);
        DB::table('users')->insert([
            'email' => 'admin@mail.me',
            'password'  => bcrypt('admin')
        ]);
        $user = \App\Models\User::where('email', 'admin@mail.me')->first();
        $admRole = \App\Models\Role::where('title', 'admin')->first();
        $prepRole = \App\Models\Role::where('title', 'teacher')->first();
        $prinRole = \App\Models\Role::where('title', 'principal')->first();
        $user->roles()->attach($admRole->id);
        $user->roles()->attach($prepRole->id);
        $user->roles()->attach($prinRole->id);

    }
}
