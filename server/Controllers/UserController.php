<?php

include('../../Models/UserModel.php');

class UserController{

    private $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function putUser()
    {
        return $this->model->putUser() ? true : false;
    }

    public function getUserInfo($par){
        return $this->model->getUserInfo($par) ? true : false;
    }
}