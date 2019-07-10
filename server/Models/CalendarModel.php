<?php

include_once('../../libs/Sql.php');
include_once('../../Views/View.php');

class CalendarModel{

    private $sql;
    private $view;

    public function __construct()
    {
        $this->sql = new Sql();
        $this->view = new View();
    }

    public function postEvent()
    {
        if($_REQUEST['note']!='' && $_REQUEST['start']!='' && $_REQUEST['end']!='' && $_REQUEST['user_id']!='' && $_REQUEST['create_date']!='' && $_REQUEST['recurent_id']!='' && $_REQUEST['room_id']!='' && $_REQUEST['start']<$_REQUEST['end']){
            //var_dump($_REQUEST);
            //echo $_REQUEST['create_date'];
            $sqlDataCheck = "SELECT start, end, create_date FROM events_booker WHERE create_date=? AND room_id=?;";
            $parDataCheck = array($_REQUEST['create_date'], $_REQUEST['room_id']);
            $sqlDataCheckResult = $this->sql->makeQuery($sqlDataCheck, $parDataCheck);
            //var_dump($sqlDataCheckResul);
            if($sqlDataCheckResult) { 
                if(is_array($sqlDataCheckResult)){
                    //var_dump($sqlEmailCheckResul);
                    $index = '00:15:00';
                    foreach($sqlDataCheckResult as $value){
                        //echo $index;
                        //var_dump($value);
                        //echo "value: ".$value['start'];
                        //echo " request: ".$_REQUEST['start'];
                        if( ($value['start']==$_REQUEST['start'] && $value['end']==$_REQUEST['end']) || $value['start']===$_REQUEST['start'] || $value['end']===$_REQUEST['end']){
                            $this->view->view('There is the same event on this day. Please, change it!!');
                        }elseif($_REQUEST['start']<$value['start'] && $_REQUEST['start']<$value['end'] && $_REQUEST['end']<$value['end'] && $_REQUEST['end']>$value['start']){
                                $this->view->view('There is the same event on this day. Please, change it!!');
                        }elseif($_REQUEST['start']>$value['start'] && $_REQUEST['start']<$value['end'] && $_REQUEST['end']<$value['end'] && $_REQUEST['end']>$value['start']){
                            $this->view->view('There is the same event on this day. Please, change it!!');
                        }elseif($_REQUEST['start']>$value['start'] && $_REQUEST['start']<$value['end'] && $_REQUEST['end']>$value['end'] && $_REQUEST['end']>$value['start']){
                            $this->view->view('There is the same event on this day. Please, change it!!');
                        }elseif($_REQUEST['start']<$value['start'] && $_REQUEST['start']<$value['end'] && $_REQUEST['end']>$value['end'] && $_REQUEST['end']>$value['start']){
                            $this->view->view('There is the same event on this day. Please, change it!!');
                        }else{
                            $sql = "INSERT INTO events_booker (note,start,end,user_id,create_date,recurent_id,room_id) VALUES(?,?,?,?,?,?,?);";
                            $par = array($_REQUEST['note'], $_REQUEST['start'], $_REQUEST['end'], $_REQUEST['user_id'],$_REQUEST['create_date'], $_REQUEST['recurent_id'],$_REQUEST['room_id']);
                            $sqlResult = $this->sql->makeQuery($sql, $par);
                            //$result = $this->view->view($sqlResult);
                            if($sqlResult){
                                return $this->view->view($sqlResult);
                            }else{
                                return $this->view->view('Something went wrong. Please, try again!');
                            }  
                        } 
                            



                            //$now = time();
                            //$startDb = strtotime($value['start']);
                            //echo $value['start']." ";
                            //echo $startDb." ";
                            //echo $now;
                            /*$data = $value['start'];
                            do{
                                date_add($data, date_interval_create_from_date_string('15 minutes'));
                                if($data==$_REQUEST['start'] || $data==$_REQUEST['end']){
                                    $this->view->view('There is the same event outside this time. Please, change it!');
                                }
                            }while($data!=$value['end']);*/

                            /*for($j=$_REQUEST['start']; $j<=$_REQUEST['end'];date_add($j, date_interval_create_from_date_string('15 minutes'))){
                                echo date_format($j, 'H:i:s');
                            }*/
                            /*$date = date_create($_REQUEST['start']);
                            date_add($date, date_interval_create_from_date_string('15 minutes'));
                            echo date_format($date, 'H:i:s');
                            */
                            /*for($i='08:00:00';$i<5;$i+='00:15:00'){
                                //echo "f";
                                echo $i;
                            }*/
                            //$index += '00:15:00';
                            //if($value['start']+$index)
                            /*for($j=$_REQUEST['start']; $j<=$_REQUEST['end'];$j+='00:15:00'){
                                //$j+='01:15:00';
                                echo $j;
                                if($value['start']===$j || $value['end']===$j){
                                    $this->view->view('There is the same event on this time. Please, change it!');
                                }
                            }*/
                        }
                        
                    }
                        
                        /*if( ($value['start']===$_REQUEST['start'] && $value['end']===$_REQUEST['end']) || $value['start']===$_REQUEST['start']) || $value['end']===$_REQUEST['end'])){
                            $this->view->view('There is the same event on this day. Please, change it!');
                        }else{
                            for($j=$_REQUEST['start']; $j<=$_REQUEST['end'];$j+=15){
                                if($value['start']===$j || $value['end']===$j){
                                    $this->view->view('There is the same event on this time. Please, change it!');
                                }
                            }
                        }*/
                    //}
                }else{
                    return $this->view->view($sqlDataCheckResult);
                }                
        }elseif(!$sqlDataCheckResult){
            $sql = "INSERT INTO events_booker (note,start,end,user_id,create_date,recurent_id,room_id) VALUES(?,?,?,?,?,?,?);";
            $par = array($_REQUEST['note'], $_REQUEST['start'], $_REQUEST['end'], $_REQUEST['user_id'],$_REQUEST['create_date'], $_REQUEST['recurent_id'],$_REQUEST['room_id']);
            $sqlResult = $this->sql->makeQuery($sql, $par);
            //$result = $this->view->view($sqlResult);
            if($sqlResult){
                return $this->view->view($sqlResult);
            }else{
                return $this->view->view('Something went wrong. Please, try again!');
            }        
        }       
        
    }

