function getSSHclients() {
	$.ajax({ url: 'honeypot.php',
         data: {action: 'sshClients'},
         dataType: "json",
         type: 'post',
         success: function(res) {
                      //console.log(res);
                      count = 1;
                      for (var key in res) {
                      	//console.log();
                        document.getElementById('cca'+count.toString()).innerHTML = key;
                      	document.getElementById('ccb'+count.toString()).innerHTML = res[key];
                        count++;
                        document.getElementById('client-rows').insertAdjacentHTML('beforeend',
                          "<tr><td id='cca"+count+"'></td><td id='ccb"+count+"'></td></tr>");
                        
                      }
                  $('#client-loading').hide();
                  $('#client-content').show();
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
                      	document.getElementById('ip-content').insertAdjacentHTML('beforeend', res[key]+"    <span id="+res[key]+"_geo></span><br>");
                      	getIPgeoInfo(res[key]);
                      }
                      $('#ip-loading').hide();
                      $('#ip-content').show();
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
                      percent = (((parseInt(res[0]) / parseInt(res[1]))*100).toFixed(2)).toString();
    					        document.getElementById('auth-content').insertAdjacentHTML('beforeend', res[0]+"/"+res[1]+" "+percent+"%<br>");
                      $('#auth-loading').hide();
                      $('#auth-content').show();
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
                      count = 1;
                      for (var key in res) {
                      	//console.log();
                        document.getElementById('cmda'+count.toString()).innerHTML = key;
                      	document.getElementById('cmdb'+count.toString()).innerHTML = res[key];
                        count++;
                        document.getElementById('cmd-rows').insertAdjacentHTML('beforeend',
                          "<tr><td id='cmda"+count+"'></td><td id='cmdb"+count+"'></td></tr>");
                      }
                      $('#cmd-loading').hide();
                      $('#cmd-content').show();
                  }
	});
}


function getIPgeoInfo(ip) {
	$.get("http://ipinfo.io/"+ip+"/json", function(data, status){
        //console.log("Data: " + data + "\nStatus: " + status);
        document.getElementById(ip+"_geo").innerHTML = data['country'];
    });
}

setTimeout(function(){
    $('#connection-alert').alert('close')
}, 2000);
getSSHclients();
getIPaddresses();
getAuthAttempts();
getCmdAttempts();