<?php

namespace Core;

class Renderer
{
    protected $engine;

    public function __construct($engine)
    {
        $this->engine = $engine;
    }

    public function render(BaseController $controller)
    {
        return $this->engine->render(
            $controller->getTemplate(),
            $controller->getTemplateArgs()
        );
    }
}
