<?php
session_start();
$pageTitle='Members';
  if (isset($_SESSION['Username'])) { //debut if globale
  	include 'init.php';	//start code members
  	$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';// start manage

    	if($do == 'Manage'){
      $stmt=$con->prepare("SELECT * FROM users WHERE GroupID !=1");
      $stmt->execute();
      $row=$stmt->fetchAll();
      ?>

        <h1 class="text-center">Manage Member</h1>
        <div class="container">
            <div class="table-responsive">
              <table class="main-table table text-center table-bordered">
                <tr>
                  <td>#ID</td>
                  <td>Username</td>
                  <td>Email</td>
                  <td>Full name</td>
                  <td>Registerd Date</td>
                  <td>Control</td>
                </tr>
                <?php
                 foreach ($row as $row) {
                  echo "<tr>";
                      echo "<td>" .$row['userID']."</td>";
                      echo "<td>" .$row['Username']."</td>";
                      echo "<td>" .$row['Email']."</td>";
                      echo "<td>" .$row['FullName']."</td>";
                      echo "<td></td>";
                      echo "<td>
                            <a href='members.php?do=Edit&userid=".$row['userID']."' class='btn btn-success'>Edit</a>
                            <a href='#' class='btn btn-danger'>Delete</a>
                            </td>";
                  echo "</tr>";
                 }
                ?>
               <tr>
              </table>
            </div>
         <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>Add New Member</a>
        </div>
       <?php  } elseif ($do == 'Add') { ?>
                    <h1 class="text-center">Edit New Member</h1>
                    <div class="container">
                        <form class="form-horizontal" action="?do=Insert" method="post">
                          <!-- start username -->
                          <div class="form-group">
                            <label class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10 col-md-6">
                            <input type="text" name="Username" class="form-control" autocomplete="off"  required="required" placeholder="username"/>
                            </div>
                          </div>
                          <!-- start password -->
                          <div class="form-group">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10 col-md-6">
                            <input type="password" name="password" class="password form-control" autocomplete="new-password" required="required" placeholder="password"/>
                            <i class="show-pass fa fa-eye fa-2x"></i>
                            </div>
                          </div>
                            <!-- start email -->
                          <div class="form-group">
                            <label class="col-sm-2 control-label">email</label>
                            <div class="col-sm-10 col-md-6">
                            <input type="email" name="email" class="form-control" required="required" placeholder="emial"/>
                            </div>
                          </div>
                        <!-- start fullname -->
                          <div class="form-group">
                            <label class="col-sm-2 control-label">Full Name</label>
                            <div class="col-sm-10 col-md-6">
                            <input type="text" name="fullname" class="form-control"  required="required" placeholder="Name"/>
                            </div>
                          </div>
                            <!-- start submit -->
                          <div class="form-group">
                              <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Add Member" class="btn btn-primary btn-lg"/>
                            </div>
                          </div>
                          <!-- fin submit -->
                        </form>
                    </div>
              <?php //fin A
          //start insert
        }elseif ($do == 'Insert') {
             if ($_SERVER['REQUEST_METHOD']=='POST') {
              echo "<h1 class='text-center'>Update Member</h1>";
              echo "<div class='container'>";
                        $user=$_POST['Username'];
                        $pass=$_POST['password'];
                        $email=$_POST['email'];
                        $name=$_POST['fullname'];
                        $hashpass=sha1($_POST['password']);
                        $formError=array();
                        if (strlen($user)<4){
                          $formError[]='Username Cant Be less than <strong>4 character</strong>';
                        }
                        if (strlen($user)>20){
                          $formError[]='Username Cant Be More than 20 character';
                        }
                        if (empty($user)){
                          $formError[]='Username Cant Be Empty';
                        }
                        if (empty($pass)){
                          $formError[]='Password Cant Be Empty';
                        }
                        if (empty($email)){
                          $formError[]='Username Cant Be Email';
                        }
                        if (empty($name)){
                          $formError[]='>Username Cant Be Name';
                        }
                        // BOUCLE POUR TEST error
                        foreach ($formError as $error) {
                          echo '<div class="alert alert-danger">'.$error.'</div>';
                        }//FIN BOUCLE

                        if (Empty($formError)) {
                        //insert the database
                        $stmt=$con->prepare("INSERT INTO
                                          users(Username, Password, Email, FullName)
                                          VALUES(:zusername, :zpassword, :zemail, :zfullname)");
                        $stmt->execute(array(
                          'zusername'=>$user,
                          'zpassword'=>$hashpass,
                          'zemail'   =>$email,
                          'zfullname'=>$name,
                        ));
                        echo "<div class='alert alert-success'>".$stmt->rowCount().'Record inserted </div>';
                         }
                        } else {
                        echo "sorry";
                        }
                        echo "</div>";
                        //fin insert
                		// start edit
  	}elseif ($do == 'Edit') {
  	$userID= isset($_GET['userid'])&& is_numeric($_GET['userid'])? intval($_GET['userid']):0;
   // check if the user exist in database
   $stmt=$con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
   $stmt->execute(array($userID));
   $row = $stmt ->fetch();
   $count = $stmt->rowCount();
   // if count >0 this mean the database
             if ($stmt ->rowCount()>0){ ?>
            		<h1 class="text-center">Edit Member</h1>
            		<div class="container">
                    <form class="form-horizontal" action="?do=Update" method="post">
                      <input type="hidden" name="userid" value="<?php echo $userID?>"/>
                    <!-- start username -->
                      <div class="form-group">
                      	<label class="col-sm-2 control-label">Username</label>
                      	<div class="col-sm-10 col-md-6">
                      	<input type="text" name="Username" class="form-control" autocomplete="off" value="<?php echo $row['Username']?>" required="required"/>
                      	</div>
                      </div>
                    	<!-- fin username -->
                    <!-- start password -->
                      <div class="form-group">
                      	<label class="col-sm-2 control-label">Password</label>
                      	<div class="col-sm-10 col-md-6">
                      	<input type="hidden" name="Oldpassword" value="<?php echo $row['Password']?>"/>
                        <input type="password" name="newpassword" class="form-control" autocomplete="new-password" />
                      	</div>
                      </div>
                    	<!-- fin password -->
                    	<!-- start email -->
                      <div class="form-group">
                      	<label class="col-sm-2 control-label">email</label>
                      	<div class="col-sm-10 col-md-6">
                      	<input type="email" name="email" class="form-control" value="<?php echo $row['Email']?>" required="required"/>
                      	</div>
                      </div>
                    	<!-- fin email -->
                    	<!-- start fullname -->
                      <div class="form-group">
                      	<label class="col-sm-2 control-label">Full Name</label>
                      	<div class="col-sm-10 col-md-6">
                      	<input type="text" name="fullname" class="form-control" value="<?php echo $row['FullName']?>" required="required"/>
                      	</div>
                      </div>
                    	<!-- fin fullname -->
                    		<!-- start submit -->
                      <div class="form-group">
                         	<div class="col-sm-offset-2 col-sm-10">
                      	<input type="submit" value="Save" class="btn btn-primary btn-lg"/>
                      	</div>
                      </div>
                    	<!-- fin submit -->
                    </form>
            		</div>
            	<?php }
                 else{
                   echo "Theres No Such ID";
                    }
              //START PAGE Update
              }elseif ($do=='Update') {
                echo "<h1 class='text-center'>Update Member</h1>";
                echo "<div class='container'>";
                if ($_SERVER['REQUEST_METHOD']=='POST') {
                $id=$_POST['userid'];
                $user=$_POST['Username'];
                $email=$_POST['email'];
                $name=$_POST['fullname'];
                //passeword trader
                $pass=empty($_POST['newpassword']) ? $_POST['Oldpassword']: sha1($_POST['newpassword']);
                //Validate the Form
                $formError=array();
                if (strlen($user)<4){
                  $formError[]='Username Cant Be less than <strong>4 character</strong>';
                }
                if (strlen($user)>20){
                  $formError[]='Username Cant Be More than 20 character';
                }
                if (empty($user)){
                  $formError[]='Username Cant Be Empty';
                }
                if (empty($email)){
                  $formError[]='Username Cant Be Email';
                }
                if (empty($name)){
                  $formError[]='>Username Cant Be Name';
                }
                // BOUCLE POUR TEST error
                foreach ($formError as $error) {
                  echo '<div class="alert alert-danger">'.$error.'</div>';
                }//FIN BOUCLE

                if (Empty($formError)) {
                //update the database
                $stmt= $con->prepare("UPDATE users SET Username=?, Email= ?, FullName=?, Password=? WHERE UserID =?");
                $stmt->execute(array($user, $email, $name, $pass, $id));
                echo $stmt->rowCount().'Record Updated';
                 }
                } else {
                echo "sorry";
                }
                echo "</div>";
                }
    	//end code members
  	include $tp1.'footer.php';
  } else{// fin if globale
  	header('Location: index.php');

  	exit();
  }
