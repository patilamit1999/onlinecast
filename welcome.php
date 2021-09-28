<?php
// Initialize the session
session_start();
	include_once('config.php');
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
	
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="js/float-panel.js"></script>
	<script src="js/script.js"></script>
	 <link href="CSS/demo2.css" rel="stylesheet" />
   <style>
		
		.float{
			position:fixed;
			width:60px;
			height:60px;
			bottom:40px;
			right:40px;
			background-image: url("photos/add.png");
			color:#FFF;
			text-align:center;
			box-shadow: 2px 2px 3px #999;
		}

		.my-float{
			margin-top:22px;
		}
		/* Style the header */
		.header {
		background-image: url("photos/head.png");
		background-opacity: 0.3;
		background-size: cover;
		
		  padding: 80px;
		  text-align: center;
		  background-image:
		  background: #1abc9c;
		  color: black;
		}

		/* Increase the font size of the h1 element */
		.header h1 {
		  font-size: 40px;
		}
		
</style>
</head>
<body>
<div class="slideanim">
		<nav class="navbar navbar-expand-lg navbar-dark bg-info">
		 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
		  <a class="navbar-brand" href="welcome.php">Home</a>
				  <div class="collapse navbar-collapse" id="navbarNavDropdown">
					<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
					  <li class="nav-item active">
						<a class="nav-link" href="my_blogs.php">My Blogs <span class="sr-only">(current)</span></a>
					  </li>
				<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  Profile
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
				  <a class="dropdown-item" href="#">Action</a>
				  <a class="dropdown-item" href="#">Another action</a>
				  <a class="dropdown-item" href="#">Something else here</a>
				</div>
			  </li>
			   
			</ul>
			<form class="form-inline my-2 my-lg-0">
			  <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
			  <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
			</form>
			<form Style="padding:20px; margin-right:5%" class="form-inline my-3 my-lg-0">
			
			   <a href="post.php" class="btn btn-warning">Write new blog</a>
			 
			</form>
		  </div>
		</nav>
</div>		
	<div class="slideanim">
	<div class="header">
	  <h1>BLOGGEER </h1>
	  <h4>Hii,  <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our Blog site. .</h4>
	</div>
	</div>
    <div style="text-align:center"class="page-header">
       
    </div>
    <p style="text-align:center; margin-top:10px">
        <a href="resetpass.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
	<?php
		require_once("nbbc/nbbc.php");
		
		$bbcode = new BBCode;
		
		$sql = "Select * From posts ORDER BY id DESC";
		
		$res = mysqli_query($link, $sql) or die(mysqli_error());
		
		$posts ="";
		
		if(mysqli_num_rows($res) > 0){
			while($row = mysqli_fetch_assoc($res)){
				$id = $row['id'];
				$title = $row['title'];
				$subtitle = $row['subtitle']; 
				$date = $row['date'];
				$username = $row['username'];
				$currentUser= $_SESSION['username'];
				
				if(false !== stripos ($currentUser, $username)){ 
				$admin= "
				<a href='del_post.php?pid=$id' class='btn btn-outline-danger'>Delete</a>&nbsp;
				<a href='edit_post.php?pid=$id' class='btn btn-outline-success'>Edit</a>
				<a href='view_post.php?pid=$id' class='btn btn-outline-info'>View Post</a>";
				}else{
				$admin = "<a href='View_post.php?pid=$id' class='btn btn-outline-info'>View Post</a>";
				}
				
				$output = $bbcode->Parse($subtitle);
				$image= '<img style="border-radius: 50%; width:15%" src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'"/>';
			
				#$posts .= "<div><h2><a href='viwpost.php?pid=$id'>$title</a></h2><h3>$date</h3><p>$output</p>$admin</div>";
				
				$posts .= "	<div class='card border-success mb-3' Style='margin-bottom:1%; margin-left: 100px; margin-right: 100px; box-shadow: 0 4px 8px 0 rgba(0,0,0,0.5);transition: 0.3s;' class='card text-center'>
				<div class='card text-center'>
				  <div class='card-header text-white bg-info mb-8'>
					$username
				  </div>
				  <div class='card-body'>
				  $image
					<h3 class='card-title'>
					$title</h3>
					<p class='card-text'>$output</p>
					$admin
				  </div>
				  <div class='card-footer text-muted'>
					$date
				  </div>
		</div>
		</div>";
			}
			echo $posts;
		}else{
			echo "There are no post to display";
		}
		
		?>
		
		
	
</body>
</html>