<?php
include 'Model.php';
use PHPUnit\Framework\TestCase;
class UserModelTest extends TestCase {

    public function testGetUserInfo()
    {
        $modelObj = new UserModel();
        $modelObj->getUserInfo(1);
        $this->assertEquals(array(0=>array('email'=>'karina@gmail.com')), $modelObj->getUserInfo(1));
    }

    public function testGetUserById()
    {
        $modelObj = new UserModel();
        $modelObj->getUserById(1);
        $this->assertEquals(array(0=>array('id'=>'1','name'=>'Karina','email'=>'karina@gmail.com','password'=>'111','role'=>'admin','status'=>'1')), $modelObj->getUserById(1));
    }

    public function testGetRooms()
    {
        $modelObj = new UserModel();
        $modelObj->getRooms();
        $this->assertEquals(array(0=>array('id'=>'1','name'=>'Play room'),1=>array('id'=>'2','name'=>'Conference room'),2=>array('id'=>'3','name'=>'Meeting room')), $modelObj->getRooms());
    }
    
}