<?php

include_once('../../config.php');

class Sql{

    private $mysql;

    public function __construct()
    {
        $this->mysql = new PDO("mysql:host=" . HOST . ";port=" . PORT . ";dbname=" . DATABASE, USER_NAME, USER_PASS);
        $this->mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function makeQuery($sql, $par=false)
    {
        //var_dump($par);
        $arr = array();
        $query = $this->mysql->prepare($sql);
        $result = $query->execute($par);
        if(stristr($sql, 'SELECT')){
            if(count($query->fetchAll(PDO::FETCH_ASSOC))>0) {
                $index = 0;
                $querySelect = $this->mysql->prepare($sql);
                $querySelect->execute($par);
                while ($row = $querySelect->fetch(PDO::FETCH_ASSOC)) {
                    $arr[$index] = $row;
                    //var_dump($row); 
                    $index++;
                }
                //var_dump($arr);
                if($arr){
                    return $arr;
                }else{
                    return 'Some problems!';
                }
            }else{
                return false;
            }            
        }else{
            if($result){
                return 'Ok!';
            }else{
                return 'There are some problems with data!';
            }
        }
        $query->close();
    }
}