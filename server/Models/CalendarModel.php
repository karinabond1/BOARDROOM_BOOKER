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

    public function postCheckEvent($arrP = false)
    {
        $arr = array();
        if ($arrP != false) {
            $arr = $arrP;
        } elseif (count($_REQUEST) == 0) {
            $arr = json_decode(file_get_contents('php://input'), true);
        } elseif (count($_REQUEST) > 0) {
            $arr = $_REQUEST;
        }
        if ($arr['start'] != '' && $arr['end'] != '' && $arr['create_date'] != '' && $arr['room_id'] != '' && $arr['start'] < $arr['end']) {
            $sqlDataCheck = "SELECT start, end, create_date FROM events_booker WHERE create_date=? AND room_id=? AND id !=?;";
            $parDataCheck = array($arr['create_date'], $arr['room_id'], $arr['id']);
            $sqlDataCheckResult = $this->sql->makeQuery($sqlDataCheck, $parDataCheck);
            if ($sqlDataCheckResult) {
                if (is_array($sqlDataCheckResult)) {
                    $index = '00:15:00';
                    foreach ($sqlDataCheckResult as $value) {
                        if (($value['start'] == $arr['start'] && $value['end'] == $arr['end']) || $value['start'] === $arr['start'] || $value['end'] === $arr['end']) {
                            if ($arrP != false) {
                                return 'There is the same event on this day. Please, change it!!';
                            }
                            return $this->view->view('There is the same event on this day. Please, change it!!');
                        } elseif ($arr['start'] < $value['start'] && $arr['start'] < $value['end'] && $arr['end'] < $value['end'] && $arr['end'] > $value['start']) {
                            if ($arrP != false) {
                                return 'There is the same event on this day. Please, change it!!';
                            }
                            return $this->view->view('There is the same event on this day. Please, change it!!');
                        } elseif ($arr['start'] > $value['start'] && $arr['start'] < $value['end'] && $arr['end'] < $value['end'] && $arr['end'] > $value['start']) {
                            if ($arrP != false) {
                                return 'There is the same event on this day. Please, change it!!';
                            }
                            return $this->view->view('There is the same event on this day. Please, change it!!');
                        } elseif ($arr['start'] > $value['start'] && $arr['start'] < $value['end'] && $arr['end'] > $value['end'] && $arr['end'] > $value['start']) {
                            if ($arrP != false) {
                                return 'There is the same event on this day. Please, change it!!';
                            }
                            return $this->view->view('There is the same event on this day. Please, change it!!');
                        } elseif ($arr['start'] < $value['start'] && $arr['start'] < $value['end'] && $arr['end'] > $value['end'] && $arr['end'] > $value['start']) {
                            if ($arrP != false) {
                                return 'There is the same event on this day. Please, change it!!';
                            }
                            return $this->view->view('There is the same event on this day. Please, change it!!');
                        } else {
                            if ($arrP != false) {
                                return 'yes';
                            }
                            return $this->view->view('yes');
                        }
                    }
                } else {
                    if ($arrP != false) {
                        return 'Something went wrong. Please, try again!';
                    }
                    return $this->view->view('Something went wrong. Please, try again!');
                }
            } else {
                if ($arrP != false) {
                    return 'yes';
                }
                return $this->view->view('yes');
            }
        } else {
            if ($arrP != false) {
                return 'Something went wrong. Please, try again!';
            }
            return $this->view->view('Something went wrong. Please, try again!');
        }
    }

    public function postEvent()
    {
        $arr = array();
        if (count($_REQUEST) == 0) {
            $arr = json_decode(file_get_contents('php://input'), true);
        } else {
            $arr = $_REQUEST;
        }
        if ($arr['start'] != '' && $arr['end'] != '' && $arr['user_id'] != '' && $arr['create_date'] != '' && $arr['room_id'] != '' && $arr['start'] < $arr['end']) {
            $sqlDataCheck = "SELECT start, end, create_date FROM events_booker WHERE create_date=? AND room_id=?;";
            $parDataCheck = array($arr['create_date'], $arr['room_id']);
            $sqlDataCheckResult = $this->sql->makeQuery($sqlDataCheck, $parDataCheck);
            if ($sqlDataCheckResult) {
                if (is_array($sqlDataCheckResult)) {
                    $index = '00:15:00';
                    foreach ($sqlDataCheckResult as $value) {
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
        } else {
            return $this->view->view('Something went wrong. Please, try again!');
        }
    }


    public function putEvent()
    {
        $arr = array();
        $arrResCheck = array();

        if (count($_REQUEST) == 0) {
            $arr = json_decode(file_get_contents('php://input'), true);
        } else {
            $arr = $_REQUEST;
        }
        if ($arr['rec'] == '+') {

            $sqlRec = "SELECT recurent_id FROM events_booker WHERE id=? ";
            $parRec = array($arr['id']);
            $sqlResultRec = $this->sql->makeQuery($sqlRec, $parRec);
            if (is_array($sqlResultRec)) {
                $create_date = $sqlResultRec[0]['recurent_id'];
            }
            $sqlRecId = "SELECT id, create_date, room_id FROM events_booker WHERE recurent_id=? ";
            $parRecId = array($create_date);
            $sqlResultRecId = $this->sql->makeQuery($sqlRecId, $parRecId);
            if (is_array($sqlResultRecId)) {
                $bool = true;
                foreach ($sqlResultRecId as $id) {
                    array_push($arrResCheck, $this->postCheckEvent(array('id' => $id['id'], 'create_date' => $id['create_date'], 'room_id' => $arr['room_id'], 'start' => $arr['start'], 'end' => $arr['end'])));
                }
                foreach ($arrResCheck as $elem) {
                    if ($elem != 'yes') {
                        $bool = false;
                    }
                    if (!$bool) {
                        break;
                    }
                }
                if ($bool) {
                    foreach ($sqlResultRecId as $id) {
                        $sql = 'UPDATE events_booker SET start=?,end=?,note=? WHERE id=?';
                        $par = array($arr['start'], $arr['end'], $arr['note'], $id['id']);
                        $sqlResult = $this->sql->makeQuery($sql, $par);
                    }
                    if ($sqlResult) {
                        return $this->view->view($sqlResult);
                    } else {
                        return $this->view->view('Something went wrong. Please, try again!');
                    }
                } else {
                    return $this->view->view("there is such events!");
                }
            } else {
                return $this->view->view('There is no such events!');
            }
        } elseif (($arr['start'] != "" || $arr['end'] != "" || $arr['note'] != "") && $arr['id'] != "") {
            $sql = 'UPDATE events_booker SET ';
            if ($arr['start'] != "") {
                $sql .= 'start=?';
                if ($arr['end'] || $arr['note']) {
                    $sql .= ', ';
                }
                $par[] = $arr['start'];
            }
            if ($arr['end'] != "") {
                $sql .= 'end=?';
                if ($arr['note']) {
                    $sql .= ', ';
                }
                $par[] = $arr['end'];
            }
            if ($arr['note'] != "") {
                $sql .= 'note=?';
                $par[] = $arr['note'];
            }
            $sql .= ' WHERE id=?';
            $par[] = $arr['id'];
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

    public function deleteEvent($par)
    {
        $arr = array();
        $arrId = array();
        $rec = "";
        if (stristr($par, '/')) {
            $arr = explode('/', $par);
            if ($arr[1] == '+') {
                $sqlRec = "SELECT recurent_id FROM events_booker WHERE id=? ";
                $parRec = array($arr[0]);
                $sqlResultRec = $this->sql->makeQuery($sqlRec, $parRec);
                if (is_array($sqlResultRec)) {
                    $create_date = $sqlResultRec[0]['recurent_id'];
                }
                $sqlRecId = "SELECT id FROM events_booker WHERE recurent_id=? ";
                $parRecId = array($create_date);
                $sqlResultRecId = $this->sql->makeQuery($sqlRecId, $parRecId);
                if (is_array($sqlResultRecId)) {
                    foreach ($sqlResultRecId as $id) {
                        $sqlRescRes = "DELETE FROM events_booker WHERE id=?;";
                        $parResRec = array($id['id']);
                        $sqlResultResRec = $this->sql->makeQuery($sqlRescRes, $parResRec);
                    }
                    if ($sqlResultResRec) {
                        return $this->view->view($sqlResultResRec);
                    } else {
                        return $this->view->view('Something went wrong. Please, try again!');
                    }
                } else {
                    return $this->view->view('There is no such events!');
                }
            } elseif (count($_REQUEST) > 0) {
                $arr = $_REQUEST;
            } else {
                if ($arr[0] != "") {
                    $sql = "DELETE FROM events_booker WHERE id=?;";
                    $par = array($arr[0]);
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
        } else {
            return $this->view->view('Something went wrong. Please, try again!!');
        }
    }

    public function getEventsByMonth($par)
    {
        if (stristr($par, '/')) {
            $arr = explode('/', $par);
        } else {
            $arr[0] = $par;
        }
        if ($arr[0] != "" && $arr[1] != "" && $arr[2] != "" && count($arr) == 3) {
            $sql = "SELECT id, note, start, end, create_date, user_id, recurent_id, room_id FROM events_booker WHERE room_id=? AND MONTH(create_date)=? AND YEAR(create_date)=? ORDER BY start;";
            $par = array($arr[0], $arr[1], $arr[2]);
            $sqlResult = $this->sql->makeQuery($sql, $par);
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

    public function getRooms($par)
    {
        $sql = "SELECT id, name FROM rooms_booker;";
        $sqlResult = $this->sql->makeQuery($sql, $par);
        if ($sqlResult) {
            return $this->view->view($sqlResult);
        } elseif (!$sqlResult) {
            return $this->view->view('There is no rooms!');
        } else {
            return $this->view->view('Something went wrong. Please, try again!');
        }
    }
}
