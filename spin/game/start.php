<?php
	include "helper.php";	
    $default_bet = 1;
    session_start();
    $_SESSION["player_id"] = 1234;
    $_SESSION["player_name"] = "Joan Wang";
    $_SESSION["player_credit"] = 500;
    $_SESSION["player_lifetime_spins"] = 0;
    $_SESSION["player_salt_value"] = 0;
 ?>

<html>
<head>
	<title>Simple Spin</title>
</head>
<body>
	<h2>Welcome <? echo $player_name; ?></h2>
	<h3>Credit: <? echo $player_credit; ?></h3>
	<h3>How much would you like to bet?</h3>
	<form method="get" action="spin.php">
		Betting <input type="text" name="bet" value="<? echo $default_bet; ?>"><br>
		<button type="submit" name="spin" value="1">Play 1 Line</button>
		<button type="submit" name="spin" value="3">Play 3 Lines</button>
	</form>
	
	<h3>Pay Table</h3>
	<table cellpadding="5" cellspacing="2" border="0">
		<tr><td>Payline</td><td>Pays</td></tr>
		<tr><td>Three Z's</td><td>500</td></tr>
		<tr><td>Three Y's</td><td>100</td></tr>
		<tr><td>Three D's</td><td>50</td></tr>
		<tr><td>Three C's</td><td>20</td></tr>
		<tr><td>Three B's</td><td>15</td></tr>
		<tr><td>Three A's</td><td>10</td></tr>
		<tr><td>A-A-any</td><td>5</td></tr>
		<tr><td>A-any-any</td><td>2</td></tr>
	</table>
</body>
</html>