<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Datasource\ConnectionManager;

class CustomHelper extends Helper
{
    
    public function p($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    public function defaultImage($class,$style)
    {
        $img = "<img style=" .$style. " class=" .$class. " src='img/default-user.png' alt='Default Image' >";
        return $img;
    }

    public function showImage($class,$style,$src)
    {
        $img1 = "<img style=" .$style. " class=" .$class. " src=".$src. ">";
        return $img1;
    }

    public function successMsg()
    {
        $successmsg = "";
        $successmsg .=  '<div class="alert alert-success alert-dismissable" style="display:none;" id="success_msg">';
        $successmsg .= '<b></b> <center> <i class="fa fa-times"></i></center></div>';
        return $successmsg;
    }

    public function errorMsg()
    {
        $errormsg = "";
        $errormsg .= '<div class="alert alert-danger alert-dismissable" style="display:none;" id="error_msg">';
        $errormsg .= '<b></b> <center> <i class="fa fa-times"></i></center></div>';
        return $errormsg;
    }

    public function loadingImg()
    {
        $loading_img = "";
        $loading_img .= '<center><img style="display:none;width:2.2%;" id="loading-img" src="'. $this->request->webroot .'img/loading-spinner-grey.gif" /></center>';
        return $loading_img;
    }

    public function getTimeSlots($i)
    {
        $timesArr = array(
             '0' => "00:00 AM",
             '1' => "01:00 AM",
             '2' => "02:00 AM",
             '3' => "03:00 AM",
             '4' => "04:00 AM",
             '5' => "05:00 AM",
             '6' => "06:00 AM",
             '7' => "07:00 AM",
             '8' => "08:00 AM",
             '9' => "09:00 AM",
             '10' => "10:00 AM",
             '11' => "11:00 AM",
             '12' => "12:00 PM",
             '13' => "01:00 PM",
             '14' => "02:00 PM",
             '15' => "03:00 PM",
             '16' => "04:00 PM",
             '17' => "05:00 PM",
             '18' => "06:00 PM",
             '19' => "07:00 PM",
             '20' => "08:00 PM",
             '21' => "09:00 PM",
             '22' => "10:00 PM",
             '23' => "11:00 PM",
             '24' => "00:00 AM"
            );
        return $timesArr[$i];
    }

    public function getSessionRate($session,$rates_plan)
    {
        $hour_rate = $rates_plan[0]['rate_hour'];
        switch ($session) {
          case '1':
            $discount = $rates_plan[0]['adgust1'];
            break;
          case '3':
            $discount = $rates_plan[0]['adgust2'];
            break;
          case '10':
            $discount = $rates_plan[0]['adgust3'];
            break;
          case '20':
            $discount = $rates_plan[0]['adgust4'];
            break;
          default:
            $discount = "0";
            break;
        }
        $discountBySession = $discount / $session;
        $finalSessionPrice = round($rates_plan[0]['rate_hour'] - $discountBySession,2);
        return $finalSessionPrice;
    }

    public function getHourlyRate($tid)
    {
        $this->conn = ConnectionManager::get('default'); 
        $results = $this->conn->execute('SELECT * FROM `trainer_ratemaster` WHERE `trainer_id` = '.$tid)->fetchAll('assoc');
        if(!empty($results)){
            $hourlyrate = $results[0]['rate_hour'];
        }else{
            $hourlyrate = 0;
        }
        return $hourlyrate;
    }

    public function getCityName($cid)
    {
        $this->conn = ConnectionManager::get('default'); 
        $results = $this->conn->execute('SELECT * FROM `cities` WHERE `id` = '.$cid)->fetchAll('assoc');
        if(!empty($results)){
            $city = $results[0]['name'];
        }else{
            $city = "";
        }
        return $city;
    }

    public function getLatLngUsingIP()
    {
        $data  = file_get_contents(CURRENT_INFO_API.$_SERVER['REMOTE_ADDR']);
        $query = json_decode($data,TRUE);
        if($query && $query['status'] == 'success') {
          return $query;
        } else {
          return array();
        }
    }

    public function getWheatherDetails()
    {
        $own_details = $this->getlatlngbyip();
        $city = $own_details['city'];
        $url  = "http://api.openweathermap.org/data/2.5/weather?q=".$city."&appid=c488325e3fceefdedd2e291d011f63f1";
        $data = @unserialize(file_get_contents($url));
        $json = file_get_contents($url);
        $data = json_decode($json,true);
        if($data['cod'] == 200){
          $response = $data;
        }else{
          $response = array();
        }
        return $response;
    }

    public function getlatlngbyip()
    {
        $data  = file_get_contents(CURRENT_INFO_API.$_SERVER['REMOTE_ADDR']);
        $query = json_decode($data,TRUE);
        return $query;
    }

    public function getTimerDetails($dateTime)
    {
     $date = strtotime($dateTime); 
     $date_now = time();
     $final_date = 24 - ($date_now - $date);
     $response = array(
        'hours'    => date('H', $final_date),
        'minutes' => date('i', $final_date),
        'seconds' => date('s', $final_date)
      );
     return $response;
    }

    public function getImageSrc($img="")
    {
      if(!empty($img)){
          if(file_exists($img)){
            $src = $this->request->webroot.$img;
          }else{
            $src = $this->request->webroot."img/default.png";
          }
      }else{
        $src = $this->request->webroot."img/default.png";
      }
      return $src;    
    }


}

?>