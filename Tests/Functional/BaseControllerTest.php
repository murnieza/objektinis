<?php

namespace Tests\Functional;

use Core\BaseController;

class BaseControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetSession()
    {
        $controller = new BaseController();

        $this->assertInstanceOf(
            "Core\\UserSession",
            $controller->getSession()
        );
    }

    public function testSetTemplateEngine()
    {
        $controller = new BaseController();

        $templateEngine = new \stdClass();
        $controller->setTemplateEngine($templateEngine);

        $this->assertSame(
            $templateEngine,
            $controller->getTemplateEngine()
        );
    }
}
