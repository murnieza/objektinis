<?php

namespace Tests\Integration;

use Core\CoursesList;

class MyAccountTest extends \PHPUnit_Framework_TestCase
{
    protected function getMyAccountMock($methods = [])
    {
        $mock = $this->getMock(
            "Core\\MyAccount",
            $methods,
            [],
            "",
            false
        );

        return $mock;
    }

    protected function getSessionMock($methods = [])
    {
        $mock = $this->getMock(
            "Core\\UserSession",
            $methods,
            [],
            "",
            false
        );

        return $mock;
    }

    protected function getUserMock($methods = [])
    {
        $mock = $this->getMock(
            "Core\\User",
            $methods,
            [],
            "",
            false
        );

        return $mock;
    }

    public function testRender()
    {
        $allCourses = new CoursesList();
        $allCourses->loadAll();

        $accountController = $this->getMyAccountMock(["getSession", "getTemplateEngine"]);

        $session = $this->getSessionMock(["getUser"]);

        $user = $this->getUserMock(["getMyCourses"]);

        $templateEngine = $this->getMock(
            "\\stdClass",
            ["render"]
        );

        $templateEngine
            ->expects($this->once())
            ->method("render")
            ->with(
                "myAccount.html.twig",
                [
                    "myCourses" => [
                        "courseA",
                        "course",
                    ],
                    "user" => $user,
                    "allCourses" => $allCourses
                ]
            );


        $user
            ->expects($this->any())
            ->method("getMyCourses")
            ->will(
                $this->returnValue(
                    [
                        "courseA",
                        "course",
                    ]
                )
            );

        $session
            ->expects($this->any())
            ->method("getUser")
            ->will($this->returnValue($user));

        $accountController
            ->expects($this->any())
            ->method("getSession")
            ->will($this->returnValue($session));
        $accountController
            ->expects($this->any())
            ->method("getTemplateEngine")
            ->will($this->returnValue($templateEngine));

        $accountController->render();
    }
}
