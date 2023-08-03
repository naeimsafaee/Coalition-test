<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskControllerTest extends TestCase {
    use RefreshDatabase;
    use WithFaker;

    /**
     * Test the index method.
     */
    public function testIndex() {
        Project::factory(10)->create();
        Task::factory(10)->create();

        $response = $this->get(route('task.index'));

        $response->assertStatus(200);

        $response->assertJsonCount(10, 'data');
    }

    /**
     * Test the store method.
     */
    public function testStore() {

        Project::factory(10)->create();

        $name = $this->faker->word;
        $project = Project::all()->random()->first();
        $priority = rand(1, 100);

        $data = [
            'name' => $name,
            'project_id' => $project->id,
            'priority' => $priority,
        ];

        $response = $this->post(route('task.store'), $data , ['Accept' => 'application/json']);

        $response->assertStatus(201);

    }

}
