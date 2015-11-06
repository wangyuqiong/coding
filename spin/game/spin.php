<?php
/* 

Using letters A, B, C, D, Y, Z in place of pictures

	====== PAYTABLE ======
	Payline           Pays
	Three Z's  (333)  500
	Three Y's  (666)  100
	Three D's  (444)  50
	Three C's  (222)  20
	Three B's  (111)  15
	Three A's  (000)  10
	A-A-any    (00-)  5
	A-any-any  (0--)  2
	
	============= REELS ===============
	# Symbol    Reel 1   Reel 2   Reel 3
	0 A         5        2        3
	1 B         4        4        4
	2 C         3        4        4
	3 Z         1        1        1
	4 D         3        3        1
	5 X         3        5        6
	6 Y         1        1        1
	  Total     20       20       20


*/
include "helper.php";	

session_start(); 

//$user_credit = isset($_GET['credit']) ? (intval($_GET['credit'])) : 500;
$user_credit = $_SESSION["player_credit"];
$play_lines  = isset($_GET['spin']) ? (intval($_GET['spin'])) : 3;
$bet_per_line = isset($_GET['bet']) ? (intval($_GET['bet'])) : 1;

$winning_current_spin = 0 - $bet_per_line * $play_lines; // start with bets placed, to be adjusted after spin
$paytable_marker = Array();

if($user_credit <= 0 || $bet_per_line * $play_lines > $user_credit) {
	echo "You don't have enough money :(";
	die();
}
 
// set up the reels
$reel[0] = array(0,0,0,0,0,1,1,1,1,2,2,2,3,4,4,4,5,5,5,6);
$reel[1] = array(0,0,1,1,1,1,2,2,2,2,3,4,4,4,5,5,5,5,5,6);
$reel[2] = array(0,0,0,1,1,1,1,2,2,2,2,3,4,5,5,5,5,5,5,6);
shuffle($reel[0]);
shuffle($reel[1]);
shuffle($reel[2]);
// payout will be calculated from the first 1 (if 1 playline) or 3 (if 3 playline) triplets
// e.g. if 1 playline, payout is calculated from ($reel[0][0], $reel[1][0], $reel[2][0])

// calculate payout
for($i = 0; $i < 3; $i++) {
	$playline[$i] = array($reel[0][$i], $reel[1][$i], $reel[2][$i]);
	
	$playline_rowbg[$i] = "#eeeeee"; 
	
	$playline_payout[$i] = calculatePayout($playline[$i]);
	$playline_payout_display[$i] = "";
	$playline_rowbg[$i] = "#ffffff";

	if($playline_payout[$i] > 0) {
		//$playline_payout[$i] *= $bet_per_line;
		$winning_current_spin += $playline_payout[$i]; 
		$playline_payout_display[$i] = "+".$playline_payout[$i];
		$paytable_marker[] = $playline_payout[$i];
		$playline_rowbg[$i] = "#99ff99"; 
	}

	if($play_lines  == 1 && $i >= 0) {
		break;
	}
}

// adjust credit
$user_credit += $winning_current_spin;
$_SESSION["player_credit"] = $user_credit;
?>

<html>
<head>
	<title>Simple Spin</title>
</head>
<body>
	<h2>Credit: <? echo $user_credit; ?></h2>

	<form method="get" action="spin.php">
		Betting <input type="text" name="bet" value="<? echo $bet_per_line; ?>"><br>
		<button type="submit" name="spin" value="1">Play 1 Line</button>
		<button type="submit" name="spin" value="3">Play 3 Lines</button>
	</form>
	
	<h3>Spin Result</h3>
	<table cellpadding="10" cellspacing="4" border="0">
		<?
		for($i = 0; $i < 3; $i++) {
		?>
			<tr bgcolor="<? echo $playline_rowbg[$i]; ?>">
				<td><? echo getSymbol($playline[$i][0]); ?></td>
				<td><? echo getSymbol($playline[$i][1]); ?></td>
				<td><? echo getSymbol($playline[$i][2]); ?></td>
				<td><? echo $playline_payout_display[$i]; ?></td>
			</tr>
		<?
		}
		?>
	</table>

	<h3>You <? echo ($winning_current_spin >= 0 ? " won $" : "  lost $").abs($winning_current_spin); ?></h3>
</body>
</html>