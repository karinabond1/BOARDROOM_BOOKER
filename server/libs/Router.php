<?php

include('../../Controllers/UserController.php');
include('../../Controllers/CalendarController.php');
include('../../Controllers/AdminController.php');
include('../../config.php');

class Router{

    private $method;
    private $url;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->url = $_SERVER['REQUEST_URI'];
    }

    
    public function methodChoose()
    {

        list( /*$u,*/ $r, $ser, $a, $class, $meth, $par) = explode('/', $this->url, 6);

        switch ($this->method) {
            case 'GET':
                //echo $class;
                $this->setMethod(ucfirst($class).'Controller', 'get' . ucfirst($meth), $par);
                break;
            case 'DELETE':
                $this->setMethod(ucfirst($class).'Controller', 'delete' . ucfirst($meth), $par);
                break;
            case 'POST':
                $this->setMethod(ucfirst($class).'Controller', 'post' . ucfirst($meth), $par);
                break;
            case 'PUT':
                $this->setMethod(ucfirst($class).'Controller', 'put' . ucfirst($meth), $par);
                break;
            default:
                return false;
        }
    }

    private function setMethod($class, $method, $par = false)
    {
        //echo $class.' '.$method;
        $obj = new $class;
        if (method_exists($obj, $method)) {
            call_user_func([$obj, $method], $par);
        }
    }
}