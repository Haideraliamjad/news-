<?php include "header.php"; ?>
<?php
if($_SESSION['login'] != true)
{
header('location:index.php');
}
//Include Database
require '../common/db_inc.php'; 
//pagination code
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
//query for fetch data
$qry = "SELECT post.post_id , post.title , post.post_date , post.author , category.category_name FROM post LEFT JOIN category ON post.category = category.category_id ORDER BY post.post_id DESC LIMIT $offset , $limit";
$res = $conn->query($qry);
?>
  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                        <?php

                          while($row = $res->fetch_assoc())
                          {

                            if($row['author'] == 0)
                            {
                              $author = 'Normal user';
                            }
                            else {
                              $author = "Admin";
                            }

                            echo "<tr>
                                <td class='id'>" . $row['post_id'] . "</td>
                                <td style='text-overflow: ellipsis'>" . $row['title'] . "</td>
                                <td>" . $row['category_name'] . "</td>
                                <td>" . $row['post_date'] . "</td>
                                <td>" . $author . "</td>
                                <td class='edit'><a href='update-post.php?post_id=" . $row['post_id'] . "'><i class='fa fa-edit'></i></a></td>
                                <td class='delete'><a href='delete-post.php?post_id=" . $row['post_id'] . "'><i class='fa fa-trash-o'></i></a></td>
                               </tr>";
                           }
                        ?>
                      </tbody>
                  </table>
                  <!-- pagination code  -->
                  <?php
                     $qry_total = "SELECT * FROM `post`";
                     $result = $conn->query($qry_total);
                     $total  = $result->num_rows;
                     $tot_row = ceil($total/$limit);
                     echo "<ul class='pagination admin-pagination'>";
                     for($i = 1; $i <= $tot_row ; $i++ ){
                      echo   "<li><a href='post.php?page=" .$i. "'>" . $i . "</a></li>";
                     }
                     echo "</ul>"
                  ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
