<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->create('admin', 'admin@admin.com');
        $this->create('userA', 'userA@userA.com');
        $this->create('userB', 'userB@userB.com');
    }

    private function create(string $name, string $email): void
    {
        $user = \App\User::firstOrNew(['email' => $email]);
        if (!$user->exists) {
            $user->fill([
                'name' => $name,
                'email' => $email,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'email_verified_at' => now(),
                'remember_token' => Str::random(10)
            ]);
        }
        $user->save();
    }
}
