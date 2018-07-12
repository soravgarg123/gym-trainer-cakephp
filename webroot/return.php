<?php
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


if($_GET['message']=="Success"){

$sql ="select * from `total_wallet_ammount` where `user_id`='".$_GET['trainee_id']."' and `user_type` = 'trainee'";
$result = mysqli_query($conn, $sql);

$row=mysqli_num_rows($result);

$sql1 = mysqli_query($conn,"insert into `trainee_txns`(trainee_id,txn_name,payment_type,txn_type,txn_id,ammount,status,added_date,modify_date)values('".$_GET['trainee_id']."','".$_GET['name']."','".$_GET['type']."','".$_GET['type']."','".$_GET['GT_Trans_Id']."','".$_GET['total_amt']."','".$_GET['message']."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."')");

if($row == 0){
	$sql1 = mysqli_query($conn,"insert into `total_wallet_ammount`(user_id,user_type,total_ammount,status,added_date,modify_date)values('".$_GET['trainee_id']."','Trainee','".$_GET['total_amt']."','".$_GET['message']."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."')");
}else{
	while($row = $result->fetch_assoc()) {
       	$appArr[] = $row;
    }
	$total_amount = $appArr[0]['total_ammount']+$_GET['total_amt'];
	$sql1 = mysqli_query($conn,"update `total_wallet_ammount` set total_ammount = '".$total_amount."',modify_date = '".date('Y-m-d H:i:s')."'");
}
	header('Location: https://virtualtrainr.com/trainees/wallet');
}else{
	header('Location: https://virtualtrainr.com/trainees/wallet');
}

?>