<?php

namespace Tests\Feature;

use App\Mail\Invitation;
use App\Models\User;
use App\Mail\OrderShipped;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_be_able_to_register_as_a_new_user()
    {
        // arrange
        // act
        $response = $this->post(route('register'), [
            'name' => 'Leonardo Lopes',
            'email' => 'leonardolivelopes2@gmail.com',
            'email_confirmation' => 'leonardolivelopes2@gmail.com',
            'password' => 'Asdfsdf'
        ]);

        // assert
        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('users', [
            'name' => 'Leonardo Lopes',
            'email' => 'leonardolivelopes2@gmail.com',
        ]);

        /** @var User $user */
        $user = User::whereEmail('leonardolivelopes2@gmail.com')->firstOrFail();
        $this->assertTrue(
            Hash::check('Asdfsdf', $user->password),
            'Checking if password was saved and it is encrypted'
        );
    }

    /** @test */
    public function name_should_be_required()
    {
        $this->post(route('register'), [])
            ->assertSessionHasErrors([
                'name' => __('validation.required', ['attribute' => 'name'])
            ]);
    }

    /** @test */
    public function name_should_have_a_max_of_255_characters()
    {
        $this->post(route('register'), [
            'name' => str_repeat('a', 256)
        ])
            ->assertSessionHasErrors([
                'name' => __('validation.max.string', ['attribute' => 'name', 'max' => 255])
            ]);
    }

    /** @test */
    public function email_should_be_required()
    {
        $this->post(route('register'), [])
            ->assertSessionHasErrors([
                'email' => __('validation.required', ['attribute' => 'email'])
            ]);
    }

    /** @test */
    public function email_should_be_valid_email()
    {
        $this->post(route('register'), [
            'email' => 'invalid-email'
        ])
            ->assertSessionHasErrors([
                'email' => __('validation.email', ['attribute' => 'email'])
            ]);
    }

    /** @test */
    public function email_should_be_unique()
    {
        User::factory()->create(['email' => 'leonardolivelopes2@gmail.com']);
        $this->post(route('register'), [
            'email' => 'leonardolivelopes2@gmail.com'
        ])
            ->assertSessionHasErrors([
                'email' => __('validation.unique', ['attribute' => 'email'])
            ]);
    }

    /** @test */
    public function email_should_be_confirmed()
    {
        User::factory()->create(['email' => 'leonardolivelopes2@gmail.com']);
        $this->post(route('register'), [
            'email' => 'leonardolivelopes2@gmail.com',
            'email_confirmation' => ''
        ])
            ->assertSessionHasErrors([
                'email' => __('validation.confirmed', ['attribute' => 'email'])
            ]);
    }

    /** @test */
    public function password_should_be_required()
    {
        $this->post(route('register'), [])
            ->assertSessionHasErrors([
                'password' => __('validation.required', ['attribute' => 'password'])
            ]);
    }

    /** @test */
    public function password_should_at_least_1_uppercase()
    {
        $response = $this->post(route('register'), [
            'password' => 'without-uppercase'
        ])
            ->assertSessionHasErrors([
                'password' => 'The password field must contain at least one uppercase and one lowercase letter.'
            ]);
    }
}
