<?php
if(isset($_POST['login']))
{
  //message variables
  $message = null;
  //Getting Details
  $name = $_POST['username'];
  $pass = sha1($_POST['password']);
  //Include Database
  require '../common/db_inc.php'; 
  //checking query
  $qry = "SELECT * FROM `user` WHERE username = ? AND password = ?";
  $res = $conn->prepare($qry);
  $res->bind_param('ss',$name,$pass);
  $res->execute();
  $data = $res->get_result();
  if($data->num_rows > 0)
  {
    $id = $data->fetch_assoc();
    $user_id = $id['user_id'];
    $user_role = $id['role'];
    session_start();
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user_id;
    $_SESSION['user_role'] = $user_role;
    $_SESSION['login'] = true;
    header('location:post.php');
  }
  else
  {
   $message = true;
  }
}
?>
<!doctype html>
<html>
   <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>ADMIN | Login</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link rel="stylesheet" href="font/font-awesome-4.7.0/css/font-awesome.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body>
        <div id="wrapper-admin" class="body-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-offset-4 col-md-4">
                        <img class="logo" src="images/news.jpg">
                        <h3 class="heading">Admin</h3>
                        <!-- Form Start -->
                        <form  action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST" autocomplete="off">
                            <?php
                             if(isset($_POST['login']))
                             {
                                if($message == true)
                                {
                                    echo '<div class="alert alert-danger">
                                           Invalid Credientials
                                          </div>';
                                }
                             }
                            ?>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" placeholder="" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="" required>
                            </div>
                            <input type="submit" name="login" class="btn btn-primary" value="login" />
                        </form>
                        <!-- /Form  End -->
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
