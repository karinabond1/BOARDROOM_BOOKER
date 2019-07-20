<?php

include_once('../../libs/Sql.php');
include_once('../../Views/View.php');

class AdminModel
{

    private $sql;
    private $view;

    public function __construct()
    {
        $this->sql = new Sql();
        $this->view = new View();
    }

    public function postUserInfo()
    {
        $arr = array();
        if (count($_REQUEST) == 0) {
            $arr = json_decode(file_get_contents('php://input'), true);
        } else {
            $arr = $_REQUEST;
        }
        $sqlEmailCheck = "SELECT id FROM users_booker WHERE email=?;";
        $parEmailCheck = array($arr['email']);
        $sqlEmailCheckResult = $this->sql->makeQuery($sqlEmailCheck, $parEmailCheck);
        if ($sqlEmailCheckResult) {
            return $this->view->view('There is the same email. Please, change it!');
        } elseif (!$sqlEmailCheckResult) {
            $sql = "INSERT INTO users_booker (name, email, password, role, status, email_to) VALUES(?,?,?,?,?,?);";
            $par = array($arr['name'], $arr['email'], $arr['password'], $arr['role'], true, 'mailto:' . $arr['email']);
            $sqlResult = $this->sql->makeQuery($sql, $par);
            return $sqlResult ? $this->view->view('Ok!') : $this->view->view('Something went wrong. Please, try again!');
        }
    }

    public function putUser()
    {
        $arr = array();
        if (count($_REQUEST) == 0) {
            $arr = json_decode(file_get_contents('php://input'), true);
        } else {
            $arr = $_REQUEST;
        }
        $sqlEmailCheck = "SELECT id FROM users_booker WHERE email=? AND id!=?;";
        $parEmailCheck = array($arr['email'], $arr['id']);
        $sqlEmailCheckResult = $this->sql->makeQuery($sqlEmailCheck, $parEmailCheck);
        if ($sqlEmailCheckResult) {
            return $this->view->view('There is the same email. Please, change it!');
        } elseif (!$sqlEmailCheckResult) {
            $sql = "UPDATE users_booker SET name=?, email=?, password=?,role=?,status=?,email_to=? WHERE id=?;";
            $par = array($arr['name'], $arr['email'], $arr['password'], $arr['role'], $arr['status'], 'mailto:' . $arr['email'], $arr['id']);
            $sqlResult = $this->sql->makeQuery($sql, $par);
            return $sqlResult ? $this->view->view($sqlResult) : $this->view->view('Something went wrong. Please, try again!');
        }
    }

    public function deleteUser($id)
    {
        $sqlEvents = "DELETE FROM events_booker where user_id=? AND create_date>?";
        $parEvents = array($id, date("Y-m-d"));
        $sqlResultEvents = $this->sql->makeQuery($sqlEvents, $parEvents);
        $sql = "UPDATE users_booker SET status=? where id=?";
        $par = array(0, $id);
        $sqlResult = $this->sql->makeQuery($sql, $par);
        return $sqlResult && $sqlResultEvents ? $this->view->view("Ok!") : $this->view->view('Something went wrong. Please, try again!');

    }

    public function getAllUsers()
    {
        $sql = "SELECT id, name, email, password, role, status, email_to FROM users_booker;";
        $sqlResult = $this->sql->makeQuery($sql, $par);
        if ($sqlResult) {
            return $this->view->view($sqlResult);
        } elseif (!$sqlResult) {
            return $this->view->view('There is no users!');
        } else {
            return $this->view->view('Something went wrong. Please, try again!');
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
                return $this->view->view($sqlResult);
            } elseif (!$sqlResult) {
                return  $this->view->view('There is no such events!');
            } else {
                return  $this->view->view('Something went wrong. Please, try again!');
            }
        } else {
            return $this->view->view('Something went wrong. Please, try again!!');
        }
    }
}
