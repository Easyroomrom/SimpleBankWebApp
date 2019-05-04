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
		  header('Location: createaccount.php');
		}

		else{
			$create_flag = 1;

			
		}

	}

	else{

		$conn->close();		
 		 setcookie("fail", 1, time() + (3));
		 header('Location: createaccount.php');

	}
		

	//Handling File Upload here

	//echo "Starting upload";

//$create_flag2 = 1

	if($create_flag){

		$create_flag2 = 1;

		$upload_dir = "photoids/";
		
		$file_name = $_FILES["photo_id"]["name"];
		
		$upload_path1 = $upload_dir.$file_name;

		$upload_good = 0;

		$imageFileType = strtolower(pathinfo($upload_path1,PATHINFO_EXTENSION));
		
				//if(isset($_POST["submit"])){
			
		echo "here";

		$is_image = getimagesize($_FILES["photo_id"]["tmp_name"]);
		
		if($is_image !== false) {
		      		//echo "File is an image - " . $check["mime"] . ".";
		      		$upload_good = 0;
		}      
		else {
		      	echo "File is not an image.";
		      	$upload_good = 1;
		}
		 		//}	

		if ($_FILES["fileToUpload"]["size"] > 5000000) {
	    	   	echo "Sorry, your file is too large.";
	    	   	$upload_good = 2;
		}
				// Allow certain file formats
		print $imageFileType;
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "pdf" ) {
	    	   	echo "Sorry, only JPG, JPEG, PNG & PDF files are allowed.";
	    	  	$upload_good = 3;
		}

		if($upload_good != 0){

		   			//echo "Sorry file was not uploaded";

		   	if($upload_good == 2){

				//File size too large
		   		$conn->close();		
	 			setcookie("fail2", 1, time() + (3));
				header('Location: createaccount.php');

		   	}

		   	else if($upload_good == 3){

				//File not valid format
		   		$conn->close();		
	 			setcookie("fail3-1", 1, time() + (3));
		       		header('Location: createaccount.php');
				print $imageFileType;

		   		}

		   	else{

		      		//File is not image
		      		$conn->close();		
	 	      		setcookie("fail3-3", 1, time() + (3));
		      		header('Location: createaccount.php');

		  	}

		}
		else{

		   	if (move_uploaded_file($_FILES["photo_id"]["tmp_name"], $upload_path1)) {
		        		echo "The file ". basename( $_FILES["photo_id"]["name"]). " has been uploaded.";
					
		     	} 
		     	else {
					$create_flag2 = 0;
					//echo "Sorry, there was an error uploading your file.";
						$conn->close();		
			 			setcookie("fail4", 4, time() + (3));
						header('Location: createaccount.php');

	    	     
		     		}


			}
			

		

				//Handle Address Proof

				$upload_dir = "proof_addr/";
		
				$file_name = $_FILES["proof_of_address"]["name"];
		
				$upload_path2 = $upload_dir.$file_name;

				$upload_good = 0;

				$imageFileType = strtolower(pathinfo($upload_path2,PATHINFO_EXTENSION));
		
		//if(isset($_POST["submit"])){
		/*	
		   echo "here";

		   $is_image = getimagesize($_FILES["photo_id"]["tmp_name"]);
		   if($is_image !== false) {
		      //echo "File is an image - " . $check["mime"] . ".";
		      $upload_good = 0;
		   }      
		   else {
		      echo "File is not an image.";
		      $upload_good = 1;
		   }
		*/
		 //}	

				if ($_FILES["fileToUpload"]["size"] > 500000) {
	    	   			echo "Sorry, your file is too large.";
	    	   			$upload_good = 2;
				}
				// Allow certain file formats
				print $imageFileType;
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
					&& $imageFileType != "pdf" ) {
	    	   			//echo "Sorry, only JPG, JPEG, PNG & PDF files are allowed.";
	    	   			$upload_good = 3;
				}

				if($upload_good != 0){

		   			//echo "Sorry file was not uploaded";

		   			if($upload_good == 2){

						//File size too large
		   				$conn->close();		
	 					setcookie("fail2", 2, time() + (3));
						header('Location: createaccount.php');

		   			}

		   			else if($upload_good == 3){

						//File not valid format
		   				$conn->close();		
	 					setcookie("fail3-2", 3, time() + (3));
						header('Location: createaccount.php');
					}

		   		}

		 		else{

					//This should not be a user error
		     			if (move_uploaded_file($_FILES["proof_of_address"]["tmp_name"], $upload_path2)) {
		        			echo "The file ". basename( $_FILES["proof_of_address"]["name"]). " has been uploaded.";
						
		     			} 
		     			else {
						$create_flag = 2;
			  			echo "Sorry, there was an error uploading your file.";
			  			$conn->close();		
	 		  			setcookie("fail4", 4, time() + (3));
			  			header('Location: createaccount.php');
	    	     			}

		     		
				}
	
	}

	if($create_flag2){

		print "All verified";

		$type = $_POST["type"];

		//account number generation

		$account = rand(0,9);

		for($i = 1; $i < 12; $i++){

			$randm = rand(0,9);
			$account = $account . $randm;


		}

		//routing number pick

		$sql = "select state from customer where ssn = '$ssn';";
		$result = $conn->query($sql);	
		$row = $result->fetch_assoc();
		$fetchd_st = $row["state"];



		switch ($fetchd_st){
			case "Arizona":
				$routing = "122100024";
				break;
			case "California":
				$routing = "322271627";
				break;
			case "Colorado":
				$routing = "102001017";
				break;
			case "Connecticut":
				$routing = "021100361";
				break;
			case "Florida":
				$routing = "267084131";
				break;
			case "Georgia":
				$routing = "061092387";
				break;
			case "Idaho":
				$routing = "123271978";
				break;
			case "Illinois":
				$routing = "071000013";
				break;
			case "Indiana":
				$routing = "074000010";
				break;
			case "Kentucky":
				$routing = "083000137";
				break;
			case "Louisiana":
				$routing = "065400137";
				break;
			case "Michigan":
				$routing = "072000326";
				break;
			case "Nevada":
				$routing = "322271627";
				break;
			case "New Jersey":
				$routing = "021202337";
				break;
			case "New York":
				$routing = "021000021";
				break;
			case "Ohio":
				$routing = "044000037";
				break;
			case "Oklahoma":
				$routing = "103000648";
				break;
			case "Oregon":
				$routing = "325070760";
				break;
			case "Texas":
				$routing = "111000614";
				break;
			case "Utah":
				$routing = "124001545";
				break;
			case "Washington":
				$routing = "325070760";
				break;
			case "West Virginia":
				$routing = "051900366";
				break;
			case "Wisconsin":
				$routing = "075000019";
				break;
			default:
				$routing = "022300173";
				break;
		}
		$start_balance = 100.00;							

		$sql = "INSERT INTO account (account_number,routing_number,type,date_open,photo_ID,proof_of_address,balance,last_active) VALUES ('$account','$routing','$type',DATE(CURDATE()),'$upload_path1','$upload_path2','$start_balance',DATE(CURDATE()));";
		echo $sql . "<BR>";

		try {
			$conn->query($sql);
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		$sql = "INSERT INTO has_account (SSN, account_number ) VALUES ('$ssn', '$account');";
		echo $sql . "<BR>";

		try {
			$conn->query($sql);
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		$conn->close();
		setcookie("acc_create_success", 1, time() + (3));
		header('Location: createaccount.php');


	}

	else{

		print "bad";

	}

}
?>
