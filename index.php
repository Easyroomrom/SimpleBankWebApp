<?php include 'header.php';?>

<body>
	<center>
	<table width='80%'>
		<td>
			<a href="index.php"><img <img style='border-style: solid; border-color: white;' class="center" src="images/menubanner.jpg"></a>
			<br>
			<h4>Welcome to Simple Bank</h4>
				<p>
					This is the website of the most trusted bank in America! All of our services were designed to make life Simple! All new members that apply for a credit card this month may be eligible for 24 months 0% APR!
				</p>
				<BR>
		</td>
	</table>
	</center>
</body>

<?php include 'footer.php';?>

<?php if(isset($_COOKIE["no_log"])){
?>
<script> alert("You must be logged in to view this page."); </script>
<?php
}
?>
