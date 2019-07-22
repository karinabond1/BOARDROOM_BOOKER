<?php

include_once('Sql.php');

class UserModel{

    private $sql;
    private $view;

    public function __construct()
    {
        $this->sql = new Sql();
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
                return $sqlResult;
            }elseif(!$sqlResult){
                return  'There is no such events!';
            }else{
                return  'Something went wrong. Please, try again!';
            }
        }else{
            return 'Something went wrong. Please, try again!!';
        }
    }   

    public function getUserById($par)
    {
        if (stristr($par, '/')) {
            $arr = explode('/', $par);
        } else {
            $arr[0] = $par;
        }
        if ($arr[0] != "" && count($arr) == 1) {
            $sql = "SELECT id, name, email, password, role, status FROM users_booker WHERE id=?;";
            $par = array($arr[0]);
            $sqlResult = $this->sql->makeQuery($sql, $par);
            if ($sqlResult) {
                return $sqlResult;
            } elseif (!$sqlResult) {
                return  'There is no such events!';
            } else {
                return  'Something went wrong. Please, try again!';
            }
        } else {
            return 'Something went wrong. Please, try again!!';
        }
    }

    public function getRooms()
    {
        $sql = "SELECT id, name FROM rooms_booker;";
        $sqlResult = $this->sql->makeQuery($sql, $par);
        if ($sqlResult) {
            return $sqlResult;
        } elseif (!$sqlResult) {
            return 'There is no rooms!';
        } else {
            return 'Something went wrong. Please, try again!';
        }
    }
}