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
        return $this->model->postUserInfo() ? true : false;
    }

    public function putUser($par)
    {
        return $this->model->putUser($par) ? true : false;
    }

    public function deleteUser($par)
    {
        return $this->model->deleteUser($par) ? true : false;
    }

    public function getAllUsers($par)
    {
        return $this->model->getAllUsers($par) ? true : false;
    }

    public function getUserById($par)
    {
        return $this->model->getUserById($par) ? true : false;
    }
}