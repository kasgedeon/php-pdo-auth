
	<!--HTML Layout starts here -->
	<?php 
	$page_title = 'GedeonKas - Sign Up';
	include_once 'partials/header.php';
	include_once 'partials/parseSignup.php';
	?>	
	
	<div class='container'>
	  <section class='col col-lg-7'>
		<h2>Register</h2><hr>
		
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
			<label for="usernameField">Username</label>
			<input type="text" class="form-control" id="usernameField" placeholder="Username" name='username'>
		  </div>
		  <div class="form-group">
			<label for="passwordField">Password</label>
			<input type="password" class="form-control" id="passwordField" placeholder="Password" name='password'>
		  </div>
		  
		  <button type="submit" class="btn btn-default pull-right" name='signBtn'>Sign Up</button>
		</form>
		
	  </section>
	</div>
		
	<?php include_once 'partials/footer.php'; ?>
	</body>
</html>