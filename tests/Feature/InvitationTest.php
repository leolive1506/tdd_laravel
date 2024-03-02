<?php

namespace Tests\Feature;

use App\Mail\Invitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_should_be_able_to_invite_someone_to_the_platform()
    {
        // arrange
            Mail::fake();
            // preciso um usuário vá convidar

            /** @var User $user */
            $user = User::factory()->create();

            // preciso estar logado
            $this->actingAs($user);
        // act
        $this->post('invite', ['email' => 'novo@gmail.com']);

        // assert
            // email foi criado
            Mail::assertSent(Invitation::class, function ($mail) {
                return $mail->hasTo('novo@gmail.com');
            });
            // criou convite no banco de dados
            $this->assertDatabaseHas('invites', ['email' => 'novo@gmail.com']);
    }
}
