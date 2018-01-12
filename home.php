<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	 <link rel="stylesheet" href="css/style.css">  
<title>Website</title>
</head>



<body>


<!------------------------------------------ PHP ----------------------------------------------------------------------------------------------------------------------------------->  
 <?php 
  //Checking Session----
  
//Creating active session
session_start();
if(!isset($_SESSION['login_user'])){
   header("Location:login.php");
}

if (isset($_POST['upload'])){
	header("Location:upload.php");	
}

if (isset($_POST['report'])){
	header("Location:report.php");	
}

if (isset($_POST['change'])){
	header("Location:change.php");	
}
	
	
?>
<!------------------------------------------ /PHP ----------------------------------------------------------------------------------------------------------------------------------->  








<!------------------------------------------ HTML --------------------------------------------------------------------------------------------------------------------------------->  
 <br><br><br>
 <div class="form">		
			
	<!-- Option Menu -->
	<p align = "left" class="message">Welcome<b><font style="color:black;" size="4">
	<?php
	//login session is the user that is currently active in the session
	$login_session=$_SESSION['login_user'];
	echo $login_session;
	?>
	
	
	</font></b>
	</p><br>
	<!-- Uploading Option -->
	<form method="post">
    <button type = "submit" name = "upload" >Upload Image</button><br><br>
	</form>
    <!-- Reporting Option -->
	<form method="post">
	<button type = "submit" name = "report" >Reporting</button><br><br>
	</form>
	<!-- Change Password Option -->
	<form method="post">
	<button type = "submit" name = "change" >Change Password</button><br><br>
	</form>
	
	<!-- Logout message -->
    <p class="message">Finished? <a href="logout.php">Logout</a></p>
    </form>

	
</div>
</body>
</html>
<!------------------------------------------ /HTML --------------------------------------------------------------------------------------------------------------------------------->  