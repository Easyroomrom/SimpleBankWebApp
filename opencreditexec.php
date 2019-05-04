<?php
if (!isset($_COOKIE["name"])) {
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

	

	print "starting";	

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

		$create_flag = 0;

		print "account exists";

		$pass = $_POST["pass"];
		$sql = "select pass_hash from customer where ssn = '$ssn';";
		$result = $conn->query($sql);	
		$row = $result->fetch_assoc();
		$fetchd_hash = $row["pass_hash"];

		if($fetchd_hash != sha1($pass.$ssn)){

		  $conn->close();		
 		  setcookie("fail", 1, time() + (3));
		  header('Location: opencreditcard.php');
		}

		else{
			$create_flag = 1;

			
		}

	}

	else{

		$conn->close();		
 		 setcookie("fail", 1, time() + (3));
		 header('Location: opencreditcard.php');

	}
		

	//Handling File Upload here

	//echo "Starting upload";

//$create_flag2 = 1

	if($create_flag){


		$credit_card = rand(0,9);

		for($i = 1; $i < 16; $i++){

			$randm = rand(0,9);
			$credit_card = $credit_card . $randm;


		}

		$sec_code = rand(0,9);

		for($i = 1; $i < 3; $i++){

			$randm = rand(0,9);
			$sec_code = $sec_code . $randm;


		}

		$exp_date = 365 * 4;

		$balance = 0;

		$income = $_POST["income"];

		$credit_limit = $income / 12;

		if($credit_limit < 100){

			$conn->close();		
 		 	setcookie("lowincome", 1, time() + (3));
		 	header('Location: opencreditcard.php');

		}

		else{


			$min_payment = 0;


			$sql = "INSERT INTO credit_card (credit_card_number,security_code,expiration_date,balance,credit_limit,payment_due,minimum_payment) VALUES ('$credit_card','$sec_code',ADDDATE(DATE(CURDATE()),$exp_date),'$balance','$credit_limit',ADDDATE(DATE(CURDATE()),30),'$min_payment');";
			echo $sql . "<BR>";

			try {
				$conn->query($sql);
			} catch (Exception $e) {
				echo $e->getMessage();
			}

			$sql = "INSERT INTO has_credit_card (SSN, credit_card_number ) VALUES ('$ssn', '$credit_card');";
			echo $sql . "<BR>";

			try {
				$conn->query($sql);
			} catch (Exception $e) {
				echo $e->getMessage();
			}

			$conn->close();
			setcookie("cred_open_success", 1, time() + (3));
			header('Location: opencreditcard.php');

		}
		
	}

}
?>
