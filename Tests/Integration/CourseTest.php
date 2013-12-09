<?php

namespace Tests\Integration;

use Core\Course;
use Core\User;

class CourseTest extends \PHPUnit_Framework_TestCase
{
    protected function getCourseMock($methods = array())
    {
        $methods = array_merge(["getDbAdapter"], $methods);

        $mock = $this->getMock(
            "Core\\Course",
            $methods,
            [],
            "",
            false
        );

        return $mock;
    }

    protected function getDbAdapterMock($methods = array())
    {
        $mock = $this->getMock(
            "Core\\MysqlAdapter",
            $methods,
            [],
            "",
            false
        );

        return $mock;
    }

    protected function getUserMock($methods = array())
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

    public function testLoadExisting()
    {
        /** @var Course $course  */
        $course = $this->getCourseMock();

        $dbAdapter = $this->getDbAdapterMock();
        $dbAdapter
            ->expects($this->once())
            ->method("queryResults")
            ->with("SELECT * FROM `courses` WHERE id='?'", ["1"])
            ->will(
                $this->returnValue(
                    [
                        [
                            'id' => "1",
                            'date' => "today",
                            'freeSlots' => 5,
                            'totalSlots' => 6,
                            'price' => 100,
                            'title' => "some title",
                            'description' => "some description",
                        ],
                    ]
                )
            );

        $course
            ->expects($this->any())
            ->method("getDbAdapter")
            ->will($this->returnValue($dbAdapter));

        $this->assertTrue($course->load("1"));
        $this->assertTrue($course->isLoaded());

        $this->assertEquals("1", $course->getId());
        $this->assertEquals("today", $course->getDate());
        $this->assertEquals(5, $course->getFreeSlots());
        $this->assertEquals(6, $course->getTotalSlots());
        $this->assertEquals(100, $course->getPrice());
        $this->assertEquals("some title", $course->getTitle());
        $this->assertEquals("some description", $course->getDescription());
    }

    public function testLoadNotExisting()
    {
        /** @var Course $course  */
        $course = $this->getCourseMock();

        $dbAdapter = $this->getDbAdapterMock();
        $dbAdapter
            ->expects($this->once())
            ->method("queryResults")
            ->with($this->anything())
            ->will(
                $this->returnValue([])
            );

        $course
            ->expects($this->any())
            ->method("getDbAdapter")
            ->will($this->returnValue($dbAdapter));

        $this->assertFalse($course->load("1"));
        $this->assertFalse($course->isLoaded());
    }

    public function testGetAllIds()
    {
        $allIds = [1, 2];

        /** @var Course $course  */
        $course = $this->getCourseMock();

        $dbAdapter = $this->getDbAdapterMock();
        $dbAdapter
            ->expects($this->once())
            ->method("queryResults")
            ->with("SELECT id FROM `courses` ORDER BY `date`")
            ->will(
                $this->returnValue($allIds)
            );

        $course
            ->expects($this->any())
            ->method("getDbAdapter")
            ->will($this->returnValue($dbAdapter));


        $this->assertEquals(
            $allIds,
            $course->getAllIds()
        );
    }

    public function testGetIdsForUser()
    {
        $allIds = [1, 2];

        /** @var Course $course  */
        $course = $this->getCourseMock();

        $dbAdapter = $this->getDbAdapterMock();
        $dbAdapter
            ->expects($this->once())
            ->method("queryResults")
            ->with("SELECT courses_id FROM registrations WHERE users_id=?", [10])
            ->will(
                $this->returnValue($allIds)
            );

        $course
            ->expects($this->any())
            ->method("getDbAdapter")
            ->will($this->returnValue($dbAdapter));


        $this->assertEquals(
            $allIds,
            $course->getIdsForUser(10)
        );
    }

