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

$sql = "delete from account where DATEDIFF(CURDATE(),last_active) > 30;";
		echo $sql . "<BR>";

		try {
			$conn->query($sql);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
