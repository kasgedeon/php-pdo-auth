<?php
//add scripts - db connection, etc.
include_once 'res/database.php';
include_once 'res/utility.php';

//processing of the form when button is clicked
if(isset($_POST['resetBtn'])){
	$form_errors = array(); //initialize array
	
	//field validation
	$required_fields = array('email', 'new_password', 'confirm_password');
	//call function to check empty fields & merge return data into $form_errors
	$form_errors = array_merge($form_errors, check_empty_fields($required_fields));
	
	//check for minimum length
	$fields_to_check_length = array('new_password' => 5, 'confirm_password' => 5);
	//call function to check min lenght
	$form_errors = array_merge($form_errors, check_min_lenght($fields_to_check_length));
	
	//email validation
	$form_errors = array_merge($form_errors, check_mail($_POST));
	
	
	//check error array is empty
	if(empty($form_errors)){
		//collect form data into variable
		$email=$_POST['email'];
		$pass1=$_POST['new_password'];
		$pass2=$_POST['confirm_password'];
		
		//Check if new_password and confirm_password are the same
		if($pass1 != $pass2){
			$result = flashMessage('New password and Confirm Password do not match');
		}
		else {
			try {
				//verify input email exists in the database
				$sqlQuery = "SELECT email FROM users WHERE email = :email";
				//PDO prepared statement: sanitize data		
				$stm = $db->prepare($sqlQuery);
				$stm->execute(array(':email' => $email)); //execute prepared query
				
				//check recor exists
				if($stm->rowCount()==1){
					//hashing password
					$hash_pass = password_hash($pass1, PASSWORD_DEFAULT);
					
					//update password
					$sqlUpdate = "UPDATE users SET password=:pass WHERE email=:email";
					$stm = $db->prepare($sqlUpdate);
					$stm->execute(array(':pass' => $hash_pass, ':email' => $email)); //execute prepared query
					
					//call sweet alert - print msg
					echo $result="<script type=\"text/javascript\">
							swal({
							  title: \"Updated!\",
							  text: \"Password reset successfully\",
							  type: 'success',
							  confirmButtonText: \"Thank You!\"
							});
						  </script>";
					//$result = flashMessage('Password reset successfully', 'Pass');
				}
				else {
					echo $result="<script type=\"text/javascript\">
							swal({
							  title: \"Failed!\",
							  text: \"Email address does not exist in the database, Please try again\",
							  type: 'error',
							  confirmButtonText: \"Ok!\"
							});
						  </script>";
					//$result = flashMessage('Email address does not exist in the database, Please try again');
				}
			} catch(PDOException $ex){
				$result = flashMessage("An error occured: " .$ex->getMessage());
			}
		}
	}
	else {
		if(count($form_errors)==1){
			$result = flashMessage('There was 1 error in the form');
		}
		else {
			$result = flashMessage("There were " .count($form_errors) ." errors in the form");
		}
	}
}		

?>