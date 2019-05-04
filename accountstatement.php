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
	<form method="POST" action ="accountstatement.php">
	<table width='50%'>
		<td>
      <fieldset>

					<label>Account</label><BR>
  					<select required name="account_number" id="account_number">

              <?php
              $ssn = $_COOKIE["ssn"];
              $sql = "SELECT ssn, a.account_number, type, balance from account a, has_account h where h.account_number=a.account_number and h.ssn = '$ssn';";
            	$result = $conn->query($sql);

            	while ($row = $result->fetch_assoc()) {
                $account_number  = $row['account_number'];
                $type  = $row['type'];
                $balance  = number_format($row['balance'],2);
                $select = ($_POST['account_number']==$account_number) ? 'selected' : '';
                echo "<option $select value='$account_number'>$account_number-$type-$$balance</option>";
            	}
              ?>

  					</select>
					<BR><BR>
          <label>How many days to look back?</label><BR>
            <select required name="lookback" id="lookback">
              <option <?= ($_POST['lookback']==7) ? 'selected' : ''?> value="7">7 days</option>
              <option <?= ($_POST['lookback']==30) ? 'selected' : ''?> value="30">30 days</option>
              <option <?= ($_POST['lookback']==120) ? 'selected' : ''?> value="120">120 days</option>
              <option <?= ($_POST['lookback']==365) ? 'selected' : ''?> value="365">365 days</option>
  					</select>
            <BR><BR>
            <label>Download report as csv? </label><input type="checkbox" name="get_csv" id="get_csv">

                    <center><input id="submit" type="submit" value="Submit"></center>
                </span>
      </fieldset>
		</td>
	</table>
  <BR>
    <?php
    $account_number  = $_POST['account_number'];
    $lookback  = $_POST['lookback'];
    $get_csv = $_POST['get_csv'] == "on";

    if ($account_number != "") {
    ?>
    <table width='50%' style="border: 1px solid black;">
      <tr><td colspan="4" style="border: 1px solid black;"><center><strong>Transactions</strong></center></td></tr>
      <tr><td><strong>Description</strong></td><td><strong>Date</strong></td><td><strong>Type</strong></td><td><strong>Amount</strong></td></tr>
    <?php
      $sql = "SELECT description, amount, type, date from transactions_account where account_number='$account_number' and date >= CURDATE()-$lookback;";
      $result = $conn->query($sql);
      //echo $sql."<BR>";
      while ($row = $result->fetch_assoc()) {
        $description  = $row['description'];
        $amount  = number_format($row['amount'],2);
        $type  = $row['type'];
        $date  = $row['date'];
        echo "<tr><td>$description</td><td>$date</td><td>$type</td><td>$$amount</td></tr>";
      }
    ?>
    </table>
    <?php
    }
    ?>
    <?php
    if ($get_csv) {
      $name = tempnam('/tmp', 'csv');
      $handle = fopen($name, 'w');

      $sql = "SELECT description, amount, type, date from transactions_account where account_number='$account_number' and date >= CURDATE()-$lookback;";
      $result = $conn->query($sql);
      //echo $sql."<BR>";
      while ($row = $result->fetch_assoc()) {
        $description  = $row['description'];
        $amount  = number_format($row['amount'],2);
        $type  = $row['type'];
        $date  = $row['date'];
        fwrite($handle,"$description,$date,$type,$amount\n");
        echo "<tr><td>$description</td><td>$date</td><td>$type</td><td>$$amount</td></tr>";
      }

      fclose($handle);
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename=' . basename($name).".csv");
      header('Content-Transfer-Encoding: binary');
      header('Expires: 0');
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      header('Pragma: public');
      header('Content-Length: ' . filesize($name));
      ob_clean();
      flush();
      readfile($name);
      unlink($name);
    }

    ?>

	</form>
	</center>
</body>

<?php include 'footer.php';?>
