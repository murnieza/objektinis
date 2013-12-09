<?php

namespace Tests\Functional;

use Core\BaseModel;
use Core\MysqlAdapter;

class BaseModelTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDbAdapter()
    {
        $model = new BaseModel();

        $this->assertSame(
            MysqlAdapter::getInstance(),
            $model->getDbAdapter()
        );
    }

    public function testIsLoaded()
    {
        $model = new BaseModel();

        $this->assertFalse($model->isLoaded());
        $model->setLoaded(true);
        $this->assertTrue($model->isLoaded());
    }
}
