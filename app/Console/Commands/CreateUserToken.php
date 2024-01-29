<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateUserToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:token
                {--email= : The email address of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->option('email') ?? $this->ask('Email Address');

        if (empty($email)) {
            $this->error('Email address cannot be empty');

            return;
        }

        $user = User::query()->where('email', $email)->first();

        if (! $user) {
            $this->error('User not found');

            return;
        }

        $token = $user->createToken('api')->plainTextToken;

        $this->info($token);
    }
}
