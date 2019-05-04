<html>
<?php
		if(isset($_COOKIE["name"])){
			$login = true;
			$getName = $_COOKIE["name"];
			$getZip = $_COOKIE["zip"];
			$getSSN = $_COOKIE["ssn"];

			$url = "http://api.zippopotam.us/us/" . $getZip;
			$json = file_get_contents($url);
			$json_data = json_decode($json, true);

			//get city and state from zip code
			$city = $json_data["places"][0]["place name"];
			$state = $json_data["places"][0]["state abbreviation"];

			$lat = $json_data["places"][0]["latitude"];
			$long = $json_data["places"][0]["longitude"];

			setcookie("name", $getName, time() + (60*30));
			setcookie("zip", $getZip, time() + (60*30));
			setcookie("ssn", $getSSN, time() + (60*30));
			?>
			<script>
			setTimeout(function(){
				window.alert("Your session has expired! You have been logged out.");
				location.reload()},
			60000*30);
			</script>
			<?php
		} else {
			$login = false;
		}
?>

<header style="background-color: grey;">
<title>Simple Bank</title>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="icon" href="images/favicon.ico">
<ul class="nav">
  <li class="nav" ><a href="index.php">Home</a></li>


  <?php if($login){  ?>
		<li class="nav" ><a href="createaccount.php">New Checking/Savings Account</a></li>
		<li class="nav" ><a href="opencreditcard.php">Get a New Credit Card</a></li>
		<li class="nav" ><a href="accountstatement.php">Account Statements</a></li>
		<li class="nav" ><a href="cardstatement.php">Card Statements</a></li>
		<li class="nav" ><a href="paybalance.php">Pay Balance</a></li>
		<li class="nav" ><a href="transfer.php">Transfer</a></li>
		<li class="nav" ><a href="transferout.php">Transfer Out</a></li>
  <p class="header">| You are currently logged in as <?= $getName?> | Location: <?=$city?>, <?=$state?> | <a href = "login.php"> Logout </a></p>
  <?php }else{?>
  <p class="header">| You are currently accessing this site as a guest. | <a href = "login.php"> Login </a>| <a href = "register.php" text-decoration: none;> Register </a></p>
  <?php }?>

 </ul>
<table width='100%'>
<td>
<img class='center' src="images/simplebanklogo.png">
</td>
</table>
<hr height='20px' width='100%' color="#003366">
</header>
