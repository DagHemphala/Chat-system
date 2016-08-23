<?php
	session_start();
	
	$checkphp = 'Clear';
	
	// resetar sessioner
	if(isset($_GET['logout'])) {
    unset($_SESSION['error_msg']);
	unset($_SESSION['username']);
	unset($_SESSION['id']);
	header('location:.');}
	
	// laddar databas
	$servernamn = "localhost";
	$username = "root";
	$password = "";
	$db = "virtuellt_tangentbord";
		
	$link = mysqli_connect($servernamn,$username,$password,$db);
		if (!$link)
		{
			echo 'Connection failed!';
			exit();	
		}
			
	echo ('<br>');
	
	
	
	//register skickas till DB
	if(isset($_REQUEST['register']) && $_REQUEST['register']=='upload')
	{
		
		//sätter in email
		$email = mysqli_real_escape_string($link, $_REQUEST['email']);
		
		$sql = "INSERT INTO email SET 
				email='$email'";
		
		mysqli_query($link, $sql);	

		$id = mysqli_insert_id($link);
	

		//sätter in password
		$pass = mysqli_real_escape_string($link, $_REQUEST['password2']);
		
		$sql = "INSERT INTO password SET 
				password='$pass',
				emailid='$id'";
				
		mysqli_query($link, $sql);	

		$id = mysqli_insert_id($link);	
		
	
		//sätter in username
		$namn = mysqli_real_escape_string($link, $_REQUEST['username2']);
		
		$passid = mysqli_real_escape_string($link, $id);
		
		$sql = "INSERT INTO username SET 
				username='$namn',
				passid='$id'";
		mysqli_query($link, $sql);			
	
		$id = mysqli_insert_id($link);
		
	
		//laddar upp bild temporär bild		
		$sql = "INSERT INTO profile_img SET 
			imgsrc='images/profile_img/default-user-image.png',
			alt='default-user-image.png',
			userid= '$id',
			datum = NOW()";

		mysqli_query($link, $sql);
		
	}
	
	//hämtar id för användaren
	if (isset($_SESSION['username'])){
		$test = $_SESSION['username'];
		$sql="SELECT id FROM username
				WHERE username = '$test'";
		$result = mysqli_query($link,$sql);
		$row = mysqli_fetch_assoc($result);
		$_SESSION['id'] = $row['id'];
		
		$userid = $_SESSION['id'];
	}
	
	if(isset($_REQUEST['change']) && $_REQUEST['change']=='upload')
	{
		//ändra bild
		if (preg_match('/^image\/(x-)?png$/i', $_FILES['upload']['type']))
					$ext = '.png';
				
		else if (preg_match('/^image\/p?jpeg$/i', $_FILES['upload']['type']))
			$ext = '.jpeg';
		
		else if (preg_match('/^image\/gif$/i', $_FILES['upload']['type']))
			$ext = '.gif';
	
		else
			$ext = 'unknown';
		
		$filename = 'images/' . time() .$ext;
		$desc = $_FILES['upload']['name'];
		
		if ($ext != 'unknown') 
		{
			!copy($_FILES['upload']['tmp_name'], $filename);
			$sql = "UPDATE profile_img SET 
				imgsrc = '$filename',
				alt = '$desc',
				datum = NOW()
				WHERE userid = '$userid'";
	
			mysqli_query($link, $sql);	
		}
	}
	
	//hämtar data om användaren
	$sql='SELECT username, email, password, imgsrc, profile_img.userid, username.id
	 	FROM email
		INNER JOIN password
		ON emailid = email.id
		INNER JOIN username 
		ON passid = password.id
		INNER JOIN profile_img
		ON userid = username.id';
		
	$result = mysqli_query($link,$sql);
	while($row = mysqli_fetch_assoc($result)) {
		
		$info[]=array('email'=>$row['email'], 'user'=>$row['username'], 'pass'=>$row['password'], 'src'=>$row['imgsrc'], 'profileimgid'=>$row['userid'],'usernameid'=>$row['id']);		
		
		if (isset($_REQUEST['username'])){
			$user = $_REQUEST['username'];
			$pass = $_REQUEST['password'];
			
			if ($row['username']==$user and $row['password']==$pass) {
				$_SESSION['username'] = $user;	
				unset($_SESSION['error_msg']);
				
			}		
			else if (!isset($_SESSION['username'])){
				$_SESSION['error_msg'] = 'Error, wrong username or password';
					
				}
			else if (isset($_SESSION['username']))
				unset($_SESSION['error_msg']);
		}
	}
	
	
	//skickar meddelande
	if(isset($_REQUEST['message']) && $_REQUEST['message']=='upload')
	{
		
		function MakeUrls($str)
		{
		$find=array('`((?:https?|ftp)://\S+[[:alnum:]]/?)`si','`((?<!//)(www\.\S+[[:alnum:]]/?))`si');
		
		$replace=array('<a href="$1" target="_blank">$1</a>','<a href="http://$1"    target="_blank">$1</a>');
		
		return preg_replace($find,$replace,$str);
		}
		//Function testing
		$str = mysqli_real_escape_string($link, $_REQUEST['input']);
		$str = htmlspecialchars($str);
		$msg = MakeUrls($str);

		$sql = "INSERT INTO message SET 
				messages = '$msg',
				usernameid = '$userid'";
				
		if (strlen($msg)>0)
		{
		mysqli_query($link, $sql);
		}
	}
	
	
	//hämtar messages från DB
	$sql='SELECT messages, usernameid 
	 	FROM message';
		
	$result = mysqli_query($link,$sql);
	while($row = mysqli_fetch_assoc($result)) {
		
		$message[]=array('message'=>$row['messages'], 'usernameid'=>$row['usernameid']);		
				
	}
	
	
	if (isset($_REQUEST['lang']))
	{	
		if ($_REQUEST['lang']=='sv')
		{
		 	$_SESSION['lang'] = 'sv';
		}
		if ($_REQUEST['lang']=='en')
		{
		 	$_SESSION['lang'] = 'en';	
		}
	}
	
	//dynamiskt
	/*
	file_get_contents;
	file_put_contents;
	file_exists:
	copy;
	unlink;*/
	
	
	include ('htmlkod.html.php');
?>