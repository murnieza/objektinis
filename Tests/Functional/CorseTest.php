<?php

namespace Tests\Functional;

use Core\Course;

class CourseTest extends \PHPUnit_Framework_TestCase
{
    public function getTestSetGetData()
    {
        return [
            ["date"],
            ["totalSlots"],
            ["price"],
            ["id"],
            ["title"],
            ["freeSlots"],
            ["description"],
        ];
    }

    /**
     * @dataProvider    getTestSetGetData()
     */
    public function testSetGet($fieldName)
    {
        $setMethodName = "set" . ucfirst($fieldName);
        $getMethodName = "get" . ucfirst($fieldName);

        $course = new Course();

        $course->{$setMethodName}("someValue");

        $this->assertEquals(
            "someValue",
            $course->{$getMethodName}()
        );
    }
}
