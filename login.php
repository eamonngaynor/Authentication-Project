
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Website</title>
        <link rel="stylesheet" href="css/style.css">  
</head>


<!------------------------------------------ JavaScript ----------------------------------------------------------------------------------------------------------------------------->  

<script>
//----------- Scroll function for Sign up and Login--
$('.message a').click(function(){
   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});


// Password validation in JS, now done in PHP--
/*
function passwordFunction(){
	
	alert ("Hello");
	var input = document.getElementById("password").value;
	var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;  	
	if(input.match(passw))   
	{   
	alert('Correct, try another...')  
	return true;
	}  
	else
	{
	alert("wrong");
	}
	
}
*/

</script>
<!------------------------------------------ /JavaScript --------------------------------------------------------------------------------------------------------------------------->  






















<!------------------------------------------ PHP ----------------------------------------------------------------------------------------------------------------------------------->  

<?php

//---------------Login

if (isset($_POST['login'])){	  
include("config.php");

session_start();


//Gathering inputs from form
$username=$_POST['username'];
$password=$_POST['password'];
$username = strip_tags($username);



//Assigning the username to a session
$_SESSION['login_user']=$username;
 
//Initial query on the table
$query = mysqli_query($db, "SELECT * FROM user WHERE username = '".$username."' and password = '".$password."'" );
$result = mysqli_query($db,"SELECT * FROM user WHERE username='$username' ");
$row = mysqli_fetch_array($result);	


if($row['logins']>2){
	$result = mysqli_query($db,"SELECT * FROM user WHERE username='$username' ");
	$row = mysqli_fetch_array($result);	
	$current = date('Y-m-d H:i:s', time());
	if($current < $row['lockout']){
		echo "<script type='text/javascript'>alert('Error: User locked out, please try again later')</script>";
	}
	
	else{
	 
	 $sql = "UPDATE user SET logins = 0 WHERE username='$username'";
   	 $db->query($sql);
		//----------If password and username are correct, load the home page and update login to 0.
	 if (password_verify($password,$row['hashedPassword'])){
		echo "<script type='text/javascript'>alert('Access Granted.')</script>";
		$result = mysqli_query($db,"SELECT * FROM user WHERE username='$username' ");
		$row = mysqli_fetch_array($result);	
		$sql = "UPDATE user SET logins = 0 WHERE username='$username'";
		$db->query($sql);
		echo "<script language='javascript' type='text/javascript'> location.href='home.php' </script>";	
	 }
	 //--------------------------------------------------------------------
	 
	 //----------If password is wrong, increment login attempt by 1
	 else{
		
		$result = mysqli_query($db,"SELECT * FROM user WHERE username='$username' ");
		$row = mysqli_fetch_array($result);	
		
		//if login = 0, update to 1.
		if($row['logins']==0){
			$sql = "UPDATE user SET logins = 1 WHERE username='$username'";
			$db->query($sql);
			echo "<h3 style='color:red';> ALERT: </h3>";
			echo "The username: ";
			//htmlspecialchars is used to prevent XSS from HTML parameter.
			echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
			echo " cannot be authenticated with those credentials";
			echo '<script type="text/javascript">alert("Invalid Login");</script>';
		}
		//if login = 1, update to 2.
		if($row['logins']==1){
			$sql = "UPDATE user SET logins = 2 WHERE username='$username'";
			$db->query($sql);	
			echo "<h3 style='color:red';> ALERT: </h3>";
			echo "The username: ";
			echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
			echo " cannot be authenticated with those credentials";
			echo '<script type="text/javascript">alert("Invalid Login");</script>';
		}
		//if login = 2, update to 3 and set the lockout time 5 minutes ahead of current time.
		if($row['logins']==2){
			$sql = "UPDATE user SET logins = 3 WHERE username='$username'";
			$db->query($sql);
			// This is what you need for future date from now.
			$date = date('Y-m-d H:i:s', strtotime("+5 minute"));
			$sql = "UPDATE user SET lockout = '$date' WHERE username='$username'";
			$db->query($sql);
			echo "<script type='text/javascript'>alert('Password invalid, user locked out please try again later.')</script>";
		}		
		//------------------------------------------------------------------------------
			
	 }
	}
}
else{
 //----------If password and username are correct, load the home page and update login to 0.
 if (password_verify($password,$row['hashedPassword'])){
	echo "<script type='text/javascript'>alert('Access Granted.')</script>";
	$result = mysqli_query($db,"SELECT * FROM user WHERE username='$username' ");
	$row = mysqli_fetch_array($result);	
	$sql = "UPDATE user SET logins = 0 WHERE username='$username'";
	$db->query($sql);
	echo "<script language='javascript' type='text/javascript'> location.href='home.php' </script>";	
 }
 //--------------------------------------------------------------------
 
 //----------If password is wrong, increment login attempt by 1
 else{
	
	$result = mysqli_query($db,"SELECT * FROM user WHERE username='$username' ");
	$row = mysqli_fetch_array($result);	
	
	//if login = 0, update to 1.
	if($row['logins']==0){
		$sql = "UPDATE user SET logins = 1 WHERE username='$username'";
		$db->query($sql);
		echo "<h3 style='color:red';> ALERT: </h3>";
		echo "The username: ";
		echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
		echo " cannot be authenticated with those credentials";
		echo '<script type="text/javascript">alert("Invalid Login");</script>';
	}
	//if login = 1, update to 2.
	if($row['logins']==1){
		$sql = "UPDATE user SET logins = 2 WHERE username='$username'";
		$db->query($sql);	
		echo "<h3 style='color:red';> ALERT: </h3>";
		echo "The username: ";
		echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
		echo " cannot be authenticated with those credentials";
		echo '<script type="text/javascript">alert("Invalid Login");</script>';
	}
	//if login = 2, update to 3 and set the lockout time 5 minutes ahead of current time.
	if($row['logins']==2){
		$sql = "UPDATE user SET logins = 3 WHERE username='$username'";
		$db->query($sql);
		// This is what you need for future date from now.
		$date = date('Y-m-d H:i:s', strtotime("+5 minute"));
		$sql = "UPDATE user SET lockout = '$date' WHERE username='$username'";
		$db->query($sql);
		echo "<script type='text/javascript'>alert('Password invalid, user locked out please try again later.')</script>";
	}
	//------------------------------------------------------------------------------
		
 }
}
}







