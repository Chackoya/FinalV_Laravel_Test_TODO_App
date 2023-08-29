<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Task;


/*
Unit tests file.

>> usage of SQLIT in memory (check phpunit.xml file) to create and store data for each test (it resets everytime). 
>> usage of factories blueprints for the tasks (e.g. for update method , gets etc);


Implemented tests:

1 - test1_fetch_all_tasks() : to check if we can fetch (GET method) the list of tasks (all of them);
2 - test2_create_a_task() : check POST method to create a task;
3 - test3_create_task_with_invalid_data(): check POST method to create task but with empty data;
4 - test4_fetch_a_task() : GET task by id test;
5 - test5_update_a_task(): PUT method test;
6 - test6_delete_a_task(): DELETE Method test;
7 - test7_title_exceed_255_characters(): Test validation input for the title when we have more than 255 chars (test if an error happens when we enter a long text as title);

*/
class TaskApiTest extends TestCase
{
    use RefreshDatabase;  //refresh(reset) DB after each test


    
    /** @test */
    public function test1_fetch_all_tasks()
    {
        $tasksTmp = Task::factory()->count(3)->create();
        // Dump the original task data to the console to check; (its created randomly)
        //dump("Generated data:" );
        //dump($tasksTmp->toArray());
        $response = $this->getJson('/api/tasks'); // Assuming tasks is the endpoint
        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    /** @test */
    public function test2_create_a_task()
    {
        $taskData = ['title' => 'Dummy TODO task', 'status' => 'pending'];
        $response = $this->postJson('/api/tasks', $taskData);
        $response->assertStatus(201)
            ->assertJsonFragment($taskData);
    }

    /** @test */
    public function test3_create_task_with_invalid_data()
    {
        $response = $this->postJson('/api/tasks', []);
        $response->assertStatus(400);  // expecting a validation error
    }

    /** @test */
    public function test4_fetch_a_task()
    {
        $task = Task::factory()->create();

        $response = $this->getJson("/api/tasks/{$task->id}");
        $response->assertStatus(200)
            ->assertJsonFragment(['title' => $task->title, 'status' => $task->status]);
    }

    /** @test */
    public function test5_update_a_task()
    {
        $task = Task::factory()->create();

        // Dump the original task data to the console to check; (its created randomly)
        dump("Generated data:" );
        dump($task->toArray());

        //update its fields
        $updatedData = ['title' => 'Updated Task', 'status' => 'completed'];
        $response = $this->putJson("/api/tasks/{$task->id}", $updatedData);



        // display the response data to the console
        dump("After update:" );
        dump($response->json());

        $response->assertStatus(200)
            ->assertJsonFragment($updatedData);
    }


    /** @test */
    public function test6_delete_a_task()
    {
        $task = Task::factory()->create();

        
        $response = $this->deleteJson("/api/tasks/{$task->id}");
        $response->assertStatus(204);  // No content
    }

    /** @test */
    public function test7_title_exceed_255_characters()
    {


        // if we put for example 300 (more than 255), we get an error, which is what we 're expecting (test passes). 
        // if we put 100(for example) , the test fails, the point is to test if it raises a validation error;
        $longTitle = str_repeat('a', 300); // Generates a string of 256 "a" characters


        $response = $this->postJson('/api/tasks', ['title' => $longTitle, 'status' => 'pending']);
        $response->assertStatus(400);  // Expecting an error;


    }

}
