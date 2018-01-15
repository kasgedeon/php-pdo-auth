<?php
//add scripts - db connection, etc.
include_once 'res/database.php';
include_once 'res/utility.php';

//processing of the form & validation
if(isset($_POST['signBtn'])){
	
	$form_errors = array(); //initialize array
	
	//field validation
	$required_fields = array('email', 'username', 'password');
	//call function to check empty fields & merge return data into $form_errors
	$form_errors = array_merge($form_errors, check_empty_fields($required_fields));
	
	//check for minimum length
	$fields_to_check_length = array('username' => 4, 'password' => 5);
	//call function to check min lenght
	$form_errors = array_merge($form_errors, check_min_lenght($fields_to_check_length));
	
	//email validation
	$form_errors = array_merge($form_errors, check_mail($_POST));
	
	
	//collect form data into variable
	$email=$_POST['email'];
	$uname=$_POST['username'];
	$pass=$_POST['password'];
	
	//check email is available
	if(checkDuplicateEntries('users', 'email', $email, $db)){
		$result = flashMessage('Email already in use, please try another email address');
	}
	//check username doesn't already exist in db
	else if(checkDuplicateEntries('users', 'username', $uname, $db)){
		$result = flashMessage('Username is already taken, please select another one');
	}
		
	//check error array is empty
	else if (empty($form_errors)){
		
		//hashing password
		$hash_pass = password_hash($pass, PASSWORD_DEFAULT);

		try {
			$sqlinsert = 'INSERT INTO users (username, email, password, join_date) 
					VALUES (:uname, :email, :pass, now())';
			//PDO prepared statement: sanitize data		
			$stm = $db->prepare($sqlinsert);
			$stm->execute(array(':uname'=>$uname, ':email'=>$email, ':pass'=>$hash_pass)); //insert data into table
			
			//Check input was succesful: One raw created
			if($stm->rowCount()==1){
				//call sweet alert
				echo $result="<script type=\"text/javascript\">
							swal({
							  title: \"Congratulations $uname!\",
							  text: \"Registration Completed Successfully\",
							  type: 'success',
							  confirmButtonText: \"Thank You!\"
							});
						  </script>";
				//$result = flashMessage("Registration Successful", "Pass");
			}			
		} catch (PDOException $ex) {
			$result = flashMessage("An error occured: ".$ex->getMessage());
		}
	}
	else {
		if(count($form_errors)==1){
			$result = flashMessage('There was 1 error in the form <br>');
		}
		else {
			$result = flashMessage('There were ' .count($form_errors) .' errors in the form <br>');
		}
	}
}  

?>