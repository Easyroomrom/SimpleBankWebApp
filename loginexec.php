<?php
if (isset($_COOKIE["name"])) {
	header('Location: index.php');
	print "Ya";
}
else {
		$matched = false;

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
		$password = $_POST["pass"];
		$pass_hash = sha1($password.$ssn);
		//Check if user exists in db
		$sql = "select * from customer where ssn = '$ssn' and pass_hash = '$pass_hash';";
		$result = $conn->query($sql);
		if ($row = $result->fetch_assoc()) {
			$matched = true;
			$yourName = $row["f_name"] . " " . $row["l_name"];
			$yourZip = $row["zip"];
		}
		//you can do while ($row = $result->fetch_assoc()) {} for queries with multiple results

		if($matched){
			setcookie("name", $yourName, time() + (60*30));
			setcookie("zip", $yourZip, time() + (60*30));
			setcookie("ssn", $ssn, time() + (60*30));
			header('Location: index.php');
		}
		else{
			setcookie("fail", 1, time() + (3));
			header('Location: login.php');
		}
	}

?>
