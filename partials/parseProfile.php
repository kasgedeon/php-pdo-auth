<?php
//include php scripts
include_once 'res/database.php';
include_once 'res/utility.php';

if((isset($_SESSION['id']) || isset($_GET['user_identity'])) && !isset($_POST['updateProfileBtn'])){
	if(isset($_GET['user_identity'])){
		$url_encoded_id = $_GET['user_identity'];
		$decode_id = base64_decode($url_encoded_id);
		$user_id_array = explode('ftYuhjo43dThsSb', $decode_id);
		$id = $user_id_array[1];
	}else{
		$id = $_SESSION['id'];
	}
	
	//query database - get user data
	$sqlQuery = 'SELECT * FROM users WHERE id = :id';
	$stm = $db->prepare($sqlQuery);
	$stm->execute(array(':id' => $id));
	
	while($row = $stm->fetch()){
		$username = $row['username'];
		$email = $row['email'];
		$join_date = strftime("%b %d, %Y", strtotime($row['join_date']));
	}
	
	$encode_id = base64_encode("ftYuhjo43dThsSb{$id}");
	
}else if(isset($_POST['updateProfileBtn'])){
	//array to hold errors
	$form_errors = array();
	
	//validate
	$required_fields = array('username', 'password');
	//call function to check empty fields & merge return data into $form_errors
	$form_errors = array_merge($form_errors, check_empty_fields($required_fields));
	
	//check for minimum length
	$fields_to_check_length = array('username' => 4);
	//call function to check min lenght
	$form_errors = array_merge($form_errors, check_min_lenght($fields_to_check_length));
	
	//email validation
	$form_errors = array_merge($form_errors, check_mail($_POST));
	
	//collect form data into variable
	$email=$_POST['email'];
	$uname=$_POST['username'];
	$hidden_id=$_POST['hidden_id'];
	
	//check error array is empty
	if(empty($form_errors)){
		try{
			//sql update query
			$sqlUpdate = "UPDATE users SET username=:username, email=:email WHERE id=:id";
			$stm = $db->prepare($sqlUpdate);
			$stm->execute(array(':username' => $uname, ':email' => $email, ':id' => $hidden_id)); //execute prepared query
					
		}catch(PDOException $ex){
				$result = flashMessage("An error occured: " .$ex->getMessage());
		}
	}
}
?>