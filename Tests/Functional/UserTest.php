<?php

namespace Tests\Functional;

use Core\Course;
use Core\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function getTestSetGetData()
    {
        return [
            ["id"],
            ["username"],
            ["admin"],
        ];
    }

    /**
     * @dataProvider    getTestSetGetData()
     */
    public function testSetGet($fieldName)
    {
        $setMethodName = "set" . ucfirst($fieldName);
        $getMethodName = "get" . ucfirst($fieldName);

        $user = new User();

        $user->{$setMethodName}("someValue");

        $this->assertEquals(
            "someValue",
            $user->{$getMethodName}()
        );
    }

    public function testLogin()
    {
        $user = new User();
        $this->assertFalse($user->logIn("foo", "bar"));
        $this->assertTrue($user->logIn("admin", "admin"));
    }
}
