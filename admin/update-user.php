<?php include "header.php"; ?>
<?php
if($_SESSION['user_role'] == 0)
{
header('location:post.php');
}
if(isset($_GET['user_id']))
{
//Connecting with database
require '../common/db_inc.php'; 
//message 
$message = null;
//Getting id
$id = $_GET['user_id'];
//Query to Show Details
$qry = 'SELECT  first_name , last_name , username , role FROM `user` WHERE user_id =  ? ';
$res = $conn->prepare($qry);
$res->bind_param('i', $id);
$res->execute();
$data_details = $res->get_result();
$data = $data_details->fetch_assoc();
//Getting Updated Data
@$new_id = $_POST['user_id'];
@$first_name = $_POST['f_name'];
@$last_name = $_POST['l_name'];
@$username = $_POST['username'];
@$role = $_POST['role'];
//Query For Update Data
$qry_update = 'UPDATE `user` SET first_name = ? , last_name = ? , username = ? , role = ? WHERE user_id = ?';
$res_2  = $conn->prepare($qry_update);
$res_2->bind_param('sssii',$first_name,$last_name,$username,$role,$new_id);
if($res_2->execute())
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
                  <h1 class="admin-heading">Modify User Details</h1>
              </div>
              <div class="col-md-offset-4 col-md-4">
                  <!-- Form Start -->
                  <form  action="" method ="POST">
                  <?php
                        if(isset($_POST['submit']))
                        {
                            if($message == true)
                            {
                                echo '<div class="alert alert-success">
                                      Update Successfully
                                     </div>';
                            }
                            elseif($message == false)
                            {
                                echo '<div class="alert alert-danger">
                                     Update Unsuccessfull
                                    </div>';
                            }
                        }
                       ?>
                      <div class="form-group">
                          <input type="hidden" name="user_id"  class="form-control" value="<?php echo $id ?>" placeholder="" >
                      </div>
                          <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="f_name" class="form-control" value="<?php echo $data['first_name']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="l_name" class="form-control" value="<?php echo $data['last_name']; ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="username" class="form-control" value="<?php echo $data['username'] ?>" placeholder="" required>
                      </div>
                      <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" value="<?php echo $data['role']; ?>">
                              <?php
                               if($data['role'] == 1){
                               echo '<option value="1" selected>Admin</option>';
                               echo '<option value="0">Normal User</option>';   
                               }
                               else{
                               echo '<option value="0" selected>Normal User</option>';
                               echo '<option value="1" >Admin</option>';
                               }
                              ?>
                          </select>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Update" required />
                  </form>
                  <!-- /Form -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
