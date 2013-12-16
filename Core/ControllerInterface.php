<?php

namespace Core;

interface ControllerInterface
{
    public function render();
    public function getTemplate();
    public function getTemplateArgs();
}
