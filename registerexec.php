<?php
if (isset($_COOKIE["name"])) {
	header('Location: index.php');
}
else {
	$servername = "127.0.0.1";
	$username = "dbuser";
	$password = "\$Jasper123";

	// Create connection
	$conn = new mysqli($servername, $username, $password);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	$conn->query("use bank;");
	echo "Connected successfully.<BR>";

	$ssn = $_POST["ssn"];
	$acc_exists = false;
	//Check if username (SSN) exists in db
	$sql = "select * from customer where ssn = '$ssn';";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
			echo 'Acc exists<BR>';
	    $acc_exists = true;
	}


	//Check if the passwords are the same
	if ($acc_exists) {
		$conn->close();
		setcookie("fail2", 1, time() + (3));
		header('Location: register.php');
	} else if($_POST["pass"] != $_POST["conf_pass"]){
		$conn->close();
		setcookie("fail", 1, time() + (3));
		header('Location: register.php');
	} else {
		$first_name = $_POST["first"];
		$last_name = $_POST["last"];
		$password = $_POST["pass"];
		$zip_code = $_POST["zip"];
		$street = $_POST["street"];
		$city = $_POST["city"];
		$state = $_POST["state"];

		$pass_hash = sha1($password.$ssn);
		$sql = "INSERT INTO customer (ssn,pass_hash,f_name,l_name,street,city,state,zip) VALUES ('$ssn','$pass_hash','$first_name','$last_name','$street','$city','$state','$zip_code');";
		echo $sql . "<BR>";

		try {
			$conn->query($sql);
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		$conn->close();
		setcookie("reg_success", 1, time() + (3));
		header('Location: login.php');
	}


}
?>
