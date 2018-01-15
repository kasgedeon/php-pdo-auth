<?php 
$page_title = 'GedeonKas - Authentication';
include_once 'partials/header.php';
?>

    <div class="container">
	
	<script type='text/javascript'>
		//swal({title:"Hello world!", text:"Hello world! Hello world!", type:"success", confirmButtonText:"Cool"});
	</script>

      <div class="flag">
        <h1>User Authentication</h1><hr>
        <p class="lead"><i>Login and Registration System with PHP - Coding</i></p>
		
		<?php if(!isset($_SESSION['username'])): ?>
		
		<p class="lead">You are currently not signed in <a href='login.php'>Login</a>. 
		Don't have an account? <a href='signup.php'>Sign Up</a> </p>
		
		<?php else: ?>
		
		<p class="lead">You are logged in as <?php if(isset($_SESSION['username'])) echo $_SESSION['username']; ?> <a href=logout.php>Logout</a> </p>
		
		<?php endif ?>		
		
      </div>
	</div>
		
	<?php 
	include_once 'partials/footer.php';
	?>
		
	</body>
</html>

