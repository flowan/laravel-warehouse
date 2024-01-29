<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create
                {--name= : The name of the user}
                {--email= : The email address of the user}
                {--password= : The password of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->option('name') ?? $this->ask('Name');

        if (empty($name)) {
            $this->error('Name cannot be empty');

            return;
        }

        $email = $this->option('email') ?? $this->ask('Email Address');

        if (empty($email)) {
            $this->error('Email address cannot be empty');

            return;
        }

        $password = $this->option('password') ?? $this->secret('Password');

        if (empty($password)) {
            $this->error('Password cannot be empty');

            return;
        }

        User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $this->info('User created successfully');
    }
}
