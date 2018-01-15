
	<!--HTML Layout starts here -->
	<?php 
	$page_title = 'GedeonKas - Reset Password';
	include_once 'partials/header.php';
	include_once 'partials/parseForgotPass.php';
	?>	
	
	<div class='container'>
	  <section class='col col-lg-7'>
		<h2>Password Reset Form</h2><hr>
		
		<div>
			<?php if(isset($result)) echo $result; ?>
			<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
		</div>
		<div class='clearfix'></div>
		
		<form method='post' action=''>
		  <div class="form-group">
			<label for="emailField">Email address</label>
			<input type="text" class="form-control" id="emailField" placeholder="Email" name='email'>
		  </div>
		  <div class="form-group">
			<label for="passwordField1">New Password</label>
			<input type="password" class="form-control" id="passwordField1" placeholder="New Password" name='new_password'>
		  </div>
		  <div class="form-group">
			<label for="passwordField2">Confirm Password</label>
			<input type="password" class="form-control" id="passwordField2" placeholder="Confirm Password" name='confirm_password''>
		  </div>
		  
		  <button type="submit" class="btn btn-default pull-right" name='resetBtn'>Reset Password</button>
		</form>
		
	  </section>
	</div>
		
	<?php include_once 'partials/footer.php'; ?>
	</body>
</html>