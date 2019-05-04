<?php include 'header.php';?>

<body>
	<center>
	<form method="POST" action ="opencreditexec.php" enctype="multipart/form-data">
	<table width='50%'>
		<td>
            <fieldset>
                <h3>
                    Please fill out the following form to see credit card eligibility.</h3>
					<h4 style>All fields required.</h4>
					<?php if (isset($_COOKIE["fail"])) {?>
					<p style = "color:red">Your ssn or password is incorrect. Please try again.</p>
					<?php } else if (isset($_COOKIE["lowincome"])) {?>
					<p style = "color:green"> Sorry, you do not qualify for a credit card...</p>
					<?php } else if (isset($_COOKIE["cred_open_success"])) {?>
					<p style = "color:green"> Congratulations! Your credit card account has been created!</p>
					<?php }?>

					<label>Estimated Annual Income</label><input required type='text' name="income" id="income">
					<BR><BR>
					<label>Confirm SSN</label><input required type='text' name="ssn" id="ssn" maxlength="9">
					<label>Confirm Password</label><input required type='password' name="pass" id="pass" maxlength="20">
					
					<BR><BR>
                    <center><input id="submit" type="submit" value="Submit"></center>
                </span>
            </fieldset>
		</td>
	</table>
	</form>
	</center>
</body>

<?php include 'footer.php';?>
