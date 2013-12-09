<?php

namespace Tests\Integration;

use Core\UserManagement;

class UserManagementTest extends \PHPUnit_Framework_TestCase
{
    public function testLoginFail()
    {
        $controller = $this->GetMock(
            "Core\\UserManagement",
            ["redirect"]
        );

        $controller
            ->expects($this->never())
            ->method("redirect");

        $controller->login();
    }

    public function testLoginOk()
    {
        $controller = $this->GetMock(
            "Core\\UserManagement",
            ["redirect"]
        );

        $_POST["username"] = "admin";
        $_POST["password"] = "admin";

        $controller
            ->expects($this->once())
            ->method("redirect");

        $controller->login();
    }
}
