<?php

include_once('../../libs/Sql.php');
include_once('../../Views/View.php');

class CallendarModel{

    private $sql;
    private $view;

    public function __construct()
    {
        $this->sql = new Sql();
        $this->view = new View();
    }

    public function postEvent()
    {
        $sqlEmailCheck = "SELECT start, end, create_date FROM events_booker WHERE create_date=?;";
        $parEmailCheck = array($_REQUEST['create_date']);
        $sqlEmailCheckResult = $this->sql->makeQuery($sqlEmailCheck, $parEmailCheck);
        if($sqlEmailCheckResult) { 
            if(is_array($sqlEmailCheckResult)){
                for($i=0; $i<count($i);$i++){
                    if(($sqlEmailCheckResult[$i]['start']===$_REQUEST['start'] && $sqlEmailCheckResult[$i]['end']===$_REQUEST['end']) || $sqlEmailCheckResult[$i]['start']===$_REQUEST['start']) || $sqlEmailCheckResult[$i]['end']===$_REQUEST['end'])){
                        $this->view->view('There is the same event on this day. Please, change it!');
                    }else{
                        for($j=$_REQUEST['start']; $j<=$_REQUEST['end'];$j+=15){
                            if($sqlEmailCheckResult[$i]['start']===$j || $sqlEmailCheckResult[$i]['end']===$j){
                                $this->view->view('There is the same event on this time. Please, change it!');
                            }
                        }
                        
                    }

                }
            }else{
                $sqlEmailCheckView = $this->view->view($sqlEmailCheckResult);
                if(!$sqlEmailCheckView){
                    return "Not ok";
                }else{
                    return "Ok";
                }
            }
            
            //return $resultEmailCheck = $this->view->view('There is the same email. Please, change it!');
        }elseif(!$sqlEmailCheckResult){
            $sql = "INSERT INTO events_booker (note,start,end,user_id,create_date,recurent_id,room_id) VALUES(?,?,?,?,?,?,?);";
            $par = array($_REQUEST['note'], $_REQUEST['start'], $_REQUEST['end'], $_REQUEST['user_id'],$_REQUEST['create_date'], $_REQUEST['recurent_id'],)$_REQUEST['room_id'];
            $sqlResult = $this->sql->makeQuery($sql, $par);
            $result = $this->view->view($sqlResult);
            if($result){
                return $result;
            }else{
                return 'Something went wrong. Please, try again!';
            }        
        }
    }

    public function putEvent()
    {
        $sql = "SELECT id, name FROM users_booker WHERE email=? AND password=?;";
        $par = array($_REQUEST['email'],$_REQUEST['password']);
        $sqlResult = $this->sql->makeQuery($sql, $par);
        $result = $this->view->view($sqlResult);
        if($result){
            return $result;
        }else{
            return 'Something went wrong. Please, try again!';
        }
    }

    public function deleteEvent()
    {
        $sql = "DELETE FROM users_booker WHERE id=?;";
        $par = array($_REQUEST['id']);
        $sqlResult = $this->sql->makeQuery($sql, $par);
        $result = $this->view->view($sqlResult);
        if($result){
            return $result;
        }else{
            return 'Something went wrong. Please, try again!';
        }
    }

    public function getEvent()
    {
        $sql = "DELETE FROM users_booker WHERE id=?;";
        $par = array($_REQUEST['id']);
        $sqlResult = $this->sql->makeQuery($sql, $par);
        $result = $this->view->view($sqlResult);
        if($result){
            return $result;
        }else{
            return 'Something went wrong. Please, try again!';
        }
    }

    
}