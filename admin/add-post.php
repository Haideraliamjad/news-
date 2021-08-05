<?php include "header.php"; ?>
<?php
//login Code
if($_SESSION['login'] != true)
{
header('location:index.php');
}
//Include Database
require '../common/db_inc.php';
//Query for fetching category
$qry = 'SELECT category_id , category_name FROM `category` ';
$res = $conn->query($qry);
if(isset($_POST['submit']))
{
//Variable for message
$message = null;
//Getting Data
$user_role = $_SESSION['user_role'];
$date = date("d-m-Y");
$post_title = $_POST['post_title'];
$post_desc = $_POST['postdesc'];
$post_cat = trim($_POST['category']);
$file_name = $_FILES['fileToUpload']['name'];
//File Uploading Code
$file_exe = pathinfo($file_name,PATHINFO_EXTENSION);
$req_exe = ['jpg','png','jpeg','gif'];
if(in_array($file_exe,$req_exe))
{
  $file_name = rand('111111111','999999999') . "." . $file_exe;
  $destination = "upload/" . $file_name;
  move_uploaded_file($_FILES['fileToUpload']['tmp_name'],$destination);
  $qry1 = "INSERT INTO `post`(title,description,category,post_date,author,post_img) VALUES (?,?,?,?,?,?)";
  $res1 = $conn->prepare($qry1);
  $res1->bind_param('ssssis',$post_title,$post_desc,$post_cat, $date , $user_role , $destination);
  $res1->execute();
  //Inserting Post category
   $qery = "UPDATE `category` SET `post` = post + 1 WHERE category_id = '$post_cat'";
  $conn->query($qery);
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
                 <h1 class="admin-heading">Add New Post</h1>
             </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form -->
                  <form  action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                  <?php
                        if(isset($_POST['submit']))
                        {
                            if($message == true)
                            {
                              echo '<div class="alert alert-success">
                                     Post uploaded successfully
                                    </div>';
                            }
                            elseif($message == false)
                            {
                              echo '<div class="alert alert-danger">
                                     Post cannot upload
                                    </div>';
                            }
                        }
                     ?>
                      <div class="form-group">
                          <label for="post_title">Title</label>
                          <input type="text" name="post_title" class="form-control" autocomplete="off" required>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1"> Description</label>
                          <textarea name="postdesc" class="form-control" rows="5"  required></textarea>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Category</label>
                          <select name="category" class="form-control">
                              <option value="" selected> Select Category</option>
                              <?php
                              while($data = $res->fetch_assoc())
                              {
                              echo '<option value=" ' . $data['category_id'] . '"> ' . $data['category_name'] . '</option>';
                              }
                              ?>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="exampleInputPassword1">Post image</label>
                          <input type="file" name="fileToUpload" required>
                      </div>
                      <input type="submit" name="submit" class="btn btn-primary" value="Save" required />
                  </form>
                  <!--/Form -->
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
