<?php

class User extends BaseModel
{
    const ERROR_OK = 0;
    const ERROR_UNKNOWN = 1;
    const ERROR_USER_EXISTS = 2;
    const ERROR_PASSWORDS_DO_NOT_MATCH = 3;
    const ERROR_EMPTY_FIELD = 4;

    private $logedIn = false;

    protected $id = null;
    protected $username = null;
    protected $admin = null;
    protected $myCourses = null;
    private $triedToRegister = false;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    private $registrationError = false;

    public function load($id)
    {
        $sql = "SELECT * FROM `users` WHERE id='?'";
        $result = $this->getDbAdapter()->queryResults($sql, array($id));
        if (is_array($result) && count($result) == 1) {
            $result = $result[0];
            $this->setId($result['id']);
            $this->setUsername($result['username']);
            $this->setAdmin($result['admin']);
            $this->setLoaded(true);
            return true;
        }
        return false;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }

    public function getAdmin()
    {
        return $this->admin;
    }

    public function loadByinput($username, $password)
    {
        $sql = "SELECT id FROM users WHERE username='?' AND password='?'";
        $id = $this->getDbAdapter()->queryResults($sql, array($username, $password));
        if(!empty($id)) {
            $this->load($id[0]['id']);
        }
        return $this->isLoaded();
    }

    public function logIn($userName, $password)
    {
        $this->loadByinput($userName, $password);
        return $this->isLoaded();
    }

    public function logOut()
    {
        $this->logedIn = false;
        session_destroy();
    }

    public function getLoginStatus()
    {
        return $this->isLoaded();
    }

    public function userExists($username)
    {
        $count = $this->getDbAdapter()->queryCount(
            "SELECT id FROM users WHERE username='?'",
            array($username)
        );

        return $count > 0;
    }

    public function create($username, $pass, $pass2)
    {
        $this->triedToRegister = true;
        $fakeUser = new User();

        if ($fakeUser->userExists($username)) {
            return $this::ERROR_USER_EXISTS;
        }
        if ($pass !== $pass2) {
            return $this::ERROR_PASSWORDS_DO_NOT_MATCH;
        }

        $sql = "INSERT INTO users SET `username`='?', `password`='?'";
        $result = $this->getDbAdapter()->makeQuery($sql, array($username, $pass));

        if ($result) {
            $this->registrationError = $this::ERROR_OK;
        } else {
            $this->registrationError = $this::ERROR_UNKNOWN;
        }

        return $this->registrationError;
    }

    public function isAdmin()
    {
        return $this->admin;
    }

    public function getMyCourses()
    {
        if ($this->myCourses === null) {
            $fakeCourse = new Course();

            $this->myCourses = new CoursesList();
            $allIds = $fakeCourse->getIdsForUser($this->getId());
            foreach($allIds as $id) {
                $id = $id['courses_id'];
                $course = clone $fakeCourse;
                $course->load($id);
                if ($course->isLoaded()) {
                    $this->myCourses->add($course);
                }
            }
        }
        return $this->myCourses;
    }

    public function isRegisteredOnCourse($courseId)
    {
        $sql = "SELECT id FROM registrations WHERE courses_id=? AND users_id=?";
        return $this->getDbAdapter()->queryCount($sql, array($courseId, $this->getId()));
    }
}