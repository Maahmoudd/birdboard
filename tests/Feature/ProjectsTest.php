<?php

namespace Tests\Feature;

use Database\Factories\ProjectFactory;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_a_user_can_create_a_project(): void
    {
        $this->withoutExceptionHandling();

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];

        $this->post('/projects', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }

    public function test_a_user_can_view_a_project()
    {
        $project = Project::factory()->create(); // Using the updated factory syntax

        $this->get('/projects/' . $project->id)
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    public function test_a_project_requires_a_title()
    {
        $factory = new ProjectFactory();
        $attributes = $factory->raw(['title' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }
    public function test_a_project_requires_a_description()
    {
        $factory = new ProjectFactory();
        $attributes = $factory->raw(['description' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}
