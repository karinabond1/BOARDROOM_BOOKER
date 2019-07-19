<?php

include_once('../../libs/Sql.php');
include_once('../../Views/View.php');

class AdminModel{

    private $sql;
    private $view;

    public function __construct()
    {
        $this->sql = new Sql();
        $this->view = new View();
    }

    public function postUserInfo()
    {
        $sqlEmailCheck = "SELECT id FROM users_booker WHERE email=?;";
        $parEmailCheck = array($_REQUEST['email']);
        $sqlEmailCheckResult = $this->sql->makeQuery($sqlEmailCheck, $parEmailCheck);
        if($sqlEmailCheckResult) {    
            return $resultEmailCheck = $this->view->view('There is the same email. Please, change it!');
        }elseif(!$sqlEmailCheckResult){
            $sql = "INSERT INTO users_booker (name, email, password, role, status, email_to) VALUES(?,?,?,?,?,?);";
            $par = array($_REQUEST['name'], $_REQUEST['email'], $_REQUEST['password'], 'user', true, 'mailto:'.$_REQUEST['email']);
            $sqlResult = $this->sql->makeQuery($sql, $par);
            if($sqlResult){
                return $this->view->view($sqlResult);
            }else{
                return $this->view->view('Something went wrong. Please, try again!');
            }        
        }
    }

    public function putUser()
    {
        $sql = "SELECT id, name FROM users_booker WHERE email=? AND password=?;";
        $par = array($_REQUEST['email'],$_REQUEST['password']);
        $sqlResult = $this->sql->makeQuery($sql, $par);
        if($sqlResult){
            return $this->view->view($sqlResult);
        }else{
            return $this->view->view('Something went wrong. Please, try again!');
        }
    }

    public function deleteUser()
    {
        $sql = "DELETE FROM users_booker WHERE id=?;";
        $par = array($_REQUEST['id']);
        $sqlResult = $this->sql->makeQuery($sql, $par);
        if($sqlResult){
            return $this->view->view($sqlResult);
        }else{
            return $this->view->view('Something went wrong. Please, try again!');
        }
    }

    public function getAllUsers()
    {
        $sql = "SELECT id, name, email, password, role, status, email_to FROM users_booker;";
        $sqlResult = $this->sql->makeQuery($sql, $par);
        if($sqlResult){
            return $this->view->view($sqlResult);
        }elseif (!$sqlResult) {
            return $this->view->view('There is no users!');
        }else{
            return $this->view->view('Something went wrong. Please, try again!');
        }
    }

    
}