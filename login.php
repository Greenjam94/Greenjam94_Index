<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<link rel="stylesheet" href="/css/login.css">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha256-k2WSCIexGzOj3Euiig+TlR8gA0EmPjuc79OEeY5L45g=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<?php
/* This is not a login that is useful for my website, blog, or anything else.
 * The password is intentionally week and easy to brute force
 */

$hash = "812aed197837a25a15359cf45abba7e45e6f26b8e49f7c0db78334013ef9ab8e4bd12c9af15b4d595d06e9ed9dce91a75e9174c1011256e32ccd1a9ecd974230";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // validate login attempt
    // create name & password variables from request
    $name = htmlspecialchars($_POST["name"]);
    $pswd = htmlspecialchars($_POST["pswd"]);

    if ($name != "iAm") {
        //incorrect username html
?>
<div class="container">
    <br>
    <div class="alert alert-danger" role="alert">Error: Incorrect username</div>
</div>
<?php
    }

    // if password is correct, load gif
    if ($hash == hash('SHA512', $pswd)){
	//show dancing html content
?>

<div class="container">
    <div class="text-center">
        <iframe src="https://giphy.com/embed/F9hQLAVhWnL56" width="480" height="319" frameBorder="0" class="giphy-embed" allowFullScreen></iframe>
	<h1>Success!</h1>
    </div>
</div>

<?php
    }
    //else error
    else {
        //incorrect password html
?>
<div class="container">
    <br>
    <div class="alert alert-danger" role="alert">Error: Incorrect password</div>
</div>
<?php
    }
}

//if not a POST request, load form
else {
?>

<div class-"container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Sign in to continue to <a href="https://blog.greenjam94.me">blog</a></h1>
            <div class="account-wall">
                <img class="profile-img" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120"
                    alt="">
                <form class="form-signin" method="post">
                <input type="text" class="form-control" name="name" value="iAm" required autofocus>
                <input type="password" class="form-control" name="pswd" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

                <a href="#" class="pull-right need-help" data-toggle="modal" data-target="#myModal">Need help?</a><span class="clearfix"></span>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Brute Force 101</h4>
      </div>
      <div class="modal-body">
        <p>A brute-force attack consists of an attacker trying many passwords or passphrases with the hope of eventually guessing correctly. The attacker systematically checks all possible passwords and passphrases until the correct one is found.</p>
	<p>Some tools that could help:</p>
	<ul>
	  <li>Burpsuite Intruder</li>
          <li>Hydra</li>
	</ul>
	<p><a href="/p455w0rd5.txt">Wordlist</a><p>
      </div>
    </div>
  </div>
</div>

<?php
}
?>
