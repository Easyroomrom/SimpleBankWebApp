<?php include 'header.php';?>

<body>
	<center>
	<form method="POST" action ="createaccountexec.php" enctype="multipart/form-data">
	<table width='50%'>
		<td>
            <fieldset>
                <h3>
                    Please fill out the following form to create a checking or savings account.</h3>
					<h4 style>All fields required.</h4>
					<?php if (isset($_COOKIE["fail"])) {?>
					<p style = "color:red">Your ssn or password is incorrect. Please try again.</p>
					<?php } else if (isset($_COOKIE["fail2"])) {?>
					<p style = "color:red">Please upload files that are less than 5MB</p>
					<?php } else if (isset($_COOKIE["fail3-1"])) {?>
					<p style = "color:red">Photo ID must be JPG, JPEG, PNG or PDF only</p>
					<?php } else if (isset($_COOKIE["fail3-2"])) {?>
					<p style = "color:red">Proof of Address must be JPG, JPEG, PNG or PDF only</p>
					<?php } else if (isset($_COOKIE["fail3-3"])) {?>
					<p style = "color:red">Photo ID must be an image file</p>
					<?php } else if (isset($_COOKIE["fail4"])) {?>
					<p style = "color:red">There has been an unexpected error in file upload. Please try again later or call the bank :)</p>
					<?php } else if (isset($_COOKIE["acc_create_success"])) {?>
					<p style = "color:green"> Congratulations! Your account has been created!</p>
					<?php }?>

					<label>Type of Account</label><BR>
					<select name="type" id="type">
						<option value="checking">Checking</option>
						<option value="savings">Savings</option>
			
					</select>
					<BR><BR>
					<label>Confirm SSN</label><input required type='text' name="ssn" id="ssn" maxlength="9">
					<label>Confirm Password</label><input required type='password' name="pass" id="pass" maxlength="20">
					<BR>
					<label>Photo ID upload: </label><input required type='file' name="photo_id" id="photo_id">
					<BR><BR>
					<label>Proof of Address upload: </label><input required type='file' name="proof_of_address" id="proof_of_address">
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
