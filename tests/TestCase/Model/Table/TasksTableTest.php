<?php

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TasksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TasksTable Test Case
 */
class TasksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TasksTable
     */
    public $Tasks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Tasks',
        'app.Statuses',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Tasks') ? [] : ['className' => TasksTable::class];
        $this->Tasks = TableRegistry::getTableLocator()->get('Tasks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tasks);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->assertInstanceOf(TasksTable::class, $this->Tasks);
        $this->assertEquals('tasks', $this->Tasks->getTable());
        $this->assertEquals('id', $this->Tasks->getPrimaryKey());
    }

    /**
     * Test Required description
     *
     * @return void
     */
    public function testRequiredDescription()
    {
        $task = $this->Tasks->newEntity([], ['validate' => 'description']);
        $this->assertFalse($this->Tasks->save($task));
        $errors = $task->getErrors();
        $this->assertArrayHasKey('description', $errors);
    }

    /**
     * Test Not Empty description
     *
     * @return void
     */
    public function testNotEmptyDescription()
    {
        $task = $this->Tasks->newEntity([
            'description' => ''
        ], ['validate' => 'description']);

        $this->assertFalse($this->Tasks->save($task));
        $errors = $task->getErrors();
        $this->assertArrayHasKey('description', $errors);
    }

    /**
     * Test Required description
     *
     * @return void
     */
    public function testRequiredStatus()
    {
        $task = $this->Tasks->newEntity([], ['validate' => 'status']);
        $this->assertFalse($this->Tasks->save($task));
        $errors = $task->getErrors();
        $this->assertArrayHasKey('status_id', $errors);
    }

    /**
     * Test Not Empty status_id
     *
     * @return void
     */
    public function testNotEmptyStatus()
    {
        $task = $this->Tasks->newEntity([
            'status_id' => ''
        ], ['validate' => 'status']);
        $this->assertFalse($this->Tasks->save($task));
        $errors = $task->getErrors();
        $this->assertArrayHasKey('status_id', $errors);
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $task = $this->Tasks->newEntity([
            'description' => 'Test Task',
            'status_id' => 123456789
        ]);
        $this->assertFalse($this->Tasks->save($task));
        $this->assertNotEmpty($task->getErrors()['status_id']);
    }
}
