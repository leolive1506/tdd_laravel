<?php

namespace Tests\Feature\Todo;

use App\Models\User;
use Tests\TestCase;

class CreateTest extends TestCase
{
    /** @test */
    public function it_should_be_able_to_create_a_todo_item()
    {
        // arrange
        /** @var User $user */
        $user = User::factory()->createOne();
        $assignedTo = User::factory()->createOne();

        $this->actingAs($user);

        // ACt
        $response = $this->post(route('todo.store'), [
            'title' => 'Todo Item',
            'description' => 'Todo Item description',
            'assigned_to' => $assignedTo->id
        ]);

        $response->assertRedirect(route('todo.index'));
        $this->assertDatabaseHas('todos', [
            'title' => 'Todo Item',
            'description' => 'Todo Item description',
            'assigned_to_id' => $assignedTo->id
        ]);
    }
}
