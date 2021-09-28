<?php
	session_start();
	include_once("config.php");
	
	if(isset($_POST['post'])){
		$title = strip_tags($_POST['title']);
		$content = strip_tags($_POST['content']);
		$subtitle = strip_tags($_POST['subtitle']);
		
		$title = mysqli_real_escape_string($link, $title);
		$content = mysqli_real_escape_string($link, $content);
		$subtitle = mysqli_real_escape_string($link, $subtitle);
		
		$time = date('l jS \of F Y h:i:s A');
	
		$file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
		
		
		$username = $_SESSION['username'];
		$sql = "INSERT INTO posts (title,content,date,username,image,subtitle) VALUES ('$title','$content','$time','$username','$file','$subtitle')";
		
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
    <title>Post-Blog</title>
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
		  <h1>New Blog</h1>
		  <p>Find Some New Creativity</p>
		</div>
		<form action="post.php" method="post" enctype="multipart/form-data">
		<div style="text-align:center;">
		<div style="margin-left:335px; width:50%; margin-right:100px; margin-top:30px;" class="input-group mb-3">
		  <input type="text" class="form-control" placeholder="Title" aria-label="Titlee" name="title" aria-describedby="basic-addon2">
		  <div class="input-group-append">
			<span class="input-group-text" id="basic-addon2">Title</span>
		  </div>
		</div>
		<div>
		<div style="text-align:center;">
		<div style="margin-left:335px; width:50%; margin-right:100px; margin-top:30px;" class="input-group mb-3">
		  <input type="text" class="form-control" placeholder="Sub-Title" aria-label="Titlee" name="subtitle" aria-describedby="basic-addon2">
		  <div class="input-group-append">
			<span class="input-group-text" id="basic-addon2">Sub-Title</span>
		  </div>
		</div>
		<div>
		
		<input type="file" name="image" id="image"><h5 class="text-danger"> Select Image For Header</h5></input>
		<!--<input placeholder="Title" name="title" type="text" autofocus size ="48"><br /><br />-->
		<textarea class="form-control" style="margin-left:335px; width:50%; margin-right:100px; margin-top:10px;" placeholder="Content" name="content" rows="10" cols="50"></textarea><br />
		<div style="text-align:center;"><input style="width:50%" class="btn btn-success"name="post" id="post" type="submit" value="Post"></div>
		</form>
		
</body>
</html>
<script>
$(ducument).ready(function(){
	$('#post').click(function(){
		var image_name= $('#image').val();
		if(image_name== '')
		{
			alert("Please Select Image");
			return false;
		}else{
			var extension = $('#image').val().split('.').pop().toLowerCase();
			if(jQuery.inArray(extension, ['gif','png','jpg','jpeg'])== -1){
				alert("Invalid Image Type");
				$('#image').val('');
				return false;
			}
		}
	});
});
</script>
