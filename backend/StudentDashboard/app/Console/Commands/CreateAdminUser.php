<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use  App\Models\Admin;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';
    protected $description = 'Create an admin user and generate a JWT token';
   

    /**
     * The console command description.
     *
     * @var string
     */

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //take admin data
        $username = $this->ask('Enter admin user name');
        $password = $this->secret('Enter Admin Password');
        //create Admin
        $admin = new Admin();
        $admin->name=$username;
        $admin->password=Hash::make($password);
        $admin->save();
        // Generate a JWT token for the admin user
        $token = JWTAuth::fromUser($admin);

        $this->info('Admin user created with token: ' . $token);

    }
}
