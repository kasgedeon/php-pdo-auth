<?php
//include php scripts
include_once 'res/database.php';
include_once 'res/utility.php';

if(isset($_POST['loginBtn'])){
	//array to hold errors
	$form_errors = array();
	
	//validate
	$required_fields = array('username', 'password');
	//call function to check empty fields & merge return data into $form_errors
	$form_errors = array_merge($form_errors, check_empty_fields($required_fields));
	
	//check if the error array is empty
	if(empty($form_errors)){
		//collect form data into variable
		$uname=$_POST['username'];
		$pass=$_POST['password'];
		
		isset($_POST['remember']) ? $remember = $_POST['remember'] : $remember = "";
		
		//check user exist in the database
		$sqlQuery = "SELECT * FROM users WHERE username = :uname";
		$stm = $db->prepare($sqlQuery);
		$stm->execute(array(':uname' => $uname));
		
		while($row = $stm->fetch()){
			$id = $row['id'];
			$hashed_pass = $row['password'];
			$username = $row['username'];
			
			if(password_verify($pass, $hashed_pass)){
				$_SESSION['id'] = $id;
				$_SESSION['username'] = $username;
				
				//extra security
				$fingerprint = md5($_SERVER['REMOTE_ADDR'] .$_SERVER['HTTP_USER_AGENT']);
				$_SESSION['last_active'] = time();
				$_SESSION['fingerprint'] = $fingerprint;
				
				
				//set cookie
				if($remember === 'yes') {
					rememberMe($id);
				}
				//call sweet alert
				echo $welcome="<script type=\"text/javascript\">
							swal({
							  title: \"Welcome back $username!\",
							  text: \"You are being logged in...\",
							  type: 'success',
							  timer: 3000,
							  showConfirmButton: false
							});
							setTimeout(function(){
								window.location.href = 'index.php';
							}, 2000);
						  </script>";
				//redirectTo('index');
			}
			else {
				$result = flashMessage('Invalid username or password');
			}
		}
	}
	else {
		if(count($form_errors)==1){
			$result = flashMessage('There was 1 error in the form');
		}
		else {
			$result = flashMessage("There were " .count($form_errors) ." errors in the form <br>");
		}
	}
}
?>