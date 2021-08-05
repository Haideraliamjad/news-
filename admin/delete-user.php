<?php
$id = $_GET['user_id'];
//Connection with data base
require '../common/db_inc.php'; 
$qry = "DELETE FROM `user` WHERE user_id = ? ";
$res = $conn->prepare($qry);
$res->bind_param('i' , $id);
if($res->execute())
{
    header('location:users.php');
}
else
{
    echo "Sorry ! We Can't Delete This User";
}
?>