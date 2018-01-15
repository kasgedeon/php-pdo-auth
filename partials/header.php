<?php
include_once "res/session.php";
include_once 'res/database.php';
include_once 'res/utility.php';
?>

<!DOCTYPE html>
<html>
	<head lang="en">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		
		<title><?php if(isset($page_title))  echo $page_title; ?></title>
		
		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/custom.css" rel="stylesheet">
		<!-- SweetAlert -->
		<script src="js/sweetalert.min.js"></script>
		<link href="css/sweetalert.css" rel="stylesheet">
	</head>
	
	<body>
		<nav class="navbar navbar-inverse navbar-fixed-top">
		  <div class="container">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="index.php">GedeonKas</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
			  <ul class="nav navbar-nav">
				<li><a href="index.php">Home</a></li><i class='hide'><?php	echo guard(); ?></i>			
				<?php if(isset($_SESSION['username']) || isCookieValid($db)): ?>		
					<li><a href="profile.php">My Profile</a></li>
					<li><a href="logout.php">Logout</a></li>				
				<?php else: ?>
					<li><a href="#">About</a></li>
					<li><a href="login.php">Login</a></li>
					<li><a href="signup.php">Sign Up</a></li>
				<?php endif ?>	
				
			  </ul>
			</div><!--/.nav-collapse -->
		  </div>
		</nav>