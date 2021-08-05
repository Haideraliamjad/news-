<?php

session_start();
session_regenerate_id(true);
if($_SESSION['login'] != true)
{
header('location:index.php');
}
//Including databae
require '../common/db_inc.php';
$id = $_GET['post_id'];
$qry = "DELETE FROM `post` WHERE post_id = ? ";
$res = $conn->prepare($qry);
$res->bind_param('i',$id);
$res->execute();
header('location:post.php');
?>
