<?php

$servername = "104.236.66.19";
$username = "jgreen";
$password = "mysqlhoney";
$database = "cowrie";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

echo '
<!DOCTYPE html>
<html>

<head>
  <title>Cowrie Honeypot Stats</title>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
  <!-- Social media links -->
  <link rel="stylesheet prefetch" href="http://netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css">
  <!-- Custom CSS Links-->
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Greenjam94.me</a>
    </div>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li><a href="http://greenjam94.me">Home</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Resume<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="resume.html">HTML version</a></li>
              <li><a href="resume.pdf">PDF version</a></li>
            </ul>
          </li>
          <li><a href="http://blog.greenjam94.me">Blog</a></li>
          <li><a href="http://greenjam94.github.io">Github Projects</a></li> 
          <li><a href="http://cogss.greenjam94.me">COGSS</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="navbar-inverse affix">
    <ul class="nav">
      
    </ul>
  </div>

  
	<div class="container">
';

// Check connection
if ($conn->connect_error) {
    echo '<div class="alert alert-danger alert-dismissible" role="alert">
    		Connection failed: Contact Greenjam94
    		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
    	</div>';
} else {
	echo '<div class="alert alert-success alert-dismissible" role="alert">
			Connected successfully
    		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		</div>';


	echo '
		<div class="panel panel-inverse">
			<div class="panel-heading">
				<h3 class="panel-title">SSH CLIENTS & COUNT</h3>
			</div>
			<div class="panel-body">';
				$versions = $conn->query("SELECT version FROM clients;");
				$distinctClients = $conn->query("SELECT count(distinct(client)) FROM sessions;");
				$clients=mysqli_fetch_row($distinctClients)[0];
				for ($i = 1; $i<=$clients; $i++) {
					$clientCount = $conn->query("SELECT count(client) FROM sessions WHERE client = ".$i);
					if ($clientCount) {

						while ($count=mysqli_fetch_row($clientCount)) {
							$version=mysqli_fetch_row($versions);

							echo ($version[0].": ".$count[0]."<br>");
						}

					} else {
						die("Query failed: ".mysqli_error($conn));
					}
				}
				echo '
			</div>
		</div>
		';

		echo '
		<div class="panel panel-inverse">
			<div class="panel-heading">
				<h3 class="panel-title">DISTINCT IP ADDRESSES</h3>
			</div>
			<div class="panel-body">';
				$ips = $conn->query("SELECT distinct(ip) FROM sessions;");
				if ($ips) {
					while ($ip=mysqli_fetch_row($ips)) {
						echo ($ip[0]."<br>");
					}
				} else {
					die("Query failed: ".mysqli_error($conn));
				}
				echo '
			</div>
		</div>';

		echo '
		<div class="panel panel-inverse">
			<div class="panel-heading">
				<h3 class="panel-title">Attempted Authentications</h3>
			</div>
			<div class="panel-body">';
				$successes = $conn->query("SELECT count(success) FROM auth WHERE success = 1;");
				$fails = $conn->query("SELECT count(success) FROM auth WHERE success = 0;");
				if ($successes && $fails) {
					// Fetch one and one row
					$success=mysqli_fetch_row($successes);
					$fail=mysqli_fetch_row($fails);
					echo ("success ratio: ".$success[0]."/".$fail[0]."<br>");
					
				} else {
					die("Query failed: ".mysqli_error($conn));
				}
				echo '
			</div>
		</div>';

		echo '
		<div class="panel panel-inverse">
			<div class="panel-heading">
				<h3 class="panel-title">Attempted Commands</h3>
			</div>
			<div class="panel-body">';
				$cmds = $conn->query("SELECT distinct(input), success FROM input;");
				if ($cmds) {
					// Fetch one and one row
					while ($cmd=mysqli_fetch_row($cmds)) {
						$worked = $cmd[1] ? "worked" : "failed";
						echo ("Attempted: ".$cmd[0]." ".$worked."<br>");
					}
				} else {
					die("Query failed: ".mysqli_error($conn));
				}
				echo '
			</div>
		</div>';

	echo "
	</div>

	<script src='https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js'></script>

	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','http://www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-65722430-1', 'auto');
	ga('send', 'pageview');

	</script>
	</body>
	</html>";

	$conn->close();
}
?>