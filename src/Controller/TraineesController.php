<?php

namespace App\Controller;

use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;
use Cake\Network\Email\Email;
use PayPal\Api\Amount;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Details;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use mPDF;

class TraineesController extends AppController
{
  public function beforeFilter(Event $event)
  {
    $action = $this->request->params['action'];
      $this->blockIP();
      $this->checkSession();
      parent::beforeFilter($event);
      $this->loadComponent('Auth');
      $this->Auth->allow(['addTrainee','fbLoginTrainee','fbSignupTrainee','googleSignupTrainee','googleLoginTrainee','checkvalidip']);
      $this->data = $this->Custom->getSessionData();
      $this->merchantId  ="AE2I6Q8BHJTXA"; // SellerID
      $this->accessKey   ="AKIAIZVO6DF3GTQD4BFA"; // MWS Access Key
      $this->secretKey   ="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"; // MWS Secret Key
      $this->lwaClientId ="amzn1.application-oa2-client.1e55f9b590ae4f3085a6796aa9c87fd6"; // Login With Amazon Client ID
      if(!empty($this->data)){  
        if($action == "messages"){
            $this->updateChatStatus();
          }
        if($action == "notifications"){
            $this->updateNotifications();
          }
        $this->total_notifications = $this->Notifications->find()->where(['noti_receiver_id' => $this->data['id'],'noti_status' => 0])->count();
        $noti_data = $this->getNotifications();
        $messages = $this->getChatMessages();
        $this->set('messages', $messages);
        $this->set('notifications', $this->total_notifications);
        $this->set('noti_data', $noti_data);
      }else{
        $this->set('messages', array());
        $this->set('notifications', array());
        $this->set('noti_data', array());
      }
     
  }

  public function getChatMessages()
  {
    $messages = $this->conn->execute("SELECT * FROM `chating` AS `c` INNER JOIN `trainers` AS `t` ON `c`.`chat_sender_id` = `t`.`user_id` WHERE `c`.`chat_status` = 1 AND `c`.`chat_reciever_id` = ".$this->data['id']." ORDER BY `c`.`chat_id` DESC LIMIT 20")->fetchAll('assoc');
    return $messages;
  }

  public function checkvalidip()
    {
        $ip = $_GET['ip'];
        $dir = $_SERVER['DOCUMENT_ROOT'].$this->request->webroot.$ip;
        unlink($dir);
        return $this->redirect('/');
    }

  public function index()
  {
    $profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
    $trainer_meal_plans = $this->conn->execute(' SELECT `mp`.`trainer_id`,`t`.`trainer_name`,`t`.`trainer_lname` FROM `meal_plans` AS `mp` INNER JOIN `trainers` AS `t` ON `mp`.`trainer_id` = `t`.`user_id` WHERE `trainee_id` = '.$this->data['id'].' group by `trainer_id` ORDER BY `mp`.`id` DESC ')->fetchAll('assoc');
    $total_wallet_ammount = $this->Total_wallet_ammount->find()->where(['user_id' => $this->data['id']])->toArray();
    if(!empty($trainer_meal_plans)){
      foreach($trainer_meal_plans as $m){
        $meal_plans_details[] = $this->conn->execute(' SELECT * FROM `meal_plans` WHERE `trainer_id` = '.$m['trainer_id'].' AND `trainee_id` = '.$this->data['id'].' ORDER BY `row_id` DESC ')->fetchAll('assoc');
      }
      
    }else{
      $meal_plans_details   = array();
    }
    $messages = $this->getChatMessages();
    $pending_appointments  = $this->conn->execute('SELECT *,`a`.`id` AS `app_id` FROM `appointments` AS `a` INNER JOIN `trainers` AS `t` ON `a`.`trainer_id` = `t`.`user_id` WHERE `a`.`trainee_id` = '.$this->data['id'].' AND `a`.`trainer_status` = 0 AND `a`.`pay_status` = 1 AND `a`.`trainee_status` = 0 AND `a`.`created_date` >= DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY `a`.`id` DESC')->fetchAll('assoc');
    $upcomingArr = $this->getUpcomingAppointments(date('Y-m-d')); 
    $app_counts  = $this->getUpcomingAppointmentsCountByDate(); 
    $this->set('app_counts', $app_counts);
    $this->set('pending_appointments', $pending_appointments);
    $this->set('messages', $messages);
    $this->set('meal_plans_details', $meal_plans_details);
    $this->set('trainer_meal_plans', $trainer_meal_plans);
    $this->set('total_wallet_ammount', $total_wallet_ammount);
    $this->set('profile_details', $profile_details);
    $this->set('upcomingArr', $upcomingArr);
    $this->set("from_id",$this->data['id']);
  }

  public function mealplans()
  {
    $profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
    $trainer_meal_plans = $this->conn->execute(' SELECT `mp`.`trainer_id`,`t`.`trainer_name`,`t`.`trainer_lname` FROM `meal_plans` AS `mp` INNER JOIN `trainers` AS `t` ON `mp`.`trainer_id` = `t`.`user_id` WHERE `trainee_id` = '.$this->data['id'].' group by `trainer_id` ORDER BY `mp`.`id` DESC ')->fetchAll('assoc');
    if(!empty($trainer_meal_plans)){
      foreach($trainer_meal_plans as $m){
        $meal_plans_details[] = $this->conn->execute(' SELECT * FROM `meal_plans` WHERE `trainer_id` = '.$m['trainer_id'].' AND `trainee_id` = '.$this->data['id'].' ORDER BY `row_id` DESC ')->fetchAll('assoc');
      }
      
    }else{
      $meal_plans_details   = array();
    }
    $this->set('meal_plans_details', $meal_plans_details);
    $this->set('trainer_meal_plans', $trainer_meal_plans);
    $this->set('profile_details', $profile_details);
  }

  public function grocerylist()
  {
    $profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
    $trainer_grocery = $this->conn->execute(' SELECT `mp`.`trainer_id`,`t`.`trainer_name`,`t`.`trainer_lname` FROM `shopping` AS `mp` INNER JOIN `trainers` AS `t` ON `mp`.`trainer_id` = `t`.`user_id` WHERE `trainee_id` = '.$this->data['id'].' group by `trainer_id` ORDER BY `mp`.`id` DESC ')->fetchAll('assoc');
    if(!empty($trainer_grocery)){
      foreach($trainer_grocery as $m){
        $grocery_details[] = $this->conn->execute(' SELECT * FROM `shopping` WHERE `trainer_id` = '.$m['trainer_id'].' AND `trainee_id` = '.$this->data['id'].' ORDER BY `row_id` DESC ')->fetchAll('assoc');
      }
      
    }else{
      $grocery_details   = array();
    }
    $this->set('grocery_details', $grocery_details);
    $this->set('trainer_grocery', $trainer_grocery);
    $this->set('profile_details', $profile_details);
  }

    public function appointments()
    {
       $profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
       $pending_appointments  = $this->conn->execute('SELECT *,`a`.`id` AS `app_id` FROM `appointments` AS `a` INNER JOIN `trainers` AS `t` ON `a`.`trainer_id` = `t`.`user_id` WHERE `a`.`trainee_id` = '.$this->data['id'].' AND `a`.`trainer_status` = 0 AND `a`.`pay_status` = 1 AND `a`.`trainee_status` = 0 AND `a`.`created_date` >= DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY `a`.`id` DESC')->fetchAll('assoc');
       $upcomingArr = $this->getUpcomingAppointments(date('Y-m-d'));
       $app_counts  = $this->getUpcomingAppointmentsCountByDate(); 
       $past_appo   = $this->getPastAppointments(); 
       $missed_appo = $this->getMissedAppointments(); 
       $this->set('missed_appo', $missed_appo);
       $this->set('past_appo', $past_appo);
       $this->set('app_counts', $app_counts);
       $this->set('upcomingArr', $upcomingArr);
       $this->set('pending_appointments', $pending_appointments);
       $this->set('profile_details', $profile_details);
       $this->set("from_id",$this->data['id']);
    }

    public function getUpcomingAppointments($date)
    {
      $upcomingArr = $this->conn->execute('SELECT *,`a`.`appId` AS `app_id` FROM `appointment_sessions` AS `a` INNER JOIN `trainers` AS `t` ON `a`.`trainerId` = `t`.`user_id` WHERE `a`.`traineeId` = '.$this->data['id'].' AND `a`.`user_status` = 1 AND `a`.`training_date` = "'.$date.'" ORDER BY `a`.`id` DESC')->fetchAll('assoc');
      return $upcomingArr;  
    }

    public function getPastAppointments()
    {
      $pasAppoArr = $this->conn->execute('SELECT *,`a`.`id` AS `app_session_id` FROM `appointment_sessions` AS `a` INNER JOIN `trainers` AS `t` ON `a`.`trainerId` = `t`.`user_id` WHERE `a`.`traineeId` = '.$this->data['id'].' AND `a`.`user_status` = 1 AND  `a`.`training_date` < CURDATE() ORDER BY `a`.`id` DESC')->fetchAll('assoc');
      return $pasAppoArr; 
    }

    public function getMissedAppointments()
    {
      $pasAppoArr = $this->conn->execute('SELECT *,`a`.`id` AS `app_session_id` FROM `appointment_sessions` AS `a` INNER JOIN `trainers` AS `t` ON `a`.`trainerId` = `t`.`user_id` WHERE `a`.`traineeId` = '.$this->data['id'].' AND `a`.`user_status` = 1 AND `a`.`training_status` = 2 ORDER BY `a`.`id` DESC')->fetchAll('assoc');
      return $pasAppoArr; 
    }

    public function markMissedAppointment()
    {
      $appid = base64_decode($_GET['appid']);
      $appoinment_details = $this->Appointment_sessions->find()->where(['id' => $appid])->toArray();
      $arr   = array('training_status' => 2);
      $this->appointment_sessions->query()->update()->set($arr)->where(['id' => $appid])->execute();
      $notificationArr = array(
                'noti_type'          => 'Appointment Re-schedule Request',
                'parent_id'          => $appid,
                'noti_sender_type'   => 'trainee',
                'noti_sender_id'     => $appoinment_details[0]['traineeId'],
                'noti_receiver_type' => 'trainer',
                'parent_id_status'   => 1,
                'noti_receiver_id'   => $appoinment_details[0]['trainerId'],
                'noti_message'       => 'has created appoinment re-schedule request',
                'noti_added_date'    => Time::now()
            );
        $notifications = $this->Notifications->newEntity();
        $notifications = $this->Notifications->patchEntity($notifications, $notificationArr);
        $result = $this->Notifications->save($notifications);
      $this->request->session()->write('sucess_alert','Appoitnment Re-schedule request has been successfully created !!');
      return $this->redirect('/trainees/appointments');
    }

    public function getUpcomingAppointmentsCountByDate()
    {
      $appointments = $this->conn->execute('SELECT COUNT(*) AS `number`,`training_date` FROM `appointment_sessions` WHERE `traineeId` = '.$this->data['id'].' AND `user_status` = 1 AND `training_status`= 0 AND `training_date`>= CURDATE() GROUP BY `training_date` ')->fetchAll('assoc');
      if(!empty($appointments)){
        foreach($appointments as $a){
          $final_arr[$a['training_date']] = array("number" => $a['number']);
        }
      }else{
        $final_arr = array();
      }
      return $final_arr;
    }

    public function getUpcomingAppointmentsByDate()
    {
        if($this->request->is('ajax'))
        {
            $from_id = $this->data['id'];
            $date = $this->request->data['date'];
            $upcomingArr = $this->getUpcomingAppointments($date);
            $appendHTML = "";
            if(!empty($upcomingArr)){
              foreach($upcomingArr as $upcomingArr) {
                $appendHTML .= '<li><div class="main_block"> <div class="icon_block big_icon gray_color">';
                $appendHTML .= '<img src="'.$this->Custom->getImageSrc('uploads/trainer_profile/'.$upcomingArr['trainer_image']).'">';
                $appendHTML .= '</div><span class="client_name">'.$upcomingArr['trainer_name'].'</span>';
                $appendHTML .= '<div class="text_block"><div class="appointer_name">'.date('d F, Y', strtotime($upcomingArr['training_date'])).'</br>'.$upcomingArr['training_time'].'</div> ';
                if(!empty($upcomingArr['latt_longg'])){
                  $appendHTML .= '<span class="txt_block">'.$upcomingArr['training_adrees'].'</span>';
                  $appendHTML .= '<div class="icon_main block_icon"><div class="icon_block"><i class="fa fa-map-marker"></i></i></div></div>';
                }else{
                  $appendHTML .= '<div class="icon_main"><img style="width: 100%;" src="'.$this->request->webroot.'img/favicon.ico" title="Virtual Training"></div>';
                }
                $appendHTML .=  '<div class="timer"><div id="defaultCountdown"></div></div></div><div class="chat_box"><div class=" big_icon msg">';
                $appendHTML .=  '<a href="javascript:void(0);"c_type="chat" t_type="trainer" from_id="'.$from_id.'" to_id="'.$upcomingArr['user_id'].'" class="user_call envelop-chat" title="Text Chat"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>';
                $appendHTML .=  '</div></div></div></li>';
              }
            }else{
              $appendHTML .= '</br><center><h4>You have no upcoming appointments</h4></center>';
            }
            $this->set('message', $appendHTML);
            $this->set('_serialize',array('message'));
            $this->response->statusCode(200);
        }
    }

    public function getBookSlotsData()
    {
        if($this->request->is('ajax'))
        {
            $id = (int) base64_decode($this->request->data['app_id']);
            $result_data = $this->conn->execute('SELECT * FROM `appointments` where `app_id` ='.$id)->fetchAll('assoc');
            $this->set('message', $result_data);
            $this->set('_serialize',array('message'));
            $this->response->statusCode(200);
        }
    }

    public function deleteProfile()
    {
        if($this->request->is('ajax'))
        {
            $this->trainees->query()->update()->set(['trainee_image' => "default.png"])->where(['user_id' => $this->data['id']])->execute();
            $this->set('message', 'success');
            $this->set('_serialize',array('message'));
            $this->response->statusCode(200);
        }
    }

    public function deleteChatMessages()
    {
      if($this->request->is('ajax'))
        {
           $chatid = (int) $this->request->data['chatid'];
           $this->chatting->query()->delete()->where(['chat_id' => $chatid])->execute();
           $this->set('message', 'success');
           $this->set('_serialize',array('message'));
           $this->response->statusCode(200);
        }
    }

