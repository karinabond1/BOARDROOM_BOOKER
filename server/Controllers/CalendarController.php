<?php

include('../../Models/CalendarModel.php');

class CalendarController{

    private $model;

    public function __construct()
    {
        $this->model = new CalendarModel();
    }

    public function postCheckEvent()
    {
        $result = $this->model->postCheckEvent();
        if(!$result){
            return false;
        }else{
            return true;
        }
    }

    public function postEvent($par)
    {
        $result = $this->model->postEvent($par);
        if(!$result){
            return false;
        }else{
            return true;
        }
    }

    public function putEvent($par)
    {
        $result = $this->model->putEvent($par);
        if(!$result){
            return false;
        }else{
            return true;
        }
    }

    public function deleteEvent($par)
    {
        $result = $this->model->deleteEvent($par);
        if(!$result){
            return false;
        }else{
            return true;
        }
    }

    public function getEventsByMonth($par)
    {
        $result = $this->model->getEventsByMonth($par);
        if(!$result){
            return false;
        }else{
            return true;
        }
    }

    public function getRooms()
    {
        $result = $this->model->getRooms();
        if(!$result){
            return false;
        }else{
            return true;
        }
    }
}