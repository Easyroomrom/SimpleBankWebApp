<?php
if (isset($_COOKIE['name'])) {
    unset($_COOKIE['name']);
	unset($_COOKIE['zip']);
	setcookie("name", null, -1, '/');
	setcookie("zip", null, -1, '/');
}

include 'header.php';
?>

<body>
	<center>
	<form method="POST" action ="loginexec.php">
	<table width='23%'>
		<td>
            <fieldset>
                * Required fields
                <h3>
                    Please input your username and password:</h3>
					<p>A login is neccasary to access many pages on the site. If you need an account, <strong><a href = "register.php">register</a></strong> today!</p>
					<?php if (isset($_COOKIE["fail"])) {?>
					<p style = "color:red">You failed your login. Try again.</p>
					<?php }?>
          <?php if (isset($_COOKIE["reg_success"])) {?>
					<p style = "color:green">You registered an account successfully!</p>
					<?php }?>

                    <label>SSN*</label><input required type='text' name="ssn" id="ssn">
					<label>Password*</label><input required type='password' name="pass"id="pass">

					<p>Note: You will be logged out after 60 seconds of inactivity</p>
                    <center><input id="submit" type="submit" value="Send"></center>
                </span>
            </fieldset>
		</td>
	</table>
	</form>
	</center>
</body>
<?php include 'footer.php';?>
