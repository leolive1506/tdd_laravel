<?php

namespace Tests\Feature\Todo;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    /** @test */
    public function it_should_be_able_to_update_a_todo(): void
    {
        /** @var User $user */
        $user = User::factory()->createOne();
        $todo = Todo::factory()->createOne();

        $this->actingAs($user);

        $response = $this->putJson(route('todo.update', $todo), [
            'title' => 'Updated todo',
            'description' => 'Updated todo description',
            'assigned_to' => $user->id,
        ]);

        $response->assertRedirect(route('todo.index'));

        $todo->refresh();

        $this->assertEquals('Updated todo', $todo->title);
        $this->assertEquals('Updated todo description', $todo->description);
    }
}
