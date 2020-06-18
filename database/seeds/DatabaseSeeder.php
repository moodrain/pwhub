<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $users = collect();
        for ($i = 1; $i <= 3; $i++) {
            $users->push([
                'id' => $i,
                'email' => "user$i@mail.com",
                'name' => 'user' . $i,
                'password' => password_hash('123', PASSWORD_DEFAULT),
            ]);
        }
        DB::table('users')->insert($users->all());
        $apps = collect();
        for ($i = 1; $i <= 5; $i++) {
            $apps->push([
                'id' => $i,
                'name' => 'application-' . $i,
                'site' => 'https://application-' . $i .'.com',
                'created_at' => mDate(time() - mt_rand(1, 999) * 60),
            ]);
        }
        DB::table('applications')->insert($apps->all());
        $accounts = collect();
        $id = 1;
        $users->map(function($user) use (&$id, $apps, $accounts) {
           $apps->map(function($app) use (&$id, $user, $accounts) {
               for ($i = 1; $i <= 2; $i++) {
                    $accounts->push([
                        'id' => $id++,
                        'username' => $user['name'] . '-' . $app['name'] . '-account-' . $i,
                        'password' => encrypt(Str::random()),
                        'user_id' => $user['id'],
                        'application_id' => $app['id'],
                        'note' => Str::random(),
                        'created_at' => mDate(time() - mt_rand(1, 999) * 60),
                    ]);
               }
           });
        });
        DB::table('accounts')->insert($accounts->all());
    }

}
