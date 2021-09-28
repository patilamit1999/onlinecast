<?php
	session_start();
	include_once("config.php");
	
	if(!isset($_SESSION['username'])){
	header("location: login.php");
	return;
	}
	if(!isset($_GET['pid'])){
	header("location: welcome.php");
	}
	$pid = $_GET['pid'];
	
	if(isset($_POST['update'])){
		$title = strip_tags($_POST['title']);
		$subtitle = strip_tags($_POST['subtitle']);
		$content = strip_tags($_POST['content']);
		
		
		$title = mysqli_real_escape_string($link, $title);
		$subtitle = mysqli_real_escape_string($link, $subtitle);
		$content = mysqli_real_escape_string($link, $content);
		
		$date = date('l jS \of F Y h:i:s A');
		
		$sql = "UPDATE posts SET title='$title' ,content='$content' , date='$date', subtitle='$subtitle' WHERE id=$pid";
		
		if($title==""|| $content == "" || $subtitle==""){
			echo "Please Complete Your Post";
			return;
		}
		
		mysqli_query($link,$sql);
		
		header("Location: welcome.php");
	}
?>

<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit-Post-Blog</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<style>
	.header {
  padding: 60px;
   background-position: center;
  background-image: url("photos/add.jpg");
  background-repeat: no-repeat;
  backgraund-size: fill;
  text-align: center;
  position: relative;
  color: black;
  font-size: 30px;
}
</style>
</head>
<body>
		<div class="header">
		  <h1>Edit Your Blog</h1>
		  <p>Find Some New Creativity</p>
		</div>
		<?php
		$sql_get = "SELECT * FROM posts WHERE id=$pid LIMIT 1";
		$res = mysqli_query($link, $sql_get);
		
		if(mysqli_num_rows($res)>0){
		while($row=mysqli_fetch_assoc($res)){
			$title = $row['title'];
			$subtitle = $row['subtitle'];
			$content =$row['content'];
			
		echo "<form action='edit_post.php?pid=$pid' method='post' enctype='multipart/form-data'>";
		echo"<div style='text-align:center;'>
		<div style='margin-left:335px; width:50%; margin-right:100px; margin-top:30px;' class='input-group mb-3'>
		  <input type='text' class='form-control' placeholder='Title' aria-label='Title' name='title' value='$title' aria-describedby='basic-addon2'>
		  <div class='input-group-append'>
			<span class='input-group-text' id='basic-addon2'>Title</span>
		  </div>
		</div>
		<div>";
		echo"<div style='text-align:center;'>
		<div style='margin-left:335px; width:50%; margin-right:100px; margin-top:30px;' class='input-group mb-3'>
		  <input type='text' class='form-control' placeholder='Sub-Title' aria-label='Title' name='subtitle' value='$subtitle' aria-describedby='basic-addon2'>
		  <div class='input-group-append'>
			<span class='input-group-text' id='basic-addon2'>Sub-Title</span>
		  </div>
		</div>
		<div>";
		echo"<textarea class='form-control' style='margin-left:335px; width:50%; margin-right:100px; margin-top:10px;' placeholder='Content' name='content' rows='10' cols='50'>$content</textarea><br />";
		
		}
	}
		?>
		<div style="text-align:center;"><input style="width:50%" class="btn btn-success"name="update" id="update" type="submit" value="Update"></div>
		</form>
</body>
</html>
