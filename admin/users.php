<?php include "header.php"; ?>
<?php
if($_SESSION['user_role'] == 0)
{
header('location:post.php');
}
//Connection with data base
require '../common/db_inc.php';
//Variables For Pagination
$limit = 5;
if(isset($_GET['page']))
{
$page = $_GET['page']; 
}
else
{
$page = 1;
}
$offset = ($page - 1) * $limit;
$qry = "SELECT user_id , first_name , last_name , username , role FROM `user` ORDER BY user_id DESC LIMIT ? , ? ";
$res = $conn->prepare($qry);
$res->bind_param('ii',$offset,$limit);
$res->execute();
$data = $res->get_result();


?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Users</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-user.php">add user</a>
              </div>
              <div class="col-md-12">
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Full Name</th>
                          <th>User Name</th>
                          <th>Role</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                          
                             <?php
                             while($row = $data->fetch_assoc())
                             {
                                if($row['role'] == 1)
                                {
                                    $role = "Admin";
                                }
                                else
                                {
                                    $role = "Normal User";
                                }
                               echo "<tr><td class='id'>" . $row['user_id'] . "</td>
                               <td>" . $row['first_name'] . " " . $row['last_name'] . "</td>
                               <td>" . $row['username'] ."</td>
                               <td> " . $role ." </td>
                               <td class='edit'><a href='update-user.php?user_id=" . $row['user_id'] ."'><i class='fa fa-edit'></i></a></td>
                               <td class='delete'><a href='delete-user.php?user_id=" . $row['user_id'] ."'><i class='fa fa-trash-o'></i></a></td></tr>";
                             }
                             ?>
                          
                      </tbody>
                  </table>
                  <?php
                   $qry1 = "SELECT * FROM `user`";
                   $newres = $conn->query($qry1);
                   $totalrec = $newres->num_rows;
                   $total = ceil($totalrec / $limit);
                   echo "<ul class='pagination admin-pagination'>";
                   for($i = 1 ; $i <= $total ; $i++)
                   {
                     echo '<li class="active"><a href="users.php?page=' . $i .'">' . $i .'</a></li>';
                   }
                   echo "</ul>";

                  ?>
              </div>
          </div>
      </div>
  </div>
<?php include "header.php"; ?>
