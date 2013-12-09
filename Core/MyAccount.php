<?php

namespace Core;

class MyAccount extends BaseController
{
    protected $template = "myAccount.html.twig";

    public function render()
    {
        $user = $this->getSession()->getUser();
        if ($user) {
            $this->tplArguments['myCourses'] = $this->getSession()->getUser()->getMyCourses();
        }
        return parent::render();
    }

    /**
     * @codeCoverageIgnore  Method is written in non testable way
     */
    public function saveCourse()
    {
        $courseId = isset($_POST['id']) ? $_POST['id'] : null;
        if (isset($courseId)) {
            $course = new Course();
            $course->load($courseId);
            if ($course->isLoaded()) {
                $course->modify(
                    $course->getId(),
                    $_POST['title'],
                    $_POST['description'],
                    $_POST['date'],
                    $_POST['price'],
                    $_POST['freeSlots'],
                    $_POST['totalSlots']
                );
            }
        }
    }

    /**
     * @codeCoverageIgnore  Method is written in non testable way
     */
    public function createCourse()
    {
        $course = new Course();
        $course->create(
            $_POST['title'],
            $_POST['description'],
            $_POST['date'],
            $_POST['price'],
            $_POST['freeSlots'],
            $_POST['totalSlots']
        );
    }
}
