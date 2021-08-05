<?php
//Query for fetching data
$query = "SELECT post.post_id,post.title, post.post_img, post.post_date , category.category_name , category.category_id FROM post LEFT JOIN 
          category ON post.category = category.category_id ORDER BY post.post_id DESC LIMIT  5 ";
$result = $conn->query($query);



?>
<div id="sidebar" class="col-md-4">
    <!-- search box -->
    <div class="search-box-container">
        <h4>Search</h4>
        <form class="search-post" action="search.php" method ="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search .....">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-danger">Search</button>
                </span>
            </div>
        </form>
    </div>
    <!-- /search box -->
    <!-- recent posts box -->
    <div class="recent-post-container">
        <h4>Recent Posts</h4>
       <?php
       while($row = $result->fetch_assoc()){
       echo '<div class="recent-post">
            <a class="post-img" href="">
                <img src="admin/'. $row['post_img'] .'" alt=""/>
            </a>
            <div class="post-content">
                <h5><a href="single.php">' . $row['title'] .'</a></h5>
                <span>
                    <i class="fa fa-tags" aria-hidden="true"></i>
                    <a href="category.php?cat='.$row['category_id'].'">'. $row['category_name'] . '</a>
                </span>
                <span>
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    '. $row['post_date'] . '
                </span>
                <a class="read-more" href="single.php?post_id='.$row['post_id'].'">read more</a>
            </div>
        </div>';
        }
        ?>
       
    <!-- /recent posts box -->
</div>
