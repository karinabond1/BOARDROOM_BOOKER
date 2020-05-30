<?php

include_once('../../libs/Sql.php');
include_once('../../Views/View.php');

class UserModel{

    private $sql;
    private $view;

    public function __construct()
    {
        $this->sql = new Sql();
        $this->view = new View();
    }

    public function putUser()
    {
        $arr = Array();
        if(count($_REQUEST)==0){
            $arr = json_decode(file_get_contents('php://input'), true);
        }else{
            $arr = $_REQUEST;
        }
        $sql = "SELECT id, name, role_id, status FROM users_booker WHERE email=? AND password=?;";
        $par = array($arr['email'],$arr['password']);        
        $sqlResult = $this->sql->makeQuery($sql, $par);
        if($sqlResult){
            return $this->view->view($sqlResult);
        }else{
            return $this->view->view('Something went wrong. Please, try again!');
        }
    }

    public function getRole($id)
    {
        $sql = "SELECT role FROM roles_booker WHERE id=?;";
        $par = array((int)$id);
        $sqlResult = $this->sql->makeQuery($sql, $par);
        echo json_encode($sqlResult);
        if($sqlResult){
            return json_encode($sqlResult);
        }else{
            return $this->view->view('Something went wrong. Please, try again!');
        }
    }

    public function getUserInfo($par){
        if (stristr($par, '/')) {
            $arr = explode('/', $par);
        }else{
            $arr[0] = $par;
        }
        if($arr[0]!="" && count($arr)==1){
            $sql = "SELECT email FROM users_booker WHERE id=?;";
            $par = array($arr[0]);
            $sqlResult = $this->sql->makeQuery($sql, $par);
            if($sqlResult){
                return $this->view->view($sqlResult);
            }elseif(!$sqlResult){
                return  $this->view->view('There is no such events!');
            }else{
                return  $this->view->view('Something went wrong. Please, try again!');
            }
        }else{
            return $this->view->view('Something went wrong. Please, try again!!');
        }
    }   
}