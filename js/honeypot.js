function getSSHclients() {
	$.ajax({ url: 'honeypot.php',
         data: {action: 'sshClients'},
         dataType: "json",
         type: 'post',
         success: function(res) {
                      //console.log(res);
                      for (var key in res) {
                      	//console.log();
                      	document.getElementById('ssh-clients').insertAdjacentHTML('beforeend', "SSH Client: "+key+" Times Used: "+res[key]+"<br>");
                      }
                  }
	});
}


function getIPaddresses() {
	$.ajax({ url: 'honeypot.php',
         data: {action: 'distinctIPs'},
         dataType: "json",
         type: 'post',
         success: function(res) {
                      //console.log(res);
                      for (var key in res) {
                      	//console.log(res[key]);
                      	document.getElementById('ip-addresses').insertAdjacentHTML('beforeend', res[key]+"    <span id="+res[key]+"_geo></span><br>");
                      	getIPgeoInfo(res[key]);
                      }
                  }
	});
}


function getAuthAttempts() {
	$.ajax({ url: 'honeypot.php',
         data: {action: 'authAttempts'},
         dataType: "json",
         type: 'post',
         success: function(res) {
					//console.log(res);
					document.getElementById('auth-attempts').insertAdjacentHTML('beforeend', res+"<br>");
                  }
	});
}


function getCmdAttempts() {
	$.ajax({ url: 'honeypot.php',
         data: {action: 'cmdAttempts'},
         dataType: "json",
         type: 'post',
         success: function(res) {
					//console.log(res);
                      for (var key in res) {
                      	//console.log();
                      	document.getElementById('cmd-attempts').insertAdjacentHTML('beforeend', "Command: "+key+" Result: "+res[key]+"<br>");
                      }
                  }
	});
}


function getIPgeoInfo(ip) {
	$.get("http://ipinfo.io/"+ip+"/json", function(data, status){
        console.log("Data: " + data + "\nStatus: " + status);
        document.getElementById(ip+"_geo").innerHTML = data['country'];
    });
}

getSSHclients();
getIPaddresses();
getAuthAttempts();
getCmdAttempts();