<?php

/***********************  MySQL Connection Script Start ********************************************/

if($_SERVER['SERVER_NAME'] == "localhost"){
	$servername = "localhost";
	$username   = "root";
	$password   = "";
	$dbname     = "fitness";
}else{
	$servername = "localhost";
	$username   = "root";
	$password   = "Abcd@1234";
	$dbname     = "virtualtrainr";
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

/***********************  MySQL Connection Script End *********************************************/

/***********************  When Trainer Not Respond Script Start ***********************************/

$sql = 'SELECT *,`a`.`id` AS `app_id` FROM `appointments` AS `a` INNER JOIN `trainees` AS `t` ON `a`.`trainee_id` = `t`.`user_id` INNER JOIN `trainers` AS `t1` ON `a`.`trainer_id` = `t1`.`user_id` WHERE `a`.`trainer_status` = 0 AND `a`.`trainee_status` = 0 AND `a`.`special_offer_modify_date` = "" AND`a`.`created_date` <= DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY `a`.`id` DESC';
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while($row = $result->fetch_assoc()) {
       	$appArr[] = $row;
    }
} else {
    $appArr = array();	
}
if(!empty($appArr)){
	foreach($appArr as $aid){
		$usql = "UPDATE appointments SET trainer_status = 2,trainee_status = 2 WHERE id = ".$aid['app_id'];
		if (mysqli_query($conn, $usql)) {
			$trainee_noti_sql = 'INSERT INTO notifications (noti_type, parent_id, noti_sender_type,parent_id_status,noti_sender_id,noti_receiver_type,noti_receiver_id,noti_message,noti_added_date) VALUES ("Auto Decline Appointment", '.$aid['app_id'].', "admin","2","48","trainee",'.$aid['trainee_id'].',"Your appointment request is auto declined, becuase your trainer is not respond with in 24 Hours !!","'.date('Y-m-d H:i:s').'")';
			$trainer_noti_sql = 'INSERT INTO notifications (noti_type, parent_id, noti_sender_type,parent_id_status,noti_sender_id,noti_receiver_type,noti_receiver_id,noti_message,noti_added_date) VALUES ("Auto Decline Appointment", '.$aid['app_id'].', "admin","2","48","trainer",'.$aid['trainer_id'].',"Trainee appointment request is auto declined, becuase you not respond trainee request with in 24 Hours !!","'.date('Y-m-d H:i:s').'")';
			mysqli_query($conn, $trainee_noti_sql);
			mysqli_query($conn, $trainer_noti_sql);
			$txnId = $aid['trainee_id']."-".uniqid();
			$trainee_txn_sql = 'INSERT INTO trainee_txns (trainee_id,txn_name,payment_type,txn_type,txn_id,ammount,status,added_date) VALUES ('.$aid['trainee_id'].',"Decline Appoinment","Wallet","Credit","'.$txnId.'",'.$aid['final_price'].',"Approved","'.date('Y-m-d H:i:s').'")';
			mysqli_query($conn, $trainee_txn_sql);
			$wallet_data_sql = 'SELECT * FROM total_wallet_ammount WHERE user_id ='.$aid['trainee_id'];
			$wallet_result = mysqli_query($conn, $wallet_data_sql);
			if (mysqli_num_rows($wallet_result) > 0) {
				$wallet_result = $wallet_result->fetch_assoc();
				$wallet_current_balance = round($wallet_result['total_ammount'] + $aid['final_price'],2);
				$wallet_update_sql = 'UPDATE total_wallet_ammount SET total_ammount ='. $wallet_current_balance.' WHERE user_id = '.$aid['trainee_id'];
				mysqli_query($conn, $wallet_update_sql);
			}else{
				$wallet_insert_sql = 'INSERT INTO total_wallet_ammount (user_id,user_type,total_ammount,added_date) VALUES ('.$aid['trainee_id'].',"trainee",'.$aid['final_price'].',"'.date('Y-m-d H:i:s').'")';
				mysqli_query($conn, $wallet_insert_sql);
			}
		    echo "Record updated successfully"."</br>";
		} else {
		    echo "Error updating record: " . mysqli_error($conn)."</br>";
		}
	}
}

