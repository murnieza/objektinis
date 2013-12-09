<?php

namespace Tests\Functional;

use Core\Course;
use Core\User;
use Core\UserSession;

class UserSessionTest extends \PHPUnit_Framework_TestCase
{
    public function testSetValue()
    {
        $userSession = new UserSession();
        $userSession->setVariable("any", "thing");

        $this->assertTrue(
            isset($_SESSION["any"])
        );
        $this->assertEquals(
            "thing",
            $_SESSION["any"]
        );
    }
}
