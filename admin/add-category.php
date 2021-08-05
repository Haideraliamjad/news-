<?php include "header.php"; ?>
<?php
if($_SESSION['user_role'] == 0)
{
header('location:post.php');
}
if(isset($_POST['save']))
{
//Connection with data base
require '../common/db_inc.php';
//message variable
$message = null;
//Getting Details
$c_name = $_POST['cat'];
$qry = 'INSERT INTO `category`(category_name) VALUES (?)';
$res = $conn->prepare($qry);
$res->bind_param('s',$c_name);
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
                  <h1 class="admin-heading">Add New Category</h1>
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start -->
                  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
                  <?php
                        if(isset($_POST['save']))
                        {
                            if($message == true)
                            {
                                echo '<div class="alert alert-success">
                                      Add Successfully
                                     </div>';
                            }
                            elseif($message == false)
                            {
                                echo '<div class="alert alert-danger">
                                     Category Created Failed
                                    </div>';
                            }
                        }
                       ?>
                      <div class="form-group">
                          <label>Category Name</label>
                          <input type="text" name="cat" class="form-control" placeholder="Category Name" required>
                      </div>
                      <input type="submit" name="save" class="btn btn-primary" value="Save" required />
                  </form>
                  <!-- /Form End -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
