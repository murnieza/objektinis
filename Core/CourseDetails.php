<?php

namespace Core;

class CourseDetails extends BaseController
{
    protected $template = "courseDetails.html.twig";

    public function render()
    {
        $course = new Course();
        if (isset($_GET['id'])) {
            $course->load(($_GET['id']));
        }
        $this->tplArguments['course'] = $course;
        $this->tplArguments['registeredUsers'] = $course->getRegisteredUsers();
        parent::render();
    }

    public function addUser()
    {
        /** @var $user User */
        $user = $this->getSession()->getUser();
        if ($user->getLoginStatus()) {
            $course = new Course();
            $course->load($_GET['id']);

            $course->addUser($user);
        }
    }
}
