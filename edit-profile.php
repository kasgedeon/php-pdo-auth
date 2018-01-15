
	<!--HTML Layout starts here -->
	<?php 
	$page_title = 'GedeonKas - Edit Profile';
	include_once 'partials/header.php';
	include_once 'partials/parseProfile.php';
	?>	
	
	<div class='container'>
	  <section class='col col-lg-7'>
		<h2>Edit Profile</h2><hr>
		
		<div>
			<?php if(isset($result)) echo $result; ?>
			<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
		</div>
		<div class='clearfix'></div>
		
		<?php if(!isset($_SESSION['username'])): ?>
		   <p class="lead">You are not authorized to view this page! <a href="login.php">Login...</a> 
		    Don't have an account? <a href="signup.php">Register</a></p>
		<?php else: ?>		
			<form method='post' action=''>
			  <div class="form-group">
				<label for="emailField">Email</label>
				<input type="text" class="form-control" id="emailField" value="<?php if(isset($email)) echo $email; ?>" name='email'>
			  </div>
			  <div class="form-group">
				<label for="usernameField">Username</label>
				<input type="text" class="form-control" id="usernameField" value="<?php if(isset($username)) echo $username; ?>" name='username'>
			  </div>
			  <input type="hidden" value="<?php if(isset($encode_id)) echo $encode_id; ?>" name='hidden_id'>
			  <button type="submit" class="btn btn-default pull-right" name='updateProfileBtn'>Update Profile</button>
			</form>
		<?php endif ?>
		<p><a href="index.php">Back</a></p>
		<p><?php if(isset($encode_id)) echo $id; ?></p>
	  </section>
	</div>
		
	<?php include_once 'partials/footer.php'; ?>
	</body>
</html>