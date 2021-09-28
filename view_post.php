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
	
	if(isset($_POST['comment'])){
		$comment = strip_tags($_POST['comment-txt']);
		
		
		$comment = mysqli_real_escape_string($link, $comment);
		
		
		$time = date('l jS \of F Y h:i:s A');
		
		$username = $_SESSION['username'];
		$sql = "INSERT INTO comments (comment,date,pid,username) VALUES ('$comment','$time','$pid','$username')";
		
		if($comment==""){
			echo "Please Complete Your Post";
			return;
		}
		
		mysqli_query($link,$sql);
		header("location: welcome.php");
		
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
  background-image: url("photos/plat.png");
  background-repeat: no-repeat;
   background-size: cover;
  text-align: center;

  color: white;
  font-size: 30px;
}

</style>
</head>
<body>
		
		<?php
		$sql_get = "SELECT * FROM posts WHERE id=$pid LIMIT 1";
		$res = mysqli_query($link, $sql_get);
		
		if(mysqli_num_rows($res)>0){
		while($row=mysqli_fetch_assoc($res)){
			$title = $row['title'];
			$subtitle = $row['subtitle'];
			$content =$row['content'];
			$date = $row['date'];
			$image = $row['image'];
			$username = $row['username'];
			
		echo "<div class='header'>
		  <h1>$title</h1>
		</div>";
		echo '<img style=" border-radius: 50%; width:20%;display: block; margin-left: auto;margin-top :3%; margin-right: auto;" src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'"/>';
		echo"<div style='text-align:center;'>
			<h1 class='text-danger'>$title</h1>
		<div>";
		echo"<div style='text-align:center;'>
		<h4 class='text-info'>$subtitle</h4>
		<div>";
		echo"<h5 style='padding: 5%; margin-top:2px;' placeholder='Content' name='content' >$content</h5><br />";
		
		}
	}
		?>
		
		<form style ="margin-bottom:5%" method="post" enctype="multipart/form-data">
		<div style="text-align:center;">
		<div style="margin-left:335px; width:50%; margin-right:100px; margin-top:30px;" class="input-group mb-3">
		  <input type="text" class="form-control" placeholder="Title" aria-label="Titlee" name="comment-txt" aria-describedby="basic-addon2">
		  <div class="input-group-append">
			<span class="input-group-text" id="basic-addon2">Comment</span>
		  </div>
		</div>
		<div style="text-align:center; margin-bottom:5%"><input style="width:10%" class="btn btn-success"name="comment" id="comment" type="submit" value="Comment"></div>
		</form>
		
		
		<?php
		include_once("config.php");
		require_once("nbbc/nbbc.php");
		
		$bbcode = new BBCode;
		
		$sql = "Select * From comments WHERE pid=$pid ORDER BY id DESC";
		
		$res = mysqli_query($link, $sql) or die(mysqli_error());
		
		$comments ="";
		
		
		
		if(mysqli_num_rows($res) > 0){
			while($row = mysqli_fetch_assoc($res)){
				$id = $row['id'];
				$comment = $row['comment'];
				$date = $row['date'];
				$username = $row['username'];
				
				
				
				
				$output = $bbcode->Parse($comment);
			
				#$posts .= "<div><h2><a href='viwpost.php?pid=$id'>$title</a></h2><h3>$date</h3><p>$output</p>$admin</div>";
				
				//$comments .= "	<div class='card border mb-12' Style='margin-bottom:1%; margin-left: 100px; margin-right: 100px; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.5);transition: 0.3s;' class='card text-center'>
				$comments .= "	<div class='card border mb-12' Style='width:60%; display: block; margin-left: auto; margin-right: auto; ' class='card text-center'>
				<div class='card text-center'>
				  <div class='card-header text-black mb-8'>
				  <h6>$username</h6>$date
					
				  </div>
				  <div class='card'>
						  <div class='card-body'>
							$comment
						  </div>
					</div>	  
		</div>
		</div>";
			}
			echo $comments;
		}else{
			echo "There are no Comments to display";
		}
		
		?>
</body>
</html>
