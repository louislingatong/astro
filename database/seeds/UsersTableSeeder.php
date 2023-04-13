<?php

use App\Models\User;
use App\Models\UserStatus;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create the system admin
        $this->_createSystemAdmin();

        // retrieve user status
        $status = UserStatus::where('name', config('user.statuses.active'))->first();

        // create employee role
        Role::create(['name' => config('user.roles.employee')]);

        if (config('app.env') === 'local') {
            factory(User::class, 20)->create([
                'user_status_id' => $status->id
            ])->assignRole(config('user.roles.employee'));
        }
    }

    private function _createSystemAdmin()
    {
        // retrieve user status
        $status = UserStatus::where('name', config('user.statuses.active'))->first();

        // create admin role
        Role::create(['name' => config('user.roles.admin')]);

        // create the system admin
        User::create([
            'first_name' => 'ASTRO',
            'last_name' => 'Administrator',
            'email' => 'admin@astro.ph',
            'password' => Hash::make('P@ssw0rd'),
            'user_status_id' => $status->id,
            'email_verified_at' => Carbon::now(),
        ])->assignRole(config('user.roles.admin'));
    }
}
