<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class AppController extends Controller
{
    public function initialize()
    {
        parent::initialize();
        header('Content-Type: application/json');
        $this->loadmodel('Users');
        $this->loadmodel('Trainers');
        $this->loadmodel('Trainees');
        $this->loadmodel('Block_ips');
        $this->loadmodel('Latest_things');
        $this->loadmodel('Profile_images_videos');
        $this->loadmodel('After_before_images');
        $this->loadmodel('Trainer_ratemaster');
        $this->loadmodel('Trainer_packagemaster');
        $this->loadmodel('Hire_trainers');
        $this->loadmodel('Notifications');
        $this->loadmodel('Countries');
        $this->loadmodel('States');
        $this->loadmodel('Cities');
        $this->loadmodel('Plans_categories');  
        $this->loadmodel('Plans_sessions');
        $this->loadmodel('Vouchers');
        $this->loadmodel('Appointments');
        $this->loadmodel('Chat_session');
        $this->loadmodel('Meal_plans');
        $this->loadmodel('Favourites');
        $this->loadmodel('Documents');
        $this->loadmodel('Ratings');
        $this->loadmodel('Bmi');
        $this->loadmodel('Chating');
        $this->loadmodel('Files');  
        $this->loadmodel('Currency');
        $this->loadmodel('Vouchers_history');
        $this->loadmodel('Admin_account');
        $this->loadmodel('Admin_sessions');
        $this->loadmodel('Admin_transactions');
        $this->loadmodel('Trainee_plan');
        $this->loadmodel('Trainee_sessions');
        $this->loadmodel('Trainer_account');
        $this->loadmodel('Trainer_sessions');
        $this->loadmodel('Trainee_txns');
        $this->loadmodel('Trainer_withdraw');
        $this->loadmodel('Total_wallet_ammount');  
        $this->loadmodel('Shopping');
        $this->loadmodel('Trainer_availability');
        $this->loadmodel('Fees');
        $this->loadmodel('Orders');
        $this->loadmodel('Trainer_txns');
        $this->loadmodel('Tokbox');
        $this->loadmodel('Video_calls');
        $this->loadmodel('Notes');
        $this->loadmodel('Visitors');
        $this->loadmodel('Custom_packages_history');
        $this->loadmodel('Appointment_sessions');
        
        $this->loadComponent('Flash');
        $this->loadComponent('Custom');
        $this->loadComponent('RequestHandler');

        $this->users = TableRegistry::get('users');
        $this->trainers = TableRegistry::get('trainers');
        $this->shopping = TableRegistry::get('shopping');
        $this->trainees = TableRegistry::get('trainees');
        $this->gallery = TableRegistry::get('profile_images_videos');
        $this->progress = TableRegistry::get('after_before_images');
        $this->block_ip = TableRegistry::get('Block_ips');
        $this->categories = TableRegistry::get('Plans_categories');
        $this->sessions = TableRegistry::get('Plans_sessions');
        $this->vouchers = TableRegistry::get('Vouchers');
        $this->appointments = TableRegistry::get('Appointments');
        $this->hire_trainers = TableRegistry::get('Hire_trainers');
        $this->notifications = TableRegistry::get('Notifications');
        $this->chat_session = TableRegistry::get('Chat_session');
        $this->meal_plans = TableRegistry::get('Meal_plans');
        $this->favourites = TableRegistry::get('Favourites');
        $this->chatting = TableRegistry::get('Chating');
        $this->files = TableRegistry::get('Files');
        $this->currency = TableRegistry::get('Currency');
        $this->admin_account = TableRegistry::get('Admin_account');
        $this->admin_sessions = TableRegistry::get('Admin_sessions');
        $this->admin_transactions = TableRegistry::get('Admin_transactions');
        $this->trainee_plan = TableRegistry::get('Trainee_plan');
        $this->trainee_sessions = TableRegistry::get('Trainee_sessions');
        $this->trainer_account = TableRegistry::get('Trainer_account');
        $this->trainer_sessions = TableRegistry::get('Trainer_sessions');
        $this->trainee_txns = TableRegistry::get('Trainee_txns');
        $this->trainer_withdraw = TableRegistry::get('Trainer_withdraw');
        $this->total_wallet_ammount = TableRegistry::get('Total_wallet_ammount');
        $this->trainer_packagemaster = TableRegistry::get('Trainer_packagemaster');
        $this->trainer_availability = TableRegistry::get('Trainer_availability');
        $this->fees = TableRegistry::get('Fees');
        $this->orders = TableRegistry::get('Orders');  
        $this->trainer_txns = TableRegistry::get('Trainer_txns');
        $this->tokbox = TableRegistry::get('Tokbox');
        $this->video_calls = TableRegistry::get('Video_calls');
        $this->notes = TableRegistry::get('Notes');
        $this->visitors = TableRegistry::get('Visitors');
        $this->appointment_sessions = TableRegistry::get('Appointment_sessions');
        $this->custom_packages_history = TableRegistry::get('Custom_packages_history');
        $this->conn = ConnectionManager::get('default');  
        $this->gym = TableRegistry::get('Gym');
    }

    public function blockIP()
    {
        $this->loadmodel('Block_ips');
        $blockip = $this->Block_ips->find()->where(['ip_status' => 0])->toArray();
        $this->set('blockip',$blockip);
        $ipArr = array();
        foreach($blockip as $b)
            {
                $ipArr[] = $b['ip_address'];
            }
        $clientIP = $this->request->clientIp();
        if (in_array($clientIP, $ipArr))
            {
                return $this->redirect('http://www.google.com');
            }
    }


    public function checkvalidip()
    {
        $ip = $_GET['ip'];
        $dir = $_SERVER['DOCUMENT_ROOT'].$this->request->webroot.$ip;
        unlink($dir);
        return $this->redirect('/');
    }

    public function datafilter()
    {
        echo "string";die;
    }

    public function checkSession()
      {
        $this->data = $this->Custom->getSessionData();
        $controller = $this->request->params['controller'];  // get controller name
        if(!empty($this->data)){
            if(strtolower($controller) != strtolower($this->data['user_type']."s")){
                $this->redirect('/'.$this->data['user_type']."s");
            }
        }
      }

}
    
