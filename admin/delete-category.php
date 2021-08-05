<?php
session_start();
session_regenerate_id(true);
if($_SESSION['user_role'] == 0)
{
header('location:post.php');
}
require '../common/db_inc.php';
$id  = $_GET['cat_id'];
$qry1 = "SELECT category_name FROM `category` WHERE  category_id = $id";
$res1 = $conn->query($qry1);
$data = $res1->fetch_assoc();
$cname = $data['category_name'];
$qry1 = "UPDATE `post` SET category = 'Undefined' WHERE category = '$cname' ";
$res2 = $conn->query($qry1);
$qry3 = "DELETE FROM `category` WHERE category_id = $id";
$res3 = $conn->query($qry3);
header('location:category.php');
?>
