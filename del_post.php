<?php 
	session_start();
	include_once('config.php');
	
	if(!isset($_SESSION['username'])){
	header("location: login.php");
	return;
	}
	
	if(!isset($_GET['pid'])){
	header("location: welcome.php");
	}else{
		$pid =$_GET['pid'];
		$sql = "DELETE FROM posts WHERE id=$pid";
		mysqli_query($link, $sql);
		$sqll = "DELETE FROM comments WHERE pid=$pid";
		mysqli_query($link, $sqll);
		header("location: welcome.php");
		
	}
	
?>