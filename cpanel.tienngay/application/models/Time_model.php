<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Time_model extends CI_Model
{
    private $time;
    private $time_utc;
    private $timestamp;
    private $set_exptime;
    private $now_time;
    function __construct()
    {
        parent::__construct();
    }

    public function create_date($timezone =+ 7)
    {
        try {
            $time = gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I")));
        } catch (Exception $ex) {
            $time = 'now';
        }
        return $time;
    }

    public function getTimeUTC($timezone =+ 0)
    {
        try {
            $time_utc = gmdate("Y/m/j H:i:s", time() + 3600*($timezone+date("I"))) . " (UTC)";
        } catch (Exception $ex) {
            $time_utc = 'now';
        }
        return $time_utc;
    }

    public function checkTokenTime($token_time = '')
    {
        $now_time = $this->convertDatetimeToTimestamp(new DateTime());
        $set_exptime = 60*60*24;
        $expited = $now_time - $token_time;
        if ($expited > $set_exptime) {
            return false;
        } else {
          return true;
      }
  }

  public function convertDatetimeToTimestamp($datetime = '')
  {
    try {
        $timestamp = $datetime->format('U');
    } catch (Exception $ex) {
        $timestamp = '';
    }
    return (int)$timestamp;
//      return (double)(string)$this->time_lib->now()->toMongoDate();
}

public function timeNowStamp($datetime  = '')
{
    try {
        $timestamp = $datetime->format('U');
    } catch (Exception $ex) {
        $timestamp = '';
    }
    return $timestamp;
}

public function convertTimestampToDatetime($timestamp  = '')
{
    $timezone = 7;
    return date('Y/m/d H:i:s', $timestamp + 3600*($timezone+date("I")));
}

public function convertTimestampToDatetime_($timestamp  = '')
{
    return date('Y-m-d', $timestamp);
}

public function getTimePeriod($timeStampNow  = '', $timeStampPosted  = '')
{
    $time = $timeStampPosted - $timeStampNow;
    return $time;
}
}
?>