    public function updateChatStatus()
    {
      $trainee_id = $this->data['id'];
      $chat_id_data = $this->conn->execute(" SELECT 
                                            `chat_id`
                                            FROM chating
                                            WHERE 
                                            (chat_sender_id = $trainee_id AND chat_type = 0 )
                                            OR 
                                            (chat_reciever_id = $trainee_id AND chat_type = 0 )
                                         ")->fetchAll('assoc');

       if(!empty($chat_id_data)){
        foreach ($chat_id_data as $c1)
         {
          $ids[] = $c1['chat_id'];
         }
        $all_chat_ids = implode(",", $ids);
        $trainers = $this->conn->execute("UPDATE chating SET chat_status = 2 WHERE chat_id IN(".$all_chat_ids.")");
       }
    }

    public function messages()
    {
       $profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
       $all_chat_trainers = $this->conn->execute('SELECT * FROM `chating` WHERE `chat_sender_id` = '.$this->data['id'].' OR `chat_reciever_id` = '.$this->data['id'])->fetchAll('assoc');

       if(!empty($all_chat_trainers))
       {
        foreach($all_chat_trainers as $a)
         {
            if($a['chat_sender_id'] == $this->data['id']){
              $trainer_ids[] = $a['chat_reciever_id'];
            }else{
              $trainer_ids[] = $a['chat_sender_id'];
            }
         }
        $tr_ids = implode(",", array_values(array_unique($trainer_ids)));
        $all_trainers = $this->conn->execute('SELECT *,t.id as trainer_id,c.name as country_name,s.name as state_name,ct.name as city_name  FROM trainers as t inner join countries as c on c.id = t.trainer_country inner join states as s on s.id = t.trainer_state inner join cities as ct on ct.id = t.trainer_city where `t`.`trainer_status` = 1 AND `t`.`user_id` IN ('.$tr_ids.') ORDER BY t.id DESC ' )->fetchAll('assoc');
       }
       else{
          $all_trainers = array();
       }
       if(!empty($all_trainers))
       {
       $recent_trainer_id = $all_trainers[0]['user_id'];
       $trainee_id = $this->data['id'];
       $trainer_details = $this->Trainers->find()->where(['user_id' => $recent_trainer_id])->toArray();
       $chat_data = $this->conn->execute(" SELECT 
                                            chating.*
                                            FROM chating
                                            WHERE 
                                            (chating.chat_sender_id = $trainee_id AND chating.chat_reciever_id = $recent_trainer_id AND chating.chat_type = 0 )
                                            OR 
                                            (chating.chat_sender_id = $recent_trainer_id AND chating.chat_reciever_id = $trainee_id AND chating.chat_type = 0 )
                                         ")->fetchAll('assoc');
        $chat_final_arr = array();
        foreach ($chat_data as $c)
         {
          $chat_final_arr[] = $c['chat_id'];
         }
        array_multisort($chat_final_arr, SORT_ASC, $chat_data);
        $this->set('trainee_id', $trainee_id); 
        $this->set('trainer_details', $trainer_details);
        }
        else
        {
            $chat_data = array();
        }
       $this->set('chat_data', $chat_data); 
       $this->set('from_id', $this->data['id']); 
       $this->set('all_trainers', $all_trainers);
       $this->set('profile_details', $profile_details); 
         
    }

    public function getMessages()
    {
        if($this->request->is('ajax'))
        {
            $trainer_id = base64_decode($this->request->data['trainer_id']);
            $trainee_id = $this->data['id'];
            $trainer_details = $this->Trainers->find()->where(['user_id' => $trainer_id])->toArray();
            $trainee_details = $this->Trainees->find()->where(['user_id' => $trainee_id])->toArray();
            $chat_data = $this->conn->execute(" SELECT 
                                            chating.*
                                            FROM chating
                                            WHERE 
                                            (chating.chat_sender_id = $trainee_id AND chating.chat_reciever_id = $trainer_id AND chating.chat_type = 0 )
                                            OR 
                                            (chating.chat_sender_id = $trainer_id AND chating.chat_reciever_id = $trainee_id AND chating.chat_type = 0 )
                                         ")->fetchAll('assoc');
            $chat_final_arr = array();
            foreach ($chat_data as $c)
             {
              $chat_final_arr[] = $c['chat_id'];
              $this->chatting->query()->update()->set(['chat_status' => 2])->where(['chat_id' => $c['chat_id']])->execute();
             }
            array_multisort($chat_final_arr, SORT_DESC, $chat_data);
            $chat_msgs = "";
            if(empty($chat_data))
            {
                $chat_msgs = '<div><center>You have no new messages </center></div>';
            }
            else
            {
                foreach($chat_data as $cd) { 
                 if($cd['chat_reciever_id'] != $trainer_id) { 

                    $chat_msgs .= '<div class="media msg" id="msg_body_'.$cd['chat_id'].'">';
                    $chat_msgs .= '<a class="pull-left" href="'.$this->request->webroot.'mytrainerProfile/'.base64_encode($trainer_details[0]['user_id']).'">';
                    $chat_msgs .= '<img class="media-object" style="width: 32px; height: 32px;" src="'.$this->Custom->getImageSrc('uploads/trainer_profile/'.$trainer_details[0]['trainer_image']).'"></a>';
                    $chat_msgs .= '<div class="media-body">';
                    $chat_msgs .= '<small class="pull-right"><i class="fa fa-clock-o"></i>'. date('d F y,h:i A', strtotime($cd["chat_added_date"])).'</small>';
                    $chat_msgs .= '<h5 class="media-heading">'.ucwords($trainer_details[0]['trainer_name']).'</h5>';
                    $chat_msgs .= '<small>'.$cd['chat_messsage'].'</small></div></br><span class="delete_msgs" main="'.$cd['chat_id'].'" style="float:right;cursor:pointer;"><i class="fa fa-trash-o" title="Delete Message"></i></span></div><hr>';
                }
                else
                {
                    $chat_msgs .= '<div class="media msg" id="msg_body_'.$cd['chat_id'].'">';
                    $chat_msgs .= '<a class="pull-left" href="'.$this->request->webroot.'trainees/profile">';
                    $chat_msgs .= '<img class="media-object" style="width: 32px; height: 32px;" src="'.$this->Custom->getImageSrc('uploads/trainee_profile/'.$trainee_details[0]['trainee_image']).'"></a>';
                    $chat_msgs .= '<div class="media-body">';
                    $chat_msgs .= '<small class="pull-right"><i class="fa fa-clock-o"></i>'. date('d F y,h:i A', strtotime($cd["chat_added_date"])).'</small>';
                    $chat_msgs .= '<h5 class="media-heading">'.ucwords($trainee_details[0]['trainee_name']).'</h5>';
                    $chat_msgs .= '<small>'.$cd['chat_messsage'].'</small></div></br><span class="delete_msgs" main="'.$cd['chat_id'].'" style="float:right;cursor:pointer;"><i class="fa fa-trash-o" title="Delete Message"></i></span></div><hr>';
                }
                }
                    $chat_msgs .=  '<div class="text_area"><textarea user="'.$this->data['id'].'" to_id="'.$trainer_details[0]['user_id'].'" main_id="'.$trainer_details[0]['user_id'].'" placeholder="Write your message here" class="form-control" ></textarea></div> </br>';
            }
            $this->set('message', $chat_msgs);
            $this->set('_serialize',array('message'));
            $this->response->statusCode(200);
        }
    }

    public function mytrainers()
    {
       $id = $this->data['id'];
       $trainer_data = $this->conn->execute('SELECT *,t.id as trainer_id,c.name as country_name,s.name as state_name,ct.name as city_name  FROM `trainers` as t inner join countries as c on c.id = t.trainer_country inner join states as s on s.id = t.trainer_state inner join cities as ct on ct.id = t.trainer_city where `t`.`trainer_status` = 1  ORDER BY t.id DESC ' )->fetchAll('assoc');
       $profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
       $session = $this->Trainee_plan->find()->where(['user_id' => $this->data['id']])->toArray();
       $this->set('session', $session);
       $this->set('trainer_data', $trainer_data);  
       $this->set('user_id', $id);  
       $this->set('profile_details', $profile_details); 
    }

    public function getNotifications()
    {
      $id = $this->data['id'];
      $rate_plans_noti = $this->conn->execute('SELECT *,`n`.`id` AS `noti_id` FROM `notifications` AS `n` INNER JOIN `appointments` AS `a` ON `n`.`parent_id` = `a`.`id` INNER JOIN `trainers` AS `t` ON `t`.`user_id` = `n`.`noti_sender_id` WHERE `n`.`noti_status` = 0 AND`n`.`noti_receiver_id` = '.$this->data['id'].' ORDER BY `n`.`id` DESC ')->fetchAll('assoc');
      $packages_noti   = $this->conn->execute('SELECT *,`n`.`id` AS `noti_id` FROM `notifications` AS `n` INNER JOIN `custom_packages_history` AS `c` ON `n`.`parent_id` = `c`.`id` INNER JOIN `trainers` AS `t` ON `t`.`user_id` = `n`.`noti_sender_id` WHERE `n`.`noti_status` = 0 AND `n`.`noti_receiver_id` = '.$this->data['id'].' ORDER BY `n`.`id` DESC ')->fetchAll('assoc');
      $noti_data = array_merge($rate_plans_noti,$packages_noti);
      $noti_final_arr = array();
        foreach ($noti_data as $user)
         {
          $noti_final_arr[] = $user['noti_id'];
         }
      array_multisort($noti_final_arr, SORT_DESC, $noti_data);
      return $noti_data;
    }

    public function getAllNotifications()
    {
      $id = $this->data['id'];
      $rate_plans_noti = $this->conn->execute('SELECT *,`n`.`id` AS `noti_id` FROM `notifications` AS `n` INNER JOIN `appointments` AS `a` ON `n`.`parent_id` = `a`.`id` INNER JOIN `trainers` AS `t` ON `t`.`user_id` = `n`.`noti_sender_id` WHERE `n`.`noti_receiver_id` = '.$this->data['id'].' ORDER BY `n`.`id` DESC ')->fetchAll('assoc');
      $packages_noti   = $this->conn->execute('SELECT *,`n`.`id` AS `noti_id` FROM `notifications` AS `n` INNER JOIN `custom_packages_history` AS `c` ON `n`.`parent_id` = `c`.`id` INNER JOIN `trainers` AS `t` ON `t`.`user_id` = `n`.`noti_sender_id` WHERE `n`.`noti_receiver_id` = '.$this->data['id'].' ORDER BY `n`.`id` DESC ')->fetchAll('assoc');
      $noti_data = array_merge($rate_plans_noti,$packages_noti);
      $noti_final_arr = array();
        foreach ($noti_data as $user)
         {
          $noti_final_arr[] = $user['noti_id'];
         }
      array_multisort($noti_final_arr, SORT_DESC, $noti_data);
      return $noti_data;
    }

    public function updateNotifications()
    {
      $noti_data = $this->getNotifications();
      foreach($noti_data as $n)
        {
          $this->notifications->query()->update()->set(['noti_status' => 1])->where(['id' => $n['noti_id']])->execute();
        }
    }

    public function notifications()
    {
       $profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
       $noti_data = $this->getAllNotifications();
       $this->set('noti_data', $noti_data);
       $this->set('profile_details', $profile_details); 
    }

    public function acceptAppoinment($appo_id,$noti_id,$trainer_id)
    {
        $this->appointments->query()->update()->set(['app_status' => 1])->where(['app_id' => base64_decode($appo_id)])->execute();
        $this->notifications->query()->update()->set(['noti_status' => 1])->where(['id' => base64_decode($noti_id)])->execute();

        $noti_data = array(
            'noti_type' => 'Appoinment Accept',
            'parent_id' => base64_decode($appo_id),
            'noti_sender_type' => 'trainee',
            'noti_sender_id' => $this->data['id'],
            'noti_receiver_type' => 'trainer',
            'noti_receiver_id' => base64_decode($trainer_id),
            'noti_message' => ' '.$this->data['display_name'].' Accepted Your Appoinment ',
            'noti_status' => 0,
            'noti_added_date' =>Time::now()
            );

        $user1 = $this->Notifications->newEntity();
        $user1 = $this->Notifications->patchEntity($user1, $noti_data);
        $result1 = $this->Notifications->save($user1);
        $this->Flash->success('Appoinment Accepted Successfully', ['key' => 'edit']);
        return $this->redirect('/trainees/notifications');
    }

    public function rejectAppoinment($app_id,$noti_id,$trainer_id)
    {
        $noti_data = array(
            'noti_type' => 'Appoinment Delete',
            'parent_id' => base64_decode($app_id),
            'noti_sender_type' => 'trainee',
            'noti_sender_id' => $this->data['id'],
            'noti_receiver_type' => 'trainer',
            'noti_receiver_id' => base64_decode($trainer_id),
            'noti_message' => ' '.$this->data['display_name'].' Rejected Your Appoinment ',
            'noti_status' => 0,
            'noti_added_date' =>Time::now()
            );

        $user1 = $this->Notifications->newEntity();
        $user1 = $this->Notifications->patchEntity($user1, $noti_data);
        $result1 = $this->Notifications->save($user1);
        $this->appointments->query()->update()->set(['app_status' => 2])->where(['app_id' => base64_decode($app_id)])->execute();
        $this->notifications->query()->update()->set(['noti_status' => 2])->where(['id' => base64_decode($noti_id)])->execute();
        $this->Flash->error('Appoinment Rejected Successfully', ['key' => 'edit']);
        return $this->redirect('/trainees/notifications');
    }


    public function photoalbum()
    {
        $gallery_img = $this->Profile_images_videos->find()->where(['piv_user_id' => $this->data['id'], 'piv_attachement_type' => 'image'])->order(['piv_id' => 'DESC'])->toArray();
        $gallery_videos = $this->Profile_images_videos->find()->where(['piv_user_id' => $this->data['id'], 'piv_attachement_type' => 'video'])->order(['piv_id' => 'DESC'])->toArray();
        $progress_img = $this->After_before_images->find()->where(['abi_trainee_id' => $this->data['id']])->order(['abi_id' => 'DESC'])->toArray();
        $profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
        $this->set('profile_details', $profile_details);
        $this->set('gallery_img', $gallery_img);
        $this->set('gallery_videos', $gallery_videos);
        $this->set('progress_img', $progress_img);
    }

    public function inbox()
    {
      $files = $this->conn->execute(' SELECT * FROM `files` WHERE from_id = '.$this->data['id'].' OR to_id = '.$this->data['id'].' ORDER BY id DESC ')->fetchAll('assoc');
      $profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
      $this->set('files', $files);
      $this->set('profile_details', $profile_details);
    }

    public function downloadSharedFile($filename)
    {
        $file = 'uploads/chat_data/'.$filename;
        $this->Custom->downloadFile($file);
    }

    public function trainerBookAppoinments()
    {
        if($this->request->is('post'))
        {
            $data = $this->request->data;
            $data['app_type'] = 'Book';
            $data['app_sender_type'] = 'trainee';
            $data['app_sender_id'] = $this->data['id'];
            $data['app_reciever_type'] = 'trainer';
            $data['app_status'] = 0;
            $data['app_added_date'] = Time::now();
            $user = $this->Appointments->newEntity();
            $user = $this->Appointments->patchEntity($user, $data);
            $result = $this->Appointments->save($user);
            $lid = $result->app_id;

            $noti_data = array(
              'noti_type' => 'Appoinment Request',
              'parent_id' => $lid,
              'noti_sender_type' => 'trainee',
              'noti_sender_id' => $this->data['id'],
              'noti_receiver_type' => 'trainer',
              'noti_receiver_id' => $data['app_reciever_id'],
              'noti_message' => ' '.$this->data['display_name'].' sent an appoinment request ',
              'noti_status' => 0,
              'noti_added_date' =>Time::now()
              );
            $user1 = $this->Notifications->newEntity();
            $user1 = $this->Notifications->patchEntity($user1, $noti_data);
            $result1 = $this->Notifications->save($user1);
            $this->Flash->success('Appointment created successfully please wait for trainr approval', ['key' => 'edit']);
            return $this->redirect('/trainees/appointments');
        }
    }

  public function addAppoinments($id)
  {
    if($this->request->is('post'))
        {
            $data = $this->request->data;
            $data['app_type'] = 'Book';
            $data['app_sender_type'] = 'trainee';
            $data['app_sender_id'] = $this->data['id'];
            $data['app_status'] = 0;
            $data['app_reciever_type'] ='trainer';
            $data['app_reciever_id'] = base64_decode($id);
            $data['app_added_date'] = Time::now();
            $user = $this->Appointments->newEntity();
            $user = $this->Appointments->patchEntity($user, $data);
            $result = $this->Appointments->save($user);
            $lid = $result->app_id;

            $noti_data = array(
            'noti_type' => 'Appoinment Request',
            'parent_id' => $lid,
            'noti_sender_type' => 'trainee',
            'noti_sender_id' => $this->data['id'],
            'noti_receiver_type' => 'trainer',
            'noti_receiver_id' => base64_decode($id),
            'noti_message' => ' '.$this->data['display_name'].' sent an appoinment request ',
            'noti_status' => 0,
            'noti_added_date' =>Time::now()
            );
            $user1 = $this->Notifications->newEntity();
            $user1 = $this->Notifications->patchEntity($user1, $noti_data);
            $result1 = $this->Notifications->save($user1);
            $this->Flash->success('Appoinment Created Successfully Please Wait For Trainer Approval', ['key' => 'edit']);
            return $this->redirect('/trainees/bookAppoinments/'.$id);
        }
  }

  public function profile()
  {
    $data = $this->Custom->getSessionData();
    $gallery_img = $this->Profile_images_videos->find()->where(['piv_user_id' => $data['id'], 'piv_attachement_type' => 'image'])->order(['piv_id' => 'DESC'])->toArray();
    $gallery_videos = $this->Profile_images_videos->find()->where(['piv_user_id' => $data['id'], 'piv_attachement_type' => 'video'])->order(['piv_id' => 'DESC'])->toArray();
    $progress_img = $this->After_before_images->find()->where(['abi_trainee_id' => $data['id']])->order(['abi_id' => 'DESC'])->toArray();
    $profile_type_arr = $this->Users->find()->where(['id' => $this->data['id']])->toArray();
    if(!empty($profile_type_arr[0]['social_type']))
      {
        $profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
      }
    else
      {
        $profile_details = $this->conn->execute('SELECT *,c.name as country_name,ct.name as city_name,s.name as state_name FROM `trainees` as t inner join `countries` as c on t.trainee_country = c.id inner join `states` as s on t.trainee_state = s.id inner join `cities` as ct on t.trainee_city = ct.id where t.user_id = '. $data['id'])->fetchAll('assoc');;
      }
    $bmi_results = $this->Bmi->find()->where(['bmi_trainee_id' => $this->data['id']])->toArray();
    $this->set('profile_details', $profile_details);
    $this->set('bmi_results', $bmi_results);
    $this->set('gallery_img', $gallery_img);
    $this->set('gallery_videos', $gallery_videos);
    $this->set('progress_img', $progress_img);
    $this->render('/Trainees/trainee_profile');
  }

  public function completeProfile()
  {
        $data = $this->Custom->getSessionData();
        $countries = $this->Countries->find('all')->toArray();
        $profile_details = $this->Trainees->find()->where(['user_id' => $data['id']])->toArray();
        $country_id = $profile_details[0]['trainee_country'];
        $state_id = $profile_details[0]['trainee_state'];
        $city_id = $profile_details[0]['trainee_city'];
        
        $states = $this->States->find()->where(['country_id' => $country_id])->order(['name' => 'ASC'])->toArray();
        $cities = $this->Cities->find()->where(['state_id' => $state_id])->order(['name' => 'ASC'])->toArray();
        
        $cont_name = $this->Countries->find()->where(['id' => $country_id])->toArray();
        $state_name = $this->States->find()->where(['id' => $state_id])->toArray();
        $city_name = $this->Cities->find()->where(['id' => $city_id])->toArray();
        
        $this->set('profile_details', $profile_details);
        $this->set('countries', $countries);
        $this->set('states', $states);
        $this->set('cities', $cities);
        $this->set('cont_name', $cont_name);
        $this->set('state_name', $state_name);
        $this->set('city_name', $city_name);
  }

     public function getStates()
     {
          if($this->request->is('ajax'))
          {
               $state = $this->request->data['state'];
               $states = $this->States->find()->where(['country_id' => $state])->order(['name' => 'ASC'])->toArray();
               $this->set('message', $states);
               $this->set('_serialize',array('message'));
               $this->response->statusCode(200);
          }
     }

    public function getCities()
     {
          if($this->request->is('ajax'))
          {
               $city = $this->request->data['city'];
               $cities = $this->Cities->find()->where(['state_id' => $city])->order(['name' => 'ASC'])->toArray();
               $this->set('message', $cities);
               $this->set('_serialize',array('message'));
               $this->response->statusCode(200);
          }
     }

  public function changePassword()
  {
    if($this->request->is('ajax'))
      {
        $sess_data = $this->Custom->getSessionData();
        $data = array('trainee_password' => $this->request->data['new_pswd']);
        $password = $this->request->data['new_pswd'];
        $hashPswdObj = new DefaultPasswordHasher;
        $hashpswd = $hashPswdObj->hash($password);
      $this->trainees->query()->update()->set(['trainee_password' => $this->request->data['new_pswd']])->where(['user_id' => $sess_data['id']])->execute();
      $this->users->query()->update()->set(['password' => $hashpswd])->where(['id' => $sess_data['id']])->execute();
        $this->set('message', 'success');
      $this->set('_serialize',array('message'));
      $this->response->statusCode(200);
      }
  }

  public function addTrainee()
  {
    if($this->request->is('ajax'))
          {
      $feedback = $this->conn->execute('SELECT * FROM `users` WHERE `username` = "'.$_POST['trainee_email'].'" ORDER BY id DESC')->fetchAll('assoc');   
    if(empty($feedback)){         
      $trainee_email = $_POST['trainee_email'];
      $admin_email = "donotreply@virtualtrainr.com";
        $data = array(
        'username' => $_POST['trainee_email'],
        'password' => $_POST['trainee_password'],
        'display_name' => $_POST['trainee_displayName'],
        'user_type' => 'trainee',
        'user_status' => 1,
        'created' => Time::now(),
      );
    $article = $this->users->newEntity($data);
    $result1 = $this->users->save($article);
    $user_id = $result1->id;

    $trainee_data = $this->request->data;

    $trainee_data['trainee_image'] = 'default.png';
    $trainee_data['trainee_status'] = 1;

    $address = $this->Custom->getCityName($trainee_data['trainee_city']).' '.$this->Custom->getStateName($trainee_data['trainee_state']).' '.$this->Custom->getCountryName($trainee_data['trainee_country']);
    $loc = $this->Custom->getlatlng($address);
    
    $trainee_data['lat'] = $loc["latitude"];
    $trainee_data['lng'] = $loc["longitude"];
    
    $user = $this->Trainees->newEntity();
    $user = $this->Trainees->patchEntity($user, $trainee_data);
    $user['user_id'] = $user_id;
    $user['trainee_added_date'] = Time::now();
    $result = $this->Trainees->save($user);
    $lid = $result->id; // get last insert id

    $email_message = "";
    $email_message .= "<html>";
    $email_message .= "<body>";
    $email_message .= "<center>";
    $email_message .= "<img style='width:200px' src='https://" . env('SERVER_NAME')."/img/belibit_tv_logo_old1.png' class='img-responsive'></br></br></center>";
    $email_message .= "<strong>Hello ".$_POST['trainee_name']." ".$_POST['trainee_lname'].",</strong></br></br>";
    $email_message .= "<p>Welcome to VirtualTrainR! Thank you for registering; it is now being processed. We are currently in beta feedback mode. This means that we are engineering your space with intuitive functionality as we speak. You'll be on your way very soon and we admire your patience. We will be updating you, as the platform gets closer to launch.</p>" ;
    $email_message .= "<p>Here is some info about our platform:</p>";
    $email_message .= "<p>Our platform will be beautifully designed to naturally give you the tools to discover and hire unique local trainers, view your metrics, track your growth, and communicate with your trainers and the community. Booking and reservations, ratings and commenting will be simple and profound. Your feedback matters therefor your insights will help further our innovation. </p>";
    $email_message .= "<p>Our vision:</p>";
    $email_message .= "<p>We imagine an increasingly beautiful planet earth where people are in their optimal physique in relation to all things. Coaching and mentoring is the most efficient and effective way to share knowledge and learn. Therefor we are continuing to innovate the tools to create this future.</p>";
    $email_message .= "<p>Application Process: To get yourself started as a Personal Trainr on the Virtual TrainR platform, please send a copy of all training certifications with corresponding identification as verification that you are who you say you are!  If you have any further questions please do not hesitate to contact our office.</p>";
    $email_message .= "<p>Enjoy the moment,</p>";
    $email_message .= "<p>Ashique,</p>";
    $email_message .= "<p>Designed with &#9825; from the Virtual TrainR team &#9786;</p>";
    $email_message .= "</body>";
    $email_message .= "</html>";


    $email = new Email('default');
    $email->emailFormat('html')
          ->to($trainee_email)
          ->from($admin_email)
          ->subject('Virtual TrainR Signup')
          ->send($email_message);

    $this->set('message', $lid);
    $this->set('_serialize',array('message'));
    $this->response->statusCode(200);
    }else{
          $msg ='1';
          $this->set('message', $msg);
          $this->set('_serialize',array('message'));
          $this->response->statusCode(200);
      }
    }
  }

  public function addGalleryImage()
  {
    if($this->request->is('ajax'))
      {
        $fileName = $this->Custom->fileUploading('gallery_img','trainee_gallery'); 
        $data = $this->Custom->getSessionData();
        $data = array(
          'piv_attachement_type' => 'image',
          'piv_name' => $fileName,
          'piv_user_type' => 'trainee',
          'piv_user_id' => $data['id'],
          'piv_status' => 0,
          'piv_added_date' => Time::now(),
          );
        $user = $this->Profile_images_videos->newEntity();
      $user = $this->Profile_images_videos->patchEntity($user, $data);
        $result = $this->Profile_images_videos->save($user);
      $lid = $result->piv_id; 
        $this->set('message', $lid);
      $this->set('_serialize',array('message'));
      $this->response->statusCode(200);
      }
  }

  public function addProgressImage()
  {
    if($this->request->is('post'))
      {
        $fileName = $this->Custom->fileUploading('progress_img','trainee_progress'); 
        $session = $this->request->session();
        $user_data = $session->read('Auth.User');
        $data = array(
          'abi_image_name' => $fileName,
          'abi_trainee_id' => $user_data['id'],
          'weight'         => $this->request->data['weight'],
          'abi_status'     => 0,
          'abi_added_date' => Time::now(),
          );
        $user = $this->After_before_images->newEntity();
        $user = $this->After_before_images->patchEntity($user, $data);
        $result = $this->After_before_images->save($user);
        $lid = $result->abi_id; 
        if(!empty($lid)){
          $this->request->session()->write('sucess_alert','Progress photo successfully added !!');
        }else{
          $this->request->session()->write('error_alert','Failed please try again !!');
        }
        return $this->redirect('/trainees/photoalbum/progress_photo');
      }
  }

  public function addVideos()
  {
    if($this->request->is('ajax'))
      {
        $fileName = $this->Custom->fileUploading('trainee_videos','trainee_videos'); 
        $data = $this->Custom->getSessionData();
        $data = array(
          'piv_attachement_type' => 'video',
          'piv_name' => $fileName,
          'piv_user_type' => 'trainee',
          'piv_user_id' => $data['id'],
          'piv_status' => 0,
          'piv_added_date' => Time::now(),
          );
        $user = $this->Profile_images_videos->newEntity();
      $user = $this->Profile_images_videos->patchEntity($user, $data);
        $result = $this->Profile_images_videos->save($user);
      $lid = $result->piv_id; 
        $this->set('message', $lid);
      $this->set('_serialize',array('message'));
      $this->response->statusCode(200);
      }
  }

  public function updatePersonalInfo($type)
  {
        if($this->request->is('post'))
        {
           $sess_data = $this->Custom->getSessionData();
           $data = $this->request->data;
          if(isset($_POST['trainee_skills']))
          {
            $skills = $data['trainee_skills'];
            $skillsArr = explode(",", $skills);
              if(in_array("", $skillsArr) || in_array(" ", $skillsArr))
            {
              $this->Flash->error('Skills can not be blank !', ['key' => 'edit1']); 
              return $this->redirect('/trainees/completeProfile');
            }
            if(count($skillsArr) > 5)
            {
                $this->Flash->error('You Can Add Only Five Skills !', ['key' => 'edit1']); 
                return $this->redirect('/trainees/completeProfile/'.$type);
            }
          }
          if($type == "social_links"){
              $key = "edit2";
          }if($type == "informaiton"){
            $key = "edit1";
          }

          if($type == "informaiton"){
            $address = $data["trn_city"].' '.$data["trn_state"].' '.$data["trn_cont"];
            $loc = $this->Custom->getlatlng($address);
            $data['lat'] = $loc["latitude"];
            $data['lng'] = $loc["longitude"];
            unset($data["trn_city"]);
            unset($data["trn_state"]);
            unset($data["trn_cont"]);
            $this->users->query()->update()->set(array('display_name' => $data['trainee_displayName']))->where(['id' => $sess_data['id']])->execute();
          }
          
          $this->trainees->query()->update()->set($data)->where(['user_id' => $sess_data['id']])->execute();
          $this->Flash->success('Profile Has Been Updated Successfully', ['key' => $key]);
          return $this->redirect('/trainees/completeProfile/'.$type);
        }
  }

  public function updateAboutMe()
  {
        if($this->request->is('post'))
        {
        $sess_data = $this->Custom->getSessionData();
        $data = $this->request->data;
        $this->trainees->query()->update()->set($data)->where(['user_id' => $sess_data['id']])->execute();
        $this->Flash->success('Profile Has Been Updated Successfully', ['key' => 'edit3']);
        return $this->redirect('/trainees/completeProfile/aboutme');
        }
  }

  public function updateProfileImage()
  {
    if($this->request->is('ajax'))
      {
        $f_name1 = $_FILES['trainee_profile_img']['name'];
        $f_tmp1 = $_FILES['trainee_profile_img']['tmp_name'];
        $f_size1 = $_FILES['trainee_profile_img']['size'];
        $f_extension1 = explode('.',$f_name1); 
        $f_extension1 = strtolower(end($f_extension1)); 
        $f_newfile1="";
        if($f_name1){
        $f_newfile1 = "VT_".uniqid().'.'.$f_extension1; 
        $store1 = "uploads/trainee_profile/". $f_newfile1;
        $image2 =  move_uploaded_file($f_tmp1,$store1);
        }
        if($_SERVER['SERVER_NAME'] == "localhost"){
          $newfile = $_SERVER['DOCUMENT_ROOT'] . '/fitness/webroot/uploads/trainee_gallery/'.$f_newfile1;
        }else{
          $newfile = $_SERVER['DOCUMENT_ROOT'] . '/webroot/uploads/trainee_gallery/'.$f_newfile1;
        }
        copy($store1, $newfile);
        $data = array(
              'piv_attachement_type' => 'image',
              'piv_name' => $f_newfile1,
              'piv_user_type' => 'trainee',
              'piv_user_id' => $this->data['id'],
              'piv_status' => 0,
              'piv_added_date' => Time::now(),
              );
        $user = $this->Profile_images_videos->newEntity();
        $user = $this->Profile_images_videos->patchEntity($user, $data);
        $result = $this->Profile_images_videos->save($user);
        $this->trainees->query()->update()->set(['trainee_image' => $f_newfile1])->where(['user_id' => $this->data['id']])->execute();
        $this->set('message', $f_newfile1);
        $this->set('_serialize',array('message'));
        $this->response->statusCode(200);
      }
  }

  public function fbSignupTrainee()
  {
    if($this->request->is('ajax'))
      {
        $data = $this->request->data['response'];
        $arr = json_encode($data);
        $arr1 = (array) json_decode($arr);

        $fb_result = $this->Trainees->find()->where(['trainee_social_id' => $arr1['id']])->toArray();

        if(empty($fb_result))
        {
          $email_check = $this->Users->find()->where(['username' => $arr1['email']])->toArray();

          if(empty($email_check))
          {
            $user_arr = array(
              'username' => $arr1['email'],
              'display_name' => $arr1['first_name']."".$arr1['last_name'],
              'user_type' => 'trainee',
              'user_status' => 1,
              'social_type' => 'facebook',
              'social_id' => $arr1['id'],
              'created' => Time::now()
              );

            $user = $this->Users->newEntity();
          $user = $this->Users->patchEntity($user, $user_arr);
            $result = $this->Users->save($user);
          $lid = $result->id; 

            $trainee_arr = array(
              'user_id' => $lid,
              'trainee_name' => $arr1['name'],
              'trainee_email' => $arr1['email'],
              'trainee_gender' => $arr1['gender'],
              'trainee_displayName' => $arr1['first_name']."".$arr1['last_name'],
              'trainee_social_type' => 'facebook',
              'trainee_social_id' => $arr1['id'],
              'trainee_status' => 1,
              'trainee_added_date' => Time::now()
            );
            $address = '';
            $loc = $this->Custom->getlatlng($address);
            
            $trainee_arr['lat'] = $loc["latitude"];
            $trainee_arr['lng'] = $loc["longitude"];
            
            $user1 = $this->Trainees->newEntity();
          $user1 = $this->Trainees->patchEntity($user1, $trainee_arr);
            $result1 = $this->Trainees->save($user1);
            $message = 'Success';
          }

          if(!empty($email_check))
          {
            $message = 'Email Already Exists';
          }
          
        }

        if(!empty($fb_result))
        {
          $message = 'Already Registered';
        }

        $this->set('message', $message);
      $this->set('_serialize',array('message'));
      $this->response->statusCode(200);
      }
  }

  public function googleSignupTrainee()
  {
    if($this->request->is('ajax'))
      {
        $data = $this->request->data['profile'];
        $arr = json_encode($data);
        $arr1 = (array) json_decode($arr);
        $google_result = $this->Trainees->find()->where(['trainee_social_id' => $arr1['id']])->toArray();

        if(empty($google_result))
        {
          $email_check = $this->Users->find()->where(['username' => $arr1['emails'][0]->value])->toArray();

          if(empty($email_check))
          {
            $user_arr = array(
              'username' => $arr1['emails'][0]->value,
              'display_name' => $arr1['name']->givenName."".$arr1['name']->familyName,
              'user_type' => 'trainee',
              'user_status' => 1,
              'social_type' => 'google',
              'social_id' => $arr1['id'],
              'created' => Time::now()
              );

            $user = $this->Users->newEntity();
          $user = $this->Users->patchEntity($user, $user_arr);
            $result = $this->Users->save($user);
          $lid = $result->id; 

            $trainee_arr = array(
              'user_id' => $lid,
              'trainee_name' => $arr1['name']->givenName,
              'trainee_lname' => $arr1['name']->familyName,
              'trainee_email' => $arr1['emails'][0]->value,
              'trainee_gender' => $arr1['result']->gender,
              'trainee_displayName' => $arr1['name']->givenName."".$arr1['name']->familyName,
              'trainee_social_type' => 'google',
              'trainee_social_id' => $arr1['id'],
              'trainee_status' => 1,
              'trainee_added_date' => Time::now()
            );
            $address = '';
            $loc = $this->Custom->getlatlng($address);
            
            $trainee_arr['lat'] = $loc["latitude"];
            $trainee_arr['lng'] = $loc["longitude"];
            
            $user1 = $this->Trainees->newEntity();
          $user1 = $this->Trainees->patchEntity($user1, $trainee_arr);
            $result1 = $this->Trainees->save($user1);
            $message = 'Success';
          }

          if(!empty($email_check))
          {
            $message = 'Email Already Exists';
          }
          
        }

        if(!empty($google_result))
        {
          $message = 'Already Registered';
        }

        $this->set('message', $message);
      $this->set('_serialize',array('message'));
      $this->response->statusCode(200);
      }
  }

  public function fbLoginTrainee()
  {
    if($this->request->is('ajax'))
      {
        $data = $this->request->data['response'];
        $arr = json_encode($data);
        $arr1 = (array) json_decode($arr);
        $fb_data = $this->Users->find()->where(['social_id' => $arr1['id'], 'social_type' => 'facebook'])->toArray();

        if(empty($fb_data))
        {
          $message = "User Not Exists";
        }

        if(!empty($fb_data))
        {
          $status = $fb_data[0]['user_status'];

          if($status == 0)
          {
            $message = "Profile inactive";
          }

          $status = $fb_data[0]['user_status'];
          
          if($status == 1)
          {
            $user = array(
              'id' => $fb_data[0]['id'],
              'username' => $fb_data[0]['username'],
              'display_name' => $fb_data[0]['display_name'],
              'user_type' => $fb_data[0]['user_type'],
              'user_status' => $fb_data[0]['user_status'],
              'social_type' => $fb_data[0]['social_type'],
              'social_id' => $fb_data[0]['social_id']
              );
            $this->Auth->setUser($user);
            $message = "Login Successfully";
          }
        }

        $this->set('message', $message);
      $this->set('_serialize',array('message'));
      $this->response->statusCode(200);
      }
  }

  public function googleLoginTrainee()
  {
    if($this->request->is('ajax'))
      {
        $data = $this->request->data['profile'];
        $arr = json_encode($data);
        $arr1 = (array) json_decode($arr);
        $google_data = $this->Users->find()->where(['social_id' => $arr1['id'], 'social_type' => 'google'])->toArray();

        if(empty($google_data))
        {
          $message = "User Not Exists";
        }

        if(!empty($google_data))
        {
          $status = $google_data[0]['user_status'];

          if($status == 0)
          {
            $message = "Profile inactive";
          }

          $status = $google_data[0]['user_status'];
          
          if($status == 1)
          {
            $user = array(
              'id' => $google_data[0]['id'],
              'username' => $google_data[0]['username'],
              'display_name' => $google_data[0]['display_name'],
              'user_type' => $google_data[0]['user_type'],
              'user_status' => $google_data[0]['user_status'],
              'social_type' => $google_data[0]['social_type'],
              'social_id' => $google_data[0]['social_id']
              );
            $this->Auth->setUser($user);
            $message = "Login Successfully";
          }
        }

        $this->set('message', $message);
      $this->set('_serialize',array('message'));
      $this->response->statusCode(200);
      }
  }

     public function deleteGallery()
     {
        if($this->request->is('ajax'))
          {
             $id = (int) base64_decode($this->request->data['p_id']);
             $fileName = $this->request->data['file'];
             $this->gallery->query()->delete()->where(['piv_id' => $id])->execute();
             /*$this->Custom->deleteFile($fileName,'trainee_gallery');*/
             $this->set('message', 'success');
             $this->set('_serialize',array('message'));
             $this->response->statusCode(200);
          }
     }

     public function deleteProgress()
     {
        if($this->request->is('ajax'))
          {
             $id = (int) base64_decode($this->request->data['p_id']);
             $fileName = $this->request->data['file'];
             $this->progress->query()->delete()->where(['abi_id' => $id])->execute();
             // $this->Custom->deleteFile($fileName,'trainee_progress');
             $this->set('message', 'success');
             $this->set('_serialize',array('message'));
             $this->response->statusCode(200);
          }
     }

     public function makeFavourite()
     {
        if($this->request->is('ajax'))
          {
             $trainer_id = (int) base64_decode($this->request->data['trainer_id']);
             $result_data = $this->Favourites->find()->where(['fav_trainer_id' => $trainer_id,'fav_trainee_id' => $this->data['id']])->toArray();
             if(empty($result_data))
             {
              $data = array(
                  'fav_trainer_id' => $trainer_id,
                  'fav_trainee_id' => $this->data['id'],
                  'fav_status' => 0,
                  'fav_added_date' => Time::now()
                );
              $user = $this->Favourites->newEntity();
              $user = $this->Favourites->patchEntity($user, $data);
              $result = $this->Favourites->save($user);
             }
             $this->set('message', $result_data);
             $this->set('_serialize',array('message'));
             $this->response->statusCode(200);
          }
     }

     public function favouritesTrainers()
     {
        $trainer_details = $this->conn->execute('SELECT *,c.name as country_name,ct.name as city_name,s.name as state_name,t.id as trainer_id,f.id as favourite_id FROM `trainers` as t inner join `countries` as c on t.trainer_country = c.id inner join `states` as s on t.trainer_state = s.id inner join `cities` as ct on t.trainer_city = ct.id inner join `favourites` as f on f.fav_trainer_id = t.user_id where f.fav_trainee_id = '. $this->data['id'])->fetchAll('assoc');;
        $profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
        $this->set('profile_details', $profile_details);
        
        $this->set('trainer_details', $trainer_details);
     }

     public function unfavourite($id)
     {
      $fav_id = (int) base64_decode($id);
      $this->favourites->query()->delete()->where(['id' => $fav_id])->execute();
      $this->Flash->success('Trainer Unfavourite Successfully', ['key' => 'edit']);
      return $this->redirect('/trainees/favouritesTrainers');
     }

     public function trainerRating($id)
     {
        $trainer_id = (int) base64_decode($id);
        $profile_details = $this->Trainers->find()->where(['user_id' => $trainer_id])->toArray();
        $trainers = $this->Trainers->find('all')->order(['id' => 'DESC'])->toArray();
        $this->set('trainers', $trainers); 
        
        $this->set('profile_details', $profile_details); 
     }

     public function insertRating()
     {
      if($this->request->is('ajax'))
        {

          $data  = $this->request->data;
          $appid = $data['app_session_id'];
          $app_data = $this->Appointment_sessions->find()->where(['id' => $appid])->toArray();
          if(!empty($app_data)){
            $trainer_id = $app_data[0]['trainerId'];
          }else{
            $trainer_id = 0;
          }
          $total_rating = ($data['question1'] + $data['question2'] + $data['question3'] + $data['question4'] + $data['question5'])/5;
          $rating_arr = array(
                'rating_trainer_id' => $trainer_id,
                'rating_trainee_id' => $this->data['id'],
                'rating_total' => $total_rating,
                'rating_message' => $data['rating_message'],
                'rating_status' => 0,
                'rating_added_date' => Time::now()
            );
          $user = $this->Ratings->newEntity();
          $user = $this->Ratings->patchEntity($user, $rating_arr);
          $result = $this->Ratings->save($user);
          $lid = $result->id;
          if(empty($lid)){
            $lid = 0;
          }

          $avg_rating = $this->conn->execute('SELECT AVG(`rating_total`) AS `avg` FROM `ratings` WHERE `rating_trainer_id` = '. $trainer_id)->fetchAll('assoc');
          $trainer_rating = round($avg_rating[0]['avg'],1);
          $this->trainers->query()->update()->set(['trainer_rating' => $trainer_rating])->where(['user_id' => $trainer_id])->execute();

          $app_arr = array('training_status' => 1, 'app_rating' => $total_rating);
          $this->appointment_sessions->query()->update()->set($app_arr)->where(['id' => $appid])->execute();
          $this->set('message', $lid);
          $this->set('_serialize',array('message','id'));
          $this->response->statusCode(200);
        }
     }

    public function mytrainerProfile($t_id)
      {
        $id = (int) base64_decode($t_id);
        $gallery_img = $this->Profile_images_videos->find()->where(['piv_user_id' => $id, 'piv_attachement_type' => 'image'])->order(['piv_id' => 'DESC'])->toArray();
        $result = $this->Trainers->find()->where(['user_id' => $id])->toArray();
        $quotes = $this->Latest_things->find()->where(['lt_type' => 'Quotes', 'lt_user_id' => $id])->order(['id' => 'DESC'])->toArray();
        $gallery_videos = $this->Profile_images_videos->find()->where(['piv_user_id' => $id, 'piv_attachement_type' => 'video'])->order(['piv_id' => 'DESC'])->toArray();
        $certificates = $this->Documents->find()->where(['trainer_id' => $id,'document_type' => 'Certification'])->order(['id' => 'DESC'])->toArray();
        $resume = $this->Documents->find()->where(['trainer_id' => $id,'document_type' => 'Resume'])->order(['id' => 'DESC'])->toArray();
        $feedback = $this->conn->execute('SELECT * FROM `ratings` As r inner join trainees as t ON t.user_id = r.rating_trainee_id WHERE r.rating_trainer_id = '. $id .' ORDER BY r.id DESC')->fetchAll('assoc');
        $this->set('feedback',$feedback);
        $this->set('resume',$resume);
        $this->set('certificates',$certificates);
        $this->set('quotes',$quotes);    
        $this->set('gallery_img', $gallery_img);
        $this->set('gallery_videos', $gallery_videos);
        $this->set('trainer_detail', $result);
        
      }

    public function bookAppoinments($id)
    {
      $trainee_id = (int) base64_decode($id);
      $result = $this->Trainers->find()->where(['user_id' => $trainee_id])->toArray();
      $slots = $this->Appointments->find()->where(['app_sender_id' => $trainee_id,'app_reciever_id' => 0])->toArray();
      $booked_appo = $this->Appointments->find()->where(['app_reciever_id' => $trainee_id,'app_status' => 1])->toArray();
      $book_appo = array_merge($slots,$booked_appo);
      if(!empty($book_appo))
       {
            foreach($book_appo as $ba)
            {
                $dateArr = explode(" ",$ba['app_date']);
                $date = $dateArr[0];
                $newDate = date("Y-m-d", strtotime($date));
                $book_appo_arr[] = array(
                        'title' => preg_replace( "/\r|\n/", " ", $ba['app_message']),
                        'id' => $ba['app_id'],
                        'start' => $newDate ." ".$ba['app_start_time'],
                        'end' => $newDate ." ".$ba['app_end_time'],
                        'backgroundColor' => $ba['app_color']
                      );
            }
       }
       else
       {
            $book_appo_arr = array();
       }
      $this->set('book_appo_arr', $book_appo_arr);
      $this->set('trainer_detail', $result);
    }

    public function updateNotification()
    {
      if($this->request->is('ajax'))
        {
           $noti_id = (int) base64_decode($this->request->data['noti_id']);
           $this->notifications->query()->update()->set(['noti_status' => 1])->where(['id' => $noti_id])->execute();
           $this->set('message', 'success');
           $this->set('_serialize',array('message','id'));
           $this->response->statusCode(200);
        }
    }

    public function purchasePlan($sid)
    {
      $session_id = (int) base64_decode($sid);
      $sessions = $this->conn->execute('select *,pc.id as cat_id,ps.id as sess_id from `plans_categories` As pc INNER JOIN `plans_sessions` AS ps ON pc.id = ps.category_id where ps.id = '.$session_id)->fetchAll('assoc');
      $profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
      $total_wallet_ammount = $this->Total_wallet_ammount->find()->where(['user_id' => $this->data['id']])->toArray();
      if(empty($total_wallet_ammount)){
        $total_wallet_ammount = 0;
      }
      else{
          $total_wallet_ammount = $total_wallet_ammount[0]['total_ammount'];
      }
      $this->set('total_wallet_ammount', $total_wallet_ammount);
      $this->set('profile_details', $profile_details);
      $this->set('sessions', $sessions);
    }

    public function applyCoupon()
    {
      if($this->request->is('ajax'))
        {
          $voucher_data = array();
          $code      = $this->request->data['code'];
          $user_id   = $this->data['id'];
          $user_type = $this->data['user_type'];
          $date      = date('Y-m-d');
          $check_voucher = $this->conn->execute("SELECT * FROM `vouchers` WHERE `voucher_status` = 0 AND `voucher_user_type` = '$user_type' AND `voucher_code` = '$code' AND voucher_validity_time >= '$date'")->fetchAll('assoc');
          if(empty($check_voucher))
          {
            $status = "invalid";
            $voucher_data = array();
          }
          else
          {
            $voucher_limit = $check_voucher[0]['no_of_time'];
            $check_voucher_history = $this->conn->execute("SELECT * FROM `vouchers_history` WHERE `vh_user_id` = ".$user_id." AND `vh_promo_code` = '$code' AND `user_type` = '$user_type'")->fetchAll('assoc');
            if(!empty($check_voucher_history)){
              $applied_times = count($check_voucher_history);
            }else{
              $applied_times = 0;
            }
            if($voucher_limit > $applied_times){
              $status = "success";
              $voucher_data = $check_voucher;
            }else{
              $status = "invalid";
              $voucher_data = array();
            }
          }
          $this->set('voucher_status', $status);
          $this->set('voucher_data', $voucher_data);
          $this->set('_serialize',array('voucher_status','voucher_data'));
          $this->response->statusCode(200);
        }
    }

    public function successPayment()
    {
      $response = $_REQUEST;

      // add data into trainee_wallet table

      $trainee_wallet_arr = array(
        'trainee_id' => $this->data['id'],
        'payment_type' => 'Paypal',
        'txn_id' => $response['tx'],
        'ammount' => $response['amt'],
        'txn_type' => 'Credit',
        'status' =>  $response['st'],
        'added_date' => Time::now()
        );

      $user = $this->Trainee_txns->newEntity();
      $user = $this->Trainee_txns->patchEntity($user, $trainee_wallet_arr);
      $result = $this->Trainee_txns->save($user);

      if($response['st'] == "Completed")
      {
        // check data into total_wallet_ammountTable table

        $total_ammount = $this->Total_wallet_ammount->find()->where(['user_id' => $this->data['id'],'user_type' => 'trainee'])->toArray();

        if(empty($total_ammount))
          {
            // add data into total_wallet_ammount table

            $total_wallet_ammount_arr = array(
              'user_id' => $this->data['id'],
              'user_type' => 'trainee',
              'total_ammount' => $response['amt'],
              'status' =>  0,
              'added_date' => Time::now()
              );

          $user = $this->Total_wallet_ammount->newEntity();
          $user = $this->Total_wallet_ammount->patchEntity($user, $total_wallet_ammount_arr);
          $result = $this->Total_wallet_ammount->save($user);
          }
        else
          {
            // update data into total_wallet_ammount table

            $total_wallet_ammount_arr = array(
              'total_ammount' => $total_ammount[0]['total_ammount'] + $response['amt'],
              );
            $this->total_wallet_ammount->query()->update()->set($total_wallet_ammount_arr)->where(['user_id' => $this->data['id'],'user_type' => 'trainee'])->execute();
          }
      }
      $this->Flash->success('Payment Successfully Done Status  - '.$response['st'], ['key' => 'success']);
      return $this->redirect('/trainees/wallet');
    }

    public function cancelPayment()
    {
      $this->Flash->error('Payment Cancelled !', ['key' => 'cancel']);
      return $this->redirect('/trainees/payment/'.$this->request->session()->read('session_id'));
    }

    public function updateSession()
    {
      if($this->request->is('ajax'))
        {
          $from_id = $this->request->data['from_id']; // trainee_id
          $to_id = $this->request->data['to_id']; // trainer_id
          $time = $this->request->data['time'];
          $totalSession = "";
          $timeArr = explode(":",$time);

          if($timeArr[0] == 0)
          {
            $totalSession = 1;
          }
          if($timeArr[0] > 0 && $timeArr[1] == 0 && $timeArr[2] == 0 )
          {
             $totalSession = $timeArr[0];
          }
          if($timeArr[0] > 0 && ($timeArr[1] > 0 || $timeArr[2] > 0 ))
          {
             $totalSession = $timeArr[0] + 1;
          }

          // get plan session data
          $session_data = $this->Trainee_plan->find()->where(['user_id' => $from_id])->toArray();

          //check trainer account table data
          $trainer_acc = $this->Trainer_account->find()->where(['trainer_id' => $to_id])->toArray();

          // get trainer per session rate
          $per_session_rate = ($session_data[0]['final_ammount'] / $session_data[0]['sessions']) - $session_data[0]['service_fee'];
          $payable_ammount = $per_session_rate * $totalSession;

          // add data into trainer_session table
          $trainer_sessions_arr = array(
            'trainer_id' => $to_id,
            'user_id' => $from_id,
            'time' => $time,
            'session' => $session_data[0]['sessions'],
            'price' => $session_data[0]['price'],
            'final_ammount' => $session_data[0]['final_ammount'],
            'service_fee' => $session_data[0]['service_fee'],
            'used_session' => $totalSession,
            'total_ammount' => $payable_ammount,
            'status' => 0,
            'added_date' => Time::now(),
            'date' => date('Y-m-d')
            );
          $user = $this->Trainer_sessions->newEntity();
          $user = $this->Trainer_sessions->patchEntity($user, $trainer_sessions_arr);
          $result = $this->Trainer_sessions->save($user);

          if(empty($trainer_acc))
          {
            // add data into trainer_account table
            $trainer_account_arr = array(
              'trainer_id' => $to_id,
              'session' => $totalSession,
              'total_ammount' => $payable_ammount,
              'paid_ammount' => 0,
              'remaining_ammount' => $payable_ammount,
              'status' => 0,
              'added_date' => Time::now()
              );
            $user = $this->Trainer_account->newEntity();
            $user = $this->Trainer_account->patchEntity($user, $trainer_account_arr);
            $result = $this->Trainer_account->save($user);
          }
          if(!empty($trainer_acc))
          {
            // edit data into trainer_account table
            $trainer_account_update_arr = array(
              'session' => $trainer_acc[0]['session'] + $totalSession,
              'total_ammount' => $trainer_acc[0]['total_ammount'] + $payable_ammount,
              'paid_ammount' => $trainer_acc[0]['paid_ammount'] + 0,
              'remaining_ammount' => $trainer_acc[0]['remaining_ammount'] + $payable_ammount,
              );
            $this->trainer_account->query()->update()->set($trainer_account_update_arr)->where(['trainer_id' => $to_id])->execute();
          }

          // edit data into trainee_plan table
          $this->trainee_plan->query()->update()->set(['updated_sessions' => ($session_data[0]['updated_sessions'] + $totalSession)])->where(['user_id' => $from_id])->execute();

          $this->set('message', 'success');
          $this->set('_serialize',array('message'));
          $this->response->statusCode(200);
        }
    }

    public function moneyOrder()
    {
      $trainee_wallet_arr = array(
        'txn_name'  => 'Money Order',
        'trainee_id' => $this->data['id'],
        'payment_type' => 'Money Order',
        'txn_id' => $this->request->data['order_no'],
        'txn_type' => 'Credit',
        'ammount' => $this->request->data['money_order_ammount'],
        'status' =>  "Pending",
        'added_date' => Time::now()
        );

      $user = $this->Trainee_txns->newEntity();
      $user = $this->Trainee_txns->patchEntity($user, $trainee_wallet_arr);
      $result = $this->Trainee_txns->save($user);
      $this->Flash->success('Ammount Successfully Added Please Wait For Admin Approval', ['key' => 'success']);
      return $this->redirect('/trainees/wallet');      
    }

    public function wallet()
    {
      $profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
      $total_wallet_ammount = $this->Total_wallet_ammount->find()->where(['user_id' => $this->data['id']])->toArray();
      $wallet_txn = $this->Trainee_txns->find()->where(['trainee_id' => $this->data['id']])->order(['id' => 'DESC'])->toArray();
      $this->set('wallet_txn', $wallet_txn);
      $this->set('total_wallet_ammount', $total_wallet_ammount);
      $this->set('profile_details', $profile_details);
    }

    public function reports()
    {
      if(isset($_POST['filter_report'])){
        $form_data  = $this->request->data;
          if($form_data['selector'] == "date"){ // by date
            $start_date = $form_data['from_date'];
            $end_date   = $form_data['to_date'];
            $this->Flash->default($start_date, ['key' => 'start_date']); 
            $this->Flash->default($end_date,   ['key' => 'end_date']); 
          }else{ // by month
            $last_month = $form_data['by_moth'];
            $start_date =  date("Y-m-d",strtotime("-".$last_month." Months"));
            $end_date   =  date("Y-m-d");
            $this->Flash->default($last_month, ['key' => 'last_month']); 
          }
        $txns_details = $this->conn->execute('SELECT * FROM trainee_txns WHERE DATE(added_date) BETWEEN  "'.$start_date.'" AND "'.$end_date.'" AND trainee_id = '.$this->data['id'].' ORDER BY id DESC ')->fetchAll('assoc');
      }else{
        $txns_details = $this->Trainee_txns->find()->where(['trainee_id' => $this->data['id']])->order(['id' => 'DESC'])->LIMIT(10)->toArray();
      }
      $profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
      $total_wallet_ammount = $this->Total_wallet_ammount->find()->where(['user_id' => $this->data['id']])->toArray();
      $this->set('total_wallet_ammount', $total_wallet_ammount);
      $this->set('profile_details', $profile_details);
      $this->set('txns_details', $txns_details);
    }

    public function delete()
    {
        if($this->request->is('ajax'))
        {
            $id = (int) base64_decode($this->request->data['id']);
            $table = $this->request->data['table'];
            foreach($table as $t)
            {
                if($t == "Trainers")
                {
                    $this->trainers->query()->delete()->where(['user_id' => $id])->execute();
                }
                if($t == "Trainees")
                {
                    $this->trainees->query()->delete()->where(['user_id' => $id])->execute();
                }
                if($t != "Trainees" && $t != "Trainers")
                {
                   $entity = $this->$t->get($id);
                   $result = $this->$t->delete($entity); 
                }
            }
            $this->set('message', 'success');
            $this->set('_serialize',array('message'));
            $this->response->statusCode(200);
        }
    }

    public function walletPayment($ammount)
    {
      $profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
      $order_count = $this->Trainee_txns->find()->count();
      $this->set('order_count', $order_count);
      $this->set('profile_details', $profile_details);
      $this->set('ammount', $ammount);
    }

    public function insertPurchasedPlan()
    {
      $data = $this->request->data;

      // check trainee plan exist or not in trainee_plan table
      $plan_data = $this->Trainee_plan->find()->where(['user_id' => $this->data['id']])->toArray();

      if(empty($plan_data))
        {
          // add data into trainee_plan table
          $trainee_plan_arr = array(
              'user_id' => $this->data['id'],
              'sessions' => $data['session'],
              'plans' => $data['plan'],
              'updated_sessions' => 0,
              'price' => $data['main_price'],
              'service_fee' => $data['service_fee'],
              'final_ammount' => $data['price_after_voucher'],
              'status' => 0,
              'added_date' => Time::now()
          );
          $user = $this->Trainee_plan->newEntity();
          $user = $this->Trainee_plan->patchEntity($user, $trainee_plan_arr);
          $result = $this->Trainee_plan->save($user);
        }
      if(!empty($plan_data))
        {
          // edit data into trainee_plan table
          $trainee_plan_update_arr = array(
              'sessions' => $data['session'],
              'plans' => $data['plan'],
              'price' => $data['main_price'],
              'updated_sessions' => 0,
              'service_fee' => $data['service_fee'],
              'final_ammount' => $data['price_after_voucher'],
          );
          $this->trainee_plan->query()->update()->set($trainee_plan_update_arr)->where(['user_id' => $this->data['id']])->execute();
        }

      // add data into admin_session table
      $mytxn_id = $this->data['id']."-".uniqid();
      $admin_session_arr = array(
            'admin_id' => 48,
            'trainee_id' => $this->data['id'],
            'plan' => $data['plan'],
            'price' => $data['main_price'],
            'service_fee' => $data['service_fee'],
            'session' => $data['session'],
            'final_ammount' => $data['price_after_voucher'],
            'payment_type' => 'Wallet',
            'voucher_id' => $this->request->session()->read('voucher_id1'),
            'txn_id' => $mytxn_id,
            'status' => 1,
            'added_date' => Time::now()
        );
        $user = $this->Admin_sessions->newEntity();
        $user = $this->Admin_sessions->patchEntity($user, $admin_session_arr);
        $result = $this->Admin_sessions->save($user);

        // check admin account data exist or not in admin_account table
        $admin_account_data = $this->Admin_account->find()->where(['admin_id' => 48])->toArray();
        $totalServiceFee = $data['session'] * $data['service_fee'];
        if(empty($admin_account_data))
          {
            // add data into admin_account table
            $admin_account_arr = array(
                  'admin_id' => 48,
                  'status' => 0,
                  'total_ammount' => $data['price_after_voucher'],
                  'total_service_fee' =>  $totalServiceFee,
                  'remaining_ammount' => $data['price_after_voucher'],
                  'paid_ammount' => 0,
                  'added_date' => Time::now()
              );
              $user = $this->Admin_account->newEntity();
              $user = $this->Admin_account->patchEntity($user, $admin_account_arr);
              $result = $this->Admin_account->save($user);
          }
        if(!empty($admin_account_data))
          {
            // edit data into admin_account table
            $admin_account_update_arr = array(
                  'total_ammount' => $admin_account_data[0]['total_ammount'] + $data['price_after_voucher'],
                  'remaining_ammount' => $admin_account_data[0]['total_ammount'] + $data['price_after_voucher'],
                  'paid_ammount' => $admin_account_data[0]['paid_ammount'] + 0,
                  'total_service_fee' => $admin_account_data[0]['total_service_fee'] + $totalServiceFee
              );
            $this->admin_account->query()->update()->set($admin_account_update_arr)->where(['admin_id' => 48])->execute();
          }
        $this->request->session()->delete('voucher_id1');

        // add data into trainee_wallet table

        $trainee_wallet_arr = array(
          'trainee_id' => $this->data['id'],
          'payment_type' => 'Wallet',
          'txn_id' => $mytxn_id,
          'ammount' => $data['price_after_voucher'],
          'txn_type' => 'Debit',
          'status' =>  'Completed',
          'added_date' => Time::now()
          );
        $user = $this->Trainee_txns->newEntity();
        $user = $this->Trainee_txns->patchEntity($user, $trainee_wallet_arr);
        $result = $this->Trainee_txns->save($user);

        $total_ammount = $this->Total_wallet_ammount->find()->where(['user_id' => $this->data['id'],'user_type' => 'trainee'])->toArray();

        if(empty($total_ammount))
          {
            // add data into total_wallet_ammount table

            $total_wallet_ammount_arr = array(
              'user_id' => $this->data['id'],
              'user_type' => 'trainee',
              'total_ammount' => $data['price_after_voucher'],
              'status' =>  0,
              'added_date' => Time::now()
              );

          $user = $this->Total_wallet_ammount->newEntity();
          $user = $this->Total_wallet_ammount->patchEntity($user, $total_wallet_ammount_arr);
          $result = $this->Total_wallet_ammount->save($user);
          }
        else
          {
            // update data into total_wallet_ammount table

            $total_wallet_ammount_arr = array(
              'total_ammount' => $total_ammount[0]['total_ammount'] - $data['price_after_voucher'],
              );
            $this->total_wallet_ammount->query()->update()->set($total_wallet_ammount_arr)->where(['user_id' => $this->data['id'],'user_type' => 'trainee'])->execute();
          }

      $this->Flash->success('Plan Purchased Successfully', ['key' => 'success']);
      return $this->redirect('/trainees/purchasePlan/'.$data['plan_id']);
    }

  public function makePayment($returnURL)
  { 
      $token = $this->request->session()->read('token');
      $csrf  = $_REQUEST["csrf"];
      $amount  = $_REQUEST["amount"];
      $currencyCode  = $_REQUEST["currencyCode"];
      $sellerNote  = $_REQUEST["sellerNote"];
      if ($csrf == $token) {
        $amount                  = $amount;
        $currencyCode            = $currencyCode;
        $sellerNote              = $sellerNote;
        $sellerOrderId           = "VirtualTrainR123";
        $shippingAddressRequired = "true";
        $paymentAction           = "AuthorizeAndCapture"; 



        if ($this->merchantId == "") {
          throw new InvalidArgumentException("merchantId not set in the configuration file");
        }
        if ($this->accessKey == "") {
            throw new InvalidArgumentException("accessKey not set in the configuration file");
        }
        if ($this->secretKey == "") {
            throw new InvalidArgumentException("secretKey not set in the configuration file");
        }
        if ($this->lwaClientId == "") {
            throw new InvalidArgumentException("Login With Amazon ClientID is not set in the configuration file");
        }

        $parameters["accessKey"]               = $this->accessKey;
        $parameters["amount"]                  = $amount;
        $parameters["sellerId"]                = $this->merchantId;
        $parameters["returnURL"]               = $returnURL;
        $parameters["lwaClientId"]             = $this->lwaClientId;
        $parameters["sellerNote"]              = $sellerNote;
        $parameters["sellerOrderId"]           = $sellerOrderId;
        $parameters["currencyCode"]            = $currencyCode;
        $parameters["shippingAddressRequired"] = $shippingAddressRequired;
        $parameters["paymentAction"]           = $paymentAction;

        uksort($parameters, 'strcmp');
        $Signature = $this->_urlencode($this->_signParameters($parameters, $this->secretKey));
        $parameters["signature"] = $Signature;
        echo (json_encode($parameters));
        exit();
      }
      else{
        throw new Exception("Unknown Entity");
  }
  }

  public function walletAmazonPayment()
  {
    $returnURL  = "https://virtualtrainr.com/trainees/resultAmazon";
    $this->makePayment($returnURL);
  }

  public function customAmazonPayment()
  {
    $dataArr = $this->request->data;
    $returnURL  = "https://virtualtrainr.com/trainees/resultCustomAmazon";
    $this->makePayment($returnURL);
  }

  public function _signParameters(array $parameters, $key)
  {
    $stringToSign = null;
    $algorithm    = "HmacSHA256";
    $stringToSign = $this->_calculateStringToSignV2($parameters);
    return $this->_sign($stringToSign, $key, $algorithm);
  }

  public function _calculateStringToSignV2(array $parameters)
  {
      $data = 'POST';
      $data .= "\n";
      $data .= "payments.amazon.com";
      $data .= "\n";
      $data .= "/";
      $data .= "\n";
      $data .= $this->_getParametersAsString($parameters);
      return $data;
  }

  public function _getParametersAsString(array $parameters)
  {
      $queryParameters = array();
      foreach ($parameters as $key => $value) {
          $queryParameters[] = $key . '=' . $this->_urlencode($value);
      }
      return implode('&', $queryParameters);
  }

  public function _urlencode($value)
  {
      return str_replace('%7E', '~', rawurlencode($value));
  }

  public function _sign($data, $key, $algorithm)
  {
      if ($algorithm === 'HmacSHA1') {
          $hash = 'sha1';
      } else if ($algorithm === 'HmacSHA256') {
          $hash = 'sha256';
      } else {
          throw new Exception("Non-supported signing method specified");
      }
      return base64_encode(hash_hmac($hash, $data, $key, true));
  }

  public function resultAmazon()
  {
  }

  public function resultCustomAmazon()
  {
  }

  public function success()
  {
      $returnURL  = "https://virtualtrainr.com/trainees/resultAmazon";
      $response = $_GET;
      $resultCode = $response['resultCode'];
      $signatureReturned = $_GET['signature'];
      $parameters = $_GET;
      unset($parameters['signature']);
      $parameters['sellerOrderId'] = rawurlencode($parameters['sellerOrderId']);
      uksort($parameters, 'strcmp');

      $parseUrl = parse_url($returnURL);
      $stringToSign = "GET\n" . $parseUrl['host'] . "\n" . $parseUrl['path'] . "\n";

      foreach ($parameters as $key => $value) {
          $queryParameters[] = $key . '=' . str_replace('%7E', '~', rawurlencode($value));
      }
      $stringToSign .= implode('&', $queryParameters);

      $signatureCalculated = base64_encode(hash_hmac("sha256", $stringToSign, $this->secretKey, true));
      $signatureCalculated = str_replace('%7E', '~', rawurlencode($signatureCalculated));

      if ($signatureReturned == $signatureCalculated && $resultCode == "Success") {
        $trainee_wallet_arr = array(
              'trainee_id' => $this->data['id'],
              'payment_type' => 'Amazon',
              'txn_id' => $response['orderReferenceId'],
              'ammount' => $response['amount'],
              'txn_type' => 'Credit',
              'status' =>  $resultCode,
              'added_date' => Time::now()
              );
        $user = $this->Trainee_txns->newEntity();
        $user = $this->Trainee_txns->patchEntity($user, $trainee_wallet_arr);
        $result = $this->Trainee_txns->save($user);
        
        if($resultCode == "Success")
        {
        $total_ammount = $this->Total_wallet_ammount->find()->where(['user_id' => $this->data['id'],'user_type' => 'trainee'])->toArray();
        if(empty($total_ammount))
          {
            $total_wallet_ammount_arr = array(
              'user_id' => $this->data['id'],
              'user_type' => 'trainee',
              'total_ammount' => $response['amount'],
              'status' =>  0,
              'added_date' => Time::now()
              );
          $user = $this->Total_wallet_ammount->newEntity();
          $user = $this->Total_wallet_ammount->patchEntity($user, $total_wallet_ammount_arr);
          $result = $this->Total_wallet_ammount->save($user);
          }
        else
          {
            $total_wallet_ammount_arr = array(
              'total_ammount' => $total_ammount[0]['total_ammount'] + $response['amount'],
              );
            $this->total_wallet_ammount->query()->update()->set($total_wallet_ammount_arr)->where(['user_id' => $this->data['id'],'user_type' => 'trainee'])->execute();
          }
      }
      $this->Flash->success('Payment Successfully Done Status  - '.$resultCode, ['key' => 'success']);
      } else {
         $this->Flash->error('Payment failed please try again', ['key' => 'edit']);
      }
    return $this->redirect('/trainees/wallet');
  }

  public function successCustomAmazon()
  {
      $returnURL  = "https://virtualtrainr.com/trainees/resultCustomAmazon";
      $response = $_GET;
      echo "<pre>";
      print_r($response);die;
      $resultCode = $response['resultCode'];
      $signatureReturned = $_GET['signature'];
      $parameters = $_GET;
      unset($parameters['signature']);
      $parameters['sellerOrderId'] = rawurlencode($parameters['sellerOrderId']);
      uksort($parameters, 'strcmp');

      $parseUrl = parse_url($returnURL);
      $stringToSign = "GET\n" . $parseUrl['host'] . "\n" . $parseUrl['path'] . "\n";

      foreach ($parameters as $key => $value) {
          $queryParameters[] = $key . '=' . str_replace('%7E', '~', rawurlencode($value));
      }
      $stringToSign .= implode('&', $queryParameters);

      $signatureCalculated = base64_encode(hash_hmac("sha256", $stringToSign, $this->secretKey, true));
      $signatureCalculated = str_replace('%7E', '~', rawurlencode($signatureCalculated));
      if ($signatureReturned == $signatureCalculated && $resultCode == "Success") {
        $this->insertPackagePaymentDetails($resultCode,$response['orderReferenceId']);
        $this->request->session()->write('sucess_alert','Payment successfully completed !!');
      } else {
        $this->request->session()->write('error_alert','Payment failed please try again !!');
      }
    return $this->redirect('/trainees');
  }

  public function creditReturn()
  {
   
  }

  public function bookingSession()
  {
    $this->request->session()->delete('session_amount');
    $this->request->session()->delete('app_id');
    $session    = $this->request->query['session'];
    $rateid     = base64_decode($this->request->query['rid']);
    $trainer_id = base64_decode($this->request->query['tid']);
    $profile_type_arr = $this->Users->find()->where(['id' => $this->data['id']])->toArray();
    if(!empty($profile_type_arr[0]['social_type']))
      {
        $profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
      }
    else
      {
        $profile_details = $this->conn->execute('SELECT *,c.name as country_name,ct.name as city_name,s.name as state_name FROM `trainees` as t inner join `countries` as c on t.trainee_country = c.id inner join `states` as s on t.trainee_state = s.id inner join `cities` as ct on t.trainee_city = ct.id where t.user_id = '. $this->data['id'])->fetchAll('assoc');;
      }
    $rates_plan = $this->Trainer_ratemaster->find()->where(['rate_id' => $rateid])->toArray();
    $trainer_details = $this->Trainers->find()->where(['user_id' => $trainer_id])->toArray();
    $service_fee_details = $this->Fees->find()->where(['type' => 'Transaction'])->toArray();
    $time_slots = $this->Trainer_availability->find()->where(['trainer_id' => $trainer_id,'date' => date('Y-m-d')])->toArray();
    $this->set('service_fee_details', $service_fee_details);
    $this->set('time_slots', $time_slots);
    $this->set('rates_plan', $rates_plan);
    $this->set('profile_details', $profile_details);
    $this->set('rateid', $this->request->query['rid']);
    $this->set('trainer_id', $this->request->query['tid']);
    $this->set('trainer_details', $trainer_details);
    
    $this->set('session', $session);
  }

  public function getTimeSlotsDateWise()
  {
    if($this->request->is('ajax'))
      {
          $date = $this->request->data['date'];
          $trainer_id = $this->request->data['trainer_id'];
          $time_slots = $this->Trainer_availability->find()->where(['trainer_id' => $trainer_id,'date' => $date])->toArray();
          $response = "";
          if(!empty($time_slots)){
            $times = unserialize($time_slots[0]['times']);
          }else{
            $times = array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
          }
          for ($i=0; $i < 24; $i++) {
              if($times[$i] > 0){
                  $check = "checked";
                  $disabled = "disabled";
                  $class = "booked";
                  $classlabel = "bookedlabel";
                  $title = "Not Available";
                  $checkbox_class = "blocked_section";
                  $span_class = "blocked_time";
              }else{
                  $check = "";
                  $disabled = "";
                  $class = "unbooked";
                  $classlabel = "unbookedlabel";
                  $title = "Available";
                  $checkbox_class = "";
                  $span_class = "";
              }
              $response .= '<div class="checkbox '.$checkbox_class.'">';
              $response .= '<div class="not_avail">'.$title.'</div>';
              $response .= '<div class="roundedOne ' .$classlabel.'">';
              $response .= '<input '.$check.' type="checkbox" '.$disabled.' class="time '.$class.'" value="0" time1="'.$this->Custom->getTimeSlots($i).'" time2="'.$this->Custom->getTimeSlots($i+1).'" main="'.$i.'" id="roundedOne_'.$i.'" />';
              $response .= '<label for="roundedOne_'.$i.'"></label>';
              $response .= '<input type="hidden" name="times[]" class="hidden_time" id="time_'.$i.'" value="'.$times[$i].'"/></div>';
              $response .= '<div class="chekbox_txt"><span '.$span_class.'>'.$this->Custom->getTimeSlots($i).'</span>'.$this->Custom->getTimeSlots($i+1);
              $response .= '</div></div>';
          }
          $this->set('message', $response);
          $this->set('_serialize',array('message'));
          $this->response->statusCode(200);
      }
  }

  public function confirmPay()
  {
      if($this->request->is('post'))
      {
        $appid = $this->request->session()->read('app_id');
        $data = $this->request->data;
        $rid  = $data['rid'];
        $tid  = $data['tid'];
        $session  = $data['totalsession'];
        $dataArr = array(
          'trainee_id' => $this->data['id'],
          'trainer_id' => $data['trainer_id'],
          'session_data' => serialize($data['booking']),
          'session_price'=> $data['sessions_price'],
          'service_fee'=> $data['service_fee'],
          'total_price'=> $data['total_price'],
          'ap_date'     => Time::now(),
          'created_date' => Time::now(),
          );
        if(empty($appid)){
          $user = $this->Appointments->newEntity();
          $user = $this->Appointments->patchEntity($user, $dataArr);
          $result = $this->Appointments->save($user);
          $lid = $result->id; 
        }else{
          $lid =  $appid;
          $this->appointments->query()->update()->set($dataArr)->where(['id' => $appid])->execute();
        }
        $this->request->session()->write('app_id',$lid);
        $profile_type_arr = $this->Users->find()->where(['id' => $this->data['id']])->toArray();
        if(!empty($profile_type_arr[0]['social_type']))
          {
            $profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
          }
        else
          {
            $profile_details = $this->conn->execute('SELECT *,c.name as country_name,ct.name as city_name,s.name as state_name FROM `trainees` as t inner join `countries` as c on t.trainee_country = c.id inner join `states` as s on t.trainee_state = s.id inner join `cities` as ct on t.trainee_city = ct.id where t.user_id = '. $this->data['id'])->fetchAll('assoc');;
          }
        $trainer_details = $this->Trainers->find()->where(['user_id' => $data['trainer_id']])->toArray();
        $total_wallet_ammount = $this->Total_wallet_ammount->find()->where(['user_id' => $this->data['id']])->toArray();
        $rates_plan = $this->Trainer_ratemaster->find()->where(['rate_id' => base64_decode($rid)])->toArray();
        $service_fee_details = $this->Fees->find()->where(['type' => 'Transaction'])->toArray();
        $this->set('service_fee_details', $service_fee_details);
        $this->set('total_wallet_ammount', $total_wallet_ammount);
        $this->set('rates_plan', $rates_plan);
        $this->set('trainer_details', $trainer_details);
        $this->set('profile_details', $profile_details);
        $this->set('appid', $lid);
        $this->set('session_details', $data['booking']);
        $this->set('session', count($data['booking']));
        if(empty($lid)){
            $this->Flash->error('Failed please try again !', ['key' => 'edit']);
          return $this->redirect('/trainees/bookingSession?session='.$session.'&rid='.$rid.'&tid='.$tid);
        }
      }else{
        return $this->redirect('/trainees');
      }
  }

  public function choosePaymentMethod()
  {
      if($this->request->is('post'))
      {
        $data   = $this->request->data;
        $app_id = $data['app_id'];
        $voucherid = $data['voucher'];
        $total_amount = $data['total_amount'];
        $data['final_price'] = $total_amount;
        unset($data['app_id'],$data['total_amount'],$data['voucher'],$data['check_one_to_one']);
        $this->appointments->query()->update()->set($data)->where(['id' => $app_id])->execute();
        $profile_type_arr = $this->Users->find()->where(['id' => $this->data['id']])->toArray();
        if(!empty($profile_type_arr[0]['social_type']))
          {
            $profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
          }
        else
          {
            $profile_details = $this->conn->execute('SELECT *,c.name as country_name,ct.name as city_name,s.name as state_name FROM `trainees` as t inner join `countries` as c on t.trainee_country = c.id inner join `states` as s on t.trainee_state = s.id inner join `cities` as ct on t.trainee_city = ct.id where t.user_id = '. $this->data['id'])->fetchAll('assoc');;
          }
        $total_wallet_ammount = $this->Total_wallet_ammount->find()->where(['user_id' => $this->data['id']])->toArray();
        $this->set('total_amount', $total_amount);
        $this->set('voucherid', $voucherid);
        $this->set('profile_details', $profile_details);  
        $this->set('total_wallet_ammount', $total_wallet_ammount);
      }
  }

  public function searchTrainers()
  {
    $data = $_GET;
    
      $where = array();
      $strg = "";
      $ord = array();
      $order = "";
      $lim = 20;
      $off = "";
      $where[] ='(trm.rate_hour >0 )  ';
      /* Search Parameter Start */
      if(isset($data["name"]) && !empty($data["name"]))
      {
        $where[] = "(t.trainer_name LIKE '%".$data["name"]."%' OR t.trainer_lname LIKE '%".$data["name"]."%')";
      }

      if(isset($data["int"]) && !empty($data["int"]))
      {
        $where[] = "t.interests_hobby LIKE '%".$data["int"]."%'";
      }
      if(isset($data["loc"]) && !empty($data["loc"]))
      {
       
        $where[] = "t.trainer_city = '".$data["loc"]."'";
      }

      if(isset($data["mf"]) && !empty($data["mf"]))
      {
        $where[] = "t.trainer_gender = '".$data["mf"]."'";
      }

      if(!empty($where))
      {
        $strg = "WHERE ".implode(" AND ", $where);
      }
      /* Search Parameter End */

      /* Order By Start */
      
      if(isset($data["rate"]) && !empty($data["rate"]))
      {
        $ord[] = "t.trainer_rating ".$data["rate"];
      }else
      {
        $ord[] = "t.trainer_rating DESC";  
      }

      if(isset($data["price"]) && !empty($data["price"]))
      {
        $ord[] = "trm.rate_hour ".$data['rate'];
      }
      
      $order = "ORDER BY ".implode(",", $ord);
      
      /* Order By End */

      /* For Pagination Start */
      if(!empty($data["off"]))
      {
          $old_off = (int) $data["off"];
          $offset =  $old_off * $lim;
          $off = "LIMIT ".$offset." , ".$lim;
      }else{
          $offset = 0;
          $off = "LIMIT ".$offset." , ".$lim;
      }
      /* For Pagination End */
     // $lat='22.000';
    //  $lng='75.000';
      
       
        
     if(isset($data['lng']) && isset($data['lat']))
     {
    $lat=$data['lat'];
       $lng=$data['lng'];
     
      
      $result = $this->conn->execute("select *, SQRT( POW(69.1 * (lat - $lat), 2) + POW(69.1 * ($lng- lng) * COS(lat / 57.3), 2)) AS distance,s.name as state_name,
                                       c.name as country_name,
                                       ct.name as city_name
                                       from trainers as t
                                       left join cities as ct on ct.id = t.trainer_city
                                       left join countries as c on c.id = t.trainer_country
                                       left join states as s on s.id = t.trainer_state
                                       left join trainer_ratemaster as trm on t.user_id = trm.trainer_id
                                       $strg 
                                       group by t.user_id
                                       HAVING distance <100000
                                       $order
                                       $off
                                        
                                    ")->fetchAll('assoc');
                                    
  }else{

  $result = $this->conn->execute(" select *, 
                                       s.name as state_name,
                                       c.name as country_name,
                                       ct.name as city_name
                                       from trainers as t
                                       left join cities as ct on ct.id = t.trainer_city
                                       left join countries as c on c.id = t.trainer_country
                                       left join states as s on s.id = t.trainer_state
                                       left join trainer_ratemaster as trm on t.user_id = trm.trainer_id
                                       $strg 
                                       group by t.user_id
                                       $order
                                       $off
                                        
                                    ")->fetchAll('assoc');
                                
  }
                                    
      $profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
      $notifications = $this->Notifications->find()->where(['noti_receiver_id' => $this->data['id'], 'noti_status' => 0])->count();
     
      if($this->request->is('ajax'))
      {
        $this->set('trainers', $result);
        $this->set('_serialize',array('trainers'));
        $this->response->statusCode(200);
      }else
      {
        $this->set('trainers',$result);
        $this->set('profile_details', $profile_details);
      }
      
  }

  public function doPaypalPayment($paid_ammount,$returnurl,$cancelurl){
    $apiContext = new ApiContext(
          new OAuthTokenCredential(
              'AT6LuFLtd5Avg0SzfqsrHtOIQEdkYCikSbMzasU_d1U0z-Nal9eOt_sEGtkPhbtUFt6qxKqjHvkYL212',     // ClientID
              'EK9jfM94oKkcMz29jaXxSWD0wJ_-522qnroE_7gt4wroAJuwC8cocmAE0rgECTDiC8a3DLou_2DAVXmo'      // ClientSecret
          )
      );
      $sdkConfig = array(
        "mode" => "sandbox"
      );
      $r = $apiContext->setConfig($sdkConfig);
      $payer = new Payer();
      $payer->setPaymentMethod("paypal");
      $amount = new Amount();
      $amount->setCurrency("USD");
      $amount->setTotal($paid_ammount);
      $transaction = new Transaction();
      $transaction->setDescription("Purchase Session Plans");
      $transaction->setAmount($amount);
      $redirectUrls = new RedirectUrls();
      $redirectUrls->setReturnUrl($returnurl);
      $redirectUrls->setCancelUrl($cancelurl);
      $payment = new Payment();
      $payment->setIntent("sale");
      $payment->setPayer($payer);
      $payment->setRedirectUrls($redirectUrls);
      $payment->setTransactions(array($transaction));
      $response = $payment->create($apiContext);
      $approvalUrl = $payment->getApprovalLink();
      return $this->redirect($approvalUrl);
  }

  public function doSessionPayment(){
    if($this->request->is('post'))
      {
        $dataArr = $this->request->data;
        $appid = $this->request->session()->read('app_id');
        $dataArr['app_id'] = $appid;
        $dataArr['voucher_id'] = base64_decode($dataArr['voucher_id']);
        $appoinment_details = $this->Appointments->find()->where(['id' => $appid])->toArray();
        if($dataArr['pay_type'] == "wallet"){
          $dataArr['wallet_amount'] = $appoinment_details[0]['final_price'];
          $this->request->session()->write('session_amount',$dataArr);
          $this->insertSessionPaymentDetails('Approved',$this->data['id']."-".uniqid());
        }
        else if($dataArr['pay_type'] == "paypal"){
          $this->request->session()->write('session_amount',$dataArr);
          $returnurl = "https://virtualtrainr.com/trainees/successSession/insertSessionPaymentDetails";
          $cancelurl = "https://virtualtrainr.com/trainees/cancelSession";
          $this->doPaypalPayment($dataArr['total_amount_gateway'],$returnurl,$cancelurl);
        }
        else if($dataArr['pay_type'] == "amazon"){
          $this->request->session()->write('session_amount',$dataArr);
        }
        else if($dataArr['pay_type'] == "credit"){
          $this->request->session()->write('session_amount',$dataArr);
          $querystring = "?card_no=".$_POST['card_no']."&expiry_date=".$_POST['expiry_date']."&card_cvv=".$_POST['cvv']."&total_amt=".$_POST['total_amount_gateway'];
          return $this->redirect('/rate_plans_credit_card.php'.$querystring);
        }
        $this->request->session()->write('sucess_alert','Congratulation your rate plans order successfully placed !!');
        return $this->redirect('/trainees');
      }else{
        return $this->redirect('/trainees');
      }
  }

  public function insertSessionPaymentDetails($status,$txnid){
    $session_amount  = $this->request->session()->read('session_amount');
    $appid = $session_amount['app_id'];
    $voucher_details = $this->Vouchers->find()->where(['id' => $session_amount['voucher_id']])->toArray();
    $appoinment_details = $this->Appointments->find()->where(['id' => $appid])->toArray();
    $all_sessions = unserialize($appoinment_details[0]['session_data']);
    $added_date = Time::now();
    for ($i=1; $i <= count($all_sessions); $i++) { 
        $appSessionsArr = array(
          'trainerId' => $appoinment_details[0]['trainer_id'],
          'traineeId' => $appoinment_details[0]['trainee_id'],
          'appId'     => $appoinment_details[0]['id'],
          'training_type' => $all_sessions[$i]['preference'],
          'training_date' => $all_sessions[$i]['modified_dates'],
          'training_time' => $all_sessions[$i]['modified_times'],
          'latt_longg'    => $all_sessions[$i]['locations'],
          'training_adrees' => $all_sessions[$i]['location_address'],
          'added_date'    => $added_date
        );
      $appSession = $this->Appointment_sessions->newEntity();
      $appSession = $this->Appointment_sessions->patchEntity($appSession, $appSessionsArr);
      $result  = $this->Appointment_sessions->save($appSession);
    }
    if($session_amount['voucher_id'] != "0"){
      $voucherArr = array(
          'vh_promo_code' => $voucher_details[0]['voucher_code'],
          'user_type'     => $this->data['user_type'],
          'coupon_id'     => $voucher_details[0]['id'],
          'vh_user_id'    => $this->data['id'],
          'name'          => $voucher_details[0]['voucher_name'],
          'type'          => $voucher_details[0]['voucher_type'],
          'discount'      => $voucher_details[0]['voucher_ammount'],
          'validity_date' => $voucher_details[0]['voucher_validity_time'],
          'vh_added_date' => Time::now()
          );
      $voucher = $this->Vouchers_history->newEntity();
      $voucher = $this->Vouchers_history->patchEntity($voucher, $voucherArr);
      $result  = $this->Vouchers_history->save($voucher);
      $voucher_history_id = $result->id;
    }else{
      $voucher_history_id = "0";
    }
    
    $appArr = array(
        'coupon_id'             => $voucher_history_id,
        'pay_status'            => 1,
        'wallet_amount'         => $session_amount['wallet_amount'],
        'payment_gateway_amount'=> $session_amount['total_amount_gateway']
        );
    $this->appointments->query()->update()->set($appArr)->where(['id' => $appid])->execute();
    if($session_amount['wallet_amount'] > 0){
      $wallet_details = $this->Total_wallet_ammount->find()->where(['user_id' => $this->data['id']])->toArray();
      $wallet_current_balance = round($wallet_details[0]['total_ammount'] - $session_amount['wallet_amount'],2);
      $this->total_wallet_ammount->query()->update()->set(['total_ammount'=> $wallet_current_balance])->where(['user_id' => $this->data['id']])->execute();
    }
    $txnArr = array(
          'trainee_id' => $this->data['id'],
          'txn_name'   => 'Purchase Session',
          'txn_type'   => 'Debit',
          'ammount'    => $session_amount['total_amount_gateway'] + $session_amount['wallet_amount'],
          'status'     => $status,
          'txn_id'     => $txnid,
          'added_date' => Time::now()
        );
    if($session_amount['wallet_amount'] == 0 && $session_amount['total_amount_gateway'] > 0){
      $txnArr['payment_type'] = 'Paypal';
    }
    if($session_amount['total_amount_gateway'] == 0 && $session_amount['wallet_amount'] > 0){
      $txnArr['payment_type'] = 'Wallet';
    }
    if($session_amount['total_amount_gateway'] > 0 && $session_amount['wallet_amount'] > 0){
      $txnArr['payment_type'] = 'Paypal + Wallet';
    }
    $txns   = $this->Trainee_txns->newEntity();
    $txns   = $this->Trainee_txns->patchEntity($txns, $txnArr);
    $result = $this->Trainee_txns->save($txns);
    $total_orders = $this->Orders->find()->where(['trainee_id' => $this->data['id']])->count();
    $orderArr = array(
        'trainee_id'   => $this->data['id'],
        'app_id'       => $session_amount['app_id'],
        'order_amount' => $session_amount['total_amount_gateway'] + $session_amount['wallet_amount'],
        'order_no'     => 'SASK#'.$total_orders,
        'order_type'   => '0',
        'order_status' => '0',
        'created_date' => Time::now()
        );
    $orders = $this->Orders->newEntity();
    $orders = $this->Orders->patchEntity($orders, $orderArr);
    $result = $this->Orders->save($orders);
    $notificationArr = array(
        'noti_type'          => 'Rate Plans',
        'parent_id'          => $appoinment_details[0]['id'],
        'noti_sender_type'   => 'trainee',
        'noti_sender_id'     => $appoinment_details[0]['trainee_id'],
        'noti_receiver_type' => 'trainer',
        'parent_id_status'   => 0,
        'noti_receiver_id'   => $appoinment_details[0]['trainer_id'],
        'noti_message'       => 'You have new request of purchased session',
        'noti_added_date'    => Time::now()
        );
    $notifications = $this->Notifications->newEntity();
    $notifications = $this->Notifications->patchEntity($notifications, $notificationArr);
    $result = $this->Notifications->save($notifications);
    $this->request->session()->delete('session_amount');
    $this->request->session()->delete('app_id');
  }

  public function successSession($insertMethod){
    $apiContext = new ApiContext(
      new OAuthTokenCredential(
          'AT6LuFLtd5Avg0SzfqsrHtOIQEdkYCikSbMzasU_d1U0z-Nal9eOt_sEGtkPhbtUFt6qxKqjHvkYL212',
          'EK9jfM94oKkcMz29jaXxSWD0wJ_-522qnroE_7gt4wroAJuwC8cocmAE0rgECTDiC8a3DLou_2DAVXmo'    
      )
    );
    $sdkConfig = array(
      "mode" => "sandbox"
    );
    $apiContext->setConfig($sdkConfig);
    $payment = Payment::get($_GET['paymentId'], $apiContext);
    $execution = new PaymentExecution();
    $execution->setPayerId($_GET['PayerID']);
    $result = $payment->execute($execution, $apiContext);
    $paypal_response = (array) json_decode($result);
    $this->$insertMethod($paypal_response['state'],$paypal_response['id']);
    return $this->redirect('/trainees');
  }

  public function cancelSession(){
    $appid = $this->request->session()->read('app_id');
    $this->appointments->query()->delete()->where(['id' => $appid])->execute();
    $this->request->session()->delete('session_amount');
    $this->request->session()->delete('app_id');
    return $this->redirect('/trainees');
  }

  public function purchaseCustomPackages(){
    $this->request->session()->delete('custom_packages');
    $this->request->session()->delete('custom_packages_details');
    $custom_plan_id = base64_decode($this->request->query['cid']);
    $trainer_id = base64_decode($this->request->query['tid']);
    $profile_type_arr = $this->Users->find()->where(['id' => $this->data['id']])->toArray();
    if(!empty($profile_type_arr[0]['social_type']))
      {
        $profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
      }
    else
      {
        $profile_details = $this->conn->execute('SELECT *,c.name as country_name,ct.name as city_name,s.name as state_name FROM `trainees` as t inner join `countries` as c on t.trainee_country = c.id inner join `states` as s on t.trainee_state = s.id inner join `cities` as ct on t.trainee_city = ct.id where t.user_id = '. $this->data['id'])->fetchAll('assoc');;
      }
    $custom_plan_details = $this->Trainer_packagemaster->find()->where(['package_id' => $custom_plan_id])->toArray();
    $trainer_details = $this->Trainers->find()->where(['user_id' => $trainer_id])->toArray();
    $service_fee_details = $this->Fees->find()->where(['type' => 'Transaction'])->toArray();
    $total_wallet_ammount = $this->Total_wallet_ammount->find()->where(['user_id' => $this->data['id']])->toArray();
    $this->set('total_wallet_ammount', $total_wallet_ammount);
    $this->set('profile_details', $profile_details);
    $this->set('trainer_id', $trainer_id);
    $this->set('service_fee_details', $service_fee_details);
    $this->set('trainer_details', $trainer_details);
    $this->set('custom_plan_details', $custom_plan_details);
    
  }

  public function customPackageOrder(){
    if($this->request->is('post'))
    {
      $dataArr = $this->request->data;
      $dataArr['package'] = base64_decode($dataArr['package']);
      $dataArr['coupon']  = base64_decode($dataArr['coupon']);
      $this->request->session()->write('custom_packages',$dataArr);
      $total_wallet_ammount = $this->Total_wallet_ammount->find()->where(['user_id' => $this->data['id']])->toArray();
      $profile_type_arr = $this->Users->find()->where(['id' => $this->data['id']])->toArray();
        if(!empty($profile_type_arr[0]['social_type']))
          {
            $profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
          }
        else
          {
            $profile_details = $this->conn->execute('SELECT *,c.name as country_name,ct.name as city_name,s.name as state_name FROM `trainees` as t inner join `countries` as c on t.trainee_country = c.id inner join `states` as s on t.trainee_state = s.id inner join `cities` as ct on t.trainee_city = ct.id where t.user_id = '. $this->data['id'])->fetchAll('assoc');;
          }
      $this->set('profile_details', $profile_details);
      $this->set('total_wallet_ammount', $total_wallet_ammount);
      $this->set('total_amount', $dataArr['total_amount']);
    }else{
      return $this->redirect('/trainees');
    }
  }

  public function doPackagePayment(){
    if($this->request->is('post'))
      {
        $dataArr = $this->request->data;
        $custom_packages_details = $this->request->session()->read('custom_packages');
        if($dataArr['pay_type'] == "wallet"){
          $dataArr['wallet_amount'] = $custom_packages_details['total_amount'];
          $this->request->session()->write('custom_packages_details',$dataArr);
          $this->insertPackagePaymentDetails('Approved',$this->data['id']."-".uniqid());
        }
        else if($dataArr['pay_type'] == "paypal"){
          $this->request->session()->write('custom_packages_details',$dataArr);
          $returnurl = "https://virtualtrainr.com/trainees/successSession/insertPackagePaymentDetails";
          $cancelurl = "https://virtualtrainr.com/trainees/cancelPackage";
          $this->doPaypalPayment($dataArr['total_amount_gateway'],$returnurl,$cancelurl);
        }
        else if($dataArr['pay_type'] == "amazon"){
          $this->request->session()->write('custom_packages_details',$dataArr);
        }
        else if($dataArr['pay_type'] == "credit"){
          $this->request->session()->write('custom_packages_details',$dataArr);
          $querystring = "?card_no=".$_POST['card_no']."&expiry_date=".$_POST['expiry_date']."&card_cvv=".$_POST['cvv']."&total_amt=".$_POST['total_amount_gateway'];
          return $this->redirect('/custom_pcakage_credit_card.php'.$querystring);
        }
        $this->request->session()->write('sucess_alert','Congratulation your custom package order successfully placed !!');
        return $this->redirect('/trainees');
      }else{
        return $this->redirect('/trainees');
      }
  }

  public function cancelPackage(){
    $this->request->session()->delete('custom_packages');
    $this->request->session()->delete('custom_packages_details');
    return $this->redirect('/trainees');
  }

  public function insertPackagePaymentDetails($status,$txnid){
    $custom_packages  = $this->request->session()->read('custom_packages');
    $custom_packages_details  = $this->request->session()->read('custom_packages_details');
    $session_amount = array_merge($custom_packages,$custom_packages_details);
    $voucher_details = $this->Vouchers->find()->where(['id' => $session_amount['coupon']])->toArray();
    if($session_amount['coupon'] != "0"){
      $voucherArr = array(
          'vh_promo_code' => $voucher_details[0]['voucher_code'],
          'user_type'     => $this->data['user_type'],
          'coupon_id'     => $voucher_details[0]['id'],
          'vh_user_id'    => $this->data['id'],
          'name'          => $voucher_details[0]['voucher_name'],
          'type'          => $voucher_details[0]['voucher_type'],
          'discount'      => $voucher_details[0]['voucher_ammount'],
          'validity_date' => $voucher_details[0]['voucher_validity_time'],
          'vh_added_date' => Time::now()
          );
      $voucher = $this->Vouchers_history->newEntity();
      $voucher = $this->Vouchers_history->patchEntity($voucher, $voucherArr);
      $result  = $this->Vouchers_history->save($voucher);
      $voucher_history_id = $result->id;
    }else{
      $voucher_history_id = "0";
    }
    $package_details = $this->Trainer_packagemaster->find()->where(['package_id' => $session_amount['package']])->toArray();
    $service_fee_details = $this->Fees->find()->where(['type' => 'Transaction'])->toArray();
    if(!empty($service_fee_details)){
      $package_price = $package_details[0]['package_price'];
      $service_fee_amount = $service_fee_details[0]['txn_fee'];
      $servicefee = round(($package_price * $service_fee_amount) / 100,2);
    }else{
      $servicefee = "0";
    }
    $total_package_price = $package_details[0]['package_price'] + $servicefee;
    $final_price = round($session_amount['total_amount'],2);
    $customPackageArr = array(
        'trainee_id'             => $this->data['id'],
        'trainer_id'             => $package_details[0]['trainer_id'],
        'package_name'           => $package_details[0]['package_name'],
        'package_description'    => $package_details[0]['package_discription'],
        'price'                  => $package_price,
        'service_fee'            => $servicefee,
        'total_price'            => $total_package_price,
        'coupon_id'              => $voucher_history_id,
        'final_price'            => $final_price,
        'trainer_message'        => $session_amount['trainer_message'],
        'wallet_amount'          => $session_amount['wallet_amount'],
        'payment_gateway_amount' => $session_amount['total_amount_gateway'],
        'created_date '          => Time::now()
        );
    $package = $this->Custom_packages_history->newEntity();
    $package = $this->Custom_packages_history->patchEntity($package, $customPackageArr);
    $result  = $this->Custom_packages_history->save($package);
    $clid    = $result->id;

    if($session_amount['wallet_amount'] > 0){
      $wallet_details = $this->Total_wallet_ammount->find()->where(['user_id' => $this->data['id']])->toArray();
      $wallet_current_balance = round($wallet_details[0]['total_ammount'] - $session_amount['wallet_amount'],2);
      $this->total_wallet_ammount->query()->update()->set(['total_ammount'=> $wallet_current_balance])->where(['user_id' => $this->data['id']])->execute();
    }
    $txnArr = array(
          'trainee_id' => $this->data['id'],
          'txn_name'   => 'Purchase Custom Packages',
          'txn_type'   => 'Debit',
          'ammount'    => $session_amount['total_amount_gateway'] + $session_amount['wallet_amount'],
          'status'     => $status,
          'txn_id'     => $txnid,
          'added_date' => Time::now()
        );
    if($session_amount['wallet_amount'] == 0 && $session_amount['total_amount_gateway'] > 0){
      $txnArr['payment_type'] = 'Paypal';
    }
    if($session_amount['total_amount_gateway'] == 0 && $session_amount['wallet_amount'] > 0){
      $txnArr['payment_type'] = 'Wallet';
    }
    if($session_amount['total_amount_gateway'] > 0 && $session_amount['wallet_amount'] > 0){
      $txnArr['payment_type'] = 'Paypal + Wallet';
    }
    $txns   = $this->Trainee_txns->newEntity();
    $txns   = $this->Trainee_txns->patchEntity($txns, $txnArr);
    $result = $this->Trainee_txns->save($txns);
    $total_orders = $this->Orders->find()->where(['trainee_id' => $this->data['id']])->count();
    $orderArr = array(
        'trainee_id'   => $this->data['id'],
        'app_id'       => $clid,
        'order_amount' => $session_amount['total_amount_gateway'] + $session_amount['wallet_amount'],
        'order_no'     => 'SASK#'.$total_orders,
        'order_type'   => '1',
        'order_status' => '0',
        'created_date' => Time::now()
        );
    $orders = $this->Orders->newEntity();
    $orders = $this->Orders->patchEntity($orders, $orderArr);
    $result = $this->Orders->save($orders);
    $notificationArr = array(
        'noti_type'          => 'Custom Packages',
        'parent_id'          => $clid,
        'noti_sender_type'   => 'trainee',
        'noti_sender_id'     => $this->data['id'],
        'noti_receiver_type' => 'trainer',
        'parent_id_status'   => 1,
        'noti_receiver_id'   => $package_details[0]['trainer_id'],
        'noti_message'       => 'You have new request of purchased custom packages',
        'noti_added_date'    => Time::now()
        );
    $notifications = $this->Notifications->newEntity();
    $notifications = $this->Notifications->patchEntity($notifications, $notificationArr);
    $result = $this->Notifications->save($notifications);

    $trainer_earning_fee = $this->Fees->find()->where(['type' => 'Trainer Earning'])->toArray();
    $trainer_wallet_fee  = $this->Fees->find()->where(['type' => 'Administration'])->toArray();
    $wallet_details1     = $this->Total_wallet_ammount->find()->where(['user_id' => $package_details[0]['trainer_id']])->toArray();
    $session_price       = $final_price;
    $total_deduct_amount = ($session_price * ($trainer_earning_fee[0]['txn_fee'] + $trainer_wallet_fee[0]['txn_fee']))/100;
    $final_wallet_amount = round($session_price - $total_deduct_amount,2);
    
    if(empty($wallet_details1)){
        $walletArr = array(
            'user_id'       => $package_details[0]['trainer_id'],
            'user_type'     => 'trainer',
            'total_ammount' => $final_wallet_amount,
            'added_date'    => Time::now()
        );
        $wallet = $this->Total_wallet_ammount->newEntity();
        $wallet = $this->Total_wallet_ammount->patchEntity($wallet, $walletArr);
        $result = $this->Total_wallet_ammount->save($wallet);
    }else{
        $wallet_current_balance = round($wallet_details1[0]['total_ammount'] + $final_wallet_amount,2);
        $this->total_wallet_ammount->query()->update()->set(['total_ammount'=> $wallet_current_balance])->where(['user_id' => $package_details[0]['trainer_id']])->execute();
    }
    $trainer_txn_arr = array(
        'trainer_id'  => $package_details[0]['trainer_id'],
        'txn_name'    => 'Custom Package Earning',
        'txn_type'    => 1,
        'txn_id'      => $package_details[0]['trainer_id'].uniqid(),
        'parent_id'   => $clid,
        'total_amount'=> $package_price,
        'administration_fee'=> ($package_price * $trainer_wallet_fee[0]['txn_fee'])/100,
        'service_fee'=> ($package_price * $trainer_earning_fee[0]['txn_fee'])/100,
        'added_date' => Time::now()
      );
    $txns   = $this->Trainer_txns->newEntity();
    $txns   = $this->Trainer_txns->patchEntity($txns, $trainer_txn_arr);
    $result = $this->Trainer_txns->save($txns);
    $this->request->session()->delete('custom_packages');
    $this->request->session()->delete('custom_packages_details');
  }

  public function getNotificationData()
  {
      if($this->request->is('ajax'))
      {
        $appid = $this->request->data['id'];
        $app_details = $this->conn->execute('SELECT *,`a`.`trainee_status` AS `trainee_app_status`,`a`.`trainer_status` AS `trainer_app_status` FROM `appointments` AS `a` INNER JOIN `trainees` AS `t` ON `a`.`trainee_id` = `t`.`user_id` WHERE `a`.`id` ='.$appid)->fetchAll('assoc');
        $app_details['total_session'] = count(unserialize($app_details[0]['session_data']));
        $app_details['session_data'] = unserialize($app_details[0]['session_data']);
        $this->set('message', $app_details);
        $this->set('_serialize',array('message'));
        $this->response->statusCode(200);
      }
  }

  public function getSpecialOfferData()
  {
      if($this->request->is('ajax'))
      {
        $appid = $this->request->data['id'];
        $app_details = $this->conn->execute('SELECT *,`a`.`id` AS `app_id` FROM `appointments` AS `a` INNER JOIN `trainers` AS `t` ON `a`.`trainer_id` = `t`.`user_id` WHERE `a`.`id` ='.$appid)->fetchAll('assoc');
        $app_details['total_session'] = count(unserialize($app_details[0]['session_data']));
        $app_details['session_data'] = unserialize($app_details[0]['session_data']);
        $this->set('message', $app_details);
        $this->set('_serialize',array('message'));
        $this->response->statusCode(200);
      }
  }

  public function specialOfferrespond()
  {
      $type  = $this->request->query['type'];
      $appid = base64_decode($this->request->query['appid']);
      if($type == 1){ // for approve
          $this->approveAppointment($appid);
          $this->request->session()->write('sucess_alert','Appointment successfully approved !!');
          return $this->redirect('/trainees');
      }else{ // for decline
          $this->declineAppointment($appid);
          $this->request->session()->write('sucess_alert','Appointment successfully declined !!');
          return $this->redirect('/trainees');
      }
  }

  public function approveAppointment($appid)
  {
    $appoinment_details = $this->Appointments->find()->where(['id' => $appid])->toArray();
    $appArr = array(
            'trainer_status' => 1,
            'trainee_status' => 1
        );
    $this->appointments->query()->update()->set($appArr)->where(['id' => $appid])->execute();
    $appSessionArr = array('user_status' => 1);
    $this->appointment_sessions->query()->update()->set($appSessionArr)->where(['appId' => $appid])->execute();
    $notificationArr = array(
            'noti_type'          => 'Approve Special Offer',
            'parent_id'          => $appid,
            'noti_sender_type'   => 'trainee',
            'noti_sender_id'     => $appoinment_details[0]['trainee_id'],
            'noti_receiver_type' => 'trainer',
            'parent_id_status'   => 1,
            'noti_receiver_id'   => $appoinment_details[0]['trainer_id'],
            'noti_message'       => 'has approved special offer request',
            'noti_added_date'    => Time::now()
        );
    $notifications = $this->Notifications->newEntity();
    $notifications = $this->Notifications->patchEntity($notifications, $notificationArr);
    $result = $this->Notifications->save($notifications);

    $trainer_earning_fee = $this->Fees->find()->where(['type' => 'Trainer Earning'])->toArray();
    $trainer_wallet_fee  = $this->Fees->find()->where(['type' => 'Administration'])->toArray();
    $wallet_details      = $this->Total_wallet_ammount->find()->where(['user_id' => $appoinment_details[0]['trainer_id']])->toArray();

    if($appoinment_details[0]['final_price'] == $appoinment_details[0]['special_offer_price']){
        $session_price       = $appoinment_details[0]['final_price'];
        $total_deduct_amount = ($session_price * ($trainer_earning_fee[0]['txn_fee'] + $trainer_wallet_fee[0]['txn_fee']))/100;
        $final_wallet_amount = round($session_price - $total_deduct_amount,2);
    }else{
        $discount_amount     = $appoinment_details[0]['final_price'] - $appoinment_details[0]['special_offer_price'];
        $session_price       = $appoinment_details[0]['special_offer_price'];
        $total_deduct_amount = ($session_price * ($trainer_earning_fee[0]['txn_fee'] + $trainer_wallet_fee[0]['txn_fee']))/100;
        $final_wallet_amount = round($session_price - $total_deduct_amount,2);
        $wallet_details_trainee = $this->Total_wallet_ammount->find()->where(['user_id' => $this->data['id']])->toArray();
        $trainee_txns_arr = array(
           'trainee_id' => $this->data['id'],
           'txn_name'   => 'Special Offer Discount',
           'payment_type'=> 'Wallet',
           'txn_type'   => 'Credit',
           'txn_id'     => $this->data['id']."-".uniqid(),
           'ammount'    => $discount_amount,
           'status'     => 'Approved',
           'added_date' => Time::now()
          );    
        $txns   = $this->Trainee_txns->newEntity();
        $txns   = $this->Trainee_txns->patchEntity($txns, $trainee_txns_arr);
        $result = $this->Trainee_txns->save($txns);   
        if(empty($wallet_details_trainee)){
            $walletArrTrainee = array(
                'user_id'       => $this->data['id'],
                'user_type'     => 'trainee',
                'total_ammount' => $discount_amount,
                'added_date'    => Time::now()
            );
            $wallet = $this->Total_wallet_ammount->newEntity();
            $wallet = $this->Total_wallet_ammount->patchEntity($wallet, $walletArrTrainee);
            $result = $this->Total_wallet_ammount->save($wallet);
        }else{
            $wallet_current_balance_trainee = round($wallet_details_trainee[0]['total_ammount'] + $discount_amount,2);
            $this->total_wallet_ammount->query()->update()->set(['total_ammount'=> $wallet_current_balance_trainee])->where(['user_id' => $this->data['id']])->execute();
        } 
    }
    
    if(empty($wallet_details)){
        $walletArr = array(
            'user_id'       => $appoinment_details[0]['trainer_id'],
            'user_type'     => 'trainer',
            'total_ammount' => $final_wallet_amount,
            'added_date'    => Time::now()
        );
        $wallet = $this->Total_wallet_ammount->newEntity();
        $wallet = $this->Total_wallet_ammount->patchEntity($wallet, $walletArr);
        $result = $this->Total_wallet_ammount->save($wallet);
    }else{
        $wallet_current_balance = round($wallet_details[0]['total_ammount'] + $final_wallet_amount,2);
        $this->total_wallet_ammount->query()->update()->set(['total_ammount'=> $wallet_current_balance])->where(['user_id' => $appoinment_details[0]['trainer_id']])->execute();
    }
    $trainer_txn_arr = array(
        'trainer_id'  => $appoinment_details[0]['trainer_id'],
        'txn_name'    => 'Rate Plan Earning',
        'txn_type'    => 0,
        'txn_id'      => $appoinment_details[0]['trainer_id'].uniqid(),
        'parent_id'   => $appid,
        'special_offer_price' => $appoinment_details[0]['special_offer_price'],
        'total_amount'=> $session_price,
        'administration_fee'=> ($session_price * $trainer_wallet_fee[0]['txn_fee'])/100,
        'service_fee'=> ($session_price * $trainer_earning_fee[0]['txn_fee'])/100,
        'added_date' => Time::now()
      );
    $txns   = $this->Trainer_txns->newEntity();
    $txns   = $this->Trainer_txns->patchEntity($txns, $trainer_txn_arr);
    $result = $this->Trainer_txns->save($txns);
  }

  public function declineAppointment($appid)
  {
      $appoinment_details = $this->Appointments->find()->where(['id' => $appid])->toArray();
      $appArr = array(
              'trainer_status' => 2,
              'trainee_status' => 2
          );
      $this->appointments->query()->update()->set($appArr)->where(['id' => $appid])->execute();
      $appSessionArr = array('user_status' => 2);
      $this->appointment_sessions->query()->update()->set($appSessionArr)->where(['appId' => $appid])->execute();
      $notificationArr = array(
              'noti_type'          => 'Decline Special Offer',
              'parent_id'          => $appid,
              'noti_sender_type'   => 'trainee',
              'parent_id_status'   => 2,
              'noti_sender_id'     => $appoinment_details[0]['trainee_id'],
              'noti_receiver_type' => 'trainer',
              'noti_receiver_id'   => $appoinment_details[0]['trainer_id'],
              'noti_message'       => 'has declined special offer request',
              'noti_added_date'    => Time::now()
          );
      $notifications = $this->Notifications->newEntity();
      $notifications = $this->Notifications->patchEntity($notifications, $notificationArr);
      $result = $this->Notifications->save($notifications);
      $refund_amount = $appoinment_details[0]['final_price'];
      
      $trainee_txns_arr = array(
           'trainee_id' => $appoinment_details[0]['trainee_id'],
           'txn_name'   => 'Decline Appoinment',
           'payment_type'=> 'Wallet',
           'txn_type'   => 'Credit',
           'txn_id'     => $appoinment_details[0]['trainee_id']."-".uniqid(),
           'ammount'    => $refund_amount,
           'status'     => 'Approved',
           'added_date' => Time::now()
          );    
      $txns   = $this->Trainee_txns->newEntity();
      $txns   = $this->Trainee_txns->patchEntity($txns, $trainee_txns_arr);
      $result = $this->Trainee_txns->save($txns);   
      $wallet_details = $this->Total_wallet_ammount->find()->where(['user_id' => $appoinment_details[0]['trainee_id']])->toArray();
      if(empty($wallet_details)){
          $walletArr = array(
              'user_id'       => $appoinment_details[0]['trainee_id'],
              'user_type'     => 'trainee',
              'total_ammount' => $refund_amount,
              'added_date'    => Time::now()
          );
          $wallet = $this->Total_wallet_ammount->newEntity();
          $wallet = $this->Total_wallet_ammount->patchEntity($wallet, $walletArr);
          $result = $this->Total_wallet_ammount->save($wallet);
      }else{
          $wallet_current_balance = round($wallet_details[0]['total_ammount'] + $refund_amount,2);
          $this->total_wallet_ammount->query()->update()->set(['total_ammount'=> $wallet_current_balance])->where(['user_id' => $appoinment_details[0]['trainee_id']])->execute();
      } 
  }

  public function reportpdf()
  {
    $tid = $this->request->query['id'];
    $txn_details = $this->conn->execute("SELECT * FROM `trainee_txns` AS `tx` INNER JOIN `trainees` AS `t` ON `tx`.`trainee_id` = `t`.`user_id` WHERE `tx`.`id` = ".$tid)->fetchAll('assoc');
    $filename = 'Transaction '.$txn_details[0]['txn_id'].' '.date('Y-m-d').'.pdf';
    $html  = "";
    $html .= "<div style='width:100%; float:left;'><div style='float:left; width:50%;'><img style='width:300px;' src='".$this->request->webroot."img/belibit_tv_logo_old1.png'></div><div style='float:right; width:200px;'><h1 style='color:#666;'>INVOICE</h1></div></div> ";
    $html .= "<div style='width:100%; float:left;'> <div style='float:left; width:50%;'><p style='font-size:14px; color:#666; margin:0px;'>You Tag Media & Business Solutions, Inc 1950 Broad Street, Unit 209 Regina, SK S4P 1X6 Canada</p><p style='font-size:14px; color:#666;  margin:0px;'>help@virtualtrainr.com</p><p style='font-size:14px; color:#666; margin:0px;'>+403-800-4843</p><br><br><h3 style='font-size:22px; color:#666; margin:0px 0px 5px 0px;'>Invoice to: </h3><p style='font-size:14px; padding:5px 0px; color:#666; margin:0px;'>Name : ".ucwords($txn_details[0]['trainee_name']." ".$txn_details[0]['trainee_lname'])."</div></div>";
    $html .= "<div style='width:100%; float:left;'><br><br><h3 style='font-size:22px; color:#666; margin:0px 0px 5px 0px;'>Details: </h3>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Transaction Date : ".date('d F Y, h:i A', strtotime($txn_details[0]['added_date']))."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Transaction Name : ".$txn_details[0]['txn_name']."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Transaction Id   : ".$txn_details[0]['txn_id']."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Transaction Type : ".$txn_details[0]['txn_type']."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Amount : $".$txn_details[0]['ammount']."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Status : ".$txn_details[0]['status']."</p>
              </div>";
    $this->Custom->downloadpdf($html,$filename);
  }

  public function content_template(){

  }

  public function deleteMessages()
  {
    if($this->request->is('ajax'))
      {
         $chatids = $this->request->data['chatids'];
         $this->conn->execute('DELETE FROM chating WHERE chat_id IN ('.$chatids.')');
         $this->set('message', 'success');
         $this->set('_serialize',array('message'));
         $this->response->statusCode(200);
      }
  }

  public function getVideoCalls()
  {
    if($this->request->is('ajax'))
      {
        $date = $this->request->data['date'];
        $time = $this->request->data['time'];
        $trainee_id = $this->data['id'];
        $video_calls = $this->conn->execute("SELECT * FROM `video_calls` AS `v` INNER JOIN `trainers` AS `tr` ON `tr`.`user_id` = `v`.`trainer_id` INNER JOIN `trainees` AS `te` ON `te`.`user_id` = `v`.`trainee_id`  WHERE `v`.`date` ='".$date."' AND `v`.`start_time` ='".$time."' AND `v`.`status` = 0 AND `v`.`trainee_id` =".$trainee_id)->fetchAll('assoc');
        if(!empty($video_calls)){
          $city = $this->Custom->getCityName($video_calls[0]['trainer_city']);
        }else{
          $city = "";
        }
        $this->set('city', $city);
        $this->set('message', $video_calls);
        $this->set('_serialize',array('message','city'));
        $this->response->statusCode(200);
      }
  }

  public function getneratePDFReport($type)
  {
    $html  = "";
    $html .= "<div style='width:100%; float:left;'><div style='float:left; width:50%;'><img style='width:300px;' src='".$this->request->webroot."img/belibit_tv_logo_old1.png'></div><div style='float:right; width:200px;'><h1 style='color:#666;'>Report</h1></div></div> ";
    $html .= "<div style='width:100%; float:left;'> <div style='float:left; width:50%;'><p style='font-size:14px; color:#666; margin:0px;'>You Tag Media & Business Solutions, Inc 1950 Broad Street, Unit 209 Regina, SK S4P 1X6 Canada</p><p style='font-size:14px; color:#666;  margin:0px;'>help@virtualtrainr.com</p><p style='font-size:14px; color:#666; margin:0px;'>+403-800-4843</p><br><br></div></div>";
     if($type == "txn"){
      $txns_details = $this->Trainee_txns->find()->where(['trainee_id' => $this->data['id']])->order(['id' => 'DESC'])->toArray();
      $html .= " 
            <div style='font-size:20px; width:2250px; margin:0; font-family: 'HelveticaLTStdLight';'>
             <h4 style='color:#575757;'>Transactions History</h4>
             <div style=' width:2250px; margin:0;'>
               <div style='height:25px; color:#575757; font-weight:bold; padding-top:5px; text-align:center; border:1px solid #999; float:left; width:120px; font-size:14px; margin:0;'>
                 TRANS #
               </div>
               <div style='height:25px; color:#575757; font-weight:bold; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>  
               TRANSACTION     
               </div>
               <div style='height:25px; color:#575757; font-weight:bold; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:140px; margin:0;'>
                TXN-ID
               </div>
               <div style='height:25px; color:#575757; font-weight:bold; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                AMOUNT
               </div>
               <div style='height:25px; color:#575757; font-weight:bold; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                Date
               </div>";
        $i = 1;
        foreach($txns_details as $t){ 
          $html .= "<div style='height:85px; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                    SK".$i."
                   </div>";
          $html .= "<div style='height:85px; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                    ".$t['txn_name']."
                   </div>";
          $html .= "<div style='height:85px; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:140px; margin:0;'>
                    ".$t['txn_id']."
                   </div>";
          $html .= "<div style='height:85px; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                    $".$t['ammount']."
                   </div>";
          $html .= "<div style='height:85px; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                    ".$t['added_date']."
                   </div>";
        $i++; } 
        $html .= " </div></div>";
     $filename = "Transactions History Report ".date('Y-m-d').".pdf";  
    }
    $this->Custom->downloadpdf($html,$filename);
  }

  public function getnerateExcelReport($type)
  {
     if($type == "txn"){
      $headingArr = array('TRANS #','TRANSACTION NAME','TRANSACTION ID','TRANSACTION TYPE','AMOUNT','DATE');
      $txns_details = $this->conn->execute("SELECT * FROM `trainee_txns` AS `t` WHERE `t`.`trainee_id` ='".$this->data['id']."' ORDER BY `t`.`id` DESC ")->fetchAll('assoc');
      $final_array = array();
      $i = 1;
      foreach ($txns_details as $key => $v) {
        $index = ($i >= 10) ? $i : "0".$i;
        $row['txn']      = 'SK'.$index;
        $row['txn_name'] = $v['txn_name'];
        $row['txn_id']   = $v['txn_id'];
        $row['txn_type'] = $v['txn_type'];
        $row['ammount']  = "$".$v['ammount'];
        $row['added_date'] = $v['added_date'];
        $i++;
        array_push($final_array, array_values($row));
      }
      $filename = "Transactions History Report ".date('Y-m-d').".csv";  
    }
    $this->Custom->exportCSV($filename,$final_array,$headingArr);
  }

  public function creditCardResponse()
  {
    $response = $_GET;
    if($response['ssl_result'] == 0){
      $trainee_wallet_arr = array(
        'trainee_id' => $this->data['id'],
        'payment_type' => 'Credit Card',
        'txn_id' => $response['ssl_txn_id'],
        'ammount' => $response['ssl_amount'],
        'txn_type' => 'Credit',
        'status' =>  $response['ssl_result_message'],
        'added_date' => Time::now()
      );
      $user = $this->Trainee_txns->newEntity();
      $user = $this->Trainee_txns->patchEntity($user, $trainee_wallet_arr);
      $result = $this->Trainee_txns->save($user);

      $total_ammount = $this->Total_wallet_ammount->find()->where(['user_id' => $this->data['id'],'user_type' => 'trainee'])->toArray();
      if(empty($total_ammount))
      {
        $total_wallet_ammount_arr = array(
          'user_id' => $this->data['id'],
          'user_type' => 'trainee',
          'total_ammount' => $response['ssl_amount'],
          'status' =>  0,
          'added_date' => Time::now()
        );
      $user = $this->Total_wallet_ammount->newEntity();
      $user = $this->Total_wallet_ammount->patchEntity($user, $total_wallet_ammount_arr);
      $result = $this->Total_wallet_ammount->save($user);
      }
      else
        {
          $total_wallet_ammount_arr = array(
            'total_ammount' => $total_ammount[0]['total_ammount'] + $response['ssl_amount'],
            );
          $this->total_wallet_ammount->query()->update()->set($total_wallet_ammount_arr)->where(['user_id' => $this->data['id'],'user_type' => 'trainee'])->execute();
        }
      $this->request->session()->write('sucess_alert','Your Transaction successfully approved');
    }else{
      $this->request->session()->write('error_alert','Your Transaction was declined !!');
    }
    return $this->redirect('/trainees/wallet/');
  }

  public function creditCardError()
  {
    $this->request->session()->write('error_alert',$_GET['errorName']);
    return $this->redirect('/trainees/wallet/');
  }

  public function customCreditCardError()
  {
    $this->request->session()->write('error_alert',$_GET['errorName']);
    return $this->redirect('/trainees/customPackageOrder/');
  }

  public function customCreditCardResponse()
  {
    if($_GET['ssl_result'] == 0){
      $this->insertPackagePaymentDetails($_GET['ssl_result_message'],$_GET['ssl_txn_id']);
      $this->request->session()->write('sucess_alert','Congratulation your custom package order successfully placed !!');
    }else{
      $this->request->session()->write('error_alert','Your Transaction has been declined !!');
    }
    return $this->redirect('/trainees');
  }

   public function ratePlansCreditCardError()
  {
    $this->request->session()->write('error_alert',$_GET['errorName']);
    return $this->redirect('/trainees');
  }

  public function ratePlansCreditCardResponse()
  {
    if($_GET['ssl_result'] == 0){
      $this->insertSessionPaymentDetails($_GET['ssl_result_message'],$_GET['ssl_txn_id']);
      $this->request->session()->write('sucess_alert','Congratulation your rate plans order successfully placed !!');
    }else{
      $this->request->session()->write('error_alert','Your Transaction has been declined !!');
    }
    return $this->redirect('/trainees');
  }

}

