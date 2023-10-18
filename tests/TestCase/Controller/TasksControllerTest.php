<?php

namespace App\Test\TestCase\Controller;

use App\Controller\TasksController;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\TasksController Test Case
 *
 * @uses \App\Controller\TasksController
 */
class TasksControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Tasks',
        'app.Statuses',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->baseUrl = '/api/tasks';
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->baseUrl);
        parent::tearDown();
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndexShouldSuccess()
    {
        $this->get($this->baseUrl);
        $this->assertResponseCode(200);
    }

    /**
     * Test add method should success
     *
     * @return void
     */
    public function testAddTaskShouldSuccess()
    {
        $data = [
            'description' => 'New Task'
        ];
        $this->post($this->baseUrl, $data);
        $this->assertResponseCode(201);
        $this->assertResponseContains('The task has been created.');
        $tasks = TableRegistry::getTableLocator()->get('Tasks');
        $task = $tasks->find()->where(['description' => $data['description']]);
        $this->assertEquals(1, $task->count());
    }

    /**
     * Test add method with Empty description should fail
     *
     * @return void
     */
    public function testAddTaskWithEmptyDescriptionShouldFail()
    {
        $data = [
            'description' => ''
        ];
        $this->post($this->baseUrl, $data);
        $this->assertResponseCode(422);
        $this->assertResponseContains('The task could not be created. Please, try again.');
        $tasks = TableRegistry::getTableLocator()->get('Tasks');
        $task = $tasks->find()->where(['description' => $data['description']]);
        $this->assertEquals(0, $task->count());
    }

    /**
     * Test edit method should success
     *
     * @return void
     */
    public function testEditTaskShouldSuccess()
    {
        $data = [
            'description' => 'New Task'
        ];
        $this->post($this->baseUrl, $data);
        $tasks = TableRegistry::getTableLocator()->get('Tasks');
        $task = $tasks->find()->order(['created' => 'DESC'])->first();
        $this->assertNotNull($task);
        $updateData = [
            'description' => 'Update a Task Description'
        ];
        $taskId = $task->id;
        $this->put("{$this->baseUrl}/{$taskId}", $updateData);
        $this->assertResponseCode(200);
        $this->assertResponseContains('The task has been updated.');
        $updatedTask = $tasks->get($taskId);
        $this->assertEquals($updateData['description'], $updatedTask->description);
    }

    /**
     * Test edit method with empty description should fail
     *
     * @return void
     */
    public function testEditTaskWithEmptyDescriptionShouldFail()
    {
        $data = [
            'description' => 'New task'
        ];
        $this->post($this->baseUrl, $data);
        $tasks = TableRegistry::getTableLocator()->get('Tasks');
        $task = $tasks->find()->order(['created' => 'DESC'])->first();
        $this->assertNotNull($task);
        $updateData = [
            'description' => ''
        ];
        $taskId = $task->id;
        $this->put("{$this->baseUrl}/{$taskId}", $updateData);
        $this->assertResponseCode(422);
        $this->assertResponseContains('The task could not be updated. Please, try again.');
        $updatedTask = $tasks->get($taskId);
        $this->assertEquals($data['description'], $updatedTask->description);
    }

    /**
     * Test edit task with status complete method should fail
     *
     * @return void
     */
    public function testEditCompletedTaskShoulFail()
    {
        $updateData = [
            'description' => 'Editing completed task'
        ];
        $this->put("{$this->baseUrl}/2", $updateData);
        $this->assertResponseCode(422);
        $this->assertResponseContains('Completed Tasks cannot be edited.');

    }

    /**
     * Test edit non existing tasks id should fail
     *
     * @return void
     */
    public function testEditNonExistingTaskShouldFail()
    {
        $updateData = [
            'description' => ''
        ];
        $this->put("{$this->baseUrl}/848484", $updateData);
        $this->assertResponseCode(404);
    }

    /**
     * Test delete method should success
     *
     * @return void
     */
    public function testDeleteTaskShouldSuccess()
    {
        $this->delete("{$this->baseUrl}/1");
        $this->assertResponseCode(204);
    }

    /**
     * Test delete non existing task id should fail
     *
     * @return void
     */
    public function testDeleteNonExistentTaskShouldFail()
    {
        $this->delete("{$this->baseUrl}/78585845");
        $this->assertResponseCode(404);
    }

    /**
     * Test updateStatus method should success
     *
     * @return void
     */
    public function testUpdateStatusShouldSuccess()
    {
        $data = [
            'status_id' => 2
        ];
        $this->patch("{$this->baseUrl}/1/status", $data);
        $this->assertResponseCode(200);
        $this->assertResponseContains('The status has been updated.');
    }

    /**
     * Test updateStatus with non existing status id should fail
     *
     * @return void
     */
    public function testUpdateNonExistentStatusShouldFail()
    {
        $data = [
            'status_id' => 785455
        ];
        $this->patch("{$this->baseUrl}/1/status", $data);
        $this->assertResponseCode(422);
        $this->assertResponseContains('The status could not be updated. Please, try again.');
    }
}
