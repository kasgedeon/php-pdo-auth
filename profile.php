	<!--HTML Layout starts here -->
	<?php 
	$page_title = 'GedeonKas - User Profile';
	include_once 'partials/header.php';
	include_once 'partials/parseProfile.php';
	?>	
	
	<div class='container'>
	  <div>
		<h2>Profile</h2><hr>
		<?php if(!isset($_SESSION['username'])): ?>
		   <p class="lead">You are not authorized to view this page! <a href="login.php">Login...</a> 
		    Don't have an account? <a href="signup.php">Register</a></p>
		<?php else: ?>
		  <section class='col col-lg-7'>
			<table class="table table-bordered table-condensed">
			   <tr><th style="width: 20%;">Username</th>
				<td><?php if(isset($username)) echo $username; ?></td></tr>
			   <tr><th>Email</th>
				<td><?php if(isset($email)) echo $email; ?></td></tr>
			   <tr><th>Date Joined</th>
				<td><?php if(isset($join_date)) echo $join_date; ?></td></tr>
			   <tr><th></th>
				<td><a class="pull-right" href="edit-profile.php?user_identity=<?php if(isset($encode_id)) echo $encode_id; ?>">
					<span class="glyphicon glyphicon-edit"></span> Edit Profile</a></td></tr>
			</table>
		  </section>
		<?php endif ?>
	  </div>
	</div>		
	<?php include_once 'partials/footer.php'; ?>
	</body>
</html>