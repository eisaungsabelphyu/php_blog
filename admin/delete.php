<?php 
session_start();
require "../config/config.php";
if(empty($_SESSION['id']) || empty($_SESSION['logged_in'])){
  header("Location: login.php");
}else{
    if($_GET){
        $stm = $pdo->prepare("DELETE FROM posts WHERE id=".$_GET['id']);
        $result = $stm->execute();
        if($result){
            echo "<script>alert('Deletd!');window.location.href='index.php';</script>";
        }
    }
    
}
?>