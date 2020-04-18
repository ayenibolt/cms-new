<?php
include('includes/config.php');
error_reporting(0);

if(isset($_POST['submit'])){
	//grab all user input
	$fullname = mysqli_real_escape_string($con, $_POST['fullname']);
	$email = mysqli_real_escape_string($con, $_POST['email']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
	$conp = mysqli_real_escape_string($con, $_POST['confirm-password']);
	$conno = mysqli_real_escape_string($con, $_POST['contactno']);
	$phash = password_hash($password, PASSWORD_BCRYPT);
		
	//check if form fields are empty
	if($fullname == '' || $email == '' || $password == '' || $conp == '' || $conno == ''){
		echo '<div style="color: red; text-align: center;">Please fill the form</div>';
	//add user information to database and log user in
	}
	if($password != $conp){
		echo 'Passwords do not match.'; 
	}else{	
		$sql = "SELECT `email` FROM `users` WHERE `fullname` = '$fullname'";
		$sql_run = mysqli_query($con, $sql);
		$sql_results = mysqli_num_rows($sql_run);
			if($sql_results > 0){
				echo 'Email already exists. Please enter another email address';
			}else{
				$stats = 1;
				
				$query = "INSERT INTO `users` (`id`, `fullName`, `userEmail`, `password`, `contactNo`, `regDate`, `status`)
					VALUES (NULL, '$fullname', '$email', '$phash', '$conno', NULL, '$stats')";
				if($query_run = mysqli_query($con, $query)){
					echo 'Registration successful. Please Login.';
					header('location:registration.php');
				}else{
					echo 'Something went wrong';
				}
			}
	}			
}	
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>CMS | User Registration</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <script>
		function submit(){
			let name = $("#fullname").val();
			let contact = $("#contactno").val();
			let password = $("#password").val();
			let confirm = $("#confirm-password").val();

			if(name <= 5 || contact.length <=5 || password.length < 5 || confirm.length <5 || password!==confirm){
			$('#submit').prop('disabled',true);
			}else{
				$('#submit').prop('disabled',false);
			}
		}

		function userAvailability() {
			$("#loaderIcon").show();
				jQuery.ajax({
					url: "check_availability.php",
					data:'email='+$("#email").val(),
					type: "POST",
					success:function(data){
						$("#user-availability-status1").html(data);
						$("#loaderIcon").hide();
					},
					error:function (){}
				});
		}
	</script>
	<script>
			function nameVal(){
			let name = $("#fullname").val();
				if(name.length >= 5 ){
					var data = "<span style='display:none'></span>";
					$("#nameVal-status").html(data);
				}else{
					var data = "<span style='color:red'> Characters must be more than 5 .</span>";
					$("#nameVal-status").html(data);
				}
				submit();
			}

			function contactVal(){
			let contact = $("#contactno").val();
			let pattern = /^\d{10}$/;
				if(contact.match(pattern)){
					let data = "<span style='display:none'></span>";
					$("#contactVal-status").html(data);
				}else{
					let data = "<span style='color:red'> Contact number must be 10 .</span>";
					$("#contactVal-status").html(data);
				}
				submit();

			}

			function checkPassword(){
				let password = $("#password").val();
				if(password.length < 8 ){
					let data = "<span style='color:red'> Passwords must be more than 8 characters</span>";
					$("#password-status").html(data);
				}else{
				let data = "<span style='display:none'></span>";
					$("#password-status").html(data);
				}
				submit();

			}

			function matchPassword(){
				let password = $("#password").val();
				let password2 = $("#confirm-password").val();
				if( password2 === password){
					let data = "<span style='display:none'></span>";
					$("#confirm-status").html(data);
				}else{
				let data = "<span style='color:red'> Passwords don't match </span>";
					$("#confirm-status").html(data);
				}
				submit();
			}
	</script>
</head>

  <body>
	  <div id="login-page">
	  	<div class="container">
	<h3 align="center" style="color:#fff">Complaint Managent System</h3>
	<hr />
		      <form class="form-login" method="post">
		        <h2 class="form-login-heading">User Registration</h2>
		        <p style="padding-left: 1%; color: green">
		        	<?php if($msg){
						echo htmlentities($msg);
		        		}?>
		        </p>
		        <div class="login-wrap">
		         <input type="text" class="form-control" placeholder="Full Name" id="fullname" name="fullname" onBlur="nameVal()" required="required" autofocus>
				 <span id="nameVal-status" style="font-size:12px;"></span>
					<br>
		            <input type="email" class="form-control" placeholder="Email ID" id="email" onBlur="userAvailability()" name="email" required="required">
		             <span id="user-availability-status1" style="font-size:12px;"></span>
		            <br>
		            <input type="password" class="form-control" id="password" placeholder="Password" onBlur="checkPassword()" required="required" name="password"><br >
					<span id="password-status" style="font-size:12px;"></span>
					<input type="password" class="form-control" id="confirm-password" onBlur="matchPassword()" placeholder="Confirm Password" required="required" name="confirm-password"><br>
					<span id="confirm-status" style="font-size:12px;"></span>
					<br>
		             <input type="text" class="form-control" id="contactno" maxlength="10" name="contactno" onBlur="contactVal()" placeholder="Contact no" required="required" autofocus>
				 		<span id="contactVal-status" style="font-size:12px;"></span>
		            <br>
		            
		            <button class="btn btn-theme btn-block" disabled="true" type="submit" name="submit" id="submit"><i class="fa fa-user"></i> Register</button>
		            <hr>
		            
		            <div class="registration">
		                Already Registered<br/>
		                <a class="" href="index.php">
		                   Sign in
		                </a>
		            </div>
		
		        </div>
		
		      
		
		      </form>	  	
	  	
	  	</div>
	  </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/img/login-bg.jpg", {speed: 500});
    </script>


  </body>
</html>
