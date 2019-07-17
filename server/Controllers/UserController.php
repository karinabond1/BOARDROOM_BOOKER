<?php

include('../../Models/UserModel.php');

class UserController{

    private $model;

    public function __construct()
    {
        //var_dump($_REQUEST);
        $this->model = new UserModel();
    }

    /*public function postUserInfo()
    {
        //echo $_REQUEST['name'];
        //var_dump($_REQUEST['name']);
        $result = $this->model->postUserInfo();
        if(!$result){
            return false;
        }else{
            return true;
        }
    }*/

    public function postUser()
    {
        //print_r($par);
        $result = $this->model->postUser();
        if(!$result){
            return false;
        }else{
            return true;
        }
    }

    public function getUserInfo($par){
        $result = $this->model->getUserInfo($par);
        if(!$result){
            return false;
        }else{
            return true;
        }

    }
}