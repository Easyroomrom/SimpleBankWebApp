<?php include 'header.php';?>

<body>
	<center>
	<form method="POST" action ="registerexec.php">
	<table width='50%'>
		<td>
            <fieldset>
                <h3>
                    Please fill out the fields to register for an Simple Bank account!</h3>
					<h4 style>All fields required.</h4>
					<?php if (isset($_COOKIE["fail"])) {?>
					<p style = "color:red">Your passwords do not match. Please try again.</p>
					<?php } else if (isset($_COOKIE["fail2"])) {?>
					<p style = "color:red">Your account already exists. Please call the bank if you forgot your password. :)</p>
					<?php }?>

          <label>First Name</label><input required type='text' name="first" id="first" maxlength="20">
					<label>Last Name</label><input required type='text' name="last" id="last" maxlength="20">
					<label>SSN (9 characters)</label><input required pattern=".{9,9}" type='text' name="ssn" id="ssn" maxlength="9">
					<label>Street</label><input required type='text' name="street" id="street" maxlength="30">
					<label>City</label><input required type='text' name="city" id="city" maxlength="20">
					<label>State</label><BR>
					<select name="state" id="state">
						<option value="AL">Alabama</option>
						<option value="AK">Alaska</option>
						<option value="AZ">Arizona</option>
						<option value="AR">Arkansas</option>
						<option value="CA">California</option>
						<option value="CO">Colorado</option>
						<option value="CT">Connecticut</option>
						<option value="DE">Delaware</option>
						<option value="DC">District Of Columbia</option>
						<option value="FL">Florida</option>
						<option value="GA">Georgia</option>
						<option value="HI">Hawaii</option>
						<option value="ID">Idaho</option>
						<option value="IL">Illinois</option>
						<option value="IN">Indiana</option>
						<option value="IA">Iowa</option>
						<option value="KS">Kansas</option>
						<option value="KY">Kentucky</option>
						<option value="LA">Louisiana</option>
						<option value="ME">Maine</option>
						<option value="MD">Maryland</option>
						<option value="MA">Massachusetts</option>
						<option value="MI">Michigan</option>
						<option value="MN">Minnesota</option>
						<option value="MS">Mississippi</option>
						<option value="MO">Missouri</option>
						<option value="MT">Montana</option>
						<option value="NE">Nebraska</option>
						<option value="NV">Nevada</option>
						<option value="NH">New Hampshire</option>
						<option value="NJ">New Jersey</option>
						<option value="NM">New Mexico</option>
						<option value="NY">New York</option>
						<option value="NC">North Carolina</option>
						<option value="ND">North Dakota</option>
						<option value="OH">Ohio</option>
						<option value="OK">Oklahoma</option>
						<option value="OR">Oregon</option>
						<option value="PA">Pennsylvania</option>
						<option value="RI">Rhode Island</option>
						<option value="SC">South Carolina</option>
						<option value="SD">South Dakota</option>
						<option value="TN">Tennessee</option>
						<option value="TX">Texas</option>
						<option value="UT">Utah</option>
						<option value="VT">Vermont</option>
						<option value="VA">Virginia</option>
						<option value="WA">Washington</option>
						<option value="WV">West Virginia</option>
						<option value="WI">Wisconsin</option>
						<option value="WY">Wyoming</option>
					</select>
					<BR><BR>
					<label>Zipcode (5 characters)</label><input required pattern=".{5,5}" type='text' name="zip" id="zip" maxlength="5">
					<label>Password</label><input required type='password' name="pass" id="pass" maxlength="20">
					<label>Confirm Password</label><input required type='password' name="conf_pass" id="confirm_password" maxlength="20">

                    <center><input id="submit" type="submit" value="Register"></center>
                </span>
            </fieldset>
		</td>
	</table>
	</form>
	</center>
</body>

<?php include 'footer.php';?>
