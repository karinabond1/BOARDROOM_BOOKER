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

    public function putUser()
    {
        $arr = Array();
        if(count($_REQUEST)==0){
            $arr = json_decode(file_get_contents('php://input'), true);
        }else{
            $arr = $_REQUEST;
        }
        //var_dump($_REQUEST);
        $sql = "SELECT id, name, role, status FROM users_booker WHERE email=? AND password=?;";
        $par = array($arr['email'],$arr['password']);
        //print_r(json_decode(file_get_contents('php://input'), true));
        //print_r($_REQUEST);
        
        $sqlResult = $this->sql->makeQuery($sql, $par);
        //$result = $this->view->view($sqlResult);
        if($sqlResult){
            return $this->view->view($sqlResult);
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
        //var_dump($arr);
        if($arr[0]!="" && count($arr)==1){
            $sql = "SELECT email FROM users_booker WHERE id=?;";
            $par = array($arr[0]);
            $sqlResult = $this->sql->makeQuery($sql, $par);
            //$result = $this->view->view($sqlResult);
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