    public function putEvent()
    {
        if(($_REQUEST['start']!="" || $_REQUEST['end']!="" || $_REQUEST['note']!="") && $_REQUEST['id']!=""){
            $sql = 'UPDATE events_booker SET ';
            if($_REQUEST['start']!="" ){
                $sql .= 'start=?';
                if($_REQUEST['end'] || $_REQUEST['note']){
                    $sql .= ', ';
                }
                $par[] = $_REQUEST['start'];
            }
            if($_REQUEST['end']!=""){
                $sql .= 'end=?';
                if($_REQUEST['note']){
                    $sql .= ', ';
                }
                $par[] = $_REQUEST['end'];
            }
            if($_REQUEST['note']!=""){
                $sql .= 'note=?';
                $par[] = $_REQUEST['note'];
            }
            $sql .= ' WHERE id=?';
            $par[] = $_REQUEST['id'];
            $sqlResult = $this->sql->makeQuery($sql, $par);
            //$result = $this->view->view($sqlResult);
            if($sqlResult){
                return $this->view->view($sqlResult);
            }else{
                return $this->view->view('Something went wrong. Please, try again!');
            }
        }else{
            return $this->view->view('Something went wrong. Please, try again!!');
        }
        
    }

    public function deleteEvent()
    {
        if($_REQUEST['id']!=""){
            $sql = "DELETE FROM events_booker WHERE id=?;";
            $par = array($_REQUEST['id']);
            $sqlResult = $this->sql->makeQuery($sql, $par);
            if($sqlResult){
                return $this->view->view($sqlResult);
            }else{
                return $this->view->view('Something went wrong. Please, try again!');
            }
        }else{
            return $this->view->view('Something went wrong. Please, try again!!');
        }
        
    }

    public function getEventsByMonth($par)
    {
        //echo $par;
        //echo 'f';
        if (stristr($par, '/')) {
            $arr = explode('/', $par);
        }
        //var_dump($arr);
        if($arr[0]!="" && $arr[1]!="" && $arr[2]!="" &&  count($arr)==3){
            $sql = "SELECT id, note, start, end, create_date FROM events_booker WHERE room_id=? AND MONTH(create_date)=? AND YEAR(create_date)=?;";
            $par = array($arr[0], $arr[1], $arr[2]);
            $sqlResult = $this->sql->makeQuery($sql, $par);
            //$result = $this->view->view($sqlResult);
            if($sqlResult){
                return $this->view->view($sqlResult);
            }elseif(!$sqlResult){
                return  $this->view->view('There is no such events!');
            }else{
                return  $this->view->view('Something went wrong. Please, try again!');
            }
        }else{
            return $this->view->view('Something went wrong. Please, try again!!');
        }
    }

    public function getRooms()
    {
        $sql = "SELECT id, name FROM rooms_booker;";
        $sqlResult = $this->sql->makeQuery($sql, $par);
        //$result = $this->view->view($sqlResult);
        if($sqlResult){
            return $this->view->view($sqlResult);
        }elseif(!$sqlResult){
            return  $this->view->view('There is no rooms!');
        }else{
            return  $this->view->view('Something went wrong. Please, try again!');
        }
    }
    
}