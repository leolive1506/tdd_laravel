<?php

namespace Tests\Feature\Todo;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

    /** @test */
    public function it_should_be_able_add_a_file_to_the_todo_item()
    {
        Storage::fake('s3');

        $user = User::factory()->createOne();
        $this->actingAs($user);

        $response = $this->post(route('todo.store'), [
            'title' => 'Todo Item',
            'description' => 'Todo Item description',
            'assigned_to' => $user->id,
            'file' => UploadedFile::fake()->image('image1.png') // fake file
        ]);

        Storage::disk('s3')->assertExists('todo/image1.png');
        $this->assertDatabaseHas('todos', [
            'file' => 'todo/image1.png',
        ]);
    }


}
