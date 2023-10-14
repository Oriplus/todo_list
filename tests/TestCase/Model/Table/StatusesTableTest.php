<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StatusesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StatusesTable Test Case
 */
class StatusesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\StatusesTable
     */
    public $Statuses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Statuses',
        'app.Tasks',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Statuses') ? [] : ['className' => StatusesTable::class];
        $this->Statuses = TableRegistry::getTableLocator()->get('Statuses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Statuses);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->assertInstanceOf(StatusesTable::class, $this->Statuses);
        $this->assertEquals('statuses', $this->Statuses->getTable());
        $this->assertEquals('id', $this->Statuses->getPrimaryKey());
    }

     /**
     * Test Required status
     *
     * @return void
     */
    public function testRequiredStatus()
    {
        $status = $this->Statuses->newEntity([]);

        $errors = $status->getErrors();
        $this->assertArrayHasKey('name', $errors);
        $this->assertArrayHasKey('_required', $errors['name']);
    }

    /**
     * Test Not Empty status
     *
     * @return void
     */
    public function testNotEmptyStatus()
    {
        $status = $this->Statuses->newEntity([
            'name' => '',
        ]);

        $errors = $status->getErrors();
        $this->assertArrayHasKey('name', $errors);
        $this->assertArrayHasKey('_empty', $errors['name']);
    }
}
