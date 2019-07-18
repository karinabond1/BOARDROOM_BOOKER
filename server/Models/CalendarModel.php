<?php

include_once('../../libs/Sql.php');
include_once('../../Views/View.php');

class CalendarModel
{

    private $sql;
    private $view;

    public function __construct()
    {
        $this->sql = new Sql();
        $this->view = new View();
    }

    public function postCheckEvent()
    {
        $arr = Array();
        if (count($_REQUEST) == 0) {
            $arr = json_decode(file_get_contents('php://input'), true);
            //var_dump($arr);
        } else {
            $arr = $_REQUEST;
        }
        if ($arr['start'] != '' && $arr['end'] != '' && $arr['user_id'] != '' && $arr['create_date'] != '' && $arr['room_id'] != '' && $arr['start'] < $arr['end']) {
            //var_dump($_REQUEST);
            //echo $_REQUEST['create_date'];
            $sqlDataCheck = "SELECT start, end, create_date FROM events_booker WHERE create_date=? AND room_id=?;";
            $parDataCheck = array($arr['create_date'], $arr['room_id']);
            $sqlDataCheckResult = $this->sql->makeQuery($sqlDataCheck, $parDataCheck);
            //var_dump($sqlDataCheckResul);
            //echo "dd";
            if ($sqlDataCheckResult) {
                if (is_array($sqlDataCheckResult)) {
                    //var_dump($sqlDataCheckResult);
                    $index = '00:15:00';
                    foreach ($sqlDataCheckResult as $value) {
                        //echo $index;
                        //var_dump($value);
                        //echo "value: ".$value['start'];
                        //echo " request: ".$_REQUEST['start'];
                        if (($value['start'] == $arr['start'] && $value['end'] == $arr['end']) || $value['start'] === $arr['start'] || $value['end'] === $arr['end']) {
                            $this->view->view('There is the same event on this day. Please, change it!!');
                        } elseif ($arr['start'] < $value['start'] && $arr['start'] < $value['end'] && $arr['end'] < $value['end'] && $arr['end'] > $value['start']) {
                            $this->view->view('There is the same event on this day. Please, change it!!');
                        } elseif ($arr['start'] > $value['start'] && $arr['start'] < $value['end'] && $arr['end'] < $value['end'] && $arr['end'] > $value['start']) {
                            $this->view->view('There is the same event on this day. Please, change it!!');
                        } elseif ($arr['start'] > $value['start'] && $arr['start'] < $value['end'] && $arr['end'] > $value['end'] && $arr['end'] > $value['start']) {
                            $this->view->view('There is the same event on this day. Please, change it!!');
                        } elseif ($arr['start'] < $value['start'] && $arr['start'] < $value['end'] && $arr['end'] > $value['end'] && $arr['end'] > $value['start']) {
                            $this->view->view('There is the same event on this day. Please, change it!!');
                        } else {
                            $this->view->view('yes');
                        }
                    }

                } else {
                    return $this->view->view('Something went wrong. Please, try again!');
                }
            }else{
                return $this->view->view('yes');
            }
        }else{
            return $this->view->view('Something went wrong. Please, try again!');
        }
    }

    public function postEvent()
    {
        $arr = Array();
        if (count($_REQUEST) == 0) {
            $arr = json_decode(file_get_contents('php://input'), true);
            //var_dump($arr);
        } else {
            $arr = $_REQUEST;
        }
        if ($arr['start'] != '' && $arr['end'] != '' && $arr['user_id'] != '' && $arr['create_date'] != '' && $arr['room_id'] != '' && $arr['start'] < $arr['end']) {
            //var_dump($_REQUEST);

            //echo $_REQUEST['create_date'];
            $sqlDataCheck = "SELECT start, end, create_date FROM events_booker WHERE create_date=? AND room_id=?;";
            $parDataCheck = array($arr['create_date'], $arr['room_id']);
            $sqlDataCheckResult = $this->sql->makeQuery($sqlDataCheck, $parDataCheck);
            //var_dump($sqlDataCheckResul);
            if ($sqlDataCheckResult) {
                //echo "dd";
                if (is_array($sqlDataCheckResult)) {
                    //var_dump($sqlDataCheckResult);
                    $index = '00:15:00';
                    foreach ($sqlDataCheckResult as $value) {
                        //echo $index;
                        //var_dump($value);
                        //echo "value: ".$value['start'];
                        //echo " request: ".$_REQUEST['start'];
                        if (($value['start'] == $arr['start'] && $value['end'] == $arr['end']) || $value['start'] === $arr['start'] || $value['end'] === $arr['end']) {
                            return $this->view->view('There is the same event on this day. Please, change it!!');
                        } elseif ($arr['start'] < $value['start'] && $arr['start'] < $value['end'] && $arr['end'] < $value['end'] && $arr['end'] > $value['start']) {
                            return $this->view->view('There is the same event on this day. Please, change it!!');
                        } elseif ($arr['start'] > $value['start'] && $arr['start'] < $value['end'] && $arr['end'] < $value['end'] && $arr['end'] > $value['start']) {
                            return $this->view->view('There is the same event on this day. Please, change it!!');
                        } elseif ($arr['start'] > $value['start'] && $arr['start'] < $value['end'] && $arr['end'] > $value['end'] && $arr['end'] > $value['start']) {
                            return $this->view->view('There is the same event on this day. Please, change it!!');
                        } elseif ($arr['start'] < $value['start'] && $arr['start'] < $value['end'] && $arr['end'] > $value['end'] && $arr['end'] > $value['start']) {
                            return $this->view->view('There is the same event on this day. Please, change it!!');
                        } else {
                            $sql = "INSERT INTO events_booker (note,start,end,user_id,create_date,recurent_id,room_id) VALUES(?,?,?,?,?,?,?);";
                            $par = array($arr['note'], $arr['start'], $arr['end'], $arr['user_id'], $arr['create_date'], $arr['recurent_id'], $arr['room_id']);
                            $sqlResult = $this->sql->makeQuery($sql, $par);
                            //$result = $this->view->view($sqlResult);
                            if ($sqlResult) {
                                return $this->view->view('Your event was booked!');
                            } else {
                                return $this->view->view('Something went wrong. Please, try again!');
                            }
                        }
                    }

                } else {

                    return $this->view->view('Something went wrong. Please, try again!');
                }
            }else {
                $sql = "INSERT INTO events_booker (note,start,end,user_id,create_date,recurent_id,room_id) VALUES(?,?,?,?,?,?,?);";
                $par = array($arr['note'], $arr['start'], $arr['end'], $arr['user_id'], $arr['create_date'], $arr['recurent_id'], $arr['room_id']);
                $sqlResult = $this->sql->makeQuery($sql, $par);
                //$result = $this->view->view($sqlResult);
                if ($sqlResult) {
                    return $this->view->view('Your event was booked!');
                } else {
                    return $this->view->view('Something went wrong. Please, try again!');
                }
            }
        }else{
            return $this->view->view('Something went wrong. Please, try again!');
        }
    }


