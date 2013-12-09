<?php

namespace Core;

class Course extends BaseModel
{
    protected $id;
    protected $date;
    protected $price;
    protected $freeSlots;
    protected $totalSlots;
    protected $title;
    protected $description;
    protected $registeredUsers = null;

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setTotalSlots($totalSlots)
    {
        $this->totalSlots = $totalSlots;
    }

    public function getTotalSlots()
    {
        return $this->totalSlots;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setFreeSlots($freeSlots)
    {
        $this->freeSlots = $freeSlots;
    }

    public function getFreeSlots()
    {
        return $this->freeSlots;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }


    public function load($id)
    {
        $sql = "SELECT * FROM `courses` WHERE id='?'";
        $result = $this->getDbAdapter()->queryResults($sql, array($id));
        if (is_array($result) && count($result) == 1) {
            $result = $result[0];
            $this->setId($result['id']);
            $this->setDate($result['date']);
            $this->setFreeSlots($result['freeSlots']);
            $this->setTotalSlots($result['totalSlots']);
            $this->setPrice($result['price']);
            $this->setTitle($result['title']);
            $this->setDescription($result['description']);
            $this->setLoaded(true);
            return true;
        }
        return false;
    }

    public function getAllIds()
    {
        $sql = "SELECT id FROM `courses` ORDER BY `date`";
        return $this->getDbAdapter()->queryResults($sql);
    }

    public function getIdsForUser($userId)
    {
        $sql = "SELECT courses_id FROM registrations WHERE users_id=?";
        return $this->getDbAdapter()->queryResults($sql, array($userId));
    }

    public function getUsersIds()
    {
        $sql = "SELECT users_id FROM registrations WHERE courses_id=?";
        return $this->getDbAdapter()->queryResults($sql, array($this->getId()));
    }

    public function getLink()
    {
        return "?cl=CourseDetails&id=" . $this->getId();
    }
    
    public function modify(
        $id,
        $title,
        $description,
        $date,
        $price,
        $freeSlots,
        $totalSlots
    ) {
        $sql = "
            UPDATE `courses`
            SET
                `title`='?',
                `description`='?',
                `date`='?',
                `price`=?,
                `freeSlots`=?,
                `totalSlots`=?
            WHERE `id`=?
        ";

        $this->getDbAdapter()->makeQuery(
            $sql,
            array(
                $title,
                $description,
                $date,
                $price,
                $freeSlots,
                $totalSlots,
                $id
            )
        );
    }

    public function create(
        $title,
        $description,
        $date,
        $price,
        $freeSlots,
        $totalSlots
    ) {
        $sql = "
            INSERT INTO `courses`
            SET
                `title`='?',
                `description`='?',
                `date`='?',
                `price`=?,
                `freeSlots`=?,
                `totalSlots`=?
        ";

        $this->getDbAdapter()->makeQuery(
            $sql,
            array(
                $title,
                $description,
                $date,
                $price,
                $freeSlots,
                $totalSlots
            )
        );
    }

    /**
     * @param $user User
     */
    public function addUser($user)
    {
        if ($user->getLoginStatus() && $this->getFreeSlots() > 0) {
            $sql = "
            INSERT INTO `registrations`
            SET
                `users_id`='?',
                `courses_id`='?'
            ";

            $this->getDbAdapter()->makeQuery(
                $sql,
                array(
                    $user->getId(),
                    $this->getId()
                )
            );

            $this->getDbAdapter()->makeQuery(
                "UPDATE
                    `courses`
                SET
                    `freeSlots`=`freeslots`-1
                WHERE id=?",
                array($this->getId())
            );
        }
    }

    public function getRegisteredUsers()
    {
        if ($this->registeredUsers === null) {
            $this->registeredUsers = new UsersList();
            $fakeUser = new User();
            foreach ($this->getUsersIds() as $userId) {
                $user = clone $fakeUser;
                $user->load($userId['users_id']);
                if ($user->isLoaded()) {
                    $this->registeredUsers->add($user);
                }
            }
        }
        return $this->registeredUsers;
    }
}
