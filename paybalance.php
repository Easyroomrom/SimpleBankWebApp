<?php include 'header.php';?>
<?php include 'logcheck.php';?>
<?php
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
?>
<body>
	<center>
	<form method="POST" action ="paybalance.php">
	<table width='50%'>
		<td>
      <fieldset>
        <h3>Pay your card balance from an account.</h3>

        <?php
        $credit_card_number_rec  = $_POST['credit_card_number_rec'];
        $account_number_send  = $_POST['account_number_send'];
        $amount = $_POST['amount'];
        $first_day_this_month = date('Y-m-01');
        //echo $first_day_this_month;

        if ($account_number_send != "" && $credit_card_number_rec != "") {
          //Check that theres enough money, then transfer
          $sql = "SELECT balance, type from account where account_number='$account_number_send';";
          $result = $conn->query($sql);
      		$row = $result->fetch_assoc();
      		$balance = $row["balance"];
          $type = $row["type"]; //checking or savings

          //Count number of widthdrawals this month
          $sql = "SELECT count(*) as count from transactions_account where account_number='$account_number_send' and date >='$first_day_this_month';";
          $result = $conn->query($sql);
      		$row = $result->fetch_assoc();
      		$widthdrawals = $row["count"];

          if ($type == "savings" && $widthdrawals >= 6) {
            echo "<p style = 'color:red'>You have reached the widthdrawal limit for this savings account.</p>";
          } else if ($balance < $amount) {
            echo "<p style = 'color:red'>You do not have enough money in this account.</p>";
          } else if ($amount <= 0) {
            echo "<p style = 'color:red'>You must enter a positive amount.</p>";
          } else {
            //Make sure we dont overpay & pay at least the minimum
            $sql = "SELECT balance, minimum_payment from credit_card where credit_card_number='$credit_card_number_rec';";
            $result = $conn->query($sql);
        		$row = $result->fetch_assoc();
        		$card_balance = $row["balance"];
            $min_payment = $row["minimum_payment"];

            if ($amount < $min_payment) {
              echo "<p style = 'color:red'>You must enter a a value higher than the minimum payment.</p>";
            } else {
              if ($amount > $card_balance) {
                $amount = $card_balance;
              }
              $min_payment = ($card_balance - $amount) / 12;

              $sql = "INSERT into transactions_account (account_number,t_id,amount,type,date,description) values ('$account_number_send',NULL,'$amount','debit',CURDATE(),'Balance payment to $account_number_rec');";
              $conn->query($sql);
              $sql = "INSERT into transactions_credit_card (credit_card_number,t_id,amount,type,date,description) values ('$credit_card_number_rec',NULL,'$amount','credit',CURDATE(),'Balance payment from $account_number_send');";
              $conn->query($sql);
              $sql = "UPDATE account SET balance = balance - $amount, last_active = CURDATE() WHERE account_number='$account_number_send';";
              $conn->query($sql);
              $sql = "UPDATE credit_card SET balance = balance - $amount, minimum_payment = $min_payment WHERE credit_card_number='$credit_card_number_rec';";
              $conn->query($sql);

              $amount = number_format($amount,2);
              echo "<p style = 'color:green'>Successfully paid balance: <strong>$$amount</strong> from <strong>$account_number_send</strong> to <strong>$credit_card_number_rec</strong>!</p>";
            }
          }

        }
        ?>
					<label>Sending Account</label><BR>
  					<select required name="account_number_send" id="account_number_send">

              <?php
              $ssn = $_COOKIE["ssn"];
              $sql = "SELECT ssn, a.account_number, type, balance from account a, has_account h where h.account_number=a.account_number and h.ssn = '$ssn';";
            	$result = $conn->query($sql);

            	while ($row = $result->fetch_assoc()) {
                $account_number  = $row['account_number'];
                $type  = $row['type'];
                $balance  = number_format($row['balance'],2);
                $select = ($_POST['account_number_send']==$account_number) ? 'selected' : '';
                echo "<option $select value='$account_number'>$account_number-$type-$$balance</option>";
            	}
              ?>

  					</select>
					  <BR><BR>
          <label>Credit Card</label><BR>
    				<select required name="credit_card_number_rec" id="credit_card_number_rec">

              <?php
              $ssn = $_COOKIE["ssn"];
              $sql = "SELECT ssn, c.credit_card_number, balance, minimum_payment from credit_card c, has_credit_card h where h.credit_card_number=c.credit_card_number and h.ssn = '$ssn';";
              $result = $conn->query($sql);

              while ($row = $result->fetch_assoc()) {
                $credit_card_number  = $row['credit_card_number'];
                $min_payment  = number_format($row['minimum_payment'],2);
                $balance  = number_format($row['balance'],2);
                $select = ($_POST['credit_card_number_rec']==$credit_card_number) ? 'selected' : '';
                echo "<option $select value='$credit_card_number'>$credit_card_number-Bal-$$balance-Min Pay-$$min_payment</option>";
              }
              ?>

    				</select>
  					<BR><BR>
        <label>Amount to pay:   $</label><input required type='number' step="0.01" name="amount" id="amount" value="<?=$amount?>">
        <center><input id="submit" type="submit" value="Transfer"></center>
      </fieldset>
		</td>
	</table>



	</form>
	</center>
</body>

<?php include 'footer.php';?>
