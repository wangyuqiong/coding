<?
function getSymbol($num) {
	$symbol = ' '; //default no payout value
	switch($num) {
		case 0:
			$symbol = 'A';
			break;
		case 1:
			$symbol = 'B';
			break;
		case 2: 
			$symbol = 'C';
			break;
		case 3:
			$symbol = 'Z';
			break;
		case 4:
			$symbol = 'D';
			break;
		case 5:
			$symbol = 'X';
			break;
		case 6:
			$symbol = 'Y';
			break;
		default:
			echo "Error getting symbol";
			die();
	}
	
	return $symbol;
}

function calculatePayout($playline) {
	/*
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
	*/
	
	$result = 0;

	if($playline[0] == 3 && $playline[1] == 3 && $playline[2] == 3) {
		$result = 500;
	} else if($playline[0] == 6 && $playline[1] == 6 && $playline[2] == 6) {
		$result = 100;
	} else if($playline[0] == 4 && $playline[1] == 4 && $playline[2] == 4) {
		$result = 50;
	} else if($playline[0] == 2 && $playline[1] == 2 && $playline[2] == 2) {
		$result = 20;
	} else if($playline[0] == 1 && $playline[1] == 1 && $playline[2] == 1) {
		$result = 15;
	} else if($playline[0] == 0 && $playline[1] == 0 && $playline[2] == 0) {
		$result = 10;
	} else if($playline[0] == 0 && $playline[1] == 0) {
		$result = 5;
	} else if($playline[0] == 0) {
		$result = 2;
	}
	
	return $result;
}
?>