/***********************  When Trainer Not Respond Script End *************************************/

/***********************  When Trainee Not Respond Script Start ***********************************/

$sql = 'SELECT *,`a`.`id` AS `app_id` FROM `appointments` AS `a` INNER JOIN `trainees` AS `t` ON `a`.`trainee_id` = `t`.`user_id` INNER JOIN `trainers` AS `t1` ON `a`.`trainer_id` = `t1`.`user_id` WHERE `a`.`trainer_status` = 0 AND `a`.`trainee_status` = 0 AND `a`.`special_offer_modify_date` != "" AND`a`.`special_offer_modify_date` <= DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY `a`.`id` DESC';
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while($row = $result->fetch_assoc()) {
       	$appArr[] = $row;
    }
} else {
    $appArr = array();	
}

if(!empty($appArr)){
	foreach($appArr as $aid){
		$usql = "UPDATE appointments SET trainer_status = 2,trainee_status = 2 WHERE id = ".$aid['app_id'];
		if (mysqli_query($conn, $usql)) {
			$trainee_noti_sql = 'INSERT INTO notifications (noti_type, parent_id, noti_sender_type,parent_id_status,noti_sender_id,noti_receiver_type,noti_receiver_id,noti_message,noti_added_date) VALUES ("Auto Decline Appointment", '.$aid['app_id'].', "admin","2","48","trainee",'.$aid['trainee_id'].',"Your appointment request is auto declined, becuase you not respond of special offer with in 24 Hours !!","'.date('Y-m-d H:i:s').'")';
			$trainer_noti_sql = 'INSERT INTO notifications (noti_type, parent_id, noti_sender_type,parent_id_status,noti_sender_id,noti_receiver_type,noti_receiver_id,noti_message,noti_added_date) VALUES ("Auto Decline Appointment", '.$aid['app_id'].', "admin","2","48","trainer",'.$aid['trainer_id'].',"Trainee appointment request is auto declined, becuase your trainee not respond of special offer request with in 24 Hours !!","'.date('Y-m-d H:i:s').'")';
			mysqli_query($conn, $trainee_noti_sql);
			mysqli_query($conn, $trainer_noti_sql);
			$txnId = $aid['trainee_id']."-".uniqid();
			$trainee_txn_sql = 'INSERT INTO trainee_txns (trainee_id,txn_name,payment_type,txn_type,txn_id,ammount,status,added_date) VALUES ('.$aid['trainee_id'].',"Decline Appoinment","Wallet","Credit","'.$txnId.'",'.$aid['final_price'].',"Approved","'.date('Y-m-d H:i:s').'")';
			mysqli_query($conn, $trainee_txn_sql);
			$wallet_data_sql = 'SELECT * FROM total_wallet_ammount WHERE user_id ='.$aid['trainee_id'];
			$wallet_result = mysqli_query($conn, $wallet_data_sql);
			if (mysqli_num_rows($wallet_result) > 0) {
				$wallet_result = $wallet_result->fetch_assoc();
				$wallet_current_balance = round($wallet_result['total_ammount'] + $aid['final_price'],2);
				$wallet_update_sql = 'UPDATE total_wallet_ammount SET total_ammount ='. $wallet_current_balance.' WHERE user_id = '.$aid['trainee_id'];
				mysqli_query($conn, $wallet_update_sql);
			}else{
				$wallet_insert_sql = 'INSERT INTO total_wallet_ammount (user_id,user_type,total_ammount,added_date) VALUES ('.$aid['trainee_id'].',"trainee",'.$aid['final_price'].',"'.date('Y-m-d H:i:s').'")';
				mysqli_query($conn, $wallet_insert_sql);
			}
		    echo "Record updated successfully"."</br>";
		} else {
		    echo "Error updating record: " . mysqli_error($conn)."</br>";
		}
	}
}


/***********************  When Trainee Not Respond Script End *************************************/

mysqli_close($conn);
?>
