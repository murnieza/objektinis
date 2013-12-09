<?php

namespace Tests\Functional;

use Core\Course;
use Core\ObjectsList;

class ObjectsListTEst extends \PHPUnit_Framework_TestCase
{
    public function testIterableBehavior()
    {
        $list = new ObjectsList("testModel");

        $this->assertFalse($list->current());

        $list->add(1);
        $list->add(2);
        $list->add(3);

        foreach ($list as $key => $value) {
            $this->assertEquals($key+1, $value);
        }
    }
}
