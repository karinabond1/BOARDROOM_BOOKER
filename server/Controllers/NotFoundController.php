<?php

include_once('../../Views/View.php');

class NotFoundController{

    private $view;

    public function __construct()
    {
        $this->view = new View();
        $this->view->view(array("Not found"));
    }

}