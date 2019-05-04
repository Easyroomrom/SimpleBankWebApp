<?php include 'header.php';?>

<body>
	<center>
	<table width='80%'>
		<td>
            <fieldset>
                * Required fields
                <h3>
                    Want to get in touch with us?</h3>
                <p>
                    Hello, this is a form that enables you to contact us with any questions or concerns you may have.
					 					We will get back to you as soon as possible!</p>


                    <label>First Name*</label><input type='text' id="first-name">
					<label>Last Name*</label><input type='text' id="last-name">
					<label>E-mail*</label><input type='text' id="email">
					<label>Subject*</label><input type='text' id="subject">
					<label>Text*</label><textarea id="content"></textarea>

                    <center><input id="submit" type="submit" value="Send"></center>
                </span>
            </fieldset>
		</td>
	</table>
	</center>
</body>

   <script>
	function sumbitInfo() {
		var fname = document.getElementById("first-name");
		var lname = document.getElementById("last-name");
		var email = document.getElementById("email");
		var subj = document.getElementById("subject");
		var content = document.getElementById("content");

		(fname.value && lname.value && subj.value && email.value && content.value) ?
			alert("Thank you " + fname.value + ", we appreciate the feedback and will get back to you as soon as possible. See you!") : alert("Please make sure to fill in all the fields");
	}
	document.getElementById("submit").
		addEventListener("click",sumbitInfo,false);
   </script>

<?php include 'footer.php';?>
