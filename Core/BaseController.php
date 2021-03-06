<?php

namespace Core;

class BaseController implements ControllerInterface
{
    protected $template = "base.html.twig";

    protected $templateEngine = null;

    protected $session = null;

    protected $tplArguments = array();

    public function __construct()
    {
        $this->session = new UserSession();
    }

    public function getSession()
    {
        return $this->session;
    }

    public function setTemplateEngine($engine)
    {
        $this->templateEngine = $engine;

        return $this;
    }

    public function getTemplateArgs()
    {
        return $this->tplArguments;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function getTemplateEngine()
    {
        return $this->templateEngine;
    }

    public function render()
    {
        $this->tplArguments['user'] = $this->getSession()->getUser();

        $coursesList = new CoursesList();
        $coursesList->loadAll();
        $this->tplArguments['allCourses'] = $coursesList;
    }

    public function redirect($location)
    {
        header("Location: " . $location);
    }
}
