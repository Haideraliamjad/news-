<?php include "header.php"; ?>
<?php
if($_SESSION['user_role'] == 0)
{
header('location:post.php');
}
//Including databae
require '../common/db_inc.php';
if(isset($_GET['page']))
{
  $page = $_GET['page'];
}
else
{
  $page = 1;
}
$limit = 5;
$offset = ($page - 1 ) * $limit;
$qry = "SELECT * FROM `category` LIMIT $offset , $limit";
$res = $conn->query($qry);
$total = $res->num_rows;

//
?>
<div id="admin-content">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h1 class="admin-heading">All Categories</h1>
            </div>
            <div class="col-md-2">
                <a class="add-new" href="add-category.php">add category</a>
            </div>
            <div class="col-md-12">
                <table class="content-table">
                    <thead>
                        <th>S.No.</th>
                        <th>Category Name</th>
                        <th>No. of Posts</th>
                        <th>Delete</th>
                    </thead>
                    <tbody>
                      <?php
                         while($data = $res->fetch_assoc())
                         {
                            echo  "<tr>
                                  <td class='id'>" . $data['category_id'] ."</td>
                                  <td>" . $data['category_name'] . "</td>
                                  <td>" . $data['post'] . "</td>
                                  <td class='delete'><a href='delete-category.php?cat_id=" . $data['category_id'] . " '><i class='fa fa-trash-o'></i></a></td>
                                  </tr>";
                         }
                       ?>

                    </tbody>
                </table>
                <?php
                $t_btn = ceil($total / $limit);
                echo "<ul class='pagination admin-pagination'>";
                for($i = 1; $i <= $t_btn ; $i++ ){
                echo "<li><a href='category.php?page=" . $i . "'>" . $i . "</a></li>";
                }
                echo "</ul>";
                ?>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
