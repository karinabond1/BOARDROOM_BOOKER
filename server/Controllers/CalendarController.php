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
        return $this->model->postCheckEvent() ? true : false;
    }

    public function postEvent($par)
    {
        return $this->model->postEvent($par) ? true : false;
    }

    public function putEvent($par)
    {
        return $this->model->putEvent($par) ? true : false;
    }

    public function deleteEvent($par)
    {
        return $this->model->deleteEvent($par) ? true : false;
    }

    public function getEventsByMonth($par)
    {
        return $this->model->getEventsByMonth($par) ? true : false;
    }

    public function getRooms()
    {
        return $this->model->getRooms() ? true : false;
    }
}