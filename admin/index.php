<?php
  session_start();
  $noNavbar='';
  $pageTitle='Login';
  if (isset($_SESSION['Username'])) {
  	header('Location: dashboard.php');  // Redirect To Dashboard Page
  }
include 'init.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
   $username =$_POST['user'];
   $password =$_POST['pass'];
   $hashedPass=sha1($password);
   // check if the user exist in database
   $stmt=$con->prepare("SELECT userID, Username, Password 
   	                    FROM users 
   	                    WHERE Username = ? AND Password = ? AND GroupID=1 LIMIT 1");
   $stmt->execute(array($username, $hashedPass));
   $row = $stmt ->fetch();
   $count = $stmt->rowCount();
   // if count >0 this mean the database
   if ($count > 0){
	   	$_SESSION['Username']= $username;// Register Session Name
	   	$_SESSION['ID'] = $row['userID']; //Register Session ID
	   	header('Location: dashboard.php');  // Redirect To Dashboard Page
	   	exit();
   }
   }
?>
	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
	<h4 class="text-center">Admin Login</h4>
		<input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off" />
		<input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
		<input class="btn btn-primary btn-block" type="submit" value="login">	

	</form>
<?php include $tp1.'footer.php';  ?>