    public function testGetUsersIds()
    {
        $allIds = [1, 2];

        /** @var Course $course  */
        $course = $this->getCourseMock(["getId"]);

        $dbAdapter = $this->getDbAdapterMock();
        $dbAdapter
            ->expects($this->once())
            ->method("queryResults")
            ->with("SELECT users_id FROM registrations WHERE courses_id=?", [10])
            ->will(
                $this->returnValue($allIds)
            );

        $course
            ->expects($this->any())
            ->method("getDbAdapter")
            ->will($this->returnValue($dbAdapter));
        $course
            ->expects($this->any())
            ->method("getId")
            ->will($this->returnValue(10));


        $this->assertEquals(
            $allIds,
            $course->getUsersIds()
        );
    }

    public function testGetLink()
    {
        /** @var Course $course  */
        $course = $this->getCourseMock(["getId"]);

        $course
            ->expects($this->any())
            ->method("getId")
            ->will($this->returnValue(10));

        $this->assertEquals(
            "?cl=CourseDetails&id=10",
            $course->getLink()
        );

    }

    public function testModify()
    {
        $expectedQuery = "
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

        /** @var Course $course  */
        $course = $this->getCourseMock(["getId"]);

        $dbAdapter = $this->getDbAdapterMock(["makeQuery"]);
        $dbAdapter
            ->expects($this->once())
            ->method("makeQuery")
            ->with($expectedQuery, [null, null, null, null, null, null, null]);

        $course
            ->expects($this->any())
            ->method("getDbAdapter")
            ->will($this->returnValue($dbAdapter));

        $course->modify(null, null, null, null, null, null, null);
    }

    public function testCreate()
    {
        $expectedQuery = "
            INSERT INTO `courses`
            SET
                `title`='?',
                `description`='?',
                `date`='?',
                `price`=?,
                `freeSlots`=?,
                `totalSlots`=?
        ";

        /** @var Course $course  */
        $course = $this->getCourseMock(["getId", "getFreeSlots"]);

        $dbAdapter = $this->getDbAdapterMock(["makeQuery"]);
        $dbAdapter
            ->expects($this->once())
            ->method("makeQuery")
            ->with($expectedQuery, [null, null, null, null, null, null]);

        $course
            ->expects($this->any())
            ->method("getDbAdapter")
            ->will($this->returnValue($dbAdapter));

        $course->create(null, null, null, null, null, null);
    }

    public function testAddUser()
    {
        $query1 = "
            INSERT INTO `registrations`
            SET
                `users_id`='?',
                `courses_id`='?'
            ";
        $query2 = "UPDATE
                    `courses`
                SET
                    `freeSlots`=`freeslots`-1
                WHERE id=?";

        /** @var $user User */
        $user = $this->getUserMock(["getId", "getLoginStatus"]);
        $user
            ->expects($this->any())
            ->method("getId")
            ->will($this->returnValue("userId"));
        $user
            ->expects($this->once())
            ->method("getLoginStatus")
            ->will($this->returnValue(true));

        /** @var Course $course  */
        $course = $this->getCourseMock(["getId", "getFreeSlots"]);

        $dbAdapter = $this->getDbAdapterMock(["makeQuery"]);
        $dbAdapter
            ->expects($this->at(0))
            ->method("makeQuery")
            ->with($query1, [$user->getId(), "courseId"]);
        $dbAdapter
            ->expects($this->at(1))
            ->method("makeQuery")
            ->with($query2, ["courseId"]);

        $course
            ->expects($this->any())
            ->method("getDbAdapter")
            ->will($this->returnValue($dbAdapter));
        $course
            ->expects($this->any())
            ->method("getId")
            ->will($this->returnValue("courseId"));
        $course
            ->expects($this->any())
            ->method("getFreeSlots")
            ->will($this->returnValue(10));

        $course->addUser($user);
    }

    public function testGetRegisteredUsers()
    {
        $course = new Course();
        $course->load(1);
        $ids = [];
        /** @var User $user */
        foreach ($course->getRegisteredUsers() as $user) {
            $ids[] = $user->getId();
        }

        sort($ids);
        $this->assertEquals(
            ["2", "16", "18"],
            $ids
        );
    }
}
