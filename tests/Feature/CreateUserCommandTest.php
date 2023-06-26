<?php

namespace Tests\Feature;

use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CreateUserCommandTest extends TestCase
{
    use RefreshDatabase;

    public function teste_create_user_correctly(): void
    {
        $this->seed(RoleSeeder::class);

        $this->artisan('users:create')
            ->expectsQuestion('Name of the new user', 'John')
            ->expectsQuestion('Email of the new user', 'john@example.com')
            ->expectsQuestion('Password of the new user', 'P@ssw0rd')
            ->expectsChoice('Role of the new user', 'admin', ['admin', 'editor'])
            ->assertExitCode(0);
    }

    public function teste_create_user_returns_validation_error(): void
    {
        $this->seed(RoleSeeder::class);

        $this->artisan('users:create')
            ->expectsQuestion('Name of the new user', '')
            ->expectsQuestion('Email of the new user', 'john@example.com')
            ->expectsQuestion('Password of the new user', 'P@ssw0rd')
            ->expectsChoice('Role of the new user', 'admin', ['admin', 'editor'])
            ->expectsOutput('The name field is required.')
            ->assertExitCode(-1);

        $this->artisan('users:create')
            ->expectsQuestion('Name of the new user', 'john')
            ->expectsQuestion('Email of the new user', '')
            ->expectsQuestion('Password of the new user', 'P@ssw0rd')
            ->expectsChoice('Role of the new user', 'admin', ['admin', 'editor'])
            ->expectsOutput('The email field is required.')
            ->assertExitCode(-1);

        $this->artisan('users:create')
            ->expectsQuestion('Name of the new user', 'John')
            ->expectsQuestion('Email of the new user', 'john@example.com')
            ->expectsQuestion('Password of the new user', '')
            ->expectsChoice('Role of the new user', 'admin', ['admin', 'editor'])
            ->expectsOutput('The password field is required.')
            ->assertExitCode(-1);

        $this->artisan('users:create')
            ->expectsQuestion('Name of the new user', 'John')
            ->expectsQuestion('Email of the new user', 'john@example.com')
            ->expectsQuestion('Password of the new user', 'pass')
            ->expectsChoice('Role of the new user', 'admin', ['admin', 'editor'])
            ->expectsOutput('The password field must be at least 8 characters.')
            ->assertExitCode(-1);

        $this->artisan('users:create')
            ->expectsQuestion('Name of the new user', 'John')
            ->expectsQuestion('Email of the new user', 'john@example.com')
            ->expectsQuestion('Password of the new user', 'P@ssw0rd')
            ->expectsChoice('Role of the new user', 'user', ['admin', 'editor'])
            ->expectsOutput('Role not found.')
            ->assertExitCode(-1);
    }
}