//---------------Register
if (isset($_POST['register'])){

include("config.php");
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//Taking input from POST form 
$username=$_POST['uname'];
$username = strip_tags($username);
$password=$_POST['pword'];
$email=$_POST['email'];
$password2=$_POST['pword2'];

$result = mysqli_query($db,"SELECT * FROM user WHERE username='$username' ");

if($result && mysqli_num_rows($result)>0){ //Checking to see if username is already taken
  echo "<script type='text/javascript'>alert('Username is already taken, user creation unsuccessful')</script>";
}

else{
	//Checking if password is equal to the re-entered password 
	if($password==$password2){
		$pattern = "/^.*(?=.{7,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/";   //Password Pattern.
		$passwordresult = preg_match($pattern,$password); //Checking password entered against pattern

		if($passwordresult == 0){	//if the password is 0 it does not meet requirements (did not match pattern)
		echo "<script type='text/javascript'>alert('Password does not meet requirements')</script>";
		}

		else{ //if password is ok, proceed and insert the user ot the table
		$password = password_hash($password, PASSWORD_DEFAULT); 
		$sql = "INSERT INTO user (username, hashedPassword, email) VALUES ('$username', '$password', '$email')"; //Insert query

			if ($conn->query($sql) === TRUE){ //checking connection to the table/db
				echo "<script type='text/javascript'>alert('User created successfully. Please Log in.')</script>";
			} 
			
			else{
			echo "Error: " . $sql . "<br>" . $conn->error;} //connect_error message
		}		
	}
	else{
		echo "<script type='text/javascript'>alert('Passwords do not match, user not created')</script>";	//if the passwords did not match
		}
	$conn->close();	
 } 
}

?>
<!------------------------------------------ /PHP ------------------------------------------------------------------------------------------------------------------------------->  













<!------------------------------------------ HTML --------------------------------------------------------------------------------------------------------------------------------->  


<!-- Page BODY -->
<body>
  <div class="login-page">
  <div class="form">		
	<!-- Registration -->
    <form name = "register" id = "register" method ="post" class="register-form" >
      <input name = "uname" type="text" placeholder="Username"   required />							
	  <input name = "email" type="email" placeholder="E-mail address"   />
      <input name = "pword" type="password" placeholder="Enter your password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
	  title = "Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required /> <!-- Pattern for password, but aslo validated in PHP -->
	  
      <input name = "pword2" type="password" placeholder="Re-enter your password"  />	
      <button name = "register" type = "submit" >create</button> 
	  <!-- Login message -->
      <p class="message">Already registered? <a href="#">Sign In</a></p>
    </form>	
		
			
	<!-- Log in -->
    <form  method="POST" class="login-form" >
      <input type="text" name ="username" placeholder="Username" required />
      <input id = "password" type="password" name ="password" placeholder="Password" required />
      <button name = "login" type = "submit">login</button>
	  <!-- Register message -->
      <p class="message">Not registered? <a href="#">Create an account</a></p>
    </form>

	
  </div>
</div>
	
<form action="tableCreate.php">
    <input align = "center" type= "submit" value="CREATE DATABASE" /> Please click this button FIRST to create a database for login use <---------------------------- (DATABASE: eamonngaynor TABLE: user)
</form>
	<!--Facilitates the scroll for Registration form -->	  
	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<!--Facilitates the JavaScript file -->
	<script type="text/javascript" src="js/index.js"></script>

</body>
</html>

<!------------------------------------------ /HTML --------------------------------------------------------------------------------------------------------------------------------->  