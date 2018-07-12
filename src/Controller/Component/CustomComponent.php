<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Datasource\ConnectionManager;
use mPDF;

class CustomComponent extends Component
{
    public function fileUploading($name,$subfolder)
    {
        $f_name1 = $_FILES[$name]['name'];
        $f_tmp1 = $_FILES[$name]['tmp_name'];
        $f_size1 = $_FILES[$name]['size'];
        $f_extension1 = explode('.',$f_name1); 
        $f_extension1 = strtolower(end($f_extension1)); 
        $f_newfile1="";
        if($f_name1){
        $f_newfile1 = "VT_".uniqid().'.'.$f_extension1; 
        $store1 = "uploads/".$subfolder."/". $f_newfile1;
        $image2 =  move_uploaded_file($f_tmp1,$store1);
        }
        return $f_newfile1;
    }

    public function getSessionData()
    {
        $session = $this->request->session();
        $user_data = $session->read('Auth.User');
        return $user_data;
    }

    public function deleteFile($fileName,$folderName)
    {
        $path =   "uploads/".$folderName."/".$fileName;
        unlink($path);
    }

    public function downloadFile($file)
    {
        if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($file));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
        }
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

    public function getlatlng($address)
    {
        $loc = array();
        $loc["latitude"] = "";
        $loc["longitude"] = "";
        $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false');
        $geo = json_decode($geo, true);
        if ($geo['status'] == 'OK') {
          $loc["latitude"]  = $geo['results'][0]['geometry']['location']['lat'];
          $loc["longitude"] = $geo['results'][0]['geometry']['location']['lng'];
        }
        else if($geo['status'] == 'ZERO_RESULTS'){
            $data  = file_get_contents(CURRENT_INFO_API.$_SERVER['REMOTE_ADDR']);
            $query = json_decode($data,TRUE);
            $loc["latitude"]  = $query['lat'];
            $loc["longitude"] = $query['lon'];
        }
        else{
            $loc["latitude"]  = "52.1332";
            $loc["longitude"] = "106.6700";
        }
        return $loc;
    }

    public function getlatlngbyip()
    {
        $data  = file_get_contents(CURRENT_INFO_API.$_SERVER['REMOTE_ADDR']);
        $query = json_decode($data,TRUE);
        return $query;
    }

    public function getserverlatlngbyip()
    {
         $ip = $_SERVER['REMOTE_ADDR']; 
        $query = @unserialize(file_get_contents('http://ip-api.com/php/'));
        return $query;
    }

    public function downloadpdf($html,$filename)
    {
        $mpdf = new mPDF();
        $mpdf->WriteHTML($html);
        $mpdf->Output($filename, 'D');
        exit;
    }

    public function exportCSV($fileName,$assocDataArray,$headingArr)
    {
      header('Content-Type: text/csv; charset=utf-8');
      header('Content-Disposition: attachment; filename='.$fileName);
      $output = fopen('php://output', 'w');
      fputcsv($output, $headingArr);
      foreach ($assocDataArray as $key => $value) {
          fputcsv($output, $value);
      }
      exit;
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


    public function getStateName($cid)
    {
        $this->conn = ConnectionManager::get('default'); 
        $results = $this->conn->execute('SELECT * FROM `states` WHERE `id` = '.$cid)->fetchAll('assoc');
        if(!empty($results)){
            $state = $results[0]['name'];
        }else{
            $state = "";
        }
        return $state;
    }


    public function getCountryName($cid)
    {
        $this->conn = ConnectionManager::get('default'); 
        $results = $this->conn->execute('SELECT * FROM `countries` WHERE `id` = '.$cid)->fetchAll('assoc');
        if(!empty($results)){
            $country = $results[0]['name'];
        }else{
            $city = "";
        }
        return $country;
    }

    public function parseTime($time)
    {
        $timeArr = explode("-", $time);
        if(!empty($timeArr)){
            $startTime = $timeArr[0];
            $endTime   = $timeArr[1];
            $startTimeArr = explode(":", $startTime);
            $endTimeArr   = explode(":", $endTime);
            $startTimeArrNew = explode(" ", $startTimeArr[1]);
            $endTimeArrNew   = explode(" ", $endTimeArr[1]);
            $finalStartTime = $startTimeArr[0].":".$startTimeArrNew[0]." ".$startTimeArrNew[1];
            $finalEndTime   = $endTimeArr[0].":".$endTimeArrNew[0]." ".$endTimeArrNew[1];
            $response  = array(
                'start_time' => date('H:i', strtotime($finalStartTime)),
                'end_time'   => date('H:i', strtotime($finalEndTime))
                );
            return $response;
        }else{
            return array();
        }
    }

    public function getTimerDetails($dateTime)
    {
     $date = strtotime($dateTime); 
     $date_now = time();
     $final_date = 24 - ($date_now - $date);
     $response = array(
        'hour'    => date('H', $final_date),
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