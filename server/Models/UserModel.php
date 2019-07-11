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

    /*public function postUserInfo()
    {
        $sqlEmailCheck = "SELECT id FROM users_booker WHERE email=?;";
        $parEmailCheck = array($_REQUEST['email']);
        $sqlEmailCheckResult = $this->sql->makeQuery($sqlEmailCheck, $parEmailCheck);
        //var_dump($sqlEmailCheckResult);
        if($sqlEmailCheckResult) {            
            //if($resultEmailCheck){
                return $resultEmailCheck = $this->view->view('There is the same email. Please, change it!');
            /*}else{
                return 'Something went wrong. Please, try again!';
            } */
       /* }elseif(!$sqlEmailCheckResult){
            $sql = "INSERT INTO users_booker (name, email, password, role, status, email_to) VALUES(?,?,?,?,?,?);";
            $par = array($_REQUEST['name'], $_REQUEST['email'], $_REQUEST['password'], 'user', true, 'mailto:'.$_REQUEST['email']);
            $sqlResult = $this->sql->makeQuery($sql, $par);
            $result = $this->view->view($sqlResult);
            if($result){
                return $result;
            }else{
                return 'Something went wrong. Please, try again!';
            }        
        }
    }*/

    public function postUser()
    {
        $arr = json_decode(file_get_contents('php://input'), true);
        $sql = "SELECT id, name, role, status FROM users_booker WHERE email=? AND password=?;";
        $par = array($arr['email'],$arr['password']);
        //print_r(json_decode(file_get_contents('php://input'), true));
        //print_r($_REQUEST);
        
        $sqlResult = $this->sql->makeQuery($sql, $par);
        $result = $this->view->view($sqlResult);
        if($result){
            return $result;
        }else{
            return 'Something went wrong. Please, try again!';
        }
    }

    
}