<?php include 'header.php'; ?>
<?php
$show = null;
if(isset($_GET['post_id']))
{
$show = true; 
//query for fetching data 
$fetch = "SELECT post.title, post.description , post.author , post.post_img, post.post_date , category.category_name FROM post LEFT JOIN 
category ON post.category = category.category_id WHERE post.post_id = ? ";
$data = $conn->prepare($fetch);
$data->bind_param('i',$_GET['post_id']); 
$data->execute();
$rows = $data->get_result();
$data_final = $rows->fetch_assoc();
$author = NULL;
if($data_final['author'] == 1)
{
$author = "Admin";
}
else 
{
$author = "Normal User";
}
}
else
{
$show = false;
}
?>
    <div id="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                  <!-- post-container -->
                   <?php
                   if($show == true)
                   {
                    echo '<div class="post-container">
                    <div class="post-content single-post">
                        <h3>'.$data_final['title'].'</h3>
                        <div class="post-information">
                            <span>
                                <i class="fa fa-tags" aria-hidden="true"></i>
                                '.$data_final['category_name'].'
                            </span>
                            <span>
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <a href="#">'.$author.'</a>
                            </span>
                            <span>
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                '.$data_final['post_date'].'
                            </span>
                        </div>
                        <img class="single-feature-image" src="admin/'.$data_final['post_img'].'" alt=""/>
                        <p class="description">
                           '.$data_final['description'].'
                        </p>
                    </div>
                  </div>';
                   }
                   else 
                   {
                     echo "<b>Invalid URL</b>";
                   }
                   ?>
                    <!-- /post-container -->
                </div>
                <?php include 'sidebar.php'; ?>
            </div>
        </div>
    </div>
<?php include 'footer.php'; ?>
