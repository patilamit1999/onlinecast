<?php 
		session_start();
		include_once("config.php")
?>
<!DOCTYPE html>
<html>
<head>
		<title>Blog</title>
</head>
<body>
		<?php
		require_once("nbbc/nbbc.php");
		
		$bbcode = new BBCode;
		
		$sql = "Select * From posts ORDER BY id DESC";
		
		$res = mysqli_query($link,$sql) or die(mysqli_error());
		
		$posts ="";
		
		if(mysqli_num_rows($res) > 0){
			while($row = mysqli_fetch_assoc($res)){
				$id = $row['id'];
				$title = $row['title'];
				$content = $row['content']; 
				$date = $row['date'];
				$username =$_SESSION['username'];
				
				$admin= "<div><a href='del_post.php?pid=$id'>Delete</a>&nbsp;<a href='edit_post.php?pid=$id'>Edit</a></div>";
				
				$output = $bbcode->Parse($content);
				
				$posts .= "<div><h2><a href='viwpost.php?pid=$id'>$title</a></h2><h4>BY : $username</h4><h3>$date</h3><p>$output</p>$admin</div>";
			}
			echo $posts;
		}else{
			echo "There are no post to display";
		}
		
		?>
	<a href ='post.php' target='_blank'>Post</a>
</body>
</html>