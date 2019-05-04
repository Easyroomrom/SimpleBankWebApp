<?php include 'header.php';?>

<body>
	<center>
	<table width='80%'>
		<td>
		   <article>
			  <h2>Contact Information</h2>
			  <p>
			  Send us your contact information to receive the latest developments and offers. <br>
			  Just fill in the form below: <br>
			  </p>
			  <form>
				<fieldset style='background: #FFF5C3;'>
				  <label for="nameinput">
					Name:
					<input type="text" id="nameinput" name="name" />
				  </label>
				  <br><br>
				  <label for="emailinput">
					Email:
					<input type="text" id="emailinput" name="email" />
				  </label>
				  <br><br>
				  <label for="phoneinput">
					Phone:
					<input type="text" id="phoneinput" name="phone" />
				  </label>
				  <br><br>
				</fieldset>
				<fieldset style='background: #FFF5C3;'>
				<center>
				  <input type="button" id="submit" value="Submit" />
				</center>
				</fieldset>
			 </form>
		   </article>
		</td>
	</table>
	</center>
</body>

   <script>
	function sumbitInfo() {
		var name = document.getElementById("nameinput");
		var email = document.getElementById("emailinput");
		var phone = document.getElementById("phoneinput");

		(name.value && email.value && phone.value) ?
			alert("Thank you " + name.value + ", expect to hear from us soon!") : alert("Please make sure to fill in all the fields");
	}
	document.getElementById("submit").
		addEventListener("click",sumbitInfo,false);
   </script>

<?php include 'footer.php';?>
