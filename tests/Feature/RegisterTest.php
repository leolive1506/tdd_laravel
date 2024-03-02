<?php

namespace Tests\Feature;

use App\Mail\Invitation;
use App\Models\User;
use App\Mail\OrderShipped;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        // assert
    }


}
