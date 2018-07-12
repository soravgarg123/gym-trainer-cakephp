<?php

namespace App\Controller;

use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;
use Cake\Network\Email\Email;
use mPDF;

class TrainersController extends AppController
{
	public function beforeFilter(Event $event)
    {
        $action = $this->request->params['action'];
    	  $this->blockIP();
        $this->checkSession();
        parent::beforeFilter($event);
        $this->loadComponent('Auth'); 
        $this->Auth->allow(['addTrainer','downloadDocument','checkvalidip']);
        $this->data = $this->Custom->getSessionData();
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
    $messages = $this->conn->execute("SELECT * FROM `chating` AS `c` INNER JOIN `trainees` AS `t` ON `c`.`chat_sender_id` = `t`.`user_id` WHERE `c`.`chat_status` = 1 AND `c`.`chat_reciever_id` = ".$this->data['id']." ORDER BY `c`.`chat_id` DESC LIMIT 20")->fetchAll('assoc');
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
		$profile_details = $this->Trainers->find()->where(['user_id' => $this->data['id']])->toArray();
    $notes = $this->Notes->find()->where(['trainer_id' => $this->data['id']])->toArray();
    $total_wallet_ammount = $this->Total_wallet_ammount->find()->where(['user_id' => $this->data['id']])->toArray();
    $messages = $this->getChatMessages();
    $pending_appointments  = $this->conn->execute('SELECT *,`a`.`id` AS `app_id` FROM `appointments` AS `a` INNER JOIN `trainees` AS `t` ON `a`.`trainee_id` = `t`.`user_id` WHERE `a`.`trainer_id` = '.$this->data['id'].' AND `a`.`trainer_status` = 0 AND `a`.`pay_status` = 1 AND `a`.`trainee_status` = 0 AND `a`.`created_date` >= DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY `a`.`id` DESC')->fetchAll('assoc');
    $visitors_count  = $this->conn->execute('SELECT *,COUNT(*) AS `total_visitors` FROM `visitors` WHERE `profile_id` = '.$this->data['id'].' GROUP BY `latitude`,`lonigtude`')->fetchAll('assoc');
    $final_visitors_count = array();
    if(!empty($visitors_count)){
        foreach ($visitors_count as $key => $v) {
          $row['zoomLevel'] = 5;
          $row['scale']     = 0.5;
          $row['title']     = str_replace(" ", "-", $v['address'])." (".$v['total_visitors'].")";
          $row['latitude']  = $v['latitude'];
          $row['longitude'] = $v['lonigtude'];
          $row['main'] = '1234';
          array_push($final_visitors_count, $row);
        }
    }else{
        $final_visitors_count = array();
    }
    $upcomingArr = $this->getUpcomingAppointments(date('Y-m-d')); 
    $app_counts  = $this->getUpcomingAppointmentsCountByDate(); 
    $this->set('app_counts', $app_counts);
    $this->set("from_id",$this->data['id']);
    $this->set('final_visitors_count', $final_visitors_count);
    $this->set('notes', $notes);
    $this->set('messages', $messages);
    $this->set('upcomingArr', $upcomingArr);
    $this->set('pending_appointments', $pending_appointments);
    $this->set('total_wallet_ammount', $total_wallet_ammount);
    $this->set('profile_details', $profile_details);
	}

  public function getVisitorsData()
  {
    $title = $this->request->data['title'];
    $html = '';
    $visitors = $this->conn->execute('SELECT * FROM `visitors` As v inner join trainees as t ON t.user_id = v.viewer_id WHERE v.address = "'.$title.'" AND v.profile_id = '. $this->data['id'] .' ORDER BY v.visitor_id DESC')->fetchAll('assoc');
    if(!empty($visitors)){
      foreach($visitors as $v){
        $html .= '<div class="session_user"><a target="_blank" href="'.$this->request->webroot.'traineeProfile/'.base64_encode($v['user_id']).'">';
        $html .= '<div class="img_user_main"><div class="small_circle"></div><div class="img_user"><img class="img-responsive" id="app-view-user-img" src="'.$this->Custom->getImageSrc('uploads/trainee_profile/'.$v['trainee_image']).'"></div>';
        $html .= '</div><div id="appo-view-profile-view" class="img_text_main">'.ucwords($v['trainee_name']." ".$v['trainee_lname']).'</div></a></div>';
      }
    }
    $this->set('message', $html);
    $this->set('_serialize',array('message'));
    $this->response->statusCode(200);
  }

	public function profile()
	{
		$data = $this->Custom->getSessionData();
		$gallery_img = $this->Profile_images_videos->find()->where(['piv_user_id' => $data['id'], 'piv_attachement_type' => 'image'])->order(['piv_id' => 'DESC'])->toArray();
		$profile_details = $this->Trainers->find()->where(['user_id' => $data['id']])->toArray();
    $rate_plans = $this->Trainer_ratemaster->find()->where(['trainer_id' => $data['id']])->toArray();
    $custom_packages = $this->Trainer_packagemaster->find()->where(['trainer_id' => $data['id']])->toArray();
		$quotes = $this->Latest_things->find()->where(['lt_type' => 'Quotes', 'lt_user_id' => $data['id']])->order(['id' => 'DESC'])->toArray();
		$gallery_videos = $this->Profile_images_videos->find()->where(['piv_user_id' => $data['id'], 'piv_attachement_type' => 'video'])->order(['piv_id' => 'DESC'])->toArray();
    $certificates = $this->Documents->find()->where(['trainer_id' => $this->data['id'],'document_type' => 'Certification'])->order(['id' => 'DESC'])->toArray();
    $resume = $this->Documents->find()->where(['trainer_id' => $this->data['id'],'document_type' => 'Resume'])->order(['id' => 'DESC'])->toArray();
    $feedback = $this->conn->execute('SELECT * FROM `ratings` As r inner join trainees as t ON t.user_id = r.rating_trainee_id WHERE r.rating_trainer_id = '. $this->data['id'] .' ORDER BY r.id DESC')->fetchAll('assoc');
    $this->set('feedback',$feedback);
    $this->set('resume',$resume);
    $this->set('certificates',$certificates);
    $this->set('quotes',$quotes);
		$this->set('rate_plans', $rate_plans);
    $this->set('custom_packages', $custom_packages);
    $this->set('profile_details', $profile_details);
		$this->set('gallery_img', $gallery_img);
		$this->set('gallery_videos', $gallery_videos);
		$this->render('/Trainers/trainer_profile');
	}

