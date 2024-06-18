<?php 

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    /**
     * Given I have a task
     * When I get all tasks
     * Then I should get a successful response
     */
    public function testGetAllTasks(): void
    {
        $client = static::createClient();

        $client->request('GET', '/tasks');

        $this->assertResponseIsSuccessful();
    }

    /**
     * Given I have a task
     * When I create a task
     * Then I should get a successful response
     */
    public function testCreateTask(): void
    {
        $client = static::createClient();

        $client->request('POST', '/tasks', [], [], [], json_encode([
            'title' => 'New Task',
            'description' => 'Description of the task',
            'status' => 'PENDING',
            'createdAt' => '2021-10-10T10:00:00+00:00',
        ]));

        $this->assertResponseIsSuccessful();
    }

    /**
     * Given I have a task
     * When I update a task
     * Then I should get a successful response
     */
    public function testUpdateTask(): void
    {
        $client = static::createClient();

        $client->request('PUT', '/tasks/1', [], [], [], json_encode([
            'title' => 'Updated Task',
            'description' => 'Updated description of the task',
            'status' => 'IN_PROGRESS',
            'createdAt' => '2021-10-10T10:00:00+00:00',
        ]));

        $this->assertResponseIsSuccessful();
    }

    /**
     * Given I have a task
     * When I delete a task
     * Then I should get a successful response
     */
    public function testDeleteTask(): void
    {
        $client = static::createClient();

        $client->request('DELETE', '/tasks/1');

        $this->assertResponseIsSuccessful();
    }
}