    public function putEvent()
    {
        if (($_REQUEST['start'] != "" || $_REQUEST['end'] != "" || $_REQUEST['note'] != "") && $_REQUEST['id'] != "") {
            $sql = 'UPDATE events_booker SET ';
            if ($_REQUEST['start'] != "") {
                $sql .= 'start=?';
                if ($_REQUEST['end'] || $_REQUEST['note']) {
                    $sql .= ', ';
                }
                $par[] = $_REQUEST['start'];
            }
            if ($_REQUEST['end'] != "") {
                $sql .= 'end=?';
                if ($_REQUEST['note']) {
                    $sql .= ', ';
                }
                $par[] = $_REQUEST['end'];
            }
            if ($_REQUEST['note'] != "") {
                $sql .= 'note=?';
                $par[] = $_REQUEST['note'];
            }
            $sql .= ' WHERE id=?';
            $par[] = $_REQUEST['id'];
            $sqlResult = $this->sql->makeQuery($sql, $par);
            //$result = $this->view->view($sqlResult);
            if ($sqlResult) {
                return $this->view->view($sqlResult);
            } else {
                return $this->view->view('Something went wrong. Please, try again!');
            }
        } else {
            return $this->view->view('Something went wrong. Please, try again!!');
        }

    }

    public function deleteEvent()
    {
        if ($_REQUEST['id'] != "") {
            $sql = "DELETE FROM events_booker WHERE id=?;";
            $par = array($_REQUEST['id']);
            $sqlResult = $this->sql->makeQuery($sql, $par);
            if ($sqlResult) {
                return $this->view->view($sqlResult);
            } else {
                return $this->view->view('Something went wrong. Please, try again!');
            }
        } else {
            return $this->view->view('Something went wrong. Please, try again!!');
        }

    }

    public function getEventsByMonth($par)
    {
        //echo $par;
        //echo 'f';
        if (stristr($par, '/')) {
            $arr = explode('/', $par);
        } else {
            $arr[0] = $par;
        }
        //var_dump($arr);
        if ($arr[0] != "" && $arr[1] != "" && $arr[2] != "" && count($arr) == 3) {
            $sql = "SELECT id, note, start, end, create_date FROM events_booker WHERE room_id=? AND MONTH(create_date)=? AND YEAR(create_date)=? ORDER BY start;";
            $par = array($arr[0], $arr[1], $arr[2]);
            $sqlResult = $this->sql->makeQuery($sql, $par);
            //$result = $this->view->view($sqlResult);
            if ($sqlResult) {
                return $this->view->view($sqlResult);
            } elseif (!$sqlResult) {
                return $this->view->view('There is no such events!');
            } else {
                return $this->view->view('Something went wrong. Please, try again!');
            }
        } else {
            return $this->view->view('Something went wrong. Please, try again!!');
        }
    }

    public function getRooms()
    {
        $sql = "SELECT id, name FROM rooms_booker;";
        $sqlResult = $this->sql->makeQuery($sql, $par);
        //$result = $this->view->view($sqlResult);
        if ($sqlResult) {
            return $this->view->view($sqlResult);
        } elseif (!$sqlResult) {
            return $this->view->view('There is no rooms!');
        } else {
            return $this->view->view('Something went wrong. Please, try again!');
        }
    }

}
