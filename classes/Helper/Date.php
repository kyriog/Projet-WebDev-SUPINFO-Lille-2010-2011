<?php

class Helper_Date {
    public static function humanToTimestamp($time) {
        $time = explode('/',$time);
        $timestamp = mktime(0, 0, 0, $time[1], $time[0], $time[2]);
        return $timestamp;
    }
    
    public static function timestampToHuman($timestamp) {
        $time = date('d/m/Y',$timestamp);
        return $time;
    }
    
    public static function timestampToMysql($timestamp) {
        $mysql = date('Y-m-d', $timestamp);
        return $mysql;
    }
    
    public static function mysqlToTimestamp($mysql) {
        $mysql = explode('-',$mysql);
        $timestamp = mktime(0, 0, 0, $mysql[1], $mysql[0], $mysql[2]);
        return $timestamp;
    }
}

?>
