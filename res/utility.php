<?php
//processing of the form & validation

/**
* @param $required_fields_array, containing all the required fields 
* @return array, containing all errors
*/
function check_empty_fields($required_fields_array){
	//array to strore any error msg from the form
	$form_errors = array();
	
	//loop through required fields array
	foreach($required_fields_array as $name_of_field){
		if(!isset($_POST[$name_of_field]) || $_POST[$name_of_field] == NULL){
			$form_errors[] = $name_of_field ." is a required field";
		}
	}
	return $form_errors;
}

/**
* @param $fields_to_check_length, containing name of fields. e.g. array('username' => 5)
* @return array, containing all errors
*/
function check_min_lenght($fields_to_check_length){
	//array to strore error msg
	$form_errors = array();
	
	//loop through required fields array
	foreach($fields_to_check_length as $name_of_field => $min_length_required){
		if(strlen(trim($_POST[$name_of_field])) < $min_length_required){
			$form_errors[] = $name_of_field ." is too short, must be at least {$min_length_required} characters long";
		}
	}
	return $form_errors;
}

/**
* @param $data, key/value pair | key=form control & value=input entered
* @return array, containing email errors
*/
function check_mail($data){
	//initialize array
	$form_errors = array();
	$key = 'email';
	
	//check email exists in data array
	if(array_key_exists($key, $data)){
		//check field has a value
		if($_POST[$key] != NULL) {
			//remove all illegal characters
			$key = filter_var($key,  FILTER_SANITIZE_EMAIL);
			
			//check if input is valid email address
			if(filter_var($_POST[$key], FILTER_VALIDATE_EMAIL) === false){
				$form_errors[] = $key ." is not a valid email address";
			}
		}
	}
	return $form_errors;
}

/**
* @param $form_errors_array, errors we want to loop through
* @return string, list that contains all error msg
*/
function show_errors($form_errors_array){
	$errors = "<p><ul style='color: red;'>";
	
	//loop through error array and display items in a list
	foreach($form_errors_array as $the_error){
		$errors .= "<li> {$the_error} </li>";
	}
	$errors .= "</ul></p>";
	return $errors;
}


/**
* @param $message, Information message we wanna print on screen
* param $passOrFail, success or failure message
* @return string, contains message
*/
function flashMessage($message, $passOrFail = "Fail"){
	if($passOrFail === "Pass"){
		$data = "<div class='alert alert-success'> {$message} ";
	}
	else {
		$data = "<div class='alert alert-danger'> {$message} ";
	}
	return $data;
}	

/**
* Redirect to another page
*/
function redirectTo($page){
	header("Location: {$page}.php");
}

/**
* Check for duplicate username
*/
function checkDuplicateEntries($table, $column, $value, $db){
	try{
		$sqlQuery = 'SELECT * FROM ' .$table. ' WHERE ' .$column. '=:column';
		$stm = $db->prepare($sqlQuery);
		$stm->execute(array('column' => $value));
		
		if($row = $stm->fetch()){
			return true;
		}
		return false;
	} catch(PDOException $ex){
		//handle exception
	}
}

/**
* @param $user_id
*/
function rememberMe($user_id) {
	$encryptCookieData = base64_encode('UaQteh514y3dtstemYODEC{$user_id}');
	//Cookie set to expire in about 15 days
	setcookie('rememberUserCookie', $encryptCookieData, time()+60*60*24*15, '/');
}

/**
* check used cookie is same as encrypted
* @param $bd
*/
function isCookieValid($db) {
	$isValid = false;
	if(isset($_COOKIE['rememberUserCookie'])) {
		
		/* decode cookie - extract user ID */
		$decryptCookieData = base64_decode($_COOKIE['rememberUserCookie']);
		$user_id = explode('UaQteh514y3dtstemYODEC', $decryptCookieData);
		$userID = $user_id[1]; //ID is at position 1 of array
		
		/* check ID from cookie exists in database */
		$sqlQuery = 'SELECT * FROM users WHERE id=:id';
		$stm = $db->prepare($sqlQuery);
		$stm->execute(array(':id'=> $userID));
		
		if($row = $stm->fetch()) {
			$id = $row['id'];
			$username = $row['username'];
			
			//create user session
			$_SESSION['id'] = $id;
			$_SESSION["username"] = $username;
			$isValid = true;
		}
		else {
			//cookie ID invalid - destroy session
			$isValid = false;
			signout();
		}
	}
	return $isValid;
}

function signout() {
	unset($_SESSION['username']);
	unset($_SESSION['id']);
	
	if(isset($_COOKIE['rememberUserCookie'])) {
		unset($_COOKIE['rememberUserCookie']);
		setcookie('rememberUserCookie', null, -1, '/');
	}
	session_destroy();
	session_regenerate_id(true);
	redirectTo('index');
}


function guard() {
	$isValid = true;
	$inactive = 60*5; //5 mins
	$fingerprint = md5($_SERVER['REMOTE_ADDR'] .$_SERVER['HTTP_USER_AGENT']);
	
	if((isset($_SESSION['fingerprint']) && $_SESSION['fingerprint'] != $fingerprint)) {
		$isValid = false;
		signout();
	}
	else if ((isset($_SESSION['last_active']) && (time()-$_SESSION['last_active']) > $inactive) && $_SESSION['username']) {
		$isValid = false;
		signout();
	}
	else {
		$_SESSION['last_active'] = time();
	}
	return $isValid;
}

?>