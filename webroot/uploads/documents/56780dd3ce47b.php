<?php
if(isset($_POST['submit']))
  {
  	if(($_POST['email']!='') && ($_POST['name']!='') && ($_POST['phone']!='') && ($_POST['venue']!='') && ($_POST['comments']!='') && ($_POST["grp_size"] !='') && ($_POST["date"]!==''))
    {
			  $to = "soravgarg123@gmail.com";
			  $email = $_POST['email'];
			  $phone = $_POST['phone']; 
			  $name = $_POST["name"];
			  $venue = $_POST["venue"];
			  $comments = $_POST["comments"];
			  $group_size = $_POST["grp_size"];
			  $date = $_POST["date"];
                
              $subject = 'the subject';
                 
			  $message = "Name: ".$name."\n";
			  $message .= "Email: ".$email."\n";
			  $message .= "Phone: ".$phone."\n";
              $message .= "Venue: ".$venue."\n"; 
              $message .= "Group Size: ".$group_size."\n"; 
              $message .= "Comments: ".$comments."\n"; 
              $message .= "Date: ".$date."\n";  

	          mail($to,$subject,$message,"From:" . $email);

	           header('Location: http://'.$_SERVER['SERVER_NAME'].'/enquiryform/?validation=success');    
    }else{
             header('Location: http://'.$_SERVER['SERVER_NAME'].'/enquiryform/?validation=fail');    
    }
 	
  }

 ?>