<?php include "header.php"; ?>
<?php
if($_SESSION['login'] != true)
{
header('location:index.php');
}
//include database
require '../common/db_inc.php';
if(isset($_GET['post_id']))
{
$id = $_GET['post_id'];
$qry = "SELECT * FROM `post` WHERE post_id = ? ";
$res = $conn->prepare($qry);
$res->bind_param('i',$id);
$res->execute();
$data = $res->get_result();
$row = $data->fetch_assoc();
//Query for fetching category
$qry1 = "SELECT * FROM `category`";
$result  = $conn->query($qry1);
//Code for update post
if(isset($_POST['submit']))
{
$new_id = $_POST['post_id'];
$post_title = $_POST['post_title'];
$post_desc = $_POST['postdesc'];
$new_category = $_POST['category'];
$old_img = $_POST['old-image'];
$new_address = null;
//Code for uploading new image
if(!empty($_FILES['new-image']['name']))
{
 unlink($old_img);
$file_name = $_FILES['new-image']['name'];
$file_exe = pathinfo($file_name,PATHINFO_EXTENSION);
$req_exe = ['jpg','png','jpeg','gif'];
if(in_array($file_exe,$req_exe))
{
  $file_name = rand('111111111','999999999') . "." . $file_exe;
  $destination = "upload/" . $file_name;
  move_uploaded_file($_FILES['new-image']['tmp_name'],$destination);
  $new_address = $destination;
}
}
else {
  $new_address = $old_img;
}
$query = "UPDATE `post` SET title = '{$post_title}' , description = '{$post_desc}' , category = {$new_category} , post_img = '{$new_address}' WHERE post_id = {$new_id}";
$conn->query($query);
header('location:post.php');
}
}
?>
<div id="admin-content">
  <div class="container">
  <div class="row">
    <div class="col-md-12">
        <h1 class="admin-heading">Update Post</h1>
    </div>
    <div class="col-md-offset-3 col-md-6">
        <!-- Form for show edit-->
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" autocomplete="off">
            <div class="form-group">
                <input type="hidden" name="post_id"  class="form-control" value="<?php echo $id; ?>" placeholder="">
            </div>
            <div class="form-group">
                <label for="exampleInputTile">Title</label>
                <input type="text" name="post_title"  class="form-control" id="exampleInputUsername" value="<?php echo $row['title']; ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1"> Description</label>
                <textarea name="postdesc" class="form-control"  required rows="5" value="">
                   <?php echo $row['description']; ?>
                </textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputCategory">Select New Category</label>
                <select class="form-control" name="category">
                  <?php 
                    $selected;
                    while($response = $result->fetch_assoc()){
                      if($response['category_id'] == $row['category'])
                      {
                        $selected = "selected";
                      }
                      else
                      {
                          $selected = '';
                      }
                      echo '<option value=" ' . $response['category_id'] . ' " ' . $selected . '> ' . $response['category_name'] . '</option>';
                    }
                  ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Post image</label>
                <input type="file" name="new-image">
                <img  src="<?php echo $row['post_img']; ?>" height="150px">
                <input type="hidden" name="old-image" value="<?php echo $row['post_img']; ?>">
            </div>
            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
        </form>
        <!-- Form End -->
      </div>
    </div>
  </div>
</div>
<?php include "footer.php"; ?>
