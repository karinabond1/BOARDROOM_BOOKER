<?php

include_once('../../Models/AdminModel.php');

class AdminController{

    private $model;

    public function __construct()
    {
        $this->model = new AdminModel();
    }

    public function postUserInfo()
    {
        $result = $this->model->postUserInfo();
        if(!$result){
            return false;
        }else{
            return true;
        }
    }

    public function putUser($par)
    {
        $result = $this->model->putUser($par);
        if(!$result){
            return false;
        }else{
            return true;
        }
    }

    public function deleteUser($par)
    {
        $result = $this->model->deleteUser($par);
        if(!$result){
            return false;
        }else{
            return true;
        }
    }
}