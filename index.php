<?php
  ob_start();
  session_start();
  require_once 'dbconnect.php';
  
  // it will never let you open index(login) page if session is set
  if ( isset($_SESSION['user'])!="" ) {
    header("Location: home.php");
    exit;
  }

  $error = false;
  
  if( isset($_POST['btn-login']) ) {  
    
    // prevent sql injections/ clear user invalid inputs
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);
    
    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    // prevent sql injections / clear user invalid inputs
    
    if(empty($email)){
      $error = true;
      $emailError = "Please enter your email address.";
    } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
      $error = true;
      $emailError = "Please enter valid email address.";
    }
    
    if(empty($pass)){
      $error = true;
      $passError = "Please enter your password.";
    }
    
    // if there's no error, continue to login
    if (!$error) {
      
      $password = hash('sha256', $pass); // password hashing using SHA256
    
      $res=mysql_query("SELECT userId, userName, userPass FROM users WHERE userEmail='$email'");
      $row=mysql_fetch_array($res);
      $count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row
      
      if( $count == 1 && $row['userPass']==$password ) {
        $_SESSION['user'] = $row['userId'];
        header("Location: home.php");
      } else {
        $errMSG = "Incorrect Credentials, Try again...";
      }
        
    }
    
  }
?>

<!DOCTYPE html>
<html>
<title>The Vine</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pattaya">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.typeit/4.3.0/typeit.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="main.css">
<body>

<!-- Header -->
<div class="bgimg w3-display-container w3-animate-opacity w3-text-white">
	<div class="w3-display-topleft w3-padding-large w3-xlarge">
    	<a href="index.php" class="logo">the vine</a>
	</div>
  <!-- Login Button -->
	<div class="w3-display-topright w3-padding-large w3-xlarge">
		<a id="login">login</a>
	</div>
  <!-- Clock -->
  <div class="w3-display-middle clock">
    <h1 class="w3-jumbo w3-animate-top w3-layout-cell" id="hours">12</h1>
    <h1 class="w3-jumbo w3-animate-top w3-layout-cell">:</h1>
    <h1 class="w3-jumbo w3-animate-top w3-layout-cell" id="minutes">00</h1>
    <h1 class="w3-jumbo w3-animate-top w3-layout-cell">:</h1>
    <h1 class="w3-jumbo w3-animate-top w3-layout-cell" id="seconds">00</h1>
    <hr class="w3-border-grey" style="margin:auto;width:40%">
    <p class="w3-large w3-center" id="timer">35 days left</p>
  </div>
  <!-- Login Form -->
  <div class="w3-display-middle login-screen">
  	<div class="w3-center" style="padding:50px 0">
		<div class="logo">login</div>
		<!-- Main Form -->
		<div class="login-form-1">
			<form id="login-form" class="w3-left" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
				<div class="login-form-main-message"></div>
				<div class="main-login-form">
					<div class="login-group">
						<div class="form-group">
            <?php
            if ( isset($errMSG) ) {
              
              ?>
              <div class="form-group">
                    <div class="alert alert-danger">
              <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                      </div>
                    </div>
                      <?php
            }
            ?>
							<label for="email" class="sr-only">Email</label>
							<input type="email" class="form-control" id="lg_username" name="email" placeholder="email" value="<?php echo $email; ?>" maxlength="40"/>
						</div>
            <span class="text-danger"><?php echo $emailError; ?></span>
						<div class="form-group">
							<label for="pass" class="sr-only">Password</label>
							<input type="password" class="form-control" id="lg_password" name="pass" placeholder="password" maxlength="15"/>
						</div>
            <span class="text-danger"><?php echo $passError; ?></span>
						<div class="form-group login-group-checkbox remember">
							<input type="checkbox" id="lg_remember" name="lg_remember">
							<label for="lg_remember">remember</label>
						</div>
					</div>
					<button type="submit" class="login-button" name="btn-login"><i class="fa fa-chevron-right"></i></button>
				</div>
				<!--<div class="etc-login-form">
					<p>forgot your password? <a id="forgot">click here</a></p>
					<p>new user? <a id="new">create new account</a></p>
				</div>-->
			</form>
		</div>
		<!-- end:Main Form -->
	</div>
  </div>
  <div class="w3-display-middle register-screen">
  	<div class="w3-center" style="padding:50px 0">
		<div class="logo">register</div>
		<!-- Main Form -->
		<div class="login-form-1">
			<form id="register-form" class="text-left">
				<div class="login-form-main-message"></div>
				<div class="main-login-form">
					<div class="login-group">
						<div class="form-group">
							<label for="reg_username" class="sr-only">Email address</label>
							<input type="text" class="form-control" id="reg_username" name="reg_username" placeholder="username">
						</div>
						<div class="form-group">
							<label for="reg_password" class="sr-only">Password</label>
							<input type="password" class="form-control" id="reg_password" name="reg_password" placeholder="password">
						</div>
						<div class="form-group">
							<label for="reg_password_confirm" class="sr-only">Password Confirm</label>
							<input type="password" class="form-control" id="reg_password_confirm" name="reg_password_confirm" placeholder="confirm password">
						</div>
						
						<div class="form-group">
							<label for="reg_email" class="sr-only">Email</label>
							<input type="text" class="form-control" id="reg_email" name="reg_email" placeholder="email">
						</div>
						<div class="form-group">
							<label for="reg_fullname" class="sr-only">Full Name</label>
							<input type="text" class="form-control" id="reg_fullname" name="reg_fullname" placeholder="full name">
						</div>
						
						<div class="form-group login-group-checkbox">
							<input type="radio" class="" name="reg_gender" id="male" placeholder="username">
							<label for="male">male</label>
							
							<input type="radio" class="" name="reg_gender" id="female" placeholder="username">
							<label for="female">female</label>
						</div>
						
						<div class="form-group login-group-checkbox">
							<input type="checkbox" class="" id="reg_agree" name="reg_agree">
							<label for="reg_agree">i agree with <a href="#">terms</a></label>
						</div>
					</div>
					<button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
				</div>
				<div class="etc-login-form">
					<p>already have an account? <a id="back-to-login">login here</a></p>
				</div>
			</form>
		</div>
		<!-- end:Main Form -->
	</div>
  </div>
  <div class="w3-display-middle forgot-screen">
  	<div class="w3-center" style="padding:50px 0">
		<div class="logo">forgot password</div>
			<div class="login-form-1">
				<form id="forgot-password-form" class="text-left">
					<div class="etc-login-form">
						<p>Please contact one of the admins on our Steam group to have your password reset to a default password.</p>
					</div>
				</form>
			</div>
	  	</div>
  	</div>
  <div class="w3-display-bottomleft w3-padding-large">
    <p>&copy;2017 JP Tyndall</p>
  </div>
</div>

</body>

<footer>
	<script>
	$(document).ready(function(){
	    $("#login").click(function(){
	        $(".default").fadeOut();
	        $(".login-screen").fadeIn();
	    });
	    $("#new").click(function(){
	        $(".login-screen").fadeOut();
	        $(".register-screen").fadeIn();
	    });
	    $("#forgot").click(function(){
	        $(".login-screen").fadeOut();
	        $(".forgot-screen").fadeIn();
	    });
	    $("#back-to-login").click(function(){
	        $(".register-screen").fadeOut();
	        $(".login-screen").fadeIn();
	    });
	});
  </script>
  <script>
    function addHexColor(c1, c2) {
      var hexStr = (parseInt(c1, 16) + parseInt(c2, 16)).toString(16);
    while (hexStr.length < 6) { hexStr = '0' + hexStr; }
    return hexStr;
    }

    function changeBackground(color) {
      document.body.style.background = color;
    }

    function pleaseWork() {
      document.getElementById("#login").innerHTML = addHexColor("eeeeee","111111");

      var q = setTimeout(pleaseWork, 1000);
    }
    

    //currentHex = document.body.style.background;
    //setInterval(changeBackground(addHexColor(currentHex, 111111))), 1000;
  </script>
  <script>
    var openDate = new Date("April 15, 2017 16:00:00");
    var date = new Date();
    var openDays = (openDate.getTime() / (1000*60*60*24));
    var currentDays = (date.getTime() / (1000*60*60*24));
    var days = Math.round(openDays - currentDays);
    document.getElementById("timer").innerHTML = days + " days till <br> next event";
  </script>
  <script>
  	function writeTime() {
  		var today = new Date();
      var h;
      if(today.getHours() > 12) {
        h = today.getHours() - 12;
      }
	    else {
        h = today.getHours();
      }
	    var m = today.getMinutes();
	    var s = today.getSeconds();
	    m = checkTime(m);
    	s = checkTime(s);
	    document.getElementById("hours").innerHTML = h +"";
	    document.getElementById("minutes").innerHTML = m;
	    document.getElementById("seconds").innerHTML = s;
  	}
  	function checkTime(i) {
    if (i < 10) {
    	i = "0" + i
    };
    return i;
	}
  	var t = setInterval(writeTime, 1000);
  </script>
  <script>
  	(function($) {
    "use strict";
	
	// Options for Message
	//----------------------------------------------
  var options = {
	  'btn-loading': '<i class="fa fa-spinner fa-pulse"></i>',
	  'btn-success': '<i class="fa fa-check"></i>',
	  'btn-error': '<i class="fa fa-remove"></i>',
	  'msg-success': 'All Good! Redirecting...',
	  'msg-error': 'Wrong login credentials!',
	  'useAJAX': false,
  };

	
	// Loading
	//----------------------------------------------
  function remove_loading($form)
  {
  	$form.find('[type=submit]').removeClass('error success');
  	$form.find('.login-form-main-message').removeClass('show error success').html('');
  }

  function form_loading($form)
  {
    $form.find('[type=submit]').addClass('clicked').html(options['btn-loading']);
  }
  
  function form_success($form)
  {
	  $form.find('[type=submit]').addClass('success').html(options['btn-success']);
	  $form.find('.login-form-main-message').addClass('show success').html(options['msg-success']);
  }

  function form_failed($form)
  {
  	$form.find('[type=submit]').addClass('error').html(options['btn-error']);
  	$form.find('.login-form-main-message').addClass('show error').html(options['msg-error']);
  }
	
})(jQuery);
  </script>
</footer>

</html>
<?php ob_end_flush(); ?>