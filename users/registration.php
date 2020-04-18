<?php
include('includes/config.php');
error_reporting(0);
if(isset($_POST['submit']))
{
	$fullname=$_POST['fullname'];
	$email=$_POST['email'];
	// $password=md5($_POST['password']);
	$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
	$contactno=$_POST['contactno'];
	$status=1;
	$query=mysqli_query($con,"insert into users(fullName,userEmail,password,contactNo,status) values('$fullname','$email','$password','$contactno','$status')");
	$msg="Registration successfull. Now You can login !";
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
			let contact = $("#contact").val();
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
			let contact = $("#contact").val();
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
				if(password.length < 5 ){
					let data = "<span style='color:red'> Passwords must be more than 5 characters</span>";
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
		             <input type="text" class="form-control" id="contact" maxlength="10" name="contactno" onBlur="contactVal()" placeholder="Contact no" required="required" autofocus>
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
