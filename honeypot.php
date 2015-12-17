<?php

function connect() {
	//Database info
	$servername = "104.236.66.19";
	$username = "jgreen";
	$password = "mysqlhoney";
	$database = "cowrie";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $database);

	// Check connection
	if ($conn->connect_error) {
		return null;
	} else {
		return $conn;
	}
}

function sshClients() {
	$conn = connect();
	if ($conn) {
		//init array
		$clientsArray = array();

		//Queries
		$versions = $conn->query("SELECT version FROM clients;");
		$distinctClients = $conn->query("SELECT count(distinct(client)) FROM sessions;");

		$clients=mysqli_fetch_row($distinctClients)[0];
		for ($i = 1; $i<=$clients; $i++) {
			$clientCount = $conn->query("SELECT count(client) FROM sessions WHERE client = ".$i);
			if ($clientCount) {

				while ($count=mysqli_fetch_row($clientCount)) {
					$version=mysqli_fetch_row($versions);

					//Add to array: key is version, value is number of times used
					$clientsArray[$version[0]] = $count[0];
				}
			}
		}

		//return JSON version of array
		echo json_encode($clientsArray);
	}
	$conn->close();
}

function distinctIPs() {
	$conn = connect();
	if ($conn) {
		//init
		$ipsArray = array();

		//Query
		$ips = $conn->query("SELECT distinct(ip) FROM sessions;");


		if ($ips) {
			while ($ip=mysqli_fetch_row($ips)) {
				//add ip to array
				$ipsArray[] = $ip[0];
			}
		}

		//return as JSON
		echo json_encode($ipsArray);
	}
	$conn->close();
}

function authAttempts() {
	$conn = connect();
	if($conn) {
		//init
		$ratio = "";

		//Queries
		$successes = $conn->query("SELECT count(success) FROM auth WHERE success = 1;");
		$fails = $conn->query("SELECT count(success) FROM auth WHERE success = 0;");

		if ($successes && $fails) {
			// Fetch one and one row
			$success=mysqli_fetch_row($successes);
			$fail=mysqli_fetch_row($fails);

			$ratio = $success[0]."/".$fail[0];
		}

		echo json_encode($ratio);
	}
	$conn->close();
}

function cmdAttempts() {
	$conn = connect();
	if($conn) {
		//init
		$cmdsArray = array();

		//Query
		$cmds = $conn->query("SELECT distinct(input), success FROM input;");

		if ($cmds) {
			while ($cmd=mysqli_fetch_row($cmds)) {
				$worked = $cmd[1] ? "spoofed" : "failed";
				
				//Add to array: key is cmd, value is result
				$cmdsArray[$cmd[0]] = $worked;
			}
		}

		echo json_encode($cmdsArray);
	}
	$conn->close();
}

//How to call functions from AJAX
//http://stackoverflow.com/questions/2269307/using-jquery-ajax-to-call-a-php-function
if(isset($_POST['action']) && !empty($_POST['action'])) {
    switch($_POST['action']) {
        case 'sshClients' : sshClients();break;
        case 'distinctIPs' : distinctIPs();break;
        case 'authAttempts' : authAttempts();break;
        case 'cmdAttempts' : cmdAttempts();break;
    }
}
?>