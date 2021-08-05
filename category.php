<?php include 'header.php'; ?>
<?php
$limit = 7;
$id = $_GET['cat'];
if(isset($_GET['page']))
{
  $page = $_GET['page'];
}
else
{
  $page = 1;
}
$offset = ($page - 1) * $limit;
$fetch_query = "SELECT post.post_id , post.title , post.description , post.category , post.post_date , post.post_img , post.author , category.category_id , category.category_name FROM `post` INNER JOIN category ON post.category = category.category_id WHERE post.category = '$id' ORDER BY post.post_id DESC LIMIT $offset , $limit";
$fetch_result  = $conn->query($fetch_query);
$cat = $fetch_result->fetch_assoc()['category_name'];
?>
    <div id="main-content">
        <div class="container">
            <div class="row">

                <div class="col-md-8">
                    <!-- post-container -->
                      <h1 class="page-heading"><?php echo @$cat; ?></h1>
                    <div class="post-container">
                       <?php
                       while($fetch_data = $fetch_result->fetch_assoc() ){
                           $admin = null;
                           if($fetch_data['author'] == 1)
                           {
                               $admin = "Admin";
                           }
                           else
                           {
                               $admin = "Normal User";
                           }
                       echo '<div class="post-content">
                            <div class="row">
                                <div class="col-md-4">
                                    <a class="post-img" href="single.php?post_id='.$fetch_data['post_id'].'"><img src="admin/'.$fetch_data['post_img'].'" alt=""/></a>
                                </div>
                                <div class="col-md-8">
                                    <div class="inner-content clearfix">
                                        <h3><a href="single.php?post_id='.$fetch_data['post_id'].'">'.$fetch_data['title'].'</a></h3>
                                        <div class="post-information">
                                            <span>
                                                <i class="fa fa-tags" aria-hidden="true"></i>
                                                <a href="category.php?cat='. $fetch_data['category_id'] .'">'.$fetch_data['category_name'].'</a>
                                            </span>
                                            <span>
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                <a href="#">'.$admin.'</a>
                                            </span>
                                            <span>
                                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                                '.$fetch_data['post_date'].'
                                            </span>
                                        </div>
                                        <p class="description">
                                           '.substr($fetch_data['description'],0,100) . ".... ".'
                                        </p>
                                        <a class="read-more pull-right" href="single.php?post_id='.$fetch_data['post_id'].'">read more</a>
                                    </div>
                                </div>
                            </div>
                        </div>';}
                        //pagination start here
                        $qry_total = "SELECT * FROM `post` WHERE category = '$id'";
                        $result = $conn->query($qry_total);
                        $total  = $result->num_rows;
                        $tot_row = ceil($total/$limit);
                        echo "<ul class='pagination admin-pagination'>";
                        for($i = 1; $i <= $tot_row ; $i++ ){
                         echo   "<li><a href='category.php?cat=" .$id. "&page=".$i."'>" . $i . "</a></li>";
                        }
                        echo "</ul>"
                     ?>
                     </div><!-- /post-container -->
                    </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