	public function addTrainer()
	{
		if($this->request->is('ajax'))
     	{
         $feedback = $this->conn->execute('SELECT * FROM `users` WHERE `username` = "'.$_POST['trainer_email'].'" ORDER BY id DESC')->fetchAll('assoc');   
    if(empty($feedback)){
            $trainer_email = $_POST['trainer_email'];
            $admin_email = "business@virtualtrainr.com";
     		$data = array(
    				'username' => $_POST['trainer_email'],
    				'password' => $_POST['trainer_password'],
    				'display_name' => $_POST['trainer_displayName'],
    				'user_type' => 'trainer',
    				'user_status' => 0,
    				'created' => Time::now(),
    			);
    		$article = $this->users->newEntity($data);
    		$result1 = $this->users->save($article);
    		$user_id = $result1->id;

            $trainer_data = $this->request->data;
            $trainer_data['trainer_image'] = 'default.png';
            $trainer_data['trainer_status'] = 0;
            $trainer_data['trainer_added_date'] = date("Y-m-d H:i:s");
            $address = $this->Custom->getCityName($trainer_data['trainer_city']).' '.$this->Custom->getStateName($trainer_data['trainer_state']).' '.$this->Custom->getCountryName($trainer_data['trainer_country']);
            $loc = $this->Custom->getlatlng($address);
    		
            $trainer_data['lat'] = $loc["latitude"];
            $trainer_data['lng'] = $loc["longitude"];
            
            $user = $this->Trainers->newEntity();
        		$user = $this->Trainers->patchEntity($user, $trainer_data);
        		$user['user_id'] = $user_id;
        		$result = $this->Trainers->save($user);
        		$lid = $result->id; // get last insert id

            $resumeArr = array(
                'document_name' => '',
                'document_file' => $this->Custom->fileUploading('resume_file','documents'),
                'document_type' => 'resume',
                'trainer_id'    =>  $user_id,
                'added_date'    => Time::now()
                );

            $user = $this->Documents->newEntity();
            $user = $this->Documents->patchEntity($user, $resumeArr);
            $result = $this->Documents->save($user);

            $certificateArr = array(
                'document_name' => $_POST['trainer_certificate_name'],
                'document_file' => $this->Custom->fileUploading('certificate_file','documents'),
                'document_type' => 'certifications',
                'trainer_id'    =>  $user_id,
                'added_date'    => Time::now()
                );

            $user = $this->Documents->newEntity();
            $user = $this->Documents->patchEntity($user, $certificateArr);
            $result = $this->Documents->save($user);

            $email_message = "";
            $email_message .= "<html>";
            $email_message .= "<body>";
            $email_message .= "<center>";
            $email_message .= "<img style='width:200px' src='https://" . env('SERVER_NAME')."/img/belibit_tv_logo_old1.png' class='img-responsive'></br></br></center>";
            $email_message .= "<strong>Hello ".$_POST['trainer_name']." ".$_POST['trainer_lname'].",</strong></br></br>";
            $email_message .= "<p>Welcome to Virtual TrainR! We thank you for your interest in becoming a part of our community. Your application has been received and will be reviewed shortly. Our recruitment team will contact you within 48 hours to get you started. </p>" ;
            $email_message .= "<p>For questions and support please email <a href='mailto:support@virtualtrainr.com'>support@virtualtrainr.com</a> and a member of our support team will be in touch with you right away.We appreciate your patience.  </p>" ;
            $email_message .= "<p>Welcome to the Future of Fitness. </p>";
            $email_message .= "</body>";
            $email_message .= "</html>";


            $email = new Email('default');
            $email->emailFormat('html')
                  ->to($trainer_email)
                  ->from($admin_email)
                  ->subject('Virtual TrainR Signup')
                  ->send($email_message);

            $admin_email_message = "";
            $admin_email_message .= "<html>";
            $admin_email_message .= "<body>";
            $admin_email_message .= "<center>";
            $admin_email_message .= "<img style='width:200px' src='https://" . env('SERVER_NAME')."/img/belibit_tv_logo_old1.png' class='img-responsive'></br></br></center>";
            $admin_email_message .= "<strong>Hello,</strong></br></br>";
            $admin_email_message .= "<p> New Trainer has registered on Virtual TrainR</p>" ;
            $admin_email_message .= "<p>Link: <a href='https://" . env('SERVER_NAME')."/trainerProfile/".base64_encode($user_id)."' target='_blank'> Click here  </a> </p>";
            $admin_email_message .= "</body>";
            $admin_email_message .= "</html>";

            $email1 = new Email('default');
            $email1->emailFormat('html')
                  ->to('business@theyoutag.com')
                  ->from($admin_email)
                  ->subject('Trainer Signup')
                  ->send($admin_email_message);

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

    public function deleteProfile()
    {
        if($this->request->is('ajax'))
        {
            $this->trainers->query()->update()->set(['trainer_image' => "default.png"])->where(['user_id' => $this->data['id']])->execute();
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

    public function deleteNotes()
    {
      if($this->request->is('ajax'))
        {
           $notesid = (int) $this->request->data['notesid'];
            $this->conn->execute('DELETE FROM notes WHERE id ='.$notesid);
           $this->set('message', 'success');
           $this->set('_serialize',array('message'));
           $this->response->statusCode(200);
        }
    }

    public function getNotesData()
    {
      if($this->request->is('ajax'))
        {
           $notesid = (int) $this->request->data['notesid'];
           $notes = $this->Notes->find()->where(['id' => $notesid])->toArray();
           $this->set('message', $notes);
           $this->set('_serialize',array('message'));
           $this->response->statusCode(200);
        }
    }


    public function inbox()
    {
      $files = $this->conn->execute(' SELECT * FROM `files` WHERE from_id = '.$this->data['id'].' OR to_id = '.$this->data['id'].' ORDER BY id DESC ')->fetchAll('assoc');
      $profile_details = $this->Trainers->find()->where(['user_id' => $this->data['id']])->toArray();
      $this->set('files', $files);
      $this->set('profile_details', $profile_details);
    }

	public function addGalleryImage()
		{
			if($this->request->is('ajax'))
         	{
         		$fileName = $this->Custom->fileUploading('gallery_img','trainer_gallery'); 
         		$data = $this->Custom->getSessionData();
         		$data = array(
         			'piv_attachement_type' => 'image',
         			'piv_name' => $fileName,
         			'piv_user_type' => 'trainer',
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

		public function addVideos()
		{
			if($this->request->is('ajax'))
         	{
         		$fileName = $this->Custom->fileUploading('trainer_videos','trainer_videos'); 
         		$data = $this->Custom->getSessionData();
         		$data = array(
         			'piv_attachement_type' => 'video',
         			'piv_name' => $fileName,
         			'piv_user_type' => 'trainer',
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

	public function completeProfile()
	{
		
		 if(isset($_REQUEST['addgym'])){
					$data=array(
					'name'=>$_REQUEST['name'],
					'address'=>$_REQUEST['address'],
					'latitude'=>$_REQUEST['lat'],
					'longitude'=>$_REQUEST['long'],
					'trainer_id'=>$this->data['id']
					);
					 $this->conn->insert('gym',$data);
           $this->Flash->success('Gym Successfully Added', ['key' => 'edit9']);
           return $this->redirect('/trainers/completeProfile/addgym');
									  
		}
		$data = $this->Custom->getSessionData();
		$countries = $this->Countries->find('all')->toArray();
		$profile_details = $this->Trainers->find()->where(['user_id' => $this->data['id']])->toArray();
		
		$gyms = $this->gym->find()->where(['trainer_id' => $this->data['id']])->toArray();
		
		$quotes = $this->Latest_things->find()->where(['lt_type' => 'Quotes', 'lt_user_id' => $data['id']])->order(['id' => 'DESC'])->toArray();
		$country_id = $profile_details[0]['trainer_country'];
        $state_id = $profile_details[0]['trainer_state'];
        $states = $this->States->find()->where(['country_id' => $country_id])->order(['name' => 'ASC'])->toArray();
        $cities = $this->Cities->find()->where(['state_id' => $state_id])->order(['name' => 'ASC'])->toArray();
        $certificates = $this->Documents->find()->where(['trainer_id' => $this->data['id'],'document_type' => 'certifications'])->order(['id' => 'DESC'])->toArray();
        $resume = $this->Documents->find()->where(['trainer_id' => $this->data['id'],'document_type' => 'resume'])->order(['id' => 'DESC'])->toArray();
        
        $trainer=$this->data['id'];
        $trainerratedetail = $this->conn->execute("SELECT *  FROM `trainer_ratemaster` where `trainer_id`=$trainer")->fetchAll('assoc');
        if(count($trainerratedetail)==0)
        {
          $trainerratedetail=array(array('rate_id'=>'','rate_hour'=>0,'adgust1'=>0,'adgust2'=>0,'adgust3'=>0,'adgust4'=>0));
        }

        $package_list = $this->conn->execute("SELECT *  FROM `trainer_packagemaster` where `trainer_id`=$trainer")->fetchAll('assoc');

        $latlng = $this->Custom->getlatlngbyip();

        $time_slots = $this->Trainer_availability->find()->where(['trainer_id' => $this->data['id'],'date' => date('Y-m-d')])->toArray();
        $this->set('time_slots', $time_slots);
        
        $this->set('latlng', $latlng);
        $this->set('package_list', $package_list);
        $this->set('trainerratedetail', $trainerratedetail);
        $this->set('resume',$resume);
        $this->set('certificates',$certificates);
        $this->set('quotes',$quotes);
		    $this->set('profile_details', $profile_details);
		    $this->set('countries', $countries);
        $this->set('states', $states);
        $this->set('cities', $cities);
        $this->set('gyms', $gyms);
	}

    public function traineeReport($id)
    {
        $trainee_profile_details = $this->Trainees->find()->where(['user_id' => base64_decode($id)])->toArray();
        $profile_details = $this->Trainers->find()->where(['user_id' => $this->data['id']])->toArray();
        $progress_img = $this->After_before_images->find()->where(['abi_trainee_id' => base64_decode($id)])->toArray();
        $meal_plans_arr = $this->Meal_plans->find()->where(['trainer_id' => $this->data['id'], 'trainee_id' => base64_decode($id)])->order(['row_id' => 'ASC'])->toArray();
        $shopping_arr = $this->Shopping->find()->where(['trainer_id' => $this->data['id'], 'trainee_id' => base64_decode($id)])->order(['row_id' => 'ASC'])->toArray();
        $bmi_results = $this->Bmi->find()->where(['bmi_trainee_id' => base64_decode($id), 'bmi_trainer_id' => $this->data['id']])->toArray();
        $this->set('bmi_results', $bmi_results);
        $this->set('meal_plans_arr', $meal_plans_arr);
        $this->set('shopping_arr', $shopping_arr);
        $this->set('progress_img', $progress_img);
        $this->set('profile_details', $profile_details);
        $this->set('trainee_profile_details', $trainee_profile_details);
    }

    public function addMealPlans()
    {
        if($this->request->is('ajax'))
        {
            $dataArr = $this->request->data;
            $meal_plans_data = $this->Meal_plans->find()->where(['row_id' => $dataArr['rowId'], 'trainee_id' => base64_decode($dataArr['trainee_id'])])->toArray();
            if(empty($meal_plans_data)){
                $finalArr = array (
                    'trainer_id' => $this->data['id'],
                    'trainee_id' => base64_decode($dataArr['trainee_id']),
                    'row_id'     => $dataArr['rowId'],
                    $dataArr['type'] => $dataArr['name'],
                    'added_date' => Time::now()
                    );
                $user = $this->Meal_plans->newEntity();
                $user = $this->Meal_plans->patchEntity($user, $finalArr);
                $result = $this->Meal_plans->save($user);
            }else{
                $this->meal_plans->query()->update()->set([$dataArr['type'] => $dataArr['name']])->where(['row_id' => $dataArr['rowId'], 'trainee_id' => base64_decode($dataArr['trainee_id'])])->execute();
            }
            $this->set('message', 'success');
            $this->set('_serialize',array('message'));
            $this->response->statusCode(200);
        }
    }

    public function addShoppingList()
    {
        if($this->request->is('ajax'))
        {
            $dataArr = $this->request->data;
            $shopping_data = $this->Shopping->find()->where(['row_id' => $dataArr['rowId'], 'trainee_id' => base64_decode($dataArr['trainee_id'])])->toArray();
            if(empty($shopping_data)){
                $finalArr = array (
                    'trainer_id' => $this->data['id'],
                    'trainee_id' => base64_decode($dataArr['trainee_id']),
                    'row_id'     => $dataArr['rowId'],
                    $dataArr['type'] => $dataArr['name'],
                    'added_date' => Time::now()
                    );
                $user = $this->Shopping->newEntity();
                $user = $this->Shopping->patchEntity($user, $finalArr);
                $result = $this->Shopping->save($user);
            }else{
                $this->shopping->query()->update()->set([$dataArr['type'] => $dataArr['name']])->where(['row_id' => $dataArr['rowId'], 'trainee_id' => base64_decode($dataArr['trainee_id'])])->execute();
            }
            $this->set('message', 'success');
            $this->set('_serialize',array('message'));
            $this->response->statusCode(200);
        }
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
     		$data = array('trainer_password' => $this->request->data['new_pswd']);
     		$password = $this->request->data['new_pswd'];
     		$hashPswdObj = new DefaultPasswordHasher;
     		$hashpswd = $hashPswdObj->hash($password);
		    $this->trainers->query()->update()->set(['trainer_password' => $this->request->data['new_pswd']])->where(['user_id' => $sess_data['id']])->execute();
		    $this->users->query()->update()->set(['password' => $hashpswd])->where(['id' => $sess_data['id']])->execute();
     		$this->set('message', 'success');
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
            if(isset($_POST['trainer_skills'])){
                $skills = $data['trainer_skills'];
                $skillsArr = explode(",", $skills);
                if(in_array("", $skillsArr) || in_array(" ", $skillsArr))
                {
                  $this->Flash->error('Skills can not be blank !', ['key' => 'edit1']); 
                  return $this->redirect('/trainers/completeProfile');
                }
                if(count($skillsArr) > 5)
                {
                    $this->Flash->error('You Can Add Only Five Skills !', ['key' => 'edit1']); 
                    return $this->redirect('/trainers/completeProfile');
                }
            }
            if($type == "informaiton"){
                $key = 'edit1';
                $address = $this->Custom->getCityName($data['trainer_city']).' '.$this->Custom->getStateName($data['trainer_state']).' '.$this->Custom->getCountryName($data['trainer_country']);
                $loc = $this->Custom->getlatlng($address);
                $data['lat'] = $loc["latitude"];
                $data['lng'] = $loc["longitude"];
                $this->users->query()->update()->set(array('display_name' => $data['trainer_displayName']))->where(['id' => $this->data['id']])->execute();
            }
            if($type == "social_links"){
                $key = 'edit2';
            }
            if($type == "achievements"){
                $key = 'edit4';
            }
            if($type == "others"){
                $key = 'edit5';
            }
            $this->trainers->query()->update()->set($data)->where(['user_id' => $sess_data['id']])->execute();
            $this->Flash->success('Profile Has Been Updated Successfully', ['key' => $key]); 
     		   return $this->redirect('/trainers/completeProfile/'.$type);
        }
	}

    public function updateBankDetails($type)
    {
        if($this->request->is('post'))
        {
            $data = $this->request->data;
            $this->trainers->query()->update()->set($data)->where(['user_id' => $this->data['id']])->execute();
            $this->Flash->success('Bank Details Updated Successfully', ['key' => 'edit3']); 
            return $this->redirect('/trainers/completeProfile/'.$type);
        }
    }


  function addpackage()
    {
        $package_name=$this->request->data['package_name'];
        $package_detail=$this->request->data['package_detail'];
        $package_price=$this->request->data['package_price'];
        $hidden_packeage_id=$this->request->data['hidden_packeage_id'];
        $trainer=$this->data['id'];
        $data = array(
            'trainer_id'=>$trainer,
            'package_name' => $package_name,
            'package_discription' =>$package_detail,
            'package_price' =>$package_price,
            'status' => 1,
            'created_date' =>date('Y-m-d H:i:s'),
            );
        if(empty($hidden_packeage_id)){
            $user = $this->Trainer_packagemaster->newEntity();
            $user = $this->Trainer_packagemaster->patchEntity($user, $data);
            $result = $this->Trainer_packagemaster->save($user);
            $packageId = $result->package_id;
            $divPackId = "pac_".$packageId;
            $response="<div class='item' id=" . $divPackId . "> <div class='session_top'> <div class='session_head'>".$package_name."<a href='javascript:void(0);' class='edit-package-btn' main=" . $packageId . "><i class='fa fa-edit'></i></a></div>
                   <div class='price_session'>".$package_detail."</div>
                    <a href='javascript:void(0);' class='order_btn'>$".$package_price."</a> </div>  </div>";
        }else{
            $this->trainer_packagemaster->query()->update()->set($data)->where(['package_id' => $hidden_packeage_id])->execute();
            $packageId = $hidden_packeage_id;
            $divPackId = "pac_".$packageId;
            $response="<div class='session_top'> <div class='session_head'>".$package_name."<a href='javascript:void(0);' class='edit-package-btn' main=" . $packageId . "><i class='fa fa-edit'></i></a></div>
                   <div class='price_session'>".$package_detail."</div>
                    <a href='javascript:void(0);' class='order_btn'>$".$package_price."</a> </div>";
        }
        
        $this->set('message', $response);
        $this->set('_serialize',array('message'));
        $this->response->statusCode(200);
    }

    public function getPackageData()
    {
        if($this->request->is('ajax'))
        {
            $pack_id = $this->request->data['pack_id'];
            $result = $this->Trainer_packagemaster->find()->where(['package_id' => $pack_id]);
            $this->set('message', $result);
            $this->set('_serialize',array('message'));
            $this->response->statusCode(200);
        }
    }

	public function updateProfileImage()
	{
		if($this->request->is('ajax'))
     	{
        $f_name1 = $_FILES['trainer_profile_img']['name'];
        $f_tmp1 = $_FILES['trainer_profile_img']['tmp_name'];
        $f_size1 = $_FILES['trainer_profile_img']['size'];
        $f_extension1 = explode('.',$f_name1); 
        $f_extension1 = strtolower(end($f_extension1)); 
        $f_newfile1="";
        if($f_name1){
        $f_newfile1 = "VT_".uniqid().'.'.$f_extension1; 
        $store1 = "uploads/trainer_profile/". $f_newfile1;
        $image2 =  move_uploaded_file($f_tmp1,$store1);
        }
        if($_SERVER['SERVER_NAME'] == "localhost"){
          $newfile = $_SERVER['DOCUMENT_ROOT'] . '/fitness/webroot/uploads/trainer_gallery/'.$f_newfile1;
        }else{
          $newfile = $_SERVER['DOCUMENT_ROOT'] . '/webroot/uploads/trainer_gallery/'.$f_newfile1;
        }
        copy($store1, $newfile);
        $data = array(
              'piv_attachement_type' => 'image',
              'piv_name' => $f_newfile1,
              'piv_user_type' => 'trainer',
              'piv_user_id' => $this->data['id'],
              'piv_status' => 0,
              'piv_added_date' => Time::now(),
              );
        $user = $this->Profile_images_videos->newEntity();
        $user = $this->Profile_images_videos->patchEntity($user, $data);
        $result = $this->Profile_images_videos->save($user);
     		$sess_data = $this->Custom->getSessionData();
     		$this->trainers->query()->update()->set(['trainer_image' => $f_newfile1])->where(['user_id' => $sess_data['id']])->execute();
     		$this->set('message', $f_newfile1);
			  $this->set('_serialize',array('message'));
			  $this->response->statusCode(200);
     	}
	}

	public function addQuotes($type)
    {
    	$sessData = $this->Custom->getSessionData();
        $data = $this->request->data;
        $data['lt_type'] = 'Quotes';
        $data['lt_status'] = 0;
        $data['lt_user_id'] = $sessData['id'];
        $data['lt_added_date'] = Time::now();
        $user = $this->Latest_things->newEntity();
        $user = $this->Latest_things->patchEntity($user, $data);
        $result = $this->Latest_things->save($user);
        $this->Flash->success('Quotes Added Successfully', ['key' => 'edit6']);
        return $this->redirect('/trainers/completeProfile/'.$type);
    }

    public function deleteGallery()
    {
        if($this->request->is('ajax'))
        {
            $id = (int) base64_decode($this->request->data['p_id']);
            $fileName = $this->request->data['file'];
            $this->gallery->query()->delete()->where(['piv_id' => $id])->execute();
            /*$this->Custom->deleteFile($fileName,'trainer_gallery');*/
            $this->set('message', 'success');
            $this->set('_serialize',array('message'));
            $this->response->statusCode(200);
        }
    }

     function setrate()
    {
        $trainer=$this->data['id'];
        $rate=$_POST['rate'];
        $rateid=$_POST['rateid'];
        if($rateid==""){
        $data = array(
                    'trainer_id'=>$trainer,
                    'rate_hour' => $rate,
                    'status' =>1,
                    'update_time' => Time::now()
                    );
        $user = $this->Trainer_ratemaster->newEntity();
        $user = $this->Trainer_ratemaster->patchEntity($user, $data);
        $result = $this->Trainer_ratemaster->save($user);
        $rid = $result->rate_id;
        }
        else
        {
            $data = array('rate_hour' =>$rate);
            $this->Trainer_ratemaster->query()->update()->set($data)->where(['rate_id' => $rateid])->execute();
            $rid = $rateid;
        }
         $rate_detail=$this->conn->execute('SELECT *  FROM `trainer_ratemaster` where  `rate_id`='.$rid)->fetchAll('assoc');
         $rate1=$rate*1-$rate_detail[0]['adgust1'];
         $rate2=$rate*3-$rate_detail[0]['adgust2'];
         $rate3=$rate*10-$rate_detail[0]['adgust3'];
         $rate4=$rate*20-$rate_detail[0]['adgust4'];

        $response="<h5>Rate Plan</h5><div class='plan_session_content'> <ul>";
        $response.="<li><div class='session_top'><div class='session_head'>1 Session</div> <div class='price_session rate1'>$".$rate1."</div></div><div class='session_bottom'><input type='text' ratet='1' id='adjust1' value='".$rate_detail[0]['adgust1']."' class='form-control adjust'></div></li>";
        $response.="<li><div class='session_top'><div class='session_head'>3 Session</div> <div class='price_session rate2'>$".$rate2."</div></div><div class='session_bottom'><input type='text' ratet='2' id='adjust2' value='".$rate_detail[0]['adgust2']."'  class='form-control adjust'></div></li>";
        $response.="<li><div class='session_top'><div class='session_head'>10 Session</div> <div class='price_session rate3'>$".$rate3."</div></div><div class='session_bottom'><input type='text' ratet='3' id='adjust3' value='".$rate_detail[0]['adgust3']."'  class='form-control adjust'></div></li>";
        $response.="<li><div class='session_top'><div class='session_head'>20 Session</div> <div class='price_session rate4'>$".$rate4."</div></div><div class='session_bottom'><input type='text' ratet='4' id='adjust4' value='".$rate_detail[0]['adgust4']."'  class='form-control adjust'></div></li></ul></div> ";
        $this->set('message', $response);
        $this->set('_serialize',array('message'));
        $this->response->statusCode(200);

   }
    function adjust()
    {
        $rateid=$_POST['rateid'];
        $adjust1=$_POST['adjust1'];
        $adjust2=$_POST['adjust2'];
        $adjust3=$_POST['adjust3'];
        $adjust4=$_POST['adjust4'];
        $data = array('adgust1' =>$adjust1,'adgust2' =>$adjust2,'adgust3' =>$adjust3,'adgust4' =>$adjust4);
        $this->Trainer_ratemaster->query()->update()->set($data)->where(['rate_id' => $rateid])->execute();
        $response="";
        $this->set('message', $response);
        $this->set('_serialize',array('message'));
        $this->response->statusCode(200);
    }

     public function rateplan()
    {
       $profile_details = $this->Trainers->find()->where(['user_id' => $this->data['id']])->toArray();
       $all_trainees = $this->conn->execute('SELECT *,t.id as trainee_id,c.name as country_name,s.name as state_name,ct.name as city_name  FROM trainees as t inner join countries as c on c.id = t.trainee_country inner join states as s on s.id = t.trainee_state inner join cities as ct on ct.id = t.trainee_city where `t`.`trainer_status` = 1 ORDER BY t.id DESC ')->fetchAll('assoc');
       $trainer=$this->data['id'];
       $trainerratedetail = $this->conn->execute("SELECT *  FROM `trainer_ratemaster` where `trainer_id`=$trainer")->fetchAll('assoc');
       if(count($trainerratedetail)==0)
       {
          $trainerratedetail=array(array('rate_id'=>'','rate_hour'=>0,'adgust1'=>0,'adgust2'=>0,'adgust3'=>0,'adgust4'=>0));
       }
       if(!empty($all_trainees))
       {
       $recent_trainee_id = $all_trainees[0]['user_id'];
       $trainer_id = $this->data['id'];
       $trainee_details = $this->Trainees->find()->where(['user_id' => $recent_trainee_id])->toArray();
       $chat_data = $this->conn->execute(" SELECT 
                                            chating.*
                                            FROM chating
                                            WHERE 
                                            (chating.chat_sender_id = $trainer_id AND chating.chat_reciever_id = $recent_trainee_id AND chating.chat_type = 0 )
                                            OR 
                                            (chating.chat_sender_id = $recent_trainee_id AND chating.chat_reciever_id = $trainer_id AND chating.chat_type = 0 )
                                         ")->fetchAll('assoc');
        $chat_final_arr = array();
        foreach ($chat_data as $c)
         {
          $chat_final_arr[] = $c['chat_id'];
         }
        array_multisort($chat_final_arr, SORT_DESC, $chat_data);
        $this->set('trainer_id', $trainer_id); 
        $this->set('trainee_details', $trainee_details); 
        }
        else
        {
            $chat_data = array();
        }
       $this->set('chat_data', $chat_data); 
       $this->set('trainerratedetail', $trainerratedetail); 
       $this->set('all_trainees', $all_trainees);
       $this->set('profile_details', $profile_details); 
    }

    public function appointments()
    {
       $profile_details = $this->Trainers->find()->where(['user_id' => $this->data['id']])->toArray();
       $pending_appointments  = $this->conn->execute('SELECT *,`a`.`id` AS `app_id` FROM `appointments` AS `a` INNER JOIN `trainees` AS `t` ON `a`.`trainee_id` = `t`.`user_id` WHERE `a`.`trainer_id` = '.$this->data['id'].' AND `a`.`trainer_status` = 0 AND `a`.`trainee_status` = 0 AND `a`.`pay_status` = 1 AND `a`.`created_date` >= DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY `a`.`id` DESC')->fetchAll('assoc');
       $upcomingArr = $this->getUpcomingAppointments(date('Y-m-d'));
       $app_counts  = $this->getUpcomingAppointmentsCountByDate(); 
       $missed_appo = $this->getMissedAppointments(); 
       $this->set('missed_appo', $missed_appo);
       $this->set('app_counts', $app_counts);
       $this->set('upcomingArr', $upcomingArr);
       $this->set('pending_appointments', $pending_appointments);
       $this->set('profile_details', $profile_details);
       $this->set("from_id",$this->data['id']);
    }

    public function bookReschduleAppointment()
    {
      $appid = (int) base64_decode($_GET['asid']);
      $app_details = $this->Appointment_sessions->find()->where(['id' => $appid])->toArray();
      $trainee_id = $app_details[0]['traineeId'];
      $trainee_details = $this->Trainees->find()->where(['user_id' => $trainee_id])->toArray();
      $profile_details = $this->Trainers->find()->where(['user_id' => $this->data['id']])->toArray();
      $this->set('appid', $appid);
      $this->set('trainee_details', $trainee_details);
      $this->set('profile_details', $profile_details);
    }

    public function doBooking($appid)
    {
      $data = $this->request->data;
      $appoinment_details = $this->Appointment_sessions->find()->where(['id' => $appid])->toArray();
      $dataArr = array(
        'training_type' => $data['booking'][1]['preference'],
        'training_date' => $data['booking'][1]['modified_dates'],
        'training_time' => $data['booking'][1]['modified_times'],
        'latt_longg'    => $data['booking'][1]['locations'],
        'training_adrees' => $data['booking'][1]['location_address'],
        'user_status'   => 1,
        'training_status'=>0,
        'added_date'    => Time::now()
      );
      $this->appointment_sessions->query()->update()->set($dataArr)->where(['id' => $appid])->execute();
      $notificationArr = array(
            'noti_type'          => 'Appointment Successfully Re-scheduled',
            'parent_id'          => $appid,
            'noti_sender_type'   => 'trainer',
            'noti_sender_id'     => $appoinment_details[0]['trainerId'],
            'noti_receiver_type' => 'trainee',
            'parent_id_status'   => 1,
            'noti_receiver_id'   => $appoinment_details[0]['traineeId'],
            'noti_message'       => 'your appointment successfully re-scheduled',
            'noti_added_date'    => Time::now()
        );
      $notifications = $this->Notifications->newEntity();
      $notifications = $this->Notifications->patchEntity($notifications, $notificationArr);
      $result = $this->Notifications->save($notifications);
      $this->request->session()->write('sucess_alert','Appoitnment successfully re-scheduled');
      return $this->redirect('/trainers/appointments');
    }


  public function getTrainerTimeSlotsDateWise()
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

    public function getMissedAppointments()
    {
      $pasAppoArr = $this->conn->execute('SELECT *,`a`.`id` AS `app_session_id` FROM `appointment_sessions` AS `a` INNER JOIN `trainees` AS `t` ON `a`.`traineeId` = `t`.`user_id` WHERE `a`.`trainerId` = '.$this->data['id'].' AND `a`.`user_status` = 1 AND `a`.`training_status` = 2 ORDER BY `a`.`id` DESC')->fetchAll('assoc');
      return $pasAppoArr; 
    }

    public function getUpcomingAppointments($date)
    {
      $upcomingArr = $this->conn->execute('SELECT *,`a`.`appId` AS `app_id` FROM `appointment_sessions` AS `a` INNER JOIN `trainees` AS `t` ON `a`.`traineeId` = `t`.`user_id` WHERE `a`.`trainerId` = '.$this->data['id'].' AND `a`.`user_status` = 1 AND `a`.`training_date` = "'.$date.'" ORDER BY `a`.`id` DESC')->fetchAll('assoc');
      return $upcomingArr;  
    }

    public function getUpcomingAppointmentsCountByDate()
    {
      $appointments = $this->conn->execute('SELECT COUNT(*) AS `number`,`training_date` FROM `appointment_sessions` WHERE `trainerId` = '.$this->data['id'].' AND `user_status` = 1 AND `training_status`= 0 AND `training_date`>= CURDATE() GROUP BY `training_date` ')->fetchAll('assoc');
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
                $appendHTML .= '<img src="'.$this->Custom->getImageSrc('uploads/trainee_profile/'.$upcomingArr['trainee_image']).'">';
                $appendHTML .= '</div><span class="client_name">'.$upcomingArr['trainee_name'].'</span>';
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

    public function appointmentsAvailability()
    {
       $profile_details = $this->Trainers->find()->where(['user_id' => $this->data['id']])->toArray();
       $time_slots = $this->Trainer_availability->find()->where(['trainer_id' => $this->data['id'],'date' => date('Y-m-d')])->toArray();
       $this->set('time_slots', $time_slots);
       $this->set('profile_details', $profile_details);
    }

    public function viewPendingAppointment()
    {
       $aid = base64_decode($this->request->query['aid']);
       $profile_type_arr = $this->Users->find()->where(['id' => $this->data['id']])->toArray();
        if(!empty($profile_type_arr[0]['social_type']))
          {
            $session_details = $this->conn->execute('SELECT *,`a`.`id` AS `app_id` FROM `appointments` AS `a` INNER JOIN `trainees` AS `t` ON `a`.`trainee_id` = `t`.`user_id` WHERE `a`.`id` = '.$aid)->fetchAll('assoc');
          }
        else
          {
            $session_details = $this->conn->execute('SELECT *,`a`.`id` AS `app_id`,c.name as country_name,ct.name as city_name,s.name as state_name FROM `appointments` AS `a` INNER JOIN `trainees` AS `t` ON `a`.`trainee_id` = `t`.`user_id` inner join `countries` as c on t.trainee_country = c.id inner join `states` as s on t.trainee_state = s.id inner join `cities` as ct on t.trainee_city = ct.id WHERE `a`.`id` = '.$aid)->fetchAll('assoc');
          }
       $profile_details = $this->Trainers->find()->where(['user_id' => $this->data['id']])->toArray();
       $time_slots = $this->Trainer_availability->find()->where(['trainer_id' => $this->data['id'],'date' => date('Y-m-d')])->toArray();
       $this->set('time_slots', $time_slots);
       $this->set('session_details', $session_details);
       $this->set('profile_details', $profile_details);
    }

    public function respondnow()
    {
        $type  = $this->request->query['type'];
        $appid = base64_decode($this->request->query['appid']);
        if($type == 1){ // for approve
            $this->approveAppointment($appid);
            $this->request->session()->write('sucess_alert','Appointment successfully approved !!');
            return $this->redirect('/trainers');
        }else{ // for decline
            $this->declineAppointment($appid);
            $this->request->session()->write('sucess_alert','Appointment successfully declined !!');
            return $this->redirect('/trainers');
        }
    }

    public function approveAppointment($appid){
        $appoinment_details = $this->Appointments->find()->where(['id' => $appid])->toArray();
        $appArr = array(
                'trainer_status' => 1,
                'trainee_status' => 1
            );
        $this->appointments->query()->update()->set($appArr)->where(['id' => $appid])->execute();
        $appSessionArr = array('user_status' => 1);
        $this->appointment_sessions->query()->update()->set($appSessionArr)->where(['appId' => $appid])->execute();
        $notificationArr = array(
                'noti_type'          => 'Approve Appointment',
                'parent_id'          => $appid,
                'noti_sender_type'   => 'trainer',
                'noti_sender_id'     => $appoinment_details[0]['trainer_id'],
                'noti_receiver_type' => 'trainee',
                'parent_id_status'   => 1,
                'noti_receiver_id'   => $appoinment_details[0]['trainee_id'],
                'noti_message'       => 'has approved your appoinment',
                'noti_added_date'    => Time::now()
            );
        $notifications = $this->Notifications->newEntity();
        $notifications = $this->Notifications->patchEntity($notifications, $notificationArr);
        $result = $this->Notifications->save($notifications);

        $trainer_earning_fee = $this->Fees->find()->where(['type' => 'Trainer Earning'])->toArray();
        $trainer_wallet_fee  = $this->Fees->find()->where(['type' => 'Administration'])->toArray();
        $wallet_details      = $this->Total_wallet_ammount->find()->where(['user_id' => $this->data['id']])->toArray();
        $session_price       = $appoinment_details[0]['final_price'];
        $total_deduct_amount = ($session_price * ($trainer_earning_fee[0]['txn_fee'] + $trainer_wallet_fee[0]['txn_fee']))/100;
        $final_wallet_amount = round($session_price - $total_deduct_amount,2);
        if(empty($wallet_details)){
            $walletArr = array(
                'user_id'       => $this->data['id'],
                'user_type'     => 'trainer',
                'total_ammount' => $final_wallet_amount,
                'added_date'    => Time::now()
            );
            $wallet = $this->Total_wallet_ammount->newEntity();
            $wallet = $this->Total_wallet_ammount->patchEntity($wallet, $walletArr);
            $result = $this->Total_wallet_ammount->save($wallet);
        }else{
            $wallet_current_balance = round($wallet_details[0]['total_ammount'] + $final_wallet_amount,2);
            $this->total_wallet_ammount->query()->update()->set(['total_ammount'=> $wallet_current_balance])->where(['user_id' => $this->data['id']])->execute();
        }
        $trainer_txn_arr = array(
            'trainer_id'  => $this->data['id'],
            'txn_name'    => 'Rate Plan Earning',
            'txn_type'    => 0,
            'txn_id'      => $this->data['id'].uniqid(),
            'parent_id'   => $appid,
            'total_amount'=> $session_price,
            'administration_fee'=> ($session_price * $trainer_wallet_fee[0]['txn_fee'])/100,
            'service_fee'=> ($session_price * $trainer_earning_fee[0]['txn_fee'])/100,
            'added_date' => Time::now()
          );
        $txns   = $this->Trainer_txns->newEntity();
        $txns   = $this->Trainer_txns->patchEntity($txns, $trainer_txn_arr);
        $result = $this->Trainer_txns->save($txns);
    }

    public function declineAppointment($appid){
        $appoinment_details = $this->Appointments->find()->where(['id' => $appid])->toArray();
        $appArr = array(
                'trainer_status' => 2,
                'trainee_status' => 2
            );
        $this->appointments->query()->update()->set($appArr)->where(['id' => $appid])->execute();
        $appSessionArr = array('user_status' => 2);
        $this->appointment_sessions->query()->update()->set($appSessionArr)->where(['appId' => $appid])->execute();
        $notificationArr = array(
                'noti_type'          => 'Decline Appointment',
                'parent_id'          => $appid,
                'noti_sender_type'   => 'trainer',
                'parent_id_status'   => 2,
                'noti_sender_id'     => $appoinment_details[0]['trainer_id'],
                'noti_receiver_type' => 'trainee',
                'noti_receiver_id'   => $appoinment_details[0]['trainee_id'],
                'noti_message'       => 'has declined your appoinment',
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

    public function dropEvent()
    {
        if($this->request->is('ajax'))
        {
            $id = (int) base64_decode($this->request->data['event_id']);
            $start_date = explode("T",$this->request->data['start_droped_date']);
            $end_date = explode("T",$this->request->data['end_droped_date']);
            $data = array(
                'app_date' => $start_date[0],
                'app_start_time' => $start_date[1],
                'app_end_time' => $end_date[1],
                );
            $this->appointments->query()->update()->set($data)->where(['app_id' => $id])->execute();
            $this->set('message', 'success');
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

    public function getViewAppoData()
    {
        if($this->request->is('ajax'))
        {
            $id = (int) base64_decode($this->request->data['app_id']);
            $result_data = $this->conn->execute('SELECT * FROM `appointments` as a inner join trainers as t on t.user_id = a.app_reciever_id where a.`app_id` ='.$id)->fetchAll('assoc');
            $this->set('message', $result_data);
            $this->set('_serialize',array('message'));
            $this->response->statusCode(200);
        }
    }

    public function deleteAppoinment()
    {
        if($this->request->is('ajax'))
        {
            $id = (int) base64_decode($this->request->data['id']);
            $this->appointments->query()->delete()->where(['app_id' => $id])->execute();
            $this->conn->execute('DELETE FROM notifications WHERE parent_id = '.$id. ' AND noti_type IN("Appoinment","Appoinment Accept","Appoinment Delete","Appoinment Request")');
            $this->set('message', 'success');
            $this->set('_serialize',array('message'));
            $this->response->statusCode(200);
        }
    }

    public function updateChatStatus()
    {
      $trainer_id = $this->data['id'];
      $chat_id_data = $this->conn->execute(" SELECT 
                                            `chat_id`
                                            FROM chating
                                            WHERE 
                                            (chat_sender_id = $trainer_id AND chat_type = 0 )
                                            OR 
                                            (chat_reciever_id = $trainer_id AND chat_type = 0 )
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
       $profile_details = $this->Trainers->find()->where(['user_id' => $this->data['id']])->toArray();
       $all_chat_trainees = $this->conn->execute('SELECT * FROM `chating` WHERE `chat_sender_id` = '.$this->data['id'].' OR `chat_reciever_id` = '.$this->data['id'])->fetchAll('assoc');

       if(!empty($all_chat_trainees))
       {
        foreach($all_chat_trainees as $a)
         {
            if($a['chat_sender_id'] == $this->data['id']){
              $trainee_ids[] = $a['chat_reciever_id'];
            }else{
              $trainee_ids[] = $a['chat_sender_id'];
            }
         }
        $te_ids = implode(",", array_values(array_unique($trainee_ids)));
        $all_trainees = $this->conn->execute('SELECT *,t.id as trainee_id,c.name as country_name,s.name as state_name,ct.name as city_name  FROM trainees as t inner join countries as c on c.id = t.trainee_country inner join states as s on s.id = t.trainee_state inner join cities as ct on ct.id = t.trainee_city where `t`.`trainee_status` = 1 AND `t`.`user_id` IN ('.$te_ids.') ORDER BY t.id DESC ')->fetchAll('assoc');
       }
       else{
          $all_trainees = array();
       }
       if(!empty($all_trainees))
       {
       $recent_trainee_id = $all_trainees[0]['user_id'];
       $trainer_id = $this->data['id'];
       $trainee_details = $this->Trainees->find()->where(['user_id' => $recent_trainee_id])->toArray();
       $chat_data = $this->conn->execute(" SELECT 
                                            chating.*
                                            FROM chating
                                            WHERE 
                                            (chating.chat_sender_id = $trainer_id AND chating.chat_reciever_id = $recent_trainee_id AND chating.chat_type = 0 )
                                            OR 
                                            (chating.chat_sender_id = $recent_trainee_id AND chating.chat_reciever_id = $trainer_id AND chating.chat_type = 0 )
                                         ")->fetchAll('assoc');
       
        $chat_final_arr = array();
        foreach ($chat_data as $c)
         {
          $chat_final_arr[] = $c['chat_id'];
         }
        array_multisort($chat_final_arr, SORT_ASC, $chat_data);
        $this->set('trainer_id', $trainer_id); 
        $this->set('trainee_details', $trainee_details); 
        }
        else
        {
            $chat_data = array();
        }
       $this->set('chat_data', $chat_data); 
       $this->set('from_id', $this->data['id']); 
       $this->set('all_trainees', $all_trainees);
       $this->set('profile_details', $profile_details); 
    }

    public function getMessages()
    {
        if($this->request->is('ajax'))
        {
            $trainee_id = base64_decode($this->request->data['trainee_id']);
            $trainer_id = $this->data['id'];
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
                    $chat_msgs .= '<a class="pull-left" href="'.$this->request->webroot.'trainers/profile">';
                    $chat_msgs .= '<img class="media-object" style="width: 32px; height: 32px;" src="'.$this->Custom->getImageSrc('uploads/trainer_profile/'.$trainer_details[0]['trainer_image']).'"></a>';
                    $chat_msgs .= '<div class="media-body">';
                    $chat_msgs .= '<small class="pull-right"><i class="fa fa-clock-o"></i>'. date('d F y,h:i A', strtotime($cd["chat_added_date"])).'</small>';
                    $chat_msgs .= '<h5 class="media-heading">'.ucwords($trainer_details[0]['trainer_name']).'</h5>';
                    $chat_msgs .= '<small>'.$cd['chat_messsage'].'</small></div></br><span class="delete_msgs" main="'.$cd['chat_id'].'" style="float:right;cursor:pointer;"><i class="fa fa-trash-o" title="Delete Message"></i></span></div><hr>';
                }
                else
                {
                    $chat_msgs .= '<div class="media msg" id="msg_body_'.$cd['chat_id'].'">';
                    $chat_msgs .= '<a class="pull-left" href="'.$this->request->webroot.'trainers/traineeReport/'.base64_encode($trainee_details[0]['user_id']).'">';
                    $chat_msgs .= '<img class="media-object" style="width: 32px; height: 32px;" src="'.$this->Custom->getImageSrc('uploads/trainee_profile/'.$trainee_details[0]['trainee_image']).'"></a>';
                    $chat_msgs .= '<div class="media-body">';
                    $chat_msgs .= '<small class="pull-right"><i class="fa fa-clock-o"></i>'. date('d F y,h:i A', strtotime($cd["chat_added_date"])).'</small>';
                    $chat_msgs .= '<h5 class="media-heading">'.ucwords($trainee_details[0]['trainee_name']).'</h5>';
                    $chat_msgs .= '<small>'.$cd['chat_messsage'].'</small></div></br><span class="delete_msgs" main="'.$cd['chat_id'].'" style="float:right;cursor:pointer;"><i class="fa fa-trash-o" title="Delete Message"></i></span></div><hr>';
                }
                }
                    $chat_msgs .=  '<div class="text_area"><textarea user="'.$this->data['id'].'" to_id="'.$trainee_details[0]['user_id'].'" main_id="'.$trainee_details[0]['user_id'].'" placeholder="Write your message here" class="form-control" ></textarea></div> </br>';
            }
            $this->set('message', $chat_msgs);
            $this->set('_serialize',array('message'));
            $this->response->statusCode(200);
        }
    }

    public function mytrainees()
    {
       $id = $this->data['id'];
       $appointment_data = $this->conn->execute('SELECT `trainee_id` FROM `appointments` WHERE `trainer_status` = 1 AND `trainee_status` = 1 AND `trainer_id` = '.$this->data['id'].' GROUP BY `trainee_id` ')->fetchAll('assoc');
       $custom_package_data = $this->conn->execute('SELECT `trainee_id` FROM `custom_packages_history` WHERE `trainer_id` = '.$this->data['id'].' GROUP BY `trainee_id` ')->fetchAll('assoc');
       $common_arr = array_merge($appointment_data,$custom_package_data);
       if(!empty($common_arr)){
        foreach($common_arr as $c)
         {
          $trainee_id[] = $c['trainee_id'];
         }
         $id_arr = array_unique($trainee_id);
         $ids    = implode(",", $id_arr);
         $trainee_data = $this->conn->execute('SELECT *,t.id as trainee_id,c.name as country_name,s.name as state_name,ct.name as city_name  FROM  trainees as t  inner join countries as c on c.id = t.trainee_country inner join states as s on s.id = t.trainee_state inner join cities as ct on ct.id = t.trainee_city where `t`.`user_id` IN('.$ids.') ORDER BY t.id DESC ')->fetchAll('assoc');
         $this->set('trainee_data', $trainee_data);  
       }else{
         $this->set('trainee_data', array());  
       }
       $profile_details = $this->Trainers->find()->where(['user_id' => $this->data['id']])->toArray();
       $this->set('user_id', $id);  
       $this->set('profile_details', $profile_details); 
    }

    public function getNotifications()
    {
      $id = $this->data['id'];
      $noti_data   = $this->conn->execute('SELECT *,`n`.`id` AS `noti_id` FROM `notifications` AS `n` INNER JOIN `trainees` AS `t` ON `t`.`user_id` = `n`.`noti_sender_id` WHERE `n`.`noti_status` = 0 AND `n`.`noti_receiver_id` = '.$this->data['id'].' ORDER BY `n`.`id` DESC ')->fetchAll('assoc');
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
      $noti_data   = $this->conn->execute('SELECT *,`n`.`id` AS `noti_id` FROM `notifications` AS `n` INNER JOIN `trainees` AS `t` ON `t`.`user_id` = `n`.`noti_sender_id` WHERE `n`.`noti_receiver_id` = '.$this->data['id'].' ORDER BY `n`.`id` DESC ')->fetchAll('assoc');
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
      $profile_details = $this->Trainers->find()->where(['user_id' => $this->data['id']])->toArray();
      $noti_data = $this->getAllNotifications();
      $this->set('noti_data', $noti_data);
      $this->set('profile_details', $profile_details); 
    }

    public function acceptAppoinment($appo_id,$noti_id,$trainee_id)
    {
        $this->appointments->query()->update()->set(['app_status' => 1])->where(['app_id' => base64_decode($appo_id)])->execute();
        $this->notifications->query()->update()->set(['noti_status' => 1])->where(['id' => base64_decode($noti_id)])->execute();

        $noti_data = array(
            'noti_type' => 'Appoinment Accept',
            'parent_id' => base64_decode($appo_id),
            'noti_sender_type' => 'trainer',
            'noti_sender_id' => $this->data['id'],
            'noti_receiver_type' => 'trainee',
            'noti_receiver_id' => base64_decode($trainee_id),
            'noti_message' => ' '.$this->data['display_name'].' Accepted Your Appoinment ',
            'noti_status' => 0,
            'noti_added_date' =>Time::now()
            );

        $user1 = $this->Notifications->newEntity();
        $user1 = $this->Notifications->patchEntity($user1, $noti_data);
        $result1 = $this->Notifications->save($user1);

        $this->Flash->success('Appoinment Accepted Successfully', ['key' => 'edit']);
        return $this->redirect('/trainers/notifications');
    }

    public function rejectAppoinment($app_id,$noti_id,$trainee_id)
    {
           $noti_data = array(
            'noti_type' => 'Appoinment Delete',
            'parent_id' => base64_decode($app_id),
            'noti_sender_type' => 'trainer',
            'noti_sender_id' => $this->data['id'],
            'noti_receiver_type' => 'trainee',
            'noti_receiver_id' => base64_decode($trainee_id),
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
        return $this->redirect('/trainers/notifications');
    }

    public function photoalbum()
    {
       $gallery_img = $this->Profile_images_videos->find()->where(['piv_user_id' => $this->data['id'], 'piv_attachement_type' => 'image'])->order(['piv_id' => 'DESC'])->toArray();
       $gallery_videos = $this->Profile_images_videos->find()->where(['piv_user_id' => $this->data['id'], 'piv_attachement_type' => 'video'])->order(['piv_id' => 'DESC'])->toArray();
       $profile_details = $this->Trainers->find()->where(['user_id' => $this->data['id']])->toArray();
       $this->set('profile_details', $profile_details); 
       $this->set('gallery_img', $gallery_img);
       $this->set('gallery_videos', $gallery_videos);
    }

    public function traineeBookAppoinments()
    {
        if($this->request->is('post'))
        {
            $data = $this->request->data;
            $data['app_type'] = 'Book';
            $data['app_sender_type'] = 'trainer';
            $data['app_sender_id'] = $this->data['id'];
            $data['app_reciever_type'] = 'trainee';
            $data['app_status'] = 0;
            $data['app_added_date'] = Time::now();
            $user = $this->Appointments->newEntity();
            $user = $this->Appointments->patchEntity($user, $data);
            $result = $this->Appointments->save($user);
            $lid = $result->app_id;

            $noti_data = array(
              'noti_type' => 'Appoinment Request',
              'parent_id' => $lid,
              'noti_sender_type' => 'trainer',
              'noti_sender_id' => $this->data['id'],
              'noti_receiver_type' => 'trainee',
              'noti_receiver_id' => $data['app_reciever_id'],
              'noti_message' => ' '.$this->data['display_name'].' sent an appoinment request ',
              'noti_status' => 0,
              'noti_added_date' =>Time::now()
              );
            $user1 = $this->Notifications->newEntity();
            $user1 = $this->Notifications->patchEntity($user1, $noti_data);
            $result1 = $this->Notifications->save($user1);

            $this->Flash->success('Appointment created successfully please wait for trainee approval', ['key' => 'edit']);
            return $this->redirect('/trainers/appointments');
        }
    }

    public function addDocuments($type)
    {
        $data = $this->request->data;
        $data['document_file'] = $this->Custom->fileUploading('document_file','documents'); 
        $data['document_type'] = $type;
        $data['trainer_id'] = $this->data['id'];
        $data['status'] = 0;
        $data['added_date'] = Time::now();
        $user = $this->Documents->newEntity();
        $user = $this->Documents->patchEntity($user, $data);
        $result = $this->Documents->save($user);
        if($type == 'certifications'){
            $key = "edit7";
        }
        if($type == 'resume'){
            $key = "edit8";
        }
        $this->Flash->success( ucwords($type) .' Added Successfully', ['key' => $key]);
        return $this->redirect('/trainers/completeProfile/'.$type);
    }

    public function downloadDocument($filename)
    {
        $file = 'uploads/documents/'.$filename;
        $this->Custom->downloadFile($file);
    }

    public function bookAppoinments($id)
    {
      $trainee_id = (int) base64_decode($id);
      $result = $this->Trainees->find()->where(['user_id' => $trainee_id])->toArray();
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
      $this->set('trainee_detail', $result);
    }

    public function addAppoinments($id)
      {
        if($this->request->is('post'))
            {
                $data = $this->request->data;
                $data['app_type'] = 'Book';
                $data['app_sender_type'] = 'trainer';
                $data['app_sender_id'] = $this->data['id'];
                $data['app_status'] = 0;
                $data['app_reciever_type'] ='trainee';
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

                $this->Flash->success('Appoinment Created Successfully Please Wait For Trainee Approval', ['key' => 'edit']);
                return $this->redirect('/trainers/bookAppoinments/'.$id);
            }
    }

    public function savebmi()
    {
        if($this->request->is('ajax'))
        {
            $bmi_data = array(
                'bmi_date' => date('Y-m-d'),
                'bmi_calculated' => $this->request->data['bmi'],
                'bmi_weight_status' => $this->request->data['status'],
                'bmi_trainee_id' => base64_decode($this->request->data['trainee_id']),
                'bmi_trainer_id' => $this->data['id'],
                'bmi_status' => 0,
                'bmi_added_date' => Time::now()
                );
            $user = $this->Bmi->newEntity();
            $user = $this->Bmi->patchEntity($user, $bmi_data);
            $result = $this->Bmi->save($user);
            $lid = $result->id;
            $this->set('message', $lid);
            $this->set('_serialize',array('message'));
            $this->response->statusCode(200);
        }
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

    public function traineravailability()
    {
      if($this->request->is('ajax'))
        {
           $data = $this->request->data();
           $dataArr = array(
                'trainer_id' => $this->data['id'],
                'date'       => $data['selected_date'],
                'times'      => serialize($data['times'])
                );

           $results = $this->Trainer_availability->find()->where(['trainer_id' => $this->data['id'],'date' => $data['selected_date']])->toArray();
           if(empty($results)){
                $dataArr['created_date'] = Time::now();
                $user = $this->Trainer_availability->newEntity();
                $user = $this->Trainer_availability->patchEntity($user, $dataArr);
                $result = $this->Trainer_availability->save($user);
           }else{
                $this->trainer_availability->query()->update()->set($dataArr)->where(['trainer_id' => $this->data['id'],'date' => $data['selected_date']])->execute();
           }
           $this->set('message', 'success');
           $this->set('_serialize',array('message'));
           $this->response->statusCode(200);
        }
    }

  public function getTimeSlotsDateWise()
  {
    if($this->request->is('ajax'))
      {
         $date = $this->request->data['date'];
         $trainer_id = $this->data['id'];
         $results = $this->Trainer_availability->find()->where(['trainer_id' => $trainer_id,'date' => $date])->toArray();
         $response = "";
         if(empty($results)){
              for ($i=0; $i < 24; $i++) { 
                 $response .= "<div class='checkbox'><div title='Available' class='roundedOne unbookedlabel'>";
                 $response .= "<input type='checkbox' class='time unbooked'  time1='".$this->Custom->getTimeSlots($i)."' time2='".$this->Custom->getTimeSlots($i+1)."' value='0' main='".$i."' id='roundedOne_".$i."' />";
                 $response .= "<label for='roundedOne_".$i."'></label>";
                 $response .= "<input type='hidden' name='times[]' class='hidden_time' id='time_".$i."' value='0'/> </div>";
                 $response .= "<div class='chekbox_txt'> <span>" .$this->Custom->getTimeSlots($i). "</span>";
                 $response .= $this->Custom->getTimeSlots($i+1)."</div></div>";
             }
         }else{
             $times = unserialize($results[0]['times']);
             for ($i=0; $i < count($times); $i++) { 
                  if($times[$i] > 0){
                      $check = "checked";
                      $disabled = "disabled";
                      $class = "booked";
                      $classlabel = "bookedlabel";
                      $title = "Blocked";
                  }else{
                      $check = "";
                      $disabled = "";
                      $class = "unbooked";
                      $classlabel = "unbookedlabel";
                      $title = "Available";
                  }
                 $response .= "<div class='checkbox'><div title='".$title."' class='roundedOne ".$classlabel."'>";
                 $response .= "<input type='checkbox' ".$check." " .$disabled. " class='time ".$class."' value='0' time1='".$this->Custom->getTimeSlots($i)."' time2='".$this->Custom->getTimeSlots($i+1)."' main='".$i."' id='roundedOne_".$i."' />";
                 $response .= "<label for='roundedOne_".$i."'></label>";
                 $response .= "<input type='hidden' name='times[]' class='hidden_time' id='time_".$i."' value='".$times[$i]."'/> </div>";
                 $response .= "<div class='chekbox_txt'> <span>" .$this->Custom->getTimeSlots($i). "</span>";
                 $response .= $this->Custom->getTimeSlots($i+1)."</div></div>";
             }
         }
         $this->set('message', $response);
         $this->set('_serialize',array('message'));
         $this->response->statusCode(200);
      }
  }

  public function makeSpecialOffer($appid)
  {
    if($this->request->is('post')){
        $dataArr = $this->request->data;
        $appid   = base64_decode($appid);
        $appoinment_details = $this->Appointments->find()->where(['id' => $appid])->toArray();
        if(!empty($appoinment_details[0]['special_offer_modify_date'])){
            $this->request->session()->write('error_alert','You already created request for special offer !!');
            return $this->redirect('/trainers');
        }
        $updateArr = array(
            'special_offer_price' => $dataArr['set_price'],
            'special_offer_modify_date' => Time::now(),
            'session_data' => serialize($dataArr['booking'])
          );
        $this->appointments->query()->update()->set($updateArr)->where(['id' => $appid])->execute();
        $this->appointment_sessions->query()->delete()->where(['appId' => $appid])->execute();
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
        $notificationArr = array(
            'noti_type'          => 'Make Special Offer',
            'parent_id'          => $appid,
            'noti_sender_type'   => 'trainer',
            'noti_sender_id'     => $this->data['id'],
            'noti_receiver_type' => 'trainee',
            'parent_id_status'   => 3,
            'noti_receiver_id'   => $appoinment_details[0]['trainee_id'],
            'noti_message'       => 'have make a request for special offer',
            'noti_added_date'    => Time::now()
            );
        $notifications = $this->Notifications->newEntity();
        $notifications = $this->Notifications->patchEntity($notifications, $notificationArr);
        $result = $this->Notifications->save($notifications);
        $this->request->session()->write('sucess_alert','Special offer request successfully created !!');
        return $this->redirect('/trainers');
    }else{
       return $this->redirect('/trainers');
    }
  }

  public function wallet()
    {
      $profile_details = $this->Trainers->find()->where(['user_id' => $this->data['id']])->toArray();
      $total_wallet_ammount = $this->Total_wallet_ammount->find()->where(['user_id' => $this->data['id']])->toArray();
      $wallet_txn = $this->Trainer_txns->find()->where(['trainer_id' => $this->data['id']])->order(['id' => 'DESC'])->toArray();
      $this->set('wallet_txn', $wallet_txn);
      $this->set('total_wallet_ammount', $total_wallet_ammount);
      $this->set('profile_details', $profile_details);
    }

  public function reports()
    {
      if(isset($_POST['filter_report'])){
        $form_data  = $this->request->data;
        if($form_data['selector'] == "date"){ 
          $start_date = $form_data['from_date'];
          $end_date   = $form_data['to_date'];
          $this->Flash->default($start_date, ['key' => 'start_date']); 
          $this->Flash->default($end_date,   ['key' => 'end_date']); 
          $txn_details = $this->conn->execute('SELECT * FROM trainer_txns WHERE DATE(added_date) BETWEEN  "'.$start_date.'" AND "'.$end_date.'" AND trainer_id = '.$this->data['id'].' ORDER BY id DESC ')->fetchAll('assoc');
        }
        else if($form_data['selector'] == "week"){ 
          $week = $form_data['week'];
          $txn_details = $this->conn->execute('SELECT * FROM trainer_txns WHERE YEAR(added_date) = '.date('Y').' AND MONTH(added_date) = '.date('m') .' AND trainer_id = '.$this->data['id'].' ORDER BY id DESC ')->fetchAll('assoc');
        }
        else if($form_data['selector'] == "month"){ 
          $month = $form_data['month'];
          $txn_details = $this->conn->execute('SELECT * FROM trainer_txns WHERE YEAR(added_date) = '.date('Y').' AND MONTH(added_date) = '.$month .' AND trainer_id = '.$this->data['id'].' ORDER BY id DESC ')->fetchAll('assoc');
        }
        else if($form_data['selector'] == "annual"){ 
          $annual   = $form_data['annual'];
          $txn_details = $this->conn->execute('SELECT * FROM trainer_txns WHERE year(added_date) = '.$annual .' AND trainer_id = '.$this->data['id'].' ORDER BY id DESC ')->fetchAll('assoc');
        }
        $custom_packages = $this->conn->execute('SELECT *,`cp`.`id` AS `cp_id` FROM `custom_packages_history` AS `cp` INNER JOIN `trainees` AS `t` ON `cp`.`trainee_id` = `t`.`user_id` WHERE `cp`.`trainer_id` ='.$this->data['id'].' ORDER BY `cp`.`id` DESC LIMIT 10')->fetchAll('assoc');
        $appointments = $this->conn->execute('SELECT *,`a`.`id` AS `appo_id` FROM `appointments` AS `a` INNER JOIN `trainees` AS `t` ON `a`.`trainee_id` = `t`.`user_id` WHERE `a`.`trainer_id` ='.$this->data['id'].' ORDER BY `a`.`id` DESC LIMIT 10')->fetchAll('assoc');
      }else{
        $txn_details = $this->Trainer_txns->find()->where(['trainer_id' => $this->data['id']])->order(['id' => 'DESC'])->limit(10)->toArray();
        $custom_packages = $this->conn->execute('SELECT *,`cp`.`id` AS `cp_id` FROM `custom_packages_history` AS `cp` INNER JOIN `trainees` AS `t` ON `cp`.`trainee_id` = `t`.`user_id` WHERE `cp`.`trainer_id` ='.$this->data['id'].' ORDER BY `cp`.`id` DESC LIMIT 10')->fetchAll('assoc');
        $appointments = $this->conn->execute('SELECT *,`a`.`id` AS `appo_id` FROM `appointments` AS `a` INNER JOIN `trainees` AS `t` ON `a`.`trainee_id` = `t`.`user_id` WHERE `a`.`trainer_id` ='.$this->data['id'].' ORDER BY `a`.`id` DESC LIMIT 10')->fetchAll('assoc');
      }
      $profile_details = $this->Trainers->find()->where(['user_id' => $this->data['id']])->toArray();
      $total_wallet_ammount = $this->Total_wallet_ammount->find()->where(['user_id' => $this->data['id']])->toArray();
      $this->set('appointments', $appointments);
      $this->set('txn_details', $txn_details);
      $this->set('custom_packages', $custom_packages);
      $this->set('total_wallet_ammount', $total_wallet_ammount);
      $this->set('profile_details', $profile_details);
    }

  public function withdrawRequest()
  {
    if($this->request->is('post')){
        $dataArr = $this->request->data;
        $service_fee_details = $this->Fees->find()->where(['type' => 'Withdrawal'])->toArray();
        if(!empty($service_fee_details)){
            $txn_fee =  $service_fee_details[0]['txn_fee'];
        }else{
            $txn_fee = 0;
        }
        $withdraw_fees = round(($dataArr['withdraw_amount'] * $txn_fee)/100,2);
        $final_withdraw_amount = round(($dataArr['withdraw_amount'] - $withdraw_fees),2);
        $trainerWithdrawArr = array(
            'trainer_id'      => $this->data['id'],
            'ammount'         => $dataArr['withdraw_amount'],
            'withdraw_payment_type' => $dataArr['payment_type'],
            'withdraw_fees'         => $withdraw_fees,
            'final_withdraw_amount' => $final_withdraw_amount,
            'withdraw_status' => 0,
            'added_date'      => Time::now()
            );
        $trainerWithdraw = $this->Trainer_withdraw->newEntity();
        $trainerWithdraw = $this->Trainer_withdraw->patchEntity($trainerWithdraw, $trainerWithdrawArr);
        $result = $this->Trainer_withdraw->save($trainerWithdraw);
        $lid = $result->id;

        $total_wallet_ammount = $this->Total_wallet_ammount->find()->where(['user_id' => $this->data['id']])->toArray();
        $total_wallet_ammount_arr = array(
              'total_ammount' => $total_wallet_ammount[0]['total_ammount'] - $dataArr['withdraw_amount'],
              );
        $this->total_wallet_ammount->query()->update()->set($total_wallet_ammount_arr)->where(['user_id' => $this->data['id']])->execute();

        $this->request->session()->write('sucess_alert','Your withdraw request successfully created !!');
        return $this->redirect('/trainers/wallet');
    }else{
       return $this->redirect('/trainers');
    }
  }

  public function packagepdf()
  {
    $pid = $this->request->query['id'];
    $custom_packages = $this->conn->execute('SELECT *,`cp`.`id` AS `cp_id` FROM `custom_packages_history` AS `cp` INNER JOIN `trainees` AS `t` ON `cp`.`trainee_id` = `t`.`user_id` WHERE `cp`.`id` ='.$pid)->fetchAll('assoc');
    $filename = 'Custom Package '.date('Y-m-d').'.pdf';
    $html  = "";
    $html .= "<div style='width:100%; float:left;'><div style='float:left; width:50%;'><img style='width:300px;' src='".$this->request->webroot."img/belibit_tv_logo_old1.png'></div><div style='float:right; width:200px;'><h1 style='color:#666;'>INVOICE</h1></div></div> ";
    $html .= "<div style='width:100%; float:left;'> <div style='float:left; width:50%;'><p style='font-size:14px; color:#666; margin:0px;'>You Tag Media & Business Solutions, Inc 1950 Broad Street, Unit 209 Regina, SK S4P 1X6 Canada</p><p style='font-size:14px; color:#666;  margin:0px;'>help@virtualtrainr.com</p><p style='font-size:14px; color:#666; margin:0px;'>+403-800-4843</p><br><br><h3 style='font-size:22px; color:#666; margin:0px 0px 5px 0px;'>Invoice to: </h3><p style='font-size:14px; padding:5px 0px; color:#666; margin:0px;'>Name : ".ucwords($custom_packages[0]['trainee_name']." ".$custom_packages[0]['trainee_lname'])."</div></div>";
    $html .= "<div style='width:100%; float:left;'><br><br><h3 style='font-size:22px; color:#666; margin:0px 0px 5px 0px;'>Details: </h3>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Purchase Date : ".date('d F Y, h:i A', strtotime($custom_packages[0]['created_date']))."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Package Name : ".$custom_packages[0]['package_name']."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Package Description   : ".$custom_packages[0]['package_description']."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Package Price : $".$custom_packages[0]['price']."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Service Fee : $".$custom_packages[0]['service_fee']."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Discount : $".round($custom_packages[0]['total_price'] - $custom_packages[0]['final_price'],2)."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Final Price : $".$custom_packages[0]['final_price']."</p>
              </div>";
    $this->Custom->downloadpdf($html,$filename);
  }

  public function sessionpdf()
  {
    $pid = $this->request->query['id'];
    $custom_packages = $this->conn->execute('SELECT *,`a`.`id` AS `appo_id` FROM `appointments` AS `a` INNER JOIN `trainees` AS `t` ON `a`.`trainee_id` = `t`.`user_id` WHERE `a`.`id` ='.$pid)->fetchAll('assoc');
    $totalSessions = count(unserialize($custom_packages[0]['session_data']));
    $filename = 'Rate Plans '.date('Y-m-d').'.pdf';
    $html  = "";
    $html .= "<div style='width:100%; float:left;'><div style='float:left; width:50%;'><img style='width:300px;' src='".$this->request->webroot."img/belibit_tv_logo_old1.png'></div><div style='float:right; width:200px;'><h1 style='color:#666;'>INVOICE</h1></div></div> ";
    $html .= "<div style='width:100%; float:left;'> <div style='float:left; width:50%;'><p style='font-size:14px; color:#666; margin:0px;'>You Tag Media & Business Solutions, Inc 1950 Broad Street, Unit 209 Regina, SK S4P 1X6 Canada</p><p style='font-size:14px; color:#666;  margin:0px;'>help@virtualtrainr.com</p><p style='font-size:14px; color:#666; margin:0px;'>+403-800-4843</p><br><br><h3 style='font-size:22px; color:#666; margin:0px 0px 5px 0px;'>Invoice to: </h3><p style='font-size:14px; padding:5px 0px; color:#666; margin:0px;'>Name : ".ucwords($custom_packages[0]['trainee_name']." ".$custom_packages[0]['trainee_lname'])."</div></div>";
    $html .= "<div style='width:100%; float:left;'><br><br><h3 style='font-size:22px; color:#666; margin:0px 0px 5px 0px;'>Details: </h3>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Purchase Date : ".date('d F Y, h:i A', strtotime($custom_packages[0]['created_date']))."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Session Name : ".$totalSessions." Sessions</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Session Price   : $".$custom_packages[0]['session_price']."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Service Price : $".$custom_packages[0]['service_fee']."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Total Fee : $".$custom_packages[0]['total_price']."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Discount : $".round($custom_packages[0]['total_price'] - $custom_packages[0]['final_price'],2)."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Final Price : $".$custom_packages[0]['final_price']."</p>
              </div>";
    $this->Custom->downloadpdf($html,$filename);
  }

  public function withdrawpdf()
  {
    $tid = $this->request->query['id'];
    $txn_details = $this->conn->execute("SELECT * FROM `trainer_withdraw` AS `tx` INNER JOIN `trainers` AS `t` ON `tx`.`trainer_id` = `t`.`user_id` WHERE `tx`.`id` = ".$tid)->fetchAll('assoc');
    $filename = 'Withdraw '.$txn_details[0]['withdraw_txn_id'].' '.date('Y-m-d').'.pdf';
    switch ($txn_details[0]['withdraw_payment_type']) {
          case '0':
            $type = "Paypal";
            break;
          case '1':
            $type = "Amazon";
            break;
          default:
            $type = "Direct Payment";
            break;
        }
    switch ($txn_details[0]['withdraw_status']) {
          case '0':
            $status = "Pending";
            break;
          case '1':
            $status = "Completed";
            break;
          case '2':
            $status = "Failed";
            break;
          default:
            $status = "NA";
            break;
      }
    $html  = "";
    $html .= "<div style='width:100%; float:left;'><div style='float:left; width:50%;'><img style='width:300px;' src='".$this->request->webroot."img/belibit_tv_logo_old1.png'></div><div style='float:right; width:200px;'><h1 style='color:#666;'>INVOICE</h1></div></div> ";
    $html .= "<div style='width:100%; float:left;'> <div style='float:left; width:50%;'><p style='font-size:14px; color:#666; margin:0px;'>You Tag Media & Business Solutions, Inc 1950 Broad Street, Unit 209 Regina, SK S4P 1X6 Canada</p><p style='font-size:14px; color:#666;  margin:0px;'>help@virtualtrainr.com</p><p style='font-size:14px; color:#666; margin:0px;'>+403-800-4843</p><br><br><h3 style='font-size:22px; color:#666; margin:0px 0px 5px 0px;'>Invoice to: </h3><p style='font-size:14px; padding:5px 0px; color:#666; margin:0px;'>Name : ".ucwords($txn_details[0]['trainer_name']." ".$txn_details[0]['trainer_lname'])."</div></div>";
    $html .= "<div style='width:100%; float:left;'><br><br><h3 style='font-size:22px; color:#666; margin:0px 0px 5px 0px;'>Details: </h3>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Withdraw Date : ".date('d F Y, h:i A', strtotime($txn_details[0]['added_date']))."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Withdraw Amount : $".$txn_details[0]['ammount']."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Administration Fee : $".$txn_details[0]['withdraw_fees']."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Final Amount : $".$txn_details[0]['final_withdraw_amount']."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Withdraw Id : ".$txn_details[0]['withdraw_txn_id']."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Payment Gateway : ".$type."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Status : ".$status."</p>
              </div>";
    $this->Custom->downloadpdf($html,$filename);
  }

  public function txnpdf()
  {
    $tid = $this->request->query['id'];
    $txn_details = $this->conn->execute("SELECT * FROM `trainer_txns` AS `tx` INNER JOIN `trainers` AS `t` ON `tx`.`trainer_id` = `t`.`user_id` WHERE `tx`.`id` = ".$tid)->fetchAll('assoc');
    $filename = 'Transaction '.$txn_details[0]['txn_id'].' '.date('Y-m-d').'.pdf';
    $status = 'Completed';
    $html  = "";
    $html .= "<div style='width:100%; float:left;'><div style='float:left; width:50%;'><img style='width:300px;' src='".$this->request->webroot."img/belibit_tv_logo_old1.png'></div><div style='float:right; width:200px;'><h1 style='color:#666;'>INVOICE</h1></div></div> ";
    $html .= "<div style='width:100%; float:left;'> <div style='float:left; width:50%;'><p style='font-size:14px; color:#666; margin:0px;'>You Tag Media & Business Solutions, Inc 1950 Broad Street, Unit 209 Regina, SK S4P 1X6 Canada</p><p style='font-size:14px; color:#666;  margin:0px;'>help@virtualtrainr.com</p><p style='font-size:14px; color:#666; margin:0px;'>+403-800-4843</p><br><br><h3 style='font-size:22px; color:#666; margin:0px 0px 5px 0px;'>Invoice to: </h3><p style='font-size:14px; padding:5px 0px; color:#666; margin:0px;'>Name : ".ucwords($txn_details[0]['trainer_name']." ".$txn_details[0]['trainer_lname'])."</div></div>";
    $html .= "<div style='width:100%; float:left;'><br><br><h3 style='font-size:22px; color:#666; margin:0px 0px 5px 0px;'>Details: </h3>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Transaction Date : ".date('d F Y, h:i A', strtotime($txn_details[0]['added_date']))."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Transaction Amount : $".$txn_details[0]['total_amount']."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Transaction Name : $".$txn_details[0]['txn_name']."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Administration Fee : $".$txn_details[0]['administration_fee']."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Transaction Id : ".$txn_details[0]['txn_id']."</p>
              <p style='font-size:16px; color:#666; margin:0px; padding:5px 0px;'>Status : ".$status."</p>
              </div>";
    $this->Custom->downloadpdf($html,$filename);
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

  public function notesmgmt()
  {
    if($this->request->is('post'))
      {
         $data = $this->request->data;
         $noteid = $data['notes_id'];
         $notes = $data['notes'];
         unset($data['notes_id']);
         if(!empty($noteid)){
          $this->conn->execute('UPDATE `notes` SET `notes` = "'.$notes.'" WHERE `id` ='.$noteid);
         }else{
          $data['trainer_id'] = $this->data['id'];
          $data['created_date'] = Time::now();
          $user1 = $this->Notes->newEntity();
          $user1 = $this->Notes->patchEntity($user1, $data);
          $result1 = $this->Notes->save($user1);
         }
        return $this->redirect('/trainers');
      }
  }

  public function getneratePDFReport($type)
  {
    $html  = "";
    $html .= "<div style='width:100%; float:left;'><div style='float:left; width:50%;'><img style='width:300px;' src='".$this->request->webroot."img/belibit_tv_logo_old1.png'></div><div style='float:right; width:200px;'><h1 style='color:#666;'>Report</h1></div></div> ";
    $html .= "<div style='width:100%; float:left;'> <div style='float:left; width:50%;'><p style='font-size:14px; color:#666; margin:0px;'>You Tag Media & Business Solutions, Inc 1950 Broad Street, Unit 209 Regina, SK S4P 1X6 Canada</p><p style='font-size:14px; color:#666;  margin:0px;'>help@virtualtrainr.com</p><p style='font-size:14px; color:#666; margin:0px;'>+403-800-4843</p><br><br></div></div>";
    if($type == "custom"){
      $filename = "Custom Packages Sold Report ".date('Y-m-d').".pdf";
      $custom_packages = $this->conn->execute('SELECT *,`cp`.`id` AS `cp_id` FROM `custom_packages_history` AS `cp` INNER JOIN `trainees` AS `t` ON `cp`.`trainee_id` = `t`.`user_id` WHERE `cp`.`trainer_id` ='.$this->data['id'].' ORDER BY `cp`.`id` DESC LIMIT 10')->fetchAll('assoc');
      $html .= " 
            <div style='font-size:20px; width:2250px; margin:0; font-family: 'HelveticaLTStdLight';'>
             <h4 style='color:#575757;'>Custom Packages Sold Report</h4>
             <div style=' width:2250px; margin:0;'>
               <div style='height:25px; color:#575757; font-weight:bold; padding-top:5px; text-align:center; border:1px solid #999; float:left; width:120px; font-size:14px; margin:0;'>
                 TRANS #
               </div>
               <div style='height:25px; color:#575757; font-weight:bold; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>  
               CUSTOMER     
               </div>
               <div style='height:25px; color:#575757; font-weight:bold; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                PACKAGE
               </div>
               <div style='height:25px; color:#575757; font-weight:bold; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                PRICE
               </div>
               <div style='height:25px; color:#575757; font-weight:bold; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                SERVICE FEE
               </div>";
        $i = 1;
        foreach($custom_packages as $t){ 
          $html .= "<div style='height:25px; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                    SK".$i."
                   </div>";
          $html .= "<div style='height:25px; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                    ".$t['trainee_name']." ".$t['trainee_lname']."
                   </div>";
          $html .= "<div style='height:25px; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                    ".$t['package_name']."
                   </div>";
          $html .= "<div style='height:25px; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                    $".$t['price']."
                   </div>";
          $html .= "<div style='height:25px; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                    $".$t['service_fee']."
                   </div>";
        $i++; } 
        $html .= " </div></div>";
    }
    else if($type == "sessions"){
      $appointments = $this->conn->execute('SELECT *,`a`.`id` AS `appo_id` FROM `appointments` AS `a` INNER JOIN `trainees` AS `t` ON `a`.`trainee_id` = `t`.`user_id` WHERE `a`.`trainer_id` ='.$this->data['id'].' ORDER BY `a`.`id` DESC LIMIT 10')->fetchAll('assoc');
      $html .= " 
            <div style='font-size:20px; width:2250px; margin:0; font-family: 'HelveticaLTStdLight';'>
             <h4 style='color:#575757;'>Rate Plans Packages Sold Report</h4>
             <div style=' width:2250px; margin:0;'>
               <div style='height:25px; color:#575757; font-weight:bold; padding-top:5px; text-align:center; border:1px solid #999; float:left; width:120px; font-size:14px; margin:0;'>
                 TRANS #
               </div>
               <div style='height:25px; color:#575757; font-weight:bold; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>  
               CUSTOMER     
               </div>
               <div style='height:25px; color:#575757; font-weight:bold; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                SESSION
               </div>
               <div style='height:25px; color:#575757; font-weight:bold; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                PRICE
               </div>
               <div style='height:25px; color:#575757; font-weight:bold; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                SERVICE FEE
               </div>";
        $j = 1;
        foreach($appointments as $t){ 
          $totalSessions = count(unserialize($t['session_data']));
          $html .= "<div style='height:25px; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                    SK".$j."
                   </div>";
          $html .= "<div style='height:25px; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                    ".$t['trainee_name']." ".$t['trainee_lname']."
                   </div>";
          $html .= "<div style='height:25px; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                    ".$totalSessions." Sessions
                   </div>";
          $html .= "<div style='height:25px; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                    $".$t['final_price']."
                   </div>";
          $html .= "<div style='height:25px; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                    $".$t['service_fee']."
                   </div>";
        $j++; } 
        $html .= " </div></div>";
     $filename = "Rate Plans Packages Sold Report ".date('Y-m-d').".pdf"; 
    }
    else if($type == "txn"){
      $txn_details = $this->Trainer_txns->find()->where(['trainer_id' => $this->data['id']])->order(['id' => 'DESC'])->limit(10)->toArray();
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
               <div style='height:25px; color:#575757; font-weight:bold; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                TXN-ID
               </div>
               <div style='height:25px; color:#575757; font-weight:bold; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                AMOUNT
               </div>
               <div style='height:25px; color:#575757; font-weight:bold; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                STATUS
               </div>";
        $k = 1;
        foreach($txn_details as $t){ 
          $html .= "<div style='height:25px; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                    SK".$k."
                   </div>";
          $html .= "<div style='height:25px; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                    ".$t['txn_name']."
                   </div>";
          $html .= "<div style='height:25px; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                    ".$t['txn_id']."
                   </div>";
          $html .= "<div style='height:25px; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                    $".$t['total_amount']."
                   </div>";
          $html .= "<div style='height:25px; padding-top:5px; text-align:center; border:1px solid #999; float:left; font-size:14px; width:120px; margin:0;'>
                    Completed
                   </div>";
        $k++; } 
        $html .= " </div></div>";
     $filename = "Transactions History Report ".date('Y-m-d').".pdf";  
    }
    $this->Custom->downloadpdf($html,$filename);
  }

  public function getnerateExcelReport($type)
  {
    if($type == "custom"){
      $headingArr = array('TRANS #','CUSTOMER','PACKAGE NAME','PRICE','DATE');
      $custom_packages = $this->conn->execute('SELECT *,`cp`.`id` AS `cp_id` FROM `custom_packages_history` AS `cp` INNER JOIN `trainees` AS `t` ON `cp`.`trainee_id` = `t`.`user_id` WHERE `cp`.`trainer_id` ='.$this->data['id'].' ORDER BY `cp`.`id` DESC ')->fetchAll('assoc');
      $final_array = array();
      $i = 1;
      foreach ($custom_packages as $key => $v) {
        $index = ($i >= 10) ? $i : "0".$i;
        $row['id']      = 'SK'.$index;
        $row['name']    = $v['trainee_name']." ".$v['trainee_lname'];
        $row['package'] = $v['package_name'];
        $row['price']   = "$".$v['price'];
        $row['created_date'] = $v['created_date'];
        $i++;
        array_push($final_array, array_values($row));
      }
      $filename = "Custom Packages Sold Report ".date('Y-m-d').".csv";
    }
    else if($type == "sessions"){
      $headingArr = array('TRANS #','CUSTOMER','SESSION NAME','PRICE','DATE');
      $appointments = $this->conn->execute('SELECT *,`a`.`id` AS `appo_id` FROM `appointments` AS `a` INNER JOIN `trainees` AS `t` ON `a`.`trainee_id` = `t`.`user_id` WHERE `a`.`trainer_id` ='.$this->data['id'].' ORDER BY `a`.`id` DESC')->fetchAll('assoc');
      $final_array = array();
      $i = 1;
      foreach ($appointments as $key => $v) {
        $index = ($i >= 10) ? $i : "0".$i;
        $totalSessions = count(unserialize($v['session_data']));
        $row['id']      = 'SK'.$index;
        $row['name']    = $v['trainee_name']." ".$v['trainee_lname'];
        $row['session'] = $totalSessions." Sessions";
        $row['price']   = "$".$v['final_price'];
        $row['created_date'] = $v['created_date'];
        $i++;
        array_push($final_array, array_values($row));
      }
     $filename = "Rate Plans Packages Sold Report ".date('Y-m-d').".csv"; 
    }
    else if($type == "txn"){
      $headingArr = array('TRANS #','TRANSACTION NAME','TRANSACTION ID','AMOUNT','DATE','STATUS');
      $txn_details = $this->Trainer_txns->find()->where(['trainer_id' => $this->data['id']])->order(['id' => 'DESC'])->toArray();
      $final_array = array();
      $i = 1;
      foreach ($txn_details as $key => $v) {
        $index = ($i >= 10) ? $i : "0".$i;
        $row['id']          = 'SK'.$index;
        $row['txn_name']    = $v['txn_name'];
        $row['txn_id']      = $v['txn_id'];
        $row['total_amount']= "$".$v['total_amount'];
        $row['added_date']= $v['added_date'];
        $i++;
        array_push($final_array, array_values($row));
      }
     $filename = "Transactions History Report ".date('Y-m-d').".csv";  
    }
    $this->Custom->exportCSV($filename,$final_array,$headingArr);
  }




}

?>
