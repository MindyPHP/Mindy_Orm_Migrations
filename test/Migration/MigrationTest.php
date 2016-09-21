<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 08/01/15 14:31
 */

namespace Tests\Cases\Migration;

use Mindy\Base\Mindy;
use Mindy\Migration\Migration;
use Mindy\Tests\Orm\OrmDatabaseTestCase;

class MigrationTest extends OrmDatabaseTestCase
{
    /**
     * @var Migration
     */
    public $m;

    public function setUp()
    {
        $this->markTestSkipped('TODO');
    }

    public function testNameGeneration()
    {
        $this->assertEquals('Test_' . time() . '.json', $this->m->generateName());
    }

    public function testGetExportFields()
    {
        $this->assertTrue(is_array($this->m->getFields()));
        $this->assertTrue(is_string($this->m->exportFields()));
    }

    public function testHasChanges()
    {
        $this->assertEquals(0, count($this->m->getMigrations()));

        $this->assertTrue($this->m->hasChanges());
        $this->assertTrue($this->m->save());

        $this->assertEquals(1, count($this->m->getMigrations()));

        $this->assertFalse($this->m->hasChanges());

        $this->m = new Migration(new TestChanged, $this->migrationPath);
        $this->m->setName('Test');

        $this->assertTrue($this->m->hasChanges());
        sleep(1);
        $this->assertTrue($this->m->save());

        $this->assertEquals(2, count($this->m->getMigrations()));
    }

    public function testSave()
    {
        // No migrations yet
        $this->assertTrue($this->m->save());
        // Has one migration and no changes in model
        $this->assertFalse($this->m->save());
    }
}