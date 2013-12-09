<?php

class CoursesList extends ObjectsList
{
    public function __construct()
    {
        parent::__construct(get_class());
    }

    public function loadAll()
    {
        $fakeCourse = new Course();
        $allCoursesIds = $fakeCourse->getAllIds();
        foreach($allCoursesIds as $id) {
            $course = clone $fakeCourse;
            $course->load($id['id']);
            $this->add($course);
        }
    }

    /**
     * @param $user User
     */
    public function loadForUser($user)
    {
        if ($user->getLoginStatus()) {

        }
    }
}