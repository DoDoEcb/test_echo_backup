<center>
<table id="page">
<tr>
	<th>Currency</th><th>Available</th><th>Pending</th><th>Deposit</th><th>Withdraw</th>
</tr>
<?php
if(!isUserLoggedIn()){ header("LOCATION:index.php?page=login"); die(); }
$user_id =  $loggedInUser->user_id;
$sql = mysql_query("SELECT * FROM Wallets ORDER BY `Name` ASC");
while ($row = mysql_fetch_assoc($sql)) {
$coin = $row["Id"];
$result = @mysql_query("SELECT * FROM balances WHERE User_ID='$user_id' AND `Wallet_ID` = '$coin'");
if($result == NULL)
{
$amount = 0;
$pending = 0;
}
else
{
$amount = @mysql_result($result,0,"Amount");
}
$account = $loggedInUser->display_username;
?>
<tr>
	<td><a href="index.php?page=trade&market=<?php echo $market_id; ?>"><?php echo $row["Name"];?></a></td><td class="b1"><?php echo $amount ?></td><td class="b1"><?php echo $pending; ?></td><td><a href="index.php?page=deposit&id=<?php echo $row["Id"]; ?>">Deposit</a></td><td><a href="index.php?page=withdraw&id=<?php echo $row["Id"]; ?>">Withdraw</a></td>
</tr>
<?php
}
?>
</table>
</center>
