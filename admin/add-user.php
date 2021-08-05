<?php include "header.php"; ?>
<?php
if($_SESSION['user_role'] == 0)
{
header('location:post.php');
}
if(isset($_POST['save']))
{
//Include Database
require '../common/db_inc.php';
//page variable
$message = null;
//Getting Details
$firs_tname = $_POST['fname'];  
$last_name  = $_POST['lname'];
$user_name = $_POST['user'];
$password = sha1($_POST['password']);
$role = $_POST['role'];
//Save Data
$qry = "INSERT INTO `user`(first_name,last_name,username,password,role) VALUES (? , ? , ? , ? , ?)";
$res = $conn->prepare($qry);
$res->bind_param('ssssi',$firs_tname,$last_name,$user_name,$password,$role);
if($res->execute())
{
  $message = true;
}
else
{
 $message = false;
}
}
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <h1 class="admin-heading">Add User</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start -->
                  <form  action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST" autocomplete="off">
                       <?php
                        if(isset($_POST['save']))
                        {
                            if($message == true)
                            {
                                echo '<div class="alert alert-success">
                                      Account Created
                                     </div>';
                            }
                            elseif($message == false)
                            {
                                echo '<div class="alert alert-danger">
                                     Account Creation Failed
                                    </div>';
                            }
                        }
                       ?>
                      <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                      </div>
                          <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="user" class="form-control" placeholder="Username" required>
                      </div>

                      <div class="form-group">
                          <label>Password</label>
                          <input type="password" name="password" class="form-control" placeholder="Password" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" >
                              <option value="0">Normal User</option>
                              <option value="1">Admin</option>
                          </select>
                      </div>
                      <input type="submit"  name="save" class="btn btn-primary" value="Save" required />
                  </form>
                   <!-- Form End-->
               </div>
           </div>
       </div>
   </div>
<?php include "footer.php"